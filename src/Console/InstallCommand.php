<?php
namespace Ekramul\SecurityGuard\Console;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    protected $signature = 'security:install';

    public function handle()
    {
        $this->call('vendor:publish', ['--tag' => 'security-config']);

        if (!file_exists(storage_path('quarantine'))) {
            mkdir(storage_path('quarantine'), 0755, true);
        }

        $this->info('Security Guard Installed ✅');
    }
}
