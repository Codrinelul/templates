<?php
/**
 * @author        Theodor Flavian Hanu <th@cloudlab.at>.
 * @copyright     Copyright(c) 2020 CloudLab AG (http://cloudlab.ag)
 * @link          http://www.cloudlab.ag
 */

namespace Modules\Templates\Filters;


use Modules\Templates\Entities\Template;

class WebproductGetConfigFilter
{
    public function addTemplateOptionsToWebproductConfig($result, $request, $webproduct)
    {
        $templates                  = $webproduct->personalization_template;
        $result['template_chooser'] = $webproduct->template_chooser;
        $templatesArray             = [];
        if ($templates) {
            $templatesArray = Template::whereIn('id', (array)$templates)
                                      ->pluck('name', 'id')
                                      ->toArray();
            $template_id    = null;
            if (count($templatesArray)) {
                $template_id = array_keys($templatesArray)[0];
            }
            $template = Template::find($template_id);
            if ($template) {
                if ($template->preview_type === 'tdpreview') {
                    $td_data = array();
                    $td_textures = json_decode($template->td_data, true);
                    if (!empty($td_textures)) {
                        $td_data=[];
                        if(is_array($td_textures)){
                            for ($x = 1; $x < count($td_textures); $x += 2) {
                                $td_data[$td_textures[$x]] = $td_textures[$x - 1];
                            }
                        }
                    }

                    $result['template_config'] = [
                        'td_filename' => $template->td_filename,
                        'td_data'     => $td_data
                    ];
                }
            }
        }
        $result['template'] = $templatesArray;
        return $result;
    }
}
