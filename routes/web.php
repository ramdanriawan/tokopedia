<?php

use App\Models\User;
use App\Models\Berita;
use App\Models\Disposisi;
use App\Models\Rekrutmen;
use App\Models\UnitKerja;
use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use App\Http\Livewire\Jabatan\Index;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\LoginController;

Route::get('/', ['App\Http\Controllers\TokopediaController', 'index']);

// Route::get('/', function () {
//     $data['berita'] = Berita::limit(12)->get()->reverse();

//     return view('index', $data);
// });

Route::get('home/berita/{berita}', function(Berita $berita) {

    $data["item"]   = $berita;
    $data["berita"] = $berita;

    return view('berita', $data);
})->name('home.berita.show');

Route::get('/auth/redirect', function () {

    return Socialite::driver('github')->redirect();
});

Route::get('/auth/callback', function () {
    $user = Socialite::driver('github')->user();

    //  // All providers...
    //  $user->getId();
    //  $user->getNickname();
    //  $user->getName();
    //  $user->getEmail();
    //  $user->getAvatar();
});

Route::get('/debug-sentry', function () { 
    throw new Exception('My first Sentry error!');
});

Route::post('login_manual', [LoginController::class, 'authenticate'])->name('login_manual');

Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    Route::get('/dashboard', function () {
        $data['disposisis']    = Disposisi::all();
        $data['rekrutmens']    = Rekrutmen::all();
        $data['surat_keluars'] = SuratKeluar::all();
        $data['surat_masuks']  = SuratMasuk::all();
        $data['unit_kerjas']   = UnitKerja::all();
        $data['users']         = User::all();

        return view('dashboard', $data);

    })->name('dashboard');

    Route::get('jabatanx', Index::class)->name('jabatan.index');

    Route::get('user/profile', [UserController::class, 'profile'])->name('user.profile');

    Route::post('bagian/laporan/print', ['App\Http\Controllers\BagianController', 'print'])->name('bagian.print');
    Route::get('bagian/laporan', ['App\Http\Controllers\BagianController', 'laporan'])->name('bagian.laporan.index');
    Route::get('bagian/hapus_semua', ['App\Http\Controllers\BagianController', 'hapus_semua'])->name('bagian.hapus_semua');
    Route::resource('bagian', 'App\Http\Controllers\BagianController')->parameters(['bagian' => 'bagian']);

    Route::post('disposisi/laporan/print', ['App\Http\Controllers\DisposisiController', 'print'])->name('disposisi.print');
    Route::get('disposisi/laporan', ['App\Http\Controllers\DisposisiController', 'laporan'])->name('disposisi.laporan.index');
    Route::get('disposisi/hapus_semua', ['App\Http\Controllers\DisposisiController', 'hapus_semua'])->name('disposisi.hapus_semua');
    Route::resource('disposisi', 'App\Http\Controllers\DisposisiController')->parameters(['disposisi' => 'disposisi']);

    Route::post('jabatan/laporan/print', ['App\Http\Controllers\JabatanController', 'print'])->name('jabatan.print');
    Route::get('jabatan/laporan', ['App\Http\Controllers\JabatanController', 'laporan'])->name('jabatan.laporan.index');
    Route::get('jabatan/hapus_semua', ['App\Http\Controllers\JabatanController', 'hapus_semua'])->name('jabatan.hapus_semua');
    Route::resource('jabatan', 'App\Http\Controllers\JabatanController')->parameters(['jabatan' => 'jabatan']);

    Route::post('rekrutmen/laporan/print', ['App\Http\Controllers\RekrutmenController', 'print'])->name('rekrutmen.print');
    Route::get('rekrutmen/laporan', ['App\Http\Controllers\RekrutmenController', 'laporan'])->name('rekrutmen.laporan.index');
    Route::get('rekrutmen/hapus_semua', ['App\Http\Controllers\RekrutmenController', 'hapus_semua'])->name('rekrutmen.hapus_semua');
    Route::resource('rekrutmen', 'App\Http\Controllers\RekrutmenController')->parameters(['rekrutmen' => 'rekrutmen']);

    Route::post('sifat_surat/laporan/print', ['App\Http\Controllers\SifatSuratController', 'print'])->name('sifat_surat.print');
    Route::get('sifat_surat/laporan', ['App\Http\Controllers\SifatSuratController', 'laporan'])->name('sifat_surat.laporan.index');
    Route::get('sifat_surat/hapus_semua', ['App\Http\Controllers\SifatSuratController', 'hapus_semua'])->name('sifat_surat.hapus_semua');
    Route::resource('sifat_surat', 'App\Http\Controllers\SifatSuratController')->parameters(['sifat_surat' => 'sifat_surat']);

    Route::post('surat_keluar/laporan/print', ['App\Http\Controllers\SuratKeluarController', 'print'])->name('surat_keluar.print');
    Route::get('surat_keluar/laporan', ['App\Http\Controllers\SuratKeluarController', 'laporan'])->name('surat_keluar.laporan.index');
    Route::get('surat_keluar/hapus_semua', ['App\Http\Controllers\SuratKeluarController', 'hapus_semua'])->name('surat_keluar.hapus_semua');
    Route::resource('surat_keluar', 'App\Http\Controllers\SuratKeluarController')->parameters(['surat_keluar' => 'surat_keluar']);

    Route::post('surat_masuk/laporan/print', ['App\Http\Controllers\SuratMasukController', 'print'])->name('surat_masuk.print');
    Route::get('surat_masuk/laporan', ['App\Http\Controllers\SuratMasukController', 'laporan'])->name('surat_masuk.laporan.index');
    Route::get('surat_masuk/hapus_semua', ['App\Http\Controllers\SuratMasukController', 'hapus_semua'])->name('surat_masuk.hapus_semua');
    Route::resource('surat_masuk', 'App\Http\Controllers\SuratMasukController')->parameters(['surat_masuk' => 'surat_masuk']);

    Route::post('unit_kerja/laporan/print', ['App\Http\Controllers\UnitKerjaController', 'print'])->name('unit_kerja.print');
    Route::get('unit_kerja/laporan', ['App\Http\Controllers\UnitKerjaController', 'laporan'])->name('unit_kerja.laporan.index');
    Route::get('unit_kerja/hapus_semua', ['App\Http\Controllers\UnitKerjaController', 'hapus_semua'])->name('unit_kerja.hapus_semua');
    Route::resource('unit_kerja', 'App\Http\Controllers\UnitKerjaController')->parameters(['unit_kerja' => 'unit_kerja']);

    Route::post('user/laporan/print', ['App\Http\Controllers\UserController', 'print'])->name('user.print');
    Route::get('user/{user}/profile', ['App\Http\Controllers\UserController', 'profile'])->name('user.profile');
    Route::put('user/{user}/profile/update', ['App\Http\Controllers\UserController', 'profileUpdate'])->name('user.profile.update');
    Route::get('user/laporan', ['App\Http\Controllers\UserController', 'laporan'])->name('user.laporan.index');
    Route::get('user/hapus_semua', ['App\Http\Controllers\UserController', 'hapus_semua'])->name('user.hapus_semua');
    Route::resource('user', 'App\Http\Controllers\UserController')->parameters(['user' => 'user']);

    Route::post('disposisi/laporan/print', ['App\Http\Controllers\DisposisiController', 'print'])->name('disposisi.print');
    Route::get('disposisi/laporan', ['App\Http\Controllers\DisposisiController', 'laporan'])->name('disposisi.laporan.index');
    Route::get('disposisi/hapus_semua', ['App\Http\Controllers\DisposisiController', 'hapus_semua'])->name('disposisi.hapus_semua');
    Route::resource('disposisi', 'App\Http\Controllers\DisposisiController')->parameters(['disposisi' => 'disposisi']);

    Route::post('sub_bagian/laporan/print', ['App\Http\Controllers\SubBagianController', 'print'])->name('sub_bagian.print');
    Route::get('sub_bagian/laporan', ['App\Http\Controllers\SubBagianController', 'laporan'])->name('sub_bagian.laporan.index');
    Route::get('sub_bagian/hapus_semua', ['App\Http\Controllers\SubBagianController', 'hapus_semua'])->name('sub_bagian.hapus_semua');
    Route::resource('sub_bagian', 'App\Http\Controllers\SubBagianController')->parameters(['sub_bagian' => 'sub_bagian']);

    Route::post('berita/laporan/print', ['App\Http\Controllers\BeritaController', 'print'])->name('berita.print');
    Route::get('berita/laporan', ['App\Http\Controllers\BeritaController', 'laporan'])->name('berita.laporan.index');
    Route::get('berita/hapus_semua', ['App\Http\Controllers\BeritaController', 'hapus_semua'])->name('berita.hapus_semua');
    Route::resource('berita', 'App\Http\Controllers\BeritaController')->parameters(['berita' => 'berita']);

    Route::post('ckeditor/upload', ['App\Http\Controllers\CKEditorController', 'upload']);
});