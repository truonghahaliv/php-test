<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class UserFileImport implements ToCollection, ToModel, WithHeadingRow, WithValidation
{
    private $current = 0;

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection):View
    {
        return view('admin.users.index');
    }

    public function model(array $row): void
    {

        $this->current++;
        if ($this->current > 1) {
            $count = User::where('email', $row[1])->count();
            if (empty($count)) {
                $user = new User();
                $user->name = $row[0];
                $user->email = $row[1];
                $user->password = Hash::make($row[2]);
                $user->save();
            }

        }
    }
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' ],
            'password' => ['required', 'string', 'min:8'],
        ];
    }

}
