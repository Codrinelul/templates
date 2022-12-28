<?php

namespace Modules\Templates\Services;

use Modules\Templates\Repositories\TemplateRepository;
use Modules\EditorFiles\Entities\File;
use Illuminate\Support\Facades\DB;
use Modules\EditorFiles\Helpers\FileHelper;
use Exception;
use Modules\EditorFiles\Services\FileService;
use Modules\Templates\Entities\Template;
use Modules\Templates\Grids\TemplateGridInterface;
use Illuminate\Http\Request;

class TemplateService
{

    // Template repository reference
    protected $repository;

    /**
     * Initializing the repository reference with interface
     *
     * @param TemplateRepository $templateRepo
     */
    public function __construct(TemplateRepository $templateRepo)
    {
        $this->repository  = $templateRepo;
        $this->fileService = app(FileService::class);
    }

    public function create(array $attributes, $pdfFileObj = null, $thumbnailObj = null,$defaultPdfObj =null)
    {
        if ($pdfFileObj) {
            $overwrite_pdf                     = isset($attributes['overwrite_pdf']) ? 1 : 0;
            $pdfFileData                       = $this->addPdf($pdfFileObj,
                ['uuid' => isset($attributes['background_pdf']) ? $attributes['background_pdf'] : false, 'overwrite' => $overwrite_pdf]);
            $attributes['background_pdf_uuid'] = $pdfFileData['uuid'];
        } else {
            $attributes['background_pdf_uuid'] = isset($attributes['background_pdf']) && $attributes['background_pdf'] ? $attributes['background_pdf'] : '';
        }

        if ($thumbnailObj) {
            $thumbFileData                      = $this->addThumbnail($thumbnailObj);
            $attributes['thumbnail_image_uuid'] = $thumbFileData['uuid'];
        }
        if($defaultPdfObj){
            $defaultPdfFile                      = $this->addPdf($defaultPdfObj,['uuid' => isset($attributes['default_pdf_uuid']) ? $attributes['default_pdf_uuid'] : false,'overwrite' =>0,'pdf_path'=>"default_pdf_templates",""]);
            $attributes['default_pdf_uuid'] = $defaultPdfFile['uuid'];
        }

        return $this->repository->create($attributes);
    }

    public function update($data, $id, $pdfFileObj = null, $thumbnailObj = null, $defaultPdfObj=null)
    {
       
        if ($pdfFileObj) {
            $overwrite_pdf               = isset($data['overwrite_pdf']) ? 1 : 0;
            $pdfFileData                 = $this->addPdf($pdfFileObj, ['uuid' => isset($data['background_pdf']) ? $data['background_pdf'] : false, 'overwrite' => $overwrite_pdf]);
            $data['background_pdf_uuid'] = $pdfFileData['uuid'];
        } else {
            $data['background_pdf_uuid'] = isset($data['background_pdf']) && $data['background_pdf'] ? $data['background_pdf'] : '';
        }

        if ($thumbnailObj) {
            $thumbFileData                = $this->addThumbnail($thumbnailObj);
            $data['thumbnail_image_uuid'] = $thumbFileData['uuid'];
        }
        if ($defaultPdfObj) {
            $defaultPdfFile                 = $this->addPdf($defaultPdfObj,
                ['uuid' => isset($data['default_pdf_uuid']) ? $data['default_pdf_uuid'] : false, 'overwrite' => 0, 'pdf_path' => "default_pdf_templates", ""]);
            $data['default_pdf_uuid'] = $defaultPdfFile['uuid'];

        }
        return $this->repository->update($data, $id);
    }

    public function list($attributes)
    {
        $q         = isset($attributes['q']) ? $attributes['q'] : null;
        $perPage   = isset($attributes['perPage']) ? $attributes['perPage'] : null;
        $templates = $this->repository->allOrSearch($q, $perPage);

        return $templates;
    }

    public function listAll($fields = ['id', 'code', 'name'])
    {
        $templates = $this->repository->getAllTemplates();
        return $templates::get()->map->only($fields);
    }

    public function getCollection()
    {
        $templates = $this->repository->getAllTemplates();
        return $templates::get();
    }
    public function getTemplatesByIds($value)
    {
        $model = $this->repository->getAllTemplates();
        if (is_array($value)) {
            return $model->whereIn('id', $value)->get();
        }
        return $model->where('id', '=', $value)->get();
    }
    public function getTemplateById($id)
    {

        return $this->repository->findById($id);
    }

