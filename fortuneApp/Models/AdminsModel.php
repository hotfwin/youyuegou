<?php

namespace App\Models;

class AdminsModel extends \CodeIgniter\Model
{
    protected $table = 'to_admins';
    protected $primaryKey = 'id';
    protected $returnType = 'object';     //设置返回结果为对象
    protected $allowedFields = [
        'id', 'username', 'password', 'salt', 'status',
        'email','mobile','role', 'last_login'
    ];

    public function getLogin($login)
    {
        $this->where('username', $login);
        $data = $this->get()->getRow();
        // $data=$this->first();

        if ($data) {
            return $data;
        }

        $this->where('email', $login);
        $data = $this->get()->getRow();
        if ($data) {
            return $data;
        }

        $this->where('mobile', $login);
        $data = $this->get()->getRow();
        if ($data) {
            return $data;
        }

        return FALSE;
    }

    //加密算法
    public function encryption($string, $salt = 'luck')
    {
        return sha1(md5($string) . $salt);
    }

    public function getNews($slug = false)
    {
        if ($slug === false) {
            return $this->findAll();
        }
        return $this->asArray()
            ->where(['slug' => $slug])
            ->first();
    }
}
