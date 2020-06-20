<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

//检查是否登录的过滤器
class LoginFilter implements FilterInterface
{
    public function before(RequestInterface $request)
    {
        // echo '前置过滤器，这里用杰检测是否登录<br>';exit;

        // print_r($request->uri->getSegments());exit;

        if (session('id') == '') {
            $session=\Config\Services::session();
            $jumpUrl=$request->uri->getSegment(1);
            $jumpUrl=$jumpUrl!=''?$jumpUrl.'/'.$request->uri->getSegment(2):'';
            // echo $jumpUrl;exit;
            $session->setFlashdata('jumpUrl',$jumpUrl);

            // echo '<hr>没有登录，请跳到登录页<hr><br>';
            return redirect()->to(site_url('login/index'));
        }

        // echo '<hr>检查是否有权限访问<hr>';
        $rightsModel = new \App\Models\RightsModel();

		if(!$rightsModel->permit()){
			exit('<hr>你没有权限访问此页<hr>');
        }
        
    }

    public function after(RequestInterface $request,ResponseInterface $response)
    {
        return view($this->request->uri->getSegment(1).'/'.$this->request->uri->getSegment(2));
    }

}

