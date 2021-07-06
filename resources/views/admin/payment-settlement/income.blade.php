<?php 
use App\Models\User\UserIncome;
use App\Models\User\UserSalary;
use App\Models\User\Reward;
use App\Http\Controllers\Admin\DistributorController;
?>
@extends('admin.admin_layout.main')
@section('title', 'Income Settlement')
@section('page_title', 'Income Settlement')
@section('customcss')
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
            $payment = DB::table('product_payments')->where('user_id', $user->id)->where('product_amount', 3000)->first();
            if($payment){
                $userIncome = DB::table('user_incomes')->where('child_id', $user->id)->where('user_id', $joiner->id)->first();
                // dd($fastTrack);
                $userSalary = DB::table('user_salaries')->where('child_id', $user->id)->where('user_id', $joiner->id)->first();
                // dd(empty($fastTrack));
                if(empty($userIncome))
                {
                    $userIncome = new UserIncome();
                    $userIncome->user_id = $joiner->id;
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
                    $userSalary->user_id = $joiner->id;
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
                $reward = DB::table('rewards')->where('user_id', $joiner->id)->where('level', 1)->first();
                if(empty($reward))
                {
                    if(count($items) > 2){
                        $reward = new Reward();
                        $reward->user_id = $joiner->id;
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
                }
                else{
                    if($count == count($items))
                    {
                        $status = "Qualified";
                    }
                    else{
                        $status = "Not Qualified";
                    }
                    $result = DB::table('rewards')->where('user_id', $joiner->id)->where('level', 1)->update(['joiner_added' => count($items), 'status' => $status, 'date' => max($items)]);
                }
            }
        ?>
        @if(count($user->childs))
            @include('admin.company-tree.child',['user_childs' => $user->user_childs])
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
                        <div class="col-xs-6">
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
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Month-Year</th>
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
    else
    { 
        $.ajax({
            type:"POST",
            url:"{{ route('admin.generate-income-settlement') }}",
            data:{start_date:start_date, end_date:end_date},
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