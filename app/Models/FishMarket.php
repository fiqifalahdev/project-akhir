<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FishMarket extends Model
{
    use HasFactory;

    protected $table = 'fish_markets';

    protected $fillable = [
        'name',
        'address',
        'phone',
        'latitude',
        'longitude',
    ];
}
