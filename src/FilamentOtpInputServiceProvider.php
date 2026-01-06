<?php
namespace NeedLaravelSite\FilamentOtpInput\Src;

use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
use Illuminate\Support\ServiceProvider;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentOtpInputServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // This is the critical line - loads your views
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'filament-otp-input');

        // Optional: allow users to publish views
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../resources/views' => resource_path('views/vendor/filament-otp-input'),
            ], 'filament-otp-input-views');
        }
    }
}
