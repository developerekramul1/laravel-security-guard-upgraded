<?php
namespace Ekramul\SecurityGuard\Console;

use Illuminate\Console\Command;
use Ekramul\SecurityGuard\Scanner\MalwareScanner;
use Illuminate\Support\Facades\Mail;

class ScanCommand extends Command
{
    protected $signature = 'security:scan';

    public function handle()
    {
        $scanner = new MalwareScanner();
        $infected = $scanner->scan(base_path());

        if(!empty($infected)) {
            Mail::raw("Malware detected & quarantined in your Laravel project.", function ($msg) {
                $msg->to(config('security.email'))
                    ->subject('Security Alert 🚨');
            });

            $this->info('Malware detected & quarantined.');
        } else {
            $this->info('No malware detected.');
        }
    }
}
