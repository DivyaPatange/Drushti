<?php
    // dd(count($childs));
?>
@if(count($childs) == 1)
<ul>
    @foreach($childs->sortBy('side') as $key => $child)
    <?php 
        $productPayment = DB::table('product_payments')->where('user_id', $child->id)->where('product_amount', 3000)->first();
        if(empty($productPayment))
        {
            $color = "red";
        }
        else{
            $color = "green";
        }
    ?>
    @if($key == 0)
        @if($child->side  == "L")
        <li>
            <span class="tf-nc" style="font-size:15px;">
            <a href="#">
                <i class="fas fa-atom" style="font-size:30px; color:{{ $color }};"></i></a>
            <br>
            {{ $child->fullname }}
            <br>
            {{ $child->referral_code }}
            </span>
            @if(count($child->childs))
                @include('distributor.treeview.manageChild',['childs' => $child->childs])                                                
            @endif
        </li>
        <li style="visibility:hidden">
                                    
            <span class="tf-nc" style="font-size:15px;">
                <a href="#">
                    <i class="fas fa-atom" style="font-size:30px; color:red;"></i></a>
                <br>
        </li>
        @else
        <li style="visibility:hidden">
                                    
            <span class="tf-nc" style="font-size:15px;">
                <a href="#">
                    <i class="fas fa-atom" style="font-size:30px; color:red;"></i></a>
                <br>
        </li>
        <li>
                                    
            <span class="tf-nc" style="font-size:15px;">
                <a href="#">
                    <i class="fas fa-atom" style="font-size:30px; color:{{ $color }};"></i></a>
                <br>
                {{ $child->fullname }}
                <br>
                {{ $child->referral_code }}
                </span>
            @if(count($child->childs))
                @include('distributor.treeview.manageChild',['childs' => $child->childs])                                                
            @endif
        </li>
        @endif
    @endif
    @endforeach
</ul>
@else
<ul>
    @foreach($childs->sortBy('side') as $key => $child)
    <?php 
        $productPayment = DB::table('product_payments')->where('user_id', $child->id)->where('product_amount', 3000)->first();
        if(empty($productPayment))
        {
            $color = "red";
        }
        else{
            $color = "green";
        }
    ?>
    <li>
                                    
        <span class="tf-nc" style="font-size:15px;">
            <a href="#">
                <i class="fas fa-atom" style="font-size:30px; color:{{ $color }};"></i></a>
            <br>
            {{ $child->fullname }}
            <br>
            {{ $child->referral_code }}
            </span>
        @if(count($child->childs))
            @include('distributor.treeview.manageChild',['childs' => $child->childs])                                                
        @endif
    </li>
    @endforeach
</ul>
@endif