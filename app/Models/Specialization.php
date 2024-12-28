<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Specialization extends Model
{
    use HasFactory;

    public function specialists() : BelongsToMany
    {
        return $this->belongsToMany(Specialist::class);
    }
}
