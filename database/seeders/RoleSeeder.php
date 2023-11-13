<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $student = Role::create(['name' => 'student']);

        $updateStudent = Permission::create(['name' => 'update.student']);
        $deleteStudent = Permission::create(['name' => 'delete.student']);
        
        $student -> syncPermissions([$deleteStudent, $updateStudent]);
        //$admin -> syncPermissions([$deleteStudent, $updateStudent]);
    }
}
