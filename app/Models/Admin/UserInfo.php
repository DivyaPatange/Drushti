<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    use HasFactory;

    protected $table = "user_infos";

    protected $fillable = ['user_id', 'nominee_relation', 'nominee_name'];
}
