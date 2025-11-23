=@extends('layouts.admin')
@section('content-admin')
<div class="min-h-screen p-4 mt-16">
    <div class="grid grid-cols-1">
        <div class="w-auto shadow-sm card bg-white-custom dark:bg-dark-black-custom">
            <div class="card-body">
                <h3 class="mb-4 text-base font-medium lg:text-xl text-black-custom dark:text-white-custom">Edit Siswa
                </h3>
                <form action="{{ route('master_siswa.update', $siswa->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- NIS -->
                    <div class="mb-4">
                        <label for="nis"
                            class="block mb-3 text-sm font-medium text-black-custom dark:text-white-custom">NIS</label>
                        @error('nis')
                            <div class="mb-2 text-sm text-red-500">{{ $message }}</div>
                        @enderror
                        <input type="text" name="nis" id="nis" required
                            class="block w-full px-2 py-3 text-sm border rounded-lg border-gray-custom text-black-custom md:w-md dark:text-white-custom"
                            value="{{ old('nis', $siswa->nis) }}" placeholder="Masukkan NIS">
                    </div>

                    <!-- NISN -->
                    <div class="mb-4">
                        <label for="nisn"
                            class="block mb-3 text-sm font-medium text-black-custom dark:text-white-custom">NISN</label>
                        @error('nisn')
                            <div class="mb-2 text-sm text-red-500">{{ $message }}</div>
                        @enderror
                        <input type="text" name="nisn" id="nisn" required
                            class="block w-full px-2 py-3 text-sm border rounded-lg border-gray-custom text-black-custom md:w-md dark:text-white-custom"
                            value="{{ old('nisn', $siswa->nisn) }}" placeholder="Masukkan NISN">
                    </div>

                    <!-- Nama -->
                    <div class="mb-4">
                        <label for="nama"
                            class="block mb-3 text-sm font-medium text-black-custom dark:text-white-custom">Nama</label>
                        @error('nama')
                            <div class="mb-2 text-sm text-red-500">{{ $message }}</div>
                        @enderror
                        <input type="text" name="nama" id="nama" required
                            class="block w-full px-2 py-3 text-sm border rounded-lg border-gray-custom text-black-custom md:w-md dark:text-white-custom"
                            value="{{ old('nama', $siswa->nama) }}" placeholder="Masukkan nama lengkap">
                    </div>

                    <!-- Tanggal Lahir -->
                    <div class="mb-4">
                        <label for="tanggal_lahir"
                            class="block mb-3 text-sm font-medium text-black-custom dark:text-white-custom">Tanggal Lahir</label>
                        @error('tanggal_lahir')
                            <div class="mb-2 text-sm text-red-500">{{ $message }}</div>
                        @enderror
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" required
                            class="block w-full px-2 py-3 text-sm border rounded-lg border-gray-custom text-black-custom md:w-md dark:text-white-custom"
                            value="{{ old('tanggal_lahir', $siswa->tanggal_lahir) }}">
                    </div>

                    <!-- Jenis Kelamin -->
                    <div class="mb-4">
                        <label class="block mb-3 text-sm font-medium text-black-custom dark:text-white-custom">Jenis
                            Kelamin</label>
                        @error('jenis_kelamin')
                            <div class="mb-2 text-sm text-red-500">{{ $message }}</div>
                        @enderror
                        <div class="flex items-center gap-6">
                            <label class="flex items-center gap-2">
                                <input type="radio" name="jenis_kelamin" value="Laki-laki"
                                    {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'Laki-laki' ? 'checked' : '' }}>
                                <span class="text-black-custom dark:text-white-custom">Laki-laki</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="jenis_kelamin" value="Perempuan"
                                    {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'Perempuan' ? 'checked' : '' }}>
                                <span class="text-black-custom dark:text-white-custom">Perempuan</span>
                            </label>
                        </div>
                    </div>

                    <!-- Kelas -->
                    <div class="mb-4">
                        <label for="kelas"
                            class="block mb-3 text-sm font-medium text-black-custom dark:text-white-custom">Kelas</label>
                        @error('id_kelas')
                            <div class="mb-2 text-sm text-red-500">{{ $message }}</div>
                        @enderror
                        <select name="id_kelas" id="kelas"
                            class="block w-full px-2 py-3 text-sm border rounded-lg border-gray-custom text-black-custom md:w-md dark:text-white-custom dark:bg-dark-black-custom"
                            required>
                            <option value="">-- Pilih Kelas --</option>
                            @foreach ($kelas as $item)
                                <option value="{{ $item->id }}"
                                    {{ old('id_kelas', $siswa->id_kelas) == $item->id ? 'selected' : '' }}>
                                    {{ $item->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="flex flex-wrap gap-1 pt-4">
                        <button type="submit" class="bg-black btn text-white-custom" id="simpan">
                            <i class="fa-regular fa-floppy-disk text-white-custom"></i> Update
                        </button>
                        <a href="{{ route('master_siswa.index') }}"
                            class="border border-black btn text-black-custom dark:text-white-custom">
                            <i class="fa-regular fa-circle-xmark text-black-custom dark:text-white-custom"></i> Batal
                        </a>
                    </div>
                </form>


            </div>
        </div>
    </div>
</div>
@endsection
