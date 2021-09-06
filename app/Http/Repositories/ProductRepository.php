<?php

namespace App\Http\Repositories;

use App\Models\Brand;
use App\Models\ProcessorType;
use App\Models\Product;

class ProductRepository
{
    protected $brand;
    protected $processorType;
    protected $product;

    public function __construct(
        Brand $brand,
        ProcessorType $processorType,
        Product $product
    ) {
        $this->brand = $brand;
        $this->processorType = $processorType;
        $this->product = $product;
    }

    /**
     * Get Product List
     *
     * @return Product
     */
    public function getProductList()
    {
        return $this->product
            ->leftJoin('brand', 'brand.id_brand', '=', 'product.id_brand')
            ->leftJoin('processor_type', 'processor_type.id_processor_type', '=', 'product.id_processor_type')
            ->select([
                'product.*',
                'brand.brand_name',
                'processor_type.processor_type',
            ])
            ->paginate(50);
    }

    /**
     * Get Brands
     *
     * @return Brand
     */
    public function getBrands()
    {
        return $this->brand->get();
    }

    /**
     * Get Processor Type
     *
     * @return ProcessorType
     */
    public function getProcessorType()
    {
        return $this->processorType->get();
    }

    /**
     * Create Product
     *
     * @param array $data
     * @return Product
     */
    public function createProduct(array $data)
    {
        return $this->product->create($data);
    }

    /**
     * Find Product
     *
     * @param integer $idProduct
     * @return Product
     */
    public function findProduct(int $idProduct)
    {
        return $this->product->find($idProduct);
    }

    /**
     * Update Product
     *
     * @param integer $idProduct
     * @param array $data
     * @return boolean
     */
    public function updateProduct(int $idProduct, array $data)
    {
        return $this->product
            ->where('id_product', $idProduct)
            ->update($data);
    }

    /**
     * Delete Product
     *
     * @param integer $idProduct
     * @return void
     */
    public function deleteProduct(int $idProduct)
    {
        return  $this->product->find($idProduct)->delete();
    }

    /**
     * Get all Products for frontend listing
     *
     * @param array $searchItems
     * @return array
     */
    public function getAllProducts(array $searchItems)
    {
        $queryData = $this->applyFilter($searchItems);
        $result = $queryData['query']->paginate(50);

        foreach ($searchItems as $key => $value) {
            $result = $result->appends([$key => $value]);
        }

        return [
            'result' => $result,
            'filters' => $queryData['filters'],
        ];
    }

    /**
     * Apply query filter
     *
     * @param array $searchItems
     * @return array
     */
    private function applyFilter($searchItems)
    {
        $filters = [];
        $query = $this->product
            ->leftJoin('brand', 'brand.id_brand', '=', 'product.id_brand')
            ->leftJoin('processor_type', 'processor_type.id_processor_type', '=', 'product.id_processor_type')
            ->select([
                'product.*',
                'brand.brand_name',
                'processor_type.processor_type',
            ]);
        $screenSizes = Product::getScreenSize();
        foreach ($searchItems as $key => $value) {
            if (!$value) {
                continue;
            }

            if ($key === 'product_name') {
                $query = $query->where('name', 'like', '%' . $value . '%');
                $filters[$key] = $value;
            } elseif ($key === 'price_from') {
                $query = $query->where('price', '>=', $value);
                $filters[$key] = $value;
            } elseif ($key === 'price_to') {
                $query = $query->where('price', '<=', $value);
                $filters[$key] = $value;
            } elseif (in_array($key, ['brand', 'processor_type'])) {
                $field = 'id_' . $key;
                $query = $query->whereIn('product.' . $field, $value);
                $filters[$key] = $value;
            } elseif ($key === 'screen_size') {
                $searchScreen = $screenSizes[(int) $value] ?? 0;
                if ($value == 0) {
                    $query = $query->where('screen_size', '<=', 12);
                } else {
                    $query = $query->whereBetween('screen_size', [$searchScreen[0], $searchScreen[1]]);
                }
                $filters[$key] = $value;
            } elseif ($key === 'is_touch_screen') {
                $query = $query->where($key, $value);
                $filters[$key] = $value;
            }
        }

        if (!array_key_exists('out_of_stock', $searchItems)) {
            $query = $query->where('out_of_stock', 0);
        } else {
            $filters['out_of_stock'] = 1;
        }

        return [
            'query' => $query,
            'filters' => $filters,
        ];
    }
}
