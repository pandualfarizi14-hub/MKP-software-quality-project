<?php

namespace App\Jobs;

use App\Models\WebhookSubscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

// API & Webhook Publik - kirim notifikasi event (mis. booking.created) ke target_url tenant.
class SendWebhookNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 5; // retry sesuai mekanisme queue - lihat Testing-Checklist-E2E.md skenario negatif #6

    public function __construct(public WebhookSubscription $subscription, public string $event, public array $payload)
    {
    }

    public function handle(): void
    {
        Http::withHeaders([
            'X-Webhook-Signature' => hash_hmac('sha256', json_encode($this->payload), $this->subscription->secret),
        ])->post($this->subscription->target_url, [
            'event' => $this->event,
            'data' => $this->payload,
        ]);
    }
}
