<?php

namespace VickyDev9\PaymentsApi\Payments;

use VickyDev9\PaymentsApi\Payments\DTO\MakePaymentDTO;
use VickyDev9\PaymentsApi\Payments\DTO\PaymentInfoDTO;

interface PaymentInterface
{
    public function getPaymentInfo(string $paymentId): PaymentInfoDTO;

    public function createPayment(MakePaymentDTO $paymentDTO): string;
}
