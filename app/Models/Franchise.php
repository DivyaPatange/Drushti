<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Franchise extends Authenticatable
{
    use Notifiable;

    protected $guard = 'franchise';

    protected $table = "franchises";
    protected $fillable = [
        'fullname', 'email', 'username', 'password','mobile','nominee_name', 'nominee_relation', 'reg_date', 'address','password_1', 'parent_id', 'referral_code'
    ];
}
