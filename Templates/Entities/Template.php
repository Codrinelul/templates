<?php

    namespace Modules\Templates\Entities;

    use App\Presenters\Model;
    use Modules\Stores\Traits\ScopeStoreTrait;

    class Template extends Model
    {
        use ScopeStoreTrait;

        /**
         * @var array
         */
        protected $fillable = [
            'id',
            'name',
            'code',
            'description',
            'template_type',
            'template_source',
            'indesign_package_id',
            'preview_type',
            'svg_live_template',
            'engine',
            'fit_to_page',
            'preview_resolution',
            'preview_high_resolution',
            'file_output',
            'editable_options',
            'background_pdf_uuid',
            'thumbnail_image_uuid',
            'td_filename',
            'td_data',
            'editor_options',
            'psd_template',
            'blocks',
            'trim_box',
            'confirm_checkbox',
            'watermark',
            'show_wtm_in_preview',
            'personalization_pages',
            'project_default_title',
            'subtitle_note',
            'allow_save_load',
            'allow_download_pdf',
            'project_default_text',
            'project_default_desc',
            'watermark_text',
            'watermark_size',
            'watermark_color',
            'watermark_opacity',
            'allow_article_load',
            'article_load_file',
            'use_small_images',
            'default_pdf_uuid',
            'api_bundle_restriction',
            'api_categories',
            'api_product_type',
            'color_picker',
            'template_source',
            'thumbnail_image_uuid',
            'allow_save_data',
            'use_small_images',
            'article_load_file',
            'allow_article_load',
            'auto_preview',
	  'variable_order',
            'default_image_dpi_steps',
            'activate_white_underprint',
            'activate_white_underprint_per_block',
            'store_selection'
        ];

        protected $table = 'templates';

        protected $casts = [
            'default_image_dpi_steps' => 'array'
        ];

        /**
         * @param $query
         *
         * @return mixed
         */
        public function scopeNewest($query)
        {
            return $query->orderBy('created_at', 'desc');
        }

        /**
         * @param $query
         *
         * @return mixed
         */


        /**
         * Boot the eloquent.
         */
        public static function boot()
        {
            parent::boot();

            static::deleting(function ($data) {
                // $data->deleteImage();
            });
        }
    }
