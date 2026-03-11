<?php

namespace App\Models;

use App\Observers\HotelObserver;
use App\Traits\Hotels\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Hotel extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'name',
        'city',
        'country',
        'rating',
    ];

    protected static function boot(): void
    {
        parent::boot();

        // Your logic here, for example:
       Hotel::observe(HotelObserver::class);
    }
    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }


}
