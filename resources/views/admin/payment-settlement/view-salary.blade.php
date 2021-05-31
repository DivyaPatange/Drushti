@extends('admin.admin_layout.main')
@section('title', 'Salary Settlement List')
@section('page_title')
Salary Settlement List ({{ $settlement->month_year }})
@endsection
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
<!-- Exportable Table -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2 style="margin-bottom:15px;">All Pending Salary Settlement List</h2>
                <h2>{{ date('d-m-Y', strtotime($settlement->start_date)) }} to {{ date('d-m-Y', strtotime($settlement->end_date)) }}</h2>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover js-basic-example dataTable" id="simpletable">
                        <thead>
                            <tr>
                                <th>Sr. No.</th>
                                <th>User ID</th>
                                <th>Name</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Sr. No.</th>
                                <th>User ID</th>
                                <th>Name</th>
                                <th>Total</th>
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
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2 style="display:inline">All Paid Salary Settlement List</h2>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover js-basic-example dataTable" id="simpletable1">
                        <thead>
                            <tr>
                                <th>Sr. No.</th>
                                <th>User ID</th>
                                <th>Name</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Sr. No.</th>
                                <th>User ID</th>
                                <th>Name</th>
                                <th>Total</th>
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
var SITEURL = "{{ route('admin.salary-settlement.view', $settlement->id)}}";
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
            { data: 'user_id', name: 'user_id' },
            { data: 'name', name: 'name' },
            { data: 'total', name: 'total' },
            { data: 'action', name: 'action' },
        ],
        order: [[0, 'desc']]
    });
})

var SITEURL1 = "{{ route('admin.salary-settlement.paid', $settlement->id)}}";

$(document).ready(function() {
    // $('#simpletable').DataTable().destroy();
    var table = $('#simpletable1').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        processing: true,
        serverSide: true,
        ajax: {
            url: SITEURL1,
            type: 'GET',
            // alert(data);
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,searchable: false},
            { data: 'user_id', name: 'user_id' },
            { data: 'name', name: 'name' },
            { data: 'total', name: 'total' },
            { data: 'action', name: 'action' },
        ],
        order: [[0, 'desc']]
    });
})
$('body').on('click', '#status', function () {
    var id = $(this).data('id');
    // alert(id);
    if (id) {
      
        $.ajax({
            type:"POST",
            url:"{{ route('admin.settlement.status') }}",
            data:{id:id},
            cache:false,        
            success:function(returndata)
            {
                var oTable = $('#simpletable').dataTable(); 
                oTable.fnDraw(false);
                var oTable1 = $('#simpletable1').dataTable(); 
                oTable1.fnDraw(false);
                if(returndata.success){
                    toastr.success(returndata.success);
                }
                else{
                    toastr.error(returndata.error);
                }
            }
        });
    }
})
</script>
@endsection