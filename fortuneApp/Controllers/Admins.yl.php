<?php

namespace App\Controllers;

/***
 *|----------------------------
 *| Admins.php
 *|----------------------------
 *| 后台用户
 *| 问题：  
 *|------------------------------------------------------------------------
 *| Author:临来笑笑生     Email:luck@gust.cn      Modify: 2020.06.12
 *|------------------------------------------------------------------------
 * ***/
class Admins extends FortuneController
{
  public function __construct()
  {
    $rolesModel = new \App\Models\RolesModel();
    $this->data['roles'] = $rolesModel->getAllRoles();
    // print_r($this->data['roles']);exit;
  }

  public function modifypasswd($id = 0)
  {
    $this->data['validation'] = \Config\Services::validation();  // \Config\Services::validation();

    $postData = $this->request->getPost();

    if ($postData) {
      if (!$this->validate([
        'former' => 'required|min_length[3]|max_length[255]',
        'password'  => 'required|min_length[3]|max_length[255]',
        'passwd'  => 'required|matches[password]',   //确认密码必须与密码相同
      ])) {
        return redirect()->back()->withInput();
      }

      $id = $id ?: session('id');

      if ($id != session('id')) {
        // echo '更改的不是自己的密码，检查是否有权限!';
        // exit;
        return $this->showMessage('无权限修改他人的密码。', FALSE, 'admins/modifypasswd');
      }

      $adminModel = new \App\Models\AdminsModel();
      $admin = $adminModel->find($id);

      if ($admin->password != $adminModel->encryption($this->request->getPost('former'), $admin->salt)) {
        return $this->showMessage('原密码不正确，不允许修改。请输入正确的“原来密码”。', FALSE, 'admins/modifypasswd');
      }

      $passwd = $this->request->getPost('passwd');

      if ($passwd != $this->request->getPost('password')) {
        return $this->showMessage('新密码，确认密码不一致，请输入一致的新密码。', FALSE, 'admins/modifypasswd');
      }

      //处理更改密码
      $salt = substr(uniqid(mt_rand()), 8, 10);  //改混淆码为十个字符
      $passwd = $adminModel->encryption($passwd, $salt);
      $adminModel->update($id, ['password' => $passwd, 'salt' => $salt]);

      return $this->showMessage('恭喜你，密码修改成功!', TRUE, 'admins/modifypasswd');
    }
    return $this->view('admins/modifypasswd');
  }

  protected function beforeCreate(&$post)
  {
    $this->rules = ['username' => 'required|min_length[3]|max_length[16]'];    //校验表单

    //加密码以便保存到数据库中
    $post['salt'] = substr(uniqid(mt_rand()), 8, 10);  //改混淆码为十个字符
    $post['password'] = $this->model->encryption($post['password'], $post['salt']);
  }

  protected function beforeEdit(&$post)
  {

    if (isset($post['password'])) {
      if (!empty($post['password'])) {
        //加密码以便保存到数据库中
        $post['salt'] = substr(uniqid(mt_rand()), 8, 10);  //随机10个字符
        $post['password'] = $this->model->encryption($post['password'], $post['salt']);
      } else {
        unset($post['password']);
      }
    }
  }
}
