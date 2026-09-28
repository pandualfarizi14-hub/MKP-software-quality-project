<?php

namespace App\Providers;

use App\Repositories\Contracts\GpsProviderInterface;
use App\Repositories\Contracts\OcrProviderInterface;
use App\Repositories\Contracts\RiskScraperInterface;
use App\Repositories\Fallback\MockGpsProvider;
use App\Repositories\Fallback\MockOcrProvider;
use App\Repositories\Fallback\MockRiskScraper;
use App\Repositories\Live\ApiScraperRiskScraper;
use App\Repositories\Live\TenantGpsProvider;
use App\Repositories\Live\VeryHubOcrProvider;
use Illuminate\Support\ServiceProvider;

// Binding interface -> implementasi berdasarkan flag mode di .env (pola fallback).
// Lihat Sprint-Plan-8-Minggu.md & Environment-Setup-Guide.md bagian 5.
class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(OcrProviderInterface::class, function () {
            return config('services.ocr.mode') === 'live'
                ? new VeryHubOcrProvider() // catatan: OCR_MODE=live perlu logic pemilihan provider ganda (VeryHub + PaddleOCR) di Services/VerificationService
                : new MockOcrProvider();
        });

        $this->app->bind(RiskScraperInterface::class, function () {
            return config('services.scraper.mode') === 'live'
                ? new ApiScraperRiskScraper()
                : new MockRiskScraper();
        });

        $this->app->bind(GpsProviderInterface::class, function () {
            return config('services.gps.mode') === 'live'
                ? new TenantGpsProvider()
                : new MockGpsProvider();
        });
    }

    public function boot(): void
    {
        //
    }
}
