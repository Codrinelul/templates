<?php

namespace Modules\Templates\Repositories\Groups;

use GuzzleHttp\Client;
use Mockery\CountValidator\Exception;
use Modules\Templates\Entities\Templategroups;

class EloquentTemplategroupsRepository implements TemplategroupsRepository
{
    
    protected $model;
    
    public function __construct(Templategroups $model)
    {
        $this->model = $model;
        
    }
    
    public function perPage()
    {
        return config('admin.templategroups.perpage');
    }
    
    public function allOrSearch($searchQuery = null, $perPage = null)
    {
        if (is_null($searchQuery)) {
            return $this->getAll($perPage);
        }
        
        return $this->search($searchQuery, $perPage);
    }
    
    public function getAll($perPage = null)
    {
        if ($perPage == null) {
            return $this->model->paginate($this->perPage());
        }
        
        return $this->model->paginate($perPage);
    }
    
    public function getAllGroups()
    {
        return $this->model;
    }
    
    public function search($searchQuery, $perPage = null)
    {
        $search = "%{$searchQuery}%";
        
        if ($perPage == null) {
            return $this->model->where('name', 'like', $search)
                ->orWhere('code', 'like', $search)
                ->orWhere('description', 'like', $search)
                ->orWhere('id', '=', $searchQuery)
                ->paginate($this->perPage());
        }
        
        return $this->model->where('name', 'like', $search)
            ->orWhere('code', 'like', $search)
            ->orWhere('description', 'like', $search)
            ->orWhere('id', '=', $searchQuery)
            ->paginate($perPage);
    }
    
    public function findById($id)
    {
        
        return $this->model->find($id);
    }
    
    public function findBy($key, $value, $operator = '=')
    {
        return $this->model->where($key, $operator, $value)->paginate($this->perPage());
    }
    
    public function delete($id)
    {
        $template = $this->findById($id);
        
        if (!is_null($template)) {
            $template->delete();
            
            return true;
        }
        
        return false;
    }
    
    public function create(array $data, $id = null)
    {
        if ($id) {
            $templateGroupsInstance = $this->findById($id);
        } else {
            $templateGroupsInstance = $this->model;
        }
        $templateGroupsInstance->name        = $data['name'];
        $templateGroupsInstance->code        = $data['code'];
        $templateGroupsInstance->description = isset($data['description']) ? $data['description'] : "";
        $templateGroupsInstance->templates   = isset($data['templates']) && count($data['templates']) ? implode(",", $data['templates']) : implode(",", []);
        $templateGroupsInstance->save();
        return $templateGroupsInstance;
    }
    
    public function update($data, $id)
    {
        $this->create($data, $id);
    }
    
    
}
