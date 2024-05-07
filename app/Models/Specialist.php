<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Orchid\Screen\AsSource;

class Specialist extends Model
{
    use HasFactory, AsSource;

    protected $fillable= ['name','surname', 'title'];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function addresses() : MorphMany
    {
        return $this->morphMany(Address::class,'addressable');
    }

    public function categories() : BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }
    public function serviceCities() : BelongsToMany
    {
        return $this->belongsToMany(ServiceCity::class);
    }

    public function serviceKinds() : BelongsToMany
    {
        return $this->belongsToMany(ServiceKind::class);
    }
    public function prices() : HasMany
    {
        return $this->hasMany(Price::class);
    }
    public function cleanAndDelete() : void
    {
        
        $this->user->my_role=MyRole::where('name','user')->first()->id;
        foreach($this->addresses as $address)
        {
            $address->delete();
        }
        $this->delete();
        
    }

   
     

}
