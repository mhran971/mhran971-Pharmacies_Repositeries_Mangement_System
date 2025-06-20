<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LaboratorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $laboratories = [
            ['name_en' => 'Al-Razi Limited Liability Company', 'name_ar' => 'شركة الرازي محدودة المسؤولية'],
            ['name_en' => 'Middle East Laboratories for Pharmaceutical Industries LLC', 'name_ar' => 'مختبرات شرق المتوسط للصناعات الدوائية المحدودة المسؤولية'],
            ['name_en' => 'Human Pharma Laboratory', 'name_ar' => 'معمل هيومن فارما'],
            ['name_en' => 'Zain Pharma for Pharmaceutical Industries', 'name_ar' => 'زين فارما للصناعات الدوائية'],
            ['name_en' => 'Shifa Company for Pharmaceutical Industries', 'name_ar' => 'شركة شفا للصناعات الدوائية'],
            ['name_en' => 'Al-Madina Pharmaceutical Laboratory LLC / City Pharma', 'name_ar' => 'معمل المدينة الدوائية المحدودة المسؤولية / سيتي فارما /'],
            ['name_en' => 'Al-Saad Laboratory for Pharmaceutical Industries', 'name_ar' => 'معمل السعد للصناعات الدوائية'],
            ['name_en' => 'Asia Laboratories for Pharmaceutical Industries', 'name_ar' => 'مختبرات آسيا للصناعات الدوائية'],
            ['name_en' => 'National Company for Pharmaceutical Industries', 'name_ar' => 'الشركة الوطنية للصناعات الدوائية'],
            ['name_en' => 'Ibn Zahr Pharmaceutical Industries Company', 'name_ar' => 'شركة ابن زهر للصناعات الصيدلانية المساهمة المغفلة الخاصة'],
            ['name_en' => 'Obri Company for Pharmaceutical Industries LLC', 'name_ar' => 'شركة أوبري للصناعات الدوائية المحدودة المسؤولية'],
            ['name_en' => 'Masoud Company for Medical Solutions LLC', 'name_ar' => 'شركة مسعود للمحاليل الطبية المحدودة المسؤولية'],
            ['name_en' => 'Al-Shahba Laboratory for Human Medicine Production', 'name_ar' => 'معمل الشهباء لصناعة الادوية البشرية'],
            ['name_en' => 'Ausher Pharma Laboratory', 'name_ar' => 'معمل اوشر فارما'],
            ['name_en' => 'Al-Sharq for Human Medicines', 'name_ar' => 'الشرق للأدوية البشرية'],
            ['name_en' => 'Alpha LLC', 'name_ar' => '/الفا / المحدودة المسؤولية'],
            ['name_en' => 'M.C.P Cure Pharma LLC', 'name_ar' => 'أم سي بي كيور فارما المحدودة المسؤولية M.C.P CURE PHARMA L.L. C'],
            ['name_en' => 'Al-Ufuq Laboratory for Pharmaceutical Industries', 'name_ar' => 'معمل الأفق للصناعات الدوائية'],
            ['name_en' => 'Mercy Pharma Laboratory', 'name_ar' => 'معمل ميرسي فارما'],
            ['name_en' => 'Ibn Al-Haytham Company for Pharmaceutical Industries', 'name_ar' => 'شركة ابن الهيثم للصناعات الدوائية'],
            ['name_en' => 'Al-Raed Laboratory for Pharmaceutical Industries', 'name_ar' => 'معمل الرائد للصناعات الدوائية'],
            ['name_en' => 'Dumna Company for Pharmaceutical Industry', 'name_ar' => 'شركة دومنا للصناعة الدوائية'],
            ['name_en' => 'Al-Mustaqbal Company for Pharmaceutical Industries', 'name_ar' => 'شركة المستقبل للصناعات الدوائية'],
            ['name_en' => 'Kesbar & Shabani Pharma Company', 'name_ar' => 'شركة كسبار وشعباني فارما'],
            ['name_en' => 'Ruby', 'name_ar' => 'روبى'],
            ['name_en' => 'Syrian Drug Company (Pharmasir)', 'name_ar' => 'الشركة السورية للدواء ( فارماسير)'],
            ['name_en' => 'Masoud Pharma Laboratory', 'name_ar' => 'معمل مسعود فارما'],
            ['name_en' => 'Sandy Pharma Company', 'name_ar' => 'شركة ساندي فارما'],
            ['name_en' => 'Delta Laboratory for Pharmaceutical Industries', 'name_ar' => 'معمل دلتا للصناعات الدوائية'],
            ['name_en' => 'Unipharma Laboratory for Pharmaceutical Industries LLC', 'name_ar' => 'معمل يونيفارما للصناعات الدوائية محدودة المسؤولية'],
            ['name_en' => 'Barakat for Pharmaceutical Industries LLC', 'name_ar' => 'بركات للصناعات الدوائية محدودة المسؤولية'],
            ['name_en' => 'Rasha for Medicines', 'name_ar' => 'راشا للادوية'],
            ['name_en' => 'Mediotech', 'name_ar' => 'ميديوتيك'],
            ['name_en' => 'Medico Company', 'name_ar' => 'شركة ميديكو'],
            ['name_en' => 'Hama for Pharmaceutical Industries', 'name_ar' => 'حماة للصناعات الدوائية'],
            ['name_en' => 'Al-Zaabi Brothers - Al-Fares', 'name_ar' => 'الزعبي اخوان- الفارس'],
            ['name_en' => 'Ibn Rushd Laboratory for Pharmaceutical Industries', 'name_ar' => 'معمل ابن رشد للصناعات الدوائية'],
            ['name_en' => 'Al-Balsam Company for Pharmaceutical and Cosmetic Industries', 'name_ar' => 'شركة البلسم للصناعات الدوائية ومواد التجميل'],
            ['name_en' => 'Lama Pharma Laboratory for Pharmaceutical Industries', 'name_ar' => 'معمل لاما فارما للصناعات الدوائية'],
            ['name_en' => 'Al-Yousef Laboratory G', 'name_ar' => 'معمل اليوسف ج/ G'],
            ['name_en' => 'Rama Company for Pharmaceutical Industries', 'name_ar' => 'شركة راما للصناعات الدوائية'],
            ['name_en' => 'Ibn Hayyan Laboratory for Pharmaceutical Industries', 'name_ar' => 'معمل ابن حيان للصناعات الدوائية'],
            ['name_en' => 'Mediterranean for Pharmaceutical Industries LLC', 'name_ar' => 'المتوسط للصناعات الدوائية محدودة المسؤولية'],
            ['name_en' => 'Pharmaceutical Medical Laboratories (Medipharm)', 'name_ar' => 'المختبرات الطبية الصيدلانية / ميديفارم /'],
            ['name_en' => 'Al-Qanawati Laboratory for Pharmaceutical Industries', 'name_ar' => 'معمل القنواتي للصناعات الدوائية'],
            ['name_en' => 'Unishima Company for Pharmaceutical Industries', 'name_ar' => 'شركة يونيشيما للصناعات الدوائية'],
            ['name_en' => 'Diamond Pharma', 'name_ar' => 'دياموند فارما'],
            ['name_en' => 'Bahri Medical Company LLC', 'name_ar' => 'شركة بحري الطبية المحدودة المسؤولية'],
            ['name_en' => 'Vita Pharma Laboratory', 'name_ar' => 'معمل فيتا فارما'],
            ['name_en' => 'Al-Nawras Laboratory for Pharmaceutical Industries', 'name_ar' => 'معمل النورس للصناعات الدوائية'],
            ['name_en' => 'Ugarit for Pharmaceutical Industries', 'name_ar' => 'اوغاريت للصناعات الدوائية'],
            ['name_en' => 'SEFCO', 'name_ar' => 'سيفكو'],
            ['name_en' => 'Cerda Pharma Laboratory for Medical Solutions', 'name_ar' => 'معمل سيردا فارما للمحاليل الطبية'],
            ['name_en' => 'Golden Medpharma Laboratory', 'name_ar' => 'معمل غولدن ميدفارما'],
            ['name_en' => 'Avamia for Pharmaceutical Industries', 'name_ar' => 'افاميا للصناعات الدوائية'],
            ['name_en' => 'Tramedica Laboratory for Pharmaceutical Industries', 'name_ar' => 'معمل التراميديكا للصناعات الدوائية'],
            ['name_en' => 'Tamico Laboratory - Rural Damascus - Al-Maliha', 'name_ar' => 'معمل تاميكو- ريف دمشق - المليحة'],
            ['name_en' => 'Amisa Laboratory', 'name_ar' => 'معمل اميسا'],
            ['name_en' => 'Kimy for Pharmaceutical Industries', 'name_ar' => 'كيمي للصناعات الدوائية'],
            ['name_en' => 'Biomed Pharma Company LLC', 'name_ar' => 'شركة بيوميد فارما المحدودة المسؤولية'],
            ['name_en' => 'Hayat Pharma for Pharmaceutical Industries', 'name_ar' => 'حياة فارما للصناعات الدوائية'],
            ['name_en' => 'Magic Pharma', 'name_ar' => 'ماجيكو'],
            ['name_en' => 'Cipharma Company for Pharmaceutical Industries', 'name_ar' => 'شركة سيفارما للصناعات الدوائية'],
            ['name_en' => 'Amrit Drug Company', 'name_ar' => 'شركة عمريت للدواء'],
            ['name_en' => 'Abdul Wahab Al-Qanawati Company for Medical Preparations', 'name_ar' => 'شركة عبد الوهاب القنواتي للمستحضرات الطبية المساهمة المغفلة الخاصة'],
            ['name_en' => 'Prolene Pharma Company', 'name_ar' => 'شركة برولاين فارما'],
            ['name_en' => 'United Company for Pharmaceutical Industries LLC', 'name_ar' => 'شركة المتحدة للصناعات الدوائية المحدودة المسؤولية'],
            ['name_en' => 'Gamma Laboratories for Pharmaceutical Industries LLC', 'name_ar' => 'مختبرات غاما للصناعات الدوائية المحدودة المسؤولية'],
            ['name_en' => 'United Pharma', 'name_ar' => 'يونايتد فارما'],
            ['name_en' => 'Taryaq Laboratory for Pharmaceutical Industries', 'name_ar' => 'معمل ترياق للصناعات الدوائية'],
            ['name_en' => 'Middle East for Human Medicine Industries LLC - Megapharma', 'name_ar' => 'شركة الشرق الاوسط لصناعة الادوية البشرية المحدودة المسؤولية- ميغافارما'],
            ['name_en' => 'Ibn Sina Laboratory Branch 1 for Pharmaceutical Industries - Rural Damascus', 'name_ar' => 'معمل ابن سينا فرع 1 للصناعات الدوائية - ريف دمشق'],
            ['name_en' => 'Salama Care Laboratory for Pharmaceutical Industries', 'name_ar' => 'معمل سلامة كيرللصناعات الدوائية'],
            ['name_en' => 'International Drug Laboratory IDM', 'name_ar' => 'معمل الدولية للدواء اي دي م i d m'],
            ['name_en' => 'Matouk Pharma Company LLC', 'name_ar' => 'شركة معتوق فارما محدودة المسؤولية'],
            ['name_en' => 'Miamed Laboratory for Pharmaceutical Industries', 'name_ar' => 'معمل مياميد للصناعات الدوائية'],
            ['name_en' => 'Al-Farabi Laboratory', 'name_ar' => 'معمل الفارابي'],
            ['name_en' => 'Shamra Pharma Laboratory', 'name_ar' => 'معمل شمرا فارما'],
            ['name_en' => 'Al-Salam Company for Pharmaceutical Industries', 'name_ar' => 'شركة السلام للصناعات الدوائية'],
            ['name_en' => 'Siraj Laboratory for Pharmaceutical Industries - Siraj Pharma', 'name_ar' => 'معمل سراج للصناعات الدوائية - سراج فارما'],
            ['name_en' => 'Al-Sham (Shamco)', 'name_ar' => 'الشام (شامكو)'],
            ['name_en' => 'Asco Pharma', 'name_ar' => 'آسكو فارما'],
            ['name_en' => 'Al-Maarefa Company for Pharmaceutical Industries (Alma)', 'name_ar' => 'شركة المعرفة للصناعات الدوائية ( ألما المساهمة المغفلة)'],
            ['name_en' => 'Al-Dimas Laboratory for Medicine Production', 'name_ar' => 'معمل الديماس لصناعة الادوية'],
            ['name_en' => 'Al-Hassan', 'name_ar' => 'الحسن'],
            ['name_en' => 'Adamco Company', 'name_ar' => 'شركة أدامكو'],
            ['name_en' => 'Kinda for Pharmaceutical Industries', 'name_ar' => 'كندة للصناعات الدوائية'],
            ['name_en' => 'Victoria Company for Pharmaceutical Industries LLC', 'name_ar' => 'شركة فكتوريا/ VICTORIA / للصناعات الدوائية المحدودة المسؤولية'],
            ['name_en' => 'Melkart Laboratory for Pharmaceutical Industries', 'name_ar' => 'معمل ملكارت للصناعات الدوائية'],
        ];

        collect($laboratories)->chunk(100)->each(function ($chunk) {
            DB::table('laboratories')->insert($chunk->toArray());
        });
    }
}
