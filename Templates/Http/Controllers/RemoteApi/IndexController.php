<?php

namespace Modules\Templates\Http\Controllers\RemoteApi;

use App\Exceptions\LocalizedException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Templates\Helpers\RemoteApi\Templates;
use Modules\Templates\Services\TemplateService as TemplateService;

class IndexController extends Controller
{

    public function getRemoteTemplates(Request $request)
    {
        try {
            $helper          = app(Templates::class);
            $templateService = app(TemplateService::class);
            $categories      = $request->input('categories', []);

            if (!$categories) {
                throw new \Exception(__('Please specify categories'));
            }

            $template_id = $request->input('template', 0);
            $template    = $templateService->getTemplateById($template_id);

            if (!$template->id) {
                throw new \Exception(__('Please specify a valid template'));
            }

            $filters = array(
                'language'     => strtolower($request->input('locale', \App::getLocale())),
                'categories'   => (array)$categories,
                'color_family' => strtolower($request->input('color_family', null)),
                'product_type' => $template->api_product_type,
                'unit_type'    => $helper::UNIT_TYPES[printq_system_settings_value('calculation.measuring.measuring_system')]
            );

            $page         = $request->input('page', 1);
            $limit        = $request->input('perPage', 9);
            $packingModel = $request->input('packingModel', null);

            $templateData = $helper->getTemplates($filters, $limit, $page, $packingModel);

            $result = [
                'success' => 1,
                'data'    => $templateData
            ];

        } catch (LocalizedException $e) {
            $identifier = logExceptionAdditional($e, $request->all());
            $result     = [
                'success'          => 0,
                'error_code'       => $e->getCode(),
                'message'          => $e->getMessage(),
                'error_identifier' => $identifier,
            ];
        } catch (\Exception $e) {
            $identifier = logExceptionAdditional($e, $request->all());
            $result     = [
                'success'          => 0,
                'error_code'       => 'SERVER_ERROR',
                'message'          => 'An error has occured. '.$e->getMessage(),
                'error_identifier' => $identifier,
            ];
        }

        return response()->json($result);
    }

    public function getTemplatesForBundle()
    {
        print 123;
    }
}
