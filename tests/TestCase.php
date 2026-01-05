<?php
namespace NeedLaravelSite\ContactForm\Tests;

use NeedLaravelSite\ContactForm\Src\FilamentOtpInputServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
class TestCase extends Orchestra
{

    protected function getPackageProviders($app): array
    {
        return [
            FilamentOtpInputServiceProvider::class,
        ];
    }

}
