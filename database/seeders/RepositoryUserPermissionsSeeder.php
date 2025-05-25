<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RepositoryUserPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userPermissions = [
            ['PERMISSION_id' => 1, 'Repository_User_id' => 1],
            ['PERMISSION_id' => 5, 'Repository_User_id' => 1],
            ['PERMISSION_id' => 3, 'Repository_User_id' => 2],
            ['PERMISSION_id' => 7, 'Repository_User_id' => 3],
            ['PERMISSION_id' => 12, 'Repository_User_id' => 4],
            ['PERMISSION_id' => 18, 'Repository_User_id' => 5],
            ['PERMISSION_id' => 1, 'Repository_User_id' => 2],
            ['PERMISSION_id' => 5, 'Repository_User_id' => 2],
            ['PERMISSION_id' => 3, 'Repository_User_id' => 3],
            ['PERMISSION_id' => 7, 'Repository_User_id' => 4],
            ['PERMISSION_id' => 12, 'Repository_User_id' => 5],
            ['PERMISSION_id' => 18, 'Repository_User_id' => 6],
            ['PERMISSION_id' => 1, 'Repository_User_id' => 7],
            ['PERMISSION_id' => 5, 'Repository_User_id' => 3],
            ['PERMISSION_id' => 3, 'Repository_User_id' => 3],
            ['PERMISSION_id' => 7, 'Repository_User_id' => 4],
            ['PERMISSION_id' => 12, 'Repository_User_id' => 5],
            ['PERMISSION_id' => 18, 'Repository_User_id' => 6],
        ];

        collect($userPermissions)->chunk(10)->each(function ($chunk) {
            DB::table('repository_user_permissions')->insert($chunk->toArray());
        });
    }
}
