<?php
namespace Ekramul\SecurityGuard;

use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;

class SecurityGuardServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/security.php' => config_path('security.php'),
        ], 'security-config');

        if ($this->app->runningInConsole()) {
            $this->commands([
                Console\ScanCommand::class,
                Console\InstallCommand::class,
            ]);
        }

        $this->app->booted(function () {
            $schedule = app(Schedule::class);
            $schedule->command('security:scan')->daily();
        });
    }
}
