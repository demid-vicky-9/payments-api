# Instruction

## Laravel Usage

Create file `config/payments_api.php` with content:

```php
return [
    'paypal' => [
        'client_id' => env('PAYPAL_CLIENT_ID', ''),
        'client_secret' => env('PAYPAL_CLIENT_SECRET', ''),
        'app_id' => env('PAYPAL_APP_ID', ''),
        'mode' => env('PAYPAL_MODE', ''),
    ],
    'stripe' => [
        'secret_key' => env('STRIPE_SECRET_KEY', null),
        'publishable_key' => env('STRIPE_PUBLISHABLE_KEY', null),
    ],
    'liqpay' => [
        'private_key' => env('LIQPAY_PRIVATE_KEY', null),
        'public_key' => env('LIQPAY_PUBLIC_KEY', null),
    ],
];
```

For get orderId use:

```php
    public function __construct(
        protected PaymentFactory $paymentFactory
    ) {
    }
    
    public function getOrderId(int $system) {
        $paymentService = $this->paymentFactory->getInstance(
            Payments::from($system),
            config('payments_api')
        );
        $makePaymentDTO = new MakePaymentDTO(
            15.25,
            Currency::USD
        );
        $orderId = $paymentService->cratePayment($makePaymentDTO);
        
        return $orderId;
    }
```

For get payment result info use:

```php
    public function __construct(
        protected PaymentFactory $paymentFactory
    ) {
    }
    
    public function getPaymentResult(int $system, string $paymentId) {
    $paymentService = $this->paymentFactory->getInstance(
        Payments::from($system),
        config('payments_api')
    );
    $paymentResult = $paymentService->getPaymentInfo($paymentId);

    return $paymentResult;
```
