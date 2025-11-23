@extends('layouts.admin')
@section('content-admin')
    <div class="min-h-screen p-4 mt-16">
        <div class="grid grid-cols-1">
            <div class="w-auto shadow-sm card bg-white-custom dark:bg-dark-black-custom">
                <div class="card-body">
                    <h3 class="mb-4 text-base font-medium lg:text-xl text-black-custom dark:text-white-custom">Data Soal
                        Ujian</h3>
                    <div class="flex flex-col-reverse justify-between w-full gap-3 mb-5 md:gap-0 md:flex-row">
                        <form method="GET" action="{{ route('master_soal.index') }}" id="filterForm">
                            <select
                                class="w-full border select border-gray-custom md:w-xs dark:text-white-custom dark:bg-dark-black-custom"
                                name="ujian_id" onchange="document.getElementById('filterForm').submit();">
                                <option value="">Pilih Ujian</option>
                                @foreach ($ujian as $item)
                                    <option value="{{ $item->id }}"
                                        {{ request('ujian_id') == $item->id ? 'selected' : '' }}>
                                        {{ $item->nama_ujian }}
                                    </option>
                                @endforeach
                            </select>
                        </form>

                        <div class="flex gap-2">
                            <a href="{{ route('master_soal.create') }}">
                                <button type="button" class="bg-black btn text-white-custom"><i
                                        class="fa-solid fa-plus"></i>Tambah Soal Ujian</button>
                            </a>
                            <a href="{{ route('soal.template') }}">
                                <button type="button" class="border border-black btn text-black-custom dark:text-white-custom"><i
                                        class="fa-solid fa-file"></i>Template Soal Ujian</button>
                            </a>
                            <a href="{{ route('import.view.soal') }}">
                                <button type="button" class="border border-black btn text-black-custom dark:text-white-custom"><i
                                        class="fa-solid fa-file-import"></i>Import Soal Ujian</button>
                            </a>

                            <!-- Tombol Hapus Semua Soal -->
                            <button type="button" id="btn-delete-all" class="text-red-600 border border-red-600 btn">
                                <i class="fa-solid fa-trash"></i> Hapus Semua Soal
                            </button>
                            {{-- fungsi untuk hapus --}}
                            <form id="form-delete-all" action="{{ route('master_soal.deleteAll') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id_ujian" value="{{ request('ujian_id') }}">
                            </form>
                        </div>
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
                            <thead class="bg-gray-100 text-black-custom dark:text-white-custom dark:bg-gray-900">
                                <tr>
                                    <th class="px-4 py-3 text-sm font-semibold text-left">No</th>
                                    <th class="px-4 py-3 text-sm font-semibold text-left">Soal</th>
                                    <th class="px-4 py-3 text-sm font-semibold text-left">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-dark-black-custom">
                                @forelse ($soal as $index => $item)
                                    <tr class="transition duration-150">
                                        <td class="px-4 py-3 text-sm text-gray-700 align-top dark:text-white-custom">
                                            {{ $index + 1 }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-700 align-top dark:text-white-custom">
                                            @php
                                                $isImage = $item->soal &&
                                                    Str::contains($item->soal, '/') &&
                                                    in_array(Str::lower(pathinfo($item->soal, PATHINFO_EXTENSION)), ['jpg','jpeg','png','gif','webp']);
                                            @endphp
                                            @if ($isImage)
                                                <img src="{{ Storage::url($item->soal) }}" alt="Soal Gambar" class="w-32 h-auto mb-2">
                                            @else
                                                <p class="text-sm text-black-custom dark:text-white-custom">{{ $item->soal }}</p>
                                            @endif

                                            <ul class="mt-2 ml-5 space-y-1 list-disc">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @php
                                                        $jawaban = $item["pilihan_$i"];
                                                        $isImage = Str::endsWith($jawaban, [
                                                            '.jpg',
                                                            '.jpeg',
                                                            '.png',
                                                            '.gif',
                                                        ]);
                                                        $isCorrect = "pilihan_$i" == $item->jawaban_benar;
                                                    @endphp
                                                    <li
                                                        class="{{ $isCorrect ? 'text-blue-600 font-semibold' : 'text-gray-700 dark:text-white-custom' }} text-sm">
                                                        @if ($isImage)
                                                            <img src="{{ asset('storage/' . $jawaban) }}"
                                                                alt="Pilihan Gambar" class="w-24 h-auto">
                                                            @if ($isCorrect)
                                                                <span class="ml-2">(Dipilih)</span>
                                                            @endif
                                                        @else
                                                            {{ $jawaban }}
                                                            @if ($isCorrect)
                                                                <span class="ml-2 font-semibold">(Dipilih)</span>
                                                            @endif
                                                        @endif
                                                    </li>
                                                @endfor
                                            </ul>
                                        </td>
                                        <td class="flex gap-2 px-4 py-3">
                                            <a href="{{ route('master_soal.edit', base64_encode($item->id)) }}"
                                                class="border border-black btn btn-edit text-black-custom dark:text-white-custom"><i
                                                    class="fa-regular fa-pen-to-square"></i></a>
                                            <form action="{{ route('master_soal.destroy', $item->id) }}" method="POST"
                                                class="form-hapus d-inline">
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
                                @empty
                                    <tr>
                                        <td colspan="3"
                                            class="px-4 py-6 text-center text-gray-500 dark:text-white-custom">Tidak ada
                                            soal untuk ujian ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- table --}}
                    {{-- pagination --}}
                    {{ $soal->links() }}
                    {{-- pagination --}}
                </div>
            </div>
        </div>
    </div>

    {{-- sweetalert --}}
    @push('scripts')
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
                        }
                    });
                });
            });
        </script>

        {{-- hapus soal all --}}
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
        document.getElementById('btn-delete-all').addEventListener('click', function () {
            Swal.fire({
                title: 'Yakin ingin menghapus semua soal?',
                text: "Tindakan ini tidak dapat dibatalkan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#000',
                cancelButtonColor: '#5C5470',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form-delete-all').submit();
                }
            })
        });
        </script>
    @endpush
@endsection
