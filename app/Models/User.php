<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
// use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute; // 👈 Ye custom ID format ke liye zaroori hai

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',        // 👈 Intern ya Mentor identify karne ke liye
        'phone',       // 👈 Profile Fields
        'address',     
        'university',  
        'degree',      
        'avatar',      // 👈 Profile Picture ke liye
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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

    /**
     * Accessor: Automatic "ID 01 intern" format banane ke liye
     */
    protected function formattedId(): Attribute
    {
        return Attribute::make(
            get: fn () => 'ID ' . sprintf('%02d', $this->id) . ' intern'
        );
    }
    // User model ke andar brackets { } ke last mein ye add karen:

public function attendances()
{
    return $this->hasMany(Attendance::class);
}

public function tasks()
{
    return $this->hasMany(Task::class);
}
}