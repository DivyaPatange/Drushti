<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settlement extends Model
{
    use HasFactory;

    protected $table = "settlements";

    protected $fillable = ['month_year', 'start_date', 'end_date', 'prev_start_date', 'prev_end_date'];
}
