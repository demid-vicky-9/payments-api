<?php

namespace VickyDev9\PaymentsApi\Payments\Handlers\Paypal;

use Illuminate\Support\Str;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Throwable;
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
     * @param PayPalClient $payPal
     * @param MakePaymentDTO $paymentDTO
     * @return string
     * @throws Throwable
     */
    public function handle(PayPalClient $payPal, MakePaymentDTO $paymentDTO): string
    {
        $response = $payPal->createOrder([
            "intent"         => "CAPTURE",
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => Str::upper(
                            $this->currencyService->getCurrencyCode($paymentDTO->getCurrency())
                        ),
                        "value"         => number_format($paymentDTO->getAmount(), 2, '.')
                    ]
                ]
            ]
        ]);

        if (isset($response['id']) && $response['id'] != null) {
            return $response['id'];
        }

        return '';
    }
}
