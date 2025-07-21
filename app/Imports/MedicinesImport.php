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
        $laboratoryId = Laboratory::where('name_en', trim($row[1]))
            ->orWhere('name_ar', trim($row[1]))
            ->value('id');

        $pharmaceuticalFormId = Pharmaceutical_Form::where('name_en', trim($row[5]))
            ->orWhere('name_ar', trim($row[5]))
            ->value('id');

        if (!$laboratoryId || !$pharmaceuticalFormId) {
            return null;
        }

        return new Medicine([
            'trade_name' => $row[0],
            'laboratory_id' => $laboratoryId,
            'composition' => $row[2],
            'titer' => $row[3],
            'packaging' => $row[4],
            'pharmaceutical_form_id' => $pharmaceuticalFormId,
        ]);
    }

}
