<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserIncome extends Model
{
    use HasFactory;

    protected $table = "user_incomes";

    protected $fillable = ['user_id', 'child_id', 'level', 'product_amount', 'payment_date', 'income_amount', 'admin_charges', 'net_income', 'settled_status', 'settled_date'];
}
