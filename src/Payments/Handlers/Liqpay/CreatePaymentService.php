<?php

namespace VickyDev9\PaymentsApi\Payments\Handlers\Liqpay;

use Illuminate\Support\Str;
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
     * @param Liqpay $liqpay
     * @param MakePaymentDTO $paymentDTO
     * @return string
     */
    public function handle(Liqpay $liqpay, MakePaymentDTO $paymentDTO): string
    {
        $data = $liqpay->cnb_form_raw([
            'version'     => 3,
            'amount'      => $paymentDTO->getAmount(),
            'currency' => Str::upper(
                $this->currencyService->getCurrencyCode($paymentDTO->getCurrency())
            ),
            'description' => $paymentDTO->getDescription(),
            'order_id'    => (int)round(microtime(true) * 1000),
            'action'      => 'pay',
        ]);

        $result = ['id' => $data['data'], 'signature' => $data['signature']];

        return json_encode($result, true);
    }
}
