<?php

namespace App\Models\Franchise;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPayment extends Model
{
    use HasFactory;

    protected $table = "product_payments";

    protected $fillable = ['franchise_id', 'user_id', 'referral_code', 'product_amount', 'payment_date'];
}
