<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Target extends Model
{
    use HasFactory;

    protected function name() : Attribute
    {
        return Attribute::make(
            set: fn (string $value)=>strtolower($value),
            get: fn (string $value)=>ucfirst($value),
        );
    }
    public function specialists() : BelongsToMany
    {
        return $this->belongsToMany(Specialist::class);
    }
}
