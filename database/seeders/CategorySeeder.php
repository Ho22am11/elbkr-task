<?php

namespace Database\Seeders;

use App\Models\category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
{
    $categories = [
        'مكيف اسبليت',
        'مكيف جداري',
        'مكيف مخفي',
        'مكيف كاسيت',
        'مكيف باكيج',
        'مكيف دولابي',
    ];

    foreach ($categories as $name) {
        category::create(['name' => $name]);
    }
}
}
