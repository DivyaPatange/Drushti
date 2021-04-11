@extends('distributor.distributor_layout.main')
@section('title', 'Add Joiner')
@section('page_title', 'Add Joiner')
@section('customcss')
@endsection
@section('content')
<!-- Exportable Table -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>Add Joiner</h2>
            </div>
            <div class="body">
                <form method="POST" action="{{ route('admin.distributor.store') }}">
                @csrf
                    <div class="row clearfix">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" name="user_referral" class="form-control @error('user_referral') is-invalid @enderror" id="user_referral_info" placeholder="Enter Referral Code" value="{{ old('user_referral') }}"/>
                                </div>
                                @error('user_referral')
                                    <span class="invalid-feedback error" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <h3 id="referral_name"></h3>
                            </div>
                        </div>
                    </div>
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
                                    <input type="number" name="mobile_no" class="form-control @error('mobile_no') is-invalid @enderror" placeholder="Mobile No." value="{{ old('mobile_no') }}"/>
                                </div>
                                @error('mobile_no')
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
<script>
$(document).ready(function () {
    // keyup function looks at the keys typed on the search box
    $('#user_referral_info').on('keyup',function() {
        // the text typed in the input field is assigned to a variable 
        var query = $(this).val();
        // call to an ajax function
        $.ajax({
            // assign a controller function to perform search action - route name is search
            url:"{{ route('distributor.search') }}",
            // since we are getting data methos is assigned as GET
            type:"GET",
            // data are sent the server
            data:{'user_referral_info':query},
            // if search is succcessfully done, this callback function is called
            success:function (data) {
                // print the search results in the div called country_list(id)
                $('#referral_name').html(data);
            }
        })
        // end of ajax call
    });
})
</script>
<script type="text/javascript"> 
    $(function(){
        setTimeout(function(){
        $(".error").hide();
        }, 2500);
    });
</script> 
@endsection