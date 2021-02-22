<?php declare(strict_types=1);

namespace App\ApiGateway\Providers;

use App\Services\Dispatcher;
use GuzzleHttp\Client;
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
        $this->app->singleton(Dispatcher::class, function () {
            return new Dispatcher(app(Client::class), env('USERS_URL'), env('FINANCE_MANAGER_URL'));
        });
    }
}
