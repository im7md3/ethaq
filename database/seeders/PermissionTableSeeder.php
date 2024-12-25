<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $models=array_keys(config()->get('permissionsname.models'));
        $maps=config()->get('permissionsname.map');
        $permissions =[];
        foreach($models as $model){
            foreach(config()->get('permissionsname.models.'.$model) as $map){
                $permissions[]=$map.'_'.$model;
            }
        }

        Permission::truncate();
        Role::truncate();
        $admin_role = Role::create(['name' => 'مدير عام']);
        $role2 = Role::create(['name' => 'المحاسبين']);
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
            $admin_role->givePermissionTo($permission);
        }
        $admin=User::find(1);
        $admin2=User::find(2);
        $admin->syncRoles($admin_role);
        $admin2->syncRoles($role2);


        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
