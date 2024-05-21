<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExportUser implements FromQuery, WithHeadings, WithMapping
{

    use Exportable;

    public function query()
    {
        return User::all();
    }

    public function headings(): array
    {
        return [
            '#',
            'Name',
            'Email',

        ];
    }

    public function map($user): array
    {
        return [
            $user->id,
            $user->name,
            $user->email

        ];
    }

    public function fields(): array
    {
        return [
            'id',
            'name',
            'email',

        ];
    }
}
