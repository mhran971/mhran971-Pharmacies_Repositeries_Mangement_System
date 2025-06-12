<?php

namespace App\Imports;

use App\Models\Laboratory;
use App\Models\Medicine;
use App\Models\Pharmaceutical_Form;
use App\Models\PharmaceuticalForm;
use Maatwebsite\Excel\Concerns\ToModel;

class MedicinesImport implements ToModel
{
    /**
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $lab = Laboratory::where('name', trim($row[1]))->first();

        $form = Pharmaceutical_Form::where('name', trim($row[5]))->first();

        if (!$lab || !$form) {
            return null;
        }

        return new Medicine([
            'trade_name' => $row[0],
            'laboratory_id' => $lab->id,
            'composition' => $row[2],
            'titer' => $row[3],
            'packaging' => $row[4],
            'pharmaceutical_form_id' => $form->id,
        ]);
    }
}
