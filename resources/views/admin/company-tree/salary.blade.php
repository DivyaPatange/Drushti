<?php 
use App\Models\User\UserSalary;
?>
<ul>
@foreach($user_childs as $child)
@if($loop->depth <= 7)
    <li>
    <?php
        $payment = DB::table('product_payments')->where('user_id', $child->id)->where('product_amount', 3000)->first();
        if($loop->depth == 3)
        {
            $salaryPer = 0.002;
        }
        elseif($loop->depth == 4)
        {
            $salaryPer = 0.002;
        }
        elseif($loop->depth == 5)
        {
            $salaryPer = 0.002;
        }
        elseif($loop->depth == 6)
        {
            $salaryPer = 0.0015;
        }
        elseif($loop->depth == 7)
        {
            $salaryPer = 0.0015;
        }
        if($payment){
            $userSalary = DB::table('user_salaries')->where('child_id', $child->id)->where('user_id', $joiner->id)->first();
           
            if(empty($userSalary))
            {
                $userSalary = new UserSalary();
                $userSalary->user_id = $joiner->id;
                $userSalary->child_id = $child->id;
                $userSalary->level = $loop->depth - 1;
                $userSalary->product_amount = $payment->product_amount +  7000;
                $userSalary->payment_date = $payment->payment_date;
                $userSalary->income_amount = $salaryPer * ($payment->product_amount +  7000);
                $userSalary->admin_charges = 0.1 * ($salaryPer * ($payment->product_amount +  7000));
                $userSalary->net_income = ($salaryPer * ($payment->product_amount +  7000)) - (0.1 * ($salaryPer * ($payment->product_amount +  7000)));
                $userSalary->save();
            }
        }
    ?>
        
    @if(count($child->childs))
        @include('admin.company-tree.salary',['user_childs' => $child->user_childs])
    @endif
    </li>
@endif
@endforeach
</ul>