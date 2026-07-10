<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsService
{
    public function sendOtp(string $phone, string $code): bool
    {
        $apiKey = config('services.smsir.api_key');
        $templateId = config('services.smsir.otp_template_id');

        if (! $apiKey || ! $templateId) {
            Log::warning("SMS.ir config missing. Would have sent OTP {$code} to {$phone}");
            return false;
        }

        $response = Http::withHeaders([
            'x-api-key' => $apiKey,
            'Accept' => 'text/plain',
            'Content-Type' => 'application/json',
        ])->post('https://api.sms.ir/v1/send/verify', [
            'mobile' => $phone,
            'templateId' => $templateId,
            'parameters' => [
                ['name' => 'CODE', 'value' => $code],
            ],
        ]);

        Log::info("SMS.ir Verify response for {$phone}: " . $response->status() . ' - ' . $response->body());

        return $response->successful();
    }

    public function sendOrderStatusUpdate(string $phone, string $orderNumber, string $status): bool
    {
        $statusLabels = [
            'pending' => 'در انتظار پرداخت',
            'paid' => 'پرداخت شده',
            'shipped' => 'ارسال شده',
            'delivered' => 'تحویل داده شده',
            'cancelled' => 'لغو شده',
        ];

        $label = $statusLabels[$status] ?? $status;

        // TODO: create a second SMS.ir template for order status and use send/verify here too.
        Log::info("Order status SMS (not yet using Verify template) for {$phone}: order {$orderNumber} -> {$label}");

        return false;
    }
}