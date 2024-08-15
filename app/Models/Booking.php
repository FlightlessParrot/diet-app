<?php

namespace App\Models;

use App\Events\BookingDeleted;
use App\Events\BookingUpdated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    use HasFactory;

    protected $with = ['address'];
    protected $dispatchesEvents = [
        'deleted' => BookingDeleted::class,
        'updated' => BookingUpdated::class,
    ];
    protected $fillable = ['start_date', 'end_date'];

    public function specialist() : BelongsTo
    {
        return $this->belongsTo(Specialist::class);
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function address() : BelongsTo
    {
        return $this->belongsTo(Address::class);
    }


}
