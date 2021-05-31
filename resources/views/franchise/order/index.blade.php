@extends('franchise.franchise_layout.main')
@section('title', 'Orders')
@section('page_title', 'All Orders')
@section('customcss')
<!-- JQuery DataTable Css -->
<link href="{{ asset('adminAsset/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css') }}" rel="stylesheet">
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
.error{
    color:red;
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
                <h2 style="display:inline"> Orders List</h2>
                <a href="javascript:void(0)" style="float:right;"><button type="button" class="btn btn-primary waves-effect " data-toggle="modal" data-target="#smallModal">Add New</button></a>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover js-basic-example dataTable" id="simpletable">
                        <thead>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Amount</th>
                                <th>Status</th>
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
<div class="modal fade" id="smallModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="smallModalLabel">Request Product</h4>
            </div>
            <form method="POST" id="submitForm">
            <div class="modal-body">
                <div class="form-group">
                    <div class="form-line">
                        <span id="amt_err" class="error"></span>
                        <input type="number" name="order_amt" class="form-control @error('order_amt') is-invalid @enderror" id="order_amt" placeholder="Enter Order Amount"/>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success waves-effect" id="submitButton">Submit</button>
                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">CLOSE</button>
            </div>
            </form>
        </div>
    </div>
</div>
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

<!-- Custom Js -->
<script src="{{ asset('adminAsset/js/admin.js') }}"></script>
<!-- <script src="{{ asset('adminAsset/js/pages/tables/jquery-datatable.js') }}"></script> -->
<!-- <script src="{{ asset('adminAsset/js/pages/index.js') }}"></script> -->
<script>
var SITEURL = "{{ route('franchise.order')}}";
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
            { data: 'order_amt', name: 'order_amt' },
            { data: 'status', name: 'status' },
        ],
        order: [[0, 'desc']]
    });
})

$('body').on('click', '#submitButton', function () {
    var order_amt = $("#order_amt").val();
    if (order_amt=="") {
        $("#amt_err").fadeIn().html("Required");
        setTimeout(function(){ $("#amt_err").fadeOut(); }, 3000);
        $("#order_amt").focus();
        return false;
    }
    else
    { 
        var datastring="order_amt="+order_amt;
        // alert(datastring);
        $.ajax({
            type:"POST",
            url:"{{ route('franchise.order.store') }}",
            data:datastring,
            cache:false,        
            success:function(returndata)
            {
                document.getElementById("submitForm").reset();
                $("#smallModal").modal('hide');
                var oTable = $('#simpletable').dataTable(); 
                oTable.fnDraw(false);
                toastr.success(returndata.success);
            
            // location.reload();
            // $("#pay").val("");
            }
        });
    }
})
</script>
@endsection