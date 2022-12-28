<?php
/**
 * @author        Theodor Flavian Hanu <th@cloudlab.at>.
 * @copyright     Copyright(c) 2020 CloudLab AG (http://cloudlab.ag)
 * @link          http://www.cloudlab.ag
 */

\Eventy::addFilter('webproduct-form-fieldsets', 'Modules\Templates\Filters\WebproductFormFilter@addTemplateFields', 40, 1);
\Eventy::addFilter('webproduct-get-config', 'Modules\Templates\Filters\WebproductGetConfigFilter@addTemplateOptionsToWebproductConfig', 40, 3);
