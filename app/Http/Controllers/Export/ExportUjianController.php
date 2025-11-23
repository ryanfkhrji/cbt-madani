<?php

namespace App\Http\Controllers\Export;

use App\Models\Kelas;
use App\Models\Ujian;
use App\Models\TransSoal;
use App\Exports\HasilUjian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ExportUjianController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('trans_soals')
            ->join('ujians', 'ujians.id', '=', 'trans_soals.id_ujian')
            ->join('siswas', 'siswas.id', '=', 'trans_soals.id_siswa')
            ->join('kelas', 'kelas.id', '=', 'trans_soals.id_kelas')
            ->select('trans_soals.*', 'siswas.nis', 'siswas.nisn', 'siswas.nama', 'kelas.nama_kelas', 'ujians.nama_ujian');

        if ($request->ujian_id) {
            $query->where('trans_soals.id_ujian', $request->ujian_id);
        }

        if ($request->kelas_id) {
            $query->where('trans_soals.id_kelas', $request->kelas_id);
        }

        $items = $query->paginate(50)->withQueryString();
        $ujians = Ujian::all();
        $kelas = Kelas::all();

        return view('hasil-ujian.index', compact('items', 'kelas', 'ujians'));
    }


    public function detail($id)
    {
        $items = DB::table('detail_tr_nilais')
            ->join('soals', 'soals.id', '=', 'detail_tr_nilais.id_soal')
            ->where('detail_tr_nilais.id_trans', $id)
            ->select('detail_tr_nilais.*', 'soals.soal', 'soals.pilihan_1', 'soals.pilihan_2', 'soals.pilihan_3', 'soals.pilihan_4', 'soals.pilihan_5')
            ->get();
        return view('hasil-ujian.detail',compact('items'));
    }

    public function exportExcel(Request $request)
    {
        $query = DB::table('trans_soals')
            ->join('ujians', 'ujians.id', '=','trans_soals.id_ujian')
            ->join('siswas', 'siswas.id', '=','trans_soals.id_siswa')
            ->join('kelas', 'kelas.id', '=','trans_soals.id_kelas')
            ->select('trans_soals.*','siswas.nis', 'siswas.nama', 'kelas.nama_kelas', 'ujians.nama_ujian');


            if ($request->filled('ujian_id')) {
            $query->where('trans_soals.id_ujian', $request->ujian_id);
        }

        if ($request->filled('kelas_id')) {
            $query->where('trans_soals.id_kelas', $request->kelas_id);
        }

        $items = $query->get();


        // Tambahkan penomoran "No" di collection agar kolom No terisi
        $numbered = $items->values()->map(function ($row, $idx) {
            $row->no = $idx + 1;
            return $row;
        });

        $namaKelas = Kelas::find($request->kelas_id);
        $namaUjian = Ujian::find($request->ujian_id);

        $meta = [
        'kelas'   => $namaKelas->nama_kelas,
        'ujian'   => $namaUjian->nama_ujian,
        'tanggal' => $items->first() ? date('d-m-Y', strtotime($items->first()->created_at)) : now()->format('d-m-Y'),
    ];


        $filename = 'hasil-ujian-' . $namaKelas->nama_kelas . '-' . $namaUjian->nama_ujian .  '.xlsx';

        return Excel::download(new HasilUjian($numbered, $meta), $filename);

    }

    public function ulangUjian($id)
    {
        $transSoal = TransSoal::find($id);

        if (!$transSoal) {
            return redirect()->back()->with('error', 'Data hasil ujian tidak ditemukan.');
        }
        $transSoal->delete();

        // Hapus detail nilai terkait
        DB::table('detail_tr_nilais')->where('id_trans', $transSoal->id)->delete();

        return redirect()->back()->with('success', 'Ujian berhasil diulang. Siswa dapat mengerjakan ulang ujian tersebut.');

    }
}
