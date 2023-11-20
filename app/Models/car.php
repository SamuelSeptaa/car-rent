<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class car extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function rents()
    {
        return $this->hasMany(rent::class, 'car_id');
    }
}
