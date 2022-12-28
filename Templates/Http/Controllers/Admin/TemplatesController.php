<?php

namespace Modules\Templates\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseModuleController;
use App\Http\Repositories\Colors\EloquentColorRepository as ColorRepository;
use App\Http\Repositories\Fonts\EloquentFontRepository as FontRepository;
use App\Http\Repositories\Layouts\EloquentLayoutRepository as LayoutRepository;
use App\Http\Repositories\Refinements\EloquentRefinementRepository as RefinementRepository;
use App\Http\Repositories\Shapes\EloquentShapeRepository as ShapeRepository;
use App\Http\Repositories\Submodels\EloquentSubmodelRepository as SubmodelRepository;
use App\Http\Repositories\Helpers\EloquentHelperRepository as HelperRepository;
use App\Http\Repositories\Cms\EloquentCmsRepository as CmsRepository;
use App\Models\ColorSet;
use App\Models\FontSet;
use App\Models\ShapeSet;
use App\Services\ReadPdfService;
use Illuminate\Http\Request;
use Modules\Templates\Http\Validation\Create;
use Modules\Templates\Http\Validation\Update;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Indesign\Repositories\IndesignPackageRepository;
use Modules\Indesign\Services\IndesignPackageService;
use Modules\Templates\Services\TemplateService;
use Modules\EditorFiles\Services\FileService;
use Modules\DesignerBackgrounds\Services\DesignerBackgroundsService;
use Modules\Templates\Helpers\RemoteApi\ProductTypes;
use Modules\Templates\Helpers\RemoteApi\Categories;
use Exception;
use Cache;
use Modules\Templates\Entities\Template;
use Modules\Templates\Grids\TemplateGridInterface;
use Modules\PrintqCore\Http\Middleware\PjaxMiddleware;

use App\Services\PersonalizationService;
use Illuminate\Support\Arr;
use Modules\Variables\Services\VariableService;
use Modules\Texts\Repositories\Texts\EloquentTextRepository;
use Modules\Texts\Entities\TextSet;

class TemplatesController extends BaseModuleController
{

    protected $templates;

    protected $service;

    protected $fileService;

    protected $personalizationService;
    protected $variableService;

    public function __construct(TemplateService $service)
    {
        $this->service            = $service;
        $this->repository         = $this->getRepository();
        $this->packageRepository  = app(IndesignPackageRepository::class);
        $this->packageService     = app(IndesignPackageService::class);
        $this->fileService        = app(FileService::class);
        $this->backgroundsService = app(DesignerBackgroundsService::class);
        $this->middleware(PjaxMiddleware::class)->only('index', 'destroy');
        $this->personalizationService = app(PersonalizationService::class);
        $this->variableService    = app(VariableService::class);

    }

    /**
     * Get repository instance.
     *
     * @return mixed
     */
    public function getRepository()
    {
        $repository = 'Modules\Templates\Repositories\TemplateRepository';

        return app($repository);
    }

    /**
     * Redirect not found.
     *
     * @return Response
     */
    protected function redirectNotFound()
    {
        return $this->redirect('templates.index')
            ->withFlashMessage('Template not found!')
            ->withFlashType('danger');
    }

    /**
     * Display a listing of templates.
     *
     * @return Response
     */
    public function index(TemplateGridInterface $templateGrid, Request $request)
    {
        $template = Template::query();
        return $templateGrid
            ->create(['query' => $template, 'request' => $request])
            ->setGridSelectionOptions([
                'delete'        => 'delete',
                'changeSetting' => 'Change Setting'
            ])
            ->renderOn('templates::admin.templates.index');

    }

