<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    use HasFactory;
    protected $fillable = ['city','province_id','code','line_1','line_2'];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function Province() : BelongsTo
    {
        return $this->belongsTo(Province::class);
    }
}
