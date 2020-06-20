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

namespace App\Models;

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
class PicturesModel extends \CodeIgniter\Model
{
    protected $table = 'pictures';
    protected $primaryKey = 'id';
    protected $returnType = 'object';     //设置返回结果为对象
    protected $allowedFields = [
        'uuid', 'name', 'size', 'ext', 'path', 'md5', 'created_at', 'updated_at',
    ];

    public function showUUID($uuid)
    {
        if ($uuid == '') return;
        $this->select('name');
        $this->where('uuid',$uuid);
        $row=$this->get()->getRow();
        if(!$row) return FALSE;
        $row->name;
        return 'http://qb1fbi10h.bkt.clouddn.com/'.$row->name;
    }

    public function getUUID($uuid){
        $this->where('uuid',$uuid);
        return $this->get()->getRow();
    }

    public function qiniu($filePath, $fileName)
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
        // $filePath = 'static/uploads/1591628235_3a4756a0dad461df313f.jpg';

        // 上传到七牛后保存的文件名
        // $key = 'mntp.jpg';
        $key = $fileName;

        // 初始化 UploadManager 对象并进行文件的上传。
        $uploadMgr = new \Qiniu\Storage\UploadManager();

        // 调用 UploadManager 的 putFile 方法进行文件的上传。
        list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);

        if ($err !== null) {
            echo "\n====> putFile result(结果): \n";
            var_dump($err);
            exit('文件上传出错了');
        } else {
            // var_dump($ret);
            // array(2) { ["hash"]=> string(28) "FoqUCUQcdkUjtqjpCifUzNbg6MAA" ["key"]=> string(8) "mntp.jpg" }
            //http://qb1fbi10h.bkt.clouddn.com/mntp.jpg
            // 上传后的下载:http://<domain>/<key>  (每个 bucket 都会绑定一个或多个域名 (domain))
        }

        return $ret;
    }
}
