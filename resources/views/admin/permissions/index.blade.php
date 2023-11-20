@extends('admin.layout.index')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>{{ $title }}</h4>
                    <div class="card-header-action ml-auto">
                        <a href="{{ route('create-permission') }}" class="btn btn-success">Create New</a>
                    </div>
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

                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped" id="the-data-table" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>Action</th>
                                    <th>Permission Name</th>
                                    <th>Updated At</th>
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
