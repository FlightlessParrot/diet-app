<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orchid\Screen\AsSource;

class Discount extends Model
{
    use HasFactory, AsSource, SoftDeletes;

    protected $fillable = ['limited','code','amount','quantity'];

    public function payments() : HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
