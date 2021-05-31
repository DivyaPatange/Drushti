<?php

namespace App\Models\Franchise;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminPayment extends Model
{
    use HasFactory;

    protected $table = "admin_payments";

    protected $fillable = ['admingiven', 'usergiven', 'remain', 'user_id'];
}
