<?php

namespace App\Providers;

use App\Services\FirebaseService;
use Illuminate\Support\ServiceProvider;
use Kreait\Firebase\Factory;

class FirebaseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(FirebaseService::class,
            function ($app) {
                $firebaseConfigPath = config('firebase.credentials.path');

                if (!file_exists($firebaseConfigPath)) {
                    throw new \RuntimeException("Firebase service account key file not found at: $firebaseConfigPath");
                }

                $firebase = (new Factory)->withServiceAccount($firebaseConfigPath)
                    ->withDatabaseUri(
                        config('firebase.database_uri')
                    );

                return new FirebaseService($firebase);
            }
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
