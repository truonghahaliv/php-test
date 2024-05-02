<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UserFileExport implements FromCollection, WithHeadings, WithMapping
{

    public function collection()
    {
        // TODO: Implement collection() method.
        return User::select('*')->get();
    }

    public function headings(): array
    {
        // TODO: Implement headings() method.
        return [
            '#',
            'Name',
            'Email',
            'Created Date'
        ];
    }

    public function map($user): array
    {
        // TODO: Implement map() method.
        return [
            $user->id,
            $user->name,
            $user->email,
            $user->created_at,
        ];
    }
}
