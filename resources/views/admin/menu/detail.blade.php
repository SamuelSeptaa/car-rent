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
                                    <label>Title</label>
                                    <input type="text" name="title" id="title" class="form-control"
                                        value="{{ $detail->title }}">
                                    <div class="invalid-feedback" for="title">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label>Uri</label>
                                    <input type="text" name="uri" id="uri" oninput="updateValue(this)"
                                        class="form-control" disabled value="{{ $detail->uri }}">
                                    <div class="invalid-feedback" for="uri">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label>Icon</label>
                                    <input type="text" name="icon" id="icon" class="form-control"
                                        placeholder="Icon Font Awesome 5" value="{{ $detail->icon }}">
                                    <div class="invalid-feedback" for="icon">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label>Menu Header</label>
                                    <select class="form-control select2" id="header" name="header">
                                        <option selected></option>
                                        @foreach ($header_list as $h)
                                            <option {{ $detail->header == $h->id ? 'selected' : '' }}
                                                value="{{ $h->id }}">{{ $h->title }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback" for="header">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-check">
                                    <input class="form-check-input"
                                        {{ $detail->is_has_data_manipulation == 'YES' ? 'checked' : '' }} disabled
                                        type="checkbox" name="is_has_data_manipulation" value="YES">
                                    <label class="form-check-label">
                                        Is Has Data Manipulation
                                    </label>
                                    <small class="form-text text-muted">
                                        Enable if the menu has create, edit, and delete.
                                    </small>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="card-footer pt-">
                        <button type="submit" id="btn-save" class="btn btn-success">Save</button>
                        <a href="{{ route('menu') }}" id="btn-cancel" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
