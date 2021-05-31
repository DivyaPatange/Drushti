@extends('franchise.franchise_layout.main')
@section('title', 'Profile')
@section('page_title', 'Profile')
@section('customcss')
<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<style>
.error{
    color:red;
}
</style>
@endsection
@section('content')
<div class="row clearfix">
    <div class="col-xs-12 col-sm-3">
        <div class="card profile-card">
            <div class="profile-header">&nbsp;</div>
            <div class="profile-body">
                <div class="image-area">
                    @if(isset($kycdetails) && !empty($kycdetails) && isset($kycdetails->user_img))
                    <img src="{{ URL::asset('kycdocument/userImg/' . $kycdetails->user_img) }}" alt="AdminBSB - Profile Image" width="180px" height="180px"/>
                    @else
                    <img src="{{ asset('adminAsset/images/user-lg.jpg') }}" alt="AdminBSB - Profile Image" width="180px" height="180px"/>
                    @endif
                </div>
                <div class="content-area">
                    <h3>{{ $franchise->fullname }}</h3>
                    <p>{{ $franchise->username }}</p>
                    <p>Franchise Profile</p>
                </div>
            </div>
            <div class="profile-footer">
                <ul>
                    <li>
                        <span>Mobile No.</span>
                        <span>{{ $franchise->mobile }}</span>
                    </li>
                    <li>
                        <span>Registration Date</span>
                        <span>{{ date('d-m-Y', strtotime($franchise->reg_date)) }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-9">
        <div class="card">
            <div class="body">
                <div>
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Home</a></li>
                        <li role="presentation"><a href="#profile_settings" aria-controls="settings" role="tab" data-toggle="tab">Profile Settings</a></li>
                        <li role="presentation"><a href="#change_password_settings" aria-controls="settings" role="tab" data-toggle="tab">Change Password</a></li>
                    </ul>

                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade in active" id="home">
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
                        <div role="tabpanel" class="tab-pane fade in" id="profile_settings">
                            <form class="form-horizontal" id="submitForm" method="POST">
                                <div class="body">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" name="fullname" class="form-control @error('fullname') is-invalid @enderror" placeholder="Fullname" value="{{ $franchise->fullname }}"/>
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
                                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{ $franchise->email }}"/>
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
                                                    <input type="number" name="mobile" class="form-control @error('mobile') is-invalid @enderror" placeholder="Mobile No." value="{{ $franchise->mobile }}"/>
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
                                                    <input type="text" name="nominee_name" class="form-control @error('nominee_name') is-invalid @enderror" placeholder="Nominee Name" value="{{ $franchise->nominee_name }}"/>
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
                                                    <input type="text" name="nominee_relation" class="form-control @error('nominee_relation') is-invalid @enderror" placeholder="Nominee Relation" value="{{ $franchise->nominee_relation }}"/>
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
                                                    <textarea class="form-control @error('address') is-invalid @enderror" name="address" placeholder="Address" >{{ $franchise->address }}</textarea>
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
                                            <h4>Shop Details</h4>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" name="shop_name" class="form-control @error('shop_name') is-invalid @enderror" placeholder="Shop Name" value="{{ $shopdetails->shop_name }}"/>
                                                </div>
                                                @error('shop_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" name="shop_id" class="form-control @error('shop_id') is-invalid @enderror" placeholder="Shop Registration ID" value="{{ $shopdetails->shop_registration_id }}"/>
                                                </div>
                                                @error('shop_id')
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
                                </div>
                            </form>
                        </div>
                        <div role="tabpanel" class="tab-pane fade in" id="change_password_settings">
                            <form class="form-horizontal" method="POST" id="change-password">
                                <div class="form-group">
                                    <label for="OldPassword" class="col-sm-3 control-label">Old Password </label>
                                    <div class="col-sm-9">
                                        <span id="old_err" class="error"></span>    
                                        <div class="form-line">
                                            <input type="password" class="form-control" id="OldPassword" name="OldPassword" placeholder="Old Password">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="NewPassword" class="col-sm-3 control-label">New Password</label>
                                    <div class="col-sm-9"> 
                                        <span id="new_err" class="error"></span>
                                        <div class="form-line">
                                            <input type="password" class="form-control" id="NewPassword" name="NewPassword" placeholder="New Password">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="NewPasswordConfirm" class="col-sm-3 control-label">New Password (Confirm)</label>
                                    <div class="col-sm-9"> 
                                        <span id="confirm_err" class="error"></span>
                                        <div class="form-line">
                                            <input type="password" class="form-control" id="NewPasswordConfirm" name="NewPasswordConfirm" placeholder="New Password (Confirm)">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-offset-3 col-sm-9">
                                        <button type="button" id="submitButton" class="btn btn-danger">SUBMIT</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('customjs')
<!-- Flot Charts Plugin Js -->
<script src="{{ asset('adminAsset/plugins/flot-charts/jquery.flot.js') }}"></script>
<script src="{{ asset('adminAsset/plugins/flot-charts/jquery.flot.resize.js') }}"></script>
<script src="{{ asset('adminAsset/plugins/flot-charts/jquery.flot.pie.js') }}"></script>
<script src="{{ asset('adminAsset/plugins/flot-charts/jquery.flot.categories.js') }}"></script>
<script src="{{ asset('adminAsset/plugins/flot-charts/jquery.flot.time.js') }}"></script>
<script src="{{ asset('adminAsset/js/admin.js') }}"></script>
<script src="{{ asset('adminAsset/js/pages/index.js') }}"></script>
<script>
$('body').on('submit', '#submitForm', function (event) {
    event.preventDefault();
    var formdata = new FormData(this);
    $.ajax({
        url   :"{{ route('franchise.profile.update') }}",
        type  :"POST",
        data  :formdata,
        cache :false,
        processData: false,
        contentType: false,
        success:function(result){
        // alert(result);
            toastr.success(result.success);
            location.reload();
        }
    });
});
$('body').on('click', '#submitButton', function () {
    var OldPassword = $("#OldPassword").val();
    var NewPassword = $("#NewPassword").val();
    var NewPasswordConfirm = $("#NewPasswordConfirm").val();
    if (OldPassword=="") {
        $("#old_err").fadeIn().html("Required");
        setTimeout(function(){ $("#old_err").fadeOut(); }, 3000);
        $("#OldPassword").focus();
        return false;
    }
    if (NewPassword=="") {
        $("#new_err").fadeIn().html("Required");
        setTimeout(function(){ $("#new_err").fadeOut(); }, 3000);
        $("#NewPassword").focus();
        return false;
    }
    if (NewPasswordConfirm=="") {
        $("#confirm_err").fadeIn().html("Required");
        setTimeout(function(){ $("#confirm_err").fadeOut(); }, 3000);
        $("#NewPasswordConfirm").focus();
        return false;
    }
    if(OldPassword == NewPassword)
    {
        $("#old_err").fadeIn().html("New Password Match with Old Password");
        setTimeout(function(){ $("#old_err").fadeOut(); }, 3000);
        $("#OldPassword").focus();
        $("#NewPassword").focus();
        return false;
    }
    if(NewPassword != NewPasswordConfirm)
    {
        $("#new_err").fadeIn().html("New Password and Confirm Password does not Match.");
        setTimeout(function(){ $("#new_err").fadeOut(); }, 3000);
        $("#NewPasswordConfirm").focus();
        $("#NewPassword").focus();
        return false;
    }
    else{
        $.ajax({
            url   :"{{ route('franchise.password.update') }}",
            type  :"POST",
            data  :{OldPassword:OldPassword,NewPassword:NewPassword,NewPasswordConfirm:NewPasswordConfirm},
            success:function(result){
            // alert(result);
                document.getElementById("change-password").reset();
                toastr.success(result.success);
            }
        });
    }
});
</script>
@endsection