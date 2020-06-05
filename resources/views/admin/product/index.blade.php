@extends('layouts.backend.app')

@section('title', 'Product')

@push('css')
    <!-- DataTables -->
    <link rel="stylesheet"
        href="{{ asset('assets/backend/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/backend/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
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
                <a href="{{ route('product.create') }}" class="btn btn-primary float-right"> <i
                        class="fas fa-plus"></i> <span>Create New</span></a>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="data_table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>SL.</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Image</th>
                                    <th>Sizes</th>
                                    <th>Colors</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach($products as $item)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->price }}</td>
                                        <td>
                                            <img src="{{ Storage::disk('public')->url('product/'.$item->image) }}" alt="" width="50">
                                        </td>
                                        <td>
                                            @foreach($item->sizes as $size)
                                                <span class="badge badge-success">{{ $size->name }}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach($item->colors as $color)
                                                <span class="badge badge-success">{{ $color->name }}</span>
                                            @endforeach
                                        </td>
                                        <td>{{ $item->created_at->diffForHumans() }}</td>
                                        <td>
                                            <a class="btn btn-info btn-sm"
                                                href="{{ route('product.edit',$item->id) }}"><i
                                                    class="fas fa-edit"></i></a>
                                            <button onclick="deleteForm({{ $item->id }})"
                                                class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                            <form
                                                action="{{ route('product.destroy',$item->id) }}"
                                                method="POST" id="deleteForm-{{ $item->id }}" style="display: none;">
                                                @csrf @method('DELETE')</form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>SL.</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Image</th>
                                    <th>Sizes</th>
                                    <th>Colors</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
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
    <!-- DataTables -->
    <script src="{{ asset('assets/backend/plugins/datatables/jquery.dataTables.min.js') }}">
    </script>
    <script
        src="{{ asset('assets/backend/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}">
    </script>
    <script
        src="{{ asset('assets/backend/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}">
    </script>
    <script
        src="{{ asset('assets/backend/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}">
    </script>
    <script>
        $(function () {
            $("#data_table").DataTable({
                "responsive": true,
                "autoWidth": false,
            });
        });
    </script>
    <script>
        function deleteForm(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    document.getElementById('deleteForm-' + id).submit();

                    Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    )
                } else {
                    Swal.fire(
                        'Good!',
                        'Your Data is save !',
                        'success'
                    )
                }
            })
        }
    </script>
@endpush