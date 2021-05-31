<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Market Career Power | Distributor | Register</title>
    <!-- Favicon-->
    <link rel="icon" href="{{ asset('asset/images/mcp123.png') }}" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="{{ asset('adminAsset/plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="{{ asset('adminAsset/plugins/node-waves/waves.css') }}" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="{{ asset('adminAsset/plugins/animate-css/animate.css') }}" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="{{ asset('adminAsset/css/style.css') }}" rel="stylesheet">
    <style>
        .error{
            color:red;
        }
    </style>
</head>

<body class="signup-page">
    <div class="row">
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
    <div class="signup-box">
        <div class="logo">
            <a href="javascript:void(0);">Market Career<b> Power</b></a>
            <small>Registration Form</small>
        </div>
        <div class="card">
            <div class="body text-center">
                <img src="{{ asset('asset/images/mcp123.png') }}" alt="" width="150px" class="">  
                <form id="sign_up" method="POST" action="{{ route('register.submit') }}">
                @csrf
                    <div class="msg">Register a new user</div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">person</i>
                        </span>
                        <div class="form-line">
                            <input type="text" class="form-control" value="{{ old('referral_code') }}" name="referral_code" id="user_referral_info" placeholder="Enter Referral ID">
                        </div>
                        @error('referral_code')
                            <span class="invalid-feedback error" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <span id="referral_name" class="text-dark"></span>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">account_box</i>
                        </span>
                        <div class="form-line">
                            <input type="text" class="form-control" value="{{ old('sponsor_id') }}" name="sponsor_id" id="sponsor_id" placeholder="Enter Sponsor ID">
                        </div>
                        @error('sponsor_id')
                            <span class="invalid-feedback error" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <span id="sponsor_name" class="text-dark"></span>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">account_circle</i>
                        </span>
                        <div class="form-line">
                            <input type="text" class="form-control" value="{{ old('fullname') }}" name="fullname" placeholder="Enter Fullname">
                        </div>
                        @error('fullname')
                            <span class="invalid-feedback error" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">phone</i>
                        </span>
                        <div class="form-line">
                            <input type="number" class="form-control" value="{{ old('mobile_no') }}" name="mobile_no" placeholder="Enter Mobile No.">
                        </div>
                        @error('mobile_no')
                            <span class="invalid-feedback error" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">location_on</i>
                        </span>
                        <div class="form-line">
                            <textarea class="form-control" name="address" placeholder="Address">{{ old('address ') }}</textarea>
                        </div>
                        @error('address')
                            <span class="invalid-feedback error" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <input type="password" class="form-control" name="password" placeholder="Password">
                        </div>
                        @error('password')
                            <span class="invalid-feedback error" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password">
                        </div>
                    </div>
                    <div class="demo-radio-button">
                        <input type="radio" id="radio_30" name="join_side" value="L" class="with-gap radio-col-red" @if(old('join_side') == "L") Checked @endif>
                        <label for="radio_30">Left Join</label>
                        <input type="radio" id="radio_31" name="join_side" value="R" class="with-gap radio-col-pink" @if(old('join_side') == "R") Checked @endif>
                        <label for="radio_31">Right Join</label>
                    </div>
                    @error('join_side')
                        <span class="invalid-feedback error" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <button class="btn btn-block btn-lg bg-pink waves-effect" type="submit">SIGN UP</button>

                    <div class="m-t-25 m-b--5 align-center">
                        <a href="{{ url('/login') }}">Have an Account?</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

<!-- Jquery Core Js -->
<script src="{{ asset('adminAsset/plugins/jquery/jquery.min.js') }}"></script>

<!-- Bootstrap Core Js -->
<script src="{{ asset('adminAsset/plugins/bootstrap/js/bootstrap.js') }}"></script>

<!-- Waves Effect Plugin Js -->
<script src="{{ asset('adminAsset/plugins/node-waves/waves.js') }}"></script>

<!-- Validation Plugin Js -->
<script src="{{ asset('adminAsset/plugins/jquery-validation/jquery.validate.js') }}"></script>

<!-- Custom Js -->
<script src="{{ asset('adminAsset/js/admin.js') }}"></script>
<script src="{{ asset('adminAsset/js/pages/examples/sign-up.js') }}"></script>
<script>
$(document).ready(function () {
    // keyup function looks at the keys typed on the search box
    $('#user_referral_info').on('keyup',function() {
        // the text typed in the input field is assigned to a variable 
        var query = $(this).val();
        // call to an ajax function
        $.ajax({
            // assign a controller function to perform search action - route name is search
            url:"{{ route('search') }}",
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

$(document).ready(function () {
    // keyup function looks at the keys typed on the search box
    $('#sponsor_id').on('keyup',function() {
        // the text typed in the input field is assigned to a variable 
        var query = $(this).val();
        // call to an ajax function
        $.ajax({
            // assign a controller function to perform search action - route name is search
            url:"{{ route('search') }}",
            // since we are getting data methos is assigned as GET
            type:"GET",
            // data are sent the server
            data:{'user_referral_info':query},
            // if search is succcessfully done, this callback function is called
            success:function (data) {
                // print the search results in the div called country_list(id)
                $('#sponsor_name').html(data);
            }
        })
        // end of ajax call
    });
})
</script>
</body>

</html>