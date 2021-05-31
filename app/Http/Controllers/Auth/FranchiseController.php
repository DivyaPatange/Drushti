<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FranchiseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:franchise');
    }

    public function index()
    {
        return view('franchise.dashboard');
    }
}
