@extends('adminlte::page')
@section('title', 'Products|Laptops')
@section('content_header')
<h1>{{ $action == 'create' ? 'Add New Product' : 'Update Product' }}</h1>
@stop
@section('content')
<div class="col-md-10">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $action == 'create' ? 'Add New Product' : 'Update Product : ' . $product->name }}</h3>
        </div>
        <form method="POST" action="{{ $action == 'create' ? route('admin.product-save') :  route('admin.product-update') }}" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <div class="form-group">
                    <label for="name">Product Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $product->name ?? '') }}" placeholder="Enter name">
                </div>

                @if ($action == 'edit')
                <input type="hidden" name="id_product" value="{{ $product->id_product }}">
                @if ($product->image != '')
                <img src="{{ asset('/product_images/' . $product->image) }}" width="100px">
                @endif
                @endif

                <div class="form-group">
                    <label for="image">Product Image</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="image" name="image">
                            <label class="custom-file-label" for="image">Choose file</label>
                        </div>
                        <div class="input-group-append">
                            <span class="input-group-text">Upload</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="number" step="any" class="form-control" id="price" name="price" value="{{ old('price', $product->price ?? '') }}" placeholder="Enter Price">
                </div>
                <div class="form-group">
                    <label for="id_brand">Brand</label>
                    <select class="form-control" id="id_brand" name="id_brand">
                        <option value="">Select Brand</option>
                        @if (!empty($brands))
                        @foreach ($brands as $brand)
                        <option value="{{ $brand->id_brand }}" {{ isset($product) && $brand->id_brand == $product->id_brand ? 'selected' : '' }}>{{ $brand->brand_name }}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
                <div class="form-group">
                    <label for="id_processor_type">Processor Type</label>
                    <select class="form-control" id="id_processor_type" name="id_processor_type">
                        <option value="">Select Processor type</option>
                        @if (!empty($processorTypes))
                        @foreach ($processorTypes as $processorType)
                        <option value="{{ $processorType->id_processor_type }}" {{ isset($product) && $processorType->id_processor_type == $product->id_processor_type ? 'selected' : '' }}>{{ $processorType->processor_type }}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
                <div class="form-group">
                    <label for="screen_size">Screen Size</label>
                    <input type="number" step="any" class="form-control" id="screen_size" name="screen_size" value="{{ old('screen_size', $product->screen_size ?? '') }}" placeholder="Enter Screen Size">
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="is_touch_screen" name="is_touch_screen" {{ isset($product) && $product->is_touch_screen == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_touch_screen">Touch Screen</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="out_of_stock" name="out_of_stock" {{ isset($product) && $product->out_of_stock == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="out_of_stock">Out of Stock</label>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route('admin.product-list') }}" class="btn btn-primary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection