<?php

namespace App\Models;

class ExampleModel extends \CodeIgniter\Model
{
    protected $table = 'originalEvidences';
    protected $primaryKey = 'id';
    protected $returnType = 'object';     //设置返回结果为对象
    protected $allowedFields = [
        'companyID', 'companyName', 'creditCode',
        'eID', 'fullName', 'category','detail',  //等数据列
        'invoiceFile','invoiceExtension'
    ];
}
