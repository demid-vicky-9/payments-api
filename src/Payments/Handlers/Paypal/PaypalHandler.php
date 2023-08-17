<?php

namespace VickyDev9\PaymentsApi\Payments\Handlers\Paypal;

use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Throwable;
use VickyDev9\PaymentsApi\Currency\CurrencyService;
use VickyDev9\PaymentsApi\Payments\DTO\AuthDataDTO;
use VickyDev9\PaymentsApi\Payments\DTO\MakePaymentDTO;
use VickyDev9\PaymentsApi\Payments\DTO\PaymentInfoDTO;
use VickyDev9\PaymentsApi\Payments\PaymentInterface;

class PaypalHandler implements PaymentInterface
{
    /**
     * @param PayPalClient $payPalClient
     * @param AuthDataDTO $authData
     * @throws Throwable
     */
    public function __construct(
        protected PayPalClient $payPalClient,
        AuthDataDTO            $authData
    ) {
        $this->payPalClient->setApiCredentials([
            'mode'           => $authData->isSandbox() === false ? 'live' : 'sandbox',
            // Can only be 'sandbox' Or 'live'. If empty or invalid, 'live' will be used.
            'sandbox'        => [
                'client_id'     => $authData->getPublic(),
                'client_secret' => $authData->getPrivate(),
                'app_id'        => $authData->getId(),
            ],
            'live'           => [
                'client_id'     => $authData->getPublic(),
                'client_secret' => $authData->getPrivate(),
                'app_id'        => $authData->getId(),
            ],
            'payment_action' => 'Sale',
            // Can only be 'Sale', 'Authorization' or 'Order'
            'currency'       => 'USD',
            'notify_url'     => '',
            // Change this accordingly for your application.
            'locale'         => 'en_US',
            // force gateway language  i.e. it_IT, es_ES, en_US ... (for express checkout only)
            'validate_ssl'   => true,
            // Validate SSL when creating api client.
        ]);
        $this->payPalClient->getAccessToken();
    }

    /**
     * @param string $paymentId
     * @return PaymentInfoDTO
     * @throws Throwable
     */
    public function getPaymentInfo(string $paymentId): PaymentInfoDTO
    {
        return (new GetPaymentInfoService())->handle($this->payPalClient, $paymentId);
    }

    /**
     * @param MakePaymentDTO $paymentDTO
     * @return string
     * @throws Throwable
     */
    public function cratePayment(MakePaymentDTO $paymentDTO): string
    {
        $currency = new CurrencyService();
        return (new CreatePaymentService($currency))->handle($this->payPalClient, $paymentDTO);
    }
}
