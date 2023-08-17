<?php

namespace VickyDev9\PaymentsApi\Payments\DTO;

use VickyDev9\PaymentsApi\Enums\CurrencyEnum;
use VickyDev9\PaymentsApi\Enums\PaymentEnum;
use VickyDev9\PaymentsApi\Enums\StatusEnum;

class PaymentInfoDTO
{
    /**
     * @param StatusEnum $status
     * @param PaymentEnum $paymentSystem
     * @param string $orderId
     * @param string $paymentId
     * @param string $amount
     * @param CurrencyEnum $currency
     * @param int $time
     * @param PayerDTO|null $payer
     */
    public function __construct(
        protected StatusEnum   $status,
        protected PaymentEnum  $paymentSystem,
        protected string       $orderId,
        protected string       $paymentId,
        protected string       $amount,
        protected CurrencyEnum $currency,
        protected int          $time,
        protected ?PayerDTO    $payer,
    ) {
    }

    /**
     * @return StatusEnum
     */
    public function getStatus(): StatusEnum
    {
        return $this->status;
    }

    /**
     * @return PaymentEnum
     */
    public function getPaymentSystem(): PaymentEnum
    {
        return $this->paymentSystem;
    }

    /**
     * @return string
     */
    public function getOrderId(): string
    {
        return $this->orderId;
    }

    /**
     * @return string
     */
    public function getPaymentId(): string
    {
        return $this->paymentId;
    }

    /**
     * @return string
     */
    public function getAmount(): string
    {
        return $this->amount;
    }

    /**
     * @return CurrencyEnum
     */
    public function getCurrency(): CurrencyEnum
    {
        return $this->currency;
    }

    /**
     * @return int
     */
    public function getTime(): int
    {
        return $this->time;
    }

    /**
     * @return PayerDTO|null
     */
    public function getPayer(): ?PayerDTO
    {
        return $this->payer;
    }
}
