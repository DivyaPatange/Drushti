<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FranchiseBankdetails extends Model
{
    use HasFactory;
    protected $table = "franchise_bankdetails";
    protected $fillable = ['franchise_id', 'bank_name', 'branch_name', 'ifsc_code', 'acc_no', 'acc_holder_name'];
}
