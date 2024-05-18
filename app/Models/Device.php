<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $primaryKey='device_id';
    protected $table='devices';
    protected $fillable = [
        'device_name',
        'quantity',
        'rental_price',
        'original_price',
        'device_type_id'
    ];
    public function deviceType()
    {
        return this-> belongsTo(DeviceType::class,'device_type_id');
    }
    
    public function deviceRentals()
    {
        return $this->hasMany(DeviceRental::class, 'device_id');
    }
}