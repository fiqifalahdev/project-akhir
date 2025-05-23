<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'birthdate',
        'gender',
        'address',
        'role',
        'about',
        'profile_image',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    // =============== Relationship ===============
    /**
     * Get the Location associated with the user.
     * 
     * 
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'id', 'user_id', 'location');
    }

    /**
     * Get the Feeds associated with the user.
     * 
     */
    public function feeds(): HasMany
    {
        return $this->hasMany(Feed::class, 'user_id', 'id', 'feeds');
    }

    /**
     * Get the appointment requests associated with the user.
     * 
     * 
     */
    public function appointmentRequests(): HasMany
    {
        return $this->hasMany(AppointmentRequest::class, 'requester_id', 'id');
    }

    public function appointmentAcceptance(): HasMany
    {
        return $this->hasMany(AppointmentRequest::class, 'recipient_id', 'id');
    }
}
