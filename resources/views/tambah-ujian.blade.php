<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CBT | Admin</title>
    <!-- fontawesome -->
        <link rel="stylesheet" href="/fontawesome/css/all.min.css" />

    <!-- favicon -->
        <link rel="icon" type="image/svg+xml" href="/assets/logo-sekolah.png">

    {{-- quill --}}
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">

    <link rel="stylesheet" href="/build/assets/app-CMdHnh2Y.css">
    <script src="/build/assets/app-BYiNv_yN.js" defer></script>
</head>
<body>
    <div class="drawer lg:drawer-open">
        <input id="my-drawer-2" type="checkbox" class="drawer-toggle" />
        {{-- sidebar --}}
        <div class="z-50 drawer-side">
            <label for="my-drawer-2" aria-label="close sidebar" class="drawer-overlay"></label>
            @include('components.sidebar.sidebar')
        </div>
        {{-- sidebar --}}

        {{-- navbar --}}
        <div class="drawer-content">
            @include('components.navbar.navbar')
        </div>
        {{-- navbar --}}

        {{-- content --}}
        <div class="drawer-content">
            <div class="min-h-screen p-4 mt-16">
                <div class="grid grid-cols-1">
                    <div class="w-auto shadow-sm card bg-white-custom">
                        <div class="card-body">
                            <h3 class="mb-4 text-base font-medium lg:text-xl text-black-custom">Tambah Ujian</h3>
                            <form action="">
                                <div class="mb-4">
                                    <label for="nama-ujian" class="block mb-3 text-sm font-medium text-black-custom">Nama Ujian</label>
                                    <input type="text" class="block w-full px-2 py-3 text-sm font-medium border rounded-lg border-gray-custom text-black-custom md:w-xs focus:outline-gray-custom" name="nama-ujian" id="nama-ujian" placeholder="Nama Ujian" required>
                                </div>
                                <div class="mb-4">
                                    <label for="nama-mapel" class="block mb-3 text-sm font-medium text-black-custom">Nama Mapel</label>
                                    <input type="text" class="block w-full px-2 py-3 text-sm font-medium border rounded-lg border-gray-custom text-black-custom md:w-xs focus:outline-gray-custom" name="nama-mapel" id="nama-mapel" placeholder="Nama Mapel" required>
                                </div>
                                <div class="mb-4">
                                    <label for="jumlah-soal" class="block mb-3 text-sm font-medium text-black-custom">Jumlah Soal</label>
                                    <input type="number" class="block w-full px-2 py-3 text-sm font-medium border rounded-lg border-gray-custom text-black-custom md:w-xs focus:outline-gray-custom" name="jumlah-soal" id="jumlah-soal" placeholder="Jumlah Soal" required>
                                </div>
                                <div class="mb-4">
                                    <label for="durasi" class="block mb-3 text-sm font-medium text-black-custom">Durasi (menit)</label>
                                    <input type="number" class="block w-full px-2 py-3 text-sm font-medium border rounded-lg border-gray-custom text-black-custom md:w-xs focus:outline-gray-custom" name="durasi" id="durasi" placeholder="Durasi (menit)" required>
                                </div>
                                <div class="mb-4">
                                    <label for="acak-soal" class="block mb-3 text-sm font-medium text-black-custom">Acak Soal</label>
                                    <select class="w-full border select border-gray-custom md:w-xs">
                                        <option>Ya</option>
                                        <option>Tidak</option>
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label for="acak-jawaban" class="block mb-3 text-sm font-medium text-black-custom">Acak Jawaaban</label>
                                    <select class="w-full border select border-gray-custom md:w-xs">
                                        <option>Ya</option>
                                        <option>Tidak</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label for="deskripsi" class="block mb-3 text-sm font-medium text-black-custom">Deskripsi</label>
                                    <div id="editor"></div>
                                </div>
                                <div class="flex flex-wrap gap-1 pt-4">
                                    <button type="submit" class="btn bg-blue-custom text-white-custom" id="simpan"><i class="fa-regular fa-floppy-disk text-white-custom"></i>Simpan</button>
                                    <button type="button" class="btn bg-red-custom text-white-custom" id="batal"><i class="fa-regular fa-circle-xmark text-white-custom"></i>Batal</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- content --}}
    </div>

    {{-- quill --}}
    <script>
        const quill = new Quill('#editor', {
            theme: 'snow'
        });
    </script>

    {{-- sweetalert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const simpan = document.getElementById('simpan');
        const batal = document.getElementById('batal');
        simpan.addEventListener('click', () => {
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Data berhasil disimpan',
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true
            }).then(() => {
                window.location.href = '/data-ujian';
            });
        });

        batal.addEventListener('click', () => {
            window.location.href = '/data-ujian';
        });
    </script>
    {{-- sweetalert --}}
</body>
</html>
