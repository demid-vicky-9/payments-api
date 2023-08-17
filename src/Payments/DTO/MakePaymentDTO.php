<?php

namespace VickyDev9\PaymentsApi\Payments\DTO;

use VickyDev9\PaymentsApi\Enums\CurrencyEnum;

class MakePaymentDTO
{
    /**
     * @param float $amount
     * @param CurrencyEnum $currency
     * @param string $description
     */
    public function __construct(
        protected float        $amount,
        protected CurrencyEnum $currency,
        protected string       $description = '',
    ) {
    }

    /**
     * @return float
     */
    public function getAmount(): float
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
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }
}
