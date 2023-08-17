<?php

namespace VickyDev9\PaymentsApi\Currency;

use VickyDev9\PaymentsApi\Enums\CurrencyEnum;

class CurrencyService
{
    /**
     * @param CurrencyEnum $currency
     * @return string
     */
    public function getCurrencyCode(CurrencyEnum $currency): string
    {
        return match ($currency) {
            CurrencyEnum::USD => 'usd',
            CurrencyEnum::EUR => 'eur',
            CurrencyEnum::PLN => 'pln',
        };
    }
}
