<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'fullname',
        'email',
        'password',
        'username',
        'mobile',
        'referral_code',
        'address',
        'password_1',
        'reg_date', 
        'parent_id', 'index', 'side', 'sub_parent_id', 'sponsor_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function childs() {
        return $this->hasMany('App\Models\User','sponsor_id','id') ;
    }

    public function user_childs() {
        return $this->hasMany('App\Models\User','parent_id','id') ;
    }
}
