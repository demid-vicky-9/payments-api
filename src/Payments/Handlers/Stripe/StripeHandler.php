<?php

namespace VickyDev9\PaymentsApi\Payments\Handlers\Stripe;

use Stripe\Exception\ApiErrorException;
use Stripe\StripeClient;
use VickyDev9\PaymentsApi\Currency\CurrencyService;
use VickyDev9\PaymentsApi\Payments\DTO\MakePaymentDTO;
use VickyDev9\PaymentsApi\Payments\DTO\PaymentInfoDTO;
use VickyDev9\PaymentsApi\Payments\PaymentInterface;

class StripeHandler implements PaymentInterface
{
    /**
     * @param StripeClient $stripe
     */
    public function __construct(
        protected StripeClient $stripe
    ) {
    }

    /**
     * @param string $paymentId
     * @return PaymentInfoDTO
     * @throws ApiErrorException
     */
    public function getPaymentInfo(string $paymentId): PaymentInfoDTO
    {
        return (new GetPaymentInfoService())->handle($this->stripe, $paymentId);
    }

    /**
     * @param MakePaymentDTO $paymentDTO
     * @return string
     * @throws ApiErrorException
     */
    public function cratePayment(MakePaymentDTO $paymentDTO): string
    {
        $currency = new CurrencyService();
        return (new CreatePaymentService($currency))->handle($this->stripe, $paymentDTO);
    }
}
