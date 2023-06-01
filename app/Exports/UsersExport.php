<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromQuery, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {
        return User::query()->where('email', 'admin@admin.com');
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama',
            'Email',
            'D',
            'D',
            'D',
            'D',
            'D',
            'D',
            'D',
            'D',
            'D',
            'D',
            'D',
            'D',
            'D',
            'D',
            'D',
        ];
    }
}
