@extends('layout.main')
@section('head-css-script')
    <link rel="stylesheet" href="{{ asset('asset/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/plugins/summernote/summernote-bs4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/plugins/toastr/toastr.min.css') }}">
@endsection
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                @include('flash')
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">{{ $pagetitle }}</h3>
                        </div>
                        <form id="warehouse_create_form" method="POST" action="{{ route('warehouse.update', ['id' => $warehouse->warehouse_id]) }}"
                            enctype="multipart/form-data">@csrf

                            <input type="hidden" name="warehouse_lat" id="warehouse_lat" value="{{ $warehouse->warehouse_lat }}">
                            <input type="hidden" name="warehouse_lon" id="warehouse_lon" value="{{ $warehouse->warehouse_lon }}">

                            <div class="card-body">

                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="warehouse_name">Warehouse Name</label>
                                            <input type="text" class="form-control @error('warehouse_name') is-invalid @enderror" name="warehouse_name" value="{{ $warehouse->warehouse_name }}" id="warehouse_name" placeholder="Enter Warehouse Name">
                                            @error('warehouse_name')
                                                <span class="error invalid-feedback" style="display: block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="warehouse_address_line1">Warehouse Address Line 1</label>
                                            <input type="text"
                                                class="form-control @error('warehouse_address_line1') is-invalid @enderror"
                                                name="warehouse_address_line1" value="{{ $warehouse->warehouse_address_line1 }}" id="warehouse_address_line1" placeholder="Enter Warehouse Address Line 1">
                                            @error('warehouse_address_line1')
                                                <span class="error invalid-feedback"
                                                    style="display: block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="warehouse_address_line2">Warehouse Address Line 2</label>
                                            <input type="text"
                                                class="form-control @error('warehouse_address_line2') is-invalid @enderror"
                                                name="warehouse_address_line2" value="{{ $warehouse->warehouse_address_line2 }}" id="warehouse_address_line2" placeholder="Enter Warehouse Address Line 2">
                                            @error('warehouse_address_line2')
                                                <span class="error invalid-feedback"
                                                    style="display: block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="warehouse_area">Warehouse Area</label>
                                            <input type="text"
                                                class="form-control @error('warehouse_area') is-invalid @enderror"
                                                name="warehouse_area" value="{{ $warehouse->warehouse_area }}" id="warehouse_area" placeholder="Enter Warehouse Area">
                                            @error('warehouse_area')
                                                <span class="error invalid-feedback"
                                                    style="display: block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="warehouse_zip_code">Warehouse Zipcode</label>
                                            <input type="text"
                                                class="form-control @error('warehouse_zip_code') is-invalid @enderror"
                                                name="warehouse_zip_code" value="{{ $warehouse->warehouse_zip_code }}" id="warehouse_zip_code" placeholder="Enter Warehouse Zipcode">
                                            @error('warehouse_zip_code')
                                                <span class="error invalid-feedback"
                                                    style="display: block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('footer-script')
    <script src="{{ asset('asset/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('asset/plugins/jquery-validation/additional-methods.min.js') }}"></script>

    <script src="{{ asset('asset/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>

    <script src="{{ asset('asset/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('asset/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('asset/plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('asset/plugins/summernote/summernote-bs4.min.js') }}"></script>

    <script type="text/javascript"
    src="https://maps.google.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&libraries=places"></script>

    <script>
        window.addEventListener('load', initialize);

        function initialize() {
            var input = document.getElementById('warehouse_address_line1');
            var autocomplete = new google.maps.places.Autocomplete(input);

            autocomplete.addListener('place_changed', function() {
                var place = autocomplete.getPlace();
                $('#warehouse_lat').val(place.geometry['location'].lat());
                $('#warehouse_lon').val(place.geometry['location'].lng());

                var area = '';
                var postalCode = '';

                for (var i = 0; i < place.address_components.length; i++) {
                    var component = place.address_components[i];
                    for (var j = 0; j < component.types.length; j++) {
                        if (component.types[j] == 'sublocality_level_1' || component.types[j] == 'locality') {
                            area = component.long_name;
                        }
                        if (component.types[j] == 'postal_code') {
                            postalCode = component.long_name;
                        }
                    }
                }

                $('#warehouse_area').val(area);
                $('#warehouse_zip_code').val(postalCode);
            });
        }

        $(function() {
            var validationRules = {
                "warehouse_name" : "required",
                "warehouse_area": "required",
                "warehouse_zip_code": "required",
                "warehouse_address_line1": "required",
            };

            var validation_messages = {
                "warehouse_name" : "Please Enter Warehouse Name",
                "warehouse_area": "Please Enter Warehouse Area",
                "warehouse_zip_code": "Please Enter Warehouse Zip Code",
                "warehouse_address_line1": "Please Enter Warehouse Address Line 1",
            };

            $('#warehouse_create_form').validate({
                rules: validationRules,
                messages: validation_messages,
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
@endsection
