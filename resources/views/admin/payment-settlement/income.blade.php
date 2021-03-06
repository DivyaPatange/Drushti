<?php 
use App\Models\User\UserIncome;
use App\Http\Controllers\Admin\DistributorController;
?>
@extends('admin.admin_layout.main')
@section('title', 'Income Settlement')
@section('page_title', 'Income Settlement')
@section('customcss')
<!-- Bootstrap Select Css -->
<link href="{{ asset('adminAsset/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" />
<!-- JQuery DataTable Css -->
<link href="{{ asset('adminAsset/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css') }}" rel="stylesheet">
<script src="https://use.fontawesome.com/d5c7b56460.js"></script>
<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<!-- Bootstrap DatePicker Css -->
<link href="{{ asset('adminAsset/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css') }}" rel="stylesheet" />

<!-- Wait Me Css -->
<link href="{{ asset('adminAsset/plugins/waitme/waitMe.css') }}" rel="stylesheet" />
<!-- Custom Css -->
<link href="{{ asset('adminAsset/css/style.css') }}" rel="stylesheet">
<style>
.error{
    color:red;
}
</style>
@endsection
@section('content')
@foreach($joiners1 as $joiner)
<?php
// $users = DB::table('users')->where('parent_id', '=', $joiner->id)->get();
$val = DistributorController::getUserLevel($joiner->id);
// dd($val);
$users = $val['users'];
$allMenus = $val['allMenus'];
$items = $val['items'];
$items1 = $val['items1'];
$items2 = $val['items2'];
$items3 = $val['items3'];
$items4 = $val['items4'];
$items5 = $val['items5'];

?>
<ul style="display:none"> 
    @foreach($users as $key => $user)
    <li>
        <?php
            $payment = DB::table('product_payments')->where('user_id', $user->id)->where('product_amount', 3000)->where('plan', '10500')->first();
            if($payment){
                $userIncome = DB::table('user_incomes')->where('child_id', $user->id)->where('user_id', $joiner->id)->where('plan', '10500')->first();
                // dd(empty($fastTrack));
                if(empty($userIncome))
                {
                    $userIncome = new UserIncome();
                    $userIncome->user_id = $joiner->id;
                    $userIncome->child_id = $user->id;
                    $userIncome->level = 1;
                    $userIncome->plan = 10500;
                    $userIncome->product_amount = $payment->product_amount +  7000;
                    $userIncome->payment_date = $payment->payment_date;
                    $userIncome->income_amount = 0.06 * ($payment->product_amount +  7000);
                    $userIncome->admin_charges = 0.1 * (0.06 * ($payment->product_amount +  7000));
                    $userIncome->net_income = (0.06 * ($payment->product_amount +  7000)) - (0.1 * (0.06 * ($payment->product_amount +  7000)));
                    $userIncome->save();
                    // dd($fastTrack);
                }
            }
        ?>
        @if(count($user->childs))
            @include('admin.company-tree.income',['user_childs' => $user->user_childs])
        @endif
    </li>
    @endforeach
</ul>
@endforeach


@foreach($joiners1 as $joiner)
<?php
// $users = DB::table('users')->where('parent_id', '=', $joiner->id)->get();
$val = DistributorController::getPlanUserDetails($joiner->id);
// dd($val);
$users1 = $val['users1'];
$allMenus1 = $val['allMenus1'];
$items6 = $val['items6'];
$items7 = $val['items7'];
$items8 = $val['items8'];
$items9 = $val['items9'];
$items10 = $val['items10'];
$items11 = $val['items11'];

?>
<ul style="display:none"> 
    @foreach($users1 as $key => $user1)
    <li>
        <?php
            $payment1 = DB::table('product_payments')->where('user_id', $user1->id)->where('product_amount', 3000)->where('plan', '3000')->first();
            if($payment1){
                $userIncome1 = DB::table('user_incomes')->where('child_id', $user1->id)->where('user_id', $joiner->id)->where('plan', '3000')->first();
    
                if(empty($userIncome1))
                {
                    $userIncome1 = new UserIncome();
                    $userIncome1->user_id = $joiner->id;
                    $userIncome1->child_id = $user1->id;
                    $userIncome1->level = 1;
                    $userIncome1->product_amount = $payment1->product_amount;
                    $userIncome1->payment_date = $payment1->payment_date;
                    $userIncome1->income_amount = 0.15 * $payment1->product_amount;
                    $userIncome1->admin_charges = 0.1 * (0.15 * $payment1->product_amount);
                    $userIncome1->net_income = (0.15 * $payment1->product_amount) - (0.1 * (0.15 * $payment1->product_amount));
                    $userIncome1->plan = 3000;
                    $userIncome1->save();
                }    
            }
        ?>
        @if(count($user1->childs))
            @include('admin.company-tree.plan-income',['user_childs' => $user1->user_childs])
        @endif
    </li>
    @endforeach
