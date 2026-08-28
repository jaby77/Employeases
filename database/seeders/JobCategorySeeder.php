<?php

namespace Database\Seeders;

use App\Models\JobCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class JobCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Administrative', 'description' => 'Clerical, secretarial, and administrative support positions'],
            ['name' => 'Agriculture', 'description' => 'Farming, fisheries, and agricultural work'],
            ['name' => 'Construction', 'description' => 'Building, construction, and laborer positions'],
            ['name' => 'Education', 'description' => 'Teaching, training, and educational support'],
            ['name' => 'Government', 'description' => 'Local and national government positions'],
            ['name' => 'Healthcare', 'description' => 'Medical, nursing, and health services'],
            ['name' => 'Hospitality', 'description' => 'Hotels, restaurants, and tourism'],
            ['name' => 'Information Technology', 'description' => 'IT support, programming, and technical roles'],
            ['name' => 'Manufacturing', 'description' => 'Factory and production work'],
            ['name' => 'Services', 'description' => 'Customer service, sales, and retail'],
            ['name' => 'Transportation', 'description' => 'Driving, logistics, and delivery'],
            ['name' => 'Other', 'description' => 'Other types of employment'],
        ];

        foreach ($categories as $cat) {
            JobCategory::create([
                'name' => $cat['name'],
                'slug' => Str::slug($cat['name']),
                'description' => $cat['description'],
                'is_active' => true,
            ]);
        }
    }
}
