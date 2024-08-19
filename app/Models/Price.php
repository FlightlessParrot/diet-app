<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchid\Screen\AsSource;
use Illuminate\Database\Eloquent\Casts\Attribute;
class Price extends Model
{
    use HasFactory, AsSource;

    protected $fillable=['price','name'];
    public function specialist() :BelongsTo
    {
        return $this->belongsTo(Specialist::class);
    }

    // protected function price(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn (string $value) => number_format($value,2),
    //     );
    // }
}
