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
                                    <label>Plat Kendaraan</label>
                                    <input disabled type="text" id="plat_number" class="form-control"
                                        value="{{ $detail->plat_number }}">
                                    <div class="invalid-feedback" for="plat_number">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label>Tanggal Mulai</label>
                                    <input disabled type="text" id="total_rent_fee" class="form-control"
                                        value="{{ currencyIDR($detail->total_rent_fee) }}">
                                    <div class="invalid-feedback" for="total_rent_fee">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label>Tanggal Berakhir</label>
                                    <input disabled type="text" id="rent_start_date" class="form-control"
                                        value="{{ parseTanggal($detail->rent_start_date, true) }}">
                                    <div class="invalid-feedback" for="rent_start_date">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label>Total</label>
                                    <input disabled type="text" id="rent_end_date" class="form-control"
                                        value="{{ parseTanggal($detail->rent_end_date, true) }}">
                                    <div class="invalid-feedback" for="rent_end_date">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer pt-">
                        <button type="submit" id="btn-save" class="btn btn-success">Return Kendaraan</button>
                        <a href="{{ route('transaksi-rental') }}" id="btn-cancel" class="btn btn-secondary">Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