    public function deleteTemplateById($id)
    {
        $this->repository->delete($id);
        //delete also images
    }

    public function duplicateTemplate($id)
    {
        return $this->repository->duplicate($id);
    }

    public function getPdfTemplates()
    {
        $pdf_templates = array();
        $fileTable     = File::tableName();
        $files         = DB::table($fileTable)
            ->where($fileTable . '.customer', '=', 'admin')
            ->where($fileTable . '.source', '=', 'pdf_templates')
            ->where($fileTable . '.editor', '=', 'pdf_templates')
            ->oldest()
            ->get();

        if ($files->count()) {
            foreach ($files as $key => $file) {
                $pdf_templates[$file->uuid] = str_replace('.pdf', '', $file->original_filename);
            }
        }

        return $pdf_templates;
    }


    public function addPdf($pdfFileObj, $data = [])
    {

        $extension = FileHelper::getExtension($pdfFileObj->getClientOriginalName());

        if ($extension != 'pdf') {
            throw new \Exception('Invalid Extension!');
        }
        $pdfPath = "pdf_templates";
        if(isset($data['pdf_path']) && $data['pdf_path']){
            $pdfPath = $data['pdf_path'];
        }

        $attr    = [
            'customer'    => 'admin',
            'editor'      => $pdfPath,
            'source'      => $pdfPath,
            'source_type' => $pdfPath,
            'author'      => 'admin',
            'path'        => $pdfPath,
            'create_new'  => 1,
            'overwrite'   => isset($data['overwrite']) ? $data['overwrite'] : 0,
            'uuid'        => isset($data['uuid']) && $data['uuid'] ? $data['uuid'] : '',
            'thumbnails'  => ['thumb', 'working']
        ];
        $pdfFile = $this->fileService->store($pdfFileObj, $attr);

        return $pdfFile;
    }

    public function addThumbnail($thumbObj)
    {

        $extension = FileHelper::getExtension($thumbObj->getClientOriginalName());
        if (!in_array($extension, ['png', 'jpg', 'jpeg'])) {
            throw new \Exception('Invalid Extension for Thumbnail!');
        }
        $attr      = [
            'customer'    => 'admin',
            'editor'      => 'thumb_templates',
            'source'      => 'thumb_templates',
            'source_type' => 'thumb_templates',
            'author'      => 'admin',
            'path'        => 'thumb_templates',
            'author'      => 'admin',
            'create_new'  => 1,
            'overwrite'   => 0,
            'uuid'        => '',
            'thumbnails'  => ['thumb', 'working']
        ];
        $thumbFile = $this->fileService->store($thumbObj, $attr);

        return $thumbFile;
    }
    public function changeSettings($data, Request $request)
    {
        $templateGrid = app(TemplateGridInterface::class);
        $templateIds = explode(',', $data['template_ids']);
        $exceptIds = explode(',', $data['except_ids']);
        parse_str($data['query_params'], $queryParams);
        $editableOptions = [];
        if (isset($data['editable_options_check'])) {
            $editableOptions = array_intersect_key($data['editable_options'], $data['editable_options_check']);
        }
        // dd($data);
        $request->replace($queryParams);
        $template = $this->repository->getAllTemplates()->when(!in_array('all', $templateIds), function ($query) use ($templateIds) {
                $query->whereIn('id', $templateIds);
            })
            ->when(in_array('all', $templateIds) && count($exceptIds), function ($query) use ($exceptIds) {
                $query->whereNotIn('id', $exceptIds);
            });
        $templates = $templateGrid
            ->create(['query' => $template, 'request' => $request])
            ->getQuery();
        unset($templates->getQuery()->limit, $templates->getQuery()->offset);
        $templates = $templates->get();
        if ($templates->count()) {
            foreach ($templates as $t => $template) {
                $options = unserialize($template->editable_options);
                $changeOptions = array_intersect_key($editableOptions, $options);
                $template->editable_options = serialize(array_replace($options, $editableOptions)); //$changeOptions
                // dd($template->editable_options);
                $this->changeSettingSetupData($data, $template);
                $template->save();
            }
        }
    }
    public function changeSettingSetupData($data, &$template)
    {
        if (isset($data['setup']) && count($data['setup'])) {
            foreach ($data['setup'] as $s => $setup) {
                $template->{$s} = $data[$s];
            }
        }
    }
}
