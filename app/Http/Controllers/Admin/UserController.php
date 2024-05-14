<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\File\ImportFileRequest;
use App\Http\Requests\Admin\User\StoreUserRequest;
use App\Http\Requests\Admin\User\UpdateUserRequest;
use App\Imports\UserFileExport;
use App\Imports\UserFileImport;
use App\Jobs\UserImportDataJob;
use App\Models\User;
use App\Repositories\User\UserInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    //
    protected UserInterface $userRepository;

    public function __construct(UserInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index(): View
    {

        $users = $this->userRepository->paginate(5);

        // Return the products to a view
        return view('admin.users.index', compact('users'))->with('i', (request()->input('page', 1) - 1) * 5);

    }

    public function create(): View
    {

        return view('admin.users.create');
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {

        $validatedData = $request->validated();

        $this->userRepository->create($validatedData);

        return redirect()->route('user.index')->with('success', 'Product created successfully.');

    }

    public function edit(User $user): View
    {

        return view('admin.users.edit', ['user' => $user]);
    }

    public function update(User $user, UpdateUserRequest $request): RedirectResponse
    {

        $validatedData = $request->validated();

        $this->userRepository->update($user, $validatedData);

        return redirect(route('user.index'))->with('success', 'Product Updated Successfully');

    }

    public function destroy(User $user): RedirectResponse
    {

        $this->userRepository->delete($user);

        return redirect(route('user.index'))->with('success', 'User deleted Succesffully');
    }

    public function fileImport(): View
    {

        return view('admin.users.file');
    }

    public function importFile(ImportFileRequest $request):RedirectResponse
    {

            $file = file($request->file('file'));

            $chunks = array_chunk($file, 1000);

            $header = [];
            $batch = Bus::batch([ ])->dispatch();

            foreach ($chunks as $key => $chunk) {
                $data = array_map('str_getcsv', $chunk);

                if ($key == 0) {
                    $header = $data[0];
                    unset($data[0]);
                }

                $batch->add(new UserImportDataJob($data, $header));
            }


      return  redirect()->route('user.index')->with('success', 'User imported successfully.');

        //    return(array_map('str_getcsv', file($request->file('file'))));
        // $csv = array_map('str_getcsv', file('data.csv'));

        //        foreach ($csv as  $value) {
        //            $record = array_combine($header, $value);
        //            dd($record);
        //        }

        //        $chunks = array_chunk($a, 1000);
        //        $part = storage_path('temp');
        //        dd($part);
        //        foreach ($chunks as $chunk) {
        //            $fi
        //        }
        //        Excel::import(new UserFileImport,$request->file('file'));
        //        $users = $this->userRepository->paginate(5);

    }

    public function exportFile(Request $request)
    {

        return Excel::download(new UserFileExport(), 'users.csv');

    }
}
