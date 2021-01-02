<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $permissions = [
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'hotel-list',
            'hotel-create',
            'hotel-edit',
            'hotel-delete'
        ];
        foreach ($permissions as $permission) {
            permission::create(['name'=>'$permission']);
    }

}
}
