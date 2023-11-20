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
                                    <input type="text" class="form-control form-control-sm" id="search">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-sm-12">
                            <div class="buttons">
                                <button class="btn btn-sm btn-outline-info btn-filter" data-status="all">All</button>
                                @foreach ($statuses as $status)
                                    <button class="btn btn-sm btn-outline-info btn-filter"
                                        data-status="{{ $status }}">{{ $status }}</button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped" id="the-data-table">
                            <thead>
                                <tr>
                                    <th class="text-center">Action</th>
                                    <th class="text-center">Plat Number</th>
                                    <th class="text-center">Start Date Rental</th>
                                    <th class="text-center">End Date Rental</th>
                                    <th class="text-center">Total Rental Fee</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Late Fee</th>
                                    <th class="text-center">Date Of Returned</th>
                                    <th class="text-center">Rent At</th>
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
