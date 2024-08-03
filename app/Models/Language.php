<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Language extends Model
{
    use HasFactory;

   

    protected function name() : Attribute
    {
        return Attribute::make(
            set: fn (string $value) => strtolower($value),
        );
    }
    public function specialist() : BelongsTo
    {
        return $this->belongsTo(Specialist::class);
    }

}
