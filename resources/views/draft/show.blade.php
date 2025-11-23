@extends('layouts.admin')
@section('content-admin')
    <div class="min-h-screen p-4 mt-16">
        <div class="grid grid-cols-1">
            <div class="w-auto shadow-sm card bg-white-custom dark:bg-dark-black-custom">
                <div class="card-body">
                    <h3 class="mb-4 text-base font-medium lg:text-xl text-black-custom dark:text-white-custom">Data Sesi
                        Ujian</h3>
                    <div class="flex flex-col w-full gap-3 mb-5 md:gap-3 md:flex-row">

                        <a href="{{ route('master_draft.create') }}">
                            <button type="button" class="w-full bg-black btn text-white-custom"><i
                                    class="fa-solid fa-plus"></i>Tambah Sesi Ujian</button>
                        </a>

                        <a href="{{ route('master_draft.index') }}">
                            <button type="button" class="w-full border border-black btn text-black-custom dark:text-white-custom">Kembali</button>
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
                        <table class="table table-zebra">
                            <!-- head -->
                            <thead class="bg-gray-100 text-black-custom dark:text-white-custom dark:bg-gray-900">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Ujian</th>
                                    <th>Nama Kelas</th>
                                    <th>Nama Siswa</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="text-black-custom dark:text-white-custom">
                                <!-- row 1 -->
                                @foreach ($items as $index => $item)
                                    <tr>
                                        <th>{{ $loop->iteration + ($items->currentPage() - 1) * $items->perPage() }}</th>
                                        <td>{{ $item->ujian->nama_ujian ?? '-' }}</td>
                                        <td>{{ $item->kelas->nama_kelas ?? '-' }}</td>
                                        <td>{{ $item->siswa->nama ?? '-' }}</td>

                                        <td class="flex gap-2">
                                            <a href="{{ route('master_draft.edit', base64_encode($item->id)) }}"
                                                class="border border-black btn btn-edit text-black-custom dark:text-white-custom"><i
                                                    class="fa-regular fa-pen-to-square"></i></a>
                                            <form action="{{ route('master_draft.destroyDraft', $item->id) }}"
                                                method="POST" class="form-hapus d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                    class="text-white transition bg-black btn btn-hapus"
                                                    data-id="{{ $item->id }}">
                                                    <i class="fa-regular fa-trash-can"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                <!-- row 2 -->
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

    @push('scripts')
        {{-- sweetalert --}}
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.querySelectorAll('.btn-hapus').forEach(button => {
                button.addEventListener('click', () => {
                    Swal.fire({
                        title: 'Apakah kamu yakin?',
                        text: "Data akan dihapus!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#1463ff',
                        cancelButtonColor: '#ff3b30',
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
                    window.location.href = '/edit-sesi';
                });
            });
        </script>
        {{-- sweetalert --}}
        <script>
            document.querySelectorAll('.btn-hapus').forEach(button => {
                button.addEventListener('click', function() {
                    Swal.fire({
                        title: 'Apakah kamu yakin?',
                        text: "Data akan dihapus secara permanen!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#1463ff',
                        cancelButtonColor: '#ff3b30',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Temukan form terdekat dari tombol yang ditekan
                            this.closest('form').submit();
                            Swal.fire({
                                title: "Berhasil!",
                                text: "Berhasil Menghapus Sesi",
                                icon: "success"
                            })
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
