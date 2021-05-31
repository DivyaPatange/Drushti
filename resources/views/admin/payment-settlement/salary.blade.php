<?php 
use App\Models\User\UserIncome;
use App\Models\User\UserSalary;
use App\Models\User\Reward;
use App\Http\Controllers\Admin\DistributorController;
?>
@extends('admin.admin_layout.main')
@section('title', 'Salary Settlement')
@section('page_title', 'Salary Settlement')
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
    @if(!empty($user->id))
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
            @include('admin.company-tree.child',['childs' => $user->childs])
        @endif
    </li>
    @endif
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
                        <div class="col-md-4">
                            <div class="form-line">
                                <span id="start_err" class="error"></span>
                                <select class="form-control show-tick" id="month">
                                    <option value="">-- Select Month --</option>
                                    @for($m=1; $m<=12; $m++)
                                    <?php 
                                        $month = date('F', mktime(0,0,0,$m, 1, date('Y')));
                                    ?>
                                    <option value="{{ $m }}">{{ $month }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-line">
                                <span id="end_err" class="error"></span>
                                <select class="form-control show-tick" id="year">
                                    <option value="">-- Select Year --</option>
                                    @for($m=2021; $m<=2030; $m++)
                                    <option value="{{ $m }}">{{ $m }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
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

var SITEURL = "{{ route('admin.salary-settlement')}}";
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
    var month = $("#month").val();
    var year = $("#year").val();
    if (month=="") {
        $("#start_err").fadeIn().html("Required");
        setTimeout(function(){ $("#start_err").fadeOut(); }, 3000);
        $("#month").focus();
        return false;
    }
    if (year=="") {
        $("#end_err").fadeIn().html("Required");
        setTimeout(function(){ $("#end_err").fadeOut(); }, 3000);
        $("#year").focus();
        return false;
    }
    else
    { 
        $.ajax({
            type:"POST",
            url:"{{ route('admin.generate-salary-settlement') }}",
            data:{month:month, year:year},
            cache:false,        
            success:function(returndata)
            {
                // alert(returndata);
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