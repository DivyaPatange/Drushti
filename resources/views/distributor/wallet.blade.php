@extends('distributor.distributor_layout.main')
@section('title', 'My Wallet')
@section('page_title', 'My Wallet')
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
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>My Wallet</h2>
            </div>
            <div class="body">
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box-3 bg-teal">
                            <div class="icon">
                                <span class="chart chart-line">9,4,6,5,6,4,7,3</span>
                            </div>
                            <div class="content">
                                <div class="text">TOTAL INCOME</div>
                                <div class="number">&#8377;{{ $amount }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box-3 bg-grey">
                            <div class="icon">
                                <span class="chart chart-line">9,4,6,5,6,4,7,3</span>
                            </div>
                            <div class="content">
                                <div class="text">This Month</div>
                                <div class="number">&#8377;{{ number_format($Month) }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box-3 bg-blue-grey">
                            <div class="icon">
                                <div class="chart chart-bar">4,6,-3,-1,2,-2,4,6</div>
                            </div>
                            <div class="content">
                                <div class="text">Admin Wallet</div>
                                <div class="number">&#8377;{{ number_format($adminWallet->usergiven) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover js-basic-example dataTable" id="simpletable">
                                <thead>
                                    <tr>
                                        <th>Month Year</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Amount For</th>
                                        <th>Salary</th>
                                        <th>Balance Amount</th>
                                        <th>Extra Amount</th>
                                        <th>Admin Wallet</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Month Year</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Amount For</th>
                                        <th>Salary</th>
                                        <th>Balance Amount</th>
                                        <th>Extra Amount</th>
                                        <th>Admin Wallet</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <h2>Payment Settlement</h2>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover js-basic-example dataTable" id="simpletable1">
                                <thead>
                                    <tr>
                                        <th>Month Year</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Amount For</th>
                                        <th>Settle Amount</th>
                                        <th>Settled Status</th>
                                        <th>Settled Date</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Month Year</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Amount For</th>
                                        <th>Settle Amount</th>
                                        <th>Settled Status</th>
                                        <th>Settled Date</th>
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
<script src="{{ asset('adminAsset/js/pages/forms/basic-form-elements.js') }}"></script>
<script src="{{ asset('adminAsset/js/admin.js') }}"></script>
<!-- Sparkline Chart Plugin Js -->
<script src="{{ asset('adminAsset/plugins/jquery-sparkline/jquery.sparkline.js') }}"></script>

<!-- Custom Js -->
<script src="{{ asset('adminAsset/js/pages/widgets/infobox/infobox-4.js') }}"></script>
<script>
var SITEURL = "{{ route('distributor.my-wallet')}}";
$(document).ready(function() {
    var table = $('#simpletable').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
    url: SITEURL,
    type: 'GET',
    },
    columns: [
        { data: 'month_year', name: 'month_year' },
        { data: 'start_date', name: 'start_date' },
        { data: 'end_date', name: 'end_date' },
        { data: 'reason', name: 'reason' },
        { data: 'salary', name: 'salary' },
        {data: 'balance', name: 'balance'},
        {data: 'extra', name: 'extra'},
        {data: 'adminwallet', name: 'adminwallet'},
    ],
    order: [[0, 'desc']]
    });
});

var SITEURL1 = "{{ route('distributor.payment-settlement')}}";
$(document).ready(function() {
    var table = $('#simpletable1').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
    url: SITEURL1,
    type: 'GET',
    },
    columns: [
        { data: 'month_year', name: 'month_year' },
        { data: 'start_date', name: 'start_date' },
        { data: 'end_date', name: 'end_date' },
        { data: 'reason', name: 'reason' },
        { data: 'total', name: 'total' },
        {data: 'settled_status', name: 'settled_status'},
        {data: 'settled_date', name: 'settled_date'},
        ],
    order: [[0, 'desc']]
    });
});

</script>
@endsection