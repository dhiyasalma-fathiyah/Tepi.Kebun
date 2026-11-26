<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use App\Models\Contact;
use App\Models\Order;
use Illuminate\Support\Facades\Blade;
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
        Paginator::useBootstrapFive();

        // Badge notifikasi di sidebar admin.
        View::composer('layouts.admin', fn ($view) => $view->with([
            'unread' => Contact::where('is_read', false)->count(),
            'pendingOrders' => Order::where('status', 'pending')->count(),
        ]));

        // Pemakaian di Blade: @rupiah($angka)  =>  Rp 1.250.000
        Blade::directive('rupiah', fn (string $expression) => "<?php echo 'Rp '.number_format((float) ({$expression}), 0, ',', '.'); ?>");
    }
}
