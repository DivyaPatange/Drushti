<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FranchiseKycdetails extends Model
{
    use HasFactory;

    protected $table = "franchise_kycdetails";
    protected $fillable = ['franchise_id', 'pan_no', 'aadhar_no', 'pan', 'cheque', 'user_img', 'verified'];
}
