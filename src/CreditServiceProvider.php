<?php

namespace Chapdel\Credit;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class CreditServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('credits')
            ->hasConfigFile()
            ->hasMigration('create_credits_table');
    }
}
