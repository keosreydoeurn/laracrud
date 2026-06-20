<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        // Create a test user if not exists
        $userId = DB::table('users')->insertGetId([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create categories
        $categories = [
            ['name' => 'Technology', 'slug' => 'technology', 'description' => 'Tech news and tutorials', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Lifestyle', 'slug' => 'lifestyle', 'description' => 'Life tips and stories', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Travel', 'slug' => 'travel', 'description' => 'Travel guides and experiences', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Food', 'slug' => 'food', 'description' => 'Recipes and food reviews', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Health', 'slug' => 'health', 'description' => 'Health and wellness tips', 'created_at' => now(), 'updated_at' => now()],
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert($category);
        }

        // Get category IDs
        $categoryIds = DB::table('categories')->pluck('id')->toArray();

        // Create sample posts
        $posts = [
            [
                'title' => 'Getting Started with Laravel 11',
                'content' => 'Laravel 11 is the latest version of the popular PHP framework. It comes with many new features including a simplified application structure, health routing, and streamlined configuration. In this post, we\'ll explore how to get started with Laravel 11 and build your first web application.',
                'category_id' => $categoryIds[0],
            ],
            [
                'title' => '10 Tips for a Healthier Lifestyle',
                'content' => 'Living a healthy lifestyle doesn\'t have to be complicated. Here are 10 simple tips that can make a big difference in your overall health and wellbeing. From staying hydrated to getting enough sleep, these small changes can have a huge impact.',
                'category_id' => $categoryIds[1],
            ],
            [
                'title' => 'Exploring the Temples of Angkor Wat',
                'content' => 'Angkor Wat is one of the most magnificent archaeological sites in the world. Located in Cambodia, this temple complex is a testament to the architectural genius of the Khmer Empire. Join us as we explore the history and beauty of this UNESCO World Heritage site.',
                'category_id' => $categoryIds[2],
            ],
            [
                'title' => 'Delicious Vegan Recipes for Beginners',
                'content' => 'Vegan cooking is easier than you might think! In this post, we share some delicious and simple vegan recipes that even beginners can master. From creamy pasta dishes to flavorful stir-fries, these recipes will make you love plant-based eating.',
                'category_id' => $categoryIds[3],
            ],
            [
                'title' => 'Mastering Vue.js: A Comprehensive Guide',
                'content' => 'Vue.js is a progressive JavaScript framework for building user interfaces. In this comprehensive guide, we\'ll cover everything from the basics to advanced concepts like Vuex and Vue Router. Perfect for developers of all skill levels.',
                'category_id' => $categoryIds[0],
            ],
            [
                'title' => 'The Ultimate Travel Guide to Japan',
                'content' => 'Japan is a country that seamlessly blends ancient traditions with modern technology. From the bustling streets of Tokyo to the tranquil temples of Kyoto, this ultimate travel guide covers everything you need to know for an unforgettable trip to the Land of the Rising Sun.',
                'category_id' => $categoryIds[2],
            ],
        ];

        foreach ($posts as $post) {
            DB::table('posts')->insert([
                'user_id' => $userId,
                'category_id' => $post['category_id'],
                'title' => $post['title'],
                'slug' => Str::slug($post['title']),
                'content' => $post['content'],
                'is_published' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Create a sample comment
        $postId = DB::table('posts')->first()->id;
        DB::table('comments')->insert([
            'post_id' => $postId,
            'user_id' => $userId,
            'content' => 'Great post! Very informative and well-written.',
            'is_approved' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->command->info('Blog seeded successfully!');
        $this->command->info('User: admin@example.com / password');
    }
}
