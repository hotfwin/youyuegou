<?php

namespace App\Controllers;

class Menus extends FortuneController
{
    public function index($parent = 0)
    {
        $this->orderBy = 'order_by ASC';
        $this->where['parent'] = $parent;

        $this->data['parent'] = $parent;
        parent::index();
    }

    public function create($parent = 0)
    {

        $this->data['parent'] = $parent;
        $this->model = new \App\Models\MenusModel();
        $this->data['department'] = $this->model->getMenuLevel(1);
        // print_r($this->data);exit;

        $this->rules = ['name' => 'required|min_length[3]|max_length[16]'];    //校验表单
        return parent::create();
    }

    protected function afterCreate($insertID)
    {
        $this->model->saveCacheMenus();
    }

    public function edit($id = 0)
    {
        $this->model = new \App\Models\MenusModel();
        $this->data['department'] = $this->model->getMenuLevel(1);
        parent::edit($id);
        // print_r($this->data);exit;
    }

    protected function afterEdit($id)
    {
        $this->model->saveCacheMenus();
    }

    protected function afterDelete($id)
    {
        $this->model->saveCacheMenus();
    }

    public function indexLk($parent = 0)
    {
        // $this->model= new \App\Models\MenusModel();

        $class = ucfirst($this->request->uri->getSegment(1) ?: \Config\Services::routes()->getDefaultController());
        $modelName = "\\App\\Models\\{$class}Model";
        $this->model = new $modelName();

        $this->data['parent'] = $parent;
        $this->model->where(['parent' => $parent]);
        // $this->model->orderBy('order_by', 'ASC');
        $this->model->orderBy('order_by ASC');
        // $this->model->orderBy('order_by DESC');
        $this->data['list'] = $this->model->findAll();

        return $this->view('menus/index');
    }
}
