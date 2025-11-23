@extends('layouts.user')
@section('content-user')
    <div class="w-full min-h-screen px-4 my-4">
        {{-- Bagian Card --}}
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
            {{-- card --}}
            <div class="w-auto shadow-sm card bg-white-custom">
                <div class="card-body">
                    <h2 class="text-2xl font-semibold text-black-custom">Bahasa Indonesia Kelas X</h2>
                    <table class="mt-3 text-sm text-black-custom">
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
                        <a href="/detail-ujian">
                            <button class="w-full btn bg-blue-custom text-white-custom">Kerjakan</button>
                        </a>
                    </div>
                </div>
            </div>
            {{-- card --}}
            <div class="w-auto shadow-sm card bg-white-custom">
                <div class="card-body">
                    <h2 class="text-2xl font-semibold text-black-custom">Bahasa Indonesia Kelas X</h2>
                    <table class="mt-3 text-sm text-black-custom">
                        <tbody>
                            <tr>
                                <td>Mapel</td>
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
                        <a href="/detail-ujian">
                            <button class="w-full btn bg-blue-custom text-white-custom">Kerjakan</button>
                        </a>
                    </div>
                </div>
            </div>
            {{-- card --}}
            <div class="w-auto shadow-sm card bg-white-custom">
                <div class="card-body">
                    <h2 class="text-2xl font-semibold text-black-custom">Bahasa Indonesia Kelas X</h2>
                    <table class="mt-3 text-sm text-black-custom">
                        <tbody>
                            <tr>
                                <td>Mapel</td>
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
                        <a href="/detail-ujian">
                            <button class="w-full bg-black btn text-white-custom">Kerjakan</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        {{-- Bagian Card --}}
    </div>
@endsection
