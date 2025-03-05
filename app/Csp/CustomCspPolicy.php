<?php

namespace App\Csp;

use Spatie\Csp\Policies\Policy;
use Spatie\Csp\Directive;
use Spatie\Csp\Keyword;

class CustomCspPolicy extends Policy
{
    public function configure()
    {
        $this
            ->addDirective(Directive::DEFAULT, [Keyword::SELF])
            ->addDirective(Directive::SCRIPT, [
                Keyword::SELF, 
                'https://cdnjs.cloudflare.com', 
                'http://127.0.0.1:5173'
            ])
            ->addDirective(Directive::STYLE, [
                Keyword::SELF, 
                'https://fonts.bunny.net', 
                'https://cdnjs.cloudflare.com', 
                'https://fonts.googleapis.com'
            ])
            ->addDirective(Directive::IMG, [Keyword::SELF, 'data:', 'https://trusted-images.com'])
            ->addDirective(Directive::FONT, [
                Keyword::SELF, 
                'https://fonts.gstatic.com', 
                'https://fonts.bunny.net', 
                'https://cdnjs.cloudflare.com'
            ])
            ->addDirective(Directive::CONNECT, [
                Keyword::SELF, 
                'https://api.trusted-source.com', 
                'ws://127.0.0.1:5173', 
                'wss://127.0.0.1:5173'
            ])
            ->addDirective(Directive::FRAME_ANCESTORS, [Keyword::NONE]) // ✅ Anti-ClickJacking
            ->addDirective(Directive::OBJECT, [Keyword::NONE]) // ✅ Block Flash/Java applets
            ->addDirective(Directive::FORM_ACTION, [Keyword::SELF])
            
            // ✅ Enable Nonce for Scripts and Styles
            ->addNonceForDirective(Directive::SCRIPT)
            ->addNonceForDirective(Directive::STYLE);
    }
}
