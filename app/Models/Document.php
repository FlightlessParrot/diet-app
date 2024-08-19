<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Orchid\Screen\AsSource;

class Document extends Model
{
    use HasFactory, AsSource;

    public function commentable() : MorphTo
    {
        return $this->morphTo();
    }


}
