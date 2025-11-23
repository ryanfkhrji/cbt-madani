@extends('layouts.admin')
@section('content-admin')
    <div class="min-h-screen p-4 mt-16">
        <div class="grid grid-cols-1">
            <div class="w-auto shadow-sm card bg-white-custom dark:bg-dark-black-custom">
                <div class="card-body">
                    <h3 class="mb-4 text-base font-medium lg:text-xl text-black-custom dark:text-white-custom">Data Master
                        Jurusan</h3>
                    <div class="flex flex-wrap gap-2 mb-5">
                        <a href="{{ route('master_jurusan.create') }}">
                            <button type="button" class="bg-black btn text-white-custom"><i
                                    class="fa-solid fa-plus"></i>Tambah Jurusan</button>
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
                                    <th class="px-4 py-3 text-left">Nama Jurusan</th>
                                    <th class="px-4 py-3 text-left">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-black-custom">
                                @foreach ($jurusans as $jurusan)
                                    <tr
                                        class="dark:text-white-custom">
                                        <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-2">{{ $jurusan->nama_jurusan }}</td>
                                        <td class="flex gap-2 px-4 py-2">
                                            <a href="{{ route('master_jurusan.edit', base64_encode($jurusan->id)) }}"
                                                class="border border-black text-black-custom btn btn-edit dark:text-white-custom"><i
                                                    class="fa-regular fa-pen-to-square"></i></a>
                                            <form action="{{ route('master_jurusan.destroy', $jurusan->id) }}"
                                                method="POST" class="form-hapus d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                    class="text-white bg-black btn btn-hapus"
                                                    data-id="{{ $jurusan->id }}">
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
                    {{ $jurusans->links() }}


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
                                text: "Berhasil Menghapus Jurusan",
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
