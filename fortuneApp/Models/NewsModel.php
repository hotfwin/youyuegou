<?php

namespace App\Models;

class NewsModel extends \CodeIgniter\Model
{
    protected $table = 'news';
    protected $allowedFields = ['title', 'slug', 'body'];     //数据表列，在save用到

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