    /**
     * Show the form for creating a new template.
     *
     * @return Response
     */
    public function create()
    {

        $fontRepository = new FontRepository();
        $fonts          = $fontRepository->getAllFonts();
        $template_fonts = [];
      $preselected_fonts = [];
        foreach ($fonts as $font) {
              $template_fonts[$font->font] = $font->display_name;
  	if ($font->preselected) {
                $preselected_fonts[] = $font->font;
            }
        }
        $textRepository = new EloquentTextRepository();
        $texts          = $textRepository->getAllTexts();
        $template_texts = [];
        $preselected_texts = [];
        foreach ($texts as $text) {
            $template_texts[$text->id] = $text->title;
            if ($text->preselected) {
                $preselected_texts[] = $text->id;
            }
        }
        $colorRepository = new ColorRepository();
        $colors          = $colorRepository->getAllColors();
        $template_colors = [];
        $preselected_colors = [];
        foreach ($colors as $color) {
            $template_colors[$color->id] = $color->title;
    if ($color->preselected) {
                $preselected_colors[] = $color->id;
            }
        }


        $cmsRepository = new CmsRepository();
        $cms_all       = $cmsRepository->getAllCms();
        $template_cms  = [];
        foreach ($cms_all as $cms) {
            $template_cms[$cms->identifier] = $cms->identifier;
        }
        $template_backgrounds = [];
        $preselected_backgrounds = [];

        $backgrounds = $this->backgroundsService->list([]);


        if ($backgrounds && $backgrounds->count()) {
            foreach ($backgrounds as $background) {
                $template_backgrounds[$background->id] = $background->name;
                if ($background->preselected) {
                    $preselected_backgrounds[] = $background->id;
                }
            }
        }

        $shapeRepository = new ShapeRepository();
        $shapes          = $shapeRepository->getAllShapes();
        $template_shapes = [];
        $preselected_shapes = [];
        foreach ($shapes as $shape) {
            $template_shapes[$shape->id] = $shape->name;
            if ($shape->preselected) {
                $preselected_shapes[] = $shape->id;
            }
        }
        $articleFile        = public_path() . '/personalization/articleload_files/';
        $article_filesArray = glob($articleFile . '{*.xls,*.xlsx}', GLOB_BRACE);
        $article_files      = [];
        if (is_array($article_filesArray) && count($article_filesArray)) {
            foreach ($article_filesArray as $article) {
                $pathInfo              = pathinfo($article);
                $name                  = $pathInfo['basename'];
                $article_files [$name] = $name;
            }

        }
        $layoutRepository = new LayoutRepository();
        $layouts          = $layoutRepository->getAllLayouts();
        $template_layouts_content = array();
        $template_layouts_footer = array();
        $template_layouts_header = array();
        foreach ($layouts as $layout) {
            if ($layout['layout_type'] == "content") {
                $template_layouts_content[$layout->id] = $layout->name;
            }
            if ($layout['layout_type'] == "footer") {
                $template_layouts_footer[$layout->id] = $layout->name;
            }
            if ($layout['layout_type'] == "header") {
                $template_layouts_header[$layout->id] = $layout->name;
            }
        }

        $template_layouts = $template_layouts_content;


        $submodeRepository  = new SubmodelRepository();
        $submodels          = $submodeRepository->getAllSubmodels();
        $template_submodels = [];
        foreach ($submodels as $submodel) {
            $template_submodels[$submodel->id] = $submodel->name;
        }

        $refinementRepository = new RefinementRepository();
        $refinementsInstance  = $refinementRepository->getAllRefinements();
        $refinements_template = [];
        foreach ($refinementsInstance as $ref) {
            $refinements_template[$ref->id] = $ref->name;
        }

        $previews_svg = $this->getPreviewsSvg(
            [
                'is_Ajax' => 0,
                'data'    => [
                    'file' => null,
                    'id'   => null
                ],
            ]
        );

        $template_indesignPackage = [];

        if (isModuleActive('Indesign') ||1) {
            $template_indesignPackage = $this->packageRepository->getAllIndesignPackages();
        }

        $personalization_pdfs = $this->service->getPdfTemplates();


        /*  $svg_live_template_files = glob(public_path().'/personalization/svg_live_template/*.svg');

          $personalization_svg_live_template_files = array();
          if(count($svg_live_template_files)){
              foreach($svg_live_template_files as $svg_file){
                  $personalization_svg_live_template_files[basename($svg_file)] = basename($svg_file,'.svg');
              }
          }*/
        $personalization_svg_live_template_files = getLiveSvgs();

        $apiProductTypes = [];
        $apiCategories   = [];
        $enableApi       = (bool)printq_system_settings_value('servers.templates_api.enable_api', 0);

        if ($enableApi) {
            $productTypesObj  = app(ProductTypes::class);
            $apiProductTypes  = $productTypesObj->getTreeForSelect();
            $apiCatagoriesObj = app(Categories::class);
            $apiCategories    = $apiCatagoriesObj->getCategoriesForTree();
        }

        $thumbnailUrl = false;
        $thumbnailDefaultPdfUrl = false;

        $template_shape_sets = ShapeSet::all();
        $shape_sets = [];
        $preselected_shape_sets = [];
        foreach ($template_shape_sets as $shape_set) {
            $shape_sets[$shape_set->id] = $shape_set->name;
            if ($shape_set->preselected) {
                $preselected_shape_sets[] = $shape_set->id;
            }
        }
        $template_font_sets  = FontSet::all();
        $font_sets = [];
        $preselected_font_sets = [];
        foreach ($template_font_sets as $font_set) {
            $font_sets[$font_set->id] = $font_set->name;
            if ($font_set->preselected) {
                $preselected_font_sets[] = $font_set->id;
            }
        }
        $template_color_sets = ColorSet::all();
        $color_sets = [];
        $preselected_color_sets = [];
        foreach ($template_color_sets as $color_set) {
            $color_sets[$color_set->id] = $color_set->name;
            if ($color_set->preselected) {
                $preselected_color_sets[] = $color_set->id;
            }
        }
        $template_text_sets = TextSet::all();
        $text_sets = [];
        $preselected_text_sets = [];
        foreach ($template_text_sets as $text_set) {
            $text_sets[$text_set->id] = $text_set->name;
            if ($text_set->preselected) {
                $preselected_text_sets[] = $text_set->id;
            }
        }
        $customRuleEditableOption = "#global_editable_options";
        $defaultTemplate = printq_system_settings_value('editors.templates.default_template_config', null);
        $template = Template::find($defaultTemplate);
        if($template) {
            $webstores = $template->webstores;
            $clone = $template->replicate(['name', 'code']);
            $clone->setRelation('webstores', $webstores);
            $clone->use_as_default_template = 1;
            $template = $clone;
        }

        return $this->view(
            'templates::admin.templates.create', compact('template',
                'template_fonts', 'previews_svg', 'template_colors', 'template_backgrounds', 'template_shapes', 'template_texts',
                'template_layouts', 'template_layouts_content', 'template_layouts_footer', 'template_layouts_header', 'template_cms',
                'thumbnailUrl','customRuleEditableOption',
                'refinements_template', 'template_indesignPackage','thumbnailDefaultPdfUrl',
                'personalization_pdfs', 'article_files', 'personalization_svg_live_template_files',
                'template_submodels', 'enableApi', 'apiProductTypes', 'apiCategories', 'shape_sets', 'font_sets', 'color_sets', 'text_sets',
                'preselected_fonts', 'preselected_colors', 'preselected_backgrounds', 'preselected_shapes', 'preselected_texts',
                'preselected_shape_sets', 'preselected_font_sets', 'preselected_color_sets', 'preselected_text_sets'
            )
        );
    }

