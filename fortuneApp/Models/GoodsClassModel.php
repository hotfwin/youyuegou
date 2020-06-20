<?php

namespace App\Models;

class GoodsClassModel extends \CodeIgniter\Model
{
    protected $table = 'goods_class';
    protected $primaryKey = 'id';
    protected $returnType = 'object';     //设置返回结果为对象
    protected $allowedFields = [
        'pid', 'name', 'thumb', 'rate', 'tags', 'is_sort',
    ];

    /*取得顶层级分类*/
	public function getPID($pid=0){
		$this->where('pid',$pid);
		return $this->findAll();
    }
    
    public function getChild($data){
        if($data){
            foreach ($data as $key => $value) {
                $child=$this->getPID($value->id);
                if($child){
                    $child=$this->getChild($child);
                }
                $value->child=$child;
            }
        }
        return $data;
    }

    /*取得所有分类*/
	public function getAll(){
		$top=$this->getPID(0);
		$top=$this->getChild($top);
		
		return $top;
    }
    

    public function saveCacheCategory(){
        $category=$this->getAll();

        $config = new \Config\Cache();
        $config->handler = 'file';      //强制重写配置，确保使用的是文件缓存，而不是其它缓存
        $cache = \Config\Services::cache($config);

        $cache->save('category', $category, 0);
		return $category;
    }
    
    public function formatCategory($category,$select='0',$prefix=''){
		$option=[];
		if($category){
			foreach ($category as $key => $value) {
				# code...
				$temp='<option value="';
				$temp.=$value->id;
				$temp.='" ';
				$temp.=$value->id==$select?' selected="selected" ':'';
				$temp.=' >';
				$temp.='|'.$prefix.$value->name;
				$temp.='</option>';

				$option[]=$temp;

				if($value->child){
					$child=$this->formatCategory($value->child,$select,'-----'.$prefix);
					$option=array_merge($option,$child);
				}
				
			}
		}

		return $option;
	}

     

}
