<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;

class UserFileImport implements ToCollection, ToModel
{
    private $current = 0;

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        return view('admin.users.index');
    }

    public function model(array $row)
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

}
