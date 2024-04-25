<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Permission\PermissionRepository;
use App\Service\ValidatorService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    //
    protected PermissionRepository $permissionRepository;
    protected ValidatorService $validatorService;

    public function __construct(PermissionRepository $permissionRepository, ValidatorService $validatorService)
    {
        $this->permissionRepository = $permissionRepository;
        $this->validatorService = $validatorService;
    }

    public function index()
    {

        $permissions = $this->permissionRepository->paginate(5);

        // Return the products to a view
        return view('admin.permissions.index', compact('permissions'))->with('i', (request()->input('page', 1) - 1) * 5);

    }

    public function create()
    {

        return view("admin.permissions.create");
    }

    public function store(Request $request)
    {

        $validatedData = $this->validatorService->validatePermissionData($request);
        $this->permissionRepository->create($validatedData);
        // Redirect the user to the index page with a success message
        return redirect()->route('permission.index')->with('success', 'Permission created successfully.');


    }

    public function edit(Permission $permission)
    {

        return view('admin.permissions.edit', ['permission' => $permission]);
    }

    public function update(Permission $permission, Request $request)
    {


        $validatedData = $this->validatorService->validatePermissionData($request);


        $this->permissionRepository->update($permission, $validatedData);

        return redirect(route('permission.index'))->with('success', 'Permission Updated Successfully');

    }

    public function destroy(Permission $permission)
    {

        $this->permissionRepository->delete($permission);
        return redirect(route('permission.index'))->with('success', 'Permission Deleted Succesfully');
    }
}
