<?php

namespace App\Providers;

use App\Models\Disposisi;
use App\Models\SuratMasuk;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultstringLength(191);

        $disposisi_surat_masuk_ids = Disposisi::pluck('surat_masuk_id')->toArray();
        $surat_masuk_status_belum_disposisi_count = SuratMasuk::whereNotIn('id', $disposisi_surat_masuk_ids)->count();
        
        \view()->share('surat_masuk_status_belum_disposisi_count', $surat_masuk_status_belum_disposisi_count);
    }
}
