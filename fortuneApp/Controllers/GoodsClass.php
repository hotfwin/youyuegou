<?php

/***
 *|----------------------------
 *| GoodsClass.php
 *|----------------------------
 *|  
 *| 问题：  新增和更新后，没处理列表选择缓存
 *|------------------------------------------------------------------------
 *| Author:临来笑笑生     Email:luck@elapse.date      Modify: 2020.06.15
 *|------------------------------------------------------------------------
 * ***/

namespace App\Controllers;

class GoodsClass extends FortuneController
{
    public function index($pid = 0)
    {
        $this->orderBy = 'is_sort ASC';
        $this->data['pid'] = $pid;
        $this->where['pid'] = $pid;
        parent::index();
    }

    protected function beforeCreate(&$post)
    {
        /*处理图片上传*/
        $imagesConfig = new \Config\Images();
        $uploadDir = $imagesConfig->storage == 'qiniu' ? '/tmp/' : 'static/upload/';
        $config = [
            'uploadDir' => $uploadDir
            // 'title' => array('auto',12)  //重命名文件('auto'自动，'name'原名, '什么就是什么名')及文件名的长度
        ];
        $myUpload = new \App\Libraries\MyUpload($config);
        $upload = $myUpload->uploads('thumb');

        // print_r($upload);exit;

        if ($upload['isSuccess'] && !empty($upload['files'])) { //有文件上传才做处理
            $files = $upload['files'][0];   //单文件直接处理:Array ( [date] => Tue, 16 Jun 2020 22:46:50 +0800 [extension] => jpg [file] => /tmp/qrB27_j1vUVEHbhT3P.jpg [name] => qrB27_j1vUVEHbhT3P.jpg [old_name] => 20200612_143545.jpg [old_title] => 20200612_143545 [replaced] => [size] => 3865996 [size2] => 3.69 MB [title] => qrB27_j1vUVEHbhT3P [type] => image/jpeg [uploaded] => 1 ) ) )

            if ($imagesConfig->storage == 'qiniu') {
                $picturesModel = new \App\Models\PicturesModel();
                $result = $picturesModel->qiniu($files['file'], $files['name']);
                //上传到七牛，后缀和相关信息记录到pictures表
                /***
                 图片上传，返回 
                { ["hash"]=> string(28) "FoqUCUQcdkUjtqjpCifUzNbg6MAA" 
                    ["key"]=> string(8) "mntp.jpg" }，
                    记录到表pictures中，
                    md5=hash？
                    uuid,我直接uniqid(). 
                    name=key，
                    path = qiniu:mntp.jpg
                 ***/
                $uuid = uniqid();
                $pictures = [
                    'uuid' => $uuid,
                    'name' => $result['key'],
                    'size' => $files['size'],
                    'ext' => $files['extension'],
                    'path' => 'qiniu:' . $result['key'],
                    'md5' => $result['hash'],
                    'created_at' => date('Y-m-d H:i:s'),
                ];
                // print_r($pictures);exit;
                $picturesModel->insert($pictures);
                $post['thumb'] = $uuid;
            } else {
                $post['thumb'] = $files['file'];
            }
        }

        //加图片插件后多出fileuploader-list-image
        unset($post['fileuploader-list-image']);
    }

    public function create($pid = 0)
    {
        $postData = $this->request->getPost();
        if ($postData) {
            $jumpURL = $postData['jumpURL'] ?? FALSE;
            unset($postData['jumpURL']);

            //去掉空值
            foreach ($postData as $key => $value) {
                if ($value == '') {
                    unset($postData[$key]);
                }
            }

            /* 加载数据模型 */
            $modelName = '\\App\\Models\\' . ucfirst($this->className) . 'Model';
            $this->model = new $modelName();

            //before  after
            //是否要分别做插入数据前处理数据！！
            if (method_exists($this, 'beforeCreate')) {
                $this->beforeCreate($postData);
            }

            /**是否要校验输入数据 */
            if (!empty($this->rules)) {
                if (!$this->validate($this->rules)) {
                    return redirect()->to(site_url($this->className . '/create/'))->withInput();
                    exit;
                }
            }

            $insertID = $this->model->insert($postData);  //插入数据

            // print_r($postData);
            // echo $this->model->getLastQuery();exit;

            //插入后处理
            if (method_exists($this, 'afterCreate')) {
                $this->afterCreate($insertID);
            }

            /*是否记录操作日志*/
            if ($this->record) {
                $record['table_id'] = $insertID;
                $record['table_name'] = $this->className;
                $record['user_id'] = $this->session->get('id');
                $record['username'] = $this->session->get('username');
                $record['action'] = 'create';
                $record['record_time'] = date('Y-d-m H:i:s');
                $record['ip'] = $this->request->getIPAddress();

                $recordModel = new \App\Models\RecordModel();
                $recordModel->insert($record);
            }

            return $this->showMessage('新增数据成功', TRUE, $jumpURL);
        }

        /*取得菜单*/
        $config = new \Config\Cache();
        $config->handler = 'file';      //确保使用的是文件缓存，而不是其它缓存
        $cache = \Config\Services::cache($config);
        $this->model = new \App\Models\GoodsClassModel();

        $category = $cache->get('category');
        if (!$category) {
            $category = $this->model->saveCacheCategory();
        }

        $all = $this->model->formatCategory($category, $pid);

        $this->data['category'] = $all;
        $this->data['pid'] = $pid;

        echo $this->view(strtolower($this->className) . '/create');
    }

