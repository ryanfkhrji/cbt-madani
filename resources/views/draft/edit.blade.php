@extends('layouts.admin')
@section('content-admin')
<div class="min-h-screen p-4 mt-16">
    <div class="grid grid-cols-1">
        <div class="w-auto shadow-sm card bg-white-custom dark:bg-dark-black-custom">
            <div class="card-body">
                <h3 class="mb-4 text-base font-medium lg:text-xl text-black-custom dark:text-white-custom">Edit draft
                </h3>
                <form action="{{ route('master_draft.update', $draft->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Ujian -->
                    <div class="mb-4">
                        <label for="id_ujian"
                            class="block mb-3 text-sm font-medium text-black-custom dark:text-white-custom">Ujian</label>
                        <select name="id_ujian" class="w-full border select border-gray-custom md:w-xs dark:text-white-custom dark:bg-dark-black-custom"
                            required>
                            <option disabled {{ old('id_ujian', $draft->id_ujian) ? '' : 'selected' }}>Pilih
                                Ujian</option>
                            @foreach ($ujian as $item)
                                <option value="{{ $item->id }}"
                                    {{ old('id_ujian', $draft->id_ujian) == $item->id ? 'selected' : '' }}>
                                    {{ $item->nama_ujian }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Kelas -->
                    <div class="mb-4">
                        <label for="id_kelas"
                            class="block mb-3 text-sm font-medium text-black-custom dark:text-white-custom">Kelas</label>
                        <select name="id_kelas" id="kelas-select"
                            class="w-full border select border-gray-custom md:w-xs dark:text-white-custom dark:bg-dark-black-custom" required>
                            <option disabled {{ old('id_kelas', $draft->id_kelas) ? '' : 'selected' }}>Pilih
                                Kelas</option>
                            @foreach ($kelas as $item)
                                <option value="{{ $item->id }}"
                                    {{ old('id_kelas', $draft->id_kelas) == $item->id ? 'selected' : '' }}>
                                    {{ $item->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Nama Siswa -->
                    <div class="mb-4">
                        <label for="id_siswa" class="block mb-3 text-sm font-medium text-black-custom dark:text-white-custom">Nama
                            Siswa</label>

                        <div class="flex items-center gap-2 mb-2">
                            <input type="checkbox" id="check-all-siswa" class="form-checkbox">
                            <label for="check-all-siswa" class="text-sm text-black-custom dark:text-white-custom">Pilih Semua
                                Siswa</label>
                        </div>

                        <select name="id_siswa[]" id="siswa-select" class="w-full select md:w-xs dark:text-white-custom dark:bg-dark-black-custom"
                            multiple="multiple" required>
                            @foreach ($siswa as $item)
                                <option value="{{ $item->id }}"
                                    {{ collect(old('id_siswa', $draft->id_siswa))->contains($item->id) ? 'selected' : '' }}>
                                    {{ $item->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="flex flex-wrap gap-1 pt-4">
                        <button type="submit" class="bg-black border text-white-custom btn" id="simpan">
                            <i class="fa-regular fa-floppy-disk text-white-custom"></i> Update
                        </button>
                        <a href="{{ route('master_draft.index') }}"
                            class="border-black btn text-black-custom dark:text-white-custom">
                            <i class="fa-regular fa-circle-xmark text-black-custom dark:text-white-custom"></i> Batal
                        </a>
                    </div>
                </form>



            </div>
        </div>
    </div>
</div>

    @push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const kelasSelect = document.getElementById('kelas-select');
        const siswaSelect = document.getElementById('siswa-select');
        const checkAllSiswa = document.getElementById('check-all-siswa');

        // Fungsi untuk mengambil siswa berdasarkan kelas
        kelasSelect.addEventListener('change', function() {
            const kelasId = this.value;
            fetch(`/get-siswa-by-kelas/${kelasId}`)
                .then(response => response.json())
                .then(data => {
                    // Kosongkan opsi siswa
                    siswaSelect.innerHTML = '';

                    // Tambahkan opsi baru
                    data.forEach(siswa => {
                        const option = document.createElement('option');
                        option.value = siswa.id;
                        option.textContent = siswa.nama;
                        siswaSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Gagal mengambil data siswa:', error);
                });
        });

        // "Pilih Semua Siswa"
        checkAllSiswa.addEventListener('change', function() {
            const options = siswaSelect && siswaSelect.options;
            for (let i = 0; i < options.length; i++) {
                options[i].selected = this.checked;
            }
        });
    });
</script>

{{-- sweetalert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const simpan = document.getElementById('simpan');
    simpan.addEventListener('click', () => {
        Swal.fire({
        title: "Berhasil!",
        text: "Berhasil Mengubah Sesi Ujian",
        icon: "success",
        confirmButtonColor: "#000"
        })
    });
</script>
{{-- sweetalert --}}
    @endpush
@endsection
