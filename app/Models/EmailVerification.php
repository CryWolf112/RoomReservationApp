<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailVerification extends Model
{
    use HasFactory;

    protected $table = 'email_verifications';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'email',
        'email_confirmed',
        'created_at',
        'expires_at'
    ];

    protected $hidden = [
        'token'
    ];
}
