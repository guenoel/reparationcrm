<?php

namespace App\Support;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\Str;
use Spatie\Csp\Nonce\NonceGenerator;

class LaravelViteNonceGenerator implements NonceGenerator
{
    private static ?string $nonce = null;

    public function generate(): string
    {
        if (!self::$nonce) {
            self::$nonce = Vite::useCspNonce(); // Stocke le nonce pour toute la requête
        }
        return self::$nonce;
    }
}
