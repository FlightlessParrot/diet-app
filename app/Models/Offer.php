<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orchid\Screen\AsSource;

class Offer extends Model
{
    use HasFactory, SoftDeletes, AsSource;

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
