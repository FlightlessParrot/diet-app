<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SocialMedia extends Model
{
    use HasFactory;
    protected $fillable = [
        'url',
        'type'
    ];
    public function specialist() : BelongsTo
    {
        return $this->belongsTo(Specialist::class);
    }
}
