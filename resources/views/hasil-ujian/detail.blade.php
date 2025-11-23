@extends('layouts.admin')
@section('content-admin')
    <div class="min-h-screen p-4 mt-16">
        <div class="grid grid-cols-1">
            <div class="w-auto shadow-sm card bg-white-custom dark:bg-dark-black-custom">
                <div class="card-body">
                    <div class="flex flex-col-reverse justify-between w-full gap-3 mb-5 md:gap-0 md:flex-row">
                        <div>
                            <a href="{{ route('hasil.ujian') }}">
                                <button type="button" class="bg-black btn text-white-custom"><i class="fa-solid fa-arrow-left"></i>Kembali</button>
                            </a>
                        </div>
                    </div>
                    {{-- <div class="flex flex-wrap items-center justify-between gap-3 md:gap-0">
                        <p class="text-sm font-medium text-black-custom dark:text-white-custom">
                            Show entries
                            <input type="number"
                                class="w-10 p-1 border rounded-sm border-gray-custom focus:outline-gray-custom dark:text-white-custom"
                                placeholder="10">
                        </p>
                        <input type="text"
                            class="block w-full px-3 py-2 text-sm border rounded-sm border-gray-custom text-black-custom md:max-w-sm focus:outline-gray-custom dark:text-white-custom"
                            placeholder="Search..." required>
                    </div> --}}
                    {{-- table --}}
                    <div class="mt-4 overflow-x-auto">
                        <table class="table table-zebra">
                            <!-- head -->
                            <thead class="bg-gray-100 text-black-custom dark:text-white-custom dark:bg-gray-900">
                                <tr>
                                    <th>No</th>
                                    <th>Soal</th>
                                    <th>Jawaban</th>
                                    <th>Keterangan</th>
                                    <th>Jawaban Benar</th>
                                </tr>
                            </thead>
                            @php
                                use Illuminate\Support\Str;
                                $no = 1;
                                $abjad = ['A', 'B', 'C', 'D', 'E'];
                            @endphp
                            <tbody>
                                @foreach ($items as $i)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        {{-- Soal: bisa teks atau gambar --}}
                                        <td>
                                            @if (Str::startsWith($i->soal, 'http') || Str::endsWith($i->soal, ['.jpg', '.jpeg', '.png', '.webp']))
                                                <img src="{{ asset('storage/' . $i->soal) }}" alt="Soal Gambar"
                                                    class="w-32 h-auto rounded shadow" />
                                            @else
                                                <p class="text-sm text-black-custom dark:text-white-custom">
                                                    {{ $i->soal }}
                                                </p>
                                            @endif
                                        </td>
                                        {{-- Pilihan dipilih: huruf + isi/gambar --}}
                                        <td>
                                            @php
                                                // Pastikan pilihan dalam range yang valid (1-5)
                                                $pilihanUser = (int) $i->pilihan;
                                                if ($pilihanUser >= 1 && $pilihanUser <= 5) {
                                                    $hurufPilihan = $abjad[$pilihanUser - 1];
                                                    $isiPilihan = $i->{'pilihan_' . $pilihanUser};
                                                } else {
                                                    $hurufPilihan = '-';
                                                    $isiPilihan = 'Tidak ada pilihan';
                                                }
                                            @endphp
                                            <span class="font-semibold">{{ $hurufPilihan }}.</span>
                                            @if (!empty($isiPilihan) && $isiPilihan !== 'Tidak ada pilihan')
                                                @if (Str::contains($isiPilihan, ['pilihan_images/', 'http']) ||
                                                        Str::endsWith($isiPilihan, ['.jpg', '.jpeg', '.png', '.webp']))
                                                    <img src="{{ asset('storage/' . $isiPilihan) }}" alt="Pilihan Gambar"
                                                        class="w-20 h-auto mt-1 rounded shadow" />
                                                @else
                                                    <span class="ml-1">{{ $isiPilihan }}</span>
                                                @endif
                                            @else
                                                <span class="ml-1 text-gray-500">-</span>
                                            @endif
                                        </td>
                                        {{-- Status jawaban --}}
                                        <td>
                                            @if ($i->pilihan == $i->jawaban_benar)
                                                <span
                                                    class="px-2 py-1 text-sm font-semibold text-green-800 bg-green-200 rounded-full">
                                                    Benar
                                                </span>
                                            @else
                                                <span
                                                    class="px-2 py-1 text-sm font-semibold text-red-800 bg-red-200 rounded-full">
                                                    Salah
                                                </span>
                                            @endif
                                        </td>
                                        {{-- Jawaban benar: huruf + isi/gambar --}}
                                        <td>
                                            @php
                                                // Pastikan jawaban_benar dalam range yang valid (1-5)
                                                $jawabanBenar = (int) $i->jawaban_benar;
                                                if ($jawabanBenar >= 1 && $jawabanBenar <= 5) {
                                                    $hurufBenar = $abjad[$jawabanBenar - 1];
                                                    $isiBenar = $i->{'pilihan_' . $jawabanBenar};
                                                } else {
                                                    $hurufBenar = '-';
                                                    $isiBenar = 'Jawaban tidak valid';
                                                }
                                            @endphp

                                            <span class="font-semibold">{{ $hurufBenar }}.</span>

                                            @if (!empty($isiBenar) && $isiBenar !== 'Jawaban tidak valid')
                                                @if (Str::contains($isiBenar, ['pilihan_images/', 'http']) ||
                                                        Str::endsWith($isiBenar, ['.jpg', '.jpeg', '.png', '.webp']))
                                                    <img src="{{ asset('storage/' . $isiBenar) }}"
                                                        alt="Jawaban Benar Gambar"
                                                        class="w-20 h-auto mt-1 rounded shadow" />
                                                @else
                                                    <span class="ml-1">{{ $isiBenar }}</span>
                                                @endif
                                            @else
                                                <span class="ml-1 text-gray-500">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{-- table --}}
                    {{-- pagination --}}
                    <div class="mt-4">
                        <div class="flex flex-wrap items-center justify-between gap-3 md:gap-0">
                            <p class="text-sm font-medium text-black-custom dark:text-white-custom">Showing
                                <span class="text-sm font-semibold">10</span> entries
                            </p>
                            <div class="join">
                                <button class="join-item btn">«</button>
                                <button class="join-item btn">Page 1</button>
                                <button class="join-item btn">»</button>
                            </div>
                        </div>
                    </div>
                    {{-- pagination --}}
                </div>
            </div>
        </div>
    </div>

    {{-- sweetalert --}}
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.querySelectorAll('.btn-hapus').forEach(button => {
                button.addEventListener('click', () => {
                    Swal.fire({
                        title: 'Apakah kamu yakin?',
                        text: "Data akan dihapus!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#000',
                        cancelButtonColor: '#5C5470',
                        confirmButtonText: 'Ya, Hapus!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Ganti dengan aksi penghapusan sesuai kebutuhan
                            console.log('Data dihapus!');
                        }
                    });
                });
            });

            document.querySelectorAll('.btn-edit').forEach(button => {
                button.addEventListener('click', () => {
                    // Ganti dengan redirect dinamis jika perlu
                    window.location.href = '/edit-data-soal';
                });
            });
        </script>
        {{-- sweetalert --}}
    @endpush
@endsection
