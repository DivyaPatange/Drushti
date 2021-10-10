<?php 
use App\Models\User\Reward;
use App\Http\Controllers\Admin\DistributorController;
?>
@extends('admin.admin_layout.main')
@section('title', 'Reward Settlement')
@section('page_title', 'Reward Settlement')
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
    $val = DistributorController::getUserLevel($joiner->id);
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
            $payment = DB::table('product_payments')->where('user_id', $user->id)->where('product_amount', 3000)->where('plan', '10500')->first();
            if($payment){
                $count = 10;
                $reward = DB::table('rewards')->where('user_id', $joiner->id)->where('level', 1)->where('plan', '10500')->first();
                if(empty($reward))
                {
                    if(count($items) > 2){
                        $reward = new Reward();
                        $reward->user_id = $joiner->id;
                        $reward->level = 1;
                        $reward->total_joiner = 10;
                        $reward->joiner_added = count($items);
                        $reward->reward = 10*10000;
                        $reward->reward_amt = (0.06 * 10 * 10000);
                        $reward->admin_charges = 0.1 * ($reward->reward_amt);
                        $reward->net_income = $reward->reward_amt - $reward->admin_charges;
                        $reward->status = "Not Qualified";
                        $reward->date = max($items);
                        $reward->plan = 10500;
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
                    if(count($items) > 2){
                        $result = DB::table('rewards')->where('user_id', $joiner->id)->where('level', 1)->where('plan', '10500')->update(['joiner_added' => count($items), 'status' => $status, 'date' => max($items)]);
                    }
                }
            }
        ?>
        @if(count($user->childs))
            @include('admin.company-tree.reward',['user_childs' => $user->user_childs])
        @endif
    </li>
    @endif
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
                $count = 10;
                $reward1 = DB::table('rewards')->where('user_id', $joiner->id)->where('level', 1)->where('plan', '3000')->first();
                if(empty($reward1))
                {
                    if(count($items6) > 2){
                        $reward1 = new Reward();
                        $reward1->user_id = $joiner->id;
                        $reward1->level = 1;
                        $reward1->total_joiner = 10;
                        $reward1->joiner_added = count($items6);
                        $reward1->reward = 10*10000;
                        $reward1->reward_amt = (0.10 * 10 * 10000);
                        $reward1->admin_charges = 0.1 * ($reward1->reward_amt);
                        $reward1->net_income = $reward1->reward_amt - $reward1->admin_charges;
                        $reward1->status = "Not Qualified";
                        $reward1->date = max($items6);
                        $reward1->plan = 3000;
                        $reward1->save();
                    }
                }
                else{
                    if($count1 == count($items6))
                    {
                        $status1 = "Qualified";
                    }
                    else{
                        $status1 = "Not Qualified";
                    }
                    if(count($items6) > 2){
                        $result1 = DB::table('rewards')->where('user_id', $joiner->id)->where('level', 1)->where('plan', '3000')->update(['joiner_added' => count($items6), 'status' => $status1, 'date' => max($items6)]);
                    }
                }
            }
        ?>
        @if(count($user1->childs))
            @include('admin.company-tree.plan-reward',['user_childs' => $user1->user_childs])
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
                        <div class="col-md-3">
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
                        <div class="col-md-3">
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
                        <div class="col-md-3">
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

var SITEURL = "{{ route('admin.reward-settlement')}}";
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
    var month = $("#month").val();
    var year = $("#year").val();
    var plan = $("#plan").val();
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
            url:"{{ route('admin.generate-reward-settlement') }}",
            data:{month:month, year:year, plan:plan},
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