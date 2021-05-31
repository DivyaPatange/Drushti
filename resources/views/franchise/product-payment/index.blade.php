@extends('franchise.franchise_layout.main')
@section('title', 'Product Payment')
@section('page_title', 'Product Payment')
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
                <h2 style="display:inline">Product Payment List</h2>
                <a href="javascript:void(0)" style="float:right;"><button type="button" class="btn btn-primary waves-effect " data-toggle="modal" data-target="#smallModal">Add New</button></a>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover js-basic-example dataTable" id="simpletable">
                        <thead>
                            <tr>
                                <th>Sr. No.</th>
                                <th>User Name</th>
                                <th>Referral Code</th>
                                <th>Amount</th>
                                <th>Payment Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Sr. No.</th>
                                <th>User Name</th>
                                <th>Referral Code</th>
                                <th>Amount</th>
                                <th>Payment Date</th>
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
<!-- #END# Exportable Table -->
<div class="modal fade" id="smallModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="smallModalLabel">Request Product</h4>
            </div>
            <form method="POST" id="submitForm">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="form-line">
                                <span id="code_err" class="error"></span>
                                <input type="text" name="referral_code" class="form-control @error('referral_code') is-invalid @enderror" id="referral_code" placeholder="Enter Referral Code"/>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h5 id="referral_name"></h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="form-line">
                                <span id="amt_err" class="error"></span>
                                <input type="number" name="product_amt" class="form-control @error('product_amt') is-invalid @enderror" id="product_amt" readonly value="3000" placeholder="Enter Product Amount"/>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="form-line" id="bs_datepicker_container">
                                <span id="date_err" class="error"></span>
                                <input type="text" name="payment_date" class="form-control @error('payment_date') is-invalid @enderror" id="payment_date" placeholder="Enter Payment Date"/>
                            </div>
                        </div>
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
<!-- Autosize Plugin Js -->
<script src="{{ asset('adminAsset/plugins/autosize/autosize.js') }}"></script>
<!-- Moment Plugin Js -->
<script src="{{ asset('adminAsset/plugins/momentjs/moment.js') }}"></script>
<!-- Bootstrap Material Datetime Picker Plugin Js -->
<script src="{{ asset('adminAsset/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}"></script>

<!-- Bootstrap Datepicker Plugin Js -->
<script src="{{ asset('adminAsset/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('adminAsset/js/admin.js') }}"></script>
<script src="{{ asset('adminAsset/js/pages/forms/basic-form-elements.js') }}"></script>
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
var SITEURL = "{{ route('franchise.product-payment')}}";
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
            { data: 'username', name: 'username' },
            { data: 'referral_code', name: 'referral_code' },
            { data: 'product_amount', name: 'product_amount' },
            { data: 'payment_date', name: 'payment_date' },
            { data: 'action', name: 'action' },
        ],
        order: [[0, 'desc']]
    });
})

$(document).ready(function () {
    // keyup function looks at the keys typed on the search box
    $('#referral_code').on('keyup',function() {
        // the text typed in the input field is assigned to a variable 
        var query = $(this).val();
        // call to an ajax function
        $.ajax({
            // assign a controller function to perform search action - route name is search
            url:"{{ route('franchise.search') }}",
            // since we are getting data methos is assigned as GET
            type:"GET",
            // data are sent the server
            data:{'referral_code':query},
            // if search is succcessfully done, this callback function is called
            success:function (data) {
                // print the search results in the div called country_list(id)
                $('#referral_name').html(data);
            }
        })
        // end of ajax call
    });
})

$('body').on('click', '#submitButton', function () {
    var referral_code = $("#referral_code").val();
    var product_amt = $("#product_amt").val();
    var payment_date = $("#payment_date").val();
    if (referral_code=="") {
        $("#code_err").fadeIn().html("Required");
        setTimeout(function(){ $("#code_err").fadeOut(); }, 3000);
        $("#referral_code").focus();
        return false;
    }
    if (payment_date=="") {
        $("#date_err").fadeIn().html("Required");
        setTimeout(function(){ $("#date_err").fadeOut(); }, 3000);
        $("#payment_date").focus();
        return false;
    }
    else
    { 
        $.ajax({
            type:"POST",
            url:"{{ route('franchise.product-payment.store') }}",
            data:{referral_code:referral_code, product_amt:product_amt, payment_date:payment_date},
            cache:false,        
            success:function(returndata)
            {
                document.getElementById("submitForm").reset();
                $("#smallModal").modal('hide');
                $("#referral_name").empty();
                var oTable = $('#simpletable').dataTable(); 
                oTable.fnDraw(false);
                if(returndata.success){
                toastr.success(returndata.success);
                }
                else{
                    toastr.error(returndata.danger);
                }
            
            // location.reload();
            // $("#pay").val("");
            }
        });
    }
})
</script>
@endsection