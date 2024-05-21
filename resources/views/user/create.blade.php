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
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">{{ $pagetitle }}</h3>
                        </div>
                        <form id="order_create_form" method="POST" action="{{ route('order.store') }}"
                            enctype="multipart/form-data">@csrf

                            <input type="hidden" name="order_lat" id="order_lat">
                            <input type="hidden" name="order_long" id="order_long">
                            <input type="hidden" name="order_timezone" id="order_timezone">


                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="order_id">Order Number</label>
                                            <input type="text" name="order_id"
                                                class="form-control @error('order_id') is-invalid @enderror" id="order_id"
                                                placeholder="Enter Order Number" value="{{ old('order_id') }}">
                                            @error('order_id')
                                                <span class="error invalid-feedback"
                                                    style="display: block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="order_date">Order Date</label>
                                            <input type="datetime-local" name="order_date"
                                                class="form-control @error('order_date') is-invalid @enderror"
                                                id="order_date" placeholder="Enter Order Date"
                                                value="{{ old('order_date') ?? date('Y-m-d') }}">
                                            @error('order_date')
                                                <span class="error invalid-feedback"
                                                    style="display: block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="order_lat">Latitude</label>
                                            <input type="text" readonly name="order_lat" class="form-control"
                                                id="order_lat" placeholder="Enter Order Latitude"
                                                value="{{ old('order_lat') }}">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="order_long">Longitude</label>
                                            <input type="text" readonly name="order_long" class="form-control"
                                                id="order_long" placeholder="Enter Order Longitude"
                                                value="{{ old('order_long') }}">

                                        </div>
                                    </div>
                                </div> --}}


                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Channel</label>
                                            <select class="form-control select2bs4" name="order_channel" id="order_channel">
                                                <option value="">Please Select Channel</option>
                                                <option value="DELIVERY_COM">Delivery.com</option>
                                                <option value="POPLIN">Poplin</option>
                                                <option value="WALK_IN">Walk In</option>
                                            </select>
                                            @error('order_channel')
                                                <span class="error invalid-feedback"
                                                    style="display: block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="customer_name">Customer Name</label>
                                            <input type="text"
                                                class="form-control @error('customer_name') is-invalid @enderror"
                                                name="customer_name" id="customer_name" placeholder="Enter Customer Name">
                                            @error('customer_name')
                                                <span class="error invalid-feedback"
                                                    style="display: block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone_number">Phone Number</label>
                                            <input type="text"
                                                class="form-control @error('phone_number') is-invalid @enderror"
                                                name="phone_number" id="phone_number" placeholder="Enter Phone Number">
                                            @error('phone_number')
                                                <span class="error invalid-feedback"
                                                    style="display: block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="order_bag_count">Bag Count</label>
                                            <input type="number" name="order_bag_count"
                                                class="form-control @error('order_bag_count') is-invalid @enderror"
                                                id="order_bag_count" placeholder="Enter Bag Count"
                                                value="{{ old('order_bag_count') }}">
                                            @error('order_bag_count')
                                                <span class="error invalid-feedback"
                                                    style="display: block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>


                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="order_lbs_count">Estimated Weight</label>
                                            <input type="number" name="order_lbs_count"
                                                class="form-control @error('order_lbs_count') is-invalid @enderror"
                                                id="order_lbs_count" placeholder="Enter Weight"
                                                value="{{ old('order_lbs_count') }}">
                                            @error('order_lbs_count')
                                                <span class="error invalid-feedback"
                                                    style="display: block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="order_address">Address</label>
                                            <input type="text" name="order_address"
                                                class="form-control @error('order_address') is-invalid @enderror"
                                                id="order_address" placeholder="Enter Order Address"
                                                value="{{ old('order_address') }}">
                                            @error('order_address')
                                                <span class="error invalid-feedback"
                                                    style="display: block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="order_wash_instruction">Washing Instructions</label>
                                            <textarea rows="4" name="order_wash_instruction"
                                                class="form-control @error('order_wash_instruction') is-invalid @enderror" id="order_wash_instruction"
                                                placeholder="Enter Washing Instructions" value="{{ old('order_wash_instruction') }}"></textarea>

                                            @error('order_wash_instruction')
                                                <span class="error invalid-feedback"
                                                    style="display: block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="order_staff_notes">Staff Notes</label>
                                            <textarea rows="4" name="order_staff_notes"
                                                class="form-control @error('order_staff_notes') is-invalid @enderror" id="order_staff_notes"
                                                placeholder="Enter Staff Notes" value="{{ old('order_staff_notes') }}"></textarea>

                                            @error('order_wash_instruction')
                                                <span class="error invalid-feedback"
                                                    style="display: block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>


                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="order_additional_items">Additional Items/Costs</label>
                                        <input type="text" name="order_additional_items" id="order_additional_items"
                                            class="form-control @error('order_additional_items') is-invalid @enderror"
                                            placeholder="Enter Additional Items/Costs"
                                            value="{{ old('order_additional_items') }}">

                                        @error('order_additional_items')
                                            <span class="error invalid-feedback"
                                                style="display: block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary" onclick="submitForm()">Submit</button>
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
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });

        $(function() {

            var targetTimeZone = Intl.DateTimeFormat().resolvedOptions().timeZone;
            $("#order_timezone").val(targetTimeZone);

            var validationRules = {
                "order_id": "required",
                "order_date": "required",
                "order_channel": "required",
                "customer_name": "required",
                // "phone_number": "required",
                "order_bag_count": "required",
                "order_lbs_count": "required",
                "order_address": "required",
                "order_wash_instruction": "required",
            };

            var validation_messages = {
                "order_id": "Please Enter Order Number",
                "order_date": "Please Select Order Date",
                "order_channel": "Please Select Order Channel",
                "customer_name": "Please Enter Order Name",
                // "phone_number": "Please Enter Phone Number",
                "order_bag_count": "Please Enter Bag Count",
                "order_lbs_count": "Please Enter Estimated Weight",
                "order_address": "Please Enter Address",
                "order_wash_instruction": "Please Enter Order Wash Instruction",
            };


            $('#order_create_form').validate({
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

        function submitForm() {
            $('#order_create_form').submit();
        }

        $('#order_create_form').on('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
            }
        });
    </script>
    <script>
        // google.maps.event.addDomListener(window, 'load', initialize);
        window.addEventListener('load', initialize);

        function initialize() {
            var input = document.getElementById('order_address');
            var autocomplete = new google.maps.places.Autocomplete(input);

            autocomplete.addListener('place_changed', function() {
                var place = autocomplete.getPlace();
                $('#order_lat').val(place.geometry['location'].lat());
                $('#order_long').val(place.geometry['location'].lng());
            });
        }
    </script>
@endsection
