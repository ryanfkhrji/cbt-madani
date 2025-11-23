@extends('layouts.admin')
@section('content-admin')
    <div class="min-h-screen p-4 mt-16">
        <div class="grid grid-cols-1">
            <div class="w-auto shadow-sm card bg-white-custom dark:bg-dark-black-custom">
                <div class="card-body">
                    <h3 class="mb-4 text-base font-medium lg:text-xl text-black-custom dark:text-white-custom">
                        Hasil Ujian</h3>
                    <div class="flex flex-wrap items-center justify-between gap-3 mb-6 md:gap-0">
                        <form action="{{ route('hasil.ujian') }}" method="GET" class="flex flex-col gap-2 md:flex-row">
                            <select name="ujian_id"
                                class="w-full border select border-gray-custom md:w-xs dark:text-white-custom dark:bg-dark-black-custom">
                                <option disabled selected>Pilih Ujian</option>
                                @foreach ($ujians as $ujian)
                                    <option value="{{ $ujian->id }}"
                                        {{ request('ujian_id') == $ujian->id ? 'selected' : '' }}>
                                        {{ $ujian->nama_ujian }}
                                    </option>
                                @endforeach
                            </select>
                            <select name="kelas_id"
                                class="w-full border select border-gray-custom md:w-xs dark:text-white-custom dark:bg-dark-black-custom">
                                <option disabled selected>Pilih Kelas</option>
                                @foreach ($kelas as $kls)
                                    <option value="{{ $kls->id }}"
                                        {{ request('kelas_id') == $kls->id ? 'selected' : '' }}>
                                        {{ $kls->nama_kelas }}
                                    </option>
                                @endforeach
                            </select>
                            <button class="bg-black btn text-white-custom" type="submit">Cari</button>
                        </form>
                        {{-- button akan muncul klo di select ujiannya --}}
                        @if (request('ujian_id'))
                            <a href="{{ route('export.ujian', request()->query()) }}">
                                <button class="border border-black btn text-black-custom dark:text-white-custom" type="button">
                                    <i class="fa-solid fa-file-excel"></i> Export to Excel
                                </button>
                            </a>
                        @endif
                        {{-- button akan muncul klo di select ujiannya --}}
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
                                    <th>NIS</th>
                                    <th>Nama Siswa</th>
                                    <th>Kelas</th>
                                    <th>Ujian</th>
                                    <th>Jumlah Soal</th>
                                    <th>Jumlah Benar</th>
                                    <th>Jumlah Salah</th>
                                    <th>Nilai</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- row 1 -->
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($items as $item)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $item->nis }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->nama_kelas }}</td>
                                        <td>{{ $item->nama_ujian }}</td>
                                        <td>{{ $item->jum_soal }}</td>
                                        <td>{{ $item->benar }}</td>
                                        <td>{{ $item->salah }}</td>
                                        <td>{{ $item->score }}</td>
                                        <td class="flex gap-2">
                                            <a href="{{ route('detail.hasil.ujian', $item->id) }}">
                                                <button type="button" class="bg-black btn text-white-custom"><i
                                                        class="fa-regular fa-eye"></i>
                                                </button>
                                            </a>
                                            <button data-id={{ $item->id }} id="Exist"
                                                class="border border-black btn text-black-custom dark:text-white-custom">
                                                <i class="fa-solid fa-rotate-right"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{-- table --}}
                    {{-- pagination --}}
                    {{ $items->links() }}
                    {{-- pagination --}}
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.querySelectorAll('#Exist').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                let idHasil = this.getAttribute('data-id');
                // Tampilkan SweetAlert konfirmasi

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Dengan menekan Ya, ujian akan diulang!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#000',
                    cancelButtonColor: '#5C5470',
                    confirmButtonText: 'Ya, ulang ujian',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Arahkan ke route ulang ujian (sesuaikan route)
                        window.location.href = "ulang-ujian/" + idHasil;

                        // Setelah redirect selesai, kalau pakai AJAX bisa kasih alert sukses
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Ujian berhasil diulang.',
                            icon: 'success',
                            confirmButtonColor: '#000'
                        });
                    }
                });
            });
        });
    </script>
@endpush
