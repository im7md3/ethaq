<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlusDepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $d=Department::create([
          'name'=>'الاستشارات',
          'parent'=>'1',
        ]);
        $departments = array(
            array('name' => 'الإدارية','parent'=>$d->id,'created_at' => '2022-10-05 13:13:42','updated_at' => '2022-10-05 13:13:42'),
            array('name' => 'العمالية','parent'=>$d->id,'created_at' => '2022-10-05 13:13:42','updated_at' => '2022-10-05 13:13:42'),
            array('name' => 'الجزائية','parent'=>$d->id,'created_at' => '2022-10-05 13:13:42','updated_at' => '2022-10-05 13:13:42'),
            array('name' => 'التأديبية','parent'=>$d->id,'created_at' => '2022-10-05 13:13:42','updated_at' => '2022-10-05 13:13:42'),
            array('name' => 'التنفيذ والحجز على الاموال','parent'=>$d->id,'created_at' => '2022-10-05 13:13:42','updated_at' => '2022-10-05 13:13:42'),
            array('name' => 'الأحوال الشخصية','parent'=>$d->id,'created_at' => '2022-10-05 13:13:42','updated_at' => '2022-10-05 13:13:42'),
            array('name' => 'التأمين','parent'=>$d->id,'created_at' => '2022-10-05 13:13:42','updated_at' => '2022-10-05 13:13:42'),
            array('name' => 'الزكاة والدخل','parent'=>$d->id,'created_at' => '2022-10-05 13:13:42','updated_at' => '2022-10-05 13:13:42'),
            array('name' => 'مصرفية','parent'=>$d->id,'created_at' => '2022-10-05 13:13:42','updated_at' => '2022-10-05 13:13:42'),
            array('name' => 'أوراق تجارية','parent'=>$d->id,'created_at' => '2022-10-05 13:13:42','updated_at' => '2022-10-05 13:13:42'),
            array('name' => 'ملكية فكرية','parent'=>$d->id,'created_at' => '2022-10-05 13:13:42','updated_at' => '2022-10-05 13:13:42'),
            array('name' => 'عقارية','parent'=>$d->id,'created_at' => '2022-10-05 13:13:42','updated_at' => '2022-10-05 13:13:42'),
            array('name' => 'حقوق مالية لأفراد','parent'=>$d->id,'created_at' => '2022-10-05 13:13:42','updated_at' => '2022-10-05 13:13:42'),
            array('name' => 'أجنبية (دولية)','parent'=>$d->id,'created_at' => '2022-10-05 13:13:42','updated_at' => '2022-10-05 13:13:42'),
            array('name' => 'جمركية','parent'=>$d->id,'created_at' => '2022-10-05 13:13:42','updated_at' => '2022-10-05 13:13:42'),
            array('name' => 'السفر والسياحة','parent'=>$d->id,'created_at' => '2022-10-05 13:13:42','updated_at' => '2022-10-05 13:13:42'),
            array('name' => 'رياضية','parent'=>$d->id,'created_at' => '2022-10-05 13:13:42','updated_at' => '2022-10-05 13:13:42'),
            array('name' => 'الجرائم المعلوماتية','parent'=>$d->id,'created_at' => '2023-05-11 08:26:38','updated_at' => '2023-05-11 08:26:38','photo' => NULL)
          );

          foreach($departments as $d){
            Department::create($d);
          }
        
    }
}
