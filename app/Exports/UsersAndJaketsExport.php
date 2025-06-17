<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Jaket;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class UsersAndJaketsExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            'Users' => new UserExport(),
            'Jakets' => new JaketExport()
        ];
    }
}
