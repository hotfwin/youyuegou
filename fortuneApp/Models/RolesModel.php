<?php

namespace App\Models;

class RolesModel extends \CodeIgniter\Model
{
	protected $table = 'to_roles';
	// protected $primaryKey = 'id';
	protected $returnType = 'object';     //设置返回结果为对象
	protected $allowedFields = ['id','name','rights','default'];


	/*取得用户组的默认页*/
	public function getRolesDefault($id)
	{
		$this->where('id', $id);
		$default = $this->get()->getRow();
		if ($default) {
			return $default->default;
		}
		return '';
	}
 
	public function getAllRoles()
	{
		$this->select('id,name');
		$result = $this->findAll();
		if (!$result) return FALSE;

		$roles = [];
		foreach ($result as $value) {
			$roles[$value->id] = $value->name;
		}
		return $roles;
	}

	public function getRole($id){
		$this->where('id',$id);
		$role=$this->get()->getRow();
		if($role){
		    $role->rights=explode(',', $role->rights);
			return $role;
		}
		return FALSE;
	}
}
