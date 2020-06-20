<?php

namespace App\Controllers;

class Products extends FortuneController
{
    public function qiniu()
    {
        $configModel = new \App\Models\ConfigModel();
        $qiniu = $configModel->getName('qiniu');
        // print_r(json_decode($qiniu->val));
        $qiniu = json_decode($qiniu->val);
        $auth = new \Qiniu\Auth($qiniu->access_key, $qiniu->secret_key);
        // exit($qiniu->disks[0]->bucket);
        // $bucket = 'Bucket_Name';
        $bucket=$qiniu->disks[0]->bucket;
        // 生成上传Token
        $token = $auth->uploadToken($bucket);

        return $this->view('qiniu/up',['token'=>$token]);
        exit($token);
        // 构建 UploadManager 对象
        $uploadMgr = new UploadManager();
        return;

        exit('七个牛的图片上传测试');
    }
}
