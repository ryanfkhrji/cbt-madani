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

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="/build/assets/app-q0VINn85.css">
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
                    <div class="w-auto shadow-sm card bg-white-custom dark:bg-dark-black-custom">
                        <div class="card-body">
                            <h3 class="mb-4 text-base font-medium lg:text-xl text-black-custom dark:text-white-custom">Profile User</h3>
                            <form action="{{ route('update.profile', $user->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="mb-4">
                                    <label for="nama" class="block mb-3 text-sm font-medium text-black-custom dark:text-white-custom">
                                        Nama
                                    </label>
                                    <input type="text"
                                        class="block w-full px-2 py-3 text-sm font-medium border rounded-lg border-gray-custom text-black-custom focus:outline-gray-custom dark:text-white-custom"
                                        name="name" value="{{ $user->name }}" id="nama"
                                        placeholder="Enter your name" required>
                                </div>
                                <div class="mb-4">
                                    <label for="username" class="block mb-3 text-sm font-medium text-black-custom dark:text-white-custom">
                                        Username
                                    </label>
                                    <input type="text"
                                        class="block w-full px-2 py-3 text-sm font-medium border rounded-lg border-gray-custom text-black-custom focus:outline-gray-custom dark:text-white-custom"
                                        name="username" id="username" value="{{ $user->username }}"
                                        placeholder="Username" required readonly>
                                </div>

                                <div class="mb-4">
                                    <label for="password" class="block mb-3 text-sm font-medium text-black-custom dark:text-white-custom">
                                        Password
                                    </label>
                                    <div class="relative">
                                        <input type="password"
                                            class="block w-full px-2 py-3 text-sm font-medium border rounded-lg border-gray-custom text-black-custom focus:outline-gray-custom dark:text-white-custom"
                                            name="password" id="password" placeholder="Password">
                                        <i class="absolute text-sm cursor-pointer fa-regular fa-eye-slash top-4 right-3 text-black-custom dark:text-white-custom"
                                            id="togglePassword"></i>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label for="konfirmasi-password"
                                        class="block mb-3 text-sm font-medium text-black-custom dark:text-white-custom">
                                        Konfirmasi Password
                                    </label>
                                    <input type="password"
                                        class="block w-full px-2 py-3 text-sm font-medium border rounded-lg border-gray-custom text-black-custom focus:outline-gray-custom dark:text-white-custom"
                                        name="confirmPassword" id="konfirmasi-password"
                                        placeholder="Konfirmasi Password">
                                </div>
                                <div class="mb-4">
                                    <label for="foto" class="block mb-3 text-sm font-medium text-black-custom dark:text-white-custom">
                                        Foto User
                                    </label>
                                    <input type="file" class="w-full max-w-xs file-input dark:text-white-custom dark:bg-dark-black-custom" name="foto"
                                        id="foto" value="{{ $user->image }}" />
                                    <div
                                        class="block px-2 py-3 mt-4 overflow-auto border rounded-sm border-gray-custom max-w-max">
                                        <img src="{{ asset('storage/profile/admin/' . $user->image) }}" alt="foto-user"
                                            class="w-40">
                                    </div>
                                </div>
                                <div class="flex flex-wrap gap-1 pt-4">
                                    <button id="simpan" type="submit" class="bg-black btn text-white-custom"><i
                                            class="fa-regular fa-floppy-disk text-white-custom"></i>Simpan
                                        Perubahan
                                    </button>
                                    <button id="batal" type="button" class="border-black btn text-black-custom dark:text-white-custom"><i class="fa-regular fa-circle-xmark text-black-custom dark:text-white-custom"></i>
                                        Batal
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- content --}}
    </div>

    {{-- script toggle password --}}
    <script>
        const toggle = document.getElementById('togglePassword');
        const password = document.getElementById('password');
        toggle.addEventListener('click', function(e) {
            // toggle the type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            // toggle the eye slash icon
            this.classList.toggle('fa-eye');
        });
    </script>
    {{-- script toggle password --}}

    {{-- sweetalert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const simpan = document.getElementById('simpan');
        const batal = document.getElementById('batal');
        simpan.addEventListener('click', () => {
            Swal.fire({
            title: "Berhasil!",
            text: "Berhasil Memperbarui Profile",
            icon: "success"
            }).then(() => {
                window.location.href = '/';
            });
        });

        batal.addEventListener('click', () => {
            window.location.href = '/';
        });
    </script>
    {{-- sweetalert --}}
</body>

</html>
