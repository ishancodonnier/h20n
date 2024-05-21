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
                        <form id="product_edit_form" method="POST"
                            action="{{ route('product.update', ['id' => $product->product_id]) }}"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="product_name">Product Name</label>
                                            <input type="text"
                                                class="form-control @error('product_name') is-invalid @enderror"
                                                name="product_name" id="product_name" value="{{ $product->product_name }}"
                                                placeholder="Enter Product Name">
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
                                                name="product_price" id="product_price"
                                                value="{{ $product->product_price }}" placeholder="Enter Product Price">
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
                                            <select
                                                class="form-control select2bs4 @error('product_category_id') is-invalid @enderror"
                                                name="product_category_id" id="product_category_id">
                                                <option value="">Please Select Category</option>
                                                @foreach ($categories as $cat)
                                                    <option @if ($cat->product_category_id == $product->product_category_id) selected @endif value="{{ $cat->product_category_id }}">
                                                        {{ $cat->product_category_name }}</option>
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
                                                id="description" placeholder="Enter Product Description">{{ nl2br($product->product_description) }}</textarea>
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
                                                                class="btn btn-success btn-block">
                                                                <i class="fa fa-plus"></i>
                                                                Add
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="image_container">

                                                    @if (count($product->images) > 0)
                                                        @foreach ($product->images as $key => $image)

                                                        <div class="row image_row {{ $loop->first ? '' : 'mt-3' }}">
                                                            <input type="hidden" name="image_id[]" value="{{ $image->product_resource_id }}" />
                                                            <div class="col-md-10">
                                                                <input type="text" readonly class="form-control"
                                                                    name="product_image[]" value="{{ $image->product_resource_name }}"
                                                                    id="product_image_1">
                                                            </div>
                                                            <div class="col-md-2">
                                                                <button type="button" class="btn btn-danger btn-block remove_saved_image"
                                                                    data-product_image_id="{{ $image->product_resource_id }}">
                                                                    <i class="fa fa-times"></i> Remove
                                                                </button>
                                                            </div>
                                                        </div>

                                                        @endforeach
                                                    @else
                                                        <div class="row image_row">
                                                            <input type="hidden" name="image_id[]" value="0" />
                                                            <div class="col-md-10">
                                                                <div class="custom-file">
                                                                    <input type="file" accept="image/*"
                                                                        class="custom-file-input" name="product_image[]"
                                                                        id="product_image_1">
                                                                    <label class="custom-file-label" for="garden_image_1">Choose
                                                                        Image</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row" style="gap: 20px;">
                                    @foreach ($product->images as $product_image)
                                        @if ($product_image->product_resource_type == 'IMAGE')
                                            <div style="display: grid;">
                                                <img width="200px" height="200px"
                                                    src="{{ env('SERVER_IMAGE_URL') . 'product_images/' . $product_image->product_resource_name }}">
                                                <span>{{ $product_image->product_resource_name }}</span>
                                            </div>
                                        @else
                                            <div style="display: grid;">
                                                <video width="200px" height="200px"
                                                    src="{{ env('SERVER_IMAGE_URL') . 'product_images/' . $product_image->product_resource_name }}">
                                                <span>{{ $product_image->product_resource_name }}</span>
                                            </div>
                                        @endif
                                    @endforeach
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
    <script src="{{ asset('asset/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>

    <script src="{{ asset('asset/dist/js/ckeditor4/ckeditor.js') }}"></script>
    <script src="{{ asset('asset/dist/js/ckeditor4/samples/js/index.js') }}"></script>

    <script>
        initSample();
    </script>

    <script>

        const base_url = "{{ url('/') }}";

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

            $('#product_edit_form').validate({
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
                            <input type="hidden" name="image_id[]" value="0"/>
                            <div class="col-md-10">
                                <div class="custom-file">
                                    <input type="file" accept="image/*" class="custom-file-input" name="product_image[]" id="product_image_` + rowCount + `">
                                    <label class="custom-file-label" for="product_image_` + rowCount + `">
                                        Choose Image
                                    </label>
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

        $('.remove_saved_image').on('click', function() {
            var product_resource_id = $(this).data('product_resource_id');
            var product_id = "{{ $product->product_id }}";
            Swal.fire({
                title: 'Are you sure?',
                text: "Are you sure you wanted to delete this image permanently?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: base_url + "/product/delete-image-resource/" + product_id + "/" + product_resource_id,
                        type: "POST",
                        headers: {
                            "X-CSRF-TOKEN": $("meta[name=csrf-token]").attr("content"),
                        },
                        cache: false,
                        contentType: false,
                        processData: false,
                        async: true,
                        success: function(response) {
                            if (response.status) {
                                Swal.fire(
                                    'Deleted!',
                                    'Your image has been deleted successfully.',
                                    'success'
                                ).then((result) => {
                                    if (result.isConfirmed) {
                                        location.reload();
                                    }
                                });
                            } else {
                                toastr.options.progressBar = true;
                                toastr.error(response.msg);
                            }
                        },
                        error: function(err) {
                            toastr.options.progressBar = true;
                            toastr.error(err.responseJSON.message);
                        },
                    });
                }
            });
        });
    </script>
@endsection
