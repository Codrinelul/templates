<?php

namespace Modules\Templates\Services;

use Modules\Templates\Repositories\Groups\TemplategroupsRepository;
use Illuminate\Support\Facades\DB;
use Exception;

class TemplategroupsService
{
    
    // Template repository reference
    protected $repository;
    
    /**
     * Initializing the repository reference with interface
     *
     * @param TemplateRepository $templateRepo
     */
    public function __construct(TemplategroupsRepository $templategroupRepo)
    {
        $this->repository  = $templategroupRepo;
    }
    
    public function create(array $attributes)
    {
        return $this->repository->create($attributes);
    }
    
    public function update($data, $id)
    {
   
        $this->repository->update($data, $id);
        
    }
    
    public function list($attributes)
    {
        $q         = isset($attributes['q']) ? $attributes['q'] : null;
        $perPage   = isset($attributes['perPage']) ? $attributes['perPage'] : null;
        $groups = $this->repository->allOrSearch($q, $perPage);
        
        return $groups;
    }
    
    public function listAll()
    {
        $groups = $this->repository->getAllGroups();
        return $groups::get()->map->only(['id', 'code', 'name']);
    }
    
    public function getGroupById($id)
    {
        
        return $this->repository->findById($id);
    }
    
    public function deleteGroupById($id)
    {
        $this->repository->delete($id);
        //delete also images
    }
    
}
