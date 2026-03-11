<?php

namespace App\Models;

use App\Traits\Reservations\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    /** @use HasFactory<\Database\Factories\ReservationFactory> */
    use HasFactory ,Searchable;

    protected $fillable = ['guests' ,'checkout_date','checkin_date' ,'hotel_id' ,'room_id'];

    public function hotel():BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }

    public function room():BelongsTo
    {
        return $this->belongsTo(Room::class);
    }


}
