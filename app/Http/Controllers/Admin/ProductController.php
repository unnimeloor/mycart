<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\DatabaseManager;

use App\Http\Repositories\ProductRepository;

class ProductController extends Controller
{
    protected $productRepository;
    protected $db;

    public function __construct(
        ProductRepository $productRepository,
        DatabaseManager $db
    ) {
        $this->productRepository = $productRepository;
        $this->db = $db;
    }

    public function list()
    {
        $products = $this->productRepository->getProductList();
        
        return view('admin.product.list', [
            'products' => $products,
        ]);
    }

    public function create()
    {
        $brands = $this->productRepository->getBrands();
        $processorTypes = $this->productRepository->getProcessorType();

        return view('admin.product.form', [
            'action' => 'create',
            'processorTypes' => $processorTypes,
            'brands' => $brands,
        ]);
    }

    public function save(Request $request)
    {

        $request->validate([
            'name' => 'required|max:200',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'price' => 'required|numeric',
            'id_brand' => 'required',
            'id_processor_type' => 'required',
            'screen_size' => 'required|numeric',
        ], [
            'name.required' => 'Enter Product Name',
            'image.required' => 'Select a Product Image',
            'id_brand.required' => 'Select a Product Brand',
            'id_processor_type.required' => 'Select a Processor Type',
        ]);

        $data = [
            'name' => $request->post('name'),
            'price' => $request->post('price'),
            'id_brand' => $request->post('id_brand'),
            'id_processor_type' => $request->post('id_brand'),
            'id_processor_type' => $request->post('id_brand'),
            'screen_size' => $request->post('screen_size'),
            'is_touch_screen' => $request->post('is_touch_screen') ? 1 : 0,
            'out_of_stock' => $request->post('out_of_stock') ? 1 : 0,
        ];

        $this->db->beginTransaction();

        try {
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $fileName = time() . '.' . $image->getClientOriginalExtension();
                $uploadPath = public_path('/product_images');
                $image->move($uploadPath, $fileName);
                $data['image'] = $fileName;
            }

            $this->productRepository->createProduct($data);

            $this->db->commit();
        } catch (\Exception $e) {
            $this->db->rollback();

            return \Redirect::back()->withErrors(['Something went wrong!']);
        }

        return redirect('admin/product');
    }

    public function edit($idProduct)
    {
        $product = $this->productRepository->findProduct($idProduct);
        $brands = $this->productRepository->getBrands();
        $processorTypes = $this->productRepository->getProcessorType();

        return view('admin.product.form', [
            'action' => 'edit',
            'product' => $product,
            'brands' => $brands,
            'processorTypes' => $processorTypes,
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|max:200',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'price' => 'required|numeric',
            'id_brand' => 'required',
            'id_processor_type' => 'required',
            'screen_size' => 'required|numeric',
        ], [
            'name.required' => 'Enter Product Name',
            'id_brand.required' => 'Select a Product Brand',
            'id_processor_type.required' => 'Select a Processor Type',
        ]);

        $data = [
            'name' => $request->post('name'),
            'price' => $request->post('price'),
            'id_brand' => $request->post('id_brand'),
            'id_processor_type' => $request->post('id_brand'),
            'id_processor_type' => $request->post('id_brand'),
            'screen_size' => $request->post('screen_size'),
            'is_touch_screen' => $request->post('is_touch_screen') ? 1 : 0,
            'out_of_stock' => $request->post('out_of_stock') ? 1 : 0,
        ];

        $this->db->beginTransaction();

        try {
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $fileName = time() . '.' . $image->getClientOriginalExtension();
                $uploadPath = public_path('/product_images');
                $image->move($uploadPath, $fileName);
                $data['image'] = $fileName;
            }

            $this->productRepository->updateProduct($request->post('id_product'), $data);

            $this->db->commit();
        } catch (\Exception $e) {
            $this->db->rollback();

            return \Redirect::back()->withErrors(['Something went wrong!']);
        }

        return redirect('admin/product');
    }

    public function delete($idProduct)
    {
        $this->db->beginTransaction();

        try {
            $this->productRepository->deleteProduct($idProduct);
            $this->db->commit();

            return redirect('admin/product');
        } catch (\Exception $e) {
            $this->db->rollback();

            return \Redirect::back()->withErrors(['Something went wrong!']);
        }
    }
}
