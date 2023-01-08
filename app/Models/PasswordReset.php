<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    use HasFactory;

    protected $table = 'password_resets';
    public $timestamps = false;

    protected $fillable = [
        'email',
        'created_at',
        'expires_at'
    ];

    protected $hidden = [
        'token'
    ];
}
