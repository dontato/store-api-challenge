<?php

namespace Tests\Unit;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class PermissionSeedersTest extends TestCase
{
    /**
     * Test permissions table seeder.
     * @return void
     */
    public function testPermissionsSeed()
    {
        $this->artisan('db:seed', [
            '--class' => 'PermissionsTableSeeder',
        ]);

        collect(config('permissions'))->each(function ($name) {
            $this->assertTrue(Permission::findByName($name, 'api')->exists);
        });
    }
    /**
     * Test roles table seeder.
     * @return void
     */
    public function testRolesSeed()
    {
        $this->artisan('db:seed', [
            '--class' => 'RolesTableSeeder',
        ]);

        $role = Role::findByName('admin', 'api');

        $this->assertInstanceOf(Role::class, $role);

        collect(config('permissions'))
            ->each(function ($permission) use ($role) {
                $this->assertTrue($role->hasPermissionTo($permission));
            });
    }
}
