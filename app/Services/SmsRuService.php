<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class SmsRuService
{
    public function sendVerificationCode(string $phone, string $code): void
    {
        $apiId = config('services.sms_ru.api_id');

        if (! is_string($apiId) || $apiId === '') {
            throw new RuntimeException('SMS.ru не настроен.');
        }

        $phoneDigits = ltrim($phone, '+');
        $response = Http::asForm()
            ->timeout(15)
            ->post('https://sms.ru/sms/send', [
                'api_id' => $apiId,
                'to' => $phoneDigits,
                'msg' => 'Код для входа в '.config('app.name').': '.$code,
                'json' => 1,
            ]);

        if (
            ! $response->successful() ||
            $response->json('status') !== 'OK' ||
            $response->json('sms.'.$phoneDigits.'.status') !== 'OK'
        ) {
            throw new RuntimeException('SMS.ru не подтвердил отправку сообщения.');
        }
    }
}
