@extends('franchise.franchise_layout.main')
@section('title', 'Dashboard')
@section('page_title', 'Dashboard')
@section('customcss')

@endsection
@section('content')
<!-- Widgets -->
<div class="row clearfix">
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-pink hover-expand-effect">
            <div class="icon">
                <i class="material-icons">playlist_add_check</i>
            </div>
            <div class="content">
                <div class="text">Product Amount</div>
                <div class="number count-to" data-from="0" data-to="2500" data-speed="1000" data-fresh-interval="20"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-cyan hover-expand-effect">
            <div class="icon">
                <i class="material-icons">help</i>
            </div>
            <div class="content">
                <div class="text">Admin Amount</div>
                <div class="number count-to" data-from="0" data-to="7500" data-speed="1000" data-fresh-interval="20"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="info-box bg-light-green hover-expand-effect">
            <div class="icon">
                <i class="material-icons">forum</i>
            </div>
            <div class="content">
                <div class="text">Reward</div>
                <div class="number count-to" data-from="0" data-to="2500" data-speed="1000" data-fresh-interval="20"></div>
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
@endsection