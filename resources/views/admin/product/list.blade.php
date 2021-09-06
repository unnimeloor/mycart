@extends('adminlte::page')
@section('title', 'Products')
@section('content_header')
<h1>Products</h1>
@stop
@section('content')
<div class="container">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Available Products</h3>

                <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <div class="input-group-append">
                            <a href="{{ route('admin.product-create') }}" class="btn btn-primary">Add Products</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Brand</th>
                            <th>Processor Type</th>
                            <th>Screen Size</th>
                            <th>Touch Screen</th>
                            <th>Availability</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($products->isNotEmpty())
                        @foreach ($products as $product)
                        <tr>
                            <td><img src="{{ $product->image == '' ? asset('no_image.jpg') : asset('/product_images/' . $product->image) }}" width="100px"></td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->price }}</td>
                            <td>{{ $product->brand_name }}</td>
                            <td>{{ $product->processor_type }}</td>
                            <td>{{ $product->screen_size }}</td>
                            <td>{{ $product->is_touch_screen ? 'Yes' : 'No' }}</td>
                            <td>{{ $product->out_of_stock ? 'Available' : 'Out of stock' }}</td>
                            <td>
                                <a href="{{ route('admin.product-edit', ['id' => $product->id_product]) }}" title="Edit"><i class="far fa-edit"></i></a>
                                <a href="{{ route('admin.product-delete', ['id' => $product->id_product]) }}" title="Delete" onclick="return confirm('Are you sure you want to delete this item?');"><i class="far fa-trash-alt"></i></a>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="8">No Products found</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {!! $products->links() !!}
            </div>
        </div>
    </div>
</div>
@endsection