</ul>
@endforeach
<!-- Widgets -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>Generate Settlement</h2>
            </div>
            <div class="body">
                <div class="row">
                    <form method="POST" id="submitForm">
                        <div class="col-xs-6">
                            <div class="input-daterange input-group" id="bs_datepicker_range_container">
                                <div class="form-line">
                                    <span id="start_err" class="error"></span>
                                    <input type="text" class="form-control" id="start_date" placeholder="Date start...">
                                </div>
                                <span class="input-group-addon">to</span>
                                <div class="form-line">
                                    <span id="end_err" class="error"></span>
                                    <input type="text" class="form-control" id="end_date" placeholder="Date end...">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-line">
                                <span id="plan_err" class="error"></span>
                                <select class="form-control show-tick" id="plan">
                                    <option value="">-- Select Plan --</option>
                                    <option value="10500">10,500 /-</option>
                                    <option value="3000">3,000 /-</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="form-inline">
                                <button type="button" id="submitButton" class="btn btn-primary waves-effect">Generate</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- #END# Widgets -->
<!-- Exportable Table -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2 style="display:inline">Settlement List</h2>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover js-basic-example dataTable" id="simpletable">
                        <thead>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Month-Year</th>
                                <th>Plan</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Month-Year</th>
                                <th>Plan</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
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

<!-- Custom Js -->
<script src="{{ asset('adminAsset/js/admin.js') }}"></script>
<script src="{{ asset('adminAsset/js/pages/forms/basic-form-elements.js') }}"></script>
<script>
var date = new Date();
var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);
// alert(lastDay);
$('#start_date').datepicker({
    dateFormat: 'mm-dd-yy',
    beforeShowDay: function(d) {
    // console.log(d.getDate() == 2);
       if (d.getDate() == 1 || d.getDate() == 16) {
         return true;
       } else {
          return false;
       }
    }
});
$('#end_date').datepicker({
    dateFormat: 'mm-dd-yy',
    beforeShowDay: function(d) {
        var date = new Date($('#start_date').val());
        var day = date.getDate();
        var month = date.getMonth() + 1;
        var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);
        var lastDate = lastDay.getDate();
        // console.log(lastDate);
        if(day == 1){
            if (d.getDate() == 15) {
                return true;
            } else {
                return false;
            }
        }
        if(day = 16)
        {
            if (d.getDate() == lastDate) {
                return true;
            } else {
                return false;
            }
        }
    }
});

var SITEURL = "{{ route('admin.income-settlement')}}";
$(document).ready(function() {
    // $('#simpletable').DataTable().destroy();
    var table = $('#simpletable').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        processing: true,
        serverSide: true,
        ajax: {
            url: SITEURL,
            type: 'GET',
            // alert(data);
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,searchable: false},
            { data: 'month_year', name: 'month_year' },
            { data: 'plan', name: 'plan' },
            { data: 'start_date', name: 'start_date' },
            { data: 'end_date', name: 'end_date' },
            { data: 'action', name: 'action' },
        ],
        order: [[0, 'desc']]
    });
})
$('body').on('click', '#submitButton', function () {
    var start_date = $("#start_date").val();
    var end_date = $("#end_date").val();
    var plan = $("#plan").val();

    if (start_date=="") {
        $("#start_err").fadeIn().html("Required");
        setTimeout(function(){ $("#start_err").fadeOut(); }, 3000);
        $("#start_date").focus();
        return false;
    }
    if (end_date=="") {
        $("#end_err").fadeIn().html("Required");
        setTimeout(function(){ $("#end_err").fadeOut(); }, 3000);
        $("#end_date").focus();
        return false;
    }
    if (plan=="") {
        $("#plan_err").fadeIn().html("Required");
        setTimeout(function(){ $("#plan_err").fadeOut(); }, 3000);
        $("#plan").focus();
        return false;
    }
    else
    { 
        $.ajax({
            type:"POST",
            url:"{{ route('admin.generate-income-settlement') }}",
            data:{start_date:start_date, end_date:end_date, plan:plan},
            cache:false,        
            success:function(returndata)
            {
                alert(returndata);
                document.getElementById("submitForm").reset();
                var oTable = $('#simpletable').dataTable(); 
                oTable.fnDraw(false);
                if(returndata.success){
                    toastr.success(returndata.success);
                }
                else{
                    toastr.error(returndata.error);
                }
            
            // location.reload();
            // $("#pay").val("");
            }
        });
    }
})
</script>
@endsection