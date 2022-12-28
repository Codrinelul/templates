<?php

namespace Modules\Templates\Repositories;

use GuzzleHttp\Client;
use Mockery\CountValidator\Exception;
use Modules\Templates\Entities\Template;
use Modules\EditorFiles\Services\FileService;
use App\Library\DesignerFactory\DesignerFactory;
use App\Services\Templates\CacheService as TemplateCache;

class EloquentTemplateRepository implements TemplateRepository
{

    protected $model;

    public function __construct()
    {
        $this->model       = app(Template::class);
        $this->fileService = app(FileService::class);
    }

    public function perPage()
    {
        return config('admin.template.perpage');
    }

    public function allOrSearch($searchQuery = null, $perPage = null)
    {
        if (is_null($searchQuery)) {
            return $this->getAll($perPage);
        }

        return $this->search($searchQuery, $perPage);
    }

    public function getAll($perPage = null)
    {
        if ($perPage == null) {
            return $this->model->paginate($this->perPage());
        }

        return $this->model->paginate($perPage);
    }

    public function getAllTemplates()
    {
        return $this->model;
    }

    public function search($searchQuery, $perPage = null)
    {
        $search = "%{$searchQuery}%";

        if ($perPage == null) {
            return $this->model->where('name', 'like', $search)
                ->orWhere('code', 'like', $search)
                ->orWhere('template_type', 'like', $search)
                ->orWhere('description', 'like', $search)
                ->orWhere('id', '=', $searchQuery)
                ->paginate($this->perPage());
        }

        return $this->model->where('name', 'like', $search)
            ->orWhere('code', 'like', $search)
            ->orWhere('template_type', 'like', $search)
            ->orWhere('description', 'like', $search)
            ->orWhere('id', '=', $searchQuery)
            ->paginate($perPage);
    }

    public function findById($id)
    {

        return $this->model->find($id);
    }

    public function findBy($key, $value, $operator = '=')
    {
        return $this->model->where($key, $operator, $value)->paginate($this->perPage());
    }

    public function delete($id)
    {
        $template = $this->findById($id);

        if (!is_null($template)) {
            $template->delete();

            return true;
        }

        return false;
    }

    private function getNewUniqueFilename($name, $attributes = [])
    {
        $templates      = $this->model->where('name', 'LIKE', "$name%")->get();
        $versionCurrent = $templates->reduce(function ($carry, $model) {
            $latest = $model->name;
            if (preg_match('/_([0-9]+)$/', $latest, $matches) !== 1) {
                return $carry;
            }
            $version = (int)$matches[1];
            return ($version > $carry) ? $version : $carry;
        }, 0);
        return $name . '_' . ($versionCurrent + 1);
    }

    private function getNewUniqueCode($code, $attributes = [])
    {
        $templates      = $this->model->where('code', 'LIKE', "$code%")->get();
        $versionCurrent = $templates->reduce(function ($carry, $model) {
            $latest = $model->code;
            if (preg_match('/_([0-9]+)$/', $latest, $matches) !== 1) {
                return $carry;
            }
            $version = (int)$matches[1];
            return ($version > $carry) ? $version : $carry;
        }, 0);
        return $code . '_' . ($versionCurrent + 1);
    }

    public function duplicate($id)
    {
        $template = $this->findById($id);
        if (!is_null($template)) {
            $cloneTemplate       = $template->replicate();
            $cloneTemplate->name = $this->getNewUniqueFilename($template->name);
            $cloneTemplate->code = $this->getNewUniqueCode($template->code);
            $cloneTemplate->save();
            return $cloneTemplate;
        }
        return false;
    }

