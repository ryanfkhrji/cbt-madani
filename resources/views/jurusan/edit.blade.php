@extends('layouts.admin')
@section('content-admin')
    <div class="min-h-screen p-4 mt-16">
        <div class="grid grid-cols-1">
            <div class="w-auto shadow-sm card bg-white-custom dark:bg-dark-black-custom">
                <div class="card-body">
                    <h3 class="mb-4 text-base font-medium lg:text-xl text-black-custom dark:text-white-custom">Edit Jurusan
                    </h3>
                    <form action="{{ route('master_jurusan.update', $jurusan->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="nama-jurusan"
                                class="block mb-3 text-sm font-medium text-black-custom dark:text-white-custom">Nama Jurusan</label>
                            <input type="text"
                                class="block w-full px-2 py-3 text-sm font-medium border rounded-lg border-gray-custom text-black-custom md:w-md focus:outline-gray-custom dark:text-white-custom"
                                name="nama_jurusan" value="{{ $jurusan->nama_jurusan }}" id="nama-jurusan"
                                placeholder="Nama jurusan" required>
                        </div>
                        <div class="flex flex-wrap gap-1 pt-4">
                            <button type="submit" class="bg-black btn text-white-custom"
                                id="simpan"><i
                                    class="fa-regular fa-floppy-disk text-white-custom"></i> Update</button>
                            <button type="button" onclick="{window.location.href='{{ route('master_jurusan.index') }}'}" class="border border-black btn text-black-custom dark:text-white-custom" id="batal"><i
                                    class="fa-regular fa-circle-xmark text-black-custom dark:text-white-custom"></i> Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    {{-- sweetalert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const simpan = document.getElementById('simpan');
        simpan.addEventListener('click', () => {
            Swal.fire({
            title: "Berhasil!",
            text: "Berhasil Mengubah Jurusan",
            icon: "success",
            confirmButtonColor: "#000"
            })
        });
    </script>
    {{-- sweetalert --}}
    @endpush
@endsection
