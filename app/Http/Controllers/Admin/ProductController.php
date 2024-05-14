<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\File\ImportFileRequest;
use App\Http\Requests\Admin\Product\StoreProductRequest;
use App\Http\Requests\Admin\Product\UpdateProductRequest;
use App\Imports\ProductFileExport;
use App\Jobs\ProductImportDataJob;
use App\Models\Product;
use App\Repositories\Product\ProductInterface;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    //

    protected ProductInterface $productRepository;

    public function __construct(ProductInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function index(): View
    {
        $products = $this->productRepository->paginate(5);

        return view('admin.products.index', compact('products'))->with('i', (request()->input('page', 1) - 1) * 5);

    }

    public function create(): View
    {

        return view('admin.products.create');
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();

        $uploadedFileUrl = Cloudinary::upload($request->file('image')->getRealPath(), [
            'folder' => 'laravel-test',
        ])->getSecurePath();
        $data = array_merge($validatedData, ['image' => $uploadedFileUrl]);

        $this->productRepository->create($data);

        return redirect()->route('product.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product): View
    {

        return view('admin.products.edit', ['product' => $product]);
    }

    public function update(Product $product, UpdateProductRequest $request): RedirectResponse
    {

        $validatedData = $request->validated();
        $uploadedFileUrl = Cloudinary::upload($request->file('image')->getRealPath(), [
            'folder' => 'laravel-test',
        ])->getSecurePath();
        $data = array_merge($validatedData, ['image' => $uploadedFileUrl]);

        $this->productRepository->update($product, $data);

        return redirect(route('product.index'))->with('success', 'Product Updated Successfully');
    }

    public function destroy(Product $product): RedirectResponse
    {

        $this->productRepository->delete($product);

        return redirect(route('product.index'))->with('success', 'Product deleted Successfully');
    }

    public function fileImportIndex(): View
    {

        return view('admin.products.file');
    }

    public function fileImportUpload(ImportFileRequest $request)
    {
        $data =  file($request->file('file'));
//                $file = file($request->file('file'));
//
//                $chunks = array_chunk($file, 1000);
//
//                $header = [];
//                $batch = Bus::batch([ ])->dispatch();
//
//                foreach ($chunks as $key => $chunk) {
//                    $data = array_map('str_getcsv', $chunk);
//
//                    if ($key == 0) {
//                        $header = $data[0];
//                        unset($data[0]);
//                    }
//
//                    $batch->add(new ProductImportDataJob($data, $header));
//                }



        $chunks = array_chunk($data, 1000);

        $header = [];
        $batch  = Bus::batch([])->dispatch();

        foreach ($chunks as $key => $chunk) {
            $data = array_map('str_getcsv', $chunk);

            if ($key === 0) {
                $header = $data[0];
                unset($data[0]);
            }

            $batch->add(new ProductImportDataJob($data, $header));
        }

        return redirect(route('product.index'))->with('success', 'Product Import Successfully');


    }
    public function batch()
    {
        $batchId = request('id');
        return Bus::findBatch($batchId);
    }
    public function exportLargeDataToExcel()
    {
        $totalRecords = Product::count(); // Số lượng bản ghi tổng cộng
        $recordsPerFile = 5; // Số lượng bản ghi trong mỗi tệp Excel

        $totalFiles = ceil($totalRecords / $recordsPerFile);

        // Xử lý xuất dữ liệu thành các tệp Excel nhỏ
        for ($i = 0; $i < $totalFiles; $i++) {
            $offset = $i * $recordsPerFile;
            $limit = $recordsPerFile;
            $fileName = 'product_' . ($i + 1) . '.csv';

           return  Excel::download(new ProductFileExport($offset, $limit), $fileName);
        }


    }
}
