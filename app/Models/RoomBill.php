<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomBill extends Model
{
    use HasFactory;
    protected $primaryKey = 'room_bill_id';
    public $timestamps = false;

    protected $fillable = [
        'room_id',
        'bill_date',
        'total_room_bills',
        'electricity_price',
        'electricity_index',
        'water_price',
        'water_index',
        'status'
    ];

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id', 'room_id');
    }
}
