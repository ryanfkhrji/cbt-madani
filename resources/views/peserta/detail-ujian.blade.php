@extends('layouts.user')
@section('content-user')
    <div class="w-full min-h-screen px-4 my-4">
        {{-- Bagian Card --}}
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            {{-- card --}}
            <div class="w-auto shadow-sm card bg-white-custom dark:bg-dark-black-custom">
                <div class="card-body">
                    <h2
                        class="pb-4 text-2xl font-semibold border-b text-black-custom border-gray-custom dark:text-white-custom">
                        Identitas
                        Peserta</h2>
                    <table class="table mt-3 text-sm text-black-custom dark:text-white-custom">
                        <tbody>
                            <tr>
                                <td class="font-semibold">No. Ujian</td>
                                <td>:</td>
                                <td>{{ $siswa->nis }}</td>
                            </tr>
                            <tr>
                                <td class="font-semibold">Nama Peserta</td>
                                <td>:</td>
                                <td>{{ $siswa->nama }}</td>
                            </tr>

                            <tr>
                                <td class="font-semibold">Kelas</td>
                                <td>:</td>
                                <td>{{ $siswa->kelas->nama_kelas ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="font-semibold">Nama Ujian</td>
                                <td>:</td>
                                <td>{{ $jadwal->ujian?->nama_ujian ?? '-' }}</td>

                            </tr>
                            <tr>
                                <td class="font-semibold">Mata Pelajaran</td>
                                <td>:</td>
                                <td>{{ $jadwal->ujian->mapel->nama_mapel ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="font-semibold">Durasi</td>
                                <td>:</td>
                                <td>
                                    @php
                                        $durasiMenit = \Carbon\Carbon::parse($jadwal->jam_in)->diffInMinutes(
                                            \Carbon\Carbon::parse($jadwal->jam_out),
                                        );
                                    @endphp
                                    {{ $durasiMenit }} Menit
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
            {{-- card --}}
            <div class="w-auto shadow-sm card bg-white-custom dark:bg-dark-black-custom">
                <div class="card-body">
                    <h2
                        class="pb-4 text-2xl font-semibold border-b text-black-custom border-gray-custom dark:text-white-custom">
                        Deskripsi
                        Ujian</h2>
                    <div class="mt-3 text-sm text-black-custom dark:text-white-custom">{!! $jadwal->ujian->deskripsi !!}</div>

                    <div class="mt-6">
                        <a href="{{ route('mulai.ujian', [base64_encode($jadwal->ujian->id), base64_encode($jadwal->id)]) }}">
                            <button class="w-full bg-black btn text-white-custom">Kerjakan</button>
                        </a>

                    </div>
                </div>
            </div>
        </div>
        {{-- Bagian Card --}}
    </div>
@endsection
