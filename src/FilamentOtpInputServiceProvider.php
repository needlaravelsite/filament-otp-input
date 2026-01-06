<?php
namespace NeedLaravelSite\FilamentOtpInput\Src;

use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentOtpInputServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-otp-input';

    public function configurePackage(Package $package): void
    {
        $package
            ->name(static::$name)
            ->hasViews();
    }

    public function packageBooted(): void
    {
        // Register any additional assets if needed
    }
}
