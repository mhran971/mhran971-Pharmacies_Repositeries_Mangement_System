<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Pharmaceutical_FormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $pharmaceutical_form = [
                ['name_en' => 'Syrup', 'name_ar' => 'شراب'],
                ['name_en' => 'Coated tablets', 'name_ar' => 'أقراص ملبسة'],
                ['name_en' => 'Suppositories', 'name_ar' => 'تحاميل'],
                ['name_en' => 'Dry suspension', 'name_ar' => 'معلق جاف'],
                ['name_en' => 'Tablets', 'name_ar' => 'أقراص'],
                ['name_en' => 'Solution for injection/ampoules', 'name_ar' => 'محلول للحقن/حبابات'],
                ['name_en' => 'Capsules', 'name_ar' => 'محافظ'],
                ['name_en' => 'Soft gelatin capsules', 'name_ar' => 'محافظ جيلاتينية طرية'],
                ['name_en' => 'Serum', 'name_ar' => 'سيروم'],
                ['name_en' => 'Solution for injection/vial', 'name_ar' => 'محلول للحقن/فيال'],
                ['name_en' => 'Powder for injection/vial', 'name_ar' => 'بودرة للحقن/فيال'],
                ['name_en' => 'Extended-release capsules', 'name_ar' => 'محافظ مديدة التحرر'],
                ['name_en' => 'Eye drops', 'name_ar' => 'قطرة عينية'],
                ['name_en' => 'Chewable tablets', 'name_ar' => 'أقراص للمضغ'],
                ['name_en' => 'Gel', 'name_ar' => 'جل'],
                ['name_en' => 'Solution', 'name_ar' => 'محلول'],
                ['name_en' => 'Cream', 'name_ar' => 'كريم'],
                ['name_en' => 'Nasal spray', 'name_ar' => 'بخاخ أنفي'],
                ['name_en' => 'Enteric-coated tablets', 'name_ar' => 'أقراص ملبسة معوياً'],
                ['name_en' => 'Eye ointment/gram', 'name_ar' => 'مرهم عيني\\غرام'],
                ['name_en' => 'Sachets', 'name_ar' => 'ظروف'],
                ['name_en' => 'Topical powder', 'name_ar' => 'بودرة موضعية'],
                ['name_en' => 'Rectal cream', 'name_ar' => 'كريم شرجي'],
                ['name_en' => 'Ointment', 'name_ar' => 'مرهم'],
                ['name_en' => 'Oral drops', 'name_ar' => 'نقط فموية'],
                ['name_en' => 'Orally disintegrating tablets', 'name_ar' => 'أقراص متفتتة فموياً'],
                ['name_en' => 'Effervescent tablets', 'name_ar' => 'أقراص فوارة'],
                ['name_en' => 'Extended-release tablets', 'name_ar' => 'أقراص مديدة التحرر'],
                ['name_en' => 'Oral vial', 'name_ar' => 'فيال فموي'],
                ['name_en' => 'Oral suspension', 'name_ar' => 'معلق فموي'],
                ['name_en' => 'Nasal gel', 'name_ar' => 'جل أنفي'],
                ['name_en' => 'Bilayer tablets', 'name_ar' => 'أقراص ثنائية الطبقة'],
                ['name_en' => 'Sachets/syrup', 'name_ar' => 'ظروف / شراب'],
                ['name_en' => 'Ear drops', 'name_ar' => 'قطرة أذن'],
                ['name_en' => 'Metered spray', 'name_ar' => 'بخة محددة'],
                ['name_en' => 'Inhalation capsules', 'name_ar' => 'محافظ للاستنشاق'],
                ['name_en' => 'Vaginal ointment', 'name_ar' => 'مرهم مهبلي'],
                ['name_en' => 'Delayed-release capsules', 'name_ar' => 'محافظ متأخرة التحرر'],
                ['name_en' => 'Vaginal cream', 'name_ar' => 'كريم مهبلي'],
                ['name_en' => 'Vaginal ovules', 'name_ar' => 'بيوض مهبلية'],
                ['name_en' => 'Nasal drops', 'name_ar' => 'قطرة انف'],
                ['name_en' => 'Delayed-release tablets', 'name_ar' => 'أقراص متأخرة التحرر'],
                ['name_en' => 'Kit (capsules + coated tablets + coated tablets)', 'name_ar' => 'حزمة (محافظ+أقراص ملبسة+ أقراص ملبسة)'],
                ['name_en' => 'Bilayer extended-release tablets', 'name_ar' => 'أقراص ثنائية الطبقة مديدة التحرر'],
                ['name_en' => 'Spray', 'name_ar' => 'بخاخ'],
                ['name_en' => 'Solution for inhalation/ampoules', 'name_ar' => 'محلول للاستنشاق/حبابات'],
                ['name_en' => 'Lozenges', 'name_ar' => 'أقراص مص'],
                ['name_en' => 'Mouthwash', 'name_ar' => 'غسول فموي'],
                ['name_en' => 'Vaginal gel', 'name_ar' => 'جل مهبلي'],
                ['name_en' => 'Irrigation water', 'name_ar' => 'ماء معد للارواء'],
                ['name_en' => 'Sublingual tablets', 'name_ar' => 'أقراص تحت اللسان'],
                ['name_en' => 'Rectal enema', 'name_ar' => 'رحضة شرجية'],
                ['name_en' => 'Kit (tablets + coated tablets)', 'name_ar' => 'حزمة (أقراص+ أقراص ملبسة)'],
                ['name_en' => 'Dental anesthetic/cartridge', 'name_ar' => 'مخدر سني/ خرطوش'],
                ['name_en' => 'Inhalation solution', 'name_ar' => 'محلول للاستنشاق'],
                ['name_en' => 'Shampoo', 'name_ar' => 'شامبو'],
                ['name_en' => 'Anesthetic liquid', 'name_ar' => 'سائل تخدير'],
                ['name_en' => 'Suspension for injection', 'name_ar' => 'معلق للحقن'],
                ['name_en' => 'Solution water', 'name_ar' => 'ماء محل'],
                ['name_en' => 'Rectal ointment', 'name_ar' => 'مرهم شرجي'],
                ['name_en' => 'Eye/ear drops', 'name_ar' => 'قطرة عينية /أذنية'],
                ['name_en' => 'Eye/nasal/ear drops', 'name_ar' => 'قطرة عينية انفيةأذنية'],
                ['name_en' => 'Vaginal tablets', 'name_ar' => 'أقراص مهبلية'],
                ['name_en' => 'Solution for injection/serum bag (P.V.C.)', 'name_ar' => 'محلول للحقن/كيس سيروم(P.V.C.)'],
                ['name_en' => 'Paste', 'name_ar' => 'معجون'],
                ['name_en' => 'Oral spray', 'name_ar' => 'بخاخ فموي'],
                ['name_en' => 'Oral paste', 'name_ar' => 'معجون فموي'],
                ['name_en' => 'Elixir', 'name_ar' => 'الكسير'],
                ['name_en' => 'Eye gel', 'name_ar' => 'جل عيني'],
                ['name_en' => 'Oral gel', 'name_ar' => 'جل فموي'],
                ['name_en' => 'Single-dose eye drops', 'name_ar' => 'قطرة عينية \\جرعة وحيدة'],
                ['name_en' => 'Cutaneous emulsion', 'name_ar' => 'مستحلب جلدي'],
                ['name_en' => 'Intravenous infusion solution/bag', 'name_ar' => 'محلول تسريب وريدي/ عبوة او كيس'],
                ['name_en' => 'Nail solution', 'name_ar' => 'محلول أظافر'],
                ['name_en' => 'Chewable/dispersible tablets', 'name_ar' => 'أقراص للمضغ/قابلة للتبعثر'],
                ['name_en' => 'Soluble tablets', 'name_ar' => 'أقراص قابلة للإسالة'],
                ['name_en' => 'Tablets for oral suspension', 'name_ar' => 'أقراص لتحضير معلق فموي'],
                ['name_en' => 'Powder/oral', 'name_ar' => 'بودرة /فموي'],
                ['name_en' => 'Chewing gum', 'name_ar' => 'علكة'],
                ['name_en' => 'Prefilled syringe/for injection', 'name_ar' => 'سيرنغ معبأ/للحقن'],
                ['name_en' => 'Aerosol', 'name_ar' => 'رذاذ'],
                ['name_en' => 'Single-dose syrup', 'name_ar' => 'شراب وحيد الجرعة'],
                ['name_en' => 'Kit (coated tablets + coated tablets)', 'name_ar' => 'حزمة (أقراص ملبسة+ أقراص ملبسة)'],
                ['name_en' => 'Ophthalmic solution', 'name_ar' => 'محلول عيني'],
                ['name_en' => 'Tablets (tablet within tablet)', 'name_ar' => 'أقراص (قرص ضمن قرص)'],
                ['name_en' => 'Medical gauze', 'name_ar' => 'شاش طبي']
            ];

        collect($pharmaceutical_form)->chunk(100)->each(function ($chunk) {
            DB::table('pharmaceutical_forms')->insert($chunk->toArray());
        });
    }

}
