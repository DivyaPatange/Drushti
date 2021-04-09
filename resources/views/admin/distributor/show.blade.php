@extends('admin.admin_layout.main')
@section('title', 'Distributor Profile')
@section('page_title', 'Distributor Profile')
@section('customcss')
@endsection
@section('content')
<!-- Exportable Table -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
            <a href="javascript:void(0)" onclick="$(this).parent().find('form').submit()"><button type="button" class="btn btn-danger waves-effect">Login To Distributor</button></a>
            <form action="{{ route('login') }}" method="post" target="_blank">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="id" value="{{ $user->id}}">
                <input type="hidden" name="username" value="{{ $user->username }}">
                <input type="hidden" name="password" value="{{ $user->password_1}}">
            </form>
            </div>
            <div class="body">
               
            </div>
        </div>
    </div>
</div>
<!-- #END# Exportable Table -->

@endsection
@section('customjs')
<script src="{{ asset('adminAsset/js/admin.js') }}"></script>
@endsection