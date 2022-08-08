<?php

namespace App\Imports;

use App\Models\Street;
use Maatwebsite\Excel\Concerns\ToModel;

class StreetImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Street([
            'street' => $row[0]
        ]);
    }
}
