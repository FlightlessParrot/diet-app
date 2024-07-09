<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['name','start_date','end_date'];


    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'start_date' => 'datetime:Y-m-d',
            'end_date'=>'datetime:Y-m-d'
        ];
    }
    public function specialist() : BelongsTo
    {
        return $this->belongsTo(Specialist::class);
    }
}
