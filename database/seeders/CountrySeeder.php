<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Country;
use App\Models\Occupation;
use App\Models\Qualification;
use App\Models\Question;
use App\Models\Specialty;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Country::truncate();
        City::truncate();
        Question::truncate();
        Occupation::truncate();
        Specialty::truncate();
        Qualification::truncate();

        Country::create(['name' => 'السعودية']);


        $cities = array(
            array('id' => '1','country_id' => '1','name' => 'جدة','created_at' => '2022-10-05 13:13:41','updated_at' => '2022-10-05 13:13:41'),
            array('id' => '2','country_id' => '1','name' => 'الرياض','created_at' => '2022-10-05 13:13:41','updated_at' => '2022-10-05 13:13:41'),
            array('id' => '5','country_id' => '1','name' => 'الدمام','created_at' => '2022-10-16 08:58:47','updated_at' => '2022-10-16 08:58:47'),
            array('id' => '6','country_id' => '1','name' => 'الخبر','created_at' => '2022-10-16 08:59:06','updated_at' => '2022-10-16 08:59:06'),
            array('id' => '7','country_id' => '1','name' => 'القطيف','created_at' => '2022-10-16 08:59:14','updated_at' => '2022-10-16 08:59:14'),
            array('id' => '8','country_id' => '1','name' => 'راس تنورة','created_at' => '2022-10-16 08:59:23','updated_at' => '2022-10-16 08:59:23'),
            array('id' => '9','country_id' => '1','name' => 'الجبيل','created_at' => '2022-10-16 08:59:31','updated_at' => '2022-10-16 08:59:31'),
            array('id' => '10','country_id' => '1','name' => 'النعيرية','created_at' => '2022-10-16 08:59:38','updated_at' => '2022-10-16 08:59:38'),
            array('id' => '11','country_id' => '1','name' => 'حفر الباطن','created_at' => '2022-10-16 08:59:46','updated_at' => '2022-10-16 08:59:46'),
            array('id' => '12','country_id' => '1','name' => 'الجوف','created_at' => '2022-10-16 08:59:53','updated_at' => '2022-10-16 08:59:53'),
            array('id' => '13','country_id' => '1','name' => 'سكاكا','created_at' => '2022-10-16 09:00:00','updated_at' => '2022-10-16 09:00:00'),
            array('id' => '14','country_id' => '1','name' => 'حائل','created_at' => '2022-10-16 09:00:06','updated_at' => '2022-10-16 09:00:06'),
            array('id' => '15','country_id' => '1','name' => 'القصيم','created_at' => '2022-10-16 09:00:14','updated_at' => '2022-10-16 09:00:14'),
            array('id' => '16','country_id' => '1','name' => 'تبوك','created_at' => '2022-10-16 09:00:22','updated_at' => '2022-10-16 09:00:22'),
            array('id' => '17','country_id' => '1','name' => 'حقل','created_at' => '2022-10-16 09:00:38','updated_at' => '2022-10-16 09:00:38'),
            array('id' => '18','country_id' => '1','name' => 'المدينة المنورة','created_at' => '2022-10-16 09:00:47','updated_at' => '2022-10-16 09:00:47'),
            array('id' => '19','country_id' => '1','name' => 'وادي الدواسر','created_at' => '2022-10-16 09:01:52','updated_at' => '2022-10-16 09:01:52'),
            array('id' => '20','country_id' => '1','name' => 'بيشة','created_at' => '2022-10-16 09:01:57','updated_at' => '2022-10-16 09:01:57'),
            array('id' => '21','country_id' => '1','name' => 'أبها','created_at' => '2022-10-16 09:02:04','updated_at' => '2022-10-16 09:02:04'),
            array('id' => '22','country_id' => '1','name' => 'النماص','created_at' => '2022-10-16 09:02:16','updated_at' => '2022-10-16 09:02:16'),
            array('id' => '23','country_id' => '1','name' => 'جازان','created_at' => '2022-10-16 09:02:23','updated_at' => '2022-10-16 09:02:23'),
            array('id' => '24','country_id' => '1','name' => 'محائل عسير','created_at' => '2022-10-16 09:02:39','updated_at' => '2022-10-16 09:02:39'),
            array('id' => '25','country_id' => '1','name' => 'الباحة','created_at' => '2022-10-16 09:02:46','updated_at' => '2022-10-16 09:02:46'),
            array('id' => '26','country_id' => '1','name' => 'الطائف','created_at' => '2022-10-16 09:02:53','updated_at' => '2022-10-16 09:02:53'),
            array('id' => '27','country_id' => '1','name' => 'مكه','created_at' => '2022-10-16 09:02:59','updated_at' => '2022-10-16 09:02:59'),
            array('id' => '28','country_id' => '1','name' => 'القنفذة','created_at' => '2022-10-16 09:03:07','updated_at' => '2022-10-16 09:03:07'),
            array('id' => '29','country_id' => '1','name' => 'القويعية','created_at' => '2022-10-16 09:03:17','updated_at' => '2022-10-16 09:03:17')
          );
        foreach($cities as $city){
            City::create($city);
        }


        $occupations = array(
            array('id' => '10','name' => 'محامي','type' => 'vendor','created_at' => '2022-10-09 18:54:30','updated_at' => '2022-10-09 18:54:30'),
            array('id' => '11','name' => 'محكم','type' => 'judger','created_at' => '2022-10-09 18:54:41','updated_at' => '2022-10-09 18:54:41')
          );

          foreach($occupations as $o){
            Occupation::create($o);
          }

          $qualifications = array(
            array('id' => '7','name' => 'بكالوريس','type' => 'vendor','created_at' => '2022-10-09 18:57:17','updated_at' => '2022-10-09 18:57:17'),
            array('id' => '8','name' => 'الماجستير','type' => 'vendor','created_at' => '2022-10-09 18:57:25','updated_at' => '2022-10-09 18:57:25'),
            array('id' => '9','name' => 'دكتوراة','type' => 'vendor','created_at' => '2022-10-09 18:57:36','updated_at' => '2022-10-09 18:57:36'),
            array('id' => '10','name' => 'بكالوريس','type' => 'judger','created_at' => '2022-10-09 18:57:43','updated_at' => '2022-10-09 18:57:43'),
            array('id' => '11','name' => 'الماجستير','type' => 'judger','created_at' => '2022-10-09 18:57:55','updated_at' => '2022-10-09 18:57:55'),
            array('id' => '12','name' => 'دكتوراة','type' => 'judger','created_at' => '2022-10-09 18:58:05','updated_at' => '2022-10-09 18:58:05')
          );
          foreach($qualifications as $q){
            Qualification::create($q);
          }

          $questions = array(
            array('id' => '1','name' => 'منصة إيثاق؟','result' => 'منصة إلكترونية تقدم خدمة الوساطة إلكترونية بين العميل ومقدمي الخدمة في مجال الخدمات  القانونية من ( المحامين ) و عرض النزاعات على المحكمين المتواجدين في المنصة','created_at' => '2022-10-09 19:02:19','updated_at' => '2022-10-26 11:57:13'),
            array('id' => '2','name' => 'كيف تعمل منصة إيثاق؟','result' => 'تقدم الخدمة بالوسطاة بين العميل والمحامي في ضمان جودة العمل والتعاملات المالية ؟','created_at' => '2022-10-09 19:06:22','updated_at' => '2022-10-26 11:57:01'),
            array('id' => '3','name' => 'طريقة التسجيل في منصة إيثاق؟','result' => 'المنصة مفتوحة للجميع افراد وشركات ومؤسسات وربط مباشرة مع خدمة التحقق الشخصية نفاذ .','created_at' => '2022-10-09 19:08:27','updated_at' => '2022-10-26 11:56:52')
          );

          foreach($questions as $q){
            Question::create($q);
          }

          $specialties = array(
            array('id' => '7','name' => 'قانون','type' => 'vendor','created_at' => '2022-10-09 18:55:41','updated_at' => '2022-10-09 18:55:41'),
            array('id' => '8','name' => 'شريعة','type' => 'vendor','created_at' => '2022-10-09 18:55:50','updated_at' => '2022-10-09 18:55:50'),
            array('id' => '9','name' => 'انظمة','type' => 'vendor','created_at' => '2022-10-09 18:56:01','updated_at' => '2022-10-09 18:56:01'),
            array('id' => '10','name' => 'قانون','type' => 'judger','created_at' => '2022-10-09 18:56:10','updated_at' => '2022-10-09 18:56:10'),
            array('id' => '11','name' => 'شريعة','type' => 'judger','created_at' => '2022-10-09 18:56:18','updated_at' => '2022-10-09 18:56:18'),
            array('id' => '12','name' => 'انظمة','type' => 'judger','created_at' => '2022-10-09 18:56:28','updated_at' => '2022-10-09 18:56:28')
          );
          foreach($specialties as $s){
            Specialty::create($s);
          }
    }
}
