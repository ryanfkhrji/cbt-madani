@extends('layouts.admin')
@section('content-admin')
    <div class="min-h-screen p-4 mt-16">
        <div class="grid grid-cols-1">
            <div class="w-auto shadow-sm card bg-white-custom dark:bg-dark-black-custom">
                <div class="card-body">

                    <form method="GET" action="{{ route('master_siswa.index') }}" id="filterForm">
                        <select
                            class="w-full border select border-gray-custom md:w-xs dark:text-white-custom dark:bg-dark-black-custom"
                            name="kelas_id" onchange="document.getElementById('filterForm').submit();">
                            <option value="">Pilih Kelas</option>
                            @foreach ($kelas as $item)
                                <option value="{{ $item->id }}"
                                    {{ request('kelas_id') == $item->id ? 'selected' : '' }}>
                                    {{ $item->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>
                <div class="card-body">
                    <h3 class="mb-4 text-base font-medium lg:text-xl text-black-custom dark:text-white-custom">Data Master
                        Siswa</h3>
                    <div class="flex flex-wrap gap-2 mb-5">
                        <a href="{{ route('master_siswa.create') }}">
                            <button type="button" class="bg-black btn text-white-custom"><i
                                    class="fa-solid fa-plus"></i>Tambah Siswa</button>
                        </a>
                        <a href="{{ route('siswa.template') }}">
                            <button type="button" class="border border-black btn text-black-custom dark:text-white-custom"><i
                                    class="fa-solid fa-file-import"></i>Template Siswa</button>
                        </a>
                        <a href="/import-siswa">
                            <button type="button" class="border border-black btn text-black-custom dark:text-white-custom"><i
                                    class="fa-solid fa-file-import"></i>Import Siswa</button>
                        </a>

                        {{-- cetak kartu --}}
                        <a href="{{ route('siswa.cetak-kartu', ['kelas_id' => request('kelas_id')]) }}" target="_blank"
                            class="border border-black btn text-black-custom dark:text-white-custom"><i class="fa-solid fa-print"></i> Cetak Kartu
                            Ujian
                        </a>
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
                        <table class="table w-full table-zebra">
                            <!-- head -->
                            <thead class="bg-gray-100 text-black-custom dark:bg-gray-900 dark:text-white-custom">
                                <tr>
                                    <th class="px-4 py-3 text-left">No</th>
                                    <th class="px-4 py-3 text-left">NIS</th>
                                    <th class="px-4 py-3 text-left">NISN</th>
                                    <th class="px-4 py-3 text-left">Nama Siswa</th>
                                    <th class="px-4 py-3 text-left">Jenis Kelamin</th>
                                    <th class="px-4 py-3 text-left">Jurusan</th>
                                    <th class="px-4 py-3 text-left">Kelas</th>
                                    <th class="px-4 py-3 text-left">Aksi</th>


                                </tr>
                            </thead>
                            <tbody class="text-black-custom">
                                @foreach ($siswas as $data)
                                    <tr
                                        class="transition-colors duration-200 dark:text-white-custom">
                                        <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-2">{{ $data->nis }}</td>
                                        <td class="px-4 py-2">{{ $data->nisn }}</td>
                                        <td class="px-4 py-2">{{ $data->nama }}</td>
                                        <td class="px-4 py-2">{{ $data->jenis_kelamin }}</td>
                                        <td class="px-4 py-2">{{ optional($data->kelas->jurusan)->nama_jurusan ?? '-' }}
                                        </td>
                                        <td class="px-4 py-2">{{ optional($data->kelas)->nama_kelas ?? '-' }}</td>
                                        <td class="flex gap-2 px-4 py-2">
                                            <a href="{{ route('master_siswa.edit', base64_encode($data->id)) }}"
                                                class="border border-black btn btn-edit text-black-custom dark:text-white-custom"><i
                                                    class="fa-regular fa-pen-to-square"></i></a>
                                            <form action="{{ route('master_siswa.destroy', $data->id) }}" method="POST"
                                                class="form-hapus d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                    class="text-white transition bg-black btn btn-hapus"
                                                    data-id="{{ $data->id }}">
                                                    <i class="fa-regular fa-trash-can"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                    {{-- table --}}
                    {{-- pagination --}}
                    {{ $siswas->links() }}
                    {{-- pagination --}}
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        {{-- sweetalert --}}
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        @if (session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#000'
                });
            </script>
        @endif

        <script>
            document.querySelectorAll('.btn-hapus').forEach(button => {
                button.addEventListener('click', function() {
                    Swal.fire({
                        title: 'Apakah kamu yakin?',
                        text: "Data akan dihapus secara permanen!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#000',
                        cancelButtonColor: '#5C5470',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Temukan form terdekat dari tombol yang ditekan
                            this.closest('form').submit();
                        }
                    });
                });
            });
        </script>
        {{-- sweetalert --}}
    @endpush
@endsection
