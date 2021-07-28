<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use App\Models\Franchise\ProductPayment;
use App\Models\User\Reward;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::where('parent_id', Auth::user()->id)->get();
        $allMenus = User::pluck('fullname', 'referral_code','id', 'index')->all();
        $items = array();
        $items1 = array();
        $items2 = array();
        $items3 = array();
        $items4 = array();
        $items5 = array();
        foreach($users as $user)
        {
            if(!empty($user->id)){
                $levelPayment = ProductPayment::where('user_id', $user->id)->where('product_amount', 3000)->first();
                if(!empty($levelPayment)){
                    $items[] = $levelPayment->payment_date;
                }
                foreach($user->user_childs as $child)
                {
                    if(!empty($child->id)){
                        $levelPayment1 = ProductPayment::where('user_id', $child->id)->where('product_amount', 3000)->first();
                        if(!empty($levelPayment1)){
                            $items1[] = $levelPayment1->payment_date;
                        }
                        foreach($child->user_childs as $child)
                        {
                            if(!empty($child->id)){
                                $levelPayment2 = ProductPayment::where('user_id', $child->id)->where('product_amount', 3000)->first();
                                if(!empty($levelPayment2)){
                                    $items2[] = $levelPayment2->payment_date;
                                }
                                foreach($child->user_childs as $child)
                                {
                                    if(!empty($child->id)){
                                        $levelPayment3 = ProductPayment::where('user_id', $child->id)->where('product_amount', 3000)->first();
                                        if(!empty($levelPayment3)){
                                            $items3[] = $levelPayment3->payment_date;
                                        }
                                        foreach($child->user_childs as $child)
                                        {
                                            if(!empty($child->id)){
                                                $levelPayment4 = ProductPayment::where('user_id', $child->id)->where('product_amount', 3000)->first();
                                                if(!empty($levelPayment4)){
                                                    $items4[] = $levelPayment4->payment_date;
                                                }
                                                foreach($child->user_childs as $child)
                                                {
                                                    if(!empty($child->id)){
                                                        $levelPayment5 = ProductPayment::where('user_id', $child->id)->where('product_amount', 3000)->first();
                                                        if(!empty($levelPayment5)){
                                                            $items5[] = $levelPayment5->payment_date;
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        $userProductPayment = ProductPayment::where('user_id', Auth::user()->id)->where('product_amount', 2500)->first();
        $rewards = Reward::where('user_id', Auth::user()->id)->where('verified', 1)->get();
        return view('distributor.dashboard', compact('users', 'allMenus', 'items', 'items1', 'items2', 'items3', 'items4', 'items5', 'userProductPayment','rewards'));
    }
}
