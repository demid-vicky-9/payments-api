<?php

namespace VickyDev9\PaymentsApi\Payments;

use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Stripe\StripeClient;
use VickyDev9\PaymentsApi\Enums\PaymentEnum;
use VickyDev9\PaymentsApi\Payments\DTO\AuthDataDTO;
use VickyDev9\PaymentsApi\Payments\Handlers\Liqpay\LiqpayHandler;
use VickyDev9\PaymentsApi\Payments\Handlers\Paypal\PaypalHandler;
use VickyDev9\PaymentsApi\Payments\Handlers\Stripe\StripeHandler;

class PaymentFactory
{
    /**
     * @param PaymentEnum $payment
     * @param array $configData
     * @return PaymentInterface
     */
    public function getInstance(PaymentEnum $payment, array $configData): PaymentInterface
    {
        return match ($payment) {
            PaymentEnum::PAYPAL => new PaypalHandler(
                new PayPalClient(),
                new AuthDataDTO(
                    $configData['paypal']['client_id'],
                    $configData['paypal']['client_secret'],
                    $configData['paypal']['app_id'],
                    $configData['paypal']['mode'],
                )
            ),
            PaymentEnum::STRIPE => new StripeHandler(new StripeClient($configData['stripe']['secret_key'])),
            PaymentEnum::LIQPAY => new LiqpayHandler(
                new AuthDataDTO(
                    $configData['liqpay']['public_key'],
                    $configData['liqpay']['private_key'],
                    null,
                )
            ),
        };
    }
}
