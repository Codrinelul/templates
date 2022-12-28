<?php

namespace Modules\Templates\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseModuleController;
use Illuminate\Http\Request;
use Modules\Templates\Http\Validation\Groups\Create;
use Modules\Templates\Http\Validation\Groups\Update;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Input;
use Modules\Templates\Services\TemplategroupsService;
use Exception;


class TemplatesgroupsController extends BaseModuleController
{


    protected $service;


    public function __construct(TemplategroupsService $service)
    {
        $this->service            = $service;

    }

    /**
     * Get repository instance.
     *
     * @return mixed
     */
    public function getRepository()
    {
        $repository = 'App\Http\Repositories\Templates\TemplateRepository';

        return app($repository);
    }

    /**
     * Redirect not found.
     *
     * @return Response
     */
    protected function redirectNotFound()
    {
        return $this->redirect('templatesgroups.index')
            ->withFlashMessage('Template Group not found!')
            ->withFlashType('danger');
    }

    /**
     * Display a listing of templates.
     *
     * @return Response
     */
    public function index()
    {
        $q         = $this->getSessionField('q');
        $perPage   = $this->getSessionField('perPage');
        $groups = $this->service->list(['q' => $q, 'perPage' => $perPage]);

        return $this->view('templates::admin.templates.groups.index', compact('groups', 'no', 'q', 'perPage'));
    }

    public function getTemplateRepository()
    {
        $repository = 'Modules\Templates\Repositories\TemplateRepository';
        return app($repository);
    }
    /**
     * Show the form for creating a new template.
     *
     * @return Response
     */
    public function create()
    {
        $templatesRepository =$this->getTemplateRepository();
        $all_templates          = $templatesRepository->getAllTemplates()->get();
        $templates = array();
        foreach ($all_templates as $template) {
            $templates[$template->id] = $template->name;
        }
        return $this->view(
            'templates::admin.templates.groups.create', compact(
                'templates'
            )
        );
    }

    /**
     * Store a newly created template in storage.
     *
     * @return Response
     */
    public function store(Create $request)
    {

        $data    = $request->all();
        if (empty($data['description'])) {
            $data['description'] = '';
        }
        $templateInstance = $this->service->create($data);
        if (isset($data['redirect']) && $data['redirect'] == 'list') {
            return $this->redirect('templatesgroups.index');
        } else {
            return $this->redirect('templatesgroups.edit', array($templateInstance->id));
        }
    }

    /**
     * Show the form for editing the specified template.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id, Request $request)
    {
        try {
            $group = $this->service->getGroupById($id);
            $templatesRepository = $this->getTemplateRepository();
            $all_templates = $templatesRepository->getAllTemplates()->get();
            $templates = array();
            foreach ($all_templates as $template) {
                $templates[$template->id] = $template->name;
            }
            return $this->view(
                'templates::admin.templates.groups.edit', compact(
                    'templates', 'group'
                )
            );
        } catch (ModelNotFoundException $e) {
            return $this->redirectNotFound();
        }
    }

    /**
     * Update the specified template in storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function update(Update $request, $id)
    {
        try {
            $data = $request->all();
            if (empty($data['description'])) {
                $data['description'] = '';
            }
            $this->service->update($data,$id);

            if (isset($data['redirect']) && $data['redirect'] == 'list') {

                return $this->redirect('templatesgroups.index');
            }

            return $this->redirect('templatesgroups.edit');
        } catch (ModelNotFoundException $e) {
            return $this->redirectNotFound();
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified template from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id, Request $request)
    {
        try {
            $this->service->deleteGroupById($id);
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'data'    => [
                        'deleted' => true
                    ]
                ]);
            }

            return $this->redirect('templatesgroups.index');
        } catch (ModelNotFoundException $e) {
            return $this->redirectNotFound();
        }
    }

}
