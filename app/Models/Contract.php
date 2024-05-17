<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;
    protected $primaryKey = 'contract_id';
    protected $table = 'contracts';
    public $timestamps = false;

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id', 'room_id');
    }
}
