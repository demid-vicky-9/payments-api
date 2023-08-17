<?php

namespace VickyDev9\PaymentsApi\Enums;

enum StatusEnum: int
{
    case FAILED = 0;
    case SUCCESS = 1;
    case PENDING = 2;
    case REFUNDED = 3;
    case CANCELED = 4;
    case CREATED = 5;
    case COMPLETED = 6;
}

/*
failed - не вдалося
success - успішно
pending - oчікує
refunded - повернено
canceled - скасовано
created - створено
completed - завершено
*/
