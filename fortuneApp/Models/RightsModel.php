<?php

namespace App\Models;

class RightsModel extends \CodeIgniter\Model
{
    protected $table = 'to_rights';
    protected $primaryKey = 'right_id';
    protected $returnType = 'object';     //设置返回结果为对象
    protected $allowedFields = ['right_id', 'right_class', 'right_method', 'right_name', 'right_detail'];

    protected $rightID = 0;

    public function __construct(\CodeIgniter\Database\ConnectionInterface &$db = null, \CodeIgniter\Validation\ValidationInterface $validation = null)
    {
        parent::__construct($db, $validation);

        $routes = \Config\Services::routes();
        $defaultController = $routes->getDefaultController();
        $defaultMethod = $routes->getDefaultMethod();

        $request = \Config\Services::request();
        $segments = $request->uri->getSegments();

        $rClass = strtolower($segments[0] ?? $defaultController);
        $rMethod = strtolower($segments[1] ?? $defaultMethod);

        $this->select('right_id');
        $this->where('right_class', $rClass);
        $this->where('right_method', $rMethod);
        $right = $this->get()->getRow();

        if (!$right) {
            // echo '插入权限';
            $this->insert(['right_class' => $rClass, 'right_method' => $rMethod]);
            $this->rightID = $this->getInsertID();   //输出插入的ID 
        } else {
            $this->rightID = $right->right_id;
        }

        // echo $this->getLastQuery();
    }

    public function permit()
    {
        $adminsModel = new \App\Models\AdminsModel();


        $admin = $adminsModel->find(session('id'));

        if ($admin->role==1) {
            //是admin的“超级用户组，”直接返回，拥有所有权限
            return TRUE;
        }

        $rolesModel = new \App\Models\RolesModel();
        $roles = $rolesModel->find($admin->role);

        if (!$roles) {
            return FALSE;
        }

        $permits = explode(',', $roles->rights);

        if(in_array($this->rightID,$permits)){
            return TRUE;
        }

        return FALSE;
    }

    public function formatRights(){
        $confing=new \Config\Database();
        $sql='SELECT DISTINCT `right_class` FROM `'.$confing->default['DBPrefix'].$this->table.'` ';
        $class=$this->query($sql)->getResult();
        
		if(!$class){
			return FALSE;
		}
		$rights=array();
		foreach ($class as $value) {
			$test=array();
			$test['class']=$value->right_class;
			$this->where('right_class',$value->right_class);
			$test['methods']=$this->findAll();
        	// 
			$rights[$value->right_class]=$test;
		}
		return $rights;
	}
}
