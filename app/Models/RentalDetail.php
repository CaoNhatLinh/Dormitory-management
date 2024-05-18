<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalDetail extends Model
{
    use HasFactory;
    protected $primaryKey = 'rental_detail_id';
    protected $table = 'rental_details';
    protected $fillable = [
        'rental_id',
        'status'
    ];

    public function deviceRental()
    {
        return $this->belongsTo(DeviceRental::class, 'rental_id');
    }
}
