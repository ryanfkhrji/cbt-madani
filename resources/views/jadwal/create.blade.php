@extends('layouts.admin')
@section('content-admin')
    <div class="min-h-screen p-4 mt-16">
        <div class="grid grid-cols-1">
            <div class="w-auto shadow-sm card bg-white-custom dark:bg-dark-black-custom">
                <div class="card-body">
                    <h3 class="mb-4 text-base font-medium lg:text-xl text-black-custom dark:text-white-custom">Tambah Jadwal
                    </h3>
                    <form action="{{ route('master_jadwal.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="id_ujian"
                                class="block mb-3 text-sm font-medium text-black-custom dark:text-white-custom">Ujian</label>
                            <select name="id_ujian" id="id_ujian"
                                class="block w-full px-2 py-3 text-sm font-medium border rounded-lg border-gray-custom text-black-custom md:w-md focus:outline-gray-custom dark:text-white-custom dark:bg-dark-black-custom"
                                required>
                                <option value="" disabled selected>Pilih Ujian</option>
                                @foreach ($ujian as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_ujian }}</option>
                                @endforeach


                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="nama-jadwal"
                                class="block mb-3 text-sm font-medium text-black-custom dark:text-white-custom">Nama Jadwal</label>
                            <input type="text" name="nama_jadwal" id="nama-jadwal"
                                class="block w-full px-2 py-3 text-sm font-medium border rounded-lg border-gray-custom text-black-custom md:w-md focus:outline-gray-custom dark:text-white-custom dark:bg-dark-black-custom"
                                placeholder="Nama Jadwal" required>
                        </div>

                        <div class="mb-4">
                            <label for="hari"
                                class="block mb-3 text-sm font-medium text-black-custom dark:text-white-custom">Hari</label>
                            <select name="hari" id="hari"
                                class="block w-full px-2 py-3 text-sm font-medium border rounded-lg border-gray-custom text-black-custom md:w-md focus:outline-gray-custom dark:text-white-custom dark:bg-dark-black-custom"
                                required>
                                <option value="" disabled selected>Pilih hari</option>
                                <option value="Senin">Senin</option>
                                <option value="Selasa">Selasa</option>
                                <option value="Rabu">Rabu</option>
                                <option value="Kamis">Kamis</option>
                                <option value="Jumat">Jumat</option>
                                <option value="Sabtu">Sabtu</option>
                                <option value="Minggu">Minggu</option>
                            </select>
                        </div>


                        <div class="mb-4">
                            <label for="tanggal"
                                class="block mb-3 text-sm font-medium text-black-custom dark:text-white-custom">Tanggal</label>
                            <input type="date" name="tanggal" id="tanggal"
                                class="block w-full px-2 py-3 text-sm font-medium border rounded-lg border-gray-custom text-black-custom md:w-md focus:outline-gray-custom dark:text-white-custom dark:bg-dark-black-custom"
                                required>
                        </div>

                        <div class="mb-4">
                            <label for="jam-in" class="block mb-3 text-sm font-medium text-black-custom dark:text-white-custom">Jam
                                Masuk</label>
                            <input type="time" name="jam_in" id="jam-in"
                                class="block w-full px-2 py-3 text-sm font-medium border rounded-lg border-gray-custom text-black-custom md:w-md focus:outline-gray-custom dark:text-white-custom dark:bg-dark-black-custom"
                                required>
                        </div>

                        <div class="mb-4">
                            <label for="jam-out" class="block mb-3 text-sm font-medium text-black-custom dark:text-white-custom">Jam
                                Keluar</label>
                            <input type="time" name="jam_out" id="jam-out"
                                class="block w-full px-2 py-3 text-sm font-medium border rounded-lg border-gray-custom text-black-custom md:w-md focus:outline-gray-custom dark:text-white-custom dark:bg-dark-black-custom"
                                required>
                        </div>

                        <div class="flex flex-wrap gap-1 pt-4">
                            <button type="submit" class="bg-black btn text-white-custom" id="simpan">
                                <i class="fa-regular fa-floppy-disk text-white-custom"></i> Simpan
                            </button>
                            <button type="button" onclick="{window.location.href='{{ route('master_jadwal.index') }}'}" class="border border-black btn text-black-custom dark:text-white-custom" id="batal">
                                <i class="fa-regular fa-circle-xmark text-black-custom dark:text-white-custom"></i> Batal
                            </button>
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
            text: "Berhasil Menambahkan Jadwal",
            icon: "success",
            confirmButtonColor: "#000"
            })
        });
    </script>
    {{-- sweetalert --}}
    @endpush
@endsection
