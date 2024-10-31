<?php

namespace Rozwell\Ed25519JWT\Providers;

use Rozwell\Ed25519JWT\Commands\JWTKeysCommand;
use Rozwell\Ed25519JWT\Providers\JWT\Ed25519;
use Illuminate\Filesystem\FilesystemServiceProvider;
use Illuminate\Support\ServiceProvider;

class Ed25519JWTServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Make sure Filesystem is already registered:
        $this->app->register(FilesystemServiceProvider::class);

        $this->configureDisks();
        $this->registerProviders();
        $this->registerCommands();
    }

    public function boot()
    {
        //
    }

    protected function configureDisks()
    {
        // Add custom keys disk
        $this->mergeConfigFrom(
            __DIR__.'/../../config/disks.php', 'filesystems.disks'
        );
    }

    protected function registerCommands()
    {
        // Register jwt:keys Command
        $this->commands([
            JwtKeysCommand::class,
        ]);
    }

    protected function registerProviders()
    {
        // Replace JWT Provider
        $this->app->singleton('tymon.jwt.provider.jwt', function ($app) {
            return new Ed25519($app->config->get('jwt.algo', 'Ed25519'), [
                'private' => $app->config->get('jwt.keys.private', 'ed25519.private'),
                'public'  => $app->config->get('jwt.keys.public', 'ed25519.public'),
            ]);
        });
    }
}
