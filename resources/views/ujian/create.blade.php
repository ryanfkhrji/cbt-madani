@extends('layouts.admin')
@section('content-admin')
    <div class="min-h-screen p-4 mt-16">
        <div class="grid grid-cols-1">
            <div class="w-auto shadow-sm card bg-white-custom dark:bg-dark-black-custom">
                <div class="card-body">
                    <h3 class="mb-4 text-base font-medium lg:text-xl text-black-custom dark:text-white-custom">Tambah Ujian
                    </h3>
                    <form action="{{ route('master_ujian.store') }}" method="POST" id="form-ujian">
                        @csrf
                        <div class="mb-4">
                            <label for="nama-ujian"
                                class="block mb-3 text-sm font-medium text-black-custom dark:text-white-custom">Nama
                                Ujian</label>
                            <input type="text"
                                class="block w-full px-2 py-3 text-sm font-medium border rounded-lg border-gray-custom text-black-custom md:w-xs focus:outline-gray-custom dark:text-white-custom"
                                name="nama_ujian" id="nama-ujian" placeholder="Nama Ujian" required>
                            @error('nama_ujian')
                                <div class="mb-2 text-sm text-red-500">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="id_mapel"
                                class="block mb-3 text-sm font-medium text-black-custom dark:text-white-custom">Mata
                                Pelajaran</label>
                            <select name="id_mapel" id="mapel"
                                class="block w-full px-2 py-3 text-sm font-medium border rounded-lg border-gray-custom text-black-custom md:w-md focus:outline-gray-custom dark:text-white-custom dark:bg-dark-black-custom"
                                required>
                                <option value="">-- Pilih Mata Pelajaran --</option>
                                @foreach ($mapel as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('id_mapel') == $item->id ? 'selected' : '' }}>
                                        {{ $item->nama_mapel }}
                                    </option>
                                @endforeach
                                @error('id_mapel')
                                    <div class="mb-2 text-sm text-red-500">{{ $message }}</div>
                                @enderror
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="jumlah-soal"
                                class="block mb-3 text-sm font-medium text-black-custom dark:text-white-custom">Jumlah
                                Soal</label>
                            <input type="number"
                                class="block w-full px-2 py-3 text-sm font-medium border rounded-lg border-gray-custom text-black-custom md:w-xs focus:outline-gray-custom dark:text-white-custom"
                                name="jumlah_soal" id="jumlah-soal" placeholder="Jumlah Soal" required>
                            @error('jumlah_soal')
                                <div class="mb-2 text-sm text-red-500">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="acak-soal"
                                class="block mb-3 text-sm font-medium text-black-custom dark:text-white-custom">Acak
                                Soal</label>
                            <select name="soal_acak"
                                class="w-full border select border-gray-custom md:w-xs dark:text-white-custom dark:bg-dark-black-custom">
                                <option value="1">Ya</option>
                                <option value="2">Tidak</option>
                            </select>
                            @error('soal_acak')
                                <div class="mb-2 text-sm text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- <div class="mb-4">
                            <label for="acak-jawaban"
                                class="block mb-3 text-sm font-medium text-black-custom dark:text-white-custom">Acak Jawaaban</label>
                            <select name="jawaban_acak" class="w-full border select border-gray-custom md:w-xs dark:text-white-custom dark:bg-dark-black-custom">
                                <option value="1">Ya</option>
                                <option value="2">Tidak</option>
                            </select>
                            @error('jawaban_acak')
                                <div class="mb-2 text-sm text-red-500">{{ $message }}</div>
                            @enderror
                        </div> --}}
                        <input type="hidden" name="jawaban_acak" value="1">

                        <div class="mb-4">
                            <input type="hidden" name="deskripsi" id="deskripsi-input">
                            <label for="deskripsi"
                                class="block mb-3 text-sm font-medium text-black-custom dark:text-white-custom">Deskripsi</label>
                            <div id="editor"></div>
                            @error('deskripsi')
                                <div class="mb-2 text-sm text-red-500">{{ $message }}</div>
                            @enderror

                        </div>
                        <div class="flex flex-wrap gap-1 pt-4">
                            <button type="submit" class="bg-black btn text-white-custom" id="simpan"><i
                                    class="fa-regular fa-floppy-disk text-white-custom"></i>Simpan</button>
                            <button type="button" onclick="{window.location.href='{{ route('master_ujian.index') }}'}"
                                class="border border-black btn text-black-custom dark:text-white-custom" id="batal"><i
                                    class="fa-regular fa-circle-xmark text-black-custom dark:text-white-custom"></i>Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Inisialisasi Quill Editor
                const quill = new Quill('#editor', {
                    theme: 'snow'
                });

                // Pastikan form sudah benar ID-nya
                const form = document.getElementById('form-ujian');
                const deskripsiInput = document.getElementById('deskripsi-input');

                form.addEventListener('submit', function(e) {
                    // Ambil konten dalam bentuk HTML dan teks
                    const html = quill.root.innerHTML.trim();
                    const text = quill.getText().trim();

                    // Jika teks kosong atau hanya terdapat <p><br></p>, tampilkan alert
                    if (text.length === 0 || html === '<p><br></p>') {
                        alert('Deskripsi tidak boleh kosong.');
                        e.preventDefault(); // Batalkan submit
                        return;
                    }

                    // Set nilai ke input hidden
                    deskripsiInput.value = html;
                });
            });
        </script>
    @endpush

    @push('scripts')
        {{-- sweetalert --}}
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            const simpan = document.getElementById('simpan');
            simpan.addEventListener('click', () => {
                Swal.fire({
                    title: "Berhasil!",
                    text: "Berhasil Menambahkan Ujian",
                    icon: "success",
                    confirmButtonColor: "#000"
                })
            });
        </script>
        {{-- sweetalert --}}
    @endpush
@endsection
