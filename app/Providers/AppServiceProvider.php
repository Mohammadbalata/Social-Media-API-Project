<?php

namespace App\Providers;

use App\Notifications\Channels\FcmChannel;
use App\Services\FirebaseService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->environment('local') && class_exists(\Laravel\Telescope\TelescopeServiceProvider::class)) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
        
        // $this->app->extend(ChannelManager::class, function ($service, $app) {
        //     $service->extend('fcm', function ($app) {
        //         return new FcmChannel($app->make(FirebaseService::class));
        //     });
        //     return $service;
        // });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        JsonResource::withoutWrapping();
        Model::preventLazyLoading();
    }
}
