<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;
    protected $table = 'positions';
    protected $primaryKey = 'position_id';
    public $timestamps = false;
    protected $fillable = [
        'position_name'
    ];
    public function employees()
    {
        return $this->hasMany(Employee::class, 'position_id');
    }

}
