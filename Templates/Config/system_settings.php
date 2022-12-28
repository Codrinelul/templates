<?php
/**
 * @author        Theodor Flavian Hanu <th@cloudlab.at>.
 * @copyright     Copyright(c) 2020 CloudLab AG (http://cloudlab.ag)
 * @link          http://www.cloudlab.ag
 */

return [
    'editors' => [
        'fieldsets' => [
            'templates' => [
                'sort_order' => 10,
                'label'      => __('Templates'),
                'attributes' => [],
                'fields'     => [
                    'default_template_config' => [
                        'label'   => __('Default Template Configuration'),
                        'type'    => 'select',
                        'options' => \Modules\Templates\Entities\Template::orderBy('name', 'asc')->pluck('name', 'id'),
                    ]
                ]
            ]
        ]
    ]
];
