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
                                    <label>Plat Number</label>
                                    <input type="text" name="plat_number" id="plat_number" class="form-control"
                                        value="" placeholder="Plat Nomor Tanpa Spasi">
                                    <div class="invalid-feedback" for="plat_number">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label>Merk</label>
                                    <input type="text" name="merk" id="merk" class="form-control" value="">
                                    <div class="invalid-feedback" for="merk">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label>Model</label>
                                    <input type="text" name="model" id="model" class="form-control" value="">
                                    <div class="invalid-feedback" for="model">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label>Color</label>
                                    <input type="text" name="color" id="color" class="form-control" value="">
                                    <div class="invalid-feedback" for="color">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-sm-12">
                                <div class="form-group">
                                    <label>Rental Rate</label>
                                    <input type="text" name="rental_rate" id="rental_rate"
                                        class="form-control only-number" value="">
                                    <div class="invalid-feedback" for="rental_rate">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="card-footer pt-">
                        <button type="submit" id="btn-save" class="btn btn-success">Save</button>
                        <a href="{{ route('kendaraan') }}" id="btn-cancel" class="btn btn-secondary">Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
