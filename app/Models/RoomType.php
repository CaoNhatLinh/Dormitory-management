<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    use HasFactory;
    protected $primaryKey = 'room_type_id';
    public $timestamps = false;
    public function rooms()
    {
        return $this->hasMany(Room::class, 'room_type_id');
    }
}
