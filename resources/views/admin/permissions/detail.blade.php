@extends('admin.layout.index')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card" id="sample-login">
                <form id="form-manipulation" enctype="multipart/form-data">
                    <div class="card-header">
                        <h4>{{ $title }}</h4>
                    </div>
                    <div class="card-body pb-0">
                        <div id="alert-message-error" style="display: none;" class="alert alert-danger alert-dismissible">
                            <div class="alert-body">
                            </div>
                        </div>
                        <div id="alert-message-success" style="display: none;"
                            class="alert alert-success alert-dismissible">
                            <div class="alert-body">
                            </div>
                        </div>
                        <div class="row">
                            @csrf
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label>Permission Name</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        value="{{ $detail->name }}">
                                    <div class="invalid-feedback" for="name">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer pt-">
                        <button type="submit" id="btn-save" class="btn btn-success">Save</button>
                        <a href="{{ route('permission') }}" id="btn-cancel" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
