<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Repositories\Product\ProductRepository;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected  ProductRepository $productRepository;
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }
    public function index(){
        $products = $this->productRepository->paginate(4);

        return view('home', compact('products'))->with('i', (request()->input('page', 1) - 1) * 4);

    }


}
