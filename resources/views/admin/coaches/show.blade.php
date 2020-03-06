@extends("layouts.admin")

@section('content')
    <div class="container pt-5 pb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-header">
                        User Details
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card-title">
                                    Avatar
                                </div>
                                <div class="card-img">
                                    <img class="img-fluid" src="@if ($user->profile && $user->profile->avatar) {{ $user->profile->avatar }} @else {{ Gravatar::get($user->email) }} @endif">
                                </div>
                                <div class="card-title pt-3">
                                    Driver License
                                </div>
                                <div class="card-img">
                                    <img class="img-fluid" src="@if ($user->profile && $user->profile->license_image) {{ $user->profile->license_image }} @endif">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3">
                                    <div class="card-title">
                                        Email
                                    </div>
                                    <div class="card-text">
                                        <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                                    </div>
                                </div>
                                <div class="p-3">
                                    <div class="card-title">
                                        Phone Number
                                    </div>
                                    <div class="card-text">
                                        <a href="tel:{{ $user->phone_number }}">{{ $user->phone_number }}</a>
                                    </div>
                                </div>
                                <div class="p-3">
                                    <div class="card-title">
                                        Driver License
                                    </div>
                                    <div class="card-text">
                                        {{ $user->driver_license }}
                                    </div>
                                </div>
                                <div class="p-3">
                                    <div class="card-title">
                                        Roles
                                    </div>
                                    <div class="card-text">
                                        @foreach($user->roles as $role)
                                            <span class="badge badge-danger">{{ $role->name }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
