<?php

namespace Modules\Templates\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Rewrite\Database\Eloquent\Model;

class TemplatesDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call("OthersTableSeeder");
    }
}
