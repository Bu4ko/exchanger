<?php

namespace App\ApiGateway\Providers;

use App\CQRS\Queries\GetUserQuery;
use App\Services\Dispatcher;
use Illuminate\Support\ServiceProvider;
use Ramsey\Uuid\Uuid;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        $this->app['auth']->viaRequest('api', function ($request) {
            if ($request->input('userId') && $request->input('token')) {
                $dispatcher = app(Dispatcher::class);
                $userQuery = new GetUserQuery(
                    Uuid::fromString((string)$request->input('userId')),
                    (string)$request->input('token')
                );
                return $dispatcher->dispatch($userQuery);
            }
            return null;
        });
    }
}
