@extends("layouts.admin")

@section('template_title')
    Edit - {{ $country->country_name }}
@endsection

@section('content')
    <div class="container pt-5 pb-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                Edit - {{ $country->country_name }}
                            </h3>
                        </div>
                        <div class="kt-portlet__head-toolbar">
                            <a href="{{ route('countries.index') }}" class="btn btn-clean btn-sm btn-icon btn-icon-md">
                                <i class="fa fa-reply-all"></i>
                            </a>
                        </div>
                    </div>
                    <form class="kt-form kt-form--label-right" action="{{ route('countries.update', ['country' => $country->id]) }}" method="post">
                        @csrf
                        @method('put')
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-2 col-form-label" for="country_name">
                                    Country Name
                                </label>
                                <div class="col-10">
                                    <input type="text" class="form-control {{ $errors->has('country_name') ? 'is-invalid' : '' }}"
                                           name="country_name" id="country_name"
                                           value="{{ $country->country_name }}"
                                           required
                                           autofocus>
                                    @if ($errors->has('country_name'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('country_name') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-2 col-form-label" for="country_code">
                                    Country Code
                                </label>
                                <div class="col-10">
                                    <input type="text"
                                           value="{{ $country->country_code }}"
                                           class="form-control {{ $errors->has('country_code') ? 'is-invalid' : '' }}" name="country_code" id="country_code" required>
                                    @if ($errors->has('country_code'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('country_code') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-2 col-form-label" for="iso_code">
                                    ISO Code
                                </label>
                                <div class="col-10">
                                    <input type="text"
                                           value="{{ $country->iso_code }}"
                                           class="form-control {{ $errors->has('iso_code') ? 'is-invalid' : '' }}" name="iso_code" id="iso_code" required>
                                    @if ($errors->has('iso_code'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('iso_code') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="kt-form__actions">
                                <div class="row">
                                    <div class="col-2">

                                    </div>
                                    <div class="col-10">
                                        <button type="submit" class="btn btn-primary">
                                            Submit
                                        </button>
                                        <button type="reset" class="btn btn-secondary">
                                            Cancel
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
