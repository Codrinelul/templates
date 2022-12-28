<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddApiFieldsToTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('templates', function (Blueprint $table) {
            $table->integer('color_picker')->default(0)->nullable();
            $table->string('api_product_type', 50)->nullable();
            $table->text('api_categories')->nullable();
            $table->text('api_bundle_restriction')->nullable();
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
            $table->dropColumn('color_picker');
            $table->dropColumn('api_product_type');
            $table->dropColumn('api_categories');
            $table->dropColumn('api_bundle_restriction');
        });
    }
}
