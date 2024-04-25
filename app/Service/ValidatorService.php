<?php

namespace App\Service;

use App\Models\User;
use Illuminate\Http\Request;

class ValidatorService
{

    public function validateProductData(Request $request)
    {
        return $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,jfif|max:2048',
            'description' => 'required|string',
        ]);
    }

    public function validateProductUpdateData(Request $request)
    {
        return $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'image' => 'image|mimes:jpeg,png,jpg,gif,jfif|max:2048',
            'description' => 'required|string',
        ]);
    }
    public  function validateUserData(Request $request)
    {
        return $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required',


        ]);
    }
    public  function validateUserUpdateData(Request $request, User $user)
    {
        return $request->validate([
            'name' => 'required',

            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'required',

        ]);
    }
    public  function validatePermissionData(Request $request)
    {
        return $request->validate([
            'name' => 'required','string','unique:permissions,name'


        ]);
    }
    public  function validateRoleData(Request $request)
    {
        return $request->validate([
            'name' => 'required','string','unique:role,name'


        ]);
    }
    public function uploadImage(Request $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('public/assets/images', $imageName);
            return 'storage/assets/images/' . $imageName;
        }
        return null;
    }

}
