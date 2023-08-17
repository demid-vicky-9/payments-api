<?php

namespace VickyDev9\PaymentsApi\Payments\Handlers\Stripe;

use Stripe\Exception\ApiErrorException;
use Stripe\StripeClient;
use VickyDev9\PaymentsApi\Currency\CurrencyService;
use VickyDev9\PaymentsApi\Payments\DTO\MakePaymentDTO;

class CreatePaymentService
{
    /**
     * @param CurrencyService $currencyService
     */
    public function __construct(
        protected CurrencyService $currencyService,
    ) {
    }

    /**
     * @param StripeClient $stripeClient
     * @param MakePaymentDTO $paymentDTO
     * @return string
     * @throws ApiErrorException
     */
    public function handle(StripeClient $stripeClient, MakePaymentDTO $paymentDTO): string
    {
        $result = $stripeClient->paymentIntents->create([
            'amount'   => (int)round($paymentDTO->getAmount() * 100),
            'currency' => $this->currencyService->getCurrencyCode($paymentDTO->getCurrency()),
        ]);

        return $result->client_secret;
    }
}
