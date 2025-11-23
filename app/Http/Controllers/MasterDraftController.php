<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Ujian;
use App\Models\DraftSoal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasterDraftController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request)
{
    // dropdown filter ujian (opsional)
    $ujian = Ujian::select('id','nama_ujian')->orderBy('nama_ujian')->get();

    // query ringkasan per KELAS
    $query = Kelas::query()
        // hitung total draft per kelas (menghormati filter ujian jika ada)
        ->select('kelas.id as id_kelas','kelas.nama_kelas')
        ->withCount([
            'draftSoals as total_draft' => function ($q) use ($request) {
                if ($request->filled('ujian_id')) {
                    $q->where('id_ujian', $request->ujian_id);
                }
            },
        ])
        // pilih kolom tambahan: daftar nama ujian per kelas (GROUP_CONCAT DISTINCT)
        ->addSelect([
            'nama_ujian' => DraftSoal::query()
                ->from('draft_soals as d')
                ->join('ujians as u', 'u.id', '=', 'd.id_ujian')
                ->selectRaw('GROUP_CONCAT(DISTINCT u.nama_ujian ORDER BY u.nama_ujian SEPARATOR ", ")')
                ->when($request->filled('ujian_id'), fn($q) => $q->where('d.id_ujian', $request->ujian_id))
                ->whereColumn('d.id_kelas', 'kelas.id')
        ])
        // hanya kelas yang punya draft (sesuai filter)
        ->when(
            $request->filled('ujian_id'),
            fn ($q) => $q->whereHas('draftSoals', fn ($d) => $d->where('id_ujian', $request->ujian_id)),
            fn ($q) => $q->whereHas('draftSoals')
        )
        ->orderBy('nama_kelas');

    $kelas = $query->paginate(10)->withQueryString();

    return view('draft.index', compact('kelas', 'ujian'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $ujian = Ujian::all();
        $kelas = Kelas::all();

        return view('draft.create', compact('ujian', 'kelas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_ujian' => 'required|exists:ujians,id',
            'id_siswa' => 'required|array',
            'id_siswa.*' => 'exists:siswas,id',
            'id_kelas' => 'required|exists:kelas,id'
        ]);

        $draftSoal = [];
        foreach ($request->id_siswa as $siswaId) {
            $draftSoal[] = [
                'id_ujian' => $request->id_ujian,
                'id_kelas' => $request->id_kelas,
                'id_siswa' => $siswaId,
                'created_at' => now(), // jika pakai timestamps
                'updated_at' => now()
            ];
        }

        DraftSoal::insert($draftSoal);

        return redirect()->back()->with('message', 'Data berhasil disimpan');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $idBase = base64_decode($id);
        $items = DraftSoal::where('id_kelas',$idBase)
                ->with('Kelas','Ujian','Siswa')
                ->paginate(10);
        return view('draft.show',compact('items'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $draft = DraftSoal::findOrFail(base64_decode($id));
        $ujian = Ujian::all();
        $kelas = Kelas::all();

        // Hanya ambil siswa berdasarkan kelas di draft
        $siswa = Siswa::where('id_kelas', $draft->id_kelas)->get();

        return view('draft.edit', compact('draft', 'ujian', 'kelas', 'siswa'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $draft = DraftSoal::findOrFail($id);

        $request->validate([
            'id_ujian' => 'required|exists:ujians,id',
            'id_siswa' => 'required|array',
            'id_siswa.*' => 'exists:siswas,id',
            'id_kelas' => 'required|exists:kelas,id'
        ]);

        $draftSoal = [];
        foreach ($request->id_siswa as $siswaId) {
            $draftSoal[] = [
                'id_ujian' => $request->id_ujian,
                'id_kelas' => $request->id_kelas,
                'id_siswa' => $siswaId,
                'created_at' => now(), // jika pakai timestamps
                'updated_at' => now()
            ];
        }

        $draft->update($draftSoal);
        return redirect()->route('master_draft.index')->with('success', 'Data Draft Berhasil di ubah');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DraftSoal::where('id_kelas', $id)->delete();

        return redirect()->back()->with('message', 'Data berhasil dihapus');
    }

    public function destroyDraft($id){
         DraftSoal::where('id', $id)->delete();

        return redirect()->back()->with('message', 'Data berhasil dihapus');
    }

    public function getByKelas(Request $request)
    {
        $kelasId = $request->kelas_id;
        $query = $request->q;

        $siswa = Siswa::where('id_kelas', $kelasId)
            ->where('nama', 'like', '%' . $query . '%')
            ->select('id', 'nama')
            ->get();

        return response()->json($siswa);
    }
}
