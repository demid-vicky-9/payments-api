<?php

namespace VickyDev9\PaymentsApi\Payments\Handlers\Liqpay;

use VickyDev9\PaymentsApi\Enums\CurrencyEnum;
use VickyDev9\PaymentsApi\Enums\PaymentEnum;
use VickyDev9\PaymentsApi\Enums\StatusEnum;
use VickyDev9\PaymentsApi\Payments\DTO\PayerDTO;
use VickyDev9\PaymentsApi\Payments\DTO\PaymentInfoDTO;

class GetPaymentInfoService
{
    /**
     * @param Liqpay $liqpay
     * @param string $paymentId
     * @return PaymentInfoDTO
     */
    public function handle(Liqpay $liqpay, string $paymentId): PaymentInfoDTO
    {
        $response = $liqpay->api("request", [
            'action'   => 'status',
            'version'  => '3',
            'order_id' => $paymentId,
        ]);
        return new PaymentInfoDTO(
            $this->getStatus($response->status),
            PaymentEnum::LIQPAY,
            $response->order_id,
            $response->transaction_id,
            $response->amount,
            $this->getCurrency($response->currency),
            (int)substr($response->create_date, 0, 10),
            new PayerDTO(
                $response->sender_card_mask2,
                null,
                null,
                $response->ip
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
            'success' => StatusEnum::SUCCESS,
            default => StatusEnum::FAILED,
        };
    }

    /**
     * @param string $currency
     * @return CurrencyEnum
     */
    private function getCurrency(string $currency): CurrencyEnum
    {
        return match ($currency) {
            'USD' => CurrencyEnum::USD,
            default => CurrencyEnum::EUR,
        };
    }
}
