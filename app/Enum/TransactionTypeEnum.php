<?php

namespace App\Enum;

enum TransactionTypeEnum: string
{
    case DEPOSIT = 'deposit';
    case WITHDRAW = 'withdraw';
    case TRANSFER_IN = 'transfer_in';
    case TRANSFER_OUT = 'transfer_out';
}