    /**
     * Store a newly created template in storage.
     *
     * @return Response
     */
    public function store(Create $request)
    {

        $data    = $request->all();
        $pdfFile = $request->file('pdf');
        $defaultPdfFile        = $request->file('default_pdf');
        if (empty($data['description'])) {
            $data['description'] = '';
        }
        $thumbFile        = $request->file('thumbnail_image');
        $templateInstance = $this->service->create($data, $pdfFile, $thumbFile, $defaultPdfFile);
        if ($pdfFile) {
            Cache::flush();
        }
        if ($request->get('save_and_continue')) {
            $route  = 'templates.edit';
            $params = [$templateInstance->id];
        } else {
            $route  = 'templates.index';
            $params = [];
        }
        return $this->redirect($route, $params)
            ->withFlashMessage(__('Template Saved'))
            ->withFlashType('success');
    }

    /**
     * Show the form for editing the specified template.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id, Request $request)
    {
        try {
            $template = $this->service->getTemplateById($id);
            if (!$template) {
                return abort(404);
            }

            $previews = $this->getPreviews([
                'is_Ajax' => 0,
                'data'    => [
                    'id'            => $id,
                    'file'          => $template->background_pdf_uuid,
                    'template_type' => $template->template_type,
                    'indesign_id'   => $template->indesign_package_id
                ]
            ]);

            $fontRepository = new FontRepository();
            $fonts          = $fontRepository->getAllFonts();
            $template_fonts = [];
            $preselected_fonts = [];
            foreach ($fonts as $font) {
              $template_fonts[$font->font] = $font->display_name . ' ';
                if ($font->preselected) {
                    $preselected_fonts[] = $font->font;
                }
            }
            $textRepository = new EloquentTextRepository();
            $texts          = $textRepository->getAllTexts();
            $template_texts = [];
            $preselected_texts = [];
            foreach ($texts as $text) {
                $template_texts[$text->id] = $text->title;
                if ($text->preselected) {
                    $preselected_texts[] = $text->id;
                }
            }

            $cmsRepository = new CmsRepository();
            $cms_all       = $cmsRepository->getAllCms();
            $template_cms  = [];
            foreach ($cms_all as $cms) {
                $template_cms[$cms->identifier] = $cms->identifier;
            }

            $colorRepository = new ColorRepository();
            $colors          = $colorRepository->getAllColors();
            $template_colors = [];
            $preselected_colors = [];
            foreach ($colors as $color) {
                $template_colors[$color->id] = $color->title;
                if ($color->preselected) {
                    $preselected_colors[] = $color->id;
                }
            }

            $template_backgrounds = [];
            $preselected_backgrounds = [];
            $backgrounds          = $this->backgroundsService->list([]);

            if ($backgrounds && $backgrounds->count()) {
                foreach ($backgrounds as $background) {
                    $template_backgrounds[$background->id] = $background->name;
                    if ($background->preselected) {
                        $preselected_backgrounds[] = $background->id;
                    }
                }
            }


            $shapeRepository = new ShapeRepository();
            $shapes          = $shapeRepository->getAllShapes();
            $template_shapes = [];
            $preselected_shapes = [];
            foreach ($shapes as $shape) {
                $template_shapes[$shape->id] = $shape->name;
                if ($shape->preselected) {
                    $preselected_shapes[] = $shape->id;
                }
            }
            $articleFile        = public_path() . '/personalization/articleload_files/';
            $article_filesArray = glob($articleFile . '{*.xls,*.xlsx}', GLOB_BRACE);
            $article_files      = [];
            if (is_array($article_filesArray) && count($article_filesArray)) {
                foreach ($article_filesArray as $article) {
                    $pathInfo              = pathinfo($article);
                    $name                  = $pathInfo['basename'];
                    $article_files [$name] = $name;
                }

            }
            $layoutRepository = new LayoutRepository();
            $layouts          = $layoutRepository->getAllLayouts();
            $template_layouts_content = array();
            $template_layouts_footer = array();
            $template_layouts_header = array();
            foreach ($layouts as $layout) {
                if ($layout['layout_type'] == "content") {
                    $template_layouts_content[$layout->id] = $layout->name;
                }
                if ($layout['layout_type'] == "footer") {
                    $template_layouts_footer[$layout->id] = $layout->name;
                }
                if ($layout['layout_type'] == "header") {
                    $template_layouts_header[$layout->id] = $layout->name;
                }
            }

            $template_layouts = $template_layouts_content;


            $submodeRepository  = new SubmodelRepository();
            $submodels          = $submodeRepository->getAllSubmodels();
            $template_submodels = [];
            foreach ($submodels as $submodel) {
                $template_submodels[$submodel->id] = $submodel->name;
            }

            $refinementRepository = new RefinementRepository();
            $refinementsInstance  = $refinementRepository->getAllRefinements();
            $refinements_template = [];
            foreach ($refinementsInstance as $ref) {
                $refinements_template[$ref->id] = $ref->name;
            }

            $previews_svg = $this->getPreviewsSvg(
                [
                    'is_Ajax' => 0,
                    'data'    => [
                        'id'   => $id,
                        'file' => $template->background_svg,
                    ],
                ]
            );

            $template_indesignPackage = [];

            if (isModuleActive('Indesign') || 1) {
                $template_indesignPackage = $this->packageRepository->getAllIndesignPackages();
            }
            $personalization_pdfs = $this->service->getPdfTemplates();


            //  $svg_live_template_files = glob(public_path() . '/personalization/svg_live_template/*.svg');

            /*  if (count($svg_live_template_files)) {
                  foreach ($svg_live_template_files as $svg_file) {
                      $personalization_svg_live_template_files[basename($svg_file)] = basename($svg_file, '.svg');
                  }
              }*/
            $personalization_svg_live_template_files = getLiveSvgs();
            $lastTab                                 = $request->input('tab');
            $thumbnailUrl                            = false;
            $thumbnailDefaultPdfUrl                            = false;
            if ($template->thumbnail_image_uuid) {
                $thumb = $this->fileService->item([
                    'uuid' => $template->thumbnail_image_uuid
                ]);
                if ($thumb) {
                    if (isset($thumb['thumbnails'])) {
                        $thumbnailUrl = url('/storage/') . $thumb['thumbnails']['working']['url'];
                    }
                }
            }
            if ($template->default_pdf_uuid) {
                $thumb = $this->fileService->item([
                    'uuid' => $template->default_pdf_uuid
                ]);
                if ($thumb) {
                    if (isset($thumb['thumbnails'])) {
                        $thumbnailDefaultPdfUrl = $thumb['thumbnails']['working']['url'];
                    }
                }
            }

