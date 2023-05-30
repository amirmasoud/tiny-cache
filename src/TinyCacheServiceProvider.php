<?php

namespace Amirmasoud\TinyCache;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class TinyCacheServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('tiny-cache')
            ->hasConfigFile();
    }
}
