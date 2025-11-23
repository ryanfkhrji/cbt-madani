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

    @vite(['resources/css/app.css', 'resources/js/app.js'])

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
                            <h3 class="mb-4 text-base font-medium lg:text-xl text-black-custom">Tambah Peserta Ujian</h3>
                            <div class="p-4 mb-4 rounded-sm bg-light-blue-custom">
                                <p class="text-sm text-gray-custom">Jika password kosong, maka akan dibuat secara otomatis oleh sistem</p>
                            </div>
                            <form action="">
                                <div class="mb-4">
                                    <label for="no-ujian" class="block mb-3 text-sm font-medium text-black-custom">No Ujian</label>
                                    <input type="text" class="block w-full px-2 py-3 text-sm font-medium border rounded-lg border-gray-custom text-black-custom md:w-xs focus:outline-gray-custom" name="no-ujian" id="no-ujian" placeholder="No Ujian" required>
                                </div>
                                <div class="mb-4">
                                    <label for="nama-peserta" class="block mb-3 text-sm font-medium text-black-custom">Nama Peserta</label>
                                    <input type="text" class="block w-full px-2 py-3 text-sm font-medium border rounded-lg border-gray-custom text-black-custom md:w-md focus:outline-gray-custom" name="nama-peserta" id="nama-peserta" placeholder="Nama Peserta" required>
                                </div>
                                <div class="mb-4">
                                    <label for="jenis-kelamin" class="block mb-3 text-sm font-medium text-black-custom">Jenis Kelamin</label>
                                    <select class="w-full border select border-gray-custom md:w-xs" required>
                                        <option disabled selected>Pilih Jenis Kelamin</option>
                                        <option>Laki - laki</option>
                                        <option>Perempuan</option>
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label for="nama-sekolah" class="block mb-3 text-sm font-medium text-black-custom">Nama Sekolah</label>
                                    <input type="text" class="block w-full px-2 py-3 text-sm font-medium border rounded-lg border-gray-custom text-black-custom md:w-md focus:outline-gray-custom" name="nama-sekolah" id="nama-sekolah" placeholder="Nama Sekolah" required>
                                </div>
                                <div class="mb-4">
                                    <label for="kelas" class="block mb-3 text-sm font-medium text-black-custom">Kelas</label>
                                    <input type="text" class="block w-full px-2 py-3 text-sm font-medium border rounded-lg border-gray-custom text-black-custom md:w-md focus:outline-gray-custom" name="kelas" id="kelas" placeholder="Kelas" required>
                                </div>
                                <div class="mb-4">
                                    <label for="password" class="block mb-3 text-sm font-medium text-black-custom">Password</label>
                                    <div class="relative w-full md:max-w-md">
                                        <input type="password"
                                            class="block w-full px-4 py-3 pr-10 text-sm font-medium border rounded-lg border-gray-custom text-black-custom focus:outline-gray-custom"
                                            name="password"
                                            id="password"
                                            placeholder="Password"
                                            required>
                                        <i class="absolute transform -translate-y-1/2 cursor-pointer fa-regular fa-eye-slash right-3 top-1/2 text-black-custom" id="togglePassword"></i>
                                    </div>
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
                window.location.href = '/data-peserta';
            });
        });

        batal.addEventListener('click', () => {
            window.location.href = '/data-peserta';
        });
    </script>
    {{-- sweetalert --}}

    {{-- script toggle password --}}
    <script>
        const toggle = document.getElementById('togglePassword');
        const password = document.getElementById('password');
        toggle.addEventListener('click', function (e) {
            // toggle the type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            // toggle the eye slash icon
            this.classList.toggle('fa-eye');
        });
    </script>
    {{-- script toggle password --}}
</body>
</html>
