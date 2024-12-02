<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    use HasRoles ,HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'last_login_at',
        'is_suspended',
        'referral_code',
        'referred_by',
        'referral_income',
        'firstName',
        'middleName',
        'lastName',
        'dateOfBirth',
        'gender',
        'phoneNumber',
        'street',
        'city',
        'state',
        'postalCode',
        'country',
        'profile_picture',
        'preferredLanguage',
        'specialAccommodations',
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }
    public function leads()
    {
        return $this->hasMany(Lead::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }


    public function chats()
    {
        return $this->hasMany(Chat::class);
    }

    public function campaigns()
    {
        return $this->hasMany(Campaign::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
    public function documents()
    {
        return $this->hasMany(Document::class);
    }


    public function courses()
{
return $this->belongsToMany(Course::class, 'course_user'); // Assuming a pivot table 'course_user'
}


/**
* Get the user that referred this user.
*/
public function referrer()
{
return $this->belongsTo(User::class, 'referred_by');
}

/**
* Get the users referred by this user.
*/
public function referrals()
{
return $this->hasMany(User::class, 'referred_by');
}




}
