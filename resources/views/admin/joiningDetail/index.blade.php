@extends('admin.admin_layout.main')
@section('title', 'Joining Details')
@section('page_title', 'Joining Details')
@section('customcss')
<!-- JQuery DataTable Css -->
<link href="{{ asset('adminAsset/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css') }}" rel="stylesheet">
<!-- Bootstrap Select Css -->
<link href="{{ asset('adminAsset/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" />
<script src="https://use.fontawesome.com/d5c7b56460.js"></script>
<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<style>
td.details-control:before {
    font-family: 'FontAwesome';
    content: '\f105';
    display: block;
    text-align: center;
    font-size: 20px;
}
tr.shown td.details-control:before{
   font-family: 'FontAwesome';
    content: '\f107';
    display: block;
    text-align: center;
    font-size: 20px;
}
</style>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>	
                <strong>{{ $message }}</strong>
        </div>
        @endif
        @if ($message = Session::get('danger'))
        <div class="alert alert-danger alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>	
                <strong>{{ $message }}</strong>
        </div>
        @endif
    </div>
</div>
<!-- Exportable Table -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2> Filter List</h2>
                <div class="row m-t-10">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Joiner Details</label>
                            <select name="month_join" id="month_join" class="form-control">
                                <option value="">-Select Joining Details-</option>
                                <option value="Monthly Joining">Monthly Joining</option>
                                <option value="Previous Joining">Previous Joining</option>
                                <option value="Current Joining">Current Joining</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 hidden" id="show_month">
                        <div class="form-group">
                            <label for="">Select Month</label>
                            <div class="form-line">
                                <input type="month" id="month" name="month" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <a href="javascript:void(0)"><button type="button" id="getList" class="btn btn-primary waves-effect m-t-10">Get List</button></a>
                    </div>
                </div>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover dataTable js-exportable" id="simpletable">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Distributor Name</th>
                                <th>User ID</th>
                                <th>Password</th>
                                <th>Mobile No.</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th>Distributor Name</th>
                                <th>User ID</th>
                                <th>Password</th>
                                <th>Mobile No.</th>
                                <th>Created At</th>
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
<!-- #END# Exportable Table -->

@endsection
@section('customjs')
<!-- Waves Effect Plugin Js -->
<script src="{{ asset('adminAsset/plugins/node-waves/waves.js') }}"></script>

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
<!-- <script src="{{ asset('adminAsset/js/pages/tables/jquery-datatable.js') }}"></script> -->
<!-- <script src="{{ asset('adminAsset/js/pages/index.js') }}"></script> -->
<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
var SITEURL = "{{ route('admin.joining-detail.index')}}";
$(document).ready(function() {
    fetch_data(month_join = '', month = '');
    function fetch_data(month_join = '', month = ''){
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
                data: {month_join:month_join, month:month}
                // alert(data);
            },
            columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,searchable: false},
                    { data: 'fullname', name: 'fullname' },
                    { data: 'username', name: 'username' },
                    { data: 'password_1', name: 'password_1' },
                    { data: 'mobile', name: 'mobile' },
                    { data: 'reg_date', name: 'reg_date' },
                ],
            order: [[0, 'desc']]
        });
    }
    $('#getList').click(function () {
        var month_join = $("#month_join").val();
        var month = $("#month").val(); 
        // alert(month);
        $("#simpletable").DataTable().destroy();
        fetch_data(month_join, month);
    });
})


$('body').on('change', '#month_join', function () {
    var query = $(this).val();
    if(query == "Monthly Joining")
    {
        $("#show_month").removeClass("hidden");
    }
    else{
        $("#show_month").addClass("hidden");
    }
})
</script>
@endsection