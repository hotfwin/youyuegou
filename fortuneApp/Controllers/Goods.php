<?php

/***
 *|----------------------------
 *| Goods.php
 *|----------------------------
 *|  
 *| 问题：  
 *|------------------------------------------------------------------------
 *| Author:临来笑笑生     Email:luck@elapse.date     Modify: 2020.06.15
 *|------------------------------------------------------------------------
 * ***/

namespace App\Controllers;

class Goods extends FortuneController
{
    public function index()
    {
        $goodsName=$this->request->getGet('goods_name');
        if($goodsName){
            $this->like['goods.goods_name']=$goodsName;
        }

        $goodsSN=$this->request->getGet('goods_no');
        if($goodsSN){
            $this->like['goods.goods_no']=$goodsSN;
        }

        $cid=$this->request->getGet('cid');
        if($cid){
            $this->where['goods.cid'] = $cid;
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

        $all = $this->model->formatCategory($category, $cid?:'0');

        $this->data['category'] = $all;


        // $this->model->join('goods_class','goods_class.id = goods.cid','LEFT');
        $this->select = 'goods.*,goods_class.name as class_name';
        $this->join[] = [
            'table' => 'goods_class',
            'cond' => 'goods_class.id = goods.cid',
            'type' => 'LEFT',
        ];
        
        parent::index();
    }
}
