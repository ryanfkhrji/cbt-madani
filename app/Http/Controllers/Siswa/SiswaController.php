<?php

namespace App\Http\Controllers\Siswa;

use Carbon\Carbon;

use App\Models\Soal;
use App\Models\Siswa;
use App\Models\Ujian;
use App\Models\Jadwal;
use App\Http\Controllers\Controller;
use PhpParser\Node\Expr\Cast\String_;
use Illuminate\Support\Facades\Cache;

class SiswaController extends Controller
{
    public function index()
    {
        // Ambil data siswa dari user yang login
        $siswa = Siswa::where('nis', auth()->user()->username)->first();

        if (!$siswa) {
            abort(404, 'Siswa tidak ditemukan');
        }

        // Ambil semua id_ujian dari draft soal yang sesuai dengan kelas siswa
        $ujianIds = \App\Models\DraftSoal::where('id_kelas', $siswa->id_kelas)
            ->pluck('id_ujian')
            ->unique();

        // Set timezone ke Asia/Jakarta
        $tanggalHariIni = Carbon::now('Asia/Jakarta')->toDateString();
        $jamSekarang = Carbon::now('Asia/Jakarta')->format('H:i:s');

        // Ambil jadwal hari ini dan sesuai waktu ujian
        $jadwalUjian = \App\Models\Jadwal::whereIn('id_ujian', $ujianIds)
            ->where('tanggal', $tanggalHariIni)
            ->with('ujian.mapel') // eager load mapel jika dibutuhkan di view
            ->get();

        return view('peserta.index', [
            'siswa' => $siswa,
            'jadwalUjian' => $jadwalUjian,
        ]);
    }

    public function detail(string $id)
    {
        $id = base64_decode($id);
        $jadwal = Jadwal::with('ujian.mapel')->find($id);

        $siswa = Siswa::where('nis', auth()->user()->username)
            ->with('kelas')
            ->firstOrFail();

        return view('peserta.detail-ujian', compact('siswa', 'jadwal'));
    }
   public function mulaiUjian(string $id, string $idJadwal)
    {
        $id = base64_decode($id);
        $idJadwal = base64_decode($idJadwal);

        $ujian = Ujian::with('jadwal')->findOrFail($id);
        $siswa = Siswa::where('nis', auth()->user()->username)->firstOrFail();
        $jadwal = Jadwal::findOrFail($idJadwal);

        // Cache kunci urutan soal per (ujian, jadwal, siswa)
        $orderCacheKey = "soal:order:ujian:{$ujian->id}:jadwal:{$jadwal->id}:siswa:{$siswa->id}";

        // TTL cache hingga jam_selesai (fallback 2 jam)
        $ttlSeconds = 2 * 60 * 60;
        try {
            if (!empty($jadwal->tanggal) && !empty($jadwal->jam_out)) {
                $end = Carbon::createFromFormat('Y-m-d H:i:s', $jadwal->tanggal.' '.$jadwal->jam_out, 'Asia/Jakarta');
                $now = Carbon::now('Asia/Jakarta');
                $diff = $end->diffInSeconds($now, false);
                if ($diff > 0) {
                    $ttlSeconds = $diff;
                }
            }
        } catch (\Throwable $e) {
            // abaikan dan gunakan default
        }

        $orderedIds = Cache::remember($orderCacheKey, $ttlSeconds, function () use ($ujian) {
            $ids = Soal::where('id_ujian', $ujian->id)->pluck('id')->all();
            if ($ujian->soal_acak == 1) {
                shuffle($ids); // acak sekali per siswa
            } else {
                sort($ids);
            }
            return $ids;
        });

        // Ambil soal sesuai urutan yang sudah dicache
        $soals = Soal::with(['ujian', 'ujian.jadwal'])
            ->whereIn('id', $orderedIds)
            ->get();
        $position = array_flip($orderedIds);
        $soals = $soals->sortBy(function ($s) use ($position) {
            return $position[$s->id] ?? PHP_INT_MAX;
        })->values();

        return view('peserta.ujian', [
            'soals' => $soals,
            'tanggal_ujian' => $jadwal->tanggal,
            'jam_mulai' => $jadwal->jam_in,
            'jam_selesai' => $jadwal->jam_out,
            'id_ujian' => $id
        ]);
    }



    public function getSoal($id, $page)
    {
        $soal = Soal::with(['ujian', 'ujian.jadwal'])
            ->where('id_ujian', base64_decode($id))
            ->paginate(1, ['*'], 'page', $page)
            ->first();

        return response()->json([
            'soal' => $soal,
            'current_page' => $page,
            'total' => Soal::where('id_ujian', base64_decode($id))->count(),
            'tanggal_ujian' => $soal->ujian->jadwal->tanggal,
            'jam_mulai' => $soal->ujian->jadwal->jam_in,
            'jam_selesai' => $soal->ujian->jadwal->jam_out
        ]);
    }
}
