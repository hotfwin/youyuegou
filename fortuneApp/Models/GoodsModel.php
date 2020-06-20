<?php

/***
 *|----------------------------
 *| GoodsClassModel.php
 *|----------------------------
 *|  
 *| 问题：  
 *|------------------------------------------------------------------------
 *| Author:临来笑笑生     Email:luck@elapse.date     Modify: 2020.06.15
 *|------------------------------------------------------------------------
 * ***/

namespace App\Models;

class GoodsModel extends \CodeIgniter\Model
{
    protected $table = 'goods';
    protected $primaryKey = 'id';
    protected $returnType = 'object';     //设置返回结果为对象
    protected $allowedFields = [
        'cid', 'bid', 'user_id', 'goods_no', 'goods_subname', 'goods_name',
        'goods_price', 'goods_market_price', 'goods_num', 'goods_images',
        'goods_master_image', 'goods_freight', 'freight_id', 'free_freight',
        'chose_spec_id', 'chose_attr', 'goods_sale_num', 'goods_collect',
        'goods_status', 'goods_verify', 'goods_content', 'store_goods_class',
        'is_groupbuy', 'is_groupbuy', 'groupbuy_num', 'groupbuy_price',
        'is_top', 'is_index', 'add_time', 'edit_time',
    ];
}
