<?php

namespace App\Models;

class MenusModel extends \CodeIgniter\Model
{
    protected $table = 'to_menus';
    // protected $primaryKey = 'id';
    protected $returnType = 'object';     //设置返回结果为对象
    protected $allowedFields = [
        'id', 'order_by', 'class', 'method', 'name', 'level', 'parent', 'icon', 'department', 'is_show'
    ];

    public function getMenuLevel($level)
    {
        $this->where('level', $level);
        return $this->findAll();
    }

    public function getMenusParent($parent, $show = FALSE)
    {
        $this->where('parent', $parent);

        if ($show !== FALSE) {
            $this->where('is_show', $show);
        }

        $this->orderBy('order_by', 'ASC');
        return $this->findAll();
    }


    public function getLeftMenus($level = 1)
    {
        $this->where('level', $level);
        $this->where('is_show', 1);
        $this->orderBy('order_by', 'ASC');
        $menus = $this->findAll();

        foreach ($menus as $key => $value) {
            # code...
            $menus[$key]->child = $this->getMenusParent($value->id, 1);
        }

        // echo $this->getLastQuery();
        // echo '<br><hr>';
        // print_r($menus);
        // exit;

        return $menus;
    }

    public function getCurrent()
    {
        $routes = \Config\Services::routes();
        $defaultController = $routes->getDefaultController();
        $defaultMethod = $routes->getDefaultMethod();

        $request = \Config\Services::request();
        $segments = $request->uri->getSegments();

        $rClass = strtolower($segments[0] ?? $defaultController);
        // $rMethod = strtolower($segments[1] ?? $defaultMethod);
        $rMethod = strtolower($defaultMethod);    //直接用默认方法

        $this->where('class', $rClass);
        $this->where('method', $rMethod);
        return $this->get()->getRow();
    }

    public function saveCacheMenus($roleID = 0)
    {


        // $foo = $cache->get('foo');
        // if ( ! $foo = $cache->get('foo'))
        // {
        //         echo 'Saving to the cache!<br />';
        //         $foo = 'foobarbaz!';

        //         // Save into the cache for 5 minutes
        //         // cache()->save('foo', $foo, 300);
        //         $cache->save('foo', $foo, 300);
        // }
        //=============================================================


        // echo '取得菜单，并用文件缓存起来';
        $menus = $this->getLeftMenus();

        $rolesModel = new \App\Models\RolesModel();
        if ($roleID) {
            $rolesModel->where('id', $roleID);
        }
        $roles = $rolesModel->findAll();

        $config = new \Config\Cache();
        $config->handler = 'file';      //强制重写配置，确保使用的是文件缓存，而不是其它缓存
        $cache = \Config\Services::cache($config);

        foreach ($roles as $role) {
            if ($role->id == '1') {
                $cache->save('menus_1', $menus, 0);
            } else {
                //  这里还没测试
                $myMenus = $menus;
                foreach ($myMenus as $k => $val) {
                    if ($val->class && $val->method) {
                        $rightsModel = new \App\Models\RightsModel();
                        $rightsModel->where('right_class', $val->class);
                        $rightsModel->where('right_method', $val->method);
                        $right = $rightsModel->get()->getRow();
                        // print_r($right);exit('kkk===kk');
                        if (!$right) {
                            // echo '权限表还没有此权限，插入此权限';
                            $insertRights = [
                                'right_class' => $val->class,
                                'right_method' => $val->method
                            ];
                            $rightsModel->insert($insertRights);

                            $right = (object) $right;
                            $right->right_id = $this->getInsertID();   //输出插入的ID 
                        }

                        $permits = explode(',', $role->rights);
                        if (!in_array($right->right_id, $permits)) {
                            // echo '没有此权限，应去掉此菜单';
                            unset($myMenus[$k]);
                        }
                    } else {
                        if ($val->child) {
                            foreach ($val->child as $key => $value) {
                                $rightsModel = new \App\Models\RightsModel();
                                $rightsModel->where('right_class', $value->class);
                                $rightsModel->where('right_method', $value->method);
                                $right = $rightsModel->get()->getRow();

                                if (!$right) {
                                    // echo '权限表还没有此权限，插入此权限';
                                    $insertRights = [
                                        'right_class' => $value->class,
                                        'right_method' => $value->method
                                    ];
                                    $rightsModel->insert($insertRights);

                                    $right = (object) $right;
                                    $right->right_id = $this->getInsertID();
                                }
                                $permits = explode(',', $role->rights);
                                if (!in_array($right->right_id, $permits)) {
                                    // echo '没有此权限，应去掉此菜单';
                                    unset($myMenus[$k]->child[$key]);
                                }
                            }
                        }
                    }
                }

                $cache->save('menus_' . $role->id, $myMenus, 0);
            }
        }

        if ($roleID) {
            return $myMenus ?? $menus;
        }

        // echo $this->getLastQuery();
        // echo '<br><hr>';
        // print_r($roles);
        // exit;
    }

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
}
