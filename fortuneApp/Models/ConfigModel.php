<?php

namespace App\Models;

class ConfigModel extends \CodeIgniter\Model
{
    protected $table = 'config';
    protected $primaryKey = 'id';
    protected $returnType = 'object';     //设置返回结果为对象
    protected $allowedFields = [
        'name', 'val',
        'content',
    ];

    public function getName($name){
        $this->where('name',$name);
        return $this->get()->getRow();
    }
}
