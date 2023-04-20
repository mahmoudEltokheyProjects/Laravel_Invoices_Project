<?php
namespace Database\Seeders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class CreateAdminUserSeeder extends Seeder
{
    public function run()
    {
        //Admin Seeder
        $user = User::create([
            'name'       => 'Main Admin',
            'email'      => 'mainAdmin@gmail.com',
            'password'   => bcrypt('123456') ,
            'roles_name' => ['main_admin'],
            'Status'     => 'مفعل'
        ]);
        // role
        $role = Role::create(['name' => 'main_admin']);
        $permissions = Permission::pluck('id','id')->all();
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);
    }
}
