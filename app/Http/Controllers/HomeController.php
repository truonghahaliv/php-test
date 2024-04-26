<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Role\RoleRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Http\Request;

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


}
