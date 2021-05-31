<?php 
use App\Models\User\UserIncome;
use App\Models\User\UserSalary;
use App\Models\User\Reward;
?>
@extends('distributor.distributor_layout.main')
@section('title', 'My Income')
@section('page_title', 'My Income')
@section('customcss')
<!-- Bootstrap Select Css -->
<link href="{{ asset('adminAsset/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" />
<!-- JQuery DataTable Css -->
<link href="{{ asset('adminAsset/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css') }}" rel="stylesheet">
<style>
.info-box .content{
    padding:13px 10px;
}
</style>
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
<div class="row clearfix">
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="info-box hover-zoom-effect" style="height:100px">
            <div class="icon bg-blue">
                <i class="material-icons">account_balance_wallet</i>
            </div>
            <div class="content">
                <div class="number">Income Details</div>
                <div class="text">
                    <a href="{{ route('distributor.income') }}"><button type="button" class="btn btn-primary waves-effect">View Details</button></a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="info-box hover-zoom-effect" style="height:100px">
            <div class="icon bg-pink">
                <i class="material-icons">account_balance</i>
            </div>
            <div class="content">
                <div class="number">Salary Details</div>
                <div class="text">
                    <a href="{{ route('distributor.salary') }}"><button type="button" class="btn btn-primary waves-effect">View Details</button></a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="info-box hover-zoom-effect" style="height:100px">
            <div class="icon bg-cyan">
                <i class="material-icons">assessment</i>
            </div>
            <div class="content">
                <div class="number">Reward Details</div>
                <div class="text">
                    <a href="{{ route('distributor.reward') }}"><button type="button" class="btn btn-primary waves-effect">View Details</button></a>
                </div>
            </div>
        </div>
    </div>
</div>
@yield('income_content')
<!-- #END# Widgets -->

@endsection
@section('customjs')
<!-- Jquery DataTable Plugin Js -->
<script src="{{ asset('adminAsset/plugins/jquery-datatable/jquery.dataTables.js') }}"></script>
<script src="{{ asset('adminAsset/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js') }}"></script>
<script src="{{ asset('adminAsset/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('adminAsset/plugins/jquery-datatable/extensions/export/buttons.flash.min.js') }}"></script>
<script src="{{ asset('adminAsset/plugins/jquery-datatable/extensions/export/jszip.min.js') }}"></script>
<script src="{{ asset('adminAsset/plugins/jquery-datatable/extensions/export/pdfmake.min.js') }}"></script>
<script src="{{ asset('adminAsset/plugins/jquery-datatable/extensions/export/vfs_fonts.js') }}"></script>
<script src="{{ asset('adminAsset/plugins/jquery-datatable/extensions/export/buttons.html5.min.js') }}"></script>
<script src="{{ asset('adminAsset/plugins/jquery-datatable/extensions/export/buttons.print.min.js') }}"></script>

<!-- Select Plugin Js -->
<script src="{{ asset('adminAsset/plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>

<!-- Autosize Plugin Js -->
<script src="{{ asset('adminAsset/plugins/autosize/autosize.js') }}"></script>
<!-- Moment Plugin Js -->
<script src="{{ asset('adminAsset/plugins/momentjs/moment.js') }}"></script>
<!-- Bootstrap Material Datetime Picker Plugin Js -->
<script src="{{ asset('adminAsset/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}"></script>
<!-- Bootstrap Datepicker Plugin Js -->
<script src="{{ asset('adminAsset/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('adminAsset/js/pages/forms/basic-form-elements.js') }}"></script>
<script src="{{ asset('adminAsset/js/admin.js') }}"></script>
<!-- Sparkline Chart Plugin Js -->
<script src="{{ asset('adminAsset/plugins/jquery-sparkline/jquery.sparkline.js') }}"></script>

<!-- Custom Js -->
<script src="{{ asset('adminAsset/js/pages/widgets/infobox/infobox-4.js') }}"></script>
<script>
var SITEURL = "{{ route('distributor.income')}}";
$(document).ready(function() {
    fetch_data(level = '');
    function fetch_data(level = ''){
        // alert(student);
    var table = $('#simpletable').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
    url: SITEURL,
    type: 'GET',
    data: {level:level}
    },
    columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,searchable: false},
            { data: 'referral_code', name: 'referral_code' },
            { data: 'level', name: 'level' },
            { data: 'fullname', name: 'fullname' },
            { data: 'payment_date', name: 'payment_date' },
            { data: 'product_amount', name: 'product_amount' },
            {data: 'admin_charges', name: 'admin_charges'},
            {data: 'income_amount', name: 'income_amount'},
            {data: 'net_income', name: 'net_income'},
        ],
    order: [[0, 'desc']]
    });
    }
    $('#level').change(function () {
        var level = $("#level").val();
        $("#simpletable").DataTable().destroy();
        fetch_data(level);
    });
});

var SITEURL1 = "{{ route('distributor.salary')}}";
$(document).ready(function() {
    fetch_data(level1 = '');
    function fetch_data(level1 = ''){
        // alert(student);
    var table = $('#simpletable1').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
    url: SITEURL1,
    type: 'GET',
    data: {level1:level1}
    },
    columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,searchable: false},
            { data: 'referral_code', name: 'referral_code' },
            { data: 'level', name: 'level' },
            { data: 'fullname', name: 'fullname' },
            { data: 'payment_date', name: 'payment_date' },
            { data: 'product_amount', name: 'product_amount' },
            {data: 'admin_charges', name: 'admin_charges'},
            {data: 'income_amount', name: 'income_amount'},
            {data: 'net_income', name: 'net_income'},
        ],
    order: [[0, 'desc']]
    });
    }
    $('#level1').change(function () {
        var level1 = $("#level1").val();
        $("#simpletable1").DataTable().destroy();
        fetch_data(level1);
    });
});

var SITEURL2 = "{{ route('distributor.reward')}}";
$(document).ready(function() {
    fetch_data(level2 = '');
    function fetch_data(level2 = ''){
        // alert(student);
    var table = $('#simpletable2').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
    url: SITEURL2,
    type: 'GET',
    data: {level2:level2}
    },
    columns: [
            { data: 'level', name: 'level' },
            { data: 'total_joiner', name: 'total_joiner' },
            { data: 'joiner_added', name: 'joiner_added' },
            { data: 'reward', name: 'reward' },
            {data: 'reward_amt', name: 'reward_amt'},
            {data: 'admin_charges', name: 'admin_charges'},
            {data: 'net_income', name: 'net_income'},
            {data: 'status', name: 'status'},
        ],
    order: [[0, 'desc']]
    });
    }
    $('#level2').change(function () {
        var level2 = $("#level2").val();
        $("#simpletable2").DataTable().destroy();
        fetch_data(level2);
    });
});
</script>
@endsection