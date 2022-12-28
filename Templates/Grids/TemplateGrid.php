<?php

namespace Modules\Templates\Grids;

use Closure;
use Modules\PrintqCore\Grids\BaseAdminGrid;
use Modules\Grid\Buttons\GenericButton;


class TemplateGrid extends BaseAdminGrid implements TemplateGridInterface
{

    /**
     * The name of the grid
     *
     * @var string
     */
    protected $name = 'Templates';

    /**
     * List of buttons to be generated on the grid
     *
     * @var array
     */
    protected $buttonsToGenerate = [
        'create',
        'view',
        'delete',
        'refresh',
        'duplicate',
        //'export'
    ];

    /**
     * Specify if the rows on the table should be clicked to navigate to the record
     *
     * @var bool
     */
    protected $linkableRows = false;

    /**
     * Set the columns to be displayed.
     *
     * @return void
     * @throws \Exception if an error occurs during parsing of the data
     */
    public function setColumns()
    {
        $this->columns = [
            'id'              => [
                'label'     => __('Id'),
                'filter' => [
                    'enabled'  => true,
                    'operator' => '='
                ],
                'styles' => [
                    "column" => "gridTemplateIdCol"
                ],
                'export' => false
            ],
            'name'            => [
                'label'     => __('Name'),
                'search' => [
                    'enabled' => true
                ],
                'filter' => [
                    'enabled'  => true,
                    'operator' => 'like'
                ],
                'styles' => [
                    "column" => "gridTemplateNameCol"
                ],
            ],
            'code'            => [
                'label'     => __('Code'),
                'search' => [
                    'enabled' => true
                ],
                'filter' => [
                    'enabled'  => true,
                    'operator' => 'like'
                ],
                'styles' => [
                    "column" => "gridTemplateCodeCol"
                ],
            ],
            'template_type'   => [
                'label'     => __('Type'),
                'filter'    => [
                    'enabled'  => true,
                    'operator' => '=',
                    'type'     => 'select',
                    'data'     => ['svg' =>'Svg', 'pdf' => 'Pdf', 'indesign' => 'Indesign']
                ],
                "presenter" => function ($columnData, $columnName) {
                    return ucfirst($columnData->template_type);
                },
                'styles' => [
                    "column" => "gridTemplateTypeCol"
                ],
            ],
            'engine'          => [
                'label'     => __('Editor'),
                'filter'    => [
                    'enabled'  => true,
                    'operator' => 'like',
                    'type'     => 'select',
                    'data'     => ['Designer' => 'Designer', 'Otp' => 'Otp', 'Formular' => 'Formular', 'Brochure' => 'Brochure', 'Pdf_vt' => 'PDF/VT']
                ],
                "presenter" => function ($columnData, $columnName) {
                    return ucfirst($columnData->engine);
                },
                'styles' => [
                    "column" => "gridTemplateEngineCol"
                ],
            ],
            'template_source' => [
                'label'  => __('Template Source'),
                'filter' => [
                    'enabled'  => true,
                    'operator' => 'like',
                    'type'     => 'select',
                    'data'     => ['Own' => 'Own', 'Api' => 'Api']
                ],
                'styles' => [
                    "column" => "gridTemplateSourceCol"
                ],
            ]
        ];
    }

    /**
     * Set the links/routes. This are referenced using named routes, for the sake of simplicity
     *
     * @return void
     */
    public function setRoutes()
    {
        // searching, sorting and filtering
        $this->setIndexRouteName('admin.templates.index');
        $this->setCreateRouteName('admin.templates.create');
        $this->setViewRouteName('admin.templates.edit');
        $this->setDeleteRouteName('admin.templates.destroy');

        // default route parameter
        $this->setDefaultRouteParameter('id');
    }

    /**
     * Return a closure that is executed per row, to render a link that will be clicked on to execute an action
     *
     * @return Closure
     */
    public function getLinkableCallback(): Closure
    {
        return function ($gridName, $item) {
            return route($this->getViewRouteName(), [$item->option_id]);
        };
    }

    /**
     * Configure rendered buttons, or add your own
     *
     * @return void
     */
    public function configureButtons()
    {
        // call `addRowButton` to add a row button
        // call `addToolbarButton` to add a toolbar button
        // call `makeCustomButton` to do either of the above, but passing in the button properties as an array

        // call `editToolbarButton` to edit a toolbar button
        // call `editRowButton` to edit a row button
        // call `editButtonProperties` to do either of the above. All the edit functions accept the properties as an array

        $this->addRowButton('preview', $this->addPreviewButton());
        $this->addRowButton('duplicate', $this->addDuplicateButton());
    }

    public function addPreviewButton()
    {
        return (new GenericButton([
            'gridId'       => $this->getId(),
            'position'     => 0,
            'type'         => static::$TYPE_ROW,
            'renderIf'     => function ($gridName, $item) {
                return true;
            },
            'name'         => __('Preview'),
            'title'        => __('Preview'),
            'renderCustom' => function ($data) {
                $templateUrl = route('admin.templates.preview', $data[0]['gridItem']['id']);
                return view('templates::admin.templates.preview_button', compact('templateUrl'))->render();
            },
        ]));
    }

    public function addDuplicateButton()
    {
        return (new GenericButton([
            'name'      => __('Duplicate'),
            'icon'      => 'fa-copy',
            'position'  => 1,
            'type'      => static::$TYPE_ROW,
            'class'     => 'btn btn-primary btn-sm grid-row-button text-capitalize mr-2',
            'showModal' => false,
            'gridId'    => $this->getId(),
            'title'     => __('Duplicate'),
            'url'       => function ($gridName, $gridItem) {
                return route('admin.templates.duplicate', [$gridItem->id]);
            },
            'renderIf'  => function ($gridName, $item) {
                return in_array('duplicate', $this->buttonsToGenerate);
            }
        ]));
    }


    /**
     * Returns a closure that will be executed to apply a class for each row on the grid
     * The closure takes two arguments - `name` of grid, and `item` being iterated upon
     *
     * @return Closure
     */
    public function getRowCssStyle(): Closure
    {
        return function ($gridName, $item) {
            // e.g, to add a success class to specific table rows;
            // return $item->option_id % 2 === 0 ? 'table-success' : '';
            return '';
        };
    }

}
