<?php

namespace App\Enums;

enum BookingStatus : String
{
    case Created = 'created';
    case Pending = 'pending';
    case Confirmed = 'confirmed';
    case Rejected = 'rejected';
}

