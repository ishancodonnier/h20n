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
                        <form id="user_edit_form" method="POST"
                            action="{{ route('user.update', ['id' => $user->user_id]) }}" enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" name="user_latitude" id="user_latitude"
                                value="{{ $user->user_latitude }}">
                            <input type="hidden" name="user_longitude" id="user_longitude"
                                value="{{ $user->user_longitude }}">

                            <div class="card-body">


                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Full Name</label>
                                            <input type="text"
                                                class="form-control @error('full_name') is-invalid @enderror" id="full_name"
                                                name="full_name" placeholder="Enter Full Name"
                                                value="{{ old('full_name') ?? $user->full_name }}">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                id="email" name="email" placeholder="Enter Email"
                                                value="{{ old('email') ?? $user->email }}" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Universities</label>
                                            <select class="form-control select2bs4" name="university_id" id="university_id">
                                                @foreach ($universities as $uni)
                                                    <option @if ($uni->university_id == $user->university_id) selected @endif()
                                                        value="{{ $uni->university_id }}">{{ $uni->university_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>User Location</label>
                                            <input type="text"
                                                class="form-control @error('user_location') is-invalid @enderror"
                                                id="user_location" name="user_location" placeholder="Enter User Location"
                                                value="{{ old('user_location') ?? $user->user_location }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Student ID Image</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="student_id_images"
                                                    id="student_id_images" accept="image/*">
                                                <label class="custom-file-label" for="student_id_images">Choose
                                                    Image</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap gap-2">
                                    @if ($user->student_id_images)
                                        <img src="{{ env('SERVER_IMAGE_URL') . 'student_id_images/' . $user->student_id_images }}"
                                            style="width: 200px; height: 200px; object-fit: contain;">
                                    @endif
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
    <script src="{{ asset('asset/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>

    <script type="text/javascript"
        src="https://maps.google.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&libraries=places"></script>

    <script>
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });

        $(function() {

            bsCustomFileInput.init();


            var validationRules = {
                "full_name": "required",
                "university_id": "required",
                "user_location": "required",
            };

            var validation_messages = {
                "full_name": "Please Enter Full Name",
                "university_id": "Please Select University",
                "user_location": "Please Enter Location",
            };


            $('#user_edit_form').validate({
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
            $('#user_edit_form').submit();
        }

        $('#user_edit_form').on('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
            }
        });
    </script>
    <script>
        // google.maps.event.addDomListener(window, 'load', initialize);
        window.addEventListener('load', initialize);

        function initialize() {
            var input = document.getElementById('user_location');
            var autocomplete = new google.maps.places.Autocomplete(input);

            autocomplete.addListener('place_changed', function() {
                var place = autocomplete.getPlace();
                $('#user_latitude').val(place.geometry['location'].lat());
                $('#user_longitude').val(place.geometry['location'].lng());
            });
        }
    </script>
@endsection
