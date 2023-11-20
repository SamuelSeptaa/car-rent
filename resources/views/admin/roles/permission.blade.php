@extends('admin.layout.index')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form action="#" id="form-manipulation" enctype="multipart/form-data">
                    <div class="card-header">
                        <h4>{{ $title }}</h4>
                    </div>
                    <div class="card-body">
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
                            @foreach ($detail as $d)
                                <div class="col-12 col-md-6 col-lg-4 permission-menus">
                                    <div class="card card-primary">
                                        <div class="card-header">
                                            <h4>{{ ucwords(str_replace(['-', '_'], ' ', $d->menu_name)) }}</h4>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-sm">
                                                <tbody>
                                                    <tr>
                                                        <th style="width: 5%" class="align-middle"><input
                                                                class="select-all-permission-menu"
                                                                data-menu_name="{{ $d->menu_name }}" type="checkbox"
                                                                name="">
                                                        </th>
                                                        <td>
                                                            <div class="mb-1">
                                                                <b>Select All</b>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @foreach ($d->permission_list as $permission)
                                                        <tr>
                                                            <th style="width: 5%" class="align-middle"><input
                                                                    class="permission-checkbox"
                                                                    data-menu_name="{{ $d->menu_name }}"
                                                                    {{ $permission->is_has_permission ? 'checked' : '' }}
                                                                    type="checkbox" value="{{ $permission->id }}"
                                                                    name="permission_id[]">
                                                            </th>
                                                            <td>
                                                                <div class="mb-1">
                                                                    {{ $permission->name }}
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                    <div class="card-footer pt-0">
                        <button type="submit" id="btn-save" class="btn btn-success">Save</button>
                        <a href="{{ route('role') }}" id="btn-cancel" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
