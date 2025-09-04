<?php

namespace App\Imports;

use App\Models\Laboratory;
use App\Models\Medicine;
use App\Models\Pharmaceutical_Form;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;

class StringValueBinder extends DefaultValueBinder
{
    public function bindValue(Cell $cell, $value)
    {
        // إذا كان الرقم بصيغة علمية، حوّله إلى string كامل
        if (is_numeric($value) && stripos($value, 'E') !== false) {
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

    // تخزين آخر قيمة غير فارغة للعمود code
    protected $lastCode = null;

    public function model(array $row)
    {
        // تنظيف قيمة العمود code
        $code = isset($row['code']) ? trim($row['code']) : null;

        if ($code !== null && stripos($code, 'E') !== false) {
            $code = number_format($code, 0, '', '');
        }

        // إذا فارغة، استخدم آخر قيمة غير فارغة
        if ($code === null || $code === '') {
            $code = $this->lastCode; // يمكن أن يكون null إذا لم توجد قيمة سابقة
        } else {
            // تحديث آخر قيمة غير فارغة
            $this->lastCode = $code;
        }

        $laboratoryId = Laboratory::where('name_en', trim($row['laboratory_id']))
            ->orWhere('name_ar', trim($row['laboratory_id']))
            ->value('id');

        $pharmaceuticalFormId = Pharmaceutical_Form::where('name_en', trim($row['pharmaceutical_form_id']))
            ->orWhere('name_ar', trim($row['pharmaceutical_form_id']))
            ->value('id');

        if (!$laboratoryId || !$pharmaceuticalFormId) {
            return null;
        }

        return new Medicine([
            'trade_name' => $row['trade_name'],
            'laboratory_id' => $laboratoryId,
            'composition' => $row['composition'],
            'titer' => $row['titer'],
            'packaging' => $row['packaging'],
            'pharmaceutical_form_id' => $pharmaceuticalFormId,
            'code' => $code !== null ? $code : 'N/A',
        ]);
    }

    public function getValueBinder()
    {
        return new StringValueBinder();
    }
}
