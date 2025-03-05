<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Barryvdh\DomPDF\ServiceProvider as DomPDFServiceProvider;
use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Facades\App;

class PdfServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // ✅ Enregistrement du service DomPDF
        $this->app->register(DomPDFServiceProvider::class);

        // ✅ Enregistrement manuel de l'alias "PDF"
        $this->app->singleton('pdf', function ($app) {
            return $app->make(PDF::class);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
