<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        DB::table('role_user')->truncate();

        $superadminRole = Role::where('acc_type', 'superadmin')->first();
        $adminRole = Role::where('acc_type', 'admin')->first();
        $userRole = Role::where('acc_type', 'user')->first();

        $superadmin = User::create([
            'parent_id' => 0,
            'name' => 'Superadmin',
            'email' => 'superadmin@superadmin.com',
            'phone' => '9876543210',
            'designation' => 'Superadmin',
            'department' => 'HeadAdmin',
            'city' => 'Nagpur',
            'state' => 'Maharashtra',
            'country' => 'India',
            'pin' => '440010',
            'acc_type' => 'superadmin',
            'password' => Hash::make('superadmin@superadmin.com'),
            'status' => '1'
        ]);
        $admin = User::create([
            'parent_id' => 1,
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'phone' => '1234567890',
            'designation' => 'Professor',
            'department' => 'Science',
            'city' => 'Nagpur',
            'state' => 'Maharashtra',
            'country' => 'India',
            'pin' => '440010',
            'acc_type' => 'admin',
            'password' => Hash::make('admin@admin.com'),
            'status' => '1'
        ]);
        $user = User::create([
            'parent_id' => 2,
            'name' => 'User',
            'email' => 'user@user.com',
            'phone' => '1234567890',
            'designation' => 'Professor',
            'department' => 'Science',
            'city' => 'Nagpur',
            'state' => 'Maharashtra',
            'country' => 'India',
            'pin' => '440010',
            'acc_type' => 'user',
            'password' => Hash::make('user@user.com'),
            'status' => '0'
        ]);

        $superadmin->roles()->attach($superadminRole);
        $admin->roles()->attach($adminRole);
        $user->roles()->attach($userRole);
    }
}
