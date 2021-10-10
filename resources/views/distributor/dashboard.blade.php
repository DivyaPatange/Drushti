<?php 
use App\Models\User\UserIncome;
use App\Models\User\UserSalary;
use App\Models\User\Reward;
?>
@extends('distributor.distributor_layout.main')
@section('title', 'Dashboard')
@section('page_title', 'Dashboard')
@section('customcss')

@endsection
@section('content')
<!-- Widgets -->
<ul style="display:none"> 
    @foreach($users as $key => $user)
    <li>
        <?php
            $payment = DB::table('product_payments')->where('user_id', $user->id)->where('product_amount', 3000)->where('plan', '10500')->first();
            if($payment){
                $userIncome = DB::table('user_incomes')->where('child_id', $user->id)->where('user_id', Auth::user()->id)->where('plan', '10500')->first();
                // dd($fastTrack);
                $userSalary = DB::table('user_salaries')->where('child_id', $user->id)->where('user_id', Auth::user()->id)->first();
                // dd(empty($fastTrack));
                if(empty($userIncome))
                {
                    $userIncome = new UserIncome();
                    $userIncome->user_id = Auth::user()->id;
                    $userIncome->child_id = $user->id;
                    $userIncome->level = 1;;
                    $userIncome->product_amount = $payment->product_amount +  7000;
                    $userIncome->payment_date = $payment->payment_date;
                    $userIncome->income_amount = 0.06 * ($payment->product_amount +  7000);
                    $userIncome->admin_charges = 0.1 * (0.06 * ($payment->product_amount +  7000));
                    $userIncome->net_income = (0.06 * ($payment->product_amount +  7000)) - (0.1 * (0.06 * ($payment->product_amount +  7000)));
                    $userIncome->plan = 10500;
                    $userIncome->save();
                }

                if(empty($userSalary))
                {
                    $userSalary = new UserSalary();
                    $userSalary->user_id = Auth::user()->id;
                    $userSalary->child_id = $user->id;
                    $userSalary->level = 1;
                    $userSalary->product_amount = $payment->product_amount +  7000;
                    $userSalary->payment_date = $payment->payment_date;
                    $userSalary->income_amount = 0.01 * ($payment->product_amount +  7000);
                    $userSalary->admin_charges = 0.1 * (0.01 * ($payment->product_amount +  7000));
                    $userSalary->net_income = (0.01 * ($payment->product_amount +  7000)) - (0.1 * (0.01 * ($payment->product_amount +  7000)));
                    $userSalary->save();
                }
                $count = 10;
                $reward = DB::table('rewards')->where('user_id', Auth::user()->id)->where('plan', '10500')->where('level', 1)->first();
                if(empty($reward))
                {
                    $reward = new Reward();
                    $reward->user_id = Auth::user()->id;
                    $reward->level = 1;
                    $reward->total_joiner = 10;
                    $reward->joiner_added = count($items);
                    $reward->reward = 10*10000;
                    $reward->reward_amt = (0.06 * 10 * 10000);
                    $reward->admin_charges = 0.1 * ($reward->reward_amt);
                    $reward->net_income = $reward->reward_amt - $reward->admin_charges;
                    $reward->status = "Not Qualified";
                    $reward->date = max($items);
                    $reward->plan = 10500;
                    $reward->save();
                }
                else{
                    if($count == count($items))
                    {
                        $status = "Qualified";
                    }
                    else{
                        $status = "Not Qualified";
                    }
                    $result = DB::table('rewards')->where('user_id', Auth::user()->id)->where('plan', '10500')->where('level', 1)->update(['joiner_added' => count($items), 'status' => $status, 'date' => max($items)]);
                }
            }
        ?>
        @if(count($user->childs))
            @include('distributor.treeview.child',['user_childs' => $user->user_childs])
        @endif
    </li>
    @endforeach
</ul>
<div class="row clearfix">
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-pink hover-expand-effect">
            <div class="icon">
                <i class="material-icons">playlist_add_check</i>
            </div>
            <div class="content">
                @if(empty($userProductPayment))
                <div class="text">Product Payment</div>
                <div class="">Pending</div>
                @else
                <div class="text">Product Amount</div>
                <div class="number count-to" data-from="0" data-to="{{ $userProductPayment->product_amount }}" data-speed="1000" data-fresh-interval="20"></div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-cyan hover-expand-effect">
            <div class="icon">
                <i class="material-icons">help</i>
            </div>
            <div class="content">
                <div class="text">Admin Amount</div>
                <div class="number count-to" data-from="0" data-to="7500" data-speed="1000" data-fresh-interval="20"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-light-green hover-expand-effect">
            <div class="icon">
                <i class="material-icons">forum</i>
            </div>
            <div class="content">
                <div class="text">Reward</div>
                @if(count($rewards) > 0)
                <div class="number count-to" data-from="0" data-to="{{ $rewards->sum('net_income') }}" data-speed="1000" data-fresh-interval="20"></div>
                @else
                <div class="number count-to" data-from="0" data-to="0" data-speed="1000" data-fresh-interval="20"></div>
                @endif
            </div>
        </div>
    </div>
</div>
<!-- #END# Widgets -->

@endsection
@section('customjs')
<!-- Flot Charts Plugin Js -->
<script src="{{ asset('adminAsset/plugins/flot-charts/jquery.flot.js') }}"></script>
<script src="{{ asset('adminAsset/plugins/flot-charts/jquery.flot.resize.js') }}"></script>
<script src="{{ asset('adminAsset/plugins/flot-charts/jquery.flot.pie.js') }}"></script>
<script src="{{ asset('adminAsset/plugins/flot-charts/jquery.flot.categories.js') }}"></script>
<script src="{{ asset('adminAsset/plugins/flot-charts/jquery.flot.time.js') }}"></script>
<script src="{{ asset('adminAsset/js/admin.js') }}"></script>
<script src="{{ asset('adminAsset/js/pages/index.js') }}"></script>
@endsection