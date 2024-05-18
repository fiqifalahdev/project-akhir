<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AppointmentRequest extends Model
{
    use HasFactory;

    protected $table = 'appointment_request';
    protected $fillable = ['appointment_date', 'appointment_time', 'requester_id', 'recipient_id', 'status'];

    public function requester()
    {
        return $this->belongsTo(User::class, 'requester_id', 'id');
    }

    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_id', 'id');
    }

    /**
     * Boot the model
     * 
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->appointment_id = (string) Str::uuid();
        });
    }
}
