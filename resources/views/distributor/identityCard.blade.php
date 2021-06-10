@extends('distributor.distributor_layout.main')
@section("title","Identity Card")
@section("page_title","Identity Card")
@section("customcss")
<style>
    .identityborder{
    border: 1px solid black;
    }
    img{
    border-radius: 15px 0px 15px 0px;
    border: 1px solid black;
    }
</style>
@endsection
@section("content")
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
<div class="header-body">
    <!-- Card stats -->
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                    <div class="row mt-5" id="div1">
                        <div class="col-md-3"></div>
                        <div class="col-md-6 mx-auto identityborder mt-5" style="margin-top: 20px;">
                            <div class="row">
                                <div class="col-12 text-center">
                                    <img src="" class="m-2" width="100%">
                                    <div><h4>Plot No: - 47 old kanpthi road,balaji nagar, near yashvant school,Dr.Ambedkar marg, Nagpur, Maharashtra - 440017.</h4></div>
                                    <div class="mb-2"><h4>info@marketcareerpower.com</h4></div>
                                </div>
                                <div class="col-12 text-center">
                                    <img src="" alt="Distributor photo" style="height:170px; width:150px" class="border">
                                </div>
                                <div class="col-12 text-center mt-2 mb-2">
                                    <h4><b>Name:- &nbsp;{{Auth::user()->fullname}}</b></h4>
                                    <h4><b>Distributor ID:- &nbsp;{{Auth::user()->referral_code}}</b></h4>
                                    <h4><b>Contact No.:- &nbsp;</b></h4>
                                    <h4><b>Address.:- &nbsp; </b></h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3"></div>
                    </div>
                    <br> 
                    <br>
                                
                    <div class="row">
                        <div class="col-md-12 text-center" style="margin-bottom: 20px;">
                            <button onclick="printContent('div1')" class="btn btn-dark" usesubmitbehavior="False" href="javascript:__doPostBack('btnPrint','')">Print</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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
<script>
    function printContent(el){
        var restorepage = document.body.innerHTML;
        var printcontent = document.getElementById(el).innerHTML;
        document.body.innerHTML = printcontent;
        window.print();
        document.body.innerHTML = restorepage;
    }
</script>
@endsection