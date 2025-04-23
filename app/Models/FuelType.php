<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FuelType extends Model
{
    use HasFactory;

//    protected $table = 'car_fuel_types';
//    protected $primaryKey = 'fuel_type_id';
//    public $incrementing = false;
//    protected $keyType = 'string';
//    const UPDATED_AT = null;

    public $timestamps = false;

    protected $fillable = ['name'];

    public function cars(): HasMany
    {
        return $this->hasMany(Car::class);
    }
}
