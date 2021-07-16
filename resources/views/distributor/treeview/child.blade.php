<?php 
use App\Models\User\UserIncome;
use App\Models\User\UserSalary;
use App\Models\User\Reward;

?>
<ul>
@foreach($user_childs as $child)
@if($loop->depth <= 6)
    @if(!empty($child->id))
    <li>
    <?php
            $payment = DB::table('product_payments')->where('user_id', $child->id)->where('product_amount', 3000)->first();
            if($loop->depth == 2)
            {
                if(count($items1) > 2){
                    $date = max($items1);
                }
                $joiners = count($items1);
                $rewardPer = 0.02;
                $rewardAmt = 100*10000;
                $count = 100;
                $incomePer = 0.02;
                $salaryPer = 0.002;
            }
            elseif($loop->depth == 3)
            {
                if(count($items2) > 2){
                    $date = max($items2);
                }
                $joiners = count($items2);
                $rewardPer = 0.01;
                $rewardAmt = 1000*10000;
                $count = 1000;
                $incomePer = 0.01;
                $salaryPer = 0.002;
            }
            elseif($loop->depth == 4)
            {
                if(count($items3) > 2){
                    $date = max($items3);
                }
                $joiners = count($items3);
                $rewardPer = 0.01;
                $rewardAmt = 10000*10000;
                $count = 10000; 
                $incomePer = 0.01;
                $salaryPer = 0.002;
            }
            elseif($loop->depth == 5)
            {
                if(count($items4) > 2){
                    $date = max($items4);
                }
                $joiners = count($items4);
                $rewardPer = 0.005;
                $rewardAmt = 100000*10000;
                $count = 100000;
                $incomePer = 0.005;
                $salaryPer = 0.0015;
            }
            elseif($loop->depth == 6)
            {
                if(count($items5) > 2){
                    $date = max($items5);
                }
                $joiners = count($items5);
                $rewardPer = 0.005;
                $rewardAmt = 1000000*10000;
                $count = 1000000;
                $incomePer = 0.005;
                $salaryPer = 0.0015;
            }
            if($payment){
                $userIncome = DB::table('user_incomes')->where('child_id', $child->id)->where('user_id', Auth::user()->id)->first();
                // dd($userIncome);
                $userSalary = DB::table('user_salaries')->where('child_id', $child->id)->where('user_id', Auth::user()->id)->first();
                // dd(empty($fastTrack));
                if(empty($userIncome))
                {
                    $userIncome = new UserIncome();
                    $userIncome->user_id = Auth::user()->id;
                    $userIncome->child_id = $child->id;
                    $userIncome->level = $loop->depth;;
                    $userIncome->product_amount = $payment->product_amount +  7000;
                    $userIncome->payment_date = $payment->payment_date;
                    $userIncome->income_amount = $incomePer * ($payment->product_amount +  7000);
                    $userIncome->admin_charges = 0.1 * ($incomePer * ($payment->product_amount +  7000));
                    $userIncome->net_income = ($incomePer * ($payment->product_amount +  7000)) - (0.1 * ($incomePer * ($payment->product_amount +  7000)));
                    $userIncome->save();
                    // dd($fastTrack);
                }

                if(empty($userSalary))
                {
                    $userSalary = new UserSalary();
                    $userSalary->user_id = Auth::user()->id;
                    $userSalary->child_id = $child->id;
                    $userSalary->level = $loop->depth;
                    $userSalary->product_amount = $payment->product_amount +  7000;
                    $userSalary->payment_date = $payment->payment_date;
                    $userSalary->income_amount = $salaryPer * ($payment->product_amount +  7000);
                    $userSalary->admin_charges = 0.1 * ($salaryPer * ($payment->product_amount +  7000));
                    $userSalary->net_income = ($salaryPer * ($payment->product_amount +  7000)) - (0.1 * ($salaryPer * ($payment->product_amount +  7000)));
                    $userSalary->save();
                }
                $reward = DB::table('rewards')->where('user_id', Auth::user()->id)->where('level', $loop->depth)->first();
                if(empty($reward))
                {
                    if($joiners > 2){
                        $reward = new Reward();
                        $reward->user_id = Auth::user()->id;
                        $reward->level = $loop->depth;
                        $reward->total_joiner = $count;
                        $reward->joiner_added = $joiners;
                        $reward->reward = $rewardAmt;
                        $reward->reward_amt = ($rewardPer * $rewardAmt);
                        $reward->admin_charges = 0.1 * ($reward->reward_amt);
                        $reward->net_income = $reward->reward_amt - $reward->admin_charges;
                        $reward->status = "Not Qualified";
                        $reward->date = $date;
                        $reward->save();
                    }
                }
                else{
                    if($count == $joiners)
                    {
                        $status = "Qualified";
                    }
                    else{
                        $status = "Not Qualified";
                    }
                    $result = DB::table('rewards')->where('user_id', Auth::user()->id)->where('level', $loop->depth)->update(['joiner_added' => $joiners, 'status' => $status, 'date' => $date]);
                }
            }
        ?>
        
        @if(count($child->childs))
            @include('distributor.treeview.child',['user_childs' => $child->user_childs])
        @endif
    </li>
    @endif
@endif
@endforeach
</ul>