<?php

namespace App\Controllers;

use App\Models\NewsModel;     //加载数据模型

class Luck extends FortuneController
{
    public function index()
    {
        if (!file_exists(APPPATH . '/Views/luck.php')) {
            exit('不存在视图');
        }
        $data['title'] = '幸运的';

        echo view('luck', $data);
    }

    public function setsession(){
        $session= \Config\Services::session();

        $session->set(['id'=>'luck']);
    }

    public function listNews()
    {
        $model = new NewsModel();
        $data['news'] = $model->getNews();
        $data['title'] = '新闻列表';

        echo view('templates/header', $data);
        echo view('news/index', $data);
        echo view('templates/footer');
    }

    public function newsView($slug = null)
    {
        $model = new NewsModel();
        $data['news'] = $model->getNews($slug);
        if (empty($data['news'])) {
            exit('出错了，没有查找 到！！o');
        }

        $data['title'] = $data['news']['title'];

        echo view('templates/header', $data);
        echo view('news/view', $data);
        echo view('templates/footer');
    }

    public function createNews()
    {

        // print_r($this->request->uri);exit; 
      
       

        $timer = new \CodeIgniter\Debug\Timer();
        $timer = \Config\Services::timer();
        $logger = service('logger');
        $logger = single_service('logger');

        // echo env('database.default.database');exit;

        helper('form');
        $model = new NewsModel();

        if (!$this->validate([
            'title' => 'required|min_length[3]|max_length[255]',
            'body'  => 'required'
        ])) {
            echo view('templates/header', ['title' => '发布一条新闻']);
            echo view('news/create');
            echo view('templates/footer');
        } else {
            $update = [
                'title' => $this->request->getVar('title'),
                'slug'  => url_title($this->request->getVar('title'), '-', TRUE),
                'body'  => $this->request->getVar('body'),
            ];

            // $model->save($update);

            if (!$model->save($update)) {
                // 'withInput'方法意味着"原有的数据"需要被存储。
                return redirect()->back()->withInput();
            }

            echo $model->getInsertID();   //输出插入的ID 
            echo '<hr>';
            echo $model->getLastQuery();   //返回最近一次运行的SQl语句

            echo view('news/success');
        }

        // exit('处理数据');
    }
}
