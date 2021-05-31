@extends('distributor.income.index')

@section('income_content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>All Income</h2>
            </div>
            <div class="body">
                <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box-3 bg-brown">
                        <div class="icon">
                            <span class="chart chart-line">9,4,6,5,6,4,7,3</span>
                        </div>
                        <div class="content">
                            <div class="text">TOTAL INCOME</div>
                            <div class="number">&#8377;{{ number_format($userIncome) }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box-3 bg-grey">
                        <div class="icon">
                            <span class="chart chart-line">9,4,6,5,6,4,7,3</span>
                        </div>
                        <div class="content">
                            <div class="text">TOTAL SALARY</div>
                            <div class="number">&#8377;{{ number_format($userSalary) }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box-3 bg-blue-grey">
                        <div class="icon">
                            <div class="chart chart-bar">4,6,-3,-1,2,-2,4,6</div>
                        </div>
                        <div class="content">
                            <div class="text">TOTAL REWARD</div>
                            <div class="number">&#8377;{{ number_format($reward) }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box-3 bg-black">
                        <div class="icon">
                            <div class="chart chart-bar reverse">4,6,-3,-1,2,-2,4,6</div>
                        </div>
                        <div class="content">
                            <div class="text">TOTAL</div>
                            <div class="number">&#8377;{{ number_format($total) }}</div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection