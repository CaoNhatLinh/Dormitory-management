<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $primaryKey = 'student_id';
    public $timestamps = false;
    public function contract()
    {
        return $this->belongsTo(Contract::class,'student_id','student_id');
    }
}
