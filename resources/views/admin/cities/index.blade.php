@extends("layouts.admin")

@section('template_title')
    All Cities
@endsection

@section('custom_stylesheet')
    <link rel="stylesheet" href="{{ asset('vendor/datatables/media/css/dataTables.bootstrap4.css') }}">
    <style>
        .pac-container {
            z-index: 10000 !important;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card bg-white shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        Cities
                    </h5>
                    <div class="card-header-actions">
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#createModal">
                            <i class="la la-plus"></i> Add City
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-hover" id="dataTable">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Country</th>
                            <th>Name</th>
                            <th>ZIP Code</th>
                            {{--                                <th>Restaurants</th>--}}
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
                <form id="createForm" action="{{ route('cities.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Country</label>
                            <select class="form-control" name="country" id="country" required>
                                <option value="">Select Country</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->country_code }}">{{ $country->country_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>City Name</label>
                            <input type="text" class="form-control" name="city_name" id="city_name" required>
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
    <script type="text/javascript" src='https://maps.googleapis.com/maps/api/js?key={{ config("settings.googleMapsAPIKey") }}&libraries=places&dummy=.js'></script>
    <script>
        let dataTable;
        $(document).ready(function() {
            dataTable = $('#dataTable').DataTable({
                language: { search: "", searchPlaceholder: "Search..." },
                "processing": true,
                "serverSide": true,
                "responsive": true,
                "ajax": '{{ route('cities.index') }}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'country_name', name: 'country_name'},
                    { data: 'city_name', name: 'city_name' },
                    { data: 'zip_code', name: 'zip_code' },
                    // { data: 'restaurants', name: 'restaurants' },
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
            var geocoder = new google.maps.Geocoder();
            var address = $('input[name="city_name"]').val();
            var latitude = 0.0;
            var longitude = 0.0;

            geocoder.geocode({'address': address}, function(results, status) {

                if (status == google.maps.GeocoderStatus.OK) {
                    latitude = results[0].geometry.location.lat();
                    longitude = results[0].geometry.location.lng();

                    $.ajax({
                        type: 'POST',
                        url: url,
                        data: {
                            _token: '{{ csrf_token() }}',
                            city_name: address,
                            // zip_code: $('input[name="zip_code"]').val(),
                            country: $('select[name="country"]').val(),
                            latitude: latitude,
                            longitude: longitude,
                        },
                        success: function (data) {
                            if($.isEmptyObject(data.error)) {
                                toastr.success(data.success);
                                $('#createModal').modal('toggle');
                                dataTable.draw();
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
                    });
                }
            });
        });
    </script>
    <script>
        function initialize(country) {
            var options = {
                types: ['(cities)'],
                componentRestrictions: {country: country}
            };

            var input = document.getElementById('city_name');
            var autocomplete = new google.maps.places.Autocomplete(input, options);
        }

        $('#country').on('change', function () {
            if($('#country').val()) {
                $('#city_name').prop('disabled', false);
                $('#city_name').val('');
                var country = $(this).val();
                initialize(country);
            }
        });

        $(document).ready(function () {
            if(!$('#country').val()) {
                $('#city_name').prop('disabled', true);
            } else {
                initialize($('#country').val());
            }
        });

    </script>
@endsection

