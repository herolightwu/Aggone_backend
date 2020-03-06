@extends("layouts.admin")

@section('custom_stylesheet')
    <link rel="stylesheet" href="{{ asset('vendor/datatables/media/css/dataTables.bootstrap4.css') }}">
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card bg-white shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        Countries
                    </h5>
                    <div class="card-header-actions">
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#createModal">
                            <i class="la la-plus"></i> Add Country
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-hover" id="dataTable">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Country Code</th>
                            <th>ISO Code</th>
                            <th>Cities</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom_modal')
    <div class="modal fade" id="createModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <form id="createForm" action="{{ route('countries.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Country Name</label>
                            <input class="form-control" name="country_name" type="text" placeholder="United States">
                        </div>
                        <div class="form-group">
                            <label>Country Code</label>
                            <input class="form-control" name="country_code" type="text" placeholder="us">
                        </div>
                        <div class="form-group">
                            <label>Phone Prefix</label>
                            <input class="form-control" name="iso_code" type="text" placeholder="+1">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-outline-success btn-create" type="submit">
                            <i class="la la-save"></i> Submit
                        </button>
                        <button class="btn btn-outline-secondary" type="button" data-dismiss="modal">
                            <i class="la la-times"></i> Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white">Delete</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="la la-times text-white"></i>
                    </button>
                </div>
                <div class="modal-body">
                    Do you want to delete?
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-danger btn-confirm-delete">
                        <i class="la la-trash"></i> Confirm Delete
                    </button>
                    <button class="btn btn-outline-secondary" data-dismiss="modal">
                        <i class="la la-times"></i> Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="restoreModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title">Restore</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="la la-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    Do you want to restore?
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-warning btn-confirm-restore">
                        <i class="la la-reply"></i> Confirm Restore
                    </button>
                    <button class="btn btn-outline-secondary" data-dismiss="modal">
                        <i class="la la-times"></i> Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('template_scripts')
    <script src="{{ asset('vendor/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/media/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/media/js/dataTables.responsive.js') }}"></script>
    <script>
        let dataTable;
        $(document).ready(function() {
            dataTable = $('#dataTable').DataTable({
                language: { search: "", searchPlaceholder: "Search..." },
                "processing": true,
                "serverSide": true,
                "responsive": true,
                "ajax": '{{ route('countries.index') }}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'country_name', name: 'country_name' },
                    { data: 'country_code', name: 'country_code' },
                    { data: 'iso_code', name: 'iso_code' },
                    { data: 'cities', name: 'cities' },
                    { data: 'deleted_at', name: 'deleted_at' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ]
            });
        });
        let deleteUrl;
        $('#deleteModal').on('show.bs.modal', function (e) {
            deleteUrl = $(e.relatedTarget).attr('data-url');
        });
        $('.btn-confirm-delete').click(function (e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: deleteUrl,
                data: {
                    _token: '{{ csrf_token() }}',
                    _method: 'DELETE'
                },
                success: function (data) {
                    if($.isEmptyObject(data.error)) {
                        toastr.success(data.success);
                        dataTable.draw();
                        $('#deleteModal').modal('toggle');
                    } else {
                        var messages = '';
                        $.each( data.error, function( key, value ) {
                            messages += value[0] + '<br />';
                        });
                        toastr.error(messages);
                        $('#deleteModal').modal('toggle');
                    }
                },
                error: function (xhr, status, thrownError) {
                    toastr.error(thrownError);
                    $('#deleteModal').modal('toggle');
                }
            })
        });

        let restoreUrl;
        $('#restoreModal').on('show.bs.modal', function (e) {
            restoreUrl = $(e.relatedTarget).attr('data-url');
        });
        $('.btn-confirm-restore').click(function (e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: restoreUrl,
                data: {
                    _token: '{{ csrf_token() }}',
                    _method: 'PUT'
                },
                success: function (data) {
                    if($.isEmptyObject(data.error)) {
                        toastr.success(data.success);
                        dataTable.draw();
                        $('#restoreModal').modal('toggle');
                    } else {
                        var messages = '';
                        $.each( data.error, function( key, value ) {
                            messages += value[0] + '<br />';
                        });
                        toastr.error(messages);
                        $('#restoreModal').modal('toggle');
                    }
                },
                error: function (xhr, status, thrownError) {
                    toastr.error(thrownError);
                    $('#restoreModal').modal('toggle');
                }
            })
        });

        $('#createForm').submit(function (e) {
            e.preventDefault();
            let url = $(this).attr('action');
            let form = $(this);
            $.ajax({
                type: 'POST',
                url: url,
                data: form.serialize(),
                success: function (data) {
                    if($.isEmptyObject(data.error)) {
                        toastr.success(data.success);
                        dataTable.draw();
                        $('#createModal').modal('toggle');
                    } else {
                        var messages = '';
                        $.each( data.error, function( key, value ) {
                            messages += value[0] + '<br />';
                        });
                        toastr.error(messages);
                    }
                },
                error: function (xhr, status, thrownError) {
                    toastr.error(thrownError);
                    $('#createModal').modal('toggle');
                }
            })
        })
    </script>
@endsection
