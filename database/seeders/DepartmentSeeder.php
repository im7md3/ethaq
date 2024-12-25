<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    Department::truncate();

    $departments = array(
      array('id' => '1','name' => 'المحاماة','parent' => NULL,'created_at' => '2022-10-05 13:13:42','updated_at' => '2022-10-05 13:13:42','photo' => NULL),
      array('id' => '2','name' => 'التحليل والدراسات القانونية','parent' => '1','created_at' => '2022-10-05 13:13:42','updated_at' => '2023-05-11 08:12:36','photo' => 'departments/1683781956law 1.png'),
      array('id' => '3','name' => 'الترافع في قضية','parent' => '1','created_at' => '2022-10-05 13:13:42','updated_at' => '2023-05-11 08:11:19','photo' => 'departments/1683781879laws 1.png'),
      array('id' => '4','name' => 'صياغة عقد','parent' => '1','created_at' => '2022-10-05 13:13:42','updated_at' => '2023-05-11 08:11:30','photo' => 'departments/1683781890contract 1.png'),
      array('id' => '5','name' => 'الإدارية','parent' => '2','created_at' => '2022-10-05 13:13:42','updated_at' => '2022-10-05 13:13:42','photo' => NULL),
      array('id' => '6','name' => 'العمالية','parent' => '2','created_at' => '2022-10-05 13:13:42','updated_at' => '2022-10-05 13:13:42','photo' => NULL),
      array('id' => '7','name' => 'الجزائية','parent' => '2','created_at' => '2022-10-05 13:13:42','updated_at' => '2022-10-05 13:13:42','photo' => NULL),
      array('id' => '8','name' => 'التأديبية','parent' => '2','created_at' => '2022-10-05 13:13:42','updated_at' => '2022-10-05 13:13:42','photo' => NULL),
      array('id' => '9','name' => 'التنفيذ والحجز على الاموال','parent' => '2','created_at' => '2022-10-05 13:13:42','updated_at' => '2022-10-05 13:13:42','photo' => NULL),
      array('id' => '10','name' => 'الأحوال الشخصية','parent' => '2','created_at' => '2022-10-05 13:13:42','updated_at' => '2022-10-05 13:13:42','photo' => NULL),
      array('id' => '11','name' => 'التأمين','parent' => '2','created_at' => '2022-10-05 13:13:42','updated_at' => '2022-10-05 13:13:42','photo' => NULL),
      array('id' => '12','name' => 'الزكاة والدخل','parent' => '2','created_at' => '2022-10-05 13:13:42','updated_at' => '2022-10-05 13:13:42','photo' => NULL),
      array('id' => '13','name' => 'مصرفية','parent' => '2','created_at' => '2022-10-05 13:13:42','updated_at' => '2022-10-05 13:13:42','photo' => NULL),
      array('id' => '14','name' => 'أوراق تجارية','parent' => '2','created_at' => '2022-10-05 13:13:42','updated_at' => '2022-10-05 13:13:42','photo' => NULL),
      array('id' => '15','name' => 'ملكية فكرية','parent' => '2','created_at' => '2022-10-05 13:13:42','updated_at' => '2022-10-05 13:13:42','photo' => NULL),
      array('id' => '16','name' => 'عقارية','parent' => '2','created_at' => '2022-10-05 13:13:42','updated_at' => '2022-10-05 13:13:42','photo' => NULL),
      array('id' => '17','name' => 'حقوق مالية لأفراد','parent' => '2','created_at' => '2022-10-05 13:13:42','updated_at' => '2022-10-05 13:13:42','photo' => NULL),
      array('id' => '18','name' => 'أجنبية (دولية)','parent' => '2','created_at' => '2022-10-05 13:13:42','updated_at' => '2022-10-05 13:13:42','photo' => NULL),
      array('id' => '19','name' => 'جمركية','parent' => '2','created_at' => '2022-10-05 13:13:42','updated_at' => '2022-10-05 13:13:42','photo' => NULL),
      array('id' => '20','name' => 'السفر والسياحة','parent' => '2','created_at' => '2022-10-05 13:13:42','updated_at' => '2022-10-05 13:13:42','photo' => NULL),
      array('id' => '21','name' => 'رياضية','parent' => '2','created_at' => '2022-10-05 13:13:42','updated_at' => '2022-10-05 13:13:42','photo' => NULL),
      array('id' => '22','name' => 'الإدارية','parent' => '3','created_at' => '2022-10-05 13:13:42','updated_at' => '2022-10-05 13:13:42','photo' => NULL),
      array('id' => '23','name' => 'العمالية','parent' => '3','created_at' => '2022-10-05 13:13:42','updated_at' => '2022-10-05 13:13:42','photo' => NULL),
      array('id' => '24','name' => 'الجزائية','parent' => '3','created_at' => '2022-10-05 13:13:42','updated_at' => '2022-10-05 13:13:42','photo' => NULL),
      array('id' => '25','name' => 'التأديبية','parent' => '3','created_at' => '2022-10-05 13:13:42','updated_at' => '2022-10-05 13:13:42','photo' => NULL),
      array('id' => '26','name' => 'التنفيذ والحجز على الاموال','parent' => '3','created_at' => '2022-10-05 13:13:42','updated_at' => '2022-10-05 13:13:42','photo' => NULL),
      array('id' => '27','name' => 'الأحوال الشخصية','parent' => '3','created_at' => '2022-10-05 13:13:42','updated_at' => '2022-10-05 13:13:42','photo' => NULL),
      array('id' => '28','name' => 'التأمين','parent' => '3','created_at' => '2022-10-05 13:13:42','updated_at' => '2022-10-05 13:13:42','photo' => NULL),
      array('id' => '29','name' => 'الزكاة والدخل','parent' => '3','created_at' => '2022-10-05 13:13:42','updated_at' => '2022-10-05 13:13:42','photo' => NULL),
      array('id' => '30','name' => 'مصرفية','parent' => '3','created_at' => '2022-10-05 13:13:42','updated_at' => '2022-10-05 13:13:42','photo' => NULL),
      array('id' => '31','name' => 'أوراق تجارية','parent' => '3','created_at' => '2022-10-05 13:13:42','updated_at' => '2022-10-05 13:13:42','photo' => NULL),
      array('id' => '32','name' => 'ملكية فكرية','parent' => '3','created_at' => '2022-10-05 13:13:42','updated_at' => '2022-10-05 13:13:42','photo' => NULL),
      array('id' => '33','name' => 'عقارية','parent' => '3','created_at' => '2022-10-05 13:13:42','updated_at' => '2022-10-05 13:13:42','photo' => NULL),
      array('id' => '34','name' => 'حقوق مالية لأفراد','parent' => '3','created_at' => '2022-10-05 13:13:42','updated_at' => '2022-10-05 13:13:42','photo' => NULL),
      array('id' => '35','name' => 'أجنبية (دولية)','parent' => '3','created_at' => '2022-10-05 13:13:42','updated_at' => '2022-10-05 13:13:42','photo' => NULL),
      array('id' => '36','name' => 'جمركية','parent' => '3','created_at' => '2022-10-05 13:13:42','updated_at' => '2022-10-05 13:13:42','photo' => NULL),
      array('id' => '37','name' => 'السفر والسياحة','parent' => '3','created_at' => '2022-10-05 13:13:42','updated_at' => '2022-10-05 13:13:42','photo' => NULL),
      array('id' => '38','name' => 'رياضية','parent' => '3','created_at' => '2022-10-05 13:13:42','updated_at' => '2022-10-05 13:13:42','photo' => NULL),
      array('id' => '39','name' => 'الإدارية','parent' => '4','created_at' => '2022-10-05 13:13:42','updated_at' => '2022-10-05 13:13:42','photo' => NULL),
      array('id' => '40','name' => 'العمالية','parent' => '4','created_at' => '2022-10-05 13:13:42','updated_at' => '2022-10-05 13:13:42','photo' => NULL),
      array('id' => '41','name' => 'الجزائية','parent' => '4','created_at' => '2022-10-05 13:13:42','updated_at' => '2022-10-05 13:13:42','photo' => NULL),
      array('id' => '42','name' => 'التأديبية','parent' => '4','created_at' => '2022-10-05 13:13:42','updated_at' => '2022-10-05 13:13:42','photo' => NULL),
      array('id' => '43','name' => 'التنفيذ والحجز على الاموال','parent' => '4','created_at' => '2022-10-05 13:13:42','updated_at' => '2022-10-05 13:13:42','photo' => NULL),
      array('id' => '44','name' => 'الأحوال الشخصية','parent' => '4','created_at' => '2022-10-05 13:13:42','updated_at' => '2022-10-05 13:13:42','photo' => NULL),
      array('id' => '45','name' => 'التأمين','parent' => '4','created_at' => '2022-10-05 13:13:42','updated_at' => '2022-10-05 13:13:42','photo' => NULL),
      array('id' => '46','name' => 'الزكاة والدخل','parent' => '4','created_at' => '2022-10-05 13:13:42','updated_at' => '2022-10-05 13:13:42','photo' => NULL),
      array('id' => '47','name' => 'مصرفية','parent' => '4','created_at' => '2022-10-05 13:13:42','updated_at' => '2022-10-05 13:13:42','photo' => NULL),
      array('id' => '48','name' => 'أوراق تجارية','parent' => '4','created_at' => '2022-10-05 13:13:42','updated_at' => '2022-10-05 13:13:42','photo' => NULL),
      array('id' => '49','name' => 'ملكية فكرية','parent' => '4','created_at' => '2022-10-05 13:13:42','updated_at' => '2022-10-05 13:13:42','photo' => NULL),
      array('id' => '50','name' => 'عقارية','parent' => '4','created_at' => '2022-10-05 13:13:42','updated_at' => '2022-10-05 13:13:42','photo' => NULL),
      array('id' => '51','name' => 'حقوق مالية لأفراد','parent' => '4','created_at' => '2022-10-05 13:13:42','updated_at' => '2022-10-05 13:13:42','photo' => NULL),
      array('id' => '52','name' => 'أجنبية (دولية)','parent' => '4','created_at' => '2022-10-05 13:13:42','updated_at' => '2022-10-05 13:13:42','photo' => NULL),
      array('id' => '53','name' => 'جمركية','parent' => '4','created_at' => '2022-10-05 13:13:42','updated_at' => '2022-10-05 13:13:42','photo' => NULL),
      array('id' => '54','name' => 'السفر والسياحة','parent' => '4','created_at' => '2022-10-05 13:13:42','updated_at' => '2022-10-05 13:13:42','photo' => NULL),
      array('id' => '55','name' => 'رياضية','parent' => '4','created_at' => '2022-10-05 13:13:42','updated_at' => '2022-10-05 13:13:42','photo' => NULL),
      array('id' => '58','name' => 'الجرائم المعلوماتية','parent' => '2','created_at' => '2023-05-10 02:20:40','updated_at' => '2023-05-10 02:20:40','photo' => NULL),
      array('id' => '59','name' => 'الجرائم المعلوماتية','parent' => '3','created_at' => '2023-05-10 02:20:50','updated_at' => '2023-05-10 02:20:50','photo' => NULL),
      array('id' => '60','name' => 'الجرائم المعلوماتية','parent' => '4','created_at' => '2023-05-10 02:21:00','updated_at' => '2023-05-10 02:21:00','photo' => NULL),
      array('id' => '61','name' => 'صحيفة الدعوى','parent' => '1','created_at' => '2023-05-10 02:22:24','updated_at' => '2023-05-11 08:10:47','photo' => 'departments/1683781847document 1.png'),
      array('id' => '62','name' => 'مذكرة جوابية','parent' => '1','created_at' => '2023-05-10 02:24:56','updated_at' => '2023-05-11 08:10:01','photo' => 'departments/1683781801law-book 1.png'),
      array('id' => '63','name' => 'اعداد ومراجعة الوثائق','parent' => '1','created_at' => '2023-05-10 02:26:38','updated_at' => '2023-05-11 08:09:44','photo' => 'departments/1683781784documentation 1.png'),
      array('id' => '64','name' => 'التوثيق والتصديق للمستندات','parent' => '1','created_at' => '2023-05-10 02:27:15','updated_at' => '2023-05-11 08:09:35','photo' => 'departments/1683781775document (1) 1.png'),
      array('id' => '65','name' => 'الوكلات والتفويض','parent' => '1','created_at' => '2023-05-10 02:27:39','updated_at' => '2023-05-11 08:09:22','photo' => 'departments/1683781762compliant 1.png'),
      array('id' => '66','name' => 'الإدارية','parent' => '4','created_at' => '2023-05-10 02:32:31','updated_at' => '2023-05-10 02:32:31','photo' => NULL),
      array('id' => '67','name' => 'العمالية','parent' => '4','created_at' => '2023-05-10 02:32:47','updated_at' => '2023-05-10 02:32:47','photo' => NULL),
      array('id' => '68','name' => 'الجزائية','parent' => '4','created_at' => '2023-05-10 02:33:01','updated_at' => '2023-05-10 02:33:01','photo' => NULL),
      array('id' => '69','name' => 'التأديبية','parent' => '4','created_at' => '2023-05-10 02:33:13','updated_at' => '2023-05-10 02:33:13','photo' => NULL),
      array('id' => '70','name' => 'التنفيذ والحجز على الاموال','parent' => '4','created_at' => '2023-05-10 02:33:24','updated_at' => '2023-05-10 02:33:24','photo' => NULL),
      array('id' => '71','name' => 'الأحوال الشخصية','parent' => '4','created_at' => '2023-05-10 02:33:34','updated_at' => '2023-05-10 02:33:34','photo' => NULL),
      array('id' => '72','name' => 'التأمين','parent' => '4','created_at' => '2023-05-10 02:33:48','updated_at' => '2023-05-10 02:33:48','photo' => NULL),
      array('id' => '73','name' => 'الزكاة والدخل','parent' => '4','created_at' => '2023-05-10 02:33:57','updated_at' => '2023-05-10 02:33:57','photo' => NULL),
      array('id' => '74','name' => 'مصرفية','parent' => '4','created_at' => '2023-05-10 02:34:06','updated_at' => '2023-05-10 02:34:06','photo' => NULL),
      array('id' => '75','name' => 'اوراق تجارية','parent' => '4','created_at' => '2023-05-10 02:34:16','updated_at' => '2023-05-10 02:34:16','photo' => NULL),
      array('id' => '76','name' => 'ملكية فكرية','parent' => '4','created_at' => '2023-05-10 02:34:25','updated_at' => '2023-05-10 02:34:25','photo' => NULL),
      array('id' => '77','name' => 'عقارية','parent' => '4','created_at' => '2023-05-10 02:34:37','updated_at' => '2023-05-10 02:34:37','photo' => NULL),
      array('id' => '78','name' => 'حقوق مالية للأفراد','parent' => '4','created_at' => '2023-05-10 02:35:00','updated_at' => '2023-05-10 02:35:00','photo' => NULL),
      array('id' => '79','name' => 'أجنبية (دولية )','parent' => '4','created_at' => '2023-05-10 02:35:09','updated_at' => '2023-05-10 02:35:09','photo' => NULL),
      array('id' => '80','name' => 'جمركية','parent' => '4','created_at' => '2023-05-10 02:35:18','updated_at' => '2023-05-10 02:35:18','photo' => NULL),
      array('id' => '81','name' => 'السفر والسياحه','parent' => '4','created_at' => '2023-05-10 02:35:28','updated_at' => '2023-05-10 02:35:28','photo' => NULL),
      array('id' => '82','name' => 'رياضه','parent' => '4','created_at' => '2023-05-10 02:35:40','updated_at' => '2023-05-10 02:35:40','photo' => NULL),
      array('id' => '83','name' => 'الجرائم المعلوماتية','parent' => '61','created_at' => '2023-05-10 02:37:08','updated_at' => '2023-05-10 02:37:08','photo' => NULL),
      array('id' => '84','name' => 'الإدارية','parent' => '61','created_at' => '2023-05-10 02:37:32','updated_at' => '2023-05-10 02:37:32','photo' => NULL),
      array('id' => '85','name' => 'العمالية','parent' => '61','created_at' => '2023-05-10 02:38:00','updated_at' => '2023-05-10 02:38:00','photo' => NULL),
      array('id' => '86','name' => 'الجزائية','parent' => '61','created_at' => '2023-05-10 02:38:16','updated_at' => '2023-05-10 02:38:16','photo' => NULL),
      array('id' => '87','name' => 'التأديبية','parent' => '61','created_at' => '2023-05-10 02:38:29','updated_at' => '2023-05-10 02:38:29','photo' => NULL),
      array('id' => '88','name' => 'التنفيذ والحجز على الاموال','parent' => '61','created_at' => '2023-05-10 02:38:45','updated_at' => '2023-05-10 02:38:45','photo' => NULL),
      array('id' => '89','name' => 'الأحوال الشخصية','parent' => '61','created_at' => '2023-05-10 02:39:01','updated_at' => '2023-05-10 02:39:01','photo' => NULL),
      array('id' => '90','name' => 'التأمين','parent' => '61','created_at' => '2023-05-10 02:39:15','updated_at' => '2023-05-10 02:39:15','photo' => NULL),
      array('id' => '91','name' => 'الزكاة والدخل','parent' => '61','created_at' => '2023-05-10 02:39:28','updated_at' => '2023-05-10 02:39:28','photo' => NULL),
      array('id' => '92','name' => 'مصرفية','parent' => '61','created_at' => '2023-05-10 02:39:41','updated_at' => '2023-05-10 02:39:41','photo' => NULL),
      array('id' => '93','name' => 'اوراق تجارية','parent' => '61','created_at' => '2023-05-10 02:39:55','updated_at' => '2023-05-10 02:39:55','photo' => NULL),
      array('id' => '94','name' => 'ملكية فكرية','parent' => '61','created_at' => '2023-05-10 02:40:06','updated_at' => '2023-05-10 02:40:06','photo' => NULL),
      array('id' => '95','name' => 'عقارية','parent' => '61','created_at' => '2023-05-10 02:40:20','updated_at' => '2023-05-10 02:40:20','photo' => NULL),
      array('id' => '96','name' => 'حقوق مالية للأفراد','parent' => '61','created_at' => '2023-05-10 02:40:33','updated_at' => '2023-05-10 02:40:33','photo' => NULL),
      array('id' => '97','name' => 'أجنبية (دولية )','parent' => '61','created_at' => '2023-05-10 02:41:05','updated_at' => '2023-05-10 02:41:05','photo' => NULL),
      array('id' => '98','name' => 'جمركية','parent' => '61','created_at' => '2023-05-10 02:41:25','updated_at' => '2023-05-10 02:41:25','photo' => NULL),
      array('id' => '99','name' => 'السفر والسياحه','parent' => '61','created_at' => '2023-05-10 02:41:40','updated_at' => '2023-05-10 02:41:40','photo' => NULL),
      array('id' => '100','name' => 'رياضه','parent' => '61','created_at' => '2023-05-10 02:41:56','updated_at' => '2023-05-10 02:41:56','photo' => NULL),
      array('id' => '101','name' => 'الأدارية','parent' => '62','created_at' => '2023-05-11 08:22:43','updated_at' => '2023-05-11 08:22:43','photo' => NULL),
      array('id' => '102','name' => 'العمالية','parent' => '62','created_at' => '2023-05-11 08:23:10','updated_at' => '2023-05-11 08:23:10','photo' => NULL),
      array('id' => '103','name' => 'الجزائية','parent' => '62','created_at' => '2023-05-11 08:23:25','updated_at' => '2023-05-11 08:23:25','photo' => NULL),
      array('id' => '104','name' => 'التأديبية','parent' => '62','created_at' => '2023-05-11 08:23:37','updated_at' => '2023-05-11 08:23:37','photo' => NULL),
      array('id' => '105','name' => 'التنفيذ والحجز على الاموال','parent' => '62','created_at' => '2023-05-11 08:23:51','updated_at' => '2023-05-11 08:23:51','photo' => NULL),
      array('id' => '106','name' => 'الأحوال الشخصية','parent' => '62','created_at' => '2023-05-11 08:24:04','updated_at' => '2023-05-11 08:24:04','photo' => NULL),
      array('id' => '107','name' => 'التأمين','parent' => '62','created_at' => '2023-05-11 08:24:17','updated_at' => '2023-05-11 08:24:17','photo' => NULL),
      array('id' => '108','name' => 'الزكاة والدخل','parent' => '62','created_at' => '2023-05-11 08:24:28','updated_at' => '2023-05-11 08:24:28','photo' => NULL),
      array('id' => '109','name' => 'مصرفية','parent' => '62','created_at' => '2023-05-11 08:24:39','updated_at' => '2023-05-11 08:24:39','photo' => NULL),
      array('id' => '110','name' => 'اوراق تجارية','parent' => '62','created_at' => '2023-05-11 08:24:49','updated_at' => '2023-05-11 08:24:49','photo' => NULL),
      array('id' => '111','name' => 'ملكية فكرية','parent' => '62','created_at' => '2023-05-11 08:25:00','updated_at' => '2023-05-11 08:25:00','photo' => NULL),
      array('id' => '112','name' => 'عقارية','parent' => '62','created_at' => '2023-05-11 08:25:11','updated_at' => '2023-05-11 08:25:11','photo' => NULL),
      array('id' => '113','name' => 'حقوق مالية للأفراد','parent' => '62','created_at' => '2023-05-11 08:25:26','updated_at' => '2023-05-11 08:25:26','photo' => NULL),
      array('id' => '114','name' => 'اجنبية (دولية)','parent' => '62','created_at' => '2023-05-11 08:25:39','updated_at' => '2023-05-11 08:25:39','photo' => NULL),
      array('id' => '115','name' => 'جمركية','parent' => '62','created_at' => '2023-05-11 08:25:59','updated_at' => '2023-05-11 08:25:59','photo' => NULL),
      array('id' => '116','name' => 'السفر والسياحة','parent' => '62','created_at' => '2023-05-11 08:26:15','updated_at' => '2023-05-11 08:26:15','photo' => NULL),
      array('id' => '117','name' => 'رياضة','parent' => '62','created_at' => '2023-05-11 08:26:29','updated_at' => '2023-05-11 08:26:29','photo' => NULL),
      array('id' => '118','name' => 'الجرائم المعلوماتية','parent' => '62','created_at' => '2023-05-11 08:26:38','updated_at' => '2023-05-11 08:26:38','photo' => NULL)
    );

    foreach ($departments as $d) {
      Department::create($d);
    }

    DB::statement('SET FOREIGN_KEY_CHECKS=1;');
  }
}
