<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;


use Orchid\Screen\AsSource;

class Discount extends Model
{
    use HasFactory, AsSource, SoftDeletes;

    protected $fillable = ['limited','code','amount','quantity'];

    static public function queryAvailableDiscounts() 
    {
        return self::where('limited',false)->orWhere(function(Builder $query){
            $query->where('limited',true)->where('quantity','>',0);
        });
    }
    public function payments() : HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