            $apiProductTypes = [];
            $apiCategories   = [];
            $enableApi       = (bool)printq_system_settings_value('servers.templates_api.enable_api', 0);

            if ($enableApi) {
                //dd($template);
                $productTypesObj  = app(ProductTypes::class);
                $apiProductTypes  = $productTypesObj->getTreeForSelect();
                $apiCatagoriesObj = app(Categories::class);
                if ($template->api_categories) {
                    $apiCategories = $apiCatagoriesObj->getCategoriesForTree(json_decode($template->api_categories,
                        true));
                }
            }
            $template_shape_sets = ShapeSet::all();
            $shape_sets = [];
            $preselected_shape_sets = [];
            foreach ($template_shape_sets as $shape_set) {
                $shape_sets[$shape_set->id] = $shape_set->name;
                if ($shape_set->preselected) {
                    $preselected_shape_sets[] = $shape_set->id;
                }
            }
            $template_font_sets  = FontSet::all();
            $font_sets = [];
            $preselected_font_sets = [];
            foreach ($template_font_sets as $font_set) {
                $font_sets[$font_set->id] = $font_set->name;
                if ($font_set->preselected) {
                    $preselected_font_sets[] = $font_set->id;
                }
            }
            $template_color_sets = ColorSet::all();
            $color_sets = [];
            $preselected_color_sets = [];
            foreach ($template_color_sets as $color_set) {
                $color_sets[$color_set->id] = $color_set->name;
                if ($color_set->preselected) {
                    $preselected_color_sets[] = $color_set->id;
                }
            }
            $template_text_sets = TextSet::all();
            $text_sets = [];
            $preselected_text_sets = [];
            foreach ($template_text_sets as $text_set) {
                $text_sets[$text_set->id] = $text_set->name;
                if ($text_set->preselected) {
                    $preselected_text_sets[] = $text_set->id;
                }
            }
            $customRuleEditableOption = "#global_editable_options";
            return $this->view(
                'templates::admin.templates.edit', compact(
                    'refinements_template', 'template', 'previews', 'previews_svg', 'template_fonts', 'template_texts',
                    'template_colors', 'template_cms',
                    'thumbnailUrl','customRuleEditableOption',
                    'template_backgrounds',
                    'template_shapes', 'template_layouts', 'template_layouts_content', 'template_layouts_footer', 'template_layouts_header', 'template_indesignPackage',
                    'personalization_pdfs', 'article_files', 'lastTab', 'personalization_svg_live_template_files',
                    'template_submodels', 'enableApi', 'apiProductTypes', 'apiCategories','thumbnailDefaultPdfUrl',
                    'shape_sets', 'font_sets', 'color_sets', 'text_sets',
                    'preselected_fonts', 'preselected_colors', 'preselected_backgrounds', 'preselected_shapes', 'preselected_texts',
                    'preselected_shape_sets', 'preselected_font_sets', 'preselected_color_sets', 'preselected_text_sets'
                )
            );
        } catch (ModelNotFoundException $e) {
            return $this->redirectNotFound();
        }
    }

    /**
     * Update the specified template in storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function update(Update $request, $id)
    {
        try {
            $data = $request->all();
            if (empty($data['description'])) {
                $data['description'] = '';
            }
            $lastTab = $data['lastTab'];

            $pdfFile          = $request->file('pdf');
            $thumbFile        = $request->file('thumbnail_image');
            $defaultPdfFile        = $request->file('default_pdf');
            $templateInstance = $this->service->update($data, $id, $pdfFile, $thumbFile, $defaultPdfFile);
            if ($pdfFile) {
                Cache::flush();
            }
            if ($request->get('save_and_continue')) {
                $route  = 'templates.edit';
                $params = [$templateInstance->id, $lastTab];
            } else {
                $route  = 'templates.index';
                $params = [];
            }
            return $this->redirect($route, $params)
                ->withFlashMessage(__('Template Saved'))
                ->withFlashType('success');
        } catch (ModelNotFoundException $e) {
            return $this->redirectNotFound();
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified template from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id, Request $request)
    {
        try {
            $this->service->deleteTemplateById($id);
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'data'    => [
                        'deleted' => true
                    ]
                ]);
            }
        } catch (ModelNotFoundException $e) {
        }
    }

    public function duplicate($id)
    {
        try {
            $newTemplate = $this->service->duplicateTemplate($id);
            if ($newTemplate->id) {
                return redirect()->route('admin.templates.edit', [$newTemplate->id]);
            }
        } catch (ModelNotFoundException $e) {
        }
    }

    public function getPreviews(
        $params
        = [
            'is_Ajax'       => 1,
            'data'          => [],
            'template_type' => 'otp',
            'indesign_id'   => 0
        ]
    )
    {
        $result        = false;
        $is_Ajax       = isset($params['is_Ajax']) && $params['is_Ajax'] ? 1 : 0;
        $data          = $is_Ajax ? \Request::all() : $params['data'];
        $id            = $data['id'];
        $file_name     = $data['file'];
        $template_type = isset($data['template_type']) ? $data['template_type'] : "otp";
        $indesign_id   = isset($data['indesign_id']) && $data['indesign_id'] ? $data['indesign_id'] : 0;
        if (!$file_name || $file_name == 'null') {
            if ($is_Ajax) {
                echo json_encode(
                    [
                        'success'    => 1,
                        'page_thumb' => "",
                    ]
                );
                exit;
            } else {
                return "";
                exit;
            }
        }

        $pdfItem        = $this->fileService->getFileItem([
            'uuid'      => $file_name,
            'file_type' => 'pdf',
            'editor'    => 'pdf_templates',
        ]);
        $pdfAbsPath = $pdfItem ? ($pdfItem['absPath'] ?? null) : null;
        $data           = [
            'options'        => [],
            'input'          => $pdfAbsPath,
            'editor_config'  => [],
            'custom_options' => [],
            'type'           => 'getPages',
            'version'        => 'external'
        ];
        $readPdfService = app(ReadPdfService::class);
        $page_number    = $readPdfService->getResponseFromRest($data, $pdfAbsPath);


        $pdfImages = [];


        for ($i = 0; $i < $page_number; $i++) {
            $page_itm      = $this->fileService->item([
                'pdfPage' => $i,
                'uuid'    => $file_name
            ]);
            $pdfImages[$i] = [
                'thumb'   => $page_itm['thumbnails']['thumb']['url'],
                'working' => $page_itm['thumbnails']['working']['url']
            ];
        }
        if ($template_type == "indesign") {
            $indesignPackage = $this->packageRepository->findById($indesign_id);
            if ($indesignPackage) {
                $defaultLayout = $indesignPackage->defaultLayouts->first();
                if ($defaultLayout) {
                    $indesignData = json_decode($defaultLayout['data'], true);
                    if (is_array($indesignData) && count($indesignData)) {
                        if (isset($indesignData['pages'])) {
                            $page_number = count($indesignData['pages']);
                            $pdfImages   = [];
                            for ($i = 0; $i < $page_number; $i++) {
                                $pdfImages[$i] = [];
                            }
                        }
                    }
                }
            }
        }
        $editor_options = [];

        if ($id) {
            $template       = $this->repository->findById($id);
            $editor_options = json_decode($template->editor_options, true);
        }
        $helpers           = [];
        $helpersRepository = new HelperRepository();
        $helpers           = $helpersRepository->getAllHelpers();
        $result            = $this->view('templates::admin.templates.page_thumb',
            compact('page_number', 'pdfImages', 'editor_options', 'helpers'))->render();

        $pdf = null;
        if ($is_Ajax) {
            echo json_encode(
                [
                    'success'    => 1,
                    'page_thumb' => $result,
                ]
            );
        } else {
            return $result;
        }

    }

    public function getBlocksInfo( Request $request ) {
        try {
            $result    = ["success" => 1, "message" => "", "html" => ""];
            $data      = $request->all();
            $file_name = $data['file'];
            if (!$file_name) {
                throw new \Exception(__('File not Provided!'));
            }

            $template = $this->service->getTemplateById($data['template_id']);

            $pdfItem        = $this->fileService->getFileItem([
                'uuid'      => $file_name,
                'file_type' => 'pdf',
                'editor'    => 'pdf_templates',
            ]);
            $data           = [
                'options'        => [],
                'input'          => $pdfItem['absPath'],
                'editor_config'  => [],
                'custom_options' => [],
                'type'           => 'getBlocksInfo',
                'version'        => 'external'
            ];
            $readPdfService = app(ReadPdfService::class);
            $pages          = $readPdfService->getResponseFromRest($data, $pdfItem['absPath']);

            $pdfVars = Arr::pluck($pages, 'blocks.*.customoptions');
            $variables = $this->variableService->getAllVariables();
            $result['variables'] = $this->view('templates::admin.templates.page_variables', compact('variables', 'pdfVars'))->render();
            $result['html'] = $this->view('templates::admin.templates.blocksinfo',
                compact('pages', 'template'))->render();
        } catch (\Exception $e) {
            $result['success'] = 0;
            $result['message'] = $e->getMessage();
            echo json_encode($result);
            exit;
        }
        echo json_encode($result);
        exit;
    }

    public function getBlockProp($pdf, $doc, $page, $block, $name, $options = ['propType' => false])
    {
        $value = false;
        $query = "pages[$page]/blocks[$block]/$name";

        if (isset($options['propType']) && $options['propType']) {
            $propType = $this->getBlockPropType($pdf, $doc, $page, $block, $name);

            if ($propType != $options['propType']) {
                throw  new \Exception('Invalid property type');
            }
        }
        switch ($propType) {
            case 'number':
                $value = $pdf->pcos_get_string($doc, $query);
                break;
            case'string':
                $value = $pdf->pcos_get_string($doc, $query);
                break;
            case 'array':
                $value = $pdf->pcos_get_number($doc, $query);
                break;
            case'name':
                $value = $pdf->pcos_get_string($doc, $query);
                break;

        }

        return $value;
    }

    public function getBlockPropType($pdf, $doc, $page, $block, $name, $options = [])
    {
        $type = false;
        $type = $pdf->pcos_get_string($doc, "type:pages[$page]/blocks[$block]/$name");
        return $type;
    }

    public function getPreviewsSvg(
        $params
        = [
            'is_Ajax' => 1,
            'data'    => [],
        ]
    )
    {
        $result  = false;
        $is_Ajax = isset($params['is_Ajax']) && $params['is_Ajax'] ? 1 : 0;

        $data                   = $is_Ajax ? \Request::all() : $params['data'];
        $id                     = $data['id'];
        $editor_options         = false;
        $template               = false;
        $background_svg_content = [];
        if ($id) {
            $template               = $this->repository->findById($id);
            $editor_options         = json_decode($template->editor_options, true);
            $background_svg_content = json_decode($template->custom_blocks_designer, true);
        }

        $data = $is_Ajax ? \Request::all() : $params['data'];

        $file_name = $data['file'];


        $result = $this->view('templates::admin.templates.page_thumb_svg',
            compact('file_name', 'editor_options', 'background_svg_content'))->render();

        $pdf = null;
        if ($is_Ajax) {
            echo json_encode(
                [
                    'success'    => 1,
                    'page_thumb' => $result,
                ]
            );
        } else {
            return $result;
        }

    }

    public function preview($id, Request $request)
    {
        $templateCollection = $this->service->getCollection();
        $templateItems      = $templateCollection->only($id);
        $templateInstance   = $templateItems[0];
        $api_product_type   = $templateInstance->api_product_type ? $templateInstance->api_product_type : null;

        $result = [];
        try {
            $attributes = [
                'template_id'      => $id,
                'preview_template' => 1
            ];

            $data = $this->personalizationService->computePersonalizationData(null, $attributes);
            $additional_data = json_decode(base64_decode($data['additional_data']), true);
            if( "custom_packaging" ==  $api_product_type ){
                $additional_data['packagingOptions'] = [
                    'model' => 'Hanger',
                    'In_Designer' => 1,
                    'Use_Bleed_Mask' => 1
                ];
                $data['additional_data'] = base64_encode(json_encode($additional_data));
            }
            if ($request->customizedproductid) {
                    $data['customizedproductid'] = $request->customizedproductid;
            }
            $url  = $this->personalizationService->getPersonalizationUrl($data);
            header('Location: ' . $url);
            exit;

        } catch (\Exception $e) {
            $identifier = logExceptionAdditional($e, []);
            $result     = [
                'success'          => 0,
                'error_code'       => 'SERVER_ERROR',
                'message'          => 'An error has occured. ' . $e->getMessage(),
                'error_identifier' => $identifier,
            ];
        }

        echo json_encode($result);
        exit;
    }
    public function getBlockCustomRulesUrl(Request $request)
    {
        $data = $request->all();
        $custom_rules = 1;

        $fontRepository = new FontRepository();
        $fonts          = $fontRepository->getAllFonts();
        $template_fonts = [];
        $preselected_fonts = [];
        foreach ($fonts as $font) {
             $template_fonts[$font->font] = $font->display_name;
            if ($font->preselected) {
                $preselected_fonts[] = $font->font;
            }
        }

        $template = $this->service->getTemplateById($data['template_id']);

        $custom_block_options = json_decode($template->custom_block_options, true);

        $yes_no_options = [];

        if ($custom_block_options != []) {
            $yes_no_options = isset($custom_block_options[$data['pageid']][$data['blockname']]['custom_rules'])
                ? $custom_block_options[$data['pageid']][$data['blockname']]['custom_rules']
                : [];
        }

        $colorRepository = new ColorRepository();
        $colors          = $colorRepository->getAllColors();
        $template_colors = [];
        $preselected_colors = [];
        foreach ($colors as $color) {
            $template_colors[$color->id] = $color->title;
            if ($color->preselected) {
                $preselected_colors[] = $color->id;
            }
        }

        $textRepository = new EloquentTextRepository();
        $texts          = $textRepository->getAllTexts();
        $template_texts = [];
        $preselected_texts = [];
        foreach ($texts as $text) {
            $template_texts[$text->id] = $text->title;
            if ($text->preselected) {
                $preselected_texts[] = $text->id;
            }
        }
        $template_text_sets = TextSet::all();
        $text_sets = [];
        $preselected_text_sets = [];
        foreach ($template_text_sets as $text_set) {
            $text_sets[$text_set->id] = $text_set->name;
            if ($text_set->preselected) {
                $preselected_text_sets[] = $text_set->id;
            }
        }

        $viewData = $this->view('templates::admin.templates.block_custom_rules', compact('data', 'custom_rules',
            'template_fonts', 'template_colors', 'yes_no_options', 'preselected_fonts', 'preselected_colors',
            'template_texts', 'preselected_texts', 'text_sets', 'preselected_text_sets'
        ))->render();
        return response()->json([
            'success' => 1,
            'html' => $viewData
        ]);
        exit;
    }

    public function getPageCustomRulesUrl(Request $request)
    {
        $data = $request->all();
        $custom_rules = 1;

        $layoutRepository = new LayoutRepository();
        $layouts          = $layoutRepository->getAllLayouts();
        $template_layouts_content = array();
        $template_layouts_footer = array();
        $template_layouts_header = array();
        foreach ($layouts as $layout) {
            if ($layout['layout_type'] == "content") {
                $template_layouts_content[$layout->id] = $layout->name;
            }
            if ($layout['layout_type'] == "footer") {
                $template_layouts_footer[$layout->id] = $layout->name;
            }
            if ($layout['layout_type'] == "header") {
                $template_layouts_header[$layout->id] = $layout->name;
            }
        }

        $template_layouts = $template_layouts_content;

        $template = $this->service->getTemplateById($data['template_id']);

        $custom_page_options = json_decode($template->custom_page_options, true);

        $yes_no_options = [];

        if ($custom_page_options != []) {
            $yes_no_options = isset($custom_page_options[$data['pageid']]['custom_rules'])
                ? $custom_page_options[$data['pageid']]['custom_rules']
                : [];
        }

        $viewData = $this->view('templates::admin.templates.page_custom_rules', compact('data', 'template_layouts', 'template_layouts_content', 'template_layouts_footer', 'template_layouts_header', 'custom_rules', 'yes_no_options'))->render();
        return response()->json([
            'success' => 1,
            'html' => $viewData
        ]);
        exit;
    }

    public function savePageRulesAction(Request $request) {
        $success = false;
        $message = false;
        try {
            $data = $request->all();
            $template_id      = $data['template_id'];
            $pageid             = $data['pageid'];
            $editable_options = $data['editable_options'];

            $template = $this->service->getTemplateById($template_id);
            if ( $template ) {
                $pageOptions                        = json_decode($template->custom_page_options, true);
                $pageOptions[$pageid]['custom_rules'] = $editable_options;

                $template->custom_page_options = json_encode($pageOptions);
                $template->save();
                $success = true;
                throw new Exception(
                    'Custom Rules Successfully Saved.'
                );
            }
            else
                throw new Exception('Invalid Personalization Template!');
        } catch ( Exception $e ) {
            $message = $e->getMessage();
        }

        return response()->json(array(
            'success' => $success,
            'message' => $message
        ));

        return;
    }

    public function saveBlockRulesAction(Request $request) {
        $success = false;
        $message = false;
        try {
            $data = $request->all();
            $template_id      = $data['template_id'];
            $page             = $data['page'];
            $block_index      = $data['block_index'];
            $block_name       = $data['block_name'];
            $editable_options = $data['editable_options'];

            $template = $this->service->getTemplateById($template_id);
            if ( $template ) {
                $templateBlocks = json_decode($template->custom_block_options, true);
                $templateBlocks[$page][$block_name]['name'] = $block_name;
                $templateBlocks[$page][$block_name]['custom_rules'] = $editable_options;

                $template->custom_block_options = json_encode($templateBlocks);
                $template->save();
                $success = true;
                throw new Exception('Custom Rules Successfully Saved.');
            }
            else
                throw new Exception('Invalid Personalization Template.');
        } catch ( Exception $e ) {
            $message = $e->getMessage();
        }

        return response()->json(array(
            'success' => $success,
            'message' => $message
        ));

        return;
    }

    public function unbindPageRulesAction(Request $request) {
        $success = false;
        $message = false;
        try {
            $data = $request->all();
            $template_id      = $data['template_id'];
            $page             = $data['pageid'];
            $editable_options = $data['editable_options'];

            $template = $this->service->getTemplateById($template_id);
            if ( $template ) {
                $pageOptions                        = json_decode($template->custom_page_options, true);
                if (isset($pageOptions[$page])) {
                    unset($pageOptions[$page]);
                }

                $template->custom_page_options = json_encode($pageOptions);
                $template->save();
                $success = true;
                throw new Exception(
                    'Custom Rules Successfully Saved.'
                );
            }
            else
                throw new Exception('Invalid Personalization Template!');
        } catch ( Exception $e ) {
            $message = $e->getMessage();
        }

        return response()->json(array(
            'success' => $success,
            'message' => $message
        ));

        return;
    }

    public function unbindBlockRulesAction(Request $request) {
        $success = false;
        $message = false;
        try {
            $data = $request->all();
            $template_id      = $data['template_id'];
            $page             = $data['page'];
            $block_index      = $data['block_index'];
            $block_name       = $data['block_name'];
            $editable_options = $data['editable_options'];

            $template = $this->service->getTemplateById($template_id);
            if ( $template ) {
                $templateBlocks = json_decode($template->custom_block_options, true);
                if (isset($templateBlocks[$page][$block_name])) {
                    unset($templateBlocks[$page][$block_name]);
                }

                $template->custom_block_options = json_encode($templateBlocks);
                $template->save();
                $success = true;
                throw new Exception('Custom Rules Successfully Saved.');
            }
            else
                throw new Exception('Invalid Personalization Template.');
        } catch ( Exception $e ) {
            $message = $e->getMessage();
        }

        return response()->json(array(
            'success' => $success,
            'message' => $message
        ));

        return;
    }

    public function changeSetting(Request $request)
    {
        $data = $request->all();
        $template_ids = $except_ids = [];
        if (isset($data['template_ids'])) {
            $template_ids = explode(',', $data['template_ids']);
        }
        if (isset($data['except_ids'])) {
            $except_ids = explode(',', $data['except_ids']);
        }
        $filterData = $request->except('template_ids', 'page', 'except_ids', '_pjax');
        $query_params = http_build_query($filterData);

        $fontRepository = new FontRepository();
        $fonts          = $fontRepository->getAllFonts();
        $template_fonts = [];
        $preselected_fonts = [];
        foreach ($fonts as $font) {
            $template_fonts[$font->font] = $font->display_name . ' ';
            if ($font->preselected) {
                $preselected_fonts[] = $font->font;
            }
        }
        $textRepository = new EloquentTextRepository();
        $texts          = $textRepository->getAllTexts();
        $template_texts = [];
        $preselected_texts = [];
        foreach ($texts as $text) {
            $template_texts[$text->id] = $text->title;
            if ($text->preselected) {
                $preselected_texts[] = $text->id;
            }
        }

        $cmsRepository = new CmsRepository();
        $cms_all       = $cmsRepository->getAllCms();
        $template_cms  = [];
        foreach ($cms_all as $cms) {
            $template_cms[$cms->identifier] = $cms->identifier;
        }

        $colorRepository = new ColorRepository();
        $colors          = $colorRepository->getAllColors();
        $template_colors = [];
        $preselected_colors = [];
        foreach ($colors as $color) {
            $template_colors[$color->id] = $color->title;
            if ($color->preselected) {
                $preselected_colors[] = $color->id;
            }
        }

        $template_backgrounds = [];
        $preselected_backgrounds = [];
        $backgrounds          = $this->backgroundsService->list([]);

        if ($backgrounds && $backgrounds->count()) {
            foreach ($backgrounds as $background) {
                $template_backgrounds[$background->id] = $background->name;
                if ($background->preselected) {
                    $preselected_backgrounds[] = $background->id;
                }
            }
        }

        $shapeRepository = new ShapeRepository();
        $shapes          = $shapeRepository->getAllShapes();
        $template_shapes = [];
        $preselected_shapes = [];
        foreach ($shapes as $shape) {
            $template_shapes[$shape->id] = $shape->name;
            if ($shape->preselected) {
                $preselected_shapes[] = $shape->id;
            }
        }
        $articleFile        = public_path() . '/personalization/articleload_files/';
        $article_filesArray = glob($articleFile . '{*.xls,*.xlsx}', GLOB_BRACE);
        $article_files      = [];
        if (is_array($article_filesArray) && count($article_filesArray)) {
            foreach ($article_filesArray as $article) {
                $pathInfo              = pathinfo($article);
                $name                  = $pathInfo['basename'];
                $article_files [$name] = $name;
            }

        }
        $layoutRepository = new LayoutRepository();
        $layouts          = $layoutRepository->getAllLayouts();
        $template_layouts_content = array();
        $template_layouts_footer = array();
        $template_layouts_header = array();
        foreach ($layouts as $layout) {
            if ($layout['layout_type'] == "content") {
                $template_layouts_content[$layout->id] = $layout->name;
            }
            if ($layout['layout_type'] == "footer") {
                $template_layouts_footer[$layout->id] = $layout->name;
            }
            if ($layout['layout_type'] == "header") {
                $template_layouts_header[$layout->id] = $layout->name;
            }
        }

        $template_layouts = $template_layouts_content;

        $submodeRepository  = new SubmodelRepository();
        $submodels          = $submodeRepository->getAllSubmodels();
        $template_submodels = [];
        foreach ($submodels as $submodel) {
            $template_submodels[$submodel->id] = $submodel->name;
        }

        $refinementRepository = new RefinementRepository();
        $refinementsInstance  = $refinementRepository->getAllRefinements();
        $refinements_template = [];
        foreach ($refinementsInstance as $ref) {
            $refinements_template[$ref->id] = $ref->name;
        }

        $refinementRepository = new RefinementRepository();
        $refinementsInstance  = $refinementRepository->getAllRefinements();
        $refinements_template = [];
        foreach ($refinementsInstance as $ref) {
            $refinements_template[$ref->id] = $ref->name;
        }

        $template_shape_sets = ShapeSet::all();
        $shape_sets = [];
        $preselected_shape_sets = [];
        foreach ($template_shape_sets as $shape_set) {
            $shape_sets[$shape_set->id] = $shape_set->name;
            if ($shape_set->preselected) {
                $preselected_shape_sets[] = $shape_set->id;
            }
        }
        $template_font_sets  = FontSet::all();
        $font_sets = [];
        $preselected_font_sets = [];
        foreach ($template_font_sets as $font_set) {
            $font_sets[$font_set->id] = $font_set->name;
            if ($font_set->preselected) {
                $preselected_font_sets[] = $font_set->id;
            }
        }
        $template_color_sets = ColorSet::all();
        $color_sets = [];
        $preselected_color_sets = [];
        foreach ($template_color_sets as $color_set) {
            $color_sets[$color_set->id] = $color_set->name;
            if ($color_set->preselected) {
                $preselected_color_sets[] = $color_set->id;
            }
        }

        $template_text_sets = TextSet::all();
        $text_sets = [];
        $preselected_text_sets = [];
        foreach ($template_text_sets as $text_set) {
            $text_sets[$text_set->id] = $text_set->name;
            if ($text_set->preselected) {
                $preselected_text_sets[] = $text_set->id;
            }
        }
        $personalization_svg_live_template_files = getLiveSvgs();

        return $this->view('templates::admin.templates.change_setting', compact(
            'template_ids', 'except_ids', 'query_params', 'template_fonts',
            'template_colors', 'template_cms','template_backgrounds', 'article_files',
            'template_shapes', 'template_layouts', 'template_layouts_content', 'template_layouts_footer', 'template_layouts_header', 'template_submodels', 'refinements_template',
            'shape_sets', 'font_sets', 'color_sets', 'personalization_svg_live_template_files',
            'preselected_fonts', 'preselected_colors', 'preselected_backgrounds', 'preselected_shapes',
            'preselected_shape_sets', 'preselected_font_sets', 'preselected_color_sets',
            'template_texts', 'preselected_texts', 'text_sets', 'preselected_text_sets'
        ));
    }

    public function changeSettingUpdate(Request $request)
    {
        try {
            $data = $request->all();
            $this->service->changeSettings($data, $request);
            $route  = 'templates.index';
            $params = [];
            return $this->redirect($route, $params)
                    ->withFlashMessage(__('Templates setting Changed'))
                    ->withFlashType('success');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
