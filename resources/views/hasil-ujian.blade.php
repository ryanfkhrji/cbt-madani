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
                    <div class="w-auto shadow-sm card bg-white-custom dark:bg-dark-black-custom">
                        <div class="card-body">
                            <h3 class="mb-4 text-base font-medium lg:text-xl text-black-custom dark:text-white-custom">Hasil Ujian</h3>
                            <div class="flex flex-wrap items-center justify-between gap-3 mb-6 md:gap-0">
                                <select class="w-full border select border-gray-custom md:w-xs dark:text-white-custom dark:bg-dark-black-custom">
                                    <option disabled selected>Pilih Ujian</option>
                                    <option>Bahasa Indonesia Kelas X</option>
                                    <option>Bahasa Indonesia Kelas XI</option>
                                    <option>Bahasa Indonesia Kelas XII</option>
                                </select>
                                {{-- button akan muncul klo di select ujiannya --}}
                                <div class="hidden">
                                    <a href="/">
                                        <button type="button" class="bg-green-500 btn text-white-custom"><i class="fa-solid fa-file-export"></i>Export Nilai</button>
                                    </a>
                                    <a href="/">
                                        <button type="button" class="bg-yellow-500 btn text-white-custom"><i class="fa-solid fa-file-export"></i>Export Jawaban</button>
                                    </a>
                                </div>
                                {{-- button akan muncul klo di select ujiannya --}}
                            </div>
                            <div class="flex flex-wrap items-center justify-between gap-3 md:gap-0">
                                <p class="text-sm font-medium text-black-custom dark:text-white-custom">
                                    Show entries
                                    <input type="number" class="w-10 p-1 border rounded-sm border-gray-custom focus:outline-gray-custom dark:text-white-custom" placeholder="10">
                                </p>
                                <input type="text" class="block w-full px-3 py-2 text-sm border rounded-sm border-gray-custom text-black-custom md:max-w-sm focus:outline-gray-custom dark:text-white-custom" placeholder="Search..." required>
                            </div>
                            {{-- table --}}
                            <div class="mt-4 overflow-x-auto">
                                <table class="table table-zebra">
                                    <!-- head -->
                                    <thead class="bg-gray-100 text-black-custom dark:text-white-custom dark:bg-gray-900">
                                    <tr>
                                        <th>No</th>
                                        <th>No Ujian</th>
                                        <th>Nama Peserta</th>
                                        <th>Mulai</th>
                                        <th>Selesai</th>
                                        <th>Jumlah Benar</th>
                                        <th>Nilai</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <!-- row 1 -->
                                    <tr>
                                        <th>1</th>
                                        <td>123123123</td>
                                        <td>Budi</td>
                                        <td>2025-05-05 08:00:00</td>
                                        <td>2025-05-05 09:40:00</td>
                                        <td>15</td>
                                        <td>80,00</td>
                                        <td>
                                            <a href="/view-hasil-ujian">
                                                <button type="button" class="btn bg-blue-custom text-white-custom"><i class="fa-regular fa-eye"></i></button>
                                            </a>
                                        </td>
                                    </tr>
                                    <!-- row 2 -->
                                    <tr>
                                        <th>2</th>
                                        <td>123123123</td>
                                        <td>Budi</td>
                                        <td>2025-05-05 08:00:00</td>
                                        <td>2025-05-05 09:40:00</td>
                                        <td>15</td>
                                        <td>80,00</td>
                                        <td>
                                            <a href="/view-hasil-ujian">
                                                <button type="button" class="btn bg-blue-custom text-white-custom"><i class="fa-regular fa-eye"></i></button>
                                            </a>
                                        </td>
                                    </tr>
                                    <!-- row 3 -->
                                    <tr>
                                        <th>3</th>
                                        <td>123123123</td>
                                        <td>Budi</td>
                                        <td>2025-05-05 08:00:00</td>
                                        <td>2025-05-05 09:40:00</td>
                                        <td>15</td>
                                        <td>80,00</td>
                                        <td>
                                            <a href="/view-hasil-ujian">
                                                <button type="button" class="btn bg-blue-custom text-white-custom"><i class="fa-regular fa-eye"></i></button>
                                            </a>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            {{-- table --}}
                            {{-- pagination --}}
                            <div class="mt-4">
                                <div class="flex flex-wrap items-center justify-between gap-3 md:gap-0">
                                    <p class="text-sm font-medium text-black-custom dark:text-white-custom">Showing <span class="text-sm font-semibold">10</span> entries</p>
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
</body>
</html>
