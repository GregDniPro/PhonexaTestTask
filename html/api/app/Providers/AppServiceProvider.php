<?php

namespace App\Providers;

use App\Services\CreditScoreTransformer;
use App\Services\HttpClient;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(
            'app.client',
            HttpClient::class,
            static function (Application $app): HttpClient {
                return new HttpClient;
            }
        );
        $this->app->bind(
            'app.score_transformer',
            CreditScoreTransformer::class,
            static function (Application $app): CreditScoreTransformer {
                return new CreditScoreTransformer;
            }
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        return;
    }
}
