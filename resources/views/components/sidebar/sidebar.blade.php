@php
    use Illuminate\Support\Facades\Request;
@endphp

<ul class="w-56 min-h-screen p-4 menu bg-white-custom dark:bg-dark-black-custom">
    <div class="flex flex-col items-center gap-2 mb-4">
        <a>
            <img src="{{ asset('assets/logo-sekolah.png') }}" alt="Foto Profil"
                class="object-cover w-16 h-16 rounded-full">
        </a>
        <a class="font-bold text-md md:text-lg text-black-custom dark:text-white-custom">MADANI DEPOK</a>
    </div>

    <div class="flex flex-col">
        <!-- Dashboard -->
        <li class="rounded-sm sidebar-link">
            <a href="/"
                class="py-4 text-sm font-semibold md:text-md
                {{ Request::is('/') ? 'bg-black text-white' : 'text-black-custom dark:text-white-custom' }}">
                <i class="fa-solid fa-chart-line"></i> Dashboard
            </a>
        </li>

        <!-- Jurusan -->
        <li class="rounded-sm sidebar-link">
            <a href="{{ route('master_jurusan.index') }}"
                class="py-4 text-sm font-semibold md:text-md
                {{ Request::is('master_jurusan*') ? 'bg-black text-white' : 'text-black-custom dark:text-white-custom' }}">
                <i class="fas fa-building-columns"></i> Jurusan
            </a>
        </li>

        <!-- Kelas -->
        <li class="rounded-sm sidebar-link">
            <a href="{{ route('master_kelas.index') }}"
                class="py-4 text-sm font-semibold md:text-md
                {{ Request::is('master_kelas*') ? 'bg-black text-white' : 'text-black-custom dark:text-white-custom' }}">
                <i class="fas fa-door-open"></i> Kelas
            </a>
        </li>

        <!-- Siswa -->
        <li class="rounded-sm sidebar-link">
            <a href="{{ route('master_siswa.index') }}"
                class="py-4 text-sm font-semibold md:text-md
                {{ Request::is('master_siswa*') ? 'bg-black text-white' : 'text-black-custom dark:text-white-custom' }}">
                <i class="fas fa-user-graduate"></i> Siswa
            </a>
        </li>

        <!-- Guru -->
        <li class="rounded-sm sidebar-link">
            <a href="{{ route('master_guru.index') }}"
                class="py-4 text-sm font-semibold md:text-md
                {{ Request::is('master_guru*') ? 'bg-black text-white' : 'text-black-custom dark:text-white-custom' }}">
                <i class="fas fa-chalkboard-teacher"></i> Guru
            </a>
        </li>

        <!-- Mata Pelajaran -->
        <li class="rounded-sm sidebar-link">
            <a href="{{ route('master_mapel.index') }}"
                class="py-4 text-sm font-semibold md:text-md
                {{ Request::is('master_mapel*') ? 'bg-black text-white' : 'text-black-custom dark:text-white-custom' }}">
                <i class="fas fa-book"></i> Mata Pelajaran
            </a>
        </li>

        <!-- Ujian -->
        <li class="rounded-sm sidebar-link">
            <a href="{{ route('master_ujian.index') }}"
                class="py-4 text-sm font-semibold md:text-md
                {{ Request::is('master_ujian*') ? 'bg-black text-white' : 'text-black-custom dark:text-white-custom' }}">
                <i class="fas fa-clipboard-check"></i> Ujian
            </a>
        </li>

        <!-- Soal Ujian -->
        <li class="rounded-sm sidebar-link">
            <a href="{{ route('master_soal.index') }}"
                class="py-4 text-sm font-semibold md:text-md
                {{ Request::is('master_soal*') ? 'bg-black text-white' : 'text-black-custom dark:text-white-custom' }}">
                <i class="fas fa-file-alt"></i> Soal Ujian
            </a>
        </li>

        <!-- Sesi Ujian -->
        <li class="rounded-sm sidebar-link">
            <a href="{{ route('master_draft.index') }}"
                class="py-4 text-sm font-semibold md:text-md
                {{ Request::is('master_draft*') ? 'bg-black text-white' : 'text-black-custom dark:text-white-custom' }}">
                <i class="fas fa-clock"></i> Sesi Ujian
            </a>
        </li>

        <!-- Jadwal Ujian -->
        <li class="rounded-sm sidebar-link">
            <a href="{{ route('master_jadwal.index') }}"
                class="py-4 text-sm font-semibold md:text-md
                {{ Request::is('master_jadwal*') ? 'bg-black text-white' : 'text-black-custom dark:text-white-custom' }}">
                <i class="fas fa-calendar-alt"></i> Jadwal Ujian
            </a>
        </li>

        <!-- Hasil Ujian -->
        <li class="rounded-sm sidebar-link">
            <a href="/hasil-ujian"
                class="py-4 text-sm font-semibold md:text-md
                {{ Request::is('hasil-ujian*') ? 'bg-black text-white' : 'text-black-custom dark:text-white-custom' }}">
                <i class="fas fa-poll"></i> Hasil Ujian
            </a>
        </li>
    </div>
</ul>
