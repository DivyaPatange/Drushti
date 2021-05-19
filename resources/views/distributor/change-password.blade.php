@extends('distributor.distributor_layout.main')
@section('title', 'Change Password')
@section('page_title', 'Change Password')
@section('customcss')
<style>
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
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="margin:auto; float:none">
        <div class="card">
            <div class="header">
                <h2>Change Password</h2>
            </div>
            <div class="body">
                <form method="POST" action="{{ route('distributor.change-password.store') }}">
                @csrf
                    <div class="row clearfix">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" placeholder="Current Password" value="{{ old('current_password') }}"/>
                                </div>
                                @error('current_password')
                                    <span class="invalid-feedback error" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="password" name="new_password" class="form-control @error('new_password') is-invalid @enderror" placeholder="New Password"/>
                                </div>
                                @error('new_password')
                                    <span class="invalid-feedback error" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="password" name="new_confirm_password" class="form-control @error('new_confirm_password') is-invalid @enderror" placeholder="New Confirm Password"/>
                                </div>
                                @error('new_confirm_password')
                                    <span class="invalid-feedback error" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12">
                        <button type="submit" class="btn btn-primary waves-effect ">Save</button>
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
<script type="text/javascript"> 
    $(function(){
        setTimeout(function(){
        $(".error").hide();
        }, 2500);
    });
</script> 
@endsection