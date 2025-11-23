<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CBT | Ujian</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/png" href="{{ asset('assets/logo-sekolah.png') }}">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('build/assets/app-q0VINn85.css') }}">
    <script src="{{ asset('build/assets/app-BYiNv_yN.js') }}" defer></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-50 dark:bg-dark-black-custom">
    {{-- Navbar --}}
    @include('users.navbar.navbar')

    <div class="w-full min-h-screen px-4 my-4">
        <div class="flex flex-col gap-6 lg:flex-row">
            <!-- Kartu Soal -->
            <div class="w-full p-4 bg-white rounded shadow lg:w-2/3 dark:bg-dark-black-custom" id="soal-container"></div>

            <!-- Navigasi Soal -->
            <div class="w-full p-4 bg-white rounded shadow lg:w-1/3 dark:bg-dark-black-custom">
                <div class="flex items-center justify-center pb-4 mb-4 border-b border-gray-300">
                    <button class="px-3 py-1 text-sm text-black border border-black rounded" id="current-soal-indicator">
                        1 dikerjakan
                    </button>
                </div>

                <div class="grid grid-cols-5 gap-2 mb-4" id="soal-navigation"></div>

                <button class="w-full py-2 font-semibold text-white bg-black rounded cursor-pointer"
                    type="button" id="btn-akhir-ujian">
                    Selesai Ujian
                </button>
            </div>
        </div>
    </div>

    <!-- Overlay Peringatan Keluar Tab -->
    <div id="warning-overlay"
        style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.85);color:#fff;z-index:9999;text-align:center;padding-top:15%;">
        <h2 class="mb-4 text-2xl font-bold">⚠️ Anda meninggalkan ujian!</h2>
        <p class="text-lg">Jawaban akan dikirim dalam <b id="overlay-countdown">10</b> detik.</p>
        <button id="overlay-ok"
            class="px-6 py-2 mt-6 font-semibold text-black bg-white rounded-lg hover:bg-gray-200">
            Saya masih di sini!
        </button>
    </div>

    <script>
        "use strict";

        // ================= TIMER UJIAN =================
        const serverJamOut = "{{ $jam_selesai }}";
        const now = new Date();
        const [jamOutHour, jamOutMinute] = serverJamOut.split(':').map(Number);
        const waktuBerakhir = new Date(now.getFullYear(), now.getMonth(), now.getDate(), jamOutHour, jamOutMinute, 0);

        function startTimer() {
            function updateTimer() {
                const sisa = waktuBerakhir - new Date();
                if (sisa <= 0) {
                    clearInterval(interval);
                    document.getElementById('ujian-timer').textContent = "Waktu Habis";
                    selesaiUjian();
                    return;
                }
                const jam = Math.floor(sisa / (1000 * 60 * 60));
                const menit = Math.floor((sisa % (1000 * 60 * 60)) / (1000 * 60));
                const detik = Math.floor((sisa % (1000 * 60)) / 1000);
                document.getElementById('ujian-timer').textContent =
                    `${jam.toString().padStart(2, '0')}:${menit.toString().padStart(2, '0')}:${detik.toString().padStart(2, '0')}`;
            }
            const interval = setInterval(updateTimer, 1000);
            updateTimer();
        }

        // ================= DATA SOAL =================
        const serverSoals = @json($soals);
        const idUjian = {{ $id_ujian }};
        const idSiswa = {{ auth()->user()->id }};
        let currentSoalIndex = 0;

        const dummySoals = serverSoals.map((soal) => ({
            id: soal.id,
            soal: soal.soal,
            pilihan: [soal.pilihan_1, soal.pilihan_2, soal.pilihan_3, soal.pilihan_4, soal.pilihan_5],
            jawaban: null,
            jawaban_benar: soal.jawaban_benar,
            poin: soal.poin ?? 1
        }));

        function isImage(content) {
            return /\.(jpg|jpeg|png|gif|webp|svg)$/i.test(content);
        }

        // ================= RENDER SOAL =================
        function renderSoal(index) {
            const soal = dummySoals[index];
            const key = `jawaban_ujian_${idUjian}_soal_${soal.id}`;
            const saved = sessionStorage.getItem(key);
            let selectedJawaban = saved ? JSON.parse(saved).jawaban : null;

            let optionsHtml = soal.pilihan.map((pilihan, i) => `
                <div class="flex items-center gap-3">
                    <button type="button"
                        class="option-button px-4 py-2 border rounded ${selectedJawaban === i + 1 ? 'bg-black text-white' : ''}"
                        onclick="selectOption(${index}, ${i})">
                        ${String.fromCharCode(65 + i)}
                    </button>
                    <span>${isImage(pilihan)
                        ? `<img src="/storage/${pilihan}" class="inline-block w-24 h-auto" />`
                        : pilihan}</span>
                </div>`).join('');

            return `
                <div class="flex items-center justify-between pb-4 mb-4 border-b">
                    <h2 class="text-lg font-semibold">Soal No. ${index + 1}</h2>
                    <div id="ujian-timer" class="px-3 py-1 font-bold border rounded">00:00:00</div>
                </div>
                <div class="mb-6">${isImage(soal.soal)
                    ? `<img src="/storage/${soal.soal}" class="h-auto max-w-full" />`
                    : `<p>${soal.soal}</p>`}</div>
                <div class="flex flex-col gap-3 mb-6">${optionsHtml}</div>
                <div class="flex justify-between">
                    <button onclick="navigateSoal(${index - 1})"
                        class="px-4 py-2 bg-gray-300 rounded ${index === 0 ? 'opacity-50 cursor-not-allowed' : ''}">
                        &lt; Sebelumnya
                    </button>
                    <button onclick="navigateSoal(${index + 1})"
                        id="start-fullscreen"
                        class="px-4 py-2 bg-black text-white rounded ${index === dummySoals.length - 1 ? 'hidden' : ''}">
                        Selanjutnya &gt;
                    </button>
                </div>`;
        }

        // ================= NAVIGASI & JAWABAN =================
        function loadSoal(index) {
            if (index < 0 || index >= dummySoals.length) return;
            currentSoalIndex = index;
            document.getElementById("soal-container").innerHTML = renderSoal(index);
            updateNavigation(index);
        }

        function navigateSoal(index) {
            loadSoal(index);
        }

        function updateNavigation(currentIndex) {
            const nav = document.getElementById('soal-navigation');
            nav.innerHTML = '';
            dummySoals.forEach((soal, i) => {
                const key = `jawaban_ujian_${idUjian}_soal_${soal.id}`;
                const answered = sessionStorage.getItem(key);
                const btn = document.createElement('button');
                btn.textContent = i + 1;
                btn.className = `border rounded py-1 text-sm
                    ${i === currentIndex ? 'bg-black text-white font-bold' : ''}
                    ${answered && i !== currentIndex ? 'bg-black text-white' : 'hover:bg-gray-200'}`;
                btn.onclick = () => navigateSoal(i);
                nav.appendChild(btn);
            });

            const answeredCount = dummySoals.filter((s) => {
                const key = `jawaban_ujian_${idUjian}_soal_${s.id}`;
                return sessionStorage.getItem(key);
            }).length;
            document.getElementById('current-soal-indicator').textContent = `${answeredCount} dikerjakan`;
        }

        function selectOption(index, i) {
            const soal = dummySoals[index];
            soal.jawaban = i + 1;
            const key = `jawaban_ujian_${idUjian}_soal_${soal.id}`;
            sessionStorage.setItem(key, JSON.stringify({
                id_soal: soal.id,
                jawaban: soal.jawaban
            }));

            const optionButtons = document.querySelectorAll("#soal-container .option-button");
            optionButtons.forEach((btn) => btn.classList.remove("bg-black", "text-white"));
            optionButtons[i].classList.add("bg-black", "text-white");

            simpanJawaban(soal.id, idUjian, soal.jawaban, soal.jawaban_benar);
            updateNavigation(currentSoalIndex);
        }

        // ================= SIMPAN JAWABAN =================
        function simpanJawaban(idSoal, idUjian, jawaban, jawabanBenar) {
            fetch(`{{ url('/ujian/simpan-jawaban') }}`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ id_soal: idSoal, id_ujian: idUjian, jawaban, jawaban_benar })
            }).catch(err => console.error("Gagal simpan:", err));
        }

        // ================= SELESAI UJIAN =================
        let ujianSudahSelesai = false;
        async function selesaiUjian() {
            if (ujianSudahSelesai) return;
            ujianSudahSelesai = true;
            const jawabanUser = [];
            let benar = 0, salah = 0, score = 0;
            dummySoals.forEach(soal => {
                const saved = sessionStorage.getItem(`jawaban_ujian_${idUjian}_soal_${soal.id}`);
                if (!saved) return;
                const data = JSON.parse(saved);
                const pilihan = data.jawaban;
                const benarServer = soal.jawaban_benar;
                const poin = soal.poin ?? 1;
                if (pilihan === benarServer) { benar++; score += poin; } else salah++;
                jawabanUser.push({ id_soal: soal.id, pilihan, jawaban_benar: benarServer });
            });

            const payload = { id_ujian: idUjian, id_siswa: idSiswa, jum_soal: dummySoals.length, benar, salah, score, detail: jawabanUser };

            await fetch(`{{ url('/ujian/selesai') }}`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(payload)
            });

            dummySoals.forEach(soal => sessionStorage.removeItem(`jawaban_ujian_${idUjian}_soal_${soal.id}`));
            Swal.fire({
                icon: 'success',
                title: 'Ujian Selesai!',
                text: 'Jawaban kamu berhasil disimpan.',
                confirmButtonText: 'OK',
                confirmButtonColor: '#000',
            }).then(() => window.location.href = "{{ route('siswa') }}");
        }

        // ================= DETEKSI KELUAR TAB (OVERLAY MODE) =================
        const isMobile = /Mobi|Android|iPhone|iPad/i.test(navigator.userAgent);
        let warningShown = false;
        let countdownTimer;

        function showWarningOverlay() {
            if (warningShown) return;
            warningShown = true;
            let sisa = 10;
            const overlay = document.getElementById('warning-overlay');
            const cd = document.getElementById('overlay-countdown');
            const ok = document.getElementById('overlay-ok');
            overlay.style.display = 'block';
            cd.textContent = sisa;
            countdownTimer = setInterval(() => {
                sisa--;
                cd.textContent = sisa;
                if (sisa <= 0) {
                    clearInterval(countdownTimer);
                    overlay.style.display = 'none';
                    selesaiUjian();
                }
            }, 1000);
            ok.onclick = () => {
                clearInterval(countdownTimer);
                overlay.style.display = 'none';
                warningShown = false;
            };
        }

        document.addEventListener("visibilitychange", () => {
            if (document.visibilityState === "hidden") showWarningOverlay();
        });
        window.addEventListener("blur", () => {
            if (!isMobile) showWarningOverlay();
        });

        // ================= INISIALISASI =================
        document.addEventListener('DOMContentLoaded', () => {
            loadSoal(0);
            startTimer();
            document.getElementById('btn-akhir-ujian').addEventListener('click', () => {
                Swal.fire({
                    title: 'Akhiri Ujian?',
                    text: 'Pastikan semua soal sudah dijawab.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Akhiri!',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#000',
                    cancelButtonColor: '#5C5470',
                }).then(result => {
                    if (result.isConfirmed) selesaiUjian();
                });
            });
        });
    </script>
</body>
</html>
