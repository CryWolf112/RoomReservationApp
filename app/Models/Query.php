<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Query extends Model
{
    use HasFactory;

    protected $table = 'queries';
    public $timestamps = false;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'subject',
        'message',
        'country_id'
    ];
}
