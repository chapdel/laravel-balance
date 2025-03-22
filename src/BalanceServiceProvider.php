<?php

namespace Geow\Balance;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class BalanceServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-credits')
            ->hasConfigFile()
            ->hasMigration('create_credits_table');
    }
}
