<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    use HasFactory;

    protected $table = "rewards";

    protected $fillable = ['user_id', 'level', 'reward', 'business', 'admin_charges', 'net_income', 'status', 'date', 'verified'];
}
