<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    protected $fillable = [
        'name',
        'email',
        'password',
         'avatar', // নিশ্চিত করুন এটি fillable এ আছে
        'role',
    ];

        public function arguments()
    {
        return $this->hasMany(Argument::class);
    }

    // ২. ডিবেটে অংশগ্রহণের তথ্য
    public function debates()
    {
        return $this->belongsToMany(Debate::class, 'debate_participants')
                    ->withPivot('side')
                    ->withTimestamps();
    }
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
}
