@extends('layouts.admin')
@section('content-admin')
    <div class="min-h-screen p-4 mt-16">
        <div class="grid grid-cols-1">
            <div class="w-auto shadow-sm card bg-white-custom dark:bg-dark-black-custom">
                <div class="card-body">
                    <h3 class="mb-4 text-base font-medium lg:text-xl text-black-custom dark:text-white-custom">Data Master
                        Jadwal</h3>
                    <div class="flex flex-wrap gap-2 mb-5">
                        <a href="{{ route('master_jadwal.create') }}">
                            <button type="button" class="bg-black btn text-white-custom"><i
                                    class="fa-solid fa-plus"></i>Tambah Jadwal</button>
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
                            <thead class="bg-gray-100 text-black-custom dark:text-white-custom dark:bg-gray-900">
                                <tr>
                                    <th class="px-4 py-3 text-left">No</th>
                                    <th class="px-4 py-3 text-left">Nama Jadwal</th>
                                    <th class="px-4 py-3 text-left">Nama Ujian</th>
                                    <th class="px-4 py-3 text-left">Hari Jadwal</th>
                                    <th class="px-4 py-3 text-left">Tanggal</th>
                                    <th class="px-4 py-3 text-left">Jam In</th>
                                    <th class="px-4 py-3 text-left">Jam Out</th>
                                    <th class="px-4 py-3 text-left">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-black-custom dark:text-white-custom">
                                @foreach ($jadwal as $data)
                                    <tr class="transition-colors">
                                        <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-2">{{ $data->nama_jadwal }}</td>
                                        <td class="px-4 py-2">{{ $data->ujian?->nama_ujian ?? '-' }}</td>
                                        <td class="px-4 py-2">{{ $data->hari }}</td>
                                        <td class="px-4 py-2">{{ $data->tanggal }}</td>
                                        <td class="px-4 py-2">{{ $data->jam_in }}</td>
                                        <td class="px-4 py-2">{{ $data->jam_out }}</td>
                                        <td class="flex gap-2 px-4 py-2">
                                            <a href="{{ route('master_jadwal.edit', base64_encode($data->id)) }}"
                                                class="border border-black btn btn-edit text-black-custo dark:text-white-custom"><i
                                                    class="fa-regular fa-pen-to-square"></i></a>
                                            <form action="{{ route('master_jadwal.destroy', $data->id) }}" method="POST"
                                                class="form-hapus d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                    class="text-white transition bg-black btn btn-hapus"
                                                    data-id="{{ $data->id }}">
                                                    <i class="mr-1 fa-regular fa-trash-can"></i>
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
                    {{ $jadwal->links() }}
                    {{-- pagination --}}
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        {{-- sweetalert --}}
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                            Swal.fire({
                                title: "Berhasil!",
                                text: "Berhasil Menghapus Jadwal",
                                icon: "success",
                                confirmButtonColor: '#000'
                            })
                        }
                    });
                });
            });
        </script>
        {{-- sweetalert --}}
    @endpush
@endsection
