<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Orchid\Screen\AsSource;

class Address extends Model
{
    use HasFactory, AsSource;
    protected $fillable = ['city','province_id','code','line_1','line_2','park'];
    protected $with = ['province'];
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function Province() : BelongsTo
    {
        return $this->belongsTo(Province::class);
    }
    public function Addressable() : MorphTo
    {
        return $this->morphTo();
    }

    public function bookings() : HasMany
    {
        return $this->hasMany(Address::class);
    }
}
