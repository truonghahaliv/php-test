<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Permission\StorePermissionRequest;
use App\Http\Requests\Admin\Permission\UpdatePermissionRequest;
use App\Repositories\Permission\PermissionRepository;
use App\Service\ValidatorService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    //
    protected PermissionRepository $permissionRepository;


    public function __construct(PermissionRepository $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    public function index(): View
    {

        $permissions = $this->permissionRepository->paginate(5);

        // Return the products to a view
        return view('admin.permissions.index', compact('permissions'))->with('i', (request()->input('page', 1) - 1) * 5);

    }

    public function create(): View
    {

        return view("admin.permissions.create");
    }

    public function store(StorePermissionRequest $request): RedirectResponse
    {

        $validatedData = $request->validated();
        $this->permissionRepository->create($validatedData);
        // Redirect the user to the index page with a success message
        return redirect()->route('permission.index')->with('success', 'Permission created successfully.');


    }

    public function edit(Permission $permission): View
    {

        return view('admin.permissions.edit', ['permission' => $permission]);
    }

    public function update(Permission $permission, UpdatePermissionRequest $request): RedirectResponse
    {


        $validatedData = $request->validated();

        $this->permissionRepository->update($permission, $validatedData);

        return redirect(route('permission.index'))->with('success', 'Permission Updated Successfully');

    }

    public function destroy(Permission $permission): RedirectResponse
    {

        $this->permissionRepository->delete($permission);
        return redirect(route('permission.index'))->with('success', 'Permission Deleted Succesfully');
    }
}
