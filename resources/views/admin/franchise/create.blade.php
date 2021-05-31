@extends('admin.admin_layout.main')
@section('title', 'Add Franchise')
@section('page_title', 'Add Franchise')
@section('customcss')
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
                <h2>Add Franchise</h2>
            </div>
            <div class="body">
                <form method="POST" action="{{ route('admin.franchise.store') }}">
                @csrf
                    <div class="row clearfix">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" name="fullname" class="form-control @error('fullname') is-invalid @enderror" placeholder="Fullname" value="{{ old('fullname') }}"/>
                                </div>
                                @error('fullname')
                                    <span class="invalid-feedback error" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email') }}"/>
                                </div>
                                @error('email')
                                    <span class="invalid-feedback error" role="alert">
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
                                    <span class="invalid-feedback error" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-line" id="bs_datepicker_container">
                                    <input type="text" class="form-control @error('registration_date') is-invalid @enderror" name="registration_date" placeholder="Registration Date" value="{{ old('registration_date') }}">
                                </div>
                                @error('registration_date')
                                    <span class="invalid-feedback error" role="alert">
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
                                    <span class="invalid-feedback error" role="alert">
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
                                    <span class="invalid-feedback error" role="alert">
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
                            <h4>Shop Details</h4>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" name="shop_name" class="form-control @error('shop_name') is-invalid @enderror" placeholder="Shop Name" value="{{ old('shop_name') }}"/>
                                </div>
                                @error('shop_name')
                                    <span class="invalid-feedback error" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" name="shop_id" class="form-control @error('shop_id') is-invalid @enderror" placeholder="Shop Registration ID" value="{{ old('shop_id') }}"/>
                                </div>
                                @error('shop_id')
                                    <span class="invalid-feedback error" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12">
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
@endsection