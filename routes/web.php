<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StartControler;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\StartController;
use App\Http\Controllers\UjianController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Export\ExportUjianController;
use App\Http\Controllers\JawabUjianController;
use App\Http\Controllers\MasterGuruController;
use App\Http\Controllers\MasterSoalController;
use App\Http\Controllers\MasterDraftController;
use App\Http\Controllers\MasterKelasController;
use App\Http\Controllers\MasterMapelController;
use App\Http\Controllers\MasterSiswaController;
use App\Http\Controllers\MasterUjianController;
use App\Http\Controllers\Siswa\SiswaController;
use App\Http\Controllers\MasterJadwalController;
use App\Http\Controllers\MasterJurusanController;

// admin
Route::get('/login', [LoginController::class, 'index'])->name('login-siswa')->middleware('guest');
Route::get('/login/admin', [LoginController::class, 'admin'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'actionLogin'])->name('login.action');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::put('/updateProfile/{id}', [DashboardController::class, 'updateProfile'])->name('update.profile');

    Route::resource('master_jurusan', MasterJurusanController::class);
    Route::resource('master_kelas', MasterKelasController::class);

    //master siswa
    Route::resource('master_siswa', MasterSiswaController::class);
    Route::get('import-siswa',[MasterSiswaController::class,'viewImport']);
    Route::get('template-siswa',[MasterSiswaController::class,'exportTemplate'])->name('siswa.template');
    Route::post('import_siswa',[MasterSiswaController::class,'import'])->name('siswa.import');

    Route::resource('master_guru', MasterGuruController::class);
    Route::resource('master_mapel', MasterMapelController::class);
    Route::resource('master_ujian', MasterUjianController::class);

    //master soal
    Route::resource('master_soal', MasterSoalController::class);
    Route::get('template-soal',[MasterSoalController::class,'exportTemplate'])->name('soal.template');
    Route::get('view-import-soal',[MasterSoalController::class,'viewImport'])->name('import.view.soal');
    Route::post('import-soal',[MasterSoalController::class,'import'])->name('soal.import');
    Route::get('master_soal/{id}/addSoal', [MasterSoalController::class, 'createAll'])->name('createAll');
    Route::post('master_soal/add_soal', [MasterSoalController::class, 'storeAllExamp'])->name('master_soal.store-all');
    Route::post('master_soal/storeSoal', [MasterSoalController::class, 'storeSoal'])->name('master_soal.store-soal');
    Route::get('/get-siswa-by-kelas', [MasterDraftController::class, 'getByKelas'])->name('get-siswa-by-kelas');
    // hapus soal
    Route::post('master_soal/delete-all', [MasterSoalController::class, 'deleteAll'])->name('master_soal.deleteAll');


    Route::resource('master_draft', MasterDraftController::class);
    Route::delete('master_draftDestroy/{id}',[MasterDraftController::class,'destroyDraft'])->name('master_draft.destroyDraft');
    Route::resource('master_jadwal', MasterJadwalController::class);

    // route hasil ujian
    Route::get('hasil-ujian',[ExportUjianController::class,'index'])->name('hasil.ujian');
    Route::get('detail/{id}/ujian',[ExportUjianController::class,'detail'])->name('detail.hasil.ujian');
    Route::get('ulang-ujian/{id}',[ExportUjianController::class,'ulangUjian'])->name('ulang.ujian');
    Route::get('export-ujian', [ExportUjianController::class, 'exportExcel'])->name('export.ujian');
});

// cetak kartu
Route::get('/siswa/cetak-kartu', [MasterSiswaController::class, 'cetakKartu'])->name('siswa.cetak-kartu');

Route::middleware(['auth'])->group(function () {
    Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa');
    Route::get('/detail-ujian/{id}', [SiswaController::class, 'detail'])->name('detail.ujian');
    Route::get('/mulai-ujian/{id}/{idJadwal}', [SiswaController::class, 'mulaiUjian'])->name('mulai.ujian');
    Route::post('/ujian/simpan-jawaban', [JawabUjianController::class, 'simpanJawaban'])->name('ujian.simpan-jawaban');
    Route::post('/ujian/selesai', [UjianController::class, 'selesaikanUjian'])->name('ujian.selesai');

});



Route::get('/data-ujian', function () {
    return view('data-ujian');
});

Route::get('/tambah-ujian', function () {
    return view('tambah-ujian');
});

Route::get('/edit-ujian', function () {
    return view('edit-ujian');
});

Route::get('/data-soal', function () {
    return view('data-soal');
});

Route::get('/tambah-soal', function () {
    return view('tambah-soal');
});

Route::get('/edit-soal', function () {
    return view('edit-soal');
});

Route::get('/import-soal', function () {
    return view('import-soal');
});

Route::get('/data-sesi', function () {
    return view('data-sesi');
});

Route::get('/tambah-sesi', function () {
    return view('tambah-sesi');
});

Route::get('/edit-sesi', function () {
    return view('edit-sesi');
});

Route::get('/data-peserta', function () {
    return view('data-peserta');
});

Route::get('/tambah-peserta', function () {
    return view('tambah-peserta');
});

Route::get('/edit-peserta', function () {
    return view('edit-peserta');
});

Route::get('/import-peserta', function () {
    return view('import-peserta');
});

Route::get('/cetak-kartu', function () {
    return view('cetak-kartu');
});

Route::get('/peserta-per-sesi', function () {
    return view('peserta-per-sesi');
});

Route::get('/tambah-peserta-per-sesi', function () {
    return view('tambah-peserta-per-sesi');
});

// Route::get('/hasil-ujian', function () {
//     return view('hasil-ujian');
// });

// Route::get('/view-hasil-ujian', function () {
//     return view('view-hasil-ujian');
// });

// peserta
Route::get('/login-peserta', function () {
    return view('users.login-peserta');
})->middleware('guest');

Route::get('/daftar-ujian-peserta', function () {
    return view('users.index-peserta');
});

Route::get('/detail-ujian', function () {
    return view('users.detail-ujian');
});

Route::get('/ujian', function () {
    return view('users.ujian');
});

Route::get('/detail-ujian-selesai', function () {
    return view('users.detail-ujian-selesai');
});

Route::get('/daftar-ujian', function () {
    return view('users.daftar-ujian');
});

Route::get('/create-soal', function () {
    return view('create-soal');
});
