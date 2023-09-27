<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class CarModel extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name'
    ];

    public function carBrand()
    {
        return $this->belongsTo(CarBrand::class);
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }
}
