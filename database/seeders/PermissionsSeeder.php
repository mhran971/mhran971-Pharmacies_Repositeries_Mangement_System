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

            ['name_en' => 'Add Employee', 'name_ar' => 'إضافة موظف'], //permission id =1
            ['name_en' => 'Delete Employee', 'name_ar' => 'حذف موظف'], //permission id =2
            ['name_en' => 'View All Employee', 'name_ar' => 'عرض جميع الموظفين'],  //permission id =3
            ['name_en' => 'Electronic inventory using camera', 'name_ar' => 'جرد إلكتروني بالتصوير'],//permission id = 4
            ['name_en' => 'Add Medicine', 'name_ar' => 'إضافة دواء'], // permission id = 5
            ['name_en' => 'View orders', 'name_ar' => 'استعراض الطلبات'],   //permission id = 6
            ['name_en' => 'Modify order status', 'name_ar' => 'تعديل حالة الطلب'], //permission id =7 same
            ['name_en' => 'Search for medicine By barcode', 'name_ar' => 'البحث عن دواء بواسطة الباركود'],  //permission id = 8
            ['name_en' => 'Create invoices', 'name_ar' => 'إنشاء فواتير'],   //permission id = 9
            ['name_en' => 'View Notice before expiration', 'name_ar' => 'رؤية إشعار قبل انتهاء الصلاحية'],//permission id = 10
            ['name_en' => 'View Notice before stock runs out', 'name_ar' => 'رؤية إشعار قبل نفاد المخزون'],//permission id = 11
            ['name_en' => 'Printing invoices', 'name_ar' => 'طباعة الفواتير'], //permission id = 12
            ['name_en' => 'Inventory', 'name_ar' => 'عملية الجرد'], //  permission id = 13
            ['name_en' => 'Create graphic organizers', 'name_ar' => 'إنشاء منظمات رسومية'], //permission id = 14
            ['name_en' => 'View Pharmacy Stocks', 'name_ar' => 'عرض مخزون الصيدلية'], // permission id = 15
            ['name_en' => 'Return Medicine', 'name_ar' => 'إرجاع الدواء'], // permission id = 16
            ['name_en' => 'Delete Order', 'name_ar' => 'حذف الطلب'], // permission id = 17
            ['name_en' => 'Update Order Status', 'name_ar' => 'تحديث حالة الطلب'], // permission id = 18
            ['name_en' => 'Customer debt management', 'name_ar' => 'ادارة ديون الزبائن'], // permission id = 19
            ['name_en' => 'Foreign Drug Administration', 'name_ar' => 'ادارة الادوية الاجنبية'], // permission id = 20
            ['name_en' => 'Managing private requests', 'name_ar' => 'ادارة الطلبات الخاصة'], // permission id = 21


        ];

        collect($permissions)->chunk(15)->each(function ($chunk) {
            DB::table('permissions')->insert($chunk->toArray());
        });

    }
}
