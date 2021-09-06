<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Repositories\ProductRepository;

use App\Models\Product;

class ProductController extends Controller
{
    protected $productRepository;

    public function __construct(
        ProductRepository $productRepository,
        Product $product
    ) {
        $this->productRepository = $productRepository;
        $this->product = $product;
    }

    public function productList(Request $request)
    {
        $searchItems = $request->except('page');
        $productData = $this->productRepository->getAllProducts($searchItems);

        $brands = $this->productRepository->getBrands();
        $processorTypes = $this->productRepository->getProcessorType();

        return view('welcome', [
            'products' => $productData['result'],
            'brands' => $brands,
            'processorTypes' => $processorTypes,
            'screenSizes' => Product::getScreenSize(),
            'priceList' => Product::getPriceList(),
            'filters' => $productData['filters'],
        ]);
    }
}
