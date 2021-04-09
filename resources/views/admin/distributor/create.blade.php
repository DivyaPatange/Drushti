@extends('admin.admin_layout.main')
@section('title', 'Add Distributor')
@section('page_title', 'Add Distributor')
@section('customcss')
@endsection
@section('content')
<!-- Exportable Table -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>Add Distributor</h2>
            </div>
            <div class="body">
                <form method="POST" action="{{ route('admin.distributor.store') }}">
                @csrf
                    <div class="row clearfix">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" name="fullname" class="form-control @error('fullname') is-invalid @enderror" placeholder="Fullname" value="{{ old('fullname') }}"/>
                                </div>
                                @error('fullname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="number" name="mobile_no" class="form-control @error('mobile_no') is-invalid @enderror" placeholder="Mobile No." value="{{ old('mobile_no') }}"/>
                                </div>
                                @error('mobile_no')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="form-line">
                                    <textarea class="form-control @error('address') is-invalid @enderror" name="address" placeholder="Address" >{{ old('address') }}</textarea>
                                </div>
                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" />
                                </div>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                        <input type="hidden" name="parent_id" value="0">
                        <button type="submit" class="btn btn-primary waves-effect ">Submit</button>
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