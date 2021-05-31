@extends('franchise.franchise_layout.main')
@section('title', 'Product Payment Details')
@section('page_title', 'Product Payment Details')
@section('customcss')

@endsection
@section('content')
<!-- Widgets -->
<div class="row clearfix">
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box hover-zoom-effect">
            <div class="icon bg-pink">
                <i class="material-icons">playlist_add_check</i>
            </div>
            <div class="content">
                <div class="text">Product Amount</div>
                <div class="number">&#8377;{{ $productPayment->product_amount }}</div>
            </div>
        </div>
    </div>
    @if($productPayment->product_amount == 3000)
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box hover-zoom-effect">
            <div class="icon bg-blue">
                <i class="material-icons">help</i>
            </div>
            <div class="content">
                <div class="text">Admin Amount</div>
                <div class="number">@if(!empty($adminPayment)){{ $adminPayment->admingiven }} @endif</div>
            </div>
        </div>
    </div>
    @endif
</div>
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="body">
                <div class="row" id="div1">
                    <div class="col-12 text-center">
                        <h3>Market Career Power Pvt. Ltd.</h3>
                        <div>
                            <h5>Address:- {{ $franchise->address }}</h5>
                            <h5>Contact No.:- {{ $franchise->mobile }}</h5>
                        </div>
                        <hr>
                        <h2 class="mb-3">Distributor Product Payment Receipt</h2>
                    </div>
                    <div class="col-md-10" style="margin:auto;float:none">
                        <table class="table-responsive table mb-4">
                            <tr>
                                <th style="width:28%">Distributor Name</th>
                                <td style="width:49%">{{ $user->fullname }}</td>
                                <th class="text-center">Amount</th>
                            </tr>
                            <tr>
                                <th>Referral Code</th>
                                <td>{{ $user->referral_code }}</td>
                                <td rowspan="2" class="text-center">&#8377;{{ $productPayment->product_amount }}</td>
                            </tr>
                            <tr>
                                <th>Payment Date</th>
                                <td>{{ $productPayment->payment_date }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <button onclick="printContent('div1')" class="btn bg-black waves-effect waves-light" usesubmitbehavior="False" href="javascript:__doPostBack('btnPrint','')">Print</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- #END# Widgets -->

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
function printContent(el){
    var restorepage = document.body.innerHTML;
    var printcontent = document.getElementById(el).innerHTML;
    document.body.innerHTML = printcontent;
    window.print();
    document.body.innerHTML = restorepage;
}
</script>
@endsection