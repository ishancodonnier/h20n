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
                        <form id="delivery_area_create_form" method="POST" action="{{ route('delivery.area.store') }}"
                            enctype="multipart/form-data">@csrf

                            <div class="card-body">

                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="delivery_area_name">Delivery Area</label>
                                            <input type="text" class="form-control @error('delivery_area_name') is-invalid @enderror" name="delivery_area_name" id="delivery_area_name" placeholder="Enter Delivery Area">

                                            @error('delivery_area_name')
                                                <span class="error invalid-feedback" style="display: block">{{ $message }}</span>
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

    <script>

        $(function() {
            var validationRules = {
                "delivery_area_name": "required",
            };

            var validation_messages = {
                "delivery_area_name": "Please Enter Delivery Area",
            };

            $('#delivery_area_create_form').validate({
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
