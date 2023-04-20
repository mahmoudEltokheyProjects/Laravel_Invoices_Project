<?php
namespace Database\Seeders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
class PermissionTableSeeder extends Seeder
{
    public function run()
    {
        //Permissions
        $permissions = [

            'صلاحيات المستخدمين','المستخدمين','قائمة المستخدمين',

            'المنتجات','الاقسام',

            'اضافة مستخدم','تعديل مستخدم','حذف مستخدم',

            'اضافة صلاحية','تعديل صلاحية','حذف صلاحية','عرض صلاحية',

            'اضافة منتج','تعديل منتج','حذف منتج',

            'اضافة قسم','تعديل قسم','حذف قسم'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
