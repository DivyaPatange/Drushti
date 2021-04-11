@extends('distributor.distributor_layout.main')
@section('title', 'Distributor')
@section('page_title', 'Distributor')
@section('customcss')
<!-- JQuery DataTable Css -->
<link href="{{ asset('adminAsset/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css') }}" rel="stylesheet">
<script src="https://use.fontawesome.com/d5c7b56460.js"></script>
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
                <h2 style="display:inline"> Distributor List</h2>
                <a href="{{ route('distributor.joiners.create') }}" style="float:right"><button type="button" class="btn btn-primary waves-effect ">Add New</button></a>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover js-basic-example dataTable" id="simpletable">
                        <thead>
                            <tr>
                                <th>Sr. No.</th>
                                <th>ID</th>
                                <th>Joiner Name</th>
                                <th>Referral Code</th>
                                <th>Mobile No.</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Sr. No.</th>
                                <th>ID</th>
                                <th>Joiner Name</th>
                                <th>Referral Code</th>
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

<!-- Custom Js -->
<script src="{{ asset('adminAsset/js/admin.js') }}"></script>
<!-- <script src="{{ asset('adminAsset/js/pages/tables/jquery-datatable.js') }}"></script> -->
<!-- <script src="{{ asset('adminAsset/js/pages/index.js') }}"></script> -->
<script>
var SITEURL = "{{ route('distributor.joiners.index')}}";
$(document).ready(function() {
    // $('#simpletable').DataTable().destroy();
    var table = $('#simpletable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: SITEURL,
            type: 'GET',
            // alert(data);
        },
        columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,searchable: false},
                { data: 'id', name: 'id' },
                { data: 'fullname', name: 'fullname' },
                { data: 'referral_code', name: 'referral_code' },
                { data: 'mobile', name: 'mobile' },
                { data: 'reg_date', name: 'reg_date' },
            ],
        order: [[0, 'desc']]
    });
})
</script>
@endsection