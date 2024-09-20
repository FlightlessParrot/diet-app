<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Payment extends Model
{
    use HasFactory;

    public function specialist() : BelongsTo
    {
        return $this->belongsTo(Specialist::class);
    }

    public function subscription() :HasOne
    {
        return $this->hasOne(Subscription::class);
    }

    public function Offer() : BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    public function discount() : BelongsTo
    {
        return $this->belongsTo(Discount::class);
    }

   
}
