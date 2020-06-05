@extends('layouts.backend.app')

@section('title', 'Color')

@push('css')

@endpush

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Color</h1>
            </div>
            <div class="col-sm-6">
                <a href="{{ route('color.index') }}" class="btn btn-primary float-right"> <i
                        class="fas fa-plus"></i> <span>All Color</span></a>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('color.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Color Name</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    placeholder="enter color name" autofocus>
                            </div>
                            <input type="submit" class="btn btn-secondary btn-block">
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

@endpush