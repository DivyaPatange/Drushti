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
                <h2 style="display:inline">User Details</h2>
            </div>
            <div class="body">
                <form method="POST" id="submitForm">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="form-line">
                                    <span id="code_err" class="error"></span>
                                    <input type="text" name="referral_code" class="form-control @error('referral_code') is-invalid @enderror" id="referral_code" placeholder="Enter Referral Code"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <table class="w-100 " id='users_info'>
                                                        
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-success waves-effect" id="submitButton">Send OTP</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- #END# Exportable Table -->
<div class="modal fade" id="smallModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="smallModalLabel">Product Payment</h4>
            </div>
            <form method="POST" id="submitForm1">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="form-line">
                                <span id="otp_err" class="error"></span>
                                <input type="number" name="otp" class="form-control @error('otp') is-invalid @enderror" id="otp" placeholder="Enter OTP"/>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="form-line">
                                <span id="code_err" class="error"></span>
                                <input type="hidden" name="referral_code" class="form-control @error('referral_code') is-invalid @enderror" id="referral_id" placeholder="Enter Referral Code"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="form-line">
                                <span id="amt_err" class="error"></span>
                                <input type="number" name="product_amt" class="form-control @error('product_amt') is-invalid @enderror" id="product_amt" readonly value="7500" placeholder="Enter Product Amount"/>
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
                <button type="button" class="btn btn-success waves-effect" id="submitButton1">Submit</button>
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

$(document).ready(function () {
    // keyup function looks at the keys typed on the search box
    $('#referral_code').on('keyup',function() {
        // the text typed in the input field is assigned to a variable 
        var query = $(this).val();
        // call to an ajax function
        $.ajax({
            // assign a controller function to perform search action - route name is search
            url:"{{ route('franchise.payment-search') }}",
            // since we are getting data methos is assigned as GET
            type:"GET",
            // data are sent the server
            data:{'referral_info':query},
            // if search is succcessfully done, this callback function is called
            success:function (data) {
                // print the search results in the div called country_list(id)
                $('#users_info').html(data);
            }
        })
        // end of ajax call
    });
})

$('body').on('click', '#submitButton', function () {
    var referral_code = $("#referral_code").val();
   

    if (referral_code=="") {
        $("#code_err").fadeIn().html("Required");
        setTimeout(function(){ $("#code_err").fadeOut(); }, 3000);
        $("#referral_code").focus();
        return false;
    }
    else
    { 
        $.ajax({
            type:"POST",
            url:"{{ route('franchise.product-payment.send-otp') }}",
            data:{referral_code:referral_code},
            cache:false,        
            success:function(returndata)
            {
                if(returndata.success){
                toastr.success(returndata.success);
                document.getElementById("submitForm").reset();
                $("#users_info").empty();
                $("#smallModal").modal('show');
                $("#referral_id").val(returndata.referral_id);
                }
                else{
                    document.getElementById("submitForm").reset();
                    toastr.error(returndata.danger);
                }
            
            // location.reload();
            // $("#pay").val("");
            }
        });
    }
})

$('body').on('click', '#submitButton1', function () {
    var referral_code = $("#referral_id").val();
    var otp = $("#otp").val();
    var product_amt = $("#product_amt").val();
    var payment_date = $("#payment_date").val();
    if (otp=="") {
        $("#otp_err").fadeIn().html("Required");
        setTimeout(function(){ $("#otp_err").fadeOut(); }, 3000);
        $("#otp").focus();
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
            url:"{{ route('franchise.product-payment.submit') }}",
            data:{otp:otp, referral_code:referral_code, product_amt:product_amt, payment_date:payment_date},
            cache:false,        
            success:function(returndata)
            {
                document.getElementById("submitForm1").reset();
                $("#smallModal").modal('hide');
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