<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\StoreProductRequest;
use App\Http\Requests\Admin\Product\UpdateProductRequest;
use App\Imports\ProductFileImport;
use App\Models\Product;
use App\Repositories\Product\ProductInterface;
use App\Service\ValidatorService;

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    //

    protected ProductInterface $productRepository;
    protected ValidatorService $validatorService;

    public function __construct(ProductInterface $productRepository, ValidatorService $validatorService)
    {
        $this->productRepository = $productRepository;
        $this->validatorService = $validatorService;
    }

    public function index()
    {
        $products = $this->productRepository->paginate(5);

        return view('admin.products.index', compact('products'))->with('i', (request()->input('page', 1) - 1) * 5);

        // Fetch all products using the product repository


        // Return the products to a view


    }

    public function create()
    {

        return view("admin.products.create");
    }

    public function store(StoreProductRequest $request)
    {
        $validatedData = $request->validated();

        $uploadedFileUrl = Cloudinary::upload($request->file('image')->getRealPath(), [
            'folder' => 'laravel-test'
        ])->getSecurePath();
        $data = array_merge($validatedData, ['image' => $uploadedFileUrl]);

        $this->productRepository->create($data);

        return redirect()->route('product.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {

        return view('admin.products.edit', ['product' => $product]);
    }

    public function update(Product $product, UpdateProductRequest $request)
    {

        $validatedData = $request->validated();
        $uploadedFileUrl = Cloudinary::upload($request->file('image')->getRealPath(), [
            'folder' => 'laravel-test'
        ])->getSecurePath();
        $data = array_merge($validatedData, ['image' => $uploadedFileUrl]);



        $this->productRepository->update($product, $data);

        return redirect(route('product.index'))->with('success', 'Product Updated Successfully');
    }

    public function destroy(Product $product)
    {

        $this->productRepository->delete($product);
        return redirect(route('product.index'))->with('success', 'Product deleted Successfully');
    }
    public function file(){

        return view("admin.products.file");
    }
    public function importFile(Request $request){

        Excel::import(new ProductFileImport(), $request->file('file'));
        $products = $this->productRepository->paginate(5);

        return view('admin.products.index', compact('products'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

}
