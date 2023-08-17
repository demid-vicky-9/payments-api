<?php

namespace VickyDev9\PaymentsApi\Payments\Handlers\Stripe;

use Stripe\Exception\ApiErrorException;
use Stripe\StripeClient;
use VickyDev9\PaymentsApi\Enums\CurrencyEnum;
use VickyDev9\PaymentsApi\Enums\PaymentEnum;
use VickyDev9\PaymentsApi\Enums\StatusEnum;
use VickyDev9\PaymentsApi\Payments\DTO\PayerDTO;
use VickyDev9\PaymentsApi\Payments\DTO\PaymentInfoDTO;

class GetPaymentInfoService
{
    /**
     * @param StripeClient $stripeClient
     * @param string $paymentId
     * @return PaymentInfoDTO
     * @throws ApiErrorException
     */
    public function handle(StripeClient $stripeClient, string $paymentId): PaymentInfoDTO
    {
        $response = $stripeClient->paymentIntents->retrieve($paymentId);;
        $resultArray = ($response->toArray());

        return new PaymentInfoDTO(
            $this->getStatus($resultArray['status']),
            PaymentEnum::STRIPE,
            $resultArray['client_secret'],
            $resultArray['id'],
            $resultArray['amount_received'] / 100,
            $this->getCurrency($resultArray['currency']),
            $resultArray['created'],
            new PayerDTO(
                '',
                null,
                null,
                null,
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
            'succeeded' => StatusEnum::SUCCESS,
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
            'usd' => CurrencyEnum::USD,
            default => CurrencyEnum::EUR,
        };
    }
}
