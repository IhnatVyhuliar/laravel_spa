<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\CommentService;
use App\Services\TagClosedService;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CommentService::class, function() {
            return new CommentService(25);
        });
        $this->app->bind(TagClosedService::class, function() {
            return new TagClosedService;
        });
        
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
