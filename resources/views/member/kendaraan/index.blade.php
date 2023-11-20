@extends('admin.layout.index')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ $title }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group row align-items-center">
                                <label class="col-3 col-form-label">Search</label>
                                <div class="col-9">
                                    <input type="text" class="form-control" id="search" placeholder="Merk or Model">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group row align-items-center">
                                <label class="col-3 col-form-label">Date for Rent</label>
                                <div class="col-9">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control daterange-cus">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped  w-100" id="the-data-table">
                            <thead>
                                <tr>
                                    <th>Action</th>
                                    <th>Plat Number</th>
                                    <th>Merk</th>
                                    <th>Model</th>
                                    <th>Rental Rate / Day</th>
                                    <th>Color</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
