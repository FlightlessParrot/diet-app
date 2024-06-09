<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Icon extends Model
{
    use HasFactory;

    protected $fillable = ['url','path'];

    public function specialist() : BelongsTo
    {
        return $this->belongsTo(Specialist::class);
    }
}
