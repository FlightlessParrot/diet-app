<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subscription extends Model
{
    use HasFactory;

    public function specialist() : BelongsTo
    {
        return $this->belongsTo(Specialist::class);
    }

    public function payment() : BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }
    
}
