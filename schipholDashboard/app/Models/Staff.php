<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Staff extends Authenticatable
{
    use Notifiable;
    protected $table = 'staff';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', //coordinator directeur
        'employee_id',
        'department',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
    ];

    //role helpers  
    public function isCoordinator(): bool
    {
        return $this->role === 'coordinator';
    }

    public function isDirecteur(): bool
    {
        return $this->role === 'directeur';
    }

    public function hasRole(string ...$roles): bool
    {
        return in_array($this->role, $roles, true);
    }
}
