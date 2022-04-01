<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         \App\Models\User::factory(20)->create();
         \App\Models\Partner::factory(8)->create();
         \App\Models\Company::factory(8)->create();
         \App\Models\CompanyUser::factory(8)->create();
         \App\Models\PartnerUser::factory(8)->create();
         \App\Models\Attribute::factory(10)->create();
         \App\Models\AttributeValue::factory(10)->create();
         \App\Models\Category::factory(10)->create();
    }
}
