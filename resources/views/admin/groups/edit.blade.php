@extends("layouts.admin")

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        Edit Information
                    </h4>
                </div>
                <form action="{{ route('groups.update', ['group' => $group]) }}" method="post" id="editForm">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label>Title</label>
                            <input class="form-control" type="text" name="title" value="{{ $group->title }}">
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" name="description">{{ $group->description }}</textarea>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="form-group">
                            <button class="btn btn-outline-success" type="submit">
                                Submit
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('template_scripts')
    <script>
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
        $('#editForm').submit(function (e) {
            e.preventDefault();

            var formData = $(this).serialize();
            var url = $(this).attr('action');
            $.ajax({
                type: 'POST',
                url: url,
                data: formData,
                success: function (data) {
                    if($.isEmptyObject(data.error)) {
                        toastr.success(data.success);
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
                }
            })
        })
    </script>
@endsection
