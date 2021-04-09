<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBankDetail extends Model
{
    use HasFactory;
    protected $table = "user_bank_details";

    protected $fillable = ['user_id', 'bank_name', 'branch_name', 'ifsc_code', 'acc_no', 'acc_holder_name'];
}
