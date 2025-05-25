<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            ['name_en' => 'Manage Medicines', 'name_ar' => 'إدارة الأدوية'],
            ['name_en' => 'Add Medicine', 'name_ar' => 'إضافة دواء'],
            ['name_en' => 'Delete Medicine', 'name_ar' => 'حذف دواء'],
            ['name_en' => 'Edit Medicine', 'name_ar' => 'تعديل الدواء'],

            ['name_en' => 'View Stock', 'name_ar' => 'عرض المخزون'],
            ['name_en' => 'Export Medicines', 'name_ar' => 'تصدير الأدوية'],
            ['name_en' => 'Import Medicines', 'name_ar' => 'استيراد الأدوية'],
            ['name_en' => 'Generate Stock Report', 'name_ar' => 'إنشاء تقرير المخزون'],

            ['name_en' => 'Manage Pharmacy', 'name_ar' => 'إدارة الصيدلية'],
            ['name_en' => 'Process Sales', 'name_ar' => 'معالجة المبيعات'],
            ['name_en' => 'Handle Returns', 'name_ar' => 'إدارة المرتجعات'],
            ['name_en' => 'View Sales History', 'name_ar' => 'عرض سجل المبيعات'],

            ['name_en' => 'Assign Roles', 'name_ar' => 'تعيين الأدوار'],
            ['name_en' => 'Audit System', 'name_ar' => 'مراجعة النظام'],
            ['name_en' => 'Manage Suppliers', 'name_ar' => 'إدارة الموردين'],
            ['name_en' => 'Manage Categories', 'name_ar' => 'إدارة الفئات'],

            ['name_en' => 'Access Analytics', 'name_ar' => 'الوصول إلى التحليلات'],
            ['name_en' => 'Configure Settings', 'name_ar' => 'ضبط الإعدادات'],
            ['name_en' => 'Backup Data', 'name_ar' => 'نسخ البيانات احتياطيًا'],
            ['name_en' => 'Restore Data', 'name_ar' => 'استعادة البيانات']
        ];

        collect($permissions)->chunk(15)->each(function ($chunk) {
            DB::table('permissions')->insert($chunk->toArray());
        });

    }
}
