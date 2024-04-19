<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //
    public function index(){
        $products = Product::all();
        return view("products.index",["products"=>$products]);
      
    }
    public function create(){
        return view("products.create");
    }
    public function store(Request $request)
{
    // Validate the incoming request data
    $validatedData = $request->validate([
        'name' => 'required|string',
        'price' => 'required|numeric',
        'quantity' => 'required|integer',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,jfif|max:2048', // Assuming image is required and restricted to certain formats and size
        'description' => 'required|string',
    ]);

    // Handle the image upload
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        
        // Create the storage directory if it doesn't exist
        $imagePath = $image->storeAs('public/assets/images', $imageName);

        // Update the 'image' field in the validated data with the correct path
        $validatedData['image'] = 'storage/assets/images/' . $imageName;
    }

    // Create the product
    $product = Product::create($validatedData);

    // Redirect back to the product index page with success message
    return redirect()->route('product.index')->with('success', 'Product created successfully.');
}



    public function edit(Product $product){
        return view('products.edit', ['product' => $product]);
    }

    public function update(Product $product, Request $request){
        $validatedData = $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'image' => 'image|mimes:jpeg,png,jpg,gif,jfif|max:2048', // Assuming image is required and restricted to certain formats and size
            'description' => 'required|string',
        ]);
    
        // Handle the image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            
            // Create the storage directory if it doesn't exist
            $imagePath = $image->storeAs('public/assets/images', $imageName);
    
            // Update the 'image' field in the validated data with the correct path
            $validatedData['image'] = 'storage/assets/images/' . $imageName;
        }
        $product->update($validatedData);

        return redirect(route('product.index'))->with('success', 'Product Updated Succesffully');

    }
    public function destroy(Product $product){
        $product->delete();
        return redirect(route('product.index'))->with('success', 'Product deleted Succesffully');
    }
    
}
