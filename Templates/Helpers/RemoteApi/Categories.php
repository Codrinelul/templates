<?php

namespace Modules\Templates\Helpers\RemoteApi;

class Categories extends Base
{

    const CACHE_TAG = 'PRINTQ_REMOTE_CATEGORIES';

    public function getCategories($filters = array(), $limit = null, $page = null, $language = 'en_us', $product_type = null )
    {
        try {
            $data = [];
            if ($limit) {
                $data['limit'] = intval($limit);
            }
            if ($page) {
                $data['page'] = intval($page);
            }
            if ($filters) {
                $data['filters'] = $filters;
            }
//            if($language) {
//                $data['language'] = $language;
//            }
            $data['language'] = printq_system_settings_value('servers.templates_api.api_language');
            if($product_type) {
                $data['product_type'] = $product_type;
            }

            $cache       = app(CacheService::class);
            $canUseCache = (bool)printq_system_settings_value('editors.cache.use_cache', false);
            $cacheKey    = 'printq_categories_'.md5(http_build_query($data));

            if ($canUseCache && $cache->has(static::CACHE_TAG, $cacheKey)) {
                return $cache->get(static::CACHE_TAG, $cacheKey);
            }

            $response = $this->makeRequest('categories', $data, [], false);

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

    public function getCategoriesForTree($selected = [])
    {

        $apiCategories    = [];
        $remoteCategories = $this->getCategories();

        foreach ($remoteCategories as $remoteCategory) {

			$translated = __('cat_' . $remoteCategory['name']);
            if('cat_' . $remoteCategory['name'] == $translated) {
                $translated = $remoteCategory['name'];
            }

            $tmpCat   = array(
                'id'       => (int)$remoteCategory['id'],
                'text'     => $this->translateCategoryName($remoteCategory['name'], 'cat_'),
                'icon'     => 'x-tree-noicon',
                'state'    => [
                    'opened'   => false,
                    'selected' => in_array($remoteCategory['id'], $selected) || in_array("all", $selected)
                ],
                'children' => array()
            );
            $children = array();
            foreach ($remoteCategory['children'] as $child) {
                $children[] = array(
                    'id'    => (int)$child['id'],
                    'text'  => $this->translateCategoryName($child['name'], 'subcat_'),
                    'icon'  => 'x-tree-noicon',
                    'state' => [
                        'opened'   => false,
                        'selected' => in_array($child['id'], $selected) || in_array("all", $selected)
                    ]
                );
            }
			usort($children, [$this,'namecmp']);
            $tmpCat['children'] = $children;
            $apiCategories[]    = $tmpCat;
        }

		usort($apiCategories, [$this,'namecmp']);

        return $apiCategories;
    }

	public function translateCategoryName($name, $prefix)
    {
        $translated = __($prefix . $name);
        if ($prefix . $name == $translated) {
            $translated = $name;
        }
        return $translated;
    }

	public function namecmp($a, $b)
	{
		if ($a['text'] == $b['text']) {
			return 0;
		}

    return ($a['text'] < $b['text']) ? -1 : 1;
	}

}
