@extends('distributor.income.index')

@section('income_content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2 >All Rewards</h2>
                <div class="row m-t-15">
                    <div class="col-md-4">
                        <div class="form-group">
                            <select class="form-control show-tick" id="level2">
                                <option value="">-- Select Level --</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="body">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover js-basic-example dataTable" id="simpletable2">
                                <thead>
                                    <tr>
                                        <th>Level</th>
                                        <th>Joiner Required</th>
                                        <th>Joiner Added</th>
                                        <th>Reward</th>
                                        <th>Reward Amount</th>
                                        <th>Admin Charges</th>
                                        <th>My Net Income</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Level</th>
                                        <th>Joiner Required</th>
                                        <th>Joiner Added</th>
                                        <th>Reward</th>
                                        <th>Reward Amount</th>
                                        <th>Admin Charges</th>
                                        <th>My Net Income</th>
                                        <th>Status</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection