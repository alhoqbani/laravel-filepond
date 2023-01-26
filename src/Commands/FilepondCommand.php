<?php

namespace Alhoqbani\Filepond\Commands;

use Illuminate\Console\Command;

class FilepondCommand extends Command
{
    public $signature = 'laravel-filepond';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
