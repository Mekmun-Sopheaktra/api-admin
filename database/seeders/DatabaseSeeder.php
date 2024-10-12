<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            CategoriesSeeder::class,
            BannerSeeder::class,
            ProductSeeder::class,
            UserSeeder::class,
            NotificationSeeder::class,
            Tags::class,
            PrioritySeeder::class,
        ]);

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@shop.com',
            'password' => 'admin_admin',
            'is_superuser' => 1,
            'is_staff' => 0,
        ]);

        //create staff account
        User::factory()->create([
            'name' => 'staff',
            'email' => 'staff@shop.com',
            'password' => 'staff_staff',
            'is_superuser' => 0,
            'is_staff' => 1,
        ]);
    }
}
