<?php

    use Illuminate\Support\Facades\Schema;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;

    class AddTemplatesTable extends Migration
    {

        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create('templates', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->string('code');
                $table->longText('description');
                $table->string('template_type');
                $table->string('indesign_package_id');
                $table->string('preview_type');
                $table->string('fit_to_page')->nullable();
                $table->string('preview_resolution')->nullable();
                $table->string('preview_high_resolution')->nullable();
                $table->string('file_output');
                $table->longText('editable_options');
                $table->string('background_pdf_uuid')->nullable();
                $table->string('td_filename')->nullable();
                $table->longText('td_data')->nullable();
                $table->longText('editor_options');
                $table->string('psd_template')->nullable();
                $table->longText('blocks')->nullable();
                $table->timestamps();
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {

            Schema::drop('templates');

        }
    }
