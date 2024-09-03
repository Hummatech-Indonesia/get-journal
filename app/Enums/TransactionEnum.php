<?php

namespace App\Enums;

enum TransactionEnum: string
{
    case PAID = 'PAID';
    case UNPAID = 'UNPAID';
    case EXPIRED = 'EXPIRED';
}
