<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchid\Screen\AsSource;

class Statistic extends Model
{
    use HasFactory, AsSource;

    public function specialist () : BelongsTo
    {
        return $this->belongsTo(Specialist::class);
    }

    
}
