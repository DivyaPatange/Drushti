<?php 
use App\Models\User\Reward;
?>
<ul>
@foreach($user_childs as $child)
@if($loop->depth <= 7)
    <li>
    <?php
            $payment = DB::table('product_payments')->where('user_id', $child->id)->where('product_amount', 3000)->where('plan', '3000')->first();
            if($loop->depth == 3)
            {
                if(count($items7) > 2){
                    $date1 = max($items7);
                }
                $joiners = count($items7);
                $rewardPer = 0.03;
                $rewardAmt = 100*10000;
                $count = 100;
            }
            elseif($loop->depth == 4)
            {
                if(count($items8) > 2){
                    $date1 = max($items8);
                }
                $joiners = count($items8);
                $rewardPer = 0.02;
                $rewardAmt = 1000*10000;
                $count = 1000;
            }
            elseif($loop->depth == 5)
            {
                if(count($items9) > 2){
                    $date1 = max($items9);
                }
                $joiners = count($items9);
                $rewardPer = 0.02;
                $rewardAmt = 10000*10000;
                $count = 10000; 
            }
            elseif($loop->depth == 6)
            {
                if(count($items10) > 2){
                    $date1 = max($items10);
                }
                $joiners = count($items10);
                $rewardPer = 0.01;
                $rewardAmt = 100000*10000;
                $count = 100000;
            }
            elseif($loop->depth == 7)
            {
                if(count($items11) > 2){
                    $date1 = max($items11);
                }
                $joiners = count($items11);
                $rewardPer = 0.01;
                $rewardAmt = 1000000*10000;
                $count = 1000000;
            }
            if($payment){

                $depth = $loop->depth - 1;
                $reward = DB::table('rewards')->where('user_id', $joiner->id)->where('level', $depth)->where('plan', '3000')->first();
                if(empty($reward))
                {
                    if($joiners > 2){
                        $reward = new Reward();
                        $reward->user_id = $joiner->id;
                        $reward->level = $depth;
                        $reward->total_joiner = $count;
                        $reward->joiner_added = $joiners;
                        $reward->reward = $rewardAmt;
                        $reward->reward_amt = ($rewardPer * $rewardAmt);
                        $reward->admin_charges = 0.1 * ($reward->reward_amt);
                        $reward->net_income = $reward->reward_amt - $reward->admin_charges;
                        $reward->status = "Not Qualified";
                        $reward->date = $date1;
                        $reward->plan = 3000;
                        $reward->save();
                    }
                }
                else{
                    if($joiners > 2){
                        if($count == $joiners)
                        {
                            $status = "Qualified";
                        }
                        else{
                            $status = "Not Qualified";
                        }
                        $result = DB::table('rewards')->where('user_id', $joiner->id)->where('level', $depth)->where('plan', '3000')->update(['joiner_added' => $joiners, 'status' => $status, 'date' => $date1]);
                    }
                }
            }
        ?>
        
        @if(count($child->childs))
            @include('admin.company-tree.plan-reward',['user_childs' => $child->user_childs])
        @endif
    </li>
@endif
@endforeach
</ul>