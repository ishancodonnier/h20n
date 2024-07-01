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
                        <form id="staff_password_form" method="POST" action="{{ route('staff.update.password', ['id' => $staff->id]) }}"
                            enctype="multipart/form-data">@csrf
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="text" minlength="8" name="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Enter Password" value="{{ old('password') }}">

                                            @error('password')
                                                <span class="error invalid-feedback" style="display: block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="password_confirmation">Confirm Password</label>
                                            <input type="text" minlength="8" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" placeholder="Enter Password Confirmation" value="{{ old('password_confirmation') }}">

                                            @error('password_confirmation')
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
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });

        $(function() {

            var validationRules = {
                "password": "required",
                "password_confirmation": "required",
            };

            var validation_messages = {
                "password": "Please Enter Password"
                "password_confirmation": "Please Enter Password Confirmation",
            };


            $('#staff_password_form').validate({
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
