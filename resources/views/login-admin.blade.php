<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login - ECP</title>
    <!-- fontawesome -->
    <link rel="stylesheet" href="/fontawesome/css/all.min.css" />

    <!-- favicon -->
    <link rel="icon" type="image/svg+xml" href="/assets/logo-sekolah.png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="/build/assets/app-DnkhhTks.css">
    <script src="/build/assets/app-BYiNv_yN.js" defer></script>
</head>

<body class="relative">
    <div class="flex flex-col items-center justify-center w-full min-h-screen px-4 hero dark dark:bg-black-custom">
        <div class="z-50 w-full shadow-sm card md:w-md bg-base-100 dark:bg-dark-black-custom dark:shadow-gray-800">
            @if ($errors->any())
                <div class="mb-4 shadow-lg alert alert-error">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 w-6 h-6 stroke-current"
                            fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01M12 2a10 10 0 100 20 10 10 0 000-20z" />
                        </svg>
                        <span>{{ $errors->first() }}</span>
                    </div>
                </div>
            @endif

            <form action="{{ route('login.action') }}" method="POST">
                @csrf
                <div class="card-body">
                    <img src="{{ asset('assets/logo-sekolah.png') }}" alt="logo-sekolah" class="w-32 mx-auto mb-4">
                    <h2 class="text-2xl font-bold text-center text-black-custom dark:text-white-custom">Login Admin</h2>
                    <div class="mt-6">
                        <label for="username"
                            class="block mb-3 text-sm font-medium text-black-custom dark:text-white-custom">Username</label>
                        <input
                            class="block w-full px-2 py-3 text-sm border rounded-lg border-gray-custom text-black-custom focus:outline-gray-custom dark:text-gray-custom"
                            type="text" name="username" id="username" placeholder="Username" required
                            value="{{ old('username') }}">
                        </label>
                    </div>
                    <div class="mt-4">
                        <label for="password"
                            class="block mb-3 text-sm font-medium text-black-custom dark:text-white-custom">Password</label>
                        <div class="relative w-full md:max-w-md">
                            <input
                                type="password"class="block w-full px-4 py-3 pr-10 text-sm font-medium border rounded-lg border-gray-custom text-black-custom focus:outline-gray-custom dark:text-gray-custom"
                                name="password" id="password" placeholder="Password" required>
                            <i class="absolute transform -translate-y-1/2 cursor-pointer fa-regular fa-eye-slash right-3 top-1/2 text-black-custom dark:text-gray-custom"
                                id="togglePassword"></i>
                        </div>
                    </div>
                    <div class="mt-6">

                        {{-- <button type="submit"
                            class="w-full rounded-md btn bg-blue-custom text-white-custom">LOGIN</button> --}}
                        <button type="submit"
                            class="flex items-center justify-center w-full bg-black rounded-md btn text-white-custom"
                            id="login-button">
                            <span class="hidden mr-2 spinner loading loading-spinner loading-sm"></span>
                            <span class="btn-text">LOGIN</span>
                        </button>
                    </div>
                </div>
            </form>

        </div>
        <div class="absolute bottom-0 w-full text-center">
            @include('components.footer.footer')
        </div>
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

    {{-- Loading --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form'); // pastikan ini form login
            const loginBtn = document.getElementById('login-button');
            const spinner = loginBtn.querySelector('.spinner');
            const btnText = loginBtn.querySelector('.btn-text');

            form.addEventListener('submit', function() {
                loginBtn.disabled = true;
                spinner.classList.remove('hidden');
                btnText.classList.add('hidden');
            });
        });
    </script>

</body>

</html>
