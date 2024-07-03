<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Orchid\Attachment\Attachable;
use Orchid\Attachment\Models\Attachment;
use Orchid\Screen\AsSource;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Specialist extends Model
{
    use HasFactory, AsSource, Attachable;

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
    /**
     * Get and set the specialist's first name.
     */
    public function name()
    {
        return Attribute::make(
            get: fn (string $value) => ucfirst($value),
            set: fn (string $value) => strtolower($value),
        );
    }

    /**
     * Get and set the specialist's last name.
     */
    public function surname()
    {
        return Attribute::make(
            get: fn (string $value) => ucfirst($value),
            set: fn (string $value) => strtolower($value),
        );
    }

    /**
     * Set the specialist's title.
     */
    public function title()
    {
        return Attribute::make(
            set: fn (string $value) => strtolower($value),
        );
    }

    public function icon() :HasOne
    {
        return $this->hasOne(Icon::class);
    }
   
    public function description() :MorphOne
    {
        return $this->morphOne(Description::class, 'descriptionable');
    }
     
    public function bookings() : HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews() : HasMany
    {
        return $this->hasMany(Review::class);
    }
}
