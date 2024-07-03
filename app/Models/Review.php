<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasFactory;

    protected $fillable=['text','grade'];

    public function specialist() : BelongsTo
    {
        return $this->belongsTo(Specialist::class);
    }
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
