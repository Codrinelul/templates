<?php

namespace Modules\Templates\Helpers\RemoteApi;

class Templates extends Base
{

    const CACHE_TAG = 'PRINTQ_REMOTE_TEMPLATES';

    const UNIT_TYPE_METRIC   = 1;
    const UNIT_TYPE_IMPERIAL = 2;
    const UNIT_TYPES         = array(self::UNIT_TYPE_METRIC => 'metric', self::UNIT_TYPE_IMPERIAL => 'imperial');

    public function getTemplates($filters = array(), $limit = null, $page = null, $model = null)
    {
        try {

            $data = [];
            if ($limit) {
                $data['perPage'] = intval($limit);
            }
            if ($page) {
                $data['page'] = intval($page);
            }
            if ($filters) {
                $data['filters'] = $filters;
            }
            if ($model) {
                $data['packingModel'] = $model;
            }
            if(!$data['filters']) {
                $data['filters'] = [];
            }
            $data['filters']['language'] = printq_system_settings_value('servers.templates_api.api_language');

            $cache       = app(CacheService::class);
            $canUseCache = (bool)printq_system_settings_value('editors.cache.use_cache', false);
            $cacheKey    = 'printq_templates_'.md5(http_build_query($data));

            if ($canUseCache && $cache->has(static::CACHE_TAG, $cacheKey)) {
                return $cache->get(static::CACHE_TAG, $cacheKey);
            }

            $response = $this->makeRequest('templates', $data, [], false);

            $result = json_decode($response, true);
            if (isset($result['success']) && $result['success']) {
                $canUseCache && $cache->put(static::CACHE_TAG, $cacheKey, $result['data']);
                return $result['data'];
            }

            return [];
        } catch (\Exception $e) {
            return [];
        }
    }

    public function getTemplatesInSameBundle($templateId, $limit = null, $page = null)
    {
        try {

            if (!$templateId) {
                throw new Exception($this->__('Please provide a template'));
            }
            $data = [];
            if ($limit) {
                $data['perPage'] = intval($limit);
            }
            if ($page) {
                $data['page'] = intval($page);
            }

            $cache       = app(CacheService::class);
            $canUseCache = (bool)printq_system_settings_value('editors.cache.use_cache', false);
            $cacheKey    = 'printq_templates_in_same_bundle_'.$templateId;

            if ($canUseCache && $cache->has(static::CACHE_TAG, $cacheKey)) {
                return $cache->get(static::CACHE_TAG, $cacheKey);
            }
            $response = $this->makeRequest('templates/templatesInSameBundle/'.$templateId, $data, [], false);

            $result = json_decode($response, true);
            if (isset($result['success']) && $result['success']) {
                $canUseCache && $cache->put(static::CACHE_TAG, $cacheKey, $result['data']);

                return $result['data'];
            }

            return [];
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * @param $templateId
     *
     * @return array|mixed
     * @throws \Exception
     * @throws \Zend_Cache_Exception
     * @throws \Zend_Json_Exception
     */
    public function getTemplateData($templateId)
    {
        if (!$templateId) {
            throw new Exception('Please provide a template');
        }
        $data = ['with_parsed_content' => true];

        $cache       = app(CacheService::class);
        $canUseCache = (bool)printq_system_settings_value('editors.cache.use_cache', false);
        $cacheKey    = 'printq_template_content_'.$templateId;

        if ($canUseCache && $cache->has(static::CACHE_TAG, $cacheKey)) {
            return $cache->get(static::CACHE_TAG, $cacheKey);
        }
        $response = $this->makeRequest('templates/details/'.$templateId, $data, [], false);

        $result = json_decode($response, true);
        if (!isset($result['success']) || !$result['success']) {
            throw new Exception('Cannot retrieve template content');
        }
        $canUseCache && $cache->put(static::CACHE_TAG, $cacheKey, $result['data']);

        return $result['data'];
    }

    /**
     * @param               $pagesContent string|object|array themePageContent from designer
     * @param               $file         string
     * @param               $template_id
     * @param  null|number  $customerId   Current customer id, null if guest
     *
     * @return array|bool Array containing saved personalization id if successful, false on error
     * @throws \Zend_Json_Exception
     */
    public function savePersonalization($pagesContent, $file, $template_id, $customerId = null)
    {
        $pagesContent = !is_string($pagesContent) ? json_encode($pagesContent) : $pagesContent;
        $requestData  = [
            'content_json' => $pagesContent,
            'file'         => $file,
            'template_id'  => $template_id
        ];

        if ($customerId) {
            $requestData['customer_id'] = $customerId;
        }
        $response = $this->makeRequest('templates/storePersonalization', $requestData, [], true);
        $result   = json_decode($response, true);
        if (isset($result['success']) && $result['success']) {
            return $result['data'];
        }

        return false;
    }

    public function getPdf($personalizedId)
    {
        $requestData = [
            'personalization_id' => $personalizedId
        ];

        $response = $this->makeRequest('templates/downloadPdf', $requestData, [], false);

        $response = json_decode($response, true);

        if (!empty($response['success']) && $response['success']) {
            //if success then response should contain ['data']['pdf']
            return $response['data']['pdf'];
        }

        return false;
    }

}
