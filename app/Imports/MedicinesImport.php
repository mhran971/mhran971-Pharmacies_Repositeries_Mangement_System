<?php

namespace App\Imports;

use App\Models\Laboratory;
use App\Models\Medicine;
use App\Models\Pharmaceutical_Form;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;

class StringValueBinder extends DefaultValueBinder
{
    public function bindValue(Cell $cell, $value)
    {
        // إذا كان الرقم بصيغة علمية، حوّله إلى string كامل
        if (is_numeric($value) && stripos((string)$value, 'E') !== false) {
            $value = number_format($value, 0, '', '');
        }

        // إجبار أي قيمة لتصبح نص
        $cell->setValueExplicit((string) $value, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        return true;
    }
}

class MedicinesImport implements ToModel, WithHeadingRow
{
    use Importable;

    public function model(array $row)
    {
        // تنظيف قيمة العمود code
        $code = isset($row['code']) ? trim($row['code']) : null;

        if ($code !== null && stripos($code, 'E') !== false) {
            $code = number_format((float)$code, 0, '', '');
        }

        // إذا كان الكود فارغ، ضع قيمة افتراضية N/A
        if (empty($code)) {
            $code = 'N/A';
        }

        // جلب الـ Laboratory ID
        $laboratoryId = Laboratory::where('name_en', trim($row['laboratory_id'] ?? ''))
            ->orWhere('name_ar', trim($row['laboratory_id'] ?? ''))
            ->value('id');

        // جلب الـ Pharmaceutical Form ID
        $pharmaceuticalFormId = Pharmaceutical_Form::where('name_en', trim($row['pharmaceutical_form_id'] ?? ''))
            ->orWhere('name_ar', trim($row['pharmaceutical_form_id'] ?? ''))
            ->value('id');

        return new Medicine([
            'trade_name' => $row['trade_name'] ?? null,
            'laboratory_id' => $laboratoryId,
            'composition' => $row['composition'] ?? null,
            'titer' => $row['titer'] ?? null,
            'packaging' => $row['packaging'] ?? null,
            'pharmaceutical_form_id' => $pharmaceuticalFormId,
            'code' => $code,
        ]);
    }

    public function getValueBinder()
    {
        return new StringValueBinder();
    }
}
