<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Anonym extends Model
{
    use HasFactory;

    protected $fillable = ['full_name','email','booking_id'];
    protected $with = ['phone'];
    public function Booking() : BelongsTo {
        return $this->belongsTo(Booking::class);
    }

    public function phone() : MorphOne
    {
        return $this->morphOne(Phone::class,'phoneable');
    }
}
