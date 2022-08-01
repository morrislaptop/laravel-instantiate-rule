<?php

namespace Morrislaptop\LaravelValueObjectRule;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Morrislaptop\LaravelValueObjectRule\Commands\LaravelValueObjectRuleCommand;

class LaravelValueObjectRuleServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-value-object-rule')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-value-object-rule_table')
            ->hasCommand(LaravelValueObjectRuleCommand::class);
    }
}
