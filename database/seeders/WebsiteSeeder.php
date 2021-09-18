<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Website;
use Carbon\Carbon;

class WebsiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Website::insert([
            [
                'name' => 'website 1',
                'url' => 'https://laravel.com/',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'website 2',
                'url' => 'https://bitbucket.org/',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
    }
}
