<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Http\Middleware\Authenticate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    
    protected $table = 'users';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'birth_date',
        'gender',
        'username',
        'normalized_username',
        'email',
        'normalized_email',
        'account_confirmed',
        'country_id'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $casts = [
        'date_created' => 'datetime',
    ];

    public function roles(){
        return $this->belongsToMany(Role::class, 'users_roles');
    }

    public function isAdmin()
    {
        foreach ($this->roles()->get() as $role)
        {
            if ($role->name == 'admin')
            {
                return true;
            }
        }

        return false;
    }

    public function hasRole($role){
        foreach ($this->roles()->get() as $role)
        {
            if ($role->name == $role)
            {
                return true;
            }
        }

        return false;
    }
}
