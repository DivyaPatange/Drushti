@extends('front.frontLayout.main')
@section('customecss')

  <style>
          
      
  </style>
@endsection
@section('content')
<!-- banner-2 -->
<!-- banner-2 -->
<div class="page-head_agile_info_w3l">

</div>
<!-- //banner-2 -->
<!-- page -->
<div class="services-breadcrumb">
    <div class="agile_inner_breadcrumb">
        <div class="container">
            <ul class="w3_short">
                <li>
                    <a href="index">Home</a>
                    <i>|</i>
                </li>
                <li>Legal Document</li>
            </ul>
        </div>
    </div>
</div>
<!-- //page -->

<!-- top Products -->
<div class="ads-grid py-sm-5 py-4">
    <div class="container py-xl-4 py-lg-2">
        <!-- tittle heading -->
        <h3 class="tittle-w3l text-center mb-lg-5 mb-sm-4 mb-3">
            <span>L</span>egal
            <span>D</span>ocument</h3>
        <!-- //tittle heading -->
        <div class="row">
            <!-- product left -->
            <div class="agileinfo-ads-display col-lg-12">
                <div class="wrapper">
                    <!-- first section -->
                    <div class="container page-top">
                        <div class="row">
                            <div class="col-md-3 thumb">
                                <a href="{{ asset('asset/images/marketcareer.jpg') }}" class="fancybox" rel="ligthbox">
                                    <img  src="{{ asset('asset/images/marketcareer.jpg') }}" class="zoom img-fluid "  alt="">
                                </a>
                            </div>
                            
            
                        </div>
                    </div>
                </div>
            </div>
            <!-- //product left -->
            
            
        </div>
    </div>
</div>
<!-- //top products -->
@endsection
@section('customjs')

@endsection