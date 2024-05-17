<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceRental extends Model
{
    use HasFactory;
    protected $primaryKey = 'device_rental_id';
    protected $table = 'device_rentals';
    protected $fillable = [
        'device_id',
        'total_rental_price',
        'quantity',
        'monthly_rental_device_id'
    ];

    public function device()
    {
        return $this->belongsTo(Device::class, 'device_id');
    }

    public function rentalDetails()
    {
        return $this->hasMany(RentalDetail::class, 'rental_id');
    }
}
