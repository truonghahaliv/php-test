<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Repositories\Product\ProductInterface;
use App\Service\ValidatorService;
use Illuminate\Http\Request;

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
        // Fetch all products using the product repository
        $products = $this->productRepository->paginate(5);

        // Return the products to a view
        return view('products.index', compact('products'))->with('i', (request()->input('page', 1) - 1) * 5);

    }

    public function create()
    {
        return view("products.create");
    }

    public function store(Request $request)
    {
        $validatedData = $this->validatorService->validateProductData($request);
        $imagePath = $this->validatorService->uploadImage($request);

        if ($imagePath) {
            $validatedData['image'] = $imagePath;
        }

        $this->productRepository->create($validatedData);

        return redirect()->route('product.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {

        return view('products.edit', ['product' => $product]);
    }

    public function update(Product $product, Request $request)
    {
        $validatedData = $this->validatorService->validateProductUpdateData($request);
        $imagePath = $this->validatorService->uploadImage($request);

        if ($imagePath) {
            $validatedData['image'] = $imagePath;
        }

        $this->productRepository->update($product, $validatedData);

        return redirect(route('product.index'))->with('success', 'Product Updated Successfully');
    }

    public function destroy(Product $product)
    {
        $this->productRepository->delete($product);
        return redirect(route('product.index'))->with('success', 'Product deleted Successfully');
    }

}
