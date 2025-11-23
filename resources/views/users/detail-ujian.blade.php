@extends('layouts.user')
@section('content-user')
    <div class="w-full min-h-screen px-4 my-4">
        {{-- Bagian Card --}}
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            {{-- card --}}
            <div class="w-auto shadow-sm card bg-white-custom">
                <div class="card-body">
                    <h2 class="pb-4 text-2xl font-semibold border-b text-black-custom border-gray-custom">Identitas Peserta</h2>
                    <table class="table mt-3 text-sm text-black-custom">
                        <tbody>
                            <tr>
                                <td class="font-semibold">No. Ujian</td>
                                <td>:</td>
                                <td>123123123</td>
                            </tr>
                            <tr>
                                <td class="font-semibold">Nama Peserta</td>
                                <td>:</td>
                                <td>Budi Santoso</td>
                            </tr>
                            <tr>
                                <td class="font-semibold">Nama Sekolah</td>
                                <td>:</td>
                                <td>SMK Negri 1</td>
                            </tr>
                            <tr>
                                <td class="font-semibold">Kelas</td>
                                <td>:</td>
                                <td>X TKJ 1</td>
                            </tr>
                            <tr>
                                <td class="font-semibold">Nama Ujian</td>
                                <td>:</td>
                                <td>Bahasa Indonesia Kelas X</td>
                            </tr>
                            <tr>
                                <td class="font-semibold">Mata Pelajaran</td>
                                <td>:</td>
                                <td>Bahasa Indonesia</td>
                            </tr>
                            <tr>
                                <td class="font-semibold">Durasi</td>
                                <td>:</td>
                                <td>90 Menit</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            {{-- card --}}
            <div class="w-auto shadow-sm card bg-white-custom">
                <div class="card-body">
                    <h2 class="pb-4 text-2xl font-semibold border-b text-black-custom border-gray-custom">Deskripsi Ujian</h2>
                    <p class="mt-3 text-sm text-black-custom">Ujian Bahasa Indonesia</p>
                    <div class="mt-6">
                        <a href="/ujian">
                            <button class="w-full btn bg-blue-custom text-white-custom">Kerjakan</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        {{-- Bagian Card --}}
    </div>
@endsection