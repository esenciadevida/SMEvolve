<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(QuoteRequirementSeeder::class);
        $this->call(AdminRoleSeeder::class);
        $this->call(AdministratorSeeder::class);
        $this->call(PortfolioCategorySeeder::class);
        $this->call(PortfolioProjectSeeder::class);
    }
}
