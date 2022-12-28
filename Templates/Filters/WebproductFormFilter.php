<?php

namespace Modules\Templates\Filters;

use Modules\Templates\Services\TemplateService;

class WebproductFormFilter
{

    protected $service = null;

    public function __construct(TemplateService $service)
    {
        $this->service = $service;
    }

    public function addTemplateFields($fieldsets)
    {
        $fieldset = [
            'print_product_setup' => [
                'fields' => [
                    'personalization_template' => [
                        'type' => 'select',
                        'use_parent_name' => false,
                        'name' => 'webproduct[personalization_template]',
                        'label' => __('Personalization Template '),
                        'multiple' => true,
                        'field_options' => ['class' => 'form-control', 'multiple' => true],
                        'options' => $this->getTemplateOptions(),
                        'form_group_attributes' => [
                            'data-depends' => "[{'#personalize':{'type':'equal', 'value':[1]}}]"
                        ],
                        'select_attributes' => [
                            'class' => 'select2-js form-control'
                        ]
                    ],
                    'template_chooser' => [
                        'name' => 'webproduct[template_chooser]',
                        'use_parent_name' => false,
                        'type' => 'select',
                        'label' => __('Enable Template Chooser'),
                        'html_attributes' => [
                            'data-depends' => "[{'#personalize':{'type':'equal', 'value':[1]}}]"
                        ],
                        'options' => [
                            '0' => __('No'),
                            '1' => __('Yes'),
                        ]
                    ]
                ]
            ],
        ];

        $fieldsets = array_replace_recursive($fieldsets, $fieldset);

        $fieldsets = \Eventy::filter('webproduct-form-fieldset-templates', $fieldsets);
        return $fieldsets;
    }

    protected function getTemplateOptions()
    {
        $templates = $this->service->listAll();
        $result = [];
        if ($templates) {
            foreach ($templates as $template) {
                $result[$template['id']] = $template['name'] . ' (' . $template['code'] . ')';
            }
        } else {
            $result = [__('No templates were found!')];
        }

        return $result;
    }
}
