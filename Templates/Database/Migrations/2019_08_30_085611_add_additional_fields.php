<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAdditionalFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('templates', function (Blueprint $table) {
            $table->boolean('confirm_checkbox')->default(0);
            $table->boolean('watermark')->default(0);
            $table->boolean('show_wtm_in_preview')->default(0);
            $table->text('personalization_pages')->nullable();
            $table->text('project_default_title')->nullable();
            $table->text('subtitle_note')->nullable();
            $table->boolean('allow_save_load')->default(0);
            $table->boolean('allow_download_pdf')->default(0);
            $table->text('project_default_text')->nullable();
            $table->text('project_default_desc')->nullable();
            $table->text('watermark_text')->nullable();
            $table->text('watermark_size')->nullable();
            $table->text('watermark_color')->nullable();
            $table->text('watermark_opacity')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('', function (Blueprint $table) {

        });
    }
}
