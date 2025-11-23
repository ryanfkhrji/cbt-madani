@extends('layouts.admin')
@section('content-admin')
    <div class="min-h-screen p-4 mt-16">
        {{-- Bagian Card --}}
        <div class="grid grid-cols-1 gap-4 lg:grid-cols-4 md:grid-cols-3">
            {{-- card --}}
            <div class="w-auto shadow-sm card bg-white-custom dark:bg-dark-black-custom">
                <div class="card-body">
                    <div class="flex items-center justify-between">
                        <div class="flex flex-col gap-3">
                            <h3 class="text-base font-semibold lg:text-xl text-gray-custom">
                                Data Ujian
                            </h3>
                            <h1 class="text-4xl font-semibold lg:text-5xl text-black-custom dark:text-white-custom">
                                {{ $ujianCount }}</h1>
                        </div>
                        <div
                            class="flex items-center justify-center w-16 h-16 text-3xl text-gray-700 bg-gray-200 rounded-full">
                            <i class="fa-solid fa-book"></i>
                        </div>
                    </div>
                </div>
            </div>
            {{-- card --}}
            {{-- card --}}
            <div class="w-auto shadow-sm card bg-white-custom dark:bg-dark-black-custom">
                <div class="card-body">
                    <div class="flex items-center justify-between">
                        <div class="flex flex-col gap-3">
                            <h3 class="text-base font-semibold lg:text-xl text-gray-custom">
                                Data Soal
                            </h3>
                            <h1 class="text-4xl font-semibold lg:text-5xl text-black-custom dark:text-white-custom">
                                {{ $soalCount }}</h1>
                        </div>
                        <div
                            class="flex items-center justify-center w-16 h-16 text-3xl text-gray-700 bg-gray-200 rounded-full">
                            <i class="fa-regular fa-file-lines"></i>
                        </div>
                    </div>
                </div>
            </div>
            {{-- card --}}
            {{-- card --}}
            <div class="w-auto shadow-sm card bg-white-custom dark:bg-dark-black-custom">
                <div class="card-body">
                    <div class="flex items-center justify-between">
                        <div class="flex flex-col gap-3">
                            <h3 class="text-base font-semibold lg:text-xl text-gray-custom">
                                Data Jadwal
                            </h3>
                            <h1 class="text-4xl font-semibold lg:text-5xl text-black-custom dark:text-white-custom">
                                {{ $jadwalCount }}</h1>
                        </div>
                        <div
                            class="flex items-center justify-center w-16 h-16 text-3xl text-gray-700 bg-gray-200 rounded-full">
                            <i class="fa-regular fa-clock"></i>
                        </div>
                    </div>
                </div>
            </div>
            {{-- card --}}
            {{-- card --}}
            <div class="w-auto shadow-sm card bg-white-custom dark:bg-dark-black-custom">
                <div class="card-body">
                    <div class="flex items-center justify-between">
                        <div class="flex flex-col gap-3">
                            <h3 class="text-base font-semibold lg:text-xl text-gray-custom">
                                Data Siswa
                            </h3>
                            <h1 class="text-4xl font-semibold lg:text-5xl text-black-custom dark:text-white-custom">
                                {{ $siswaCount }}</h1>
                        </div>
                        <div
                            class="flex items-center justify-center w-16 h-16 text-3xl text-gray-700 bg-gray-200 rounded-full">
                            <i class="fa-regular fa-user"></i>
                        </div>
                    </div>
                </div>
            </div>
            {{-- card --}}
        </div>
        {{-- Bagian Card --}}

        {{-- Bagian Chart Nilai --}}
        {{-- <div class="grid grid-cols-1 mt-5">
            <div class="w-auto shadow-sm card bg-white-custom dark:bg-dark-black-custom">
                <div class="card-body">
                    <h3 class="text-base font-semibold lg:text-xl text-black-custom dark:text-white-custom">
                        Hasil Nilai Ujian</h3>
                    <canvas id="myChart"></canvas>
                </div>
            </div>
        </div> --}}
        {{-- Bagian Chart Nilai --}}
    </div>

    {{-- @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('myChart');

            const labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'];

            const data = {
                labels: labels,
                datasets: [{
                    label: 'My First Dataset',
                    data: [65, 59, 80, 81, 56, 55, 40],
                    fill: false,
                    borderColor: 'rgb(20, 99, 255)',
                    tension: 0.1
                }]
            };

            const config = {
                type: 'line',
                data: data,
            };

            new Chart(ctx, config);
        </script>
    @endpush --}}
@endsection
