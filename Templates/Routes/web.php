<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(
    ['middleware' => config('admin.filter.auth')], function () {

    Route::get(
        'templates/getpreviews', [
            'as'   => 'admin.templates.getpreviews',
            'uses' => 'Admin\TemplatesController@getPreviews',
        ]
    );
    Route::get(
        'templates/getpreviewssvg', [
            'as'   => 'admin.templates.getpreviewssvg',
            'uses' => 'Admin\TemplatesController@getPreviewsSvg',
        ]
    );
    Route::get(
        'templates/getblocksinfo', [
            'as'   => 'admin.templates.getblocksinfo',
            'uses' => 'Admin\TemplatesController@getBlocksInfo',
        ]
    );

    Route::get(
        'templates/api', [
            'as'   => 'api.templates.gettemplates',
            'uses' => 'Api\ApiController@index'
        ]
    );

    Route::post(
        'templates/getBlockCustomRulesUrl', [
            'as'   => 'admin.templates.getBlockCustomRulesUrl',
            'uses' => 'Admin\TemplatesController@getBlockCustomRulesUrl'
        ]
    );

    Route::post(
        'templates/getPageCustomRulesUrl', [
            'as'   => 'admin.templates.getPageCustomRulesUrl',
            'uses' => 'Admin\TemplatesController@getPageCustomRulesUrl'
        ]
    );

    Route::post(
        'templates/saveBlockCustomRulesUrl', [
            'as'   => 'admin.templates.saveBlockCustomRulesUrl',
            'uses' => 'Admin\TemplatesController@saveBlockRulesAction'
        ]
    );

    Route::post(
        'templates/savePageCustomRulesUrl', [
            'as'   => 'admin.templates.savePageCustomRulesUrl',
            'uses' => 'Admin\TemplatesController@savePageRulesAction'
        ]
    );

    Route::post(
        'templates/unbindBlockCustomRulesUrl', [
            'as'   => 'admin.templates.unbindBlockCustomRulesUrl',
            'uses' => 'Admin\TemplatesController@unbindBlockRulesAction'
        ]
    );

    Route::post(
        'templates/unbindPageCustomRulesUrl', [
            'as'   => 'admin.templates.unbindPageCustomRulesUrl',
            'uses' => 'Admin\TemplatesController@unbindPageRulesAction'
        ]
    );

    Route::resource(
        'templates', 'Admin\TemplatesController', [
            'except' => 'show',
            'names'  => [
                'index'   => 'admin.templates.index',
                'create'  => 'admin.templates.create',
                'store'   => 'admin.templates.store',
                'show'    => 'admin.templates.show',
                'update'  => 'admin.templates.update',
                'edit'    => 'admin.templates.edit',
                'destroy' => 'admin.templates.destroy'
            ],
        ]
    );
    Route::match(['get', 'post'],
        'templates/{id}/duplicate', [
            'as'   => 'admin.templates.duplicate',
            'uses' => 'Admin\TemplatesController@duplicate'
        ]
    );
    Route::get(
        'templates/{id}/preview/', [
            'as'   => 'admin.templates.preview',
            'uses' => 'Admin\TemplatesController@preview',
        ]
    );
    Route::get('changeSetting', [
        'as'   => 'admin.templates.changeSetting',
        'uses' => 'Admin\TemplatesController@changeSetting',
    ]);
    Route::post('changeSetting', [
        'as'   => 'admin.templates.changeSetting.update',
        'uses' => 'Admin\TemplatesController@changeSettingUpdate',
    ]);
    Route::resource(
        'templatesgroups', 'Admin\TemplatesgroupsController', [
            'except' => 'show',
            'names'  => [
                'index'   => 'admin.templatesgroups.index',
                'create'  => 'admin.templatesgroups.create',
                'store'   => 'admin.templatesgroups.store',
                'update'  => 'admin.templatesgroups.update',
                'edit'    => 'admin.templatesgroups.edit',
                'destroy' => 'admin.templatesgroups.destroy',
            ],
        ]
    );
    Route::get('templatesgroups', [
        'as'   => 'admin.templatesgroups.index',
        'uses' => 'Admin\TemplatesgroupsController@index',
    ])->middleware(config('admin.filter.pagination'));

}
);

Route::get(
    'templates/api/tdSettings', [
        'as'   => 'api.templates.tdSettings',
        'uses' => 'Api\ApiController@tdSettings'
    ]
);
Route::get(
    'templates/getRemoteTemplates', [
        'as'   => 'getRemoteTemplates',
        'uses' => 'RemoteApi\IndexController@getRemoteTemplates'
    ]
);
Route::get(
    'templates/getTemplatesForBundle', [
        'as'   => 'getTemplatesForBundle',
        'uses' => 'RemoteApi\IndexController@getTemplatesForBundle'
    ]
);
Route::get(
    'templates/api/isApiTemplatesEnabled', [
        'as'   => 'api.templates.isApiTemplatesEnabled',
        'uses' => 'Api\ApiController@isApiTemplatesEnabled'
    ]
);

