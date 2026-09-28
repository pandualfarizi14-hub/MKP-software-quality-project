<?php

// Konfigurasi mode fallback (mock/live) untuk modul yang bergantung API eksternal.
// Lihat .env.example, Sprint-Plan-8-Minggu.md, dan AppServiceProvider.
return [
    'ocr' => [
        'mode' => env('OCR_MODE', 'mock'),
        'veryhub_key' => env('OCR_VERYHUB_KEY'),
        'paddleocr_key' => env('OCR_PADDLEOCR_KEY'),
    ],

    'scraper' => [
        'mode' => env('SCRAPER_MODE', 'mock'),
        'api_key' => env('SCRAPER_API_KEY'),
    ],

    'gps' => [
        'mode' => env('GPS_MODE', 'mock'),
    ],
];