    public function edit($id = 0)
    {
        if (!$id) {
            return $this->showMessage('请选择要修改的数据！！', FALSE);
        }

        /* 加载数据模型 */
        $modelName = '\\App\\Models\\' . ucfirst($this->className) . 'Model';
        $this->model = new $modelName();

        $edit = $this->model->find($id);

        if (!$edit) {
            return $this->showMessage('要修改的数据不存在！！', FALSE);
        }

        if ($pData = $this->request->getPost()) {
            $jumpURL = $pData['jumpURL'] ?? FALSE;
            unset($pData['jumpURL']);



            //before  after
            //是否要修改数据前处理特别数据！！
            if (method_exists($this, 'beforeEdit')) {
                $this->beforeEdit($pData);
            }

            $this->model->update($id, $pData);

            //插入后处理
            if (method_exists($this, 'afterEdit')) {
                $this->afterEdit($id);
            }

            /*是否记录操作日志*/
            if ($this->record) {
                $record['table_id'] = $id;
                $record['table_name'] = $this->className;
                $record['user_id'] = $this->session->get('id');
                $record['username'] = $this->session->get('username');
                $record['action'] = 'edit';
                $record['record_time'] = date('Y-d-m H:i:s');
                $record['ip'] = $this->request->getIPAddress();

                $recordModel = new \App\Models\RecordModel();
                $recordModel->insert($record);
            }

            return $this->showMessage('数据修改成功', TRUE, $jumpURL);
        }

        $this->data['edit'] = $edit;

        /*取得菜单*/
        $config = new \Config\Cache();
        $config->handler = 'file';      //确保使用的是文件缓存，而不是其它缓存
        $cache = \Config\Services::cache($config);
        $this->model = new \App\Models\GoodsClassModel();

        $category = $cache->get('category');
        if (!$category) {
            $category = $this->model->saveCacheCategory();
        }

        // print_r($edit);exit;

        $all = $this->model->formatCategory($category, $edit->pid);
        $this->data['category'] = $all;

        //如里是图片上传到七牛，刚处理下才能显示
        $imagesConfig = new \Config\Images();
        if ($imagesConfig->storage == 'qiniu') {
            $edit->image = showQiniu($edit->thumb);
        } else {
            $edit->image = $edit->thumb;
        }

        return $this->view(strtolower($this->className) . '/edit');
    }

    /*后台接收图片上传*/
    public function uploadImg($id = 0, $uuid = 0)
    {
        if (!$id) {
            $id = $this->request->getPost('id');
        }

        $return = ['status' => FALSE, 'message' => '这里是默认返回的提示信息！！！'];

        /*处理图片上传*/
        $imagesConfig = new \Config\Images();
        $uploadDir = $imagesConfig->storage == 'qiniu' ? '/tmp/' : 'static/upload/';
        $config = [
            'uploadDir' => $uploadDir
            // 'title' => array('auto',12)  //重命名文件('auto'自动，'name'原名, '什么就是什么名')及文件名的长度
        ];
        $myUpload = new \App\Libraries\MyUpload($config);
        $upload = $myUpload->uploads('thumb');

        // print_r($upload);exit;

        if ($upload['isSuccess'] && !empty($upload['files'])) { //有文件上传才做处理
            $files = $upload['files'][0];   //单文件直接处理:Array ( [date] => Tue, 16 Jun 2020 22:46:50 +0800 [extension] => jpg [file] => /tmp/qrB27_j1vUVEHbhT3P.jpg [name] => qrB27_j1vUVEHbhT3P.jpg [old_name] => 20200612_143545.jpg [old_title] => 20200612_143545 [replaced] => [size] => 3865996 [size2] => 3.69 MB [title] => qrB27_j1vUVEHbhT3P [type] => image/jpeg [uploaded] => 1 ) ) )

            if ($imagesConfig->storage == 'qiniu') {
                $picturesModel = new \App\Models\PicturesModel();
                $result = $picturesModel->qiniu($files['file'], $files['name']);
                //上传到七牛，后缀和相关信息记录到pictures表
                /***
                 图片上传，返回 
                { ["hash"]=> string(28) "FoqUCUQcdkUjtqjpCifUzNbg6MAA" 
                    ["key"]=> string(8) "mntp.jpg" }，
                    记录到表pictures中，
                    md5=hash？
                    uuid,我直接uniqid(). 
                    name=key，
                    path = qiniu:mntp.jpg
                 ***/
                //更新pictures
                if (!$uuid) {
                    $uuid = $this->request->getPost('uuid');
                }

                $pictures = [
                    // 'uuid' => $uuid,
                    'name' => $result['key'],
                    'size' => $files['size'],
                    'ext' => $files['extension'],
                    'path' => 'qiniu:' . $result['key'],
                    'md5' => $result['hash'],
                    // 'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
                // print_r($pictures);exit;
                if ($uuid) {
                    $picturesID = $picturesModel->getUUID($uuid)->id??0;
                    $picturesModel->update($picturesID, $pictures);
                } else {
                    $pictures['uuid'] = uniqid();
                    $pictures['created_at'] = date('Y-m-d H:i:s');
                    $picturesModel->insert($pictures);
                    //更新表。
                    $goodsClassModel = new \App\Models\GoodsClassModel();
                    $goodsClassModel->update($id, ['thumb' => $pictures['uuid']]);
                }
            } else {
                //更新表。
                $goodsClassModel = new \App\Models\GoodsClassModel();
                $goodsClassModel->update($id, ['thumb' => $files['file']]);
            }
            $return['status'] = TRUE;
        }

        //输出json数据
        $this->response->setHeader('Access-Control-Allow-Origin', '*');
        return $this->response->setJSON($return);
    }
}
