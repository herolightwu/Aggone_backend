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
                        All Players
                    </h5>
                    <div class="dropdown">
                        <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
                            <i class="la la-lg la-ellipsis-v"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="{{ route('deleted-users.index') }}">
                                <i class="fa fa-lg fa-user-times"></i>Deleted Players
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-hover" id="dataTable">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Avatar</th>
                            <th>E-mail</th>
                            <th>Sport</th>
                            <th>City</th>
                            <th>Category</th>
                            <th>Club</th>
                            <th>Age</th>
                            <th>Height (Cm)</th>
                            <th>Weight (Kg)</th>
                            <th>Birthday</th>
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
                "ajax": '{{ route('coaches.index') }}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'username', name: 'username' },
                    { data: 'avatar', name: 'avatar', orderable: false, searchable: false },
                    { data: 'email', name: 'email' },
                    // { data: 'group_id', name: 'group' },
                    { data: 'sport', name: 'sport' },
                    { data: 'city', name: 'city'},
                    { data: 'category', name: 'category'},
                    { data: 'club', name: 'club'},
                    { data: 'age', name: 'age'},
                    { data: 'height', name: 'height'},
                    { data: 'weight', name: 'weight'},
                    { data: 'birthday', name: 'birthday'},
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
    </script>
@endsection
