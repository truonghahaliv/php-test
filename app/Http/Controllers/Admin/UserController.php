<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\User\UserInterface;
use App\Service\ValidatorService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    protected UserInterface $userRepository;
    protected ValidatorService $validatorService;
    public function __construct(UserInterface $userRepository, ValidatorService $validatorService){
        $this->userRepository = $userRepository;
        $this->validatorService = $validatorService;
    }

    public function index(){
        $this->validatorService->checkRole();
        $users = $this->userRepository->paginate(5);

        // Return the products to a view
        return view('users.index', compact('users'))->with('i', (request()->input('page', 1) - 1) * 5);

    }
    public function create(){
        $this->validatorService->checkRole();
        return view("users.create");
    }
    public function store(Request $request){

        $validatedData = $this->validatorService->validateUserData($request);

//        $imagePath = $this->validatorService->uploadImage($request);
//
//        if ($imagePath) {
//            $validatedData['image'] = $imagePath;
//        }

        $this->userRepository->create($validatedData);

        return redirect()->route('user.index')->with('success', 'Product created successfully.');




    }
    public function edit(User $user){
        $this->validatorService->checkRole();
        return view('users.edit', ['user' => $user]);
    }

    public function update(User $user, Request $request){


        $validatedData = $this->validatorService->validateUserUpdateData($request, $user);
//        $imagePath = $this->validatorService->uploadImage($request);
//
//        if ($imagePath) {
//            $validatedData['image'] = $imagePath;
//        }

        $this->userRepository->update($user, $validatedData);

        return redirect(route('user.index'))->with('success', 'Product Updated Successfully');

    }
    public function destroy(User $user){
        $this->validatorService->checkRole();
        $this->userRepository->delete($user);
        return redirect(route('user.index'))->with('success', 'User deleted Succesffully');
    }

}