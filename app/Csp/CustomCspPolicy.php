<?php

namespace App\Csp;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Spatie\Csp\Policies\Policy;
use Spatie\Csp\Directive;
use Spatie\Csp\Keyword;
use Illuminate\Support\Facades\Vite;

class CustomCspPolicy extends Policy
{
    public function configure()
    {
        // Vérifier si un nonce est déjà en session, sinon le générer
        if (!Session::has('csp_nonce')) {
            Session::put('csp_nonce', Vite::cspNonce());
        }

        // Récupération du nonce stocké en session
        $nonce = Session::get('csp_nonce');

        Log::info("🚀 Nonce utilisé dans CSP Policy: " . $nonce);
        
        $this
            ->addDirective(Directive::DEFAULT, [Keyword::SELF])
            ->addDirective(Directive::SCRIPT, [
                Keyword::SELF,
                'https://cdnjs.cloudflare.com',
                'https://cdn.jsdelivr.net',
                'http://127.0.0.1:5173',  // Vite en local
                "nonce-{$nonce}",
                // Keyword::STRICT_DYNAMIC, // ⚠️ Permet les scripts injectés dynamiquement (Vite)
                ...(config('app.env') !== 'production' ? [Keyword::UNSAFE_EVAL] : [])     // ⚠️ Seulement en DEV pour éviter des erreurs avec Vue
                // ...(config('app.env') !== 'production' ? [Keyword::UNSAFE_INLINE, Keyword::UNSAFE_EVAL] : []) // ⚠️ Seulement en DEV
            ])
            ->addDirective(Directive::SCRIPT_ELEM, [
                Keyword::SELF,
                'https://cdnjs.cloudflare.com',
                'https://cdn.jsdelivr.net',
                'http://127.0.0.1:5173',
                "nonce-{$nonce}",
            ])
            ->addDirective(Directive::STYLE, [
                Keyword::SELF,
                'https://fonts.bunny.net',
                'https://cdnjs.cloudflare.com',
                'https://fonts.googleapis.com',
                'https://cdn.jsdelivr.net',
                "nonce-{$nonce}",
                ...(config('app.env') !== 'production' ? [Keyword::UNSAFE_INLINE] : []) // ✅ Autoriser inline en DEV
            ])
            ->addDirective(Directive::IMG, [Keyword::SELF, 'data:', 'https://trusted-images.com'])
            ->addDirective(Directive::FONT, [
                Keyword::SELF,
                'https://fonts.gstatic.com',
                'https://fonts.bunny.net',
                'https://cdnjs.cloudflare.com',
                'https://cdn.jsdelivr.net',
            ])
            ->addDirective(Directive::CONNECT, [
                Keyword::SELF,
                'https://api.trusted-source.com',
                'http://127.0.0.1:5173',
                'ws://127.0.0.1:5173',
                'wss://127.0.0.1:5173',
            ])
            ->addDirective(Directive::FRAME_ANCESTORS, [Keyword::NONE]) // Anti-ClickJacking
            ->addDirective(Directive::OBJECT, [Keyword::NONE]) // Bloquer Flash/Java applets
            ->addDirective(Directive::FORM_ACTION, [Keyword::SELF])
            
            // Appliquer un nonce sur les scripts et styles
            ->addNonceForDirective(Directive::SCRIPT)
            ->addNonceForDirective(Directive::STYLE);
    }
}
