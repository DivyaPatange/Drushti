@extends('distributor.distributor_layout.main')
@section('title', 'KYC Document')
@section('page_title', 'KYC Document')
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
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>KYC Upload</h2>
                <div class="row">
                    <div class="col-md-12">
                    @if(isset($kycdetails) && !empty($kycdetails) && $kycdetails->verified == 1)
                        <span style="color:green;font-size:30px;">Your KYC Verification is Approved</span>
                        @else
                        <span style="color:red;font-size:30px;">Your KYC Verification is Pending</span>
                        @endif
                        <br>
                        <br>
                    </div>
                </div>
            </div>
            <div class="body">
                <form method="POST" action="{{ route('distributor.kyc-document.upload') }}" enctype="multipart/form-data">
                @csrf
                    <div class="row clearfix">
                        <div class="col-sm-12 col-md-8">
                            <div class="form-group">
                                <label for="">PAN</label>
                                <div class="form-line">
                                    <input type="file" name="pan" class="form-control @error('pan') is-invalid @enderror"/>
                                </div>
                                @error('pan')
                                    <span class="invalid-feedback error" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for=""></label>
                            @if(isset($kycdetails) && !empty($kycdetails) && isset($kycdetails->pan))
                            <a href="{{ URL::asset('kycdocument/pan/' . $kycdetails->pan) }}" target="_blank" class="btn btn-primary" style="margin-top:32px;">View</a>
                            @endif
                        </div>
                        <div class="col-sm-12 col-md-8">
                            <div class="form-group">
                                <label for="">Photo</label>
                                <div class="form-line">
                                    <input type="file" name="user_img" class="form-control @error('user_img') is-invalid @enderror"/>
                                </div>
                                @error('user_img')
                                    <span class="invalid-feedback error" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for=""></label>
                            @if(isset($kycdetails) && !empty($kycdetails) && isset($kycdetails->user_img))
                            
                            <a href="{{ URL::asset('kycdocument/userImg/' . $kycdetails->user_img) }}" target="_blank" class="btn btn-primary" style="margin-top:32px;">View</a>
                            @endif
                        </div>
                        <div class="col-sm-12 col-md-8">
                            <div class="form-group">
                                <label for="">Cancelled Cheque</label>
                                <div class="form-line">
                                    <input type="file" name="cheque" class="form-control @error('cheque') is-invalid @enderror"/>
                                </div>
                                @error('cheque')
                                    <span class="invalid-feedback error" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for=""></label>
                            @if(isset($kycdetails) && !empty($kycdetails) && isset($kycdetails->cheque))
                            <a href="{{ URL::asset('kycdocument/cheque/' . $kycdetails->cheque) }}" target="_blank" class="btn btn-primary" style="margin-top:32px;">View</a>
                            @endif
                        </div>
                        <div class="col-sm-12">
                        <input type="hidden" name="user_id" value="{{ $kycdetails->user_id }}">
                        <button type="submit" class="btn btn-primary waves-effect ">Upload</button>
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