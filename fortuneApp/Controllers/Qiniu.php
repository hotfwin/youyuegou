<?php

/***
 *|----------------------------
 *| Qiniu.php
 *|----------------------------
 *| 七牛云测试
 *| 文档：https://developer.qiniu.com/kodo/sdk/1241/php#2
 *| 问题：  
 *|------------------------------------------------------------------------
 *| Author:临来笑笑生     Email:luck@gust.cn      Modify: 2020.06.15
 *|------------------------------------------------------------------------
 * ***/

namespace App\Controllers;

use Qiniu\Auth;
use Qiniu\Storage\UploadManager;

class Qiniu extends FortuneController
{
    public function index()
    {
        $configModel = new \App\Models\ConfigModel();
        $qiniu = $configModel->getName('qiniu');
        // print_r(json_decode($qiniu->val));
        $qiniu = json_decode($qiniu->val);
        // $accessKey = "your accessKey";
        // $secretKey = "your secretKey";
        $auth = new \Qiniu\Auth($qiniu->access_key, $qiniu->secret_key);

        $bucket = $qiniu->disks[0]->bucket;  //youyugou-app => qb1fbi10h.bkt.clouddn.com
        $token = $auth->uploadToken($bucket);

        // 要上传文件的本地路径
        $filePath = 'static/uploads/1591628235_3a4756a0dad461df313f.jpg';

        // 上传到七牛后保存的文件名
        $key = 'mntp.jpg';

        // 初始化 UploadManager 对象并进行文件的上传。
        $uploadMgr = new \Qiniu\Storage\UploadManager();

        // 调用 UploadManager 的 putFile 方法进行文件的上传。
        list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);
        echo "\n====> putFile result(结果): \n";
        if ($err !== null) {
            var_dump($err);
        } else {
            var_dump($ret);
            // array(2) { ["hash"]=> string(28) "FoqUCUQcdkUjtqjpCifUzNbg6MAA" ["key"]=> string(8) "mntp.jpg" }
            //http://qb1fbi10h.bkt.clouddn.com/mntp.jpg
            // 上传后的下载:http://<domain>/<key>  (每个 bucket 都会绑定一个或多个域名 (domain))
        }

        echo '<hr>';
        echo $ret['hash'];

        echo '<hr>';
        echo base_url($filePath);
        echo '<hr>';

        exit('直传');
    }

    public function uniqid(){
        echo uniqid();
    }
    public function up()
    {
        $configModel = new \App\Models\ConfigModel();
        $qiniu = $configModel->getName('qiniu');
        // print_r(json_decode($qiniu->val));
        $qiniu = json_decode($qiniu->val);
        $auth = new \Qiniu\Auth($qiniu->access_key, $qiniu->secret_key);
        // exit($qiniu->disks[0]->bucket);
        // $bucket = 'Bucket_Name';
        $bucket = $qiniu->disks[0]->bucket;
        // 生成上传Token
        $token = $auth->uploadToken($bucket);
        return $this->view('qiniu/up', ['token' => $token]);
    }
}
