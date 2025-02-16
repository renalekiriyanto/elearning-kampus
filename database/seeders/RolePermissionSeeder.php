<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            // Courses
            [
                'name' => 'create-courses'
            ],
            [
                'name' => 'read-courses'
            ],
            [
                'name' => 'update-courses'
            ],
            [
                'name' => 'delete-courses'
            ],
            [
                'name' => 'register-courses'
            ],
            // Materials
            [
                'name' => 'create-materials'
            ],
            [
                'name' => 'read-materials'
            ],
            [
                'name' => 'update-materials'
            ],
            [
                'name' => 'delete-materials'
            ],
            [
                'name' => 'upload-materials'
            ],
            [
                'name' => 'download-materials'
            ],
            // Assignments
            [
                'name' => 'create-assignments'
            ],
            [
                'name' => 'read-assignments'
            ],
            [
                'name' => 'update-assignments'
            ],
            [
                'name' => 'delete-assignments'
            ],
            // Submission
            [
                'name' => 'create-submission'
            ],
            [
                'name' => 'read-submission'
            ],
            [
                'name' => 'update-submission'
            ],
            [
                'name' => 'delete-submission'
            ],
            [
                'name' => 'upload-submission'
            ],
            [
                'name' => 'rate-submission'
            ],
            // Discussion
            [
                'name' => 'create-discussion'
            ],
            [
                'name' => 'read-discussion'
            ],
            [
                'name' => 'update-discussion'
            ],
            [
                'name' => 'delete-discussion'
            ],
            [
                'name' => 'reply-discussion'
            ],
        ];

        foreach($data as $item){
            $permission = Permission::create($item);
        }

        $data_role = [
            [
                'name' => 'mahasiswa'
            ],
            [
                'name' => 'dosen'
            ]
        ];

        foreach($data_role as $item){
            $role = Role::create($item);
        }

        $role_dosen = Role::findByName('dosen');
        $role_dosen->givePermissionTo(['read-courses', 'create-courses', 'update-courses', 'delete-courses', 'read-materials', 'create-materials', 'upload-materials', 'read-assignments', 'create-assignments', 'delete-assignments', 'read-submission', 'rate-submission', 'read-discussion', 'create-discussion', 'update-discussion', 'delete-discussion', 'reply-discussion']);

        $role_mahasiswa = Role::findByName('mahasiswa');
        $role_mahasiswa->givePermissionTo(['read-courses', 'register-courses', 'read-materials', 'download-materials', 'read-assignments', 'read-submission', 'upload-submission', 'read-discussion', 'create-discussion', 'update-discussion', 'delete-discussion', 'reply-discussion']);
    }
}
