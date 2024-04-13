<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    // use HasFactory;

    protected $table = 'location';
    protected $guarded = ['id'];

    // =============== Relationship ===============
    public function user(): HasMany
    {
        return $this->hasMany(User::class);
    }

    // Define the Custom Factory
    protected static function newFactory(): Factory
    {
        return \Database\Factories\UserLocationFactory::new();
    }
}
