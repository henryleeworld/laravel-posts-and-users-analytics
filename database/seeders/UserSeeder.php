<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeders.
     */
    public function run(): void
    {
        User::create([
            'name' => __('Admin'),
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'role_id' => 1,
            'status_id' => 1,
            'bio' => __('System administrator with full access to manage the blog platform.'),
            'avatar' => 'https://ui-avatars.com/api/?name=Admin+User&background=3b82f6&color=ffffff',
            'last_login_at' => now()->subHours(2),
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => __('Editor'),
            'email' => 'editor@admin.com',
            'password' => Hash::make('password'),
            'role_id' => 2,
            'status_id' => 1,
            'bio' => __('Senior content editor responsible for reviewing and managing published content.'),
            'avatar' => 'https://ui-avatars.com/api/?name=Jane+Editor&background=10b981&color=ffffff',
            'last_login_at' => now()->subDays(1),
            'email_verified_at' => now(),
        ]);

        $authors = [
            [
                'name' => __('Developer'),
                'email' => 'developer@admin.com',
                'bio' => __('Full-stack developer passionate about Laravel and modern web technologies.'),
                'avatar' => 'https://ui-avatars.com/api/?name=John+Developer&background=8b5cf6&color=ffffff',
            ],
            [
                'name' => __('Tech writer'),
                'email' => 'tech-writer@admin.com',
                'bio' => __('Technical writer specializing in tutorials and documentation.'),
                'avatar' => 'https://ui-avatars.com/api/?name=Sarah+Writer&background=f59e0b&color=ffffff',
            ],
            [
                'name' => __('Designer'),
                'email' => 'designer@admin.com',
                'bio' => __('UI/UX designer with a focus on creating beautiful and functional interfaces.'),
                'avatar' => 'https://ui-avatars.com/api/?name=Mike+Designer&background=ef4444&color=ffffff',
            ],
        ];

        foreach ($authors as $author) {
            User::create([
                'name' => $author['name'],
                'email' => $author['email'],
                'password' => Hash::make('password'),
                'role_id' => 3,
                'status_id' => 1,
                'bio' => $author['bio'],
                'avatar' => $author['avatar'],
                'last_login_at' => fake()->dateTimeBetween('-7 days', 'now'),
                'email_verified_at' => now(),
            ]);
        }

        User::create([
            'name' => __('Inactive user'),
            'email' => 'inactive@admin.com',
            'password' => Hash::make('password'),
            'role_id' => 3,
            'status_id' => 2,
            'bio' => __('This user account has been deactivated.'),
            'last_login_at' => now()->subMonths(2),
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => __('Pending user'),
            'email' => 'pending@admin.com',
            'password' => Hash::make('password'),
            'role_id' => 3,
            'status_id' => 3,
            'bio' => __('New user account awaiting approval.'),
            'last_login_at' => null,
            'email_verified_at' => null,
        ]);

        User::factory(25)->create();
    }
}
