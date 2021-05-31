@extends('admin.admin_layout.main')
@section('title', 'Franchise Profile')
@section('page_title', 'Franchise Profile')
@section('customcss')
@endsection
@section('content')
<!-- Exportable Table -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
            <a href="javascript:void(0)" onclick="$(this).parent().find('form').submit()"><button type="button" class="btn btn-danger waves-effect">Login To Franchise</button></a>
            <form action="{{ route('franchise.login') }}" method="post" target="_blank">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="id" value="{{ $franchise->id}}">
                <input type="hidden" name="username" value="{{ $franchise->username }}">
                <input type="hidden" name="password" value="{{ $franchise->password_1}}">
            </form>
            </div>
            <div class="body">
                <div class="row">
                    <div class="col-md-3">
                        <p><b>Fullname</b></p>
                    </div>
                    <div class="col-md-3">
                        <p>: {{ $franchise->fullname }}</p>
                    </div>
                    <div class="col-md-3">
                        <p><b>Email</b></p>
                    </div>
                    <div class="col-md-3">
                        <p>: {{ $franchise->email }}</p>
                    </div>
                    <div class="col-md-3">
                        <p><b>Mobile No.</b></p>
                    </div>
                    <div class="col-md-3">
                        <p>: {{ $franchise->mobile }}</p>
                    </div>
                    <div class="col-md-3">
                        <p><b>Registration Date</b></p>
                    </div>
                    <div class="col-md-3">
                        <p>: {{ date('d-m-Y', strtotime($franchise->reg_date)) }}</p>
                    </div>
                    <div class="col-md-3">
                        <p><b>Address</b></p>
                    </div>
                    <div class="col-md-9">
                        <p>: {{ $franchise->address }}</p>
                    </div>
                    <div class="col-md-3">
                        <p><b>Nominee Name</b></p>
                    </div>
                    <div class="col-md-3">
                        <p>: {{ $franchise->nominee_name }}</p>
                    </div>
                    <div class="col-md-3">
                        <p><b>Nominee Relation</b></p>
                    </div>
                    <div class="col-md-3">
                        <p>: {{ $franchise->nominee_relation }}</p>
                    </div>
                    <div class="col-md-12">
                        <h4 class="col-pink">KYC Details</h4>
                        <hr>
                    </div>
                    <div class="col-md-3">
                        <p><b>Pan No.</b></p>
                    </div>
                    <div class="col-md-3">
                        <p>: @if(!empty($kycdetails)){{ $kycdetails->pan_no }}@endif</p>
                    </div>
                    <div class="col-md-3">
                        <p><b>Aadhar No.</b></p>
                    </div>
                    <div class="col-md-3">
                        <p>: @if(!empty($kycdetails)){{ $kycdetails->aadhar_no }}@endif</p>
                    </div>
                    <div class="col-md-12">
                        <h4 class="col-pink">Bank Details</h4>
                        <hr>
                    </div>
                    <div class="col-md-3">
                        <p><b>Bank Name</b></p>
                    </div>
                    <div class="col-md-3">
                        <p>: @if(!empty($bankdetails)){{ $bankdetails->bank_name }}@endif</p>
                    </div>
                    <div class="col-md-3">
                        <p><b>Branch Name</b></p>
                    </div>
                    <div class="col-md-3">
                        <p>: @if(!empty($bankdetails)){{ $bankdetails->branch_name }}@endif</p>
                    </div>
                    <div class="col-md-3">
                        <p><b>IFSC Code</b></p>
                    </div>
                    <div class="col-md-3">
                        <p>: @if(!empty($bankdetails)){{ $bankdetails->ifsc_code }}@endif</p>
                    </div>
                    <div class="col-md-3">
                        <p><b>Account No.</b></p>
                    </div>
                    <div class="col-md-3">
                        <p>: @if(!empty($bankdetails)){{ $bankdetails->acc_no }}@endif</p>
                    </div>
                    <div class="col-md-3">
                        <p><b>Account Holder Name</b></p>
                    </div>
                    <div class="col-md-9">
                        <p>: @if(!empty($bankdetails)){{ $bankdetails->acc_holder_name }}@endif</p>
                    </div>
                    <div class="col-md-12">
                        <h4 class="col-pink">Shop Details</h4>
                        <hr>
                    </div>
                    <div class="col-md-3">
                        <p><b>Shop Name</b></p>
                    </div>
                    <div class="col-md-3">
                        <p>: @if(!empty($shopdetails)){{ $shopdetails->shop_name }}@endif</p>
                    </div>
                    <div class="col-md-3">
                        <p><b>Shop Registration ID</b></p>
                    </div>
                    <div class="col-md-3">
                        <p>: @if(!empty($shopdetails)){{ $shopdetails->shop_registration_id }}@endif</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- #END# Exportable Table -->

@endsection
@section('customjs')
<script src="{{ asset('adminAsset/js/admin.js') }}"></script>
@endsection