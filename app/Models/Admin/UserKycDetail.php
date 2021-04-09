<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserKycDetail extends Model
{
    use HasFactory;

    protected $table = "user_kyc_details";

    protected $fillable = ['user_id', 'pan_no', 'aadhar_no', 'user_img', 'pan', 'cheque'];
}
