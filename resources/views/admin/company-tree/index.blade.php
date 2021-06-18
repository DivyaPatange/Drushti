@extends('admin.admin_layout.main')
@section('title', 'Company Tree')
@section('page_title', 'Company Tree')
@section('customcss')
<link href="https://unpkg.com/treeflex/dist/css/treeflex.css" rel="stylesheet">
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"> -->
<script src="https://kit.fontawesome.com/60f2fb32da.js" crossorigin="anonymous"></script>
<style>
.tf-nc
{
    border:none !important;
    text-align:center;
}
.tf-nc a
{
    color:white;
}
.tf-tree .tf-nc:after, .tf-tree .tf-nc:before, .tf-tree .tf-node-content:after, .tf-tree .tf-node-content:before{
    border-left:.0625em solid ##0f0e0e;
}
.tf-tree li li:before{
    border-top:.0625em solid ##0f0e0e;
    left: 0;
}
.tf-tree{
    text-align:center;
}
.tf-tree li{
    /* left:12px; */
}
.tf-tree li li:before{
    width:128%;
    left:-1.2125em;
}

.double{
    -moz-column-count: 2;
    -moz-column-gap: 0px;
    -webkit-column-count: 2;
    -webkit-column-gap: 0px;
    column-count: 2;
    column-gap: 0px;
}
</style>
@endsection
@section('content')
<!-- Exportable Table -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>Company Tree</h2>
            </div>
            <div class="body">
                <div class="tf-tree example">
                    <ul>
                        <li>
                            <span class="tf-nc">
                                <i class="fas fa-atom" style="font-size:25px;"></i>
                                <br>
                                Market Career Power
                                <br>
                            </span>
                            <ul id="Decor">
                            @foreach($users as $user)
                                <li>
                                
                                    <span class="tf-nc" style="font-size:15px;">
                                        <a href="#">
                                            <i class="fas fa-atom" style="font-size:30px; color:red;"></i></a>
                                        <br>
                                        {{ $user->fullname }}
                                        <br>
                                        {{ $user->referral_code }}
                                        </span>
                                    @if(count($user->childs))
                                        @include('admin.company-tree.manageChild',['childs' => $user->childs])                                                
                                    @endif
                                </li>
                            @endforeach
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- #END# Exportable Table -->

@endsection
@section('customjs')
<script src="{{ asset('adminAsset/js/admin.js') }}"></script>
<script src="{{ asset('js/treeview.js') }}"></script>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script> -->
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script> -->
<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    statusCode: {
                401: function() 
                        {
                            location.reload();
                        }
                }
});
$(function () {
    $('#Decor ul').hide(600);

    $('#Decor li').on('click', function (e) {
        e.stopPropagation();
        $(this).children('ul').slideToggle();
    });
});
</script>
@endsection