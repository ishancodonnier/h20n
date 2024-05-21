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
                        <form id="product_create_form" method="POST" action="{{ route('product.store') }}"
                            enctype="multipart/form-data">@csrf

                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="product_name">Product Name</label>
                                            <input type="text"
                                                class="form-control @error('product_name') is-invalid @enderror"
                                                name="product_name" id="product_name" placeholder="Enter Product Name">
                                            @error('product_name')
                                                <span class="error invalid-feedback"
                                                    style="display: block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="product_price">Product Price</label>
                                            <input type="text"
                                                class="form-control @error('product_price') is-invalid @enderror"
                                                name="product_price" id="product_price" placeholder="Enter Product Price">
                                            @error('product_price')
                                                <span class="error invalid-feedback"
                                                    style="display: block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="product_category_id">Category</label>
                                            <select class="form-control select2bs4 @error('product_category_id') is-invalid @enderror" name="product_category_id" id="product_category_id">
                                                <option value="">Please Select Category</option>
                                                @foreach ($categories as $cat)
                                                    <option value="{{ $cat->product_category_id }}">{{ $cat->product_category_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('product_category_id')
                                                <span class="error invalid-feedback"
                                                    style="display: block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="title">Availabel</label>
                                            <div>
                                                <div class="icheck-primary d-inline mr-3">
                                                    <input type="radio" id="active" name="is_available" value="1"
                                                    @if ($product->is_available == 1) checked @endif>
                                                    <label for="active">
                                                        Yes
                                                    </label>
                                                </div>
                                                <div class="icheck-danger d-inline">
                                                    <input type="radio" name="is_available" id="inactive" value="0"
                                                    @if ($product->is_available == 0) checked @endif>
                                                    <label for="inactive">
                                                        No
                                                    </label>
                                                </div>
                                            </div>
                                            @error('is_available')
                                                <span class="error invalid-feedback"
                                                    style="display: block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="description">Product Description</label>
                                            <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="5"
                                                id="description" placeholder="Enter Product Description"></textarea>
                                            @error('description')
                                                <span class="error invalid-feedback"
                                                    style="display: block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <label for="images">Images</label>
                                                <div class="float-right">
                                                    <div class="row flex-nowrap" style="gap: 10px;">
                                                        <div class="col-12">
                                                            <button type="button" id="add_new_image"
                                                                class="btn btn-success btn-block"><i
                                                                    class="fa fa-plus"></i>
                                                                Add</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="image_container">

                                                    <div class="row image_row">
                                                        <div class="col-md-10">
                                                            <div class="custom-file">
                                                                <input type="file" accept="image/*" class="custom-file-input" name="product_image[]" id="product_image_1">
                                                                <label class="custom-file-label" for="product_image_1">
                                                                    Choose Image
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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

    <script src="{{ asset('asset/dist/js/ckeditor4/ckeditor.js') }}"></script>
    <script src="{{ asset('asset/dist/js/ckeditor4/samples/js/index.js') }}"></script>

    <script>
        initSample();
    </script>

    <script>
        const rowNumbers = [1];

        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });

        $(function() {

            var validationRules = {
                "product_name": "required",
                "product_price": "required",
                "product_category_id": "required",
                "description": "required",
                "is_available": "required",
            };

            var validation_messages = {
                "product_name": "Please Enter Product Name",
                "product_price": "Please Enter Product Price",
                "product_category_id": "Please Product Category",
                "description": "Please Enter Product Description",
                "is_available": "Please Select Product Availability",
            };

            $('#product_create_form').validate({
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

        $('#add_new_image').on('click', function() {
            var rowCount = $('.image_container .image_row').length + 1;

            var html = `<div class="row image_row mt-3">
                            <div class="col-md-10">
                                <div class="custom-file">
                                    <input type="file" accept="image/*" class="custom-file-input" name="product_image[]"
                                        id="product_image_` + rowCount + `">
                                    <label class="custom-file-label" for="product_image_` + rowCount + `">Choose
                                        Image</label>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <button type="button" class="btn btn-danger btn-block remove_image">
                                    <i class="fa fa-times"></i> Remove
                                </button>
                            </div>
                        </div>`;

            $('.image_container').append(html);

            bsCustomFileInput.init();
        });

        $(document).on('click', '.remove_image', function(event) {
            $(this).closest('.image_row').remove();
        });
    </script>
@endsection
