<?php

namespace App\Controllers;

class Roles extends FortuneController
{

    public function create(){
        $post = $this->request->getPost();
		if(!empty($post)){
            if(isset($post['rights'])){
                $post['rights']=array_filter($post['rights']);  //去掉数组空值
                $post['rights']=implode(',', $post['rights']);  //将数组变成字符串
            }

            $this->model = new \App\Models\RolesModel();
            $this->model->insert($post);
            $menusModel = new \App\Models\MenusModel();
            $menusModel->saveCacheMenus();

			return $this->showMessage('插入用户组成功');
		}

        $rightsModel = new \App\Models\RightsModel();
        $this->data['rights'] = $rightsModel->formatRights(); //取得所有权限
        // print_r($this->data['rights']);exit;
        echo $this->view( 'roles/create');
	}

    public function edit($id = 0)
    {
        $this->model = new \App\Models\RolesModel();
        $post = $this->request->getPost();
        if (!empty($post)) {
            if(isset($post['rights'])){
                $post['rights']=array_filter($post['rights']);  //去掉数组空值
                $post['rights']=implode(',', $post['rights']);  //将数组变成字符串
            }
            // print_r($post);exit;
            $this->model->update($id, $post); 
            $menusModel = new \App\Models\MenusModel();
            $menusModel->saveCacheMenus();
            return $this->showMessage('修改用户组成功');
        }

        $rightsModel = new \App\Models\RightsModel();
        $this->data['rights'] = $rightsModel->formatRights(); //取得所有权限
        $this->data['roles'] = $this->model->getRole($id);
        echo $this->view( 'roles/edit');
    }

    public function afterDelete($id){
        $menusModel = new \App\Models\MenusModel();
        $menusModel->saveCacheMenus();
    }
}
