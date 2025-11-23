@extends('layouts.user')
@section('content-user')
    <div class="w-full min-h-screen px-4 my-4">
        {{-- Bagian Card --}}
        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            {{-- card --}}
            <div class="w-auto shadow-sm card bg-white-custom dark:bg-dark-black-custom">
                @foreach ($jadwalUjian as $jadwal)
                    <div class="mb-6 card-body">
                        <h2 class="text-2xl font-semibold text-black-custom dark:text-white-custom">
                            {{ $jadwal->ujian->mapel->nama_mapel ?? 'Mata Pelajaran' }} Kelas
                            {{ $siswa->kelas->nama_kelas ?? '-' }}
                        </h2>
                        <table class="mt-3 text-sm text-black-custom dark:text-white-custom dark:bg-dark-black-custom">
                            <tbody
                                class="text-black-custom dark:text-white-custom dark:hover:bg-gray-500 hover:bg-light-blue-custom">
                                <tr>
                                    <td>Mata Pelajaran</td>
                                    <td>:</td>
                                    <td>{{ $jadwal->ujian->mapel->nama_mapel ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td>Jadwal</td>
                                    <td>:</td>
                                    <td>{{ $jadwal->nama_jadwal }}</td>
                                </tr>
                                <tr>
                                    <td>Mulai</td>
                                    <td>:</td>
                                    <td>{{ \Carbon\Carbon::parse($jadwal->tanggal . ' ' . $jadwal->jam_in)->format('d-m-Y H:i:s') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Selesai</td>
                                    <td>:</td>
                                    <td>{{ \Carbon\Carbon::parse($jadwal->tanggal . ' ' . $jadwal->jam_out)->format('d-m-Y H:i:s') }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        @php
                            $now = now();
                            $nis = Auth::user()->username;
                            $idSiswa = \App\Models\Siswa::where('nis', $nis)->value('id');

                            $sudahKerjakan = \App\Models\TransSoal::where('id_ujian', $jadwal->ujian->id)
                                ->where('id_siswa', $idSiswa)
                                ->exists();
                        @endphp

                        <div class="mt-6">
                            @if ($sudahKerjakan)
                                <button class="w-full text-white bg-green-600 cursor-not-allowed btn" disabled>
                                    Sudah Dikerjakan
                                </button>
                            @elseif ($now->lt($jadwal->jam_in))
                                <button class="w-full text-white bg-gray-400 cursor-not-allowed btn" disabled>
                                    Ujian Belum Dimulai
                                </button>
                            @elseif ($now->gt($jadwal->jam_out))
                                <button class="w-full text-white bg-red-500 cursor-not-allowed btn" disabled>
                                    Ujian Sudah Selesai
                                </button>
                            @else
                                <a href="{{ route('detail.ujian', base64_encode($jadwal->id)) }}">
                                    <button class="w-full bg-black btn text-white-custom">
                                        Kerjakan
                                    </button>
                                </a>
                            @endif
                        </div>

                    </div>
                @endforeach

            </div>


        </div>
        {{-- Bagian Card --}}
    </div>
@endsection
