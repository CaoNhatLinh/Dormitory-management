<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceRental extends Model
{
    use HasFactory;
    protected $primaryKey = 'device_rental_id';
    protected $table = 'device_rentals';
    public $timestamps = false;
    protected $fillable = [
        'room_id',
        'total_rental_price',
        'quantity',
        'date_device_rental',
        'status'
    ];

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function deviceRentalDetails()
    {
        return $this->hasMany(DeviceRentalDetail::class, 'rental_id');
    }
    public function rentalDetails()
    {
        return $this->hasMany(DeviceRentalDetail::class, 'device_rental_id', 'device_rental_id');
    }
    
}
