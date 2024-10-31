<?php

namespace Rozwell\Ed25519JWT\Providers;

use Illuminate\Support\Facades\Storage;
use Lcobucci\JWT\Signer\Eddsa;
use Tymon\JWTAuth\Providers\JWT\Lcobucci;

class Ed25519 extends Lcobucci
{
    protected $signers = [
        'Ed25519' => Eddsa::class,
    ];

    public function __construct($algo, array $keys, $config = null)
    {
        parent::__construct('', $algo, $keys, $config);
    }

    public function getPrivateKey()
    {
        return Storage::disk('keys')->get(parent::getPrivateKey());
    }

    public function getPublicKey()
    {
        return Storage::disk('keys')->get(parent::getPublicKey());
    }

    protected function isAsymmetric()
    {
        return true;
    }
}
