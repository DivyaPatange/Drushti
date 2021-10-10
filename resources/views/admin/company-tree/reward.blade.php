<?php 
use App\Models\User\Reward;
?>
<ul>
@foreach($user_childs as $child)
@if($loop->depth <= 7)
    <li>
        <?php
            $payment = DB::table('product_payments')->where('user_id', $child->id)->where('product_amount', 3000)->first();
            if($loop->depth == 3)
            {
                if(count($items1) > 2){
                    $date = max($items1);
                }
                $joiners = count($items1);
                $rewardPer = 0.02;
                $rewardAmt = 100*10000;
                $count = 100;
            }
            elseif($loop->depth == 4)
            {
                if(count($items2) > 2){
                    $date = max($items2);
                }
                $joiners = count($items2);
                $rewardPer = 0.01;
                $rewardAmt = 1000*10000;
                $count = 1000;
            }
            elseif($loop->depth == 5)
            {
                if(count($items3) > 2){
                    $date = max($items3);
                }
                $joiners = count($items3);
                $rewardPer = 0.01;
                $rewardAmt = 10000*10000;
                $count = 10000; 
            }
            elseif($loop->depth == 6)
            {
                if(count($items4) > 2){
                    $date = max($items4);
                }
                $joiners = count($items4);
                $rewardPer = 0.005;
                $rewardAmt = 100000*10000;
                $count = 100000;
            }
            elseif($loop->depth == 7)
            {
                if(count($items5) > 2){
                    $date = max($items5);
                }
                $joiners = count($items5);
                $rewardPer = 0.005;
                $rewardAmt = 1000000*10000;
                $count = 1000000;
            }
            if($payment){
                $depth = $loop->depth - 1;
                $reward = DB::table('rewards')->where('user_id', $joiner->id)->where('level', $depth)->where('plan', 10500)->first();
         
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
                        $reward->plan = 10500;
                        $reward->date = $date;
                        $reward->save();
                    }
                }
                else{
                    if ($joiners > 2) {
                        if($count == $joiners)
                        {
                            $status = "Qualified";
                        }
                        else{
                            $status = "Not Qualified";
                        }
                        $result = DB::table('rewards')->where('user_id', $joiner->id)->where('level', $depth)->where('plan', 10500)->update(['joiner_added' => $joiners, 'status' => $status, 'date' => $date]);
                    }
                }
            }
        ?>
        
        @if(count($child->childs))
            @include('admin.company-tree.reward',['user_childs' => $child->user_childs])
        @endif
    </li>
@endif
@endforeach
</ul>