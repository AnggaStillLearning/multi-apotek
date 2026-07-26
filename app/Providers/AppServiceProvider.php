<?php

namespace App\Providers;

use App\Models\Obat;
use App\Models\BatchObat;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Isi notifikasi lonceng di navbar (stok kritis & kadaluarsa)
        // memakai kriteria yang sama dengan MonitoringController.
        View::composer('components.navbar', function ($view) {

            $stokNotif = 0;
            $expiredNotif = 0;

            if (auth()->check() && auth()->user()->apotek_id) {

                $apotekId = auth()->user()->apotek_id;

                $stokNotif = Obat::where('apotek_id', $apotekId)
                    ->whereColumn('total_stok', '<=', 'stok_minimum')
                    ->count();

                $expiredNotif = BatchObat::whereHas('obat', function ($q) use ($apotekId) {
                        $q->where('apotek_id', $apotekId);
                    })
                    ->whereBetween(
                        'tanggal_kadaluarsa',
                        [now(), now()->addDays(30)]
                    )
                    ->count();
            }

            $view->with([
                'stokNotif' => $stokNotif,
                'expiredNotif' => $expiredNotif,
                'totalNotif' => $stokNotif + $expiredNotif,
            ]);
        });
    }
}
