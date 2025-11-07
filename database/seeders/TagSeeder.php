<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            ['name' => 'Premium', 'color' => '#FFD700', 'description' => 'Premium user access'],
            ['name' => 'Verified', 'color' => '#00FF00', 'description' => 'User has been verified'],
            ['name' => 'Inactive', 'color' => '#FF0000', 'description' => 'User is inactive'],
        ];

        foreach ($tags as $tagData) {
            Tag::create($tagData);
        }

        // Assign random tags to users
        $users = User::where('is_admin', false)->get();
        $allTags = Tag::all();

        foreach ($users as $user) {
            $randomTags = $allTags->random(rand(1, 2));
            foreach ($randomTags as $tag) {
                $user->tags()->attach($tag->id, ['assigned_at' => now()]);
            }
        }
    }


}
