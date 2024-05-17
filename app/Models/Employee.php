<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $table = 'employees';
    protected $primaryKey = 'employee_id';
    protected $fillable = [
        'person_id',
        'name',
        'email',
        'avatar',
        'address',
        'position_id',
        'date_of_birth'
    ];
    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id');
    }
    
}
