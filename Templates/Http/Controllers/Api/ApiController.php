<?php

    namespace Modules\Templates\Http\Controllers\Api;

    use Illuminate\Http\Request;
    use Illuminate\Http\Response;
    use Illuminate\Routing\Controller;
    use Modules\Templates\Services\TemplateService;
    use Modules\JwtToken\Services\JwtTokenService;

    class ApiController extends Controller
    {

        protected $service;
        protected $jwtTokenService;

        public function __construct(TemplateService $service, JwtTokenService $jwtTokenService)
        {
            $this->service = $service;
            $this->jwtTokenService = $jwtTokenService;
        }

        public function index()
        {

            try {
                $templates = $this->service->listAll();
                $map       = [];
                foreach ($templates as $template) {
                    $map[$template['id']] = $template['code'];
                }

                return $map;
            } catch (\Exception $e) {
                return [];
            }
        }

        public function apitypes()
        {
            try {
                $templates = $this->service->listAll(['id', 'code', 'name', 'template_type', 'engine']);
                $map       = [];
                foreach ($templates as $template) {
                    $map[$template['id']] = 
                        [
                            'code' => $template['code'],
                            'template_type' => $template['template_type'],
                            'engine' => $template['engine'],
                    ];                
                }

                return $map;
            } catch (\Exception $e) {
                return [];
            }
        }

        public function tdSettings(Request $request)
        {
            $data        = $request->all();
            $template_id = isset($data['template_id']) && $data['template_id'] ? $data['template_id'] : false;
            $result      = array(
                'success' => 1,
                'data'    => '',
                'message' => __('Success!')
            );
            try {

                $templateInstance = $this->service->getTemplateById($template_id);
                if (!$templateInstance) {
                    throw new \Exception('Tempalte not found!');
                }

                $result['data'] = $templateInstance->td_data;


            } catch (\Exception $e) {
                $result['success'] = 0;
                $result['message'] = $e->getMessage();
            }
            echo json_encode($result);
            exit;
        }
        
        public function isApiTemplatesEnabled(Request $request){
            $data        = $request->all();
            $result      = array(
                'success'       => 1,
                'is_enabled'    => 0,
                'message'       => __('Success!')
            );
            try {

                $is_enabled = printq_system_settings_value('servers.templates_api.enable_api', 0);
                $result['is_enabled'] = $is_enabled;

            } catch (\Exception $e) {
                $result['is_enabled'] = 0;
                $result['success']    = 0;
                $result['message']    = $e->getMessage();
            }
            echo json_encode($result);
            exit;
        }

        public function getProjects()
        {

        }

        public function list(Request $request)
        {
            $attributes = $request->all();

            $jwt = self::getAttribute($attributes, 'jwt', false);

            if (!$jwt) {
                throw new \Exception('Bad data');
            }
    
            $tokenData = $this->jwtTokenService->decodeDataFromJwt($jwt);
            if( !isset($tokenData['token']) || !$tokenData['token']) {
                throw new \Exception('Bad data - missing token');
            }

           return $this->index();
        }

        static function getAttribute($attributes, $key, $default = null)
        {
            return isset($attributes[$key]) ? $attributes[$key] : $default;
        }

    }
