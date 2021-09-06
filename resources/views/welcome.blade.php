<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MyCart</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet" type="text/css" />
</head>

<body class="antialiased">
    <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
        <nav data-depth="2" class="breadcrumb hidden-sm-down">
            <div class="container">
                <h1>Categories/Laptops</h1>
                <ol itemscope="">
                    <li itemprop="itemListElement" itemscope="">
                        @if (Route::has('login'))
                        @auth
                        <a href="{{ route('admin.product-list') }}" class="btn btn-primary">Manage Products</a>
                        @else
                        <a href="{{ route('login') }}" class="btn btn-primary">Log in</a>
                        @endauth
                        @endif
                        <a href="{{ route('home') }}" class="btn btn-danger">Reset Search</a>
                     </li>
                </ol>
            </div>
        </nav>

        <section class="content_section">
            <div class="container">
                <div class="flowerlist">
                    <div class="row">
                        <aside class="col-lg-3 col-md-4 col-sm-12 col-12">
                            <form action="{{ route('product.search') }}" method="get" id="search-form">
                                <div class="listingfilter_wrappers">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                            <input type="text" class="form-control" value="{{ $filters['product_name'] ?? '' }}" placeholder="Search ..." name="product_name" style="margin-bottom: 14px;">
                                        </div>
                                    </div>
                                </div>
                                <article class="filter_wrapper">
                                    <div class="title_card">
                                        <h3>Price</h3>
                                        <a href="#">Reset</a>
                                        <div class="clearfix"></div>
                                    </div>
                                </article>
                                <article class="range row">
                                    <div class="col-lg-5">
                                        <select name="price_from" class="common-input">
                                            @foreach ($priceList['minimum'] as $key => $value)
                                            <option value="{{ $key }}" {{ isset($filters['price_from']) && $key == $filters['price_from'] ? 'selected' : '' }}>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-2"><span>to</span></div>
                                    <div class="col-lg-5">
                                        <select name="price_to" class="common-input">
                                            @foreach ($priceList['maximum'] as $key => $value)
                                            <option value="{{ $key }}" {{ isset($filters['price_to']) && $key == $filters['price_to'] ? 'selected' : '' }}>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </article>
                                <article class="price_wrapper">
                                    <div class="title_card">
                                        <h3>Brand</h3>
                                    </div>
                                    @foreach ($brands as $brand)
                                    <div class="custom-control  my-1 mr-sm-2">
                                        <input type="checkbox" name="brand[]" class="common-input" value="{{ $brand->id_brand }}" {{ isset($filters['brand']) && in_array($brand->id_brand, $filters['brand']) ? 'checked' : '' }}>
                                        <label class="">{{ $brand->brand_name }}</label>
                                    </div>
                                    @endforeach
                                </article>
                                <article class="price_wrapper">
                                    <div class="title_card">
                                        <h3>Processor Type</h3>
                                    </div>
                                    @foreach ($processorTypes as $processorType)
                                    <div class="custom-control  my-1 mr-sm-2">
                                        <input type="checkbox" name="processor_type[]" class="common-input" value="{{ $processorType->id_processor_type }}" {{ isset($filters['processor_type']) && in_array($brand->id_processor_type, $filters['processor_type']) ? 'checked' : '' }}>
                                        <label class="">{{ $processorType->processor_type }}</label>
                                    </div>
                                    @endforeach
                                </article>
                                <article class="price_wrapper">
                                    <div class="title_card">
                                        <h3>Screen Size</h3>
                                    </div>
                                    @foreach ($screenSizes as $key => $value)
                                    <div class="custom-control  my-1 mr-sm-2">
                                        <input type="checkbox" name="screen_size[]" class="common-input" value="{{ $key }}" {{ isset($filters['screen_size']) && in_array($key, $filters['screen_size']) ? 'checked' : '' }}>
                                        <label class="">{{ $value[0] }} inch - {{ $value[1] }} inch</label>
                                    </div>
                                    @endforeach
                                    <div class="custom-control  my-1 mr-sm-2">
                                        <input type="checkbox" name="screen_size[]" class="common-input" value="0" {{ isset($filters['screen_size']) && in_array(0, $filters['screen_size']) ? 'checked' : '' }}>
                                        <label class="">Below 12 Inch</label>
                                    </div>
                                    </select>
                                </article>
                                <article class="price_wrapper">
                                    <div class="title_card">
                                        <h3>Touch Screen</h3>
                                    </div>
                                    <div class="custom-control  my-1 mr-sm-2">
                                        <input type="radio" name="is_touch_screen" class="common-input" value="0" {{ isset($filters['is_touch_screen']) && $filters['is_touch_screen'] == 0 ? 'checked' : '' }}>
                                        <label>No</label>
                                    </div>
                                    <div class="custom-control  my-1 mr-sm-2">
                                        <input type="radio" name="is_touch_screen" class="common-input" value="1" {{ isset($filters['is_touch_screen']) && $filters['is_touch_screen'] == 1 ? 'checked' : '' }}>
                                        <label>Yes</label>
                                    </div>
                                </article>
                                <article class="price_wrapper">
                                    <div class="title_card">
                                        <h3>Availability</h3>
                                    </div>
                                    <div class="custom-control  my-1 mr-sm-2">
                                        <input type="checkbox" class="common-input" name="out_of_stock" value="1" {{ isset($filters['out_of_stock']) && $filters['out_of_stock'] == 1 ? 'checked' : '' }}>
                                        <label>Include out of stock</label>
                                    </div>
                                </article>
                            </form>
                        </aside>

                        <div class="col-lg-9 col-md-8 col-sm-12 col-12">
                            @if ($products->isNotEmpty())
                            @foreach ($products as $product)
                            <section class="list_view">
                                <div class="row">
                                    <div class="col-lg-3 col-md-3 col-sm-6 col-12">
                                        <article>
                                            <a href="#" class="image-box"><img src="{{ $product->image == '' ? asset('no_image.jpg') : asset('/product_images/' . $product->image) }}"></a>
                                        </article>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                        <h4>{{ $product->name }}</h4>
                                        <ul class="_1xgFaf">
                                            <li class="rgWa7D">Brand: {{ $product->brand_name }}</li>
                                            <li class="rgWa7D">Procesor: {{ $product->processor_type }}</li>
                                            <li class="rgWa7D">Screen Size: {{ $product->screen_size }}</li>
                                            <li class="rgWa7D">Touch Screen: {{ $product->is_touch_screen ? 'Yes' : 'No' }}</li>
                                            <li class="rgWa7D">{{ $product->out_of_stock ? 'Available' : 'Out of stock' }}</li>
                                        </ul>
                                        <h3>Rs: {{ $product->price }}</h3>
                                    </div>
                                </div>
                            </section>
                            @endforeach
                            @else
                            No Products found
                            @endif

                            {!! $products->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script>
        $('.common-input').change(function() {
            $('#search-form').submit();
        })
    </script>
</body>

</html>