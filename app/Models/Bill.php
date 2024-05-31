<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;
    protected $table = 'bills';
    protected $primaryKey = 'bill_id';
    public $timestamps = false;
    
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }
}