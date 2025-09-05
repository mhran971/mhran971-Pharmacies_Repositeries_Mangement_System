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

        // تنظيف القيمة من أي مسافات أو علامات tabs
        $value = trim(preg_replace('/[\x00-\x1F\x7F]/u', '', (string)$value));

        // إجبار أي قيمة لتصبح نص
        $cell->setValueExplicit($value, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        return true;
    }
}

class MedicinesImport implements ToModel, WithHeadingRow
{
    use Importable;

    public function model(array $row)
    {
        // تنظيف العمود code
        $code = isset($row['code']) ? trim($row['code']) : null;

        if ($code !== null && stripos($code, 'E') !== false) {
            $code = number_format((float)$code, 0, '', '');
        }

        // إذا كان الكود فارغ، ضع قيمة افتراضية N/A
        if (empty($code)) {
            $code = 'N/A';
        }

        // تنظيف باقي الأعمدة من المسافات والـ tabs
        $tradeName = isset($row['trade_name']) ? trim(preg_replace('/[\x00-\x1F\x7F]/u', '', $row['trade_name'])) : null;
        $composition = isset($row['composition']) ? trim($row['composition']) : null;
        $titer = isset($row['titer']) ? trim($row['titer']) : null;
        $packaging = isset($row['packaging']) ? trim($row['packaging']) : null;

        // جلب IDs بطريقة أكثر أماناً
        $laboratoryId = Laboratory::where('name_en', $row['laboratory_id'] ?? '')
            ->orWhere('name_ar', $row['laboratory_id'] ?? '')
            ->value('id');

        $pharmaceuticalFormId = Pharmaceutical_Form::where('name_en', $row['pharmaceutical_form_id'] ?? '')
            ->orWhere('name_ar', $row['pharmaceutical_form_id'] ?? '')
            ->value('id');

        return new Medicine([
            'trade_name' => $tradeName,
            'laboratory_id' => $laboratoryId,
            'composition' => $composition,
            'titer' => $titer,
            'packaging' => $packaging,
            'pharmaceutical_form_id' => $pharmaceuticalFormId,
            'code' => $code,
        ]);
    }

    public function getValueBinder()
    {
        return new StringValueBinder();
    }
}
