<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CBT | Ujian</title>
    <link rel="stylesheet" href="/fontawesome/css/all.min.css" />
    <link rel="icon" type="image/svg+xml" href="/assets/logo-sekolah.png">
    <link rel="stylesheet" href="/build/assets/app-C6BlhazT.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="/build/assets/app-w2-Mmyxk.css">
    <script src="/build/assets/app-BYiNv_yN.js" defer></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">


</head>

<body>
    {{-- navbar --}}
    @include('users.navbar.navbar')
    {{-- navbar --}}

    <div class="w-full min-h-screen px-4 my-4">
        <div class="w-full">
            <div class="flex flex-col gap-6 lg:flex-row">
                <!-- Kartu Soal -->
                <div class="w-full p-4 rounded shadow lg:w-2/3 bg-white-custom dark:bg-dark-black-custom"
                    id="soal-container">
                    <!-- Konten soal akan di-load via AJAX -->
                </div>

                <!-- Navigasi Soal -->
                <div class="w-full p-4 rounded-sm shadow lg:w-1/3 bg-white-custom dark:bg-dark-black-custom">
                    <div class="flex items-center justify-center pb-4 mb-4 border-b border-gray-custom">
                        <button class="px-3 py-1 text-sm text-white bg-blue-600 rounded" id="current-soal-indicator">
                            1 dikerjakan
                        </button>
                    </div>
                    <div class="grid grid-cols-5 gap-2 mb-4" id="soal-navigation">
                        <!-- Tombol navigasi akan di-generate oleh JavaScript -->
                    </div>
                    <button class="w-full py-2 font-semibold text-white rounded cursor-pointer bg-red-custom"
                        onclick="my_modal_1.showModal()">
                        Akhiri Ujian
                    </button>
                </div>
            </div>
        </div>
    </div>

    <dialog id="my_modal_1" class="modal">
        <div class="modal-box">
            <p class="py-4 text-black-custom dark:text-white-custom">Setelah mengakhiri ujian tidak dapat kembali ke
                ujian ini
                lagi. Yakin akan mengakhiri ujian?</p>
            <div class="modal-action">
                <form method="dialog">
                    <button id="btn-selesai-ujian" class="btn bg-green-custom text-white-custom">
                        Yakin
                    </button>
                    <button class="btn bg-red-custom text-white-custom">
                        Batal
                    </button>
                </form>
            </div>
        </div>

    </dialog>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        const serverJamIn = "{{ $jam_mulai }}"; // contoh: "08:00"
        const serverJamOut = "{{ $jam_selesai }}"; // contoh: "09:00"
        console.log(serverJamIn)

        const now = new Date(); // waktu saat ini di browser
        const [jamOutHour, jamOutMinute] = serverJamOut.split(':').map(Number);

        const waktuBerakhir = new Date(
            now.getFullYear(),
            now.getMonth(),
            now.getDate(),
            jamOutHour,
            jamOutMinute,
            0
        );

        let countdownInterval;

        function startTimer() {
            function updateTimer() {
                const now = new Date();
                const selisih = waktuBerakhir - now;

                if (selisih <= 0) {
                    clearInterval(countdownInterval);
                    document.getElementById('ujian-timer').textContent = "Waktu Habis";
                    my_modal_1.showModal(); // panggil modal selesai
                    return;
                }

                const jam = Math.floor(selisih / (1000 * 60 * 60));
                const menit = Math.floor((selisih % (1000 * 60 * 60)) / (1000 * 60));
                const detik = Math.floor((selisih % (1000 * 60)) / 1000);

                document.getElementById('ujian-timer').textContent =
                    `${jam.toString().padStart(2, '0')}:${menit.toString().padStart(2, '0')}:${detik.toString().padStart(2, '0')}`;
            }

            updateTimer(); // jalankan langsung
            countdownInterval = setInterval(updateTimer, 1000); // tiap detik
        }

        document.addEventListener('DOMContentLoaded', function() {
            loadSoal(0);
            startTimer(); // mulai timer
        });
    </script>

    <script>
        // Dummy data soal
        const serverSoals = @json($soals);

        const dummySoals = serverSoals.map((soal) => ({
            id: soal.id,
            soal: soal.soal,
            pilihan: [
                soal.pilihan_1,
                soal.pilihan_2,
                soal.pilihan_3,
                soal.pilihan_4,
            ],
            jawaban: null,
            jawaban_benar: soal.jawaban_benar, // ✅ ini yang penting
            poin: soal.poin ?? 1 // ✅ ini juga pastikan ikut
        }));

        // Variabel state
        let currentSoalIndex = 0;
        const totalSoal = dummySoals.length;

        // Fungsi untuk render soal
        function isImage(content) {
            return /\.(jpg|jpeg|png|gif|webp|svg)$/i.test(content);
        }

        function renderSoal(index) {
            const soal = dummySoals[index];

            // ✅ Ambil jawaban dari sessionStorage kalau ada
            const key = `jawaban_ujian_${idUjian}_soal_${soal.id}`;
            const saved = sessionStorage.getItem(key);
            let selectedJawaban = null;
            console.log(key)

            if (saved) {
                try {
                    const parsed = JSON.parse(saved);
                    selectedJawaban = parsed.jawaban;
                } catch (e) {
                    console.warn("Gagal parse jawaban dari sessionStorage:", e);
                }
            }

            let optionsHtml = '';

            soal.pilihan.forEach((pilihan, i) => {
                const isSelected = selectedJawaban === i + 1;
                optionsHtml += `
                            <div class="flex items-center justify-start gap-3">
                                <button type="button"
                                    class="px-4 py-2 cursor-pointer border border-blue-custom rounded-sm
                                        hover:bg-blue-100 focus:bg-blue-custom
                                        dark:hover:bg-gray-600
                                        ${isSelected ? 'bg-blue-500 text-white dark:bg-white dark:text-black' : 'dark:text-white'}"
                                    onclick="selectOption(${index}, ${i})">
                                    <span class="font-bold">${String.fromCharCode(65 + i)}</span>
                                </button>
                                <span class="text-base text-black-custom dark:text-white-custom">
                                    ${isImage(pilihan)
                                        ? `<img src="/storage/${pilihan}" alt="Pilihan ${i + 1}" class="inline-block w-24 h-auto" />`
                                        : pilihan}
                                </span>
                            </div>
                        `;
            });

            return `
                        <div class="flex items-center justify-between pb-4 mb-4 border-b border-gray-custom">
                            <h2 class="text-lg font-semibold">Soal No. ${index + 1}</h2>
                            <div id="ujian-timer" class="px-3 py-1 text-sm font-bold text-white bg-blue-500 rounded">
                                00:00:00
                            </div>
                        </div>
                        <div class="mb-6 text-lg text-black-custom dark:text-white-custom">
                            ${isImage(soal.soal)
                                ? `<img src="/storage/soal_images/${soal.soal}" alt="Soal" class="h-auto max-w-full" />`
                                : `<p>${soal.soal}</p>`}
                        </div>
                        <div class="flex flex-col items-start mb-6 gap-y-3">
                            ${optionsHtml}
                        </div>
                        <div class="flex justify-between">
                            <button onclick="navigateSoal(${index - 1})"
                                class="bg-light-blue-custom cursor-pointer text-blue-700 px-4 py-2 rounded text-sm dark:bg-gray-400 dark:text-white-custom ${index === 0 ? 'opacity-50 cursor-not-allowed' : ''}">
                                &lt; Sebelumnya
                            </button>
                            <button onclick="navigateSoal(${index + 1})"
                                class="bg-blue-custom text-white cursor-pointer px-4 py-2 rounded-sm text-sm ${index === totalSoal - 1 ? 'hidden' : ''}">
                                Selanjutnya &gt;
                            </button>
                            <button onclick="my_modal_1.showModal()"
                                class="bg-blue-custom text-white cursor-pointer px-4 py-2 rounded-sm text-sm ${index === totalSoal - 1 ? '' : 'hidden'}">
                                Selesai
                            </button>
                        </div>
                    `;
        }

        function selectOption(soalIndex, optionIndex) {
            // ✅ Simpan pilihan ke dummySoals
            dummySoals[soalIndex].jawaban = optionIndex;

            // ✅ Re-render tampilan soal secara langsung (real-time)
            loadSoal(soalIndex);
            updateAnsweredIndicator();

            const soal = dummySoals[soalIndex];

            // ✅ Simpan jawaban ke sessionStorage
            const key = `jawaban_ujian_${idUjian}_soal_${soal.id}`;
            const value = JSON.stringify({
                id_soal: soal.id,
                id_ujian: idUjian,
                jawaban: optionIndex + 1 // disimpan dari 0 (karena untuk render ulang)
            });
            sessionStorage.setItem(key, value);

            // ✅ Kirim ke server (optional)
            const jawabanUser = optionIndex + 1; // karena di server bisa pakai 1–5
            const jawabanBenar = soal.jawaban_benar; // misalnya 1–5 juga
            simpanJawaban(soal.id, idUjian, jawabanUser, jawabanBenar);
        }

        // Fungsi untuk navigasi soal
        function navigateSoal(newIndex) {
            if (newIndex >= 0 && newIndex < totalSoal) {
                currentSoalIndex = newIndex;
                loadSoal(currentSoalIndex);
            }
        }

        // Fungsi untuk load soal
        function loadSoal(index) {
            const soal = dummySoals[index];

            // ✅ Ambil dari sessionStorage dulu
            const key = `jawaban_ujian_${idUjian}_soal_${soal.id}`;
            const saved = sessionStorage.getItem(key);
            if (saved) {
                try {
                    const parsed = JSON.parse(saved);
                    dummySoals[index].jawaban = parsed.jawaban;
                } catch (e) {
                    console.warn("Gagal parsing jawaban dari sessionStorage", e);
                }
            }
            document.getElementById('soal-container').innerHTML = renderSoal(index);
            updateNavigation(index);
        }

        // Fungsi untuk update navigasi
        function updateNavigation(currentIndex) {
            // Update current soal indicator
            document.getElementById('current-soal-indicator').textContent = `${currentIndex + 1} dikerjakan`;

            // Update tombol navigasi
            const navContainer = document.getElementById('soal-navigation');
            navContainer.innerHTML = '';

            for (let i = 0; i < totalSoal; i++) {
                const btn = document.createElement('button');
                btn.className = `soal-nav-btn border border-blue-custom rounded text-sm py-1 text-center ${
                    i === currentIndex ? 'bg-blue-500 text-white font-bold' :
                    (dummySoals[i].jawaban !== null ? 'bg-green-100 dark:bg-gray-600' : 'hover:bg-blue-100')
                }`;
                btn.textContent = i + 1;
                btn.onclick = () => navigateSoal(i);
                navContainer.appendChild(btn);
            }
        }

        function updateAnsweredIndicator() {
            dummySoals.forEach((soal, index) => {
                const btn = document.getElementById(`soal-btn-${index}`);
                if (!btn) return;

                const key = `jawaban_ujian_${idUjian}_soal_${soal.id}`;
                const saved = sessionStorage.getItem(key);

                if (saved) {
                    btn.classList.add('bg-green-500', 'text-white');
                    btn.classList.remove('bg-gray-200', 'text-black');
                } else {
                    btn.classList.remove('bg-green-500', 'text-white');
                    btn.classList.add('bg-gray-200', 'text-black');
                }
            });
        }

        // Inisialisasi
        document.addEventListener('DOMContentLoaded', function() {
            // Generate tombol navigasi
            loadSoal(0);
            updateAnsweredIndicator()
        });
    </script>

    <script>
        const idUjian = {{ $id_ujian }};

        function simpanJawaban(idSoal, idUjian, jawaban, jawabanBenar) {
            $.ajax({
                url: "{{ route('ujian.simpan-jawaban') }}",
                type: "POST",
                data: {
                    id_soal: idSoal,
                    id_ujian: idUjian,
                    jawaban: jawaban,
                    jawaban_benar: jawabanBenar,
                    _token: $('meta[name="csrf-token"]').attr('content') // ✅ CSRF wajib
                },
                success: function(response) {
                    if (response.success) {
                        console.log("✅ Jawaban tersimpan.");

                        // ✅ Simpan ke sessionStorage
                        const key = `jawaban_ujian_${idUjian}_soal_${idSoal}`;
                        const value = JSON.stringify({
                            id_soal: idSoal,
                            id_ujian: idUjian,
                            jawaban: jawaban,
                            jawaban_benar: jawabanBenar
                        });
                        sessionStorage.setItem(key, value);
                    } else {
                        console.warn("⚠️ Gagal simpan:", response);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("❌ Server error:", xhr.responseText);
                }
            });
        }
    </script>

    <script>
        const idSiswa = {{ auth()->user()->id }};
        $('#btn-selesai-ujian').on('click', function() {
            Swal.fire({
                title: 'Menyimpan jawaban...',
                html: 'Mohon tunggu sebentar.',
                didOpen: () => Swal.showLoading(),
                allowOutsideClick: false
            });

            const jawabanUser = [];
            let benar = 0;
            let salah = 0;
            let scoreTotal = 0;

            dummySoals.forEach((soal, index) => {
                const key = `jawaban_ujian_${idUjian}_soal_${soal.id}`;
                const saved = sessionStorage.getItem(key);

                if (saved) {
                    try {
                        const parsed = JSON.parse(saved);
                        const pilihan = parsed.jawaban + 1;
                        const benarServer = soal.jawaban_benar;
                        const skor = soal.poin ? parseInt(soal.poin) : 1;

                        const isBenar = pilihan === benarServer;

                        if (isBenar) {
                            benar++;
                            scoreTotal += skor;
                        } else {
                            salah++;
                        }

                        jawabanUser.push({
                            id_soal: soal.id,
                            pilihan: pilihan,
                            jawaban_benar: benarServer ?? 0
                        });
                    } catch (e) {
                        console.warn("Parse error:", e);
                    }
                }
            });

            const payload = {
                id_ujian: idUjian,
                id_siswa: idSiswa,
                jum_soal: dummySoals.length,
                benar: benar,
                salah: salah,
                score: scoreTotal,
                detail: jawabanUser,
            };

            $.ajax({
                url: "{{ route('ujian.selesai') }}",
                type: "POST",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'), // ✅ CSRF wajib
                    data: payload
                },
                success: function(res) {
                    // ✅ Hapus sessionStorage jawaban ujian
                    dummySoals.forEach((soal) => {
                        const key = `jawaban_ujian_${idUjian}_soal_${soal.id}`;
                        sessionStorage.removeItem(key);
                    });
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Jawaban kamu berhasil disimpan.',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href = "{{ route('siswa') }}";
                    });
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Terjadi kesalahan saat menyimpan.'
                    });
                }
            });
        });
    </script>

</body>

</html>
