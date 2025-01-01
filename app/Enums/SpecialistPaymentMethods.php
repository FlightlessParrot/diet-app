<?php
namespace App\Enums;
enum SpecialistPaymentMethods : string
{
    case CARD = 'karta';
    case CASH = 'gotówka';
    case BLIK = 'blik';
    case TRANSFER = 'przelew';
}