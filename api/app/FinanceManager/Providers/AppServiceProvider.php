<?php

namespace App\FinanceManager\Providers;

use App\FinanceManager\CQRS\Resolver;
use App\FinanceManager\Repositories\TransactionsRepository;
use App\FinanceManager\Repositories\WalletsRepository;
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
        $this->app->singleton(Resolver::class, function () {
            return new Resolver();
        });

        $this->app->singleton(TransactionsRepository::class, function () {
            return new TransactionsRepository();
        });
        $this->app->singleton(WalletsRepository::class, function () {
            return new WalletsRepository();
        });
    }
}
