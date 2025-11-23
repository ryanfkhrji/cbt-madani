@extends('layouts.user')
@section('content-user')
    <div class="w-full min-h-screen px-4 my-4">
        {{-- Bagian Card --}}
        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            {{-- card --}}
            <div class="w-auto shadow-sm card bg-white-custom">
                <div class="card-body">
                    <h2 class="text-2xl font-semibold text-black-custom dark:text-white-custom">Bahasa Indonesia Kelas X</h2>
                    <table class="mt-3 text-sm text-black-custom dark:text-white-custom">
                        <tbody>
                            <tr>
                                <td>Mata Pelajaran</td>
                                <td>:</td>
                                <td>Bahasa Indonesia</td>
                            </tr>
                            <tr>
                                <td>Sesi</td>
                                <td>:</td>
                                <td>Sesi 1</td>
                            </tr>
                            <tr>
                                <td>Mulai</td>
                                <td>:</td>
                                <td>01-01-2023 09:00:00</td>
                            </tr>
                            <tr>
                                <td>Selesai</td>
                                <td>:</td>
                                <td>01-01-2023 12:00:00</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="mt-6">
                        <button class="w-full p-3 rounded-sm cursor-not-allowed bg-red-custom text-white-custom opacity-60" @disabled(true)>Sudah Mengeerjakan</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- Bagian Card --}}
    </div>
@endsection
