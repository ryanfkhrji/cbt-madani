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
                            <h3 class="mb-4 text-base font-medium lg:text-xl text-black-custom">Data Peserta Ujian</h3>
                            <div class="flex flex-wrap gap-2 mb-5">
                                <a href="/tambah-peserta">
                                    <button type="button" class="btn bg-blue-custom text-white-custom"><i class="fa-solid fa-plus"></i>Tambah</button>
                                </a>
                                <a href="/import-peserta">
                                    <button type="button" class="btn bg-green-custom text-white-custom"><i class="fa-solid fa-file-import"></i>Import</button>
                                </a>
                                <a href="/">
                                    <button type="button" class="bg-yellow-500 btn text-white-custom"><i class="fa-solid fa-file-export"></i>Export</button>
                                </a>
                                <a href="/cetak-kartu">
                                    <button type="button" class="bg-indigo-500 btn text-white-custom"><i class="fa-solid fa-print"></i>Cetak Kartu</button>
                                </a>
                            </div>
                            <div class="flex flex-wrap items-center justify-between gap-3 md:gap-0">
                                <p class="text-sm font-medium text-black-custom">
                                    Show entries
                                    <input type="number" class="w-10 p-1 border rounded-sm border-gray-custom focus:outline-gray-custom" placeholder="10">
                                </p>
                                <input type="text" class="block w-full px-3 py-2 text-sm border rounded-sm border-gray-custom text-black-custom md:max-w-sm focus:outline-gray-custom" placeholder="Search..." required>
                            </div>
                            {{-- table --}}
                            <div class="mt-4 overflow-x-auto">
                                <table class="table table-zebra">
                                    <!-- head -->
                                    <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>No Ujian</th>
                                        <th>Nama Peserta</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Nama Sekolah</th>
                                        <th>Kelas</th>
                                        <th>Password</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <!-- row 1 -->
                                    <tr>
                                        <th>1</th>
                                        <td>212212</td>
                                        <td>Budi</td>
                                        <td>L</td>
                                        <td>SMK Negeri 1</td>
                                        <td>X RPL 1</td>
                                        <td>9sjds92</td>
                                        <td>
                                            <button type="button" class="btn btn-edit bg-blue-custom text-white-custom"><i class="fa-regular fa-pen-to-square"></i></button>
                                            <button type="button" class="btn btn-hapus bg-red-custom text-white-custom"><i class="fa-regular fa-trash-can"></i></button>
                                        </td>
                                    </tr>
                                    <!-- row 2 -->
                                    <tr>
                                        <th>2</th>
                                        <td>212212</td>
                                        <td>Susi</td>
                                        <td>P</td>
                                        <td>SMK Negeri 1</td>
                                        <td>X RPL 1</td>
                                        <td>9sjds92</td>
                                        <td>
                                            <button type="button" class="btn btn-edit bg-blue-custom text-white-custom"><i class="fa-regular fa-pen-to-square"></i></button>
                                            <button type="button" class="btn btn-hapus bg-red-custom text-white-custom"><i class="fa-regular fa-trash-can"></i></button>
                                        </td>
                                    </tr>
                                    <!-- row 3 -->
                                    <tr>
                                        <th>3</th>
                                        <td>212212</td>
                                        <td>Rani</td>
                                        <td>P</td>
                                        <td>SMK Negeri 1</td>
                                        <td>X RPL 1</td>
                                        <td>9sjds92</td>
                                        <td>
                                            <button type="button" class="btn btn-edit bg-blue-custom text-white-custom"><i class="fa-regular fa-pen-to-square"></i></button>
                                            <button type="button" class="btn btn-hapus bg-red-custom text-white-custom"><i class="fa-regular fa-trash-can"></i></button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            {{-- table --}}
                            {{-- pagination --}}
                            <div class="mt-4">
                                <div class="flex flex-wrap items-center justify-between gap-3 md:gap-0">
                                    <p class="text-sm font-medium text-black-custom">Showing <span class="text-sm font-semibold">10</span> entries</p>
                                    <div class="join">
                                        <button class="join-item btn">«</button>
                                        <button class="join-item btn">Page 1</button>
                                        <button class="join-item btn">»</button>
                                    </div>
                                </div>
                            </div>
                            {{-- pagination --}}
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
        document.querySelectorAll('.btn-hapus').forEach(button => {
            button.addEventListener('click', () => {
                Swal.fire({
                    title: 'Apakah kamu yakin?',
                    text: "Data akan dihapus!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#1463ff',
                    cancelButtonColor: '#ff3b30',
                    confirmButtonText: 'Ya, Hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Ganti dengan aksi penghapusan sesuai kebutuhan
                        console.log('Data dihapus!');
                    }
                });
            });
        });

        document.querySelectorAll('.btn-edit').forEach(button => {
            button.addEventListener('click', () => {
                // Ganti dengan redirect dinamis jika perlu
                window.location.href = '/edit-peserta';
            });
        });
    </script>
    {{-- sweetalert --}}
</body>
</html>
