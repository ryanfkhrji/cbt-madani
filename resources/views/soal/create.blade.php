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
                    <h3 class="mb-4 text-base font-medium lg:text-xl text-black-custom dark:text-white-custom">Tambah Soal Ujian</h3>
                    <form action="{{ route('master_soal.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        {{-- Ujian --}}
                        <div class="mb-4">
                            <label class="block mb-3 text-sm font-medium text-black-custom dark:text-white-custom">Ujian</label>
                            <select class="w-full border select border-gray-custom md:w-xs dark:text-white-custom dark:bg-dark-black-custom" required
                                name="id_ujian">
                                <option disabled selected>Pilih Ujian</option>
                                @foreach ($ujian as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_ujian }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Kategori Soal --}}
                        <div class="mb-4">
                            <label class="block mb-3 text-sm font-medium text-black-custom dark:text-white-custom">Kategori
                                Soal</label>
                            <select class="w-full border select border-gray-custom md:w-xs dark:text-white-custom dark:bg-dark-black-custom" required
                                name="id_kategori_soal" id="kategori_soal">
                                <option disabled selected>Pilih Jenis Soal</option>
                                @foreach ($kategori as $item)
                                    <option value="{{ $item->id }}" data-type="{{ $item->type }}">
                                        {{ $item->type }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Soal --}}
                        <div class="mb-4">
                            <label class="block mb-3 text-sm font-medium text-black-custom dark:text-white-custom">Soal</label>
                            <div id="soalField">
                                <textarea class="w-full border textarea border-gray-custom dark:text-white-custom dark:bg-dark-black-custom" name="soal" required></textarea>

                            </div>
                        </div>

                        {{-- Kategori Jawaban --}}
                        <div class="mb-4">
                            <label class="block mb-3 text-sm font-medium text-black-custom dark:text-white-custom">Kategori
                                Jawaban</label>
                            <select class="w-full border select border-gray-custom md:w-xs dark:text-white-custom dark:bg-dark-black-custom" required
                                name="id_kategori_jawaban" id="kategori_jawaban">
                                <option disabled selected>Pilih Jenis Jawaban</option>
                                @foreach ($kategori as $item)
                                    <option value="{{ $item->id }}" data-type="{{ $item->type }}">
                                        {{ $item->type }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Pilihan 1 - 5 --}}
                        @for ($i = 1; $i <= 5; $i++)
                            <div class="mb-4">
                                <label class="block mb-3 text-sm font-medium text-black-custom dark:text-white-custom">Pilihan
                                    {{ $i }}</label>
                                <div id="input_pilihan_{{ $i }}">
                                    <textarea class="w-full border textarea border-gray-custom dark:text-white-custom dark:bg-dark-black-custom" name="pilihan_{{ $i }}"></textarea>
                                </div>
                            </div>
                        @endfor

                        {{-- Jawaban Benar --}}
                        <div class="mb-4">
                            <label class="block mb-3 text-sm font-medium text-black-custom dark:text-white-custom">Jawaban
                                Benar</label>
                            <select name="jawaban_benar" class="w-full border select border-gray-custom md:w-xs dark:text-white-custom dark:bg-dark-black-custom"
                                required>
                                <option disabled selected>Pilih Jawaban Benar</option>
                                @for ($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}">Pilihan {{ $i }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        {{-- Poin --}}
                        <div class="mb-4">
                            <label class="block mb-3 text-sm font-medium text-black-custom dark:text-white-custom">Poin</label>
                            <input type="number" name="poin" min="0"
                                class="w-full border input border-gray-custom dark:bg-dark-black-custom dark:text-white-custom" required>
                        </div>

                        <div class="flex flex-wrap gap-1 pt-4">
                            <button type="submit" class="bg-black btn text-white-custom">
                                <i class="fa-regular fa-floppy-disk text-white-custom"></i> Simpan
                            </button>
                            <button type="button" onclick="{window.location.href='{{ route('master_soal.index') }}'}" class="border border-black btn text-black-custom dark:text-white-custom"
                                id="batal">
                                <i class="fa-regular fa-circle-xmark text-black-custom dark:text-white-custom"></i> Batal
                            </button>
                        </div>
                    </form>

                    {{-- JavaScript --}}
                    <script>
                        function updateSoal(type) {
                            const Soal = document.getElementById('soalField');
                            Soal.innerHTML = '';
                            if (type == 'image') {
                                const input = document.createElement('input')
                                input.name = 'soal'
                                input.type = 'file'
                                input.accept = 'image/*';
                                input.className =
                                    'block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100';
                                Soal.appendChild(input);
                            } else {
                                const textarea = document.createElement('textarea');
                                textarea.name = `soal`;
                                textarea.className = 'textarea border border-gray-custom w-full';
                                Soal.appendChild(textarea);
                            }
                        }

                        function updatePilihanInputs(type) {
                            for (let i = 1; i <= 5; i++) {
                                const container = document.getElementById(`input_pilihan_${i}`);
                                container.innerHTML = '';
                                if (type === 'image') {
                                    const input = document.createElement('input');
                                    input.type = 'file';
                                    input.name = `pilihan_${i}`;
                                    input.accept = 'image/*';
                                    input.className =
                                        'block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100';
                                    container.appendChild(input);
                                } else {
                                    const textarea = document.createElement('textarea');
                                    textarea.name = `pilihan_${i}`;
                                    textarea.className = 'textarea border border-gray-custom w-full';
                                    container.appendChild(textarea);
                                }
                            }
                        }

                        document.getElementById('kategori_jawaban').addEventListener('change', function() {
                            const selected = this.options[this.selectedIndex];
                            const type = selected.getAttribute('data-type');
                            updatePilihanInputs(type);
                        });
                        document.getElementById('kategori_soal').addEventListener('change', function() {
                            const selected = this.options[this.selectedIndex];
                            const type = selected.getAttribute('data-type');
                            updateSoal(type);
                        })
                    </script>

                </div>
            </div>
        </div>
    </div>

    {{-- quill --}}
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.editor').forEach((el) => {
                new Quill(el, {
                    theme: 'snow'
                });
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
            text: "Berhasil Menambahkan Soal",
            icon: "success",
            confirmButtonColor: "#000"
            })
        });
    </script>
    {{-- sweetalert --}}
    @endpush
@endsection
