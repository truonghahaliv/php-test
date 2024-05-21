<?php

namespace App\Http\Controllers;

use App\Exports\ExportProduct;
use App\Exports\ExportUser;
use App\Jobs\ExportProductJob;
use App\Models\Product;
use App\Models\User;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Role\RoleRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class HomeController extends Controller
{
    protected  ProductRepository $productRepository;
    protected   $roleRepository;
    public function __construct(ProductRepository $productRepository, RoleRepository   $roleRepository)
    {
        $this->roleRepository = $roleRepository;
        $this->productRepository = $productRepository;
    }
    public function index(){
        $products = $this->productRepository->paginate(4);
        $roles = $this->roleRepository->all();
        return view('home', compact('products', 'roles'))->with('i', (request()->input('page', 1) - 1) * 4);

    }
    public function export()
    {
//        $totalProducts = (Product::count());
//        $batchSize = 1000;
//        $fileNames = [];
//
//        if ($totalProducts <= $batchSize) {
//            $products = Product::all();
//            $export = new ExportProduct($products);
//            Excel::store($export, 'product.csv', 'local');
//            return response()->json(['status' => 'Export completed', 'file_path' => storage_path('app/product.csv')]);
//        }
//
//        // Nếu số lượng sản phẩm lớn hơn 1000, chia nhỏ và dispatch job
//        for ($i = 0; $i < $totalProducts; $i ++) {
//            $fileName = "product_{$i}.csv";
//            ExportProductJob::dispatch($i, $batchSize);
//            $fileNames[] = $fileName;
//        }
//        $this->combineFiles($fileNames);
//        return response()->json(['status' => 'Jobs dispatched']);
        ExportProductJob::dispatch();

        return response()->json(['message' => 'Export job has been dispatched!']);
    }
    protected function combineFiles(array $fileNames)
    {
        $outputFile = storage_path('app/product_combined.csv');

        $headerWritten = false;

        $outputHandle = fopen($outputFile, 'w');

        foreach ($fileNames as $fileName) {
            $filePath = storage_path("app/{$fileName}");
            if (file_exists($filePath)) {
                $handle = fopen($filePath, 'r');
                if ($handle) {
                    while (($line = fgetcsv($handle)) !== false) {
                        // Write header only once
                        if (!$headerWritten) {
                            fputcsv($outputHandle, $line);
                            $headerWritten = true;
                        } else {
                            // Skip header for subsequent files
                            if ($line[0] !== 'ID') {
                                fputcsv($outputHandle, $line);
                            }
                        }
                    }
                    fclose($handle);
                    // Optionally delete the temporary file after combining
                    unlink($filePath);
                }
            }
        }

        fclose($outputHandle);
    }


}
