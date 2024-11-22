<?php

namespace App\Providers;

use App\Contracts\CalendarServiceContract;
use App\Services\GoogleCalendarService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(CalendarServiceContract::class, GoogleCalendarService::class);
    }

    public function boot(): void
    {
        Model::preventLazyLoading(! app()->isProduction());
    }
}
