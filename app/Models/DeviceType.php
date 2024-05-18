<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceType extends Model
{
    use HasFactory;
    protected $primaryKey = 'device_type_id';
    protected $table = 'device_types';
    public $timestamps = false;
    protected $fillable = [
        'device_type_name'
    ];

    public function devices()
    {
        return $this->hasMany(Device::class, 'device_type_id');
    }
}
