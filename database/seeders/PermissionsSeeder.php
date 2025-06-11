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

            ['name_en' => 'Add Employee', 'name_ar' => 'إضافة موظف'],
            ['name_en' => 'Delete Employee', 'name_ar' => 'حذف موظف'],
            ['name_en' => 'View All Employee', 'name_ar' => 'عرض جميع الموظفين'],
            ['name_en' => 'Electronic inventory using camera', 'name_ar' => 'جرد إلكتروني بالتصوير'],
            ['name_en' => 'Inventory by medicine name', 'name_ar' => 'جرد حسب اسم الدواء'],
            ['name_en' => 'Edit Medicine Quantity and expiration date', 'name_ar' => 'تعديل كمية الدواء وتاريخ انتهاء الصلاحية'],
            ['name_en' => 'Add Medicine', 'name_ar' => 'إضافة دواء'],
            ['name_en' => 'Delete Medicine', 'name_ar' => 'حذف دواء'],
            ['name_en' => 'View orders', 'name_ar' => 'استعراض الطلبات'],
            ['name_en' => 'Modify order status', 'name_ar' => 'تعديل حالة الطلب'],
            ['name_en' => 'Search for medicine By barcode', 'name_ar' => 'البحث عن دواء بواسطة الباركود'],
            ['name_en' => 'Search for medicine By Name', 'name_ar' => 'البحث عن دواء بالاسم'],
            ['name_en' => 'Create invoices', 'name_ar' => 'إنشاء فواتير'],
            ['name_en' => 'View Expiration notice', 'name_ar' => 'رؤية إشعار انتهاء الصلاحية'],
            ['name_en' => 'View Notice before expiration', 'name_ar' => 'رؤية إشعار قبل انتهاء الصلاحية'],
            ['name_en' => 'View Notice before stock runs out', 'name_ar' => 'رؤية إشعار قبل نفاد المخزون'],
            ['name_en' => 'View alternatives', 'name_ar' => 'رؤية البدائل'],
            ['name_en' => 'View Suggestions by expiration date', 'name_ar' => 'رؤية اقتراحات حسب تاريخ انتهاء الصلاحية'],
            ['name_en' => 'manage customer debts', 'name_ar' => 'إدارة ديون العملاء'],
            ['name_en' => 'Register an ordering', 'name_ar' => 'تسجيل طلب'],
            ['name_en' => 'Printing invoices', 'name_ar' => 'طباعة الفواتير'],
            ['name_en' => 'Register special requests', 'name_ar' => 'تسجيل طلبات خاصة'],
            ['name_en' => 'Determine permissions', 'name_ar' => 'تحديد الصلاحيات'],
            ['name_en' => 'Inventory', 'name_ar' => 'عملية الجرد'],
            ['name_en' => 'Import invoices from repository', 'name_ar' => 'استيراد الفواتير من المستودع'],
            ['name_en' => 'Create graphic organizers', 'name_ar' => 'إنشاء منظمات رسومية'],
            ['name_en' => 'Employee data registration', 'name_ar' => 'تسجيل بيانات الموظف'],
            ['name_en' => 'Calculating appropriate doses for children', 'name_ar' => 'حساب الجرعات المناسبة للأطفال'],
            ['name_en' => 'View medications', 'name_ar' => 'عرض الأدوية'],


            ['name_en' => 'Create Detailed Reports', 'name_ar' => 'إنشاء تقارير مفصلة'],
            ['name_en' => 'Submit the order', 'name_ar' => 'إرسال الطلب'],
            ['name_en' => 'Manage special requests', 'name_ar' => 'إدارة الطلبات الخاصة'],
            ['name_en' => 'Display the best-selling and least-selling medicines', 'name_ar' => 'عرض الأدوية الأكثر والأقل مبيعاً'],
            ['name_en' => 'Corporate debt presentation', 'name_ar' => 'عرض ديون الشركة'],
            ['name_en' => 'Additional selling recommendations', 'name_ar' => 'توصيات مبيعات إضافية'],
            ['name_en' => 'Registering company invoices', 'name_ar' => 'تسجيل فواتير الشركة']


//            ['name_en' => 'Manage Medicines', 'name_ar' => 'إدارة الأدوية'],
//            ['name_en' => 'Add Medicine', 'name_ar' => 'إضافة دواء'],
//            ['name_en' => 'Delete Medicine', 'name_ar' => 'حذف دواء'],
//            ['name_en' => 'Edit Medicine', 'name_ar' => 'تعديل الدواء'],
//
//            ['name_en' => 'View Stock', 'name_ar' => 'عرض المخزون'],
//            ['name_en' => 'Export Medicines', 'name_ar' => 'تصدير الأدوية'],
//            ['name_en' => 'Import Medicines', 'name_ar' => 'استيراد الأدوية'],
//            ['name_en' => 'Generate Stock Report', 'name_ar' => 'إنشاء تقرير المخزون'],
//
//            ['name_en' => 'Manage Pharmacy', 'name_ar' => 'إدارة الصيدلية'],
//            ['name_en' => 'Process Sales', 'name_ar' => 'معالجة المبيعات'],
//            ['name_en' => 'Handle Returns', 'name_ar' => 'إدارة المرتجعات'],
//            ['name_en' => 'View Sales History', 'name_ar' => 'عرض سجل المبيعات'],
//
//            ['name_en' => 'Assign Roles', 'name_ar' => 'تعيين الأدوار'],
//            ['name_en' => 'Audit System', 'name_ar' => 'مراجعة النظام'],
//            ['name_en' => 'Manage Suppliers', 'name_ar' => 'إدارة الموردين'],
//            ['name_en' => 'Manage Categories', 'name_ar' => 'إدارة الفئات'],
//
//            ['name_en' => 'Access Analytics', 'name_ar' => 'الوصول إلى التحليلات'],
//            ['name_en' => 'Configure Settings', 'name_ar' => 'ضبط الإعدادات'],
//            ['name_en' => 'Backup Data', 'name_ar' => 'نسخ البيانات احتياطيًا'],
//            ['name_en' => 'Restore Data', 'name_ar' => 'استعادة البيانات']
        ];

        collect($permissions)->chunk(15)->each(function ($chunk) {
            DB::table('permissions')->insert($chunk->toArray());
        });

    }
}
