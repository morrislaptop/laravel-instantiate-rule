<?php

namespace Morrislaptop\LaravelValueObjectRule\Commands;

use Illuminate\Console\Command;

class LaravelValueObjectRuleCommand extends Command
{
    public $signature = 'laravel-value-object-rule';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
