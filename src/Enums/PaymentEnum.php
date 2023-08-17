<?php

namespace VickyDev9\PaymentsApi\Enums;

enum PaymentEnum: string
{
    case PAYPAL = 'paypal';
    case STRIPE = 'stripe';
    case LIQPAY = 'liqpay';
}
