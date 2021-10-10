<?php 
use App\Models\User\UserIncome;
?>
<ul>
@foreach($user_childs as $child)
@if($loop->depth <= 7)
    <li>
    <?php
        $payment = DB::table('product_payments')->where('user_id', $child->id)->where('product_amount', 3000)->where('plan', '3000')->first();
        if($loop->depth == 3)
        {
            $incomePer = 0.07;
        }
        elseif($loop->depth == 4)
        {
            $incomePer = 0.02;
        }
        elseif($loop->depth == 5)
        {
            $incomePer = 0.02;
        }
        elseif($loop->depth == 6)
        {
            $incomePer = 0.01;
        }
        elseif($loop->depth == 7)
        {
            $incomePer = 0.01;
        }
        if($payment){
            $userIncome = DB::table('user_incomes')->where('child_id', $child->id)->where('user_id', $joiner->id)->where('plan', '3000')->first();
            // dd($userIncome);
            if(empty($userIncome))
            {
                $userIncome = new UserIncome();
                $userIncome->user_id = $joiner->id;
                $userIncome->child_id = $child->id;
                $userIncome->level = $loop->depth - 1;
                $userIncome->product_amount = $payment->product_amount;
                $userIncome->payment_date = $payment->payment_date;
                $userIncome->income_amount = $incomePer * $payment->product_amount;
                $userIncome->admin_charges = 0.1 * $incomePer * $payment->product_amount;
                $userIncome->net_income = ($incomePer * $payment->product_amount) - (0.1 * $incomePer * $payment->product_amount);
                $userIncome->plan = 3000;
                $userIncome->save();
                // dd($fastTrack);
            }

        }
    ?>
        
    @if(count($child->childs))
        @include('admin.company-tree.plan-income',['user_childs' => $child->user_childs])
    @endif
    </li>
@endif
@endforeach
</ul>