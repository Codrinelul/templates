<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Templates\Repositories\EloquentTemplateRepository;

class AddDefaultImageDpiStepsToTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('templates', function (Blueprint $table) {
            $table->string('default_image_dpi_steps')
                ->default(json_encode(EloquentTemplateRepository::getTemplateDefaultDPISteps()));
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('templates', function (Blueprint $table) {
            $table->dropColumn('default_image_dpi_steps');
        });
    }
}
