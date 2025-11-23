<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CBT | Siswa</title>
    <!-- fontawesome -->
    <link rel="stylesheet" href="/fontawesome/css/all.min.css" />

    <!-- favicon -->
    <link rel="icon" type="image/svg+xml" href="/assets/logo-sekolah.png">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="/build/assets/app-DnkhhTks.css">
    <script src="/build/assets/app-BYiNv_yN.js" defer></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="dark">
    {{-- navbar --}}
    <div class="w-full">
        @include('users.navbar.navbar')
    </div>
    {{-- navbar --}}
    <div class="drawer lg:drawer-open">

        {{-- content --}}
        <div class="drawer-content">
            @yield('content-user')

            {{-- footer --}}
            @include('components.footer.footer')
        </div>
        {{-- content --}}
    </div>
    @vite(['resources/js/app.js'])

    @stack('scripts')

</body>

</html>
