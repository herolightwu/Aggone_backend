@extends("layouts.admin")

@section('template_title')
    Edit - {{ $city->city_name }}
@endsection

@section('content')
    <div class="container pt-5 pb-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                Edit - {{ $city->city_name }}
                            </h3>
                        </div>
                        <div class="kt-portlet__head-toolbar">
                            <div class="kt-portlet__head-actions">
                                <a href="{{ route('cities.index') }}" class="btn btn-clean btn-sm btn-icon btn-icon-md">
                                    <i class="fa fa-reply-all"></i>
                                </a>
                                <a href="{{ route('cities.show', ['city' => $city->id]) }}" class="btn btn-clean btn-sm btn-icon btn-icon-md">
                                    <i class="flaticon-reply"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <form class="kt-form kt-form--label-right" action="{{ route('cities.update', ['city' => $city]) }}" method="post" id="cityForm">
                        @csrf
                        @method('put')
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-2 col-form-label" for="city_name">
                                    City Name
                                </label>
                                <div class="col-10">
                                    <input type="text" class="form-control {{ $errors->has('city_name') ? 'is-invalid' : '' }}"
                                           name="city_name" id="city_name"
                                           value="{{ $city->city_name }}"
                                           required
                                           autofocus>
                                    @if ($errors->has('city_name'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('city_name') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-2 col-form-label" for="country">
                                    Country
                                </label>
                                <div class="col-10">
                                    <select class="form-control" name="country" id="country">
                                        <option value="">Select Country</option>
                                        @if ($countries)
                                            @foreach($countries as $country)
                                                <option value="{{ $country->country_code }}" @if($currentCountry) {{ $currentCountry->id == $country->id ? 'selected="selected"' : '' }} @endif>{{ $country->country_name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->has('country'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('country') }}
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

@section('template_modals')
    <div id="overlay">
        <div class="cv-spinner">
            <span class="spinner"></span>
        </div>
    </div>
@endsection

@section('template_scripts')
    @if (session('success'))
        <script type="text/javascript">
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
            $(document).ready(function () {
                toastr.success('{{ session('success') }}');
            })
        </script>
    @endif
        <script type="text/javascript" src='https://maps.googleapis.com/maps/api/js?key={{ config("settings.googleMapsAPIKey") }}&libraries=places&dummy=.js'></script>
        <script type="text/javascript">
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

            var autocomplete;

            function initialize(country) {
                var options = {
                    types: ['(cities)'],
                    componentRestrictions: {country: country}
                };

                var input = document.getElementById('city_name');
                autocomplete = new google.maps.places.Autocomplete(input, options);

                // autocomplete.addListener('place_changed', fillInAddress);
            }

            // function fillInAddress() {
            //     // Get the place details from the autocomplete object.
            //     var place = autocomplete.getPlace();
            //
            //     // Get each component of the address from the place details,
            //     // and then fill-in the corresponding field on the form.
            //     for (var i = 0; i < place.address_components.length; i++) {
            //         var addressType = place.address_components[i].types[0];
            //         console.log(addressType);
            //     }
            //     console.log(place.address_components);
            // }

            $(document).ready(function () {
                if(!$('#country').val()) {
                    $('#city_name').prop('disabled', true);
                } else {
                    initialize($('#country').val());
                }
            });

            $('#country').on('change', function () {
                if($('#country').val()) {
                    $('#city_name').prop('disabled', false);
                    $('#city_name').val('');
                    var country = $(this).val();
                    initialize(country);
                }
            });

            $('#cityForm').submit(function (e) {
                e.preventDefault();

                var geocoder = new google.maps.Geocoder();
                var address = $('input[name="city_name"]').val();
                var latitude = 0.0;
                var longitude = 0.0;
                var form = $(this);
                var url = form.attr('action');

                geocoder.geocode({'address': address}, function(results, status) {

                    if (status == google.maps.GeocoderStatus.OK) {
                        latitude = results[0].geometry.location.lat();
                        longitude = results[0].geometry.location.lng();

                        $.ajax({
                            type: 'POST',
                            url: url,
                            data: {
                                _token: '{{ csrf_token() }}',
                                _method: 'PUT',
                                city_name: address,
                                // zip_code: $('input[name="zip_code"]').val(),
                                country: $('select[name="country"]').val(),
                                latitude: latitude,
                                longitude: longitude,
                            },
                            beforeSend: function() {
                                $("#overlay").fadeIn(300);
                            },
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
                            complete: function () {
                                setTimeout(function(){
                                    $("#overlay").fadeOut(300);
                                },500);
                            }
                        });
                    }
                });
            })

            // google.maps.event.addDomListener(window, 'load', initialize);
        </script>
@endsection
