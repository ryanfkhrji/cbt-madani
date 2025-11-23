<?php

namespace App\Imports;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportSiswa implements ToModel, WithHeadingRow
{
    /**
     * @param  array  $row  // heading row: 'nama', 'jenis_kelamin', 'nis', 'nisn', 'tanggal_lahir', 'kelas'
     */
    public function model(array $row)
    {
        if (
            empty($row['nama']) ||
            empty($row['jenis_kelamin']) ||
            empty($row['nis']) ||
            empty($row['nisn']) ||
            empty($row['tanggal_lahir']) ||
            empty($row['kelas'])
        ) {
            return null;
        }

        // cari kelas
        $kelas = DB::table('kelas')
            ->where('nama_kelas', $row['kelas'])
            ->first();
        if (! $kelas) {
            Log::warning("Kelas tidak ditemukan: {$row['kelas']}");
            return null;
        }
         // generate password acak 8 karakter
        $plainPassword = Str::random(8);

        // buat Siswa
        $siswa = Siswa::create([
            'nama'    => $row['nama'],
            'jenis_kelamin' => $row['jenis_kelamin'],
            'nis'           => $row['nis'],
            'nisn'          => $row['nisn'],
            'tanggal_lahir' => \Carbon\Carbon::createFromFormat('d-m-Y', $row['tanggal_lahir']),
            'id_kelas'      => $kelas->id,
            'password' => $plainPassword
        ]);



        // buat User
        User::create([
            'name'     => $siswa->nama,
            'username' => $siswa->nis,
            'password' => Hash::make($plainPassword),
            'role'   => 2,
            'image' => 'pria.jpg'
        ]);

        // (opsional) jika mau log atau kirim notifikasi password ke siswa
        Log::info("User dibuat untuk Siswa ID {$siswa->id}: username={$siswa->nis}, password={$plainPassword}");

        return null; // Karena kita sudah menyimpan via create(), tidak perlu return model
    }
}
