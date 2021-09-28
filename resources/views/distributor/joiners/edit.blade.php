@extends('distributor.distributor_layout.main')
@section('title', 'Edit Profile')
@section('page_title', 'Edit Profile')
@section('customcss')
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
                <h2>Edit Distributor</h2>
            </div>
            <div class="body">
                <form method="POST" action="{{ route('distributor.joiners.update', $user->id) }}">
                {{ csrf_field() }}
                @method('PUT')
                    <div class="row clearfix">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" name="fullname" class="form-control @error('fullname') is-invalid @enderror" placeholder="Fullname" value="{{ $user->fullname }}"/>
                                </div>
                                @error('fullname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{ $user->email }}"/>
                                </div>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" name="referral_code" class="form-control @error('referral_code') is-invalid @enderror" placeholder="Referral No." value="{{ $user->referral_code }}"/>
                                </div>
                                @error('referral_code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="number" name="mobile" class="form-control @error('mobile') is-invalid @enderror" placeholder="Mobile No." value="{{ $user->mobile }}"/>
                                </div>
                                @error('mobile')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" name="nominee_name" class="form-control @error('nominee_name') is-invalid @enderror" placeholder="Nominee Name" value="{{ $usersInfo->nominee_name }}"/>
                                </div>
                                @error('nominee_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" name="nominee_relation" class="form-control @error('nominee_relation') is-invalid @enderror" placeholder="Nominee Relation" value="{{ $usersInfo->nominee_relation }}"/>
                                </div>
                                @error('nominee_relation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="form-line">
                                    <textarea class="form-control @error('address') is-invalid @enderror" name="address" placeholder="Address" >{{ $user->address }}</textarea>
                                </div>
                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <h4>KYC Details</h4>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" name="pan_no" class="form-control @error('pan_no') is-invalid @enderror" placeholder="Pan No." value="{{ $kycdetails->pan_no }}"/>
                                </div>
                                @error('pan_no')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="number" name="aadhar_no" class="form-control @error('aadhar_no') is-invalid @enderror" placeholder="Aadhar No." value="{{ $kycdetails->aadhar_no }}"/>
                                </div>
                                @error('aadhar_no')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <h4>Bank Details</h4>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" name="bank_name" class="form-control @error('bank_name') is-invalid @enderror" placeholder="Bank Name" value="{{ $bankdetails->bank_name }}"/>
                                </div>
                                @error('bank_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" name="branch_name" class="form-control @error('branch_name') is-invalid @enderror" placeholder="Branch Name" value="{{ $bankdetails->branch_name }}"/>
                                </div>
                                @error('branch_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" name="ifsc_code" class="form-control @error('ifsc_code') is-invalid @enderror" placeholder="IFSC Code" value="{{ $bankdetails->ifsc_code }}"/>
                                </div>
                                @error('ifsc_code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" name="acc_no" class="form-control @error('acc_no') is-invalid @enderror" placeholder="Account Number" value="{{ $bankdetails->acc_no }}"/>
                                </div>
                                @error('acc_no')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" name="acc_holder_name" class="form-control @error('acc_holder_name') is-invalid @enderror" placeholder="Account Holder Name" value="{{ $bankdetails->acc_holder_name }}"/>
                                </div>
                                @error('acc_holder_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12">
                        <button type="submit" class="btn btn-primary waves-effect ">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- #END# Exportable Table -->

@endsection
@section('customjs')
<script src="{{ asset('adminAsset/js/admin.js') }}"></script>
@endsection