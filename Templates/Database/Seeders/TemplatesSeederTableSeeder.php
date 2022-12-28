<?php

namespace Modules\Templates\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Rewrite\Database\Eloquent\Model;
use Modules\Templates\Entities\Template;

class TemplatesSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $templates = Template::all();
        foreach ($templates as $template) {
            $blocks = @unserialize($template->blocks);
            if ($blocks !== false) {
                $template->blocks = json_encode($blocks);
                $template->save();
            }
        }
    }
}
