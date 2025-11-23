<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UjianController extends Controller
{
   public function selesaikanUjian(Request $request)
{
    // Debug: Log semua data request
    \Log::info('Request selesai ujian:', $request->all());

    // Cek apakah data dikirim langsung atau nested
    $data = $request->has('data') ? $request->input('data') : $request->all();

    // Debug: Log data yang akan diproses
    \Log::info('Data yang diproses:', $data);

    $username = Auth::user()->username;

    // Cari siswa berdasarkan username = nis
    $siswa = Siswa::where('nis', $username)->first();

    if (!$siswa) {
        return response()->json([
            'success' => false,
            'message' => 'Data siswa tidak ditemukan dari username.'
        ], 404);
    }

    $id_kelas = $siswa->id_kelas;

    // Validasi data yang diperlukan
    $requiredFields = ['id_ujian', 'id_siswa', 'jum_soal', 'benar', 'salah', 'score', 'detail'];
    foreach ($requiredFields as $field) {
        if (!isset($data[$field])) {
            return response()->json([
                'success' => false,
                'message' => "Field {$field} tidak ditemukan"
            ], 400);
        }
    }

    // Parse detail jika berupa string JSON
    $detail = is_string($data['detail']) ? json_decode($data['detail'], true) : $data['detail'];

    if (!$detail || !is_array($detail)) {
        return response()->json([
            'success' => false,
            'message' => 'Detail jawaban tidak valid'
        ], 400);
    }

    DB::beginTransaction();
    try {
        // Simpan ke trans_soals
        $trans = DB::table('trans_soals')->insertGetId([
            'id_ujian' => $data['id_ujian'],
            'id_siswa' => $siswa->id,
            'id_kelas' => $id_kelas,
            'jum_soal' => $data['jum_soal'],
            'benar' => $data['benar'],
            'salah' => $data['salah'],
            'score' => $data['score'],
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Simpan ke detail_tr_nilais
        foreach ($detail as $d) {
            DB::table('detail_tr_nilais')->insert([
                'id_trans' => $trans,
                'id_soal' => $d['id_soal'],
                'pilihan' => $d['pilihan'],
                'jawaban_benar' => $d['jawaban_benar'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        DB::commit();

        \Log::info('Ujian berhasil disimpan:', ['trans_id' => $trans]);

        return response()->json([
            'success' => true,
            'message' => 'Ujian berhasil diselesaikan',
            'trans_id' => $trans
        ]);

    } catch (\Exception $e) {
        DB::rollBack();

        \Log::error('Error selesai ujian:', [
            'error' => $e->getMessage(),
            'line' => $e->getLine(),
            'file' => $e->getFile()
        ]);

        return response()->json([
            'success' => false,
            'error' => $e->getMessage()
        ], 500);
    }
}


}
