<?php

namespace Database\Seeders;

use Domain\Permissions\Enums\RoleEnum;
use Domain\Permissions\Models\Permission;
use Domain\Permissions\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LandlordRolesAndPermissionsTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $admin = RoleEnum::ADMIN->value;
        $inspector = RoleEnum::INSPECTOR->value;
        $support = RoleEnum::SUPPORT->value;
        $secretary = RoleEnum::SECRETARY->value;
        $director = RoleEnum::DIRECTOR->value;
        $teacher = RoleEnum::TEACHER->value;

        $permissionsByRole = [
            $admin => ['*'],
            $inspector => [
                'teams.index', 'teams.show', 'rooms.index', 'rooms.show',
                'users.index', 'users.show', 'classrooms.show'
            ],
            $support => ['teams.*', 'users.*', 'classrooms.*'],
            $secretary => [
                'teams.show', 'users.show', 'rooms.*', 'classrooms.index',
                'classrooms.show', 'classrooms.create', 'classrooms.update'
            ],
            $director => [
                'teams.show', 'users.index', 'users.show', 'rooms.*', 'classrooms.*'
            ],
            $teacher => [
                'teams.show', 'users.show', 'classrooms.show'
            ],
        ];


        $insertPermissions = fn ($role) => collect($permissionsByRole[$role])
            ->map(fn ($name) => (Permission::query()->firstOrCreate(['name' => $name, 'guard_name' => 'web'], ['name' => $name, 'guard_name' => 'web']))->id)
            ->toArray();

        $permissionIdsByRole = [
            $admin => $insertPermissions($admin),
            $inspector => $insertPermissions($inspector),
            $support => $insertPermissions($support),
            $secretary => $insertPermissions($secretary),
            $director => $insertPermissions($director),
            $teacher => $insertPermissions($teacher),
        ];

        foreach ($permissionIdsByRole as $role => $permissionIds) {
            $role = Role::firstOrCreate(['name' => $role], ['name' => $role]);

            DB::table('role_has_permissions')
                ->insert(
                    collect($permissionIds)->map(fn ($id) => [
                        'role_id' => $role->id,
                        'permission_id' => $id
                    ])->toArray()
                );
        }
    }
}
