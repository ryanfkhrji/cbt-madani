@extends('layouts.admin')
@section('content-admin')
<div class="min-h-screen p-4 mt-16">
    <div class="grid grid-cols-1">
        <div class="w-auto shadow-sm card bg-white-custom dark:bg-dark-black-custom">
            <div class="card-body">
                <h3 class="mb-4 text-base font-medium lg:text-xl text-black-custom dark:text-white-custom">Edit kelas
                </h3>
                <form action="{{ route('master_kelas.update', $kelas->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="kelas"
                            class="block mb-3 text-sm font-medium text-black-custom dark:text-white-custom">Kelas</label>
                        @if ($errors->has('kelas'))
                            <div class="mb-2 text-sm text-red-500">{{ $errors->first('kelas') }}</div>
                        @endif
                        <select name="kelas" id="kelas"
                            class="block w-full px-2 py-3 text-sm font-medium border rounded-lg border-gray-custom text-black-custom md:w-md focus:outline-gray-custom dark:bg-dark-black-custom dark:text-white-custom"
                            required>
                            <option value="">-- Pilih Kelas --</option>
                            <option value="X"
                                {{ old('kelas', $kelas->kelas) == 'X' ? 'selected' : '' }}>Kelas X</option>
                            <option value="XI"
                                {{ old('kelas', $kelas->kelas) == 'XI' ? 'selected' : '' }}>Kelas XI
                            </option>
                            <option value="XII"
                                {{ old('kelas', $kelas->kelas) == 'XII' ? 'selected' : '' }}>Kelas XII
                            </option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="jurusan"
                            class="block mb-3 text-sm font-medium text-black-custom dark:text-white-custom">Jurusan</label>
                        @if ($errors->has('id_jurusan'))
                            <div class="mb-2 text-sm text-red-500">{{ $errors->first('id_jurusan') }}</div>
                        @endif
                        <select name="id_jurusan" id="jurusan"
                            class="block w-full px-2 py-3 text-sm font-medium border rounded-lg border-gray-custom text-black-custom md:w-md focus:outline-gray-custom dark:bg-dark-black-custom dark:text-white-custom"
                            required>
                            <option value="">-- Pilih Jurusan --</option>
                            @foreach ($jurusan as $item)
                                <option value="{{ $item->id }}"
                                    {{ old('id_jurusan', $kelas->id_jurusan) == $item->id ? 'selected' : '' }}>
                                    {{ $item->nama_jurusan }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="nama-kelas"
                            class="block mb-3 text-sm font-medium text-black-custom dark:text-white-custom">Nama Kelas</label>
                        @if ($errors->has('nama_kelas'))
                            <div class="mb-2 text-sm text-red-500">{{ $errors->first('nama_kelas') }}</div>
                        @endif
                        <input type="text"
                            class="block w-full px-2 py-3 text-sm font-medium border rounded-lg border-gray-custom text-black-custom md:w-md focus:outline-gray-custom dark:text-white-custom"
                            name="nama_kelas" id="nama-kelas" placeholder="Nama kelas" required
                            value="{{ old('nama_kelas', $kelas->nama_kelas) }}">
                    </div>

                    <div class="flex flex-wrap gap-1 pt-4">
                        <button type="submit" class="bg-black btn text-white-custom" id="simpan">
                            <i class="fa-regular fa-floppy-disk text-white-custom"></i> Update
                        </button>
                        <a href="{{ route('master_kelas.index') }}"
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
