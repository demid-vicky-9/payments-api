<?php

namespace VickyDev9\PaymentsApi\Payments\Handlers\Liqpay;

use VickyDev9\PaymentsApi\Payments\DTO\AuthDataDTO;
use VickyDev9\PaymentsApi\Payments\DTO\MakePaymentDTO;
use VickyDev9\PaymentsApi\Payments\DTO\PaymentInfoDTO;
use VickyDev9\PaymentsApi\Payments\PaymentInterface;

class LiqpayHandler implements PaymentInterface
{
    protected Liqpay $liqpay;

    /**
     * @param AuthDataDTO $authDataDTO
     */
    public function __construct(AuthDataDTO $authDataDTO)
    {
        $this->liqpay = new Liqpay($authDataDTO->getPublic(), $authDataDTO->getPrivate());
    }

    /**
     * @param string $paymentId
     * @return PaymentInfoDTO
     */
    public function getPaymentInfo(string $paymentId): PaymentInfoDTO
    {
        return (new GetPaymentInfoService())->handle($this->liqpay, $paymentId);
    }

    /**
     * @param MakePaymentDTO $paymentDTO
     * @return string
     */
    public function cratePayment(MakePaymentDTO $paymentDTO): string
    {
        return (new CreatePaymentService())->handle($this->liqpay, $paymentDTO);
    }
}
