<?php

namespace VickyDev9\PaymentsApi\Payments\Handlers\Paypal;

use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Throwable;
use VickyDev9\PaymentsApi\Enums\CurrencyEnum;
use VickyDev9\PaymentsApi\Enums\PaymentEnum;
use VickyDev9\PaymentsApi\Enums\StatusEnum;
use VickyDev9\PaymentsApi\Payments\DTO\PayerDTO;
use VickyDev9\PaymentsApi\Payments\DTO\PaymentInfoDTO;

class GetPaymentInfoService
{
    /**
     * @param PayPalClient $payPal
     * @param string $paymentId
     * @return PaymentInfoDTO
     * @throws Throwable
     */
    public function handle(PayPalClient $payPal, string $paymentId): PaymentInfoDTO
    {
        $response = $payPal->capturePaymentOrder($paymentId);
        return new PaymentInfoDTO(
            $this->getStatus($response['status']),
            PaymentEnum::PAYPAL,
            $response['id'],
            $response['purchase_units']['0']['payments']['captures']['0']['id'] ?? '',
            $response['purchase_units']['0']['payments']['captures']['0']['amount']['value'] ?? '',
            $this->getCurrency(
                $response['purchase_units']['0']['payments']['captures']['0']['amount']['currency_code'] ?? ''
            ),
            strtotime($response['purchase_units']['0']['payments']['captures']['0']['create_time'] ?? time()),
            new PayerDTO(
                ($response['name']['given_name'] ?? '') . ' ' . ($response['name']['surname'] ?? ''),
                $response['email_address'] ?? null,
                null,
                null
            ),
        );
    }

    /**
     * @param string $status
     * @return StatusEnum
     */
    private function getStatus(string $status): StatusEnum
    {
        return match ($status) {
            'COMPLETED' => StatusEnum::SUCCESS,
            default => StatusEnum::FAILED,
        };
    }

    /**
     * @param string $status
     * @return CurrencyEnum
     */
    private function getCurrency(string $status): CurrencyEnum
    {
        return match ($status) {
            'USD' => CurrencyEnum::USD,
            default => CurrencyEnum::EUR,
        };
    }
}
