@extends('layouts.backend.app')

@section('title', 'Product')
<!-- Select2 -->
<link rel="stylesheet"
    href="{{ asset('assets/backend/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet"
    href="{{ asset('assets/backend/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
<!-- summernote -->
<link rel="stylesheet"
    href="{{ asset('assets/backend/plugins/summernote/summernote-bs4.css') }}">
<style>
    .extra-file {
        padding: 15px !important;
        justify-content: center;
        align-items: center;
        display: flex !important;
        height: 100% !important;
    }

    .newImage {
        width: 100px;
        height: 80px;
        margin-left: 75px;
        margin-top: 20px;
    }

</style>
@push('css')

@endpush

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Product</h1>
            </div>
            <div class="col-sm-6">
                <a href="{{ route('product.index') }}" class="btn btn-primary float-right"> <i
                        class="fas fa-plus"></i> <span>All Product</span></a>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="category_id">Category</label>
                                    <select name="category_id" id="category_id" class="form-control">
                                        <option disabled="" selected="">choose category</option>
                                        @foreach($categories as $value)
                                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="brand_id">Brand</label>
                                    <select name="brand_id" id="brand_id" class="form-control">
                                        <option disabled="" selected="">choose brand</option>
                                        @foreach($brands as $value)
                                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="colors">Colors</label>
                                        <select name="colors[]" id="colors" class="select2 form-control"
                                            multiple="multiple" data-placeholder="Select a State" style="width: 100%;">
                                            @foreach($colors as $value)
                                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="sizes">Sizes</label>
                                        <select name="sizes[]" id="sizes" class="select2 form-control"
                                            multiple="multiple" data-placeholder="Select a State" style="width: 100%;">
                                            @foreach($sizes as $value)
                                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name">Product Name</label>
                                        <input type="text" value="{{ old('name') }}" name="name"
                                            id="name" class="form-control" placeholder="Enter product name">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="price">Product Price</label>
                                        <input type="text" name="price" value="{{ old('price') }}"
                                            id="price" class="form-control" placeholder="Enter product price">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="short_description">Product Short Description</label>
                                                <textarea name="short_description" id="short_description" rows="2"
                                                    class="form-control"
                                                    placeholder="Product short description"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="image">Product Image</label>
                                                <input type="file" onchange="imgPrev(this)" name="image" id="image"
                                                    class="form-control extra-file">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <img src="{{ asset('default.png') }}" alt="" id="prev_img"
                                                class="newImage">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <label for="long_description">Product Long Description</label>
                                    <textarea name="long_description" id="long_description" class="textarea"></textarea>
                                </div>
                                <br><br>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="images">Product Sub Images</label>
                                        <input type="file" name="sub_image[]" class="form-control" multiple>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <input type="submit" value="Submit" class="btn btn-secondary btn-block mt-3">
                                </div>
                            </div>
                            
                        </form>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
</section>
@endsection

@push('js')
    <!-- Select2 -->
    <script src="{{ asset('assets/backend/plugins/select2/js/select2.full.min.js') }}">
    </script>
    <!-- Summernote -->
    <script src="{{ asset('assets/backend/plugins/summernote/summernote-bs4.min.js') }}">
    </script>
    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2()
            $('#long_description').summernote({
                height: 250
            });
        })

    </script>
    <script>
        function imgPrev(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#prev_img')
                        .attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

    </script>
@endpush
