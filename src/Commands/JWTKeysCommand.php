<?php

namespace Rozwell\Ed25519JWT\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class JWTKeysCommand extends Command
{
    protected $signature = 'jwt:keys';
    protected $description = 'Generate and save JWT Ed25519 public and private keys';

    public function handle()
    {
        // Get config values
        $privateKeyPath = config('jwt.keys.private', 'ed25519.private');
        $publicKeyPath = config('jwt.keys.public', 'ed25519.public');

        // Check if configuration values are set
        if (empty($privateKeyPath) || empty($publicKeyPath)) {
            $this->error('Error: Key paths are not set in configuration (jwt.keys.private or jwt.keys.public).');
            return;
        }

        // Check if keys already exist and confirm
        if (Storage::disk('keys')->exists($privateKeyPath) || Storage::disk('keys')->exists($publicKeyPath)) {
            if (!$this->confirm('Keys already exist. Do you want to overwrite them?')) {
                $this->info('Operation cancelled.');
                return;
            }
        }

        // Generate key pair
        $keypair = sodium_crypto_sign_keypair();
        $private = sodium_crypto_sign_secretkey($keypair);
        $public = sodium_crypto_sign_publickey($keypair);

        // Save the keys
        Storage::disk('keys')->put($privateKeyPath, $private);
        Storage::disk('keys')->put($publicKeyPath, $public);

        $this->info('JWT keys generated and saved successfully.');
    }
}
