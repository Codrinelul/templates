<?php

namespace Modules\Templates\Helpers\RemoteApi;

class ProductTypes extends Base
{

    const UNIT_TYPE_METRIC   = 1;
    const UNIT_TYPE_IMPERIAL = 2;
    const UNIT_TYPES         = array(self::UNIT_TYPE_METRIC => 'metric', self::UNIT_TYPE_IMPERIAL => 'imperial');

    const CACHE_TAG = 'PRINTQ_REMOTE_PRODUCT_TYPES';
    const SVG_PATH  = 'product_types'.DIRECTORY_SEPARATOR.'svg';

    public function getAll()
    {
        try {
            $cache       = app(CacheService::class);
            $canUseCache = (bool)printq_system_settings_value('editors.cache.use_cache', false);
            $cacheKey    = 'printq_product_types';
            if ($canUseCache && $cache->has(static::CACHE_TAG, $cacheKey)) {
                return $cache->get(static::CACHE_TAG, $cacheKey);
            }
            $response = $this->makeRequest('product_types', [], [], false);
            $result   = json_decode($response, true);
            if (isset($result['success']) && $result['success']) {
                $canUseCache && $cache->put(static::CACHE_TAG, $cacheKey, $result['data']);
                return $result['data'];
            }
            return [];
        } catch (\Exception $e) {
            return [];
        }
    }

    public function getTreeForSelect()
    {

        $product_types = $this->getAll();

        $productTypesTree = [];
        foreach ($product_types as $productType) {
            if (!empty($productType['children'])) {
                $values = [];
                foreach ($productType['children'] as $child) {
                    $values[$child['code']] = $child['name'];
                }

                $productTypesTree[$productType['name']] = $values;
            }
        }
        return $productTypesTree;


    }

    /**
     * @param        $code
     * @param  bool  $forceRetrieve
     *
     * @return bool|string
     * @throws Exception
     */
    public function getPreviewSvg($code, $forceRetrieve = false)
    {
        $svgRelativePath = 'api/product_types/svg/'.$code.'.svg';
        $storageDisk     = \Storage::disk('public');
        if (!$forceRetrieve && $storageDisk->exists($svgRelativePath)) {
            return $storageDisk->get($svgRelativePath);
        }

        $dir = dirname($svgRelativePath);
        if (!$storageDisk->exists($dir)) {
            if (!$storageDisk->makeDirectory($dir, 0744, true)) {
                throw new Exception('cannot create product type preview svg directory');
            }
        }

        $productTypes = $this->getAll();

        if (is_array($productTypes)) {
            foreach ($productTypes as $rootProductType) {
                if (!empty($rootProductType['children'])) {
                    foreach ($rootProductType['children'] as $child) {
                        if ($code == $child['code']) {
                            if (!empty($child['preview_svg'])) {
                                $svg = file_get_contents($child['preview_svg']);
                                $storageDisk->put($svgRelativePath, $svg);
                                return $svg;
                            }
                            return false;
                        }
                    }
                }
            }
        }
        return false;
    }
}
