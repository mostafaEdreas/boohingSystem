<?php

namespace App\Models;

use App\Traits\Rooms\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    /** @use HasFactory<\Database\Factories\RoomFactory> */
    use HasFactory ,Searchable;


    protected $fillable = [
        'hotel_id', 'name', 'price_per_night', 'max_occupancy', 'available_rooms' , 'rooms_count'
    ];

    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }

    public function getHotelNameAttribute()
    {
        return $this->hotel?->name;
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }
}
