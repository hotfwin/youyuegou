<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class FortuneController extends Controller
{

	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = [];
	protected $model;
	protected $record = TRUE;
	protected $className = '';
	protected $data = [];
	protected $select = '*';
	protected $where = [];
	protected $like = [];
	protected $orderBy = '';   //排序  ,这个还没做========
	protected $join=[];       //联表查询数据
	protected $rules=[];       //$this->validate的认证规则数组
	// protected $pageSize='13'; //每页8、13适合


	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		parent::initController($request, $response, $logger);

		// echo '<br>=========可能等式于__construct()=========<br>';

		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------

		$this->session = \Config\Services::session();

		//定位当前菜单
		$menusModel = new \App\Models\MenusModel();
		$this->data['current'] = $menusModel->getCurrent();

		/*取得菜单*/
		$config = new \Config\Cache();
		$config->handler = 'file';      //确保使用的是文件缓存，而不是其它缓存
		$cache = \Config\Services::cache($config);

		$menus = $cache->get('menus_' . $this->session->get('role'));
		if (!$menus) {
			$menus = $menusModel->saveCacheMenus($this->session->get('role'));
		}
		$this->data['menus'] = $menus;

		$this->className = $this->request->uri->getSegment(1) ?: \Config\Services::routes()->getDefaultController();
		$this->data['className']=$this->className;
	}

	/***
	 *|----------------------------
	 *| 列表
	 *|----------------------------
	 *|  
	 *|------------------------------------------------------ 
	 * ***/
	public function index()
	{

		/* 加载数据模型 */
		$modelName = '\\App\\Models\\' . ucfirst($this->className) . 'Model';
		$this->model = new $modelName();

		$this->model->select($this->select);

		// $this->model->where('parent','');
		if ($this->where) {
			$this->model->where($this->where);
		}

		if ($this->like) {
			$this->model->like($this->like);
		}

		foreach ($this->join as $key => $value) {
			$this->model->join($value['table'],$value['cond'],$value['type']);
			// $this->model->join('goods_class','goods_class.id = goods.cid','LEFT');
			//使用：
			//$this->join[] = ['table' => 'goods_class', 'cond' => 'goods_class.id = goods.cid', 'type' => 'LEFT',];
		}

		$this->model->orderBy($this->orderBy ?: $this->model->table.'.id DESC');

		// $this->data['list'] = $this->model->findAll();
		$this->data['total'] = $this->model->countAllResults(false);
		$this->data['list'] = $this->model->paginate(config('Pager')->perPage);
		$this->data['pager'] = $this->model->pager;

		// echo $this->model->pager->links();exit('输出分页');

		// exit(strtolower($this->className).'/index');

		echo $this->view(strtolower($this->className) . '/index');
	}

	public function create()
	{
		$postData = $this->request->getPost();
		if ($postData) {
			$jumpURL = $postData['jumpURL'] ?? FALSE;
			unset($postData['jumpURL']);

			//去掉空值
			foreach ($postData as $key => $value) {
				if ($value == '') {
					unset($postData[$key]);
				}
			}

			/* 加载数据模型 */
			$modelName = '\\App\\Models\\' . ucfirst($this->className) . 'Model';
			$this->model = new $modelName();

			//before  after
			//是否要分别做插入数据前处理数据！！
			if (method_exists($this, 'beforeCreate')) {
				$this->beforeCreate($postData);
			}

			/**是否要校验输入数据 */
			if(!empty($this->rules)){
				if(!$this->validate($this->rules)){			
					return redirect()->to(site_url($this->className.'/create/'))->withInput();
					exit;
				}
			}

			$insertID = $this->model->insert($postData);  //插入数据

			// print_r($postData);
			// echo $this->model->getLastQuery();exit;

			//插入后处理
			if (method_exists($this, 'afterCreate')) {
				$this->afterCreate($insertID);
			}

			/*是否记录操作日志*/
			if ($this->record) {
				$record['table_id'] = $insertID;
				$record['table_name'] = $this->className;
				$record['user_id'] = $this->session->get('id');
				$record['username'] = $this->session->get('username');
				$record['action'] = 'create';
				$record['record_time'] = date('Y-d-m H:i:s');
				$record['ip'] = $this->request->getIPAddress();

				$recordModel = new \App\Models\RecordModel();
				$recordModel->insert($record);
			}

			return $this->showMessage('新增数据成功',TRUE,$jumpURL);
		}

		// method_exists();

		echo $this->view(strtolower($this->className) . '/create');
	}

	public function edit($id=0){
        if(!$id){
            return $this->showMessage('请选择要修改的数据！！',FALSE);
        }

		/* 加载数据模型 */
		$modelName = '\\App\\Models\\' . ucfirst($this->className) . 'Model';
		$this->model = new $modelName();

		$edit=$this->model->find($id);

        if(!$edit){
            return $this->showMessage('要修改的数据不存在！！',FALSE);
        }

        if($pData=$this->request->getPost()){
			$jumpURL = $pData['jumpURL'] ?? FALSE;
			unset($pData['jumpURL']);
			
            //去掉空值
            // foreach ($pData as $key => $value) {
            //     if($value==''){
            //         unset($pData[$key]);
            //     }
            // }

            //before  after
            //是否要修改数据前处理特别数据！！
            if(method_exists($this,'beforeEdit')){
                $this->beforeEdit($pData);
			}
			
			$this->model->update($id,$pData);

            //插入后处理
            if(method_exists($this,'afterEdit')){
                $this->afterEdit($id);  
            }

            /*是否记录操作日志*/
            if($this->record){
                $record['table_id'] = $id;
				$record['table_name'] = $this->className;
				$record['user_id'] = $this->session->get('id');
				$record['username'] = $this->session->get('username');
				$record['action'] = 'edit';
				$record['record_time'] = date('Y-d-m H:i:s');
				$record['ip'] = $this->request->getIPAddress();

				$recordModel = new \App\Models\RecordModel();
				$recordModel->insert($record);
            }

            return $this->showMessage('数据修改成功',TRUE,$jumpURL);

        } 

		$this->data['edit']=$edit;

		echo $this->view(strtolower($this->className) . '/edit');
	}
	
	public function detail($id=0){
        if(!$id){
            return $this->showMessage('请选择要查看的数据！！',FALSE);
        }

        /* 加载数据模型 */
		$modelName = '\\App\\Models\\' . ucfirst($this->className) . 'Model';
		$this->model = new $modelName();

		$detail=$this->model->find($id);

        if(!$detail){
            return $this->showMessage('要查看的数据不存在！！',FALSE);
        }

        $this->data['detail']=$detail;
    }


	public function delete($id=0){
        $jumpURL=$this->request->getVar('jumpURL')??FALSE;
        if(!$id){
            return $this->showMessage('没有要删除的数据',FALSE,$jumpURL);
        }

        //删除前数据前处理数据！！
        if(method_exists($this,'beforeDelete')){
            $this->beforeDelete($id);
        }

		//删除数据
		/* 加载数据模型 */
		$modelName = '\\App\\Models\\' . ucfirst($this->className) . 'Model';
		$this->model = new $modelName();
		$this->model->delete($id);

		//插入后处理
		if(method_exists($this,'afterDelete')){
			$this->afterDelete($id);  
		}

        /*是否记录操作日志*/
		if ($this->record) {
			$record['table_id'] = $id;
			$record['table_name'] = $this->className;
			$record['user_id'] = $this->session->get('id');
			$record['username'] = $this->session->get('username');
			$record['action'] = 'delete';
			$record['record_time'] = date('Y-d-m H:i:s');
			$record['ip'] = $this->request->getIPAddress();

			$recordModel = new \App\Models\RecordModel();
			$recordModel->insert($record);
		}

        return $this->showMessage('数据删除成功',TRUE,$jumpURL);
	}
	
	public function expurgate(){
		// echo '多选删除';
		$ids=$this->request->getVar('id');

		if(empty($ids)){
			return $this->showMessage('没有要删除的数据！',FALSE);
		}

		/* 加载数据模型 */
		$modelName = '\\App\\Models\\' . ucfirst($this->className) . 'Model';
		$this->model = new $modelName();

		foreach ($ids as $id) {
			//删除数据
			$this->model->delete($id);
		}

		/*是否记录操作日志*/
		if ($this->record) {
			$record['table_id'] = $id;
			$record['table_name'] = $this->className;
			$record['user_id'] = $this->session->get('id');
			$record['username'] = $this->session->get('username');
			$record['action'] = 'expurgate';
			$record['record_time'] = date('Y-d-m H:i:s');
			$record['ip'] = $this->request->getIPAddress();

			$recordModel = new \App\Models\RecordModel();
			$recordModel->insert($record);
		}

		return $this->showMessage('数据删除成功');
	}

	/***
	 *|----------------------------
	 *| 加上提示，并跳转
	 *|----------------------------
	 *|  
	 *|------------------------------------------------------ 
	 * ***/
	protected function showMessage($message, $type = TRUE, $jumpUrl = '')
	{
		$this->session->setFlashdata('type', $type);  //$this->session->flashdata('message');
		$this->session->setFlashdata('message', $message);
		
		if (!$jumpUrl) {
			$jumpUrl = site_url($this->className . '/index/');
		} else {
			$jumpUrl = strpos($jumpUrl, 'http') === false ? site_url($jumpUrl) : $jumpUrl;
		}

		return Header("Location:$jumpUrl"); 


		// echo $jumpUrl;exit; 

		// return redirect()->to($jumpUrl);
	}



	/***
	 *|----------------------------
	 *| view自动加载数据到视图，加载头和尾
	 *|----------------------------
	 *|  封装加上头和尾
	 *|------------------------------------------------------ 
	 * ***/
	public function view(string $name, array $data = [], array $options = []): string
	{
		$renderer = \Config\Services::renderer();  //CodeIgniter\View\View $renderer

		$config = new \Config\View();
		$saveData = $config->saveData;

		if (array_key_exists('saveData', $options)) {
			$saveData = (bool) $options['saveData'];
			unset($options['saveData']);
		}

		$data = $this->data + $data;
		// $data=array_merge($this->data,$data);

		$templates = $renderer->setData($data, 'raw')->render('templates/header', $options, $saveData);
		$templates .= $renderer->setData($data, 'raw')->render($name, $options, $saveData);
		$templates .= $renderer->setData($data, 'raw')->render('templates/footer', $options, $saveData);

		return $templates;
	}


	public function testView()
	{
		$viewPath = APPPATH . 'Views/';
		// exit($viewPath);
		if (!file_exists(APPPATH . '/Views/luck.php')) {
			exit('不存在视图');
		}
		$data['title'] = '幸运的';

		echo view('luck', $data);
	}
}
