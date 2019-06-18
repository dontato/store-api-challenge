<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Exceptions\PermissionAlreadyExists;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        collect(config('permissions'))->each(function ($permission) {
            $this->createPermission($permission);
        });
    }

    /**
     * Create a permission if it doesn't exist
     * @param  string $name
     * @param  string $guard
     * @return void
     */
    public function createPermission($name, $guard = 'api')
    {
        try {
            $this->command
                ->call('permission:create-permission', compact('name', 'guard'));
        } catch (PermissionAlreadyExists $e) {
            $this->command->info($e->getMessage());
        }
    }
}
