<?php 
use App\Models\User\UserIncome;
use App\Models\User\UserSalary;
use App\Models\User\Reward;
?>
@extends('distributor.distributor_layout.main')
@section('title', 'My Business')
@section('page_title', 'My Business')
@section('customcss')

@endsection
@section('content')
<!-- Widgets -->
<ul style="display:none"> 
    @foreach($users as $key => $user)
    @if(!empty($user->id))
    <li>
        <?php
            $payment = DB::table('product_payments')->where('user_id', $user->id)->where('product_amount', 3000)->first();
            if($payment){
                $userIncome = DB::table('user_incomes')->where('child_id', $user->id)->where('user_id', Auth::user()->id)->first();
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
                    $userIncome->save();
                    // dd($fastTrack);
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
                $reward = DB::table('rewards')->where('user_id', Auth::user()->id)->where('level', 1)->first();
                if(empty($reward))
                {
                    $reward = new Reward();
                    $reward->user_id = Auth::user()->id;
                    $reward->level = 1;
                    $reward->total_joiner = 10;
                    $reward->joiner_added = count($items);
                    $reward->reward = 10*10000;
                    $reward->reward_amt = (0.05 * 10 * 10000);
                    $reward->admin_charges = 0.1 * ($reward->reward_amt);
                    $reward->net_income = $reward->reward_amt - $reward->admin_charges;
                    $reward->status = "Not Qualified";
                    $reward->date = max($items);
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
                    $result = DB::table('rewards')->where('user_id', Auth::user()->id)->where('level', 1)->update(['joiner_added' => count($items), 'status' => $status, 'date' => max($items)]);
                }
            }
        ?>
        @if(count($user->childs))
            @include('distributor.treeview.child',['childs' => $user->childs])
        @endif
    </li>
    @endif
    @endforeach
</ul>
<?php 
$newarray = array_merge($items, $items1, $items2, $items3, $items4, $items5);
$startDate = date('Y-m-1');
$endDate = date('Y-m-t');
$current = array();
$previous = array();
for($i=0; $i < count($newarray); $i++)
{
    if(($newarray[$i] >= $startDate) && ($newarray[$i] <= $endDate))
    {
        $current[] = $newarray[$i];
    }
    else{
        $previous[] = $newarray[$i];
    }
}
?>
<div class="row clearfix">
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box hover-expand-effect">
            <div class="icon bg-red">
                <i class="material-icons">assessment</i>
            </div>
            <div class="content">
                <div class="text">Current Joining</div>
                <div class="number count-to" data-from="0" data-to="{{ count($current) }}" data-speed="1500" data-fresh-interval="5"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box hover-expand-effect">
            <div class="icon bg-indigo">
                <i class="material-icons">account_circle</i>
            </div>
            <div class="content">
                <div class="text">Previous Joining</div>
                <div class="number count-to" data-from="0" data-to="{{ count($previous) }}" data-speed="1500" data-fresh-interval="5"></div>
            </div>
        </div>
    </div>
    <!--<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">-->
    <!--    <div class="info-box bg-light-green hover-expand-effect">-->
    <!--        <div class="icon">-->
    <!--            <i class="material-icons">forum</i>-->
    <!--        </div>-->
    <!--        <div class="content">-->
    <!--            <div class="text">Reward</div>-->
    <!--            <div class="number count-to" data-from="0" data-to="2500" data-speed="1000" data-fresh-interval="20"></div>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--</div>-->
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