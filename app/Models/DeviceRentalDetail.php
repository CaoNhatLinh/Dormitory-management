<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalDetail extends Model
{
    use HasFactory;
    protected $primaryKey = 'rental_detail_id';
    protected $table = 'device_rental_details';
    protected $fillable = [
        'rental_detail_id',
        'status'
    ];

    public function deviceRental()
    {
        return $this->belongsTo(DeviceRental::class, 'device_rental_id');
    }
    public function device()
    {
        return $this->belongsTo(Device::class,'device_id');
    }
}
