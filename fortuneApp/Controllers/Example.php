<?php

namespace App\Controllers;

class Example extends FortuneController
{
    public function index()
    {
        $year = $this->request->getGet('year');
        if ($year) {
            $this->like['year'] = $year;
        }
        $month = $this->request->getGet('month');
        if ($month) {
            $this->where['month'] = $month;
        }

        $this->orderBy = 'invoiceDate desc';
        parent::index();
    }

    /*处理新建文件上传*/
    protected function beforeCreate(&$postData)
    {
        $file = $this->request->getFile('invoice_file');  //取得单文件

        if (!$file->isValid()) {
            $erorr = $file->getErrorString() . $file->getError();
            exit("文件上传出错：{$erorr}");
        }

        // $path= WRITEPATH . 'uploads/';
        $path = 'static/uploads/';      //文件上传路径

        $newName = $file->getRandomName();        //产生随机文件名
        $originalName = $file->getClientName();   //客户端上传的原文件名
        $extension = $file->getExtension();      //文件夹扩展名字(jpg)
        $type = $file->getType();     //文件的媒体类型(file)

        /**把文件从临时文件中移到上传的路径 */
        if (!$file->hasMoved()) {
            $file->move($path, $newName);
        }

        // $files = $this->request->getFiles();   //多文件
        // print_r($files);

        $postData['invoiceFile']=$path.$newName;
		$postData['invoicePath']=$path;
		$postData['invoiceTitle']=$newName;  //不还扩展名的名，这里无
		$postData['invoiceType']=$type;
        $postData['invoiceExtension']=$extension;
        
        /*划分年、月、日，以便统计搜索*/
		if(isset($postData['invoiceDate'])){
			$temp=explode('-',$postData['invoiceDate']);
			$postData['year']=$temp['0'];
			$postData['month']=$temp['1'];
			$postData['day']=$temp['2'];
		}

		$postData['create']=time();
    }
}
