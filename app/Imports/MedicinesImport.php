<?php

namespace App\Imports;

use App\Models\Medicine;
use Maatwebsite\Excel\Concerns\ToModel;

class MedicinesImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Medicine([
            'trade_name' => $row[0],
            'laboratory_name' => $row[1],
            'composition' => $row[2],
            'titer' => $row[3],
            'packaging' => $row[4],
            'pharmaceutical_form' => $row[5],
        ]);
    }
}
