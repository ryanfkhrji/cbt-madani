@extends('layouts.admin')
@section('content-admin')
    <div class="min-h-screen p-4 mt-16">
        <div class="alert-container">
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <div>
                            <h5 class="mb-1 alert-heading">Submission Failed</h5>
                            <div class="error-message">{!! session('error') !!}</div>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                        aria-label="Close"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <div>
                            <h5 class="mb-1 alert-heading">Validation Errors</h5>
                            <ul class="mb-0 error-list">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                        aria-label="Close"></button>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-check-circle me-2"></i>
                        <div>
                            <h5 class="mb-1 alert-heading">Success!</h5>
                            <div>{{ session('success') }}</div>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                        aria-label="Close"></button>
                </div>
            @endif
        </div>
        <div class="grid grid-cols-1">
            <div class="w-auto shadow-sm card bg-white-custom dark:bg-dark-black-custom">
                <div class="card-body">
                    <h3 class="mb-4 text-base font-medium lg:text-xl text-black-custom dark:text-white-custom">Tambah Sesi Ujian</h3>
                    <form action="{{ route('master_draft.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="nama-ujian"
                                class="block mb-3 text-sm font-medium text-black-custom dark:text-white-custom">Ujian</label>
                            <select name="id_ujian" class="w-full border select border-gray-custom md:w-xs dark:text-white-custom dark:bg-dark-black-custom"
                                required>
                                <option disabled selected>Pilih Ujian</option>
                                @foreach ($ujian as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_ujian }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="nama-ujian"
                                class="block mb-3 text-sm font-medium text-black-custom dark:text-white-custom">Kelas</label>
                            <select name="id_kelas" id="kelas-select"
                                class="w-full border select border-gray-custom md:w-xs dark:text-white-custom dark:bg-dark-black-custom" required>
                                <option disabled selected>Pilih Kelas</option>
                                @foreach ($kelas as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_kelas }}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="mb-4">
                            <label for="id_siswa" class="block mb-3 text-sm font-medium text-black-custom dark:text-white-custom">Nama Siswa</label>

                            <div class="flex items-center gap-2 mb-2">
                                <input type="checkbox" id="check-all-siswa" class="form-checkbox">
                                <label for="check-all-siswa" class="text-sm text-black-custom dark:text-white-custom">Pilih Semua Siswa</label>
                            </div>

                            <select name="id_siswa[]" id="siswa-select" class="w-full select md:w-xs dark:text-white-custom dark:bg-dark-black-custom"
                                multiple="multiple" required>
                                {{-- opsi siswa akan diisi via JS --}}
                            </select>
                        </div>

                        <div class="flex flex-wrap gap-1 pt-4">
                            <button type="submit" class="bg-black btn text-white-custom"
                                id="simpan"><i
                                    class="fa-regular fa-floppy-disk text-white-custom"></i>Simpan</button>
                            <button type="button" onclick="{window.location.href='{{ route('master_draft.index') }}'}" class="border-black btn text-black-custom dark:text-white-custom" id="batal"><i
                                    class="fa-regular fa-circle-xmark text-black-custom dark:text-white-custom"></i>Batal</button>
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
            text: "Berhasil Menambahkan Sesi Ujian",
            icon: "success",
            confirmButtonColor: "#000"
            })
        }).then(() => {
            // Submit form setelah alert selesai
            form.submit();
            window.location.href = '/master-draft';
        });
    </script>
    {{-- sweetalert --}}

    <script>
        let siswaSemua = []; // untuk menyimpan list siswa semua dari kelas yang dipilih

        function loadSiswaKelas(kelasId) {
            return $.ajax({
                url: '{{ route('get-siswa-by-kelas') }}',
                type: 'GET',
                data: {
                    kelas_id: kelasId,
                    _token: '{{ csrf_token() }}',
                    q: ''
                },
                dataType: 'json'
            });
        }

        $(document).ready(function() {
            const $siswaSelect = $('#siswa-select');
            const $kelasSelect = $('#kelas-select');
            const $checkAll = $('#check-all-siswa');

            // Inisialisasi select2 tanpa ajax (manual)
            $siswaSelect.select2({
                placeholder: 'Pilih siswa...',
            });

            $kelasSelect.on('change', function() {
                $siswaSelect.empty().trigger('change');
                $checkAll.prop('checked', false);
            });

            $checkAll.on('change', function() {
                const kelasId = $kelasSelect.val();
                if (!kelasId) {
                    alert('Pilih kelas terlebih dahulu');
                    $checkAll.prop('checked', false);
                    return;
                }

                if ($(this).is(':checked')) {
                    // Ambil semua siswa berdasarkan kelas
                    loadSiswaKelas(kelasId).done(function(data) {
                        siswaSemua = data;

                        $siswaSelect.empty(); // kosongkan dulu
                        const newOptions = data.map(item => new Option(item.nama, item.id, true,
                            true)); // selected = true
                        newOptions.forEach(option => $siswaSelect.append(option));
                        $siswaSelect.trigger('change');
                    });
                } else {
                    // Hapus semua pilihan
                    $siswaSelect.val(null).trigger('change');
                }
            });
        });
    </script>
    @endpush
@endsection
