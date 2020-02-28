@extends('layouts.admin')

@section('template_title')
    Edit - {{ $user->name }}
@endsection

@section('custom_stylesheet')
    <link rel="stylesheet" href="{{ asset('vendor/selectize/css/selectize.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/selectize/css/selectize.default.css') }}">
@endsection

@section('content')
    <div class="container pt-5 pb-5">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#edit_account_tab" role="tab">
                                    <i class="la la-user"></i> Account
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#change_pwd_tab" role="tab">
                                    <i class="la la-user-secret"></i> Change Password
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="edit_account_tab" role="tabpanel">
                                <form action="{{ route('users.update', $user->id) }}" method="post" id="updateForm">
                                    @csrf
                                    @method('put')
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label">Username</label>
                                        <div class="col-lg-9 col-xl-9">
                                            <input class="form-control" type="text" name="name" placeholder="Username" value="{{ $user->name }}" required>
                                            <span class="invalid-feedback name-error">
                                                </span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label">Email</label>
                                        <div class="col-lg-9 col-xl-9">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="la la-at"></i>
                                                        </span>
                                                </div>
                                                <input class="form-control" type="email" name="email" placeholder="Email Address" value="{{ $user->email }}" required>
                                            </div>
                                            <span class="invalid-feedback email-error">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label">
                                            Phone Number
                                        </label>
                                        <div class="col-lg-9 col-xl-9">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="la la-phone"></i>
                                                    </span>
                                                </div>
                                                <input class="form-control" type="text" name="phone_number" value="{{ $user->phone_number }}" placeholder="Phone Number">
                                            </div>
                                            <span class="invalid-feedback phone_number-error">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label">
                                            Driver License
                                        </label>
                                        <div class="col-lg-9 col-xl-9">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="la la-car"></i>
                                                    </span>
                                                </div>
                                                <input class="form-control" type="text" name="driver_license" value="{{ $user->driver_license }}" placeholder="Driver License">
                                            </div>
                                            <span class="invalid-feedback driver_license-error">
                                                </span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label">First Name</label>
                                        <div class="col-lg-9 col-xl-9">
                                            <input class="form-control" type="text" name="first_name" value="{{ $user->first_name }}" placeholder="First Name" required>
                                            <span class="invalid-feedback first_name-error">
                                                </span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label">Last Name</label>
                                        <div class="col-lg-9 col-xl-9">
                                            <input class="form-control" type="text" name="last_name" value="{{ $user->last_name }}" placeholder="Last Name" required>
                                            <span class="invalid-feedback last_name-error">
                                                </span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label">
                                            Roles
                                        </label>
                                        <div class="col-lg-9 col-xl-9">
                                            <select name="role[]" multiple="multiple" id="roles">
                                                @if ($roles)
                                                    @foreach($roles as $role)
                                                        <option
                                                            value="{{ $role->id }}"
                                                            @foreach($user->roles as $user_role)
                                                            @if($role->id == $user_role->id)
                                                            selected="selected"
                                                            @endif
                                                            @endforeach
                                                        >
                                                            {{ $role->name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <div class="invalid-feedback role-error">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label">
                                            City
                                        </label>
                                        <div class="col-lg-9 col-xl-9">
                                            <select class="form-control" name="city">
                                                <option value="">Select City</option>
                                                @if ($cities)
                                                    @foreach($cities as $city)
                                                        <option value="{{ $city->id }}" @if($currentCity) {{ $currentCity->id == $city->id ? 'selected="selected"' : '' }} @endif>{{ $city->city_name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <span class="invalid-feedback city-error">
                                                </span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-3 col-xl-3"></div>
                                        <div class="col-lg-9 col-xl-6">
                                            <button class="btn btn-primary btn-save" type="submit">
                                                Save Changes
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane" id="change_pwd_tab" role="tabpanel">
                                <form action="{{ route('users.update-pwd', ['user' => $user->id]) }}" method="post" id="pwdForm">
                                    @csrf
                                    @method('put')
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label">
                                            Password
                                        </label>
                                        <div class="col-xl-9 col-lg-9">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="la la-lock"></i>
                                                        </span>
                                                </div>
                                                <input type="password" name="password" class="form-control" placeholder="Password">
                                            </div>
                                            <span class="invalid-feedback password-error">
                                                </span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label">
                                            Password Confirmation
                                        </label>
                                        <div class="col-xl-9 col-lg-9">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="la la-lock"></i>
                                                        </span>
                                                </div>
                                                <input type="password" name="password_confirmation" class="form-control" placeholder="Password Confirmation">
                                            </div>
                                            <span class="invalid-feedback password_confirmation-error">
                                                </span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-3 col-xl-3"></div>
                                        <div class="col-lg-9 col-xl-6">
                                            <button class="btn btn-primary btn-bold" type="submit">
                                                Change Password
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('template_scripts')
    <script src="{{ asset('vendor/selectize/js/standalone/selectize.js') }}"></script>
    <script type="text/javascript">
        $("#roles").selectize({
            create: true
        });
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
        $('#pwdForm').submit(function (e) {
            e.preventDefault();

            let form = $(this);
            let url = form.attr('action');

            $.ajax({
                type:'POST',
                url: url,
                data: form.serialize(),
                success:function(data){
                    if($.isEmptyObject(data.error)){
                        // alert(data.success);
                        toastr.success(data.success);
                        $('.invalid-feedback').each(function (i, obj) {
                            obj.innerHTML = '';
                        });
                        $("input").each(function (i, obj) {
                            obj.classList.remove('is-invalid');
                        });
                        $("select").each(function (i, obj) {
                            obj.classList.remove('is-invalid');
                        });
                    }else{
                        $.each( data.error, function( key, value ) {
                            $("input[name="+key+"]").addClass('is-invalid');
                            $("select[name="+key+"]").addClass('is-invalid');
                            $('.'+key+'-error').html(value[0]);
                            $('.'+key+'-error').css('display', 'block');
                        });
                    }
                }
            }).done(function () {
                setTimeout(function(){
                    $("#overlay").fadeOut(300);
                },500);
            });
        });
        $('#updateForm').submit(function (e) {
            e.preventDefault();

            let form = $(this);
            let url = form.attr('action');

            $.ajax({
                type:'POST',
                url: url,
                data: form.serialize(),
                success:function(data){
                    if($.isEmptyObject(data.error)){
                        toastr.success(data.success);
                        $('.invalid-feedback').each(function (i, obj) {
                            obj.innerHTML = '';
                        });
                        $("input").each(function (i, obj) {
                            obj.classList.remove('is-invalid');
                        });
                        $("select").each(function (i, obj) {
                            obj.classList.remove('is-invalid');
                        });
                    }else{
                        $.each( data.error, function( key, value ) {
                            $("input[name="+key+"]").addClass('is-invalid');
                            $("select[name="+key+"]").addClass('is-invalid');
                            $('.'+key+'-error').html(value[0]);
                            $('.'+key+'-error').css('display', 'block');
                        });
                    }
                }
            });
        });
    </script>
@endsection
