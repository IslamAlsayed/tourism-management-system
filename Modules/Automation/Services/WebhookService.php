<?php

namespace Modules\Automation\Services;

use Illuminate\Support\Facades\Http;
use Modules\Automation\Entities\Webhook;
use Modules\Automation\Entities\WebhookLog;
use Illuminate\Support\Facades\Log;

class WebhookService
{
    /**
     * Dispatch an event to all registered and active webhooks.
     *
     * @param string $eventType
     * @param array $payload
     * @return void
     */
    public static function dispatch(string $eventType, array $payload)
    {
        $webhooks = Webhook::where('is_active', true)
            ->where(function ($query) use ($eventType) {
                $query->where('event_type', $eventType)
                    ->orWhere('event_type', '*');
            })
            ->get();

        foreach ($webhooks as $webhook) {
            self::send($webhook, $payload);
        }
    }

    /**
     * Send the payload to a specific webhook.
     *
     * @param Webhook $webhook
     * @param array $payload
     * @return void
     */
    public static function send(Webhook $webhook, array $payload)
    {
        try {
            $headers = $webhook->headers ?? [];
            if ($webhook->secret_token) {
                $headers['X-Webhook-Secret'] = $webhook->secret_token;
            }

            $response = Http::withHeaders($headers)
                ->timeout(10)
                ->post($webhook->url, [
                    'event' => $webhook->event_type,
                    'timestamp' => now()->toIso8601String(),
                    'data' => $payload
                ]);

            WebhookLog::create([
                'webhook_id' => $webhook->id,
                'payload' => $payload,
                'response_status' => $response->status(),
                'response_body' => $response->body(),
            ]);

        } catch (\Exception $e) {
            Log::error("Webhook failed for {$webhook->name}: " . $e->getMessage());
            
            WebhookLog::create([
                'webhook_id' => $webhook->id,
                'payload' => $payload,
                'response_status' => null,
                'response_body' => null,
                'error' => $e->getMessage()
            ]);
        }
    }
}
