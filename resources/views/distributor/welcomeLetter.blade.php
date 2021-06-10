@extends('distributor.distributor_layout.main')
@section("title","welcome letter")
@section("page_title","welcome letter")
@section("customcss")

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
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header" style="background: linear-gradient(64deg, #212529de 0, #212229ab 100%);">
                <!-- Card stats -->
                <div class="card-body">
                    <h2 style="color:white"><b>welcome letter</b></h2>
                    
                    <div class="row">
                        <div class="col-md-12" style="color:white">
                            <table cellspacing="0" cellpadding="2" border="0" width="100%">
                            <tbody>
                            <tr>
                                <td>
                                    <center>
                                        <table  id="div1" align="center" cellspacing="0" cellpadding="5" style="font-family: Verdana;
                                            width: 670px;">
                                            <tbody><tr>
                                                <td style="border-bottom: black 1px solid; text-align: right">
                                                    <span id="lbldate" class="label" style="font-family:Verdana;font-size:11px;">{{ "Date: " . date("d/m/Y") }}</span></td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: left">
                                                    <br>
                                                    <table border="0" cellspacing="2" cellpadding="2">
                                                        <tbody><tr>
                                                            <td>
                                                                <div id="lblWelcomeLetter" class="tdEmpty width-250"><div>Dear&nbsp;&nbsp;{{Auth::user()->fullname}}</div>
                                                                <div><br></div><div><b>ID</b>&nbsp;: {{Auth::user()->referral_code}}&nbsp;
                                                                <div><b>DOJ</b>&nbsp;: &nbsp;</div>
                                                                <div><b>Address&nbsp;</b>: &nbsp;</div>
                                                                <!--<div><b>City</b>&nbsp;: Nagpur&nbsp;</div>-->
                                                                <!--<div><b>Pin code</b>&nbsp;: 440009&nbsp;</div>-->
                                                                <!--<div><b>User Name :&nbsp;</b>TIA188833</div>-->
                                                                <div><b><br></b></div><div>Congratulations on your decision!&nbsp;</div>
                                                                <div><br></div>
                                                                <div style="text-align: justify;">A journey of a thousand miles must begin with a single step. I’d like to welcome you to&nbsp;Market Career Power. We are excited that you have accepted our business offer and agreed upon your start date. I trust that this letter finds you mutually excited about your new opportunity with&nbsp;Market Career Power.&nbsp;</div><div><br></div><div style="text-align: justify;">Each of us will play a role to ensure your successful integration into the company. Your agenda will involve planning your orientation with company and setting some initial work goals so that you feel immediately productive in your new role. And further growing into an integral part of this business.e providing you an opportunity to 
                                                                earn money which is optional, your earnings will depend directly in the 
                                                                amount of efforts you put to develop your business. Again, welcome to 
                                                                the team. If you have questions prior to your start date, please call me
                                                                 at any time, or send email if that is more convenient. We look forward 
                                                                to having you come onboard. The secret of success is constancy to 
                                                                purpose. <br></div><br><br><i>ALL THE BEST, SEE YOU AT TOP !!</i>&nbsp;<i></i><div>&nbsp;</div><div>Winning Regards,&nbsp;</div><div><b>Chief Admin Officer&nbsp;</b></div><div><b>Market Career Power.<br></b></div></div>
                                        </td>
                                        </tr>
                                                    </tbody></table>
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                                <td class="noprint">
                                                    <center>
                                                        <span id="lblerr" class="label"></span></center>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </center>
                             </td>
                            </tr>
                            <tr>
                            <td>
                            &nbsp;</td>
                            </tr>
                            <tr>
                                <td>
                                    &nbsp;</td>
                            </tr>
                            </tbody>
                        </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center">
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