    public function create(array $data, $id = null)
    {


        if ($id) {
            $templateInstance = $this->findById($id);
        } else {
            $templateInstance = $this->model;
        }

        $templateInstance->name                    = $data['name'];
        $templateInstance->code                    = $data['code'];
        $templateInstance->description             = $data['description'];
        $templateInstance->template_type           = $data['template_type'];
        $templateInstance->template_source         = $data['template_source'];
        $templateInstance->svg_live_template       = $data['svg_live_template'];
        $templateInstance->preview_type            = $data['preview_type'];
        $templateInstance->preview_resolution      = $data['preview_resolution'];
        $templateInstance->preview_high_resolution = $data['preview_high_resolution'];
        $templateInstance->file_output             = $data['file_output'];
        $templateInstance->td_data                 = $data['td_data'];
        $templateInstance->psd_template            = $data['psd_template'];
        $templateInstance->trim_box                = $data['trim_box'];
        $templateInstance->auto_preview            = $data['auto_preview'];
        $templateInstance->watermark_opacity       = $data['watermark_opacity'];
        $templateInstance->watermark_color         = $data['watermark_color'];
        $templateInstance->watermark_size          = $data['watermark_size'];
        $templateInstance->watermark_text          = $data['watermark_text'];
        $templateInstance->project_default_desc    = $data['project_default_desc'];
        $templateInstance->project_default_text    = $data['project_default_text'];
        $templateInstance->allow_download_pdf      = $data['allow_download_pdf'];
        $templateInstance->allow_save_load         = $data['allow_save_load'];
        $templateInstance->subtitle_note           = $data['subtitle_note'];
        $templateInstance->project_default_title   = $data['project_default_title'];
        $templateInstance->personalization_pages   = $data['personalization_pages'];
        $templateInstance->show_wtm_in_preview     = $data['show_wtm_in_preview'];
        $templateInstance->watermark               = $data['watermark'];
        $templateInstance->confirm_checkbox        = $data['confirm_checkbox'];
        $templateInstance->engine                  = $data['engine'];
        $templateInstance->editable_options        = serialize($data['editable_options']);
        $templateInstance->editor_options          = isset($data['editor_options']) ? json_encode($data['editor_options']) : "";
        $templateInstance->allow_article_load      = ($data['allow_article_load']);
        $templateInstance->use_small_images        = isset($data['use_small_images']) ? $data["use_small_images"] : 0;
        $templateInstance->allow_save_data         = isset($data['allow_save_data']) ? $data["allow_save_data"] : 0;
        $templateInstance->variable_order          = isset($data['variable_order']) ? $data['variable_order'] : '';
        if (isset($data['article_load_file'])) {
            $templateInstance->article_load_file = json_encode($data['article_load_file']);
        }
        if (isset($data['color_picker'])) {
            $templateInstance->color_picker = $data['color_picker'];
        }
        if (isset($data['api_product_type'])) {
            $templateInstance->api_product_type = $data['api_product_type'];
        }
        if (isset($data['api_categories'])) {
            $templateInstance->api_categories = $data['api_categories'];
        }
	if (isset($data['activate_white_underprint'])) {
            $templateInstance->activate_white_underprint           = $data['activate_white_underprint'];
        }
	if (isset($data['activate_white_underprint_per_block'])) {
            $templateInstance->activate_white_underprint_per_block = $data['activate_white_underprint_per_block'];
        }        

        $default_dpi_steps  = EloquentTemplateRepository::getTemplateDefaultDPISteps();
        $default_dpi_step_1 = null;
        if (isset($data['default_dpi_step_1'])) {
            $default_dpi_step_1 = intval($data['default_dpi_step_1']);
        }
        $default_dpi_step_2 = null;
        if (isset($data['default_dpi_step_2'])) {
            $default_dpi_step_2 = intval($data['default_dpi_step_2']);
        }
        if (!is_null($default_dpi_step_1)) {
            $default_dpi_steps['bad']['high']   = $default_dpi_step_1 - 1;
            $default_dpi_steps['meh']['low'] = $default_dpi_step_1;
        }
        if (!is_null($default_dpi_step_2)) {
            $default_dpi_steps['meh']['high']    = $default_dpi_step_2 - 1;
            $default_dpi_steps['good']['low'] = $default_dpi_step_2;
        }

        $templateInstance->default_image_dpi_steps = $default_dpi_steps;

        $templateInstance->indesign_package_id = isset($data['indesignPackageId']) ? $data['indesignPackageId'] : 0;
        $templateInstance->background_pdf_uuid = isset($data['background_pdf_uuid']) ? $data['background_pdf_uuid'] : 0;
        if (isset($data['thumbnail_image_uuid'])) {
            $templateInstance->thumbnail_image_uuid = isset($data['thumbnail_image_uuid']) ? $data['thumbnail_image_uuid'] : 0;
        }
        if (isset($data['default_pdf_uuid'])) {
            $templateInstance->default_pdf_uuid = isset($data['default_pdf_uuid']) ? $data['default_pdf_uuid'] : null;
        }


        /*if (isset($data['background_svg'])) {
            $templateInstance->background_svg = $data['background_svg'];
        }

        if (isset($data['background_pdf'])) {
            $templateInstance->background_pdf = $data['background_pdf'];
        }*/

        if (isset($data['td_filename'])) {
            $templateInstance->td_filename = $data['td_filename'];
        }

        if (isset($data['video_filename'])) {
            $templateInstance->video_filename = $data['video_filename'];
        }


        switch ($data['template_type']) {
            case 'svg':
                $custom_blocks_designer = array();


                if (isset($data['svg_content']) && count($data['svg_content'])) {
                    //nested forms
                    foreach ($data['svg_content'] as $key_content => $content) {

                        array_push($custom_blocks_designer, array(
                            'width'           => $data['width'][$key_content],
                            'height'          => $data['height'][$key_content],
                            'unit'            => $data['unit'][$key_content],
                            'current_page_nr' => $data['current_page_nr'][$key_content],
                            'svg_content'     => $data['svg_content'][$key_content],
                            'preview_image'   => isset($data['preview_image'][$key_content]) && $data['preview_image'][$key_content] ? $data['preview_image'][$key_content] : null,
                        ));
                    }
                }

                $templateInstance->custom_blocks_designer = json_encode($custom_blocks_designer);
                break;
            case 'pdf':
                try {
                    if (!isset($data['background_pdf_uuid'])) {
                        throw new Exception(__('No pdf file id provided'));
                    }
                    $attributes      = array(
                        'type'   => 'pdf',
                        'editor' => 'pdf_templates',
                        'uuid'   => $data['background_pdf_uuid'],

                    );
                    $pdfFileTemplate = $this->fileService->getFileItem($attributes);
                    if (!file_exists($pdfFileTemplate['absPath'])) {
                        throw new \Exception(__('File not exists'));
                    }
                    $designerFactory = new DesignerFactory();
                    $pdfData         = $designerFactory->createJSON('PDF', $pdfFileTemplate['absPath'], array(
                        'getBlocks' => 1
                    ));
                    if (!$pdfData['success']) {
                        throw new \Exception($pdfData['message']);
                    }

                    $templateInstance->blocks = json_encode($pdfData['result']);
                    $overwrite_pdf            = isset($attributes['overwrite_pdf']) ? 1 : 0;
                    if (isset($overwrite_pdf)) {
                        $templates = $this->model->where('background_pdf_uuid', '=',
                            $templateInstance->background_pdf_uuid)->get();
                        if (count($templates)) {
                            foreach ($templates as $template) {
                                $template->blocks = json_encode($pdfData['result']);
                                $template->save();
                            }
                        }

                    }


                } catch (\Exception $e) {
                    print_r($e->getMessage());
                    die();
                }
                break;
            case 'indesign':
                if (isset($data['indesignPackageId'])) {
                    $templateInstance->indesign_package_id = $data['indesignPackageId'];
                }
                break;
        }

        $templateInstance->save();

        if ($id) {
            $templateCache = app(TemplateCache::class);
            $templateCache->flushTemplate($id);
        }
        \StoreSelection::syncStores($templateInstance, $data);

        return $templateInstance;

    }

    public function update($data, $id)
    {

        return $this->create($data, $id);

    }

    static function getTemplateDefaultDPISteps()
    {
        return [
            'bad'  => [
                'low'  => 0,
                'high' => 119
            ],
            'meh'  => [
                'low'  => 120,
                'high' => 249
            ],
            'good' => [
                'low'  => 250,
                'high' => 99999
            ]
        ];
    }


}
