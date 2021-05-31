<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FranchiseShopdetails extends Model
{
    use HasFactory;

    protected $table = "franchise_shopdetails";
    protected $fillable = ['franchise_id', 'shop_name', 'shop_registration_id'];
}
