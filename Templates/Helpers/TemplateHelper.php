<?php

namespace Modules\Templates\Helpers;

use App\Services\PersonalizationService;
use Modules\Templates\Helpers\RemoteApi\Categories;
use Ramsey\Uuid\Uuid;

class TemplateHelper
{
    public static function pdf2Json($pdf)
    {

    }

    public function getCategoryTree($template)
    {
        if ($cats = $template->api_categories) {
            $selectedCategories = json_decode($cats, true);
            $allCategories      = false;
            if (count($selectedCategories) && $selectedCategories[0] == 'all') {
                $allCategories = true;
            }

            $categoriesHelper = app(Categories::class);
            $language         = \App::getLocale();
            $categories       = $categoriesHelper->getCategories([], null, null, $language, $template->api_product_type);

            $catTree = array();

            foreach ($categories as $category) {
                $tmpCat = array(
                    'id'       => $category['id'],
                    'text'     => $categoriesHelper->translateCategoryName($category['name'], 'cat_'),
                    'leaf'     => false,
                    'children' => array()
                );

                $includeCategory = $allCategories || array_search($category['id'], $selectedCategories) !== false;
                if (isset($category['children']) && count($category['children'])) {
                    foreach ($category['children'] as $child) {
                        if ($allCategories || array_search($child['id'], $selectedCategories)) {
                            $includeCategory      = true;
                            $tmpCat['children'][] = array(
                                'id'   => $child['id'],
                                'leaf' => true,
                                'text' => $categoriesHelper->translateCategoryName($child['name'], 'subcat_'),
                            );
                        }

                    }

				usort($tmpCat['children'], [$categoriesHelper,'namecmp']);
                }
                if ($includeCategory) {
                    $catTree[] = $tmpCat;
                }
            }
			usort($catTree, [$categoriesHelper,'namecmp']);

            return $catTree;

        }

        return [];

    }

    public function getSecureParam()
    {
        $secure = false;
        if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
            $secure = true;
        }
        return $secure;
    }

    public function getApiEditUrl($template, $data)
    {
        $additional_data              = PersonalizationService::getAttribute($data, 'additional_data', []);
        $additional_data['pqApiTmpl'] = $template->id;
        $additional_data['store_code'] = \Store::getStoreCode();
        $data['ApiKey']               = printq_system_settings_value('servers.templates_api.api_key');
        $data['additional_data']      = base64_encode(json_encode($additional_data));

        $params = [
            'ApiKey'            => printq_system_settings_value('servers.templates_api.api_key'),
            'additional_data'   => base64_encode(json_encode($additional_data)),
            'success_url'       => PersonalizationService::getAttribute($data, 'success_url', ''),
            'cancel_url'        => PersonalizationService::getAttribute($data, 'cancel_url', ''),
            'theme'             => PersonalizationService::getAttribute($data, 'theme', 'default'),
            'locale'            => PersonalizationService::getAttribute($data, 'locale', 'de'),
            'customer'          => PersonalizationService::getAttribute($data, 'customer', Uuid::uuid4()->getHex()),
            'text_replacements' => PersonalizationService::getAttribute($data, 'text_replacements', []),
            'store_code'        => \Store::getStoreCode()
        ];

        return printq_system_settings_value('servers.templates_api.api_url').'openEditor?templateId={{template-id}}&'.http_build_query($params);

    }
}
