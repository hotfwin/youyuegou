<?php

namespace App\Controllers;

//图形验证码还没有做

class Login extends FortuneController
{
    public function index()
    {
        $session = \Config\Services::session();
        $data['error'] = $session->getFlashdata('error');

        $session->keepFlashdata('jumpUrl');  //flase不能隔一次中转,所以这里要保持它

        $throttle = session('throttle_' . old('login')) ?: 0;
        $data['throttle'] = $throttle;

        if ($throttle > 0) {
            $captch = new \App\Libraries\Captcha();

            $config = [
                'img_path' => 'static/captcha/',
                'font_path' => 'static/captcha/hy.ttf',
                'img_width' => '130',
                'img_height' => '40',
                'img_url' => base_url('static/captcha/')
            ];

            $image = $captch->chinese($config);
            $session->setTempdata('captcha', $image['word'], 120);   //120秒内有效
            $data['captchaImg'] = $image['src'];
        }

        return view($this->request->uri->getSegment(1) . '/' . $this->request->uri->getSegment(2), $data);
    }

    public function check()
    {
        // echo '用户登录检测';

        $session = \Config\Services::session();

        //===================
        // $session=\Config\Services::session();
        $jumpUrl = $session->getFlashdata('jumpUrl');
        print_r($jumpUrl);
        echo '登录成功';
        //=======================

        if (!$this->validate([
            'login' => 'required|min_length[3]|max_length[255]',
            'passwd'  => 'required|min_length[3]'
        ])) {
            // echo \Config\Services::validation()->showError('login');
            // echo '<hr><br>';
            // echo \Config\Services::validation()->listErrors();exit;

            $error = \Config\Services::validation()->listErrors();

            $session->setFlashdata('error', $error);

            // 'withInput'方法意味着"原有的数据"需要被存储。
            // return redirect()->back()->withInput();
            return redirect()->to(site_url('login/index/'))->withInput();
        }

        $login = $this->request->getPost('login');
        $passwd = $this->request->getPost('passwd');
        $captcha = $this->request->getPost('captcha');

        $throttle = session('throttle_' . $login) ?: 0;
        if ($throttle >= 1) {
            echo '非第一次密码错误，要验证输入验证码!';

            if ($captcha != $session->getTempdata('captcha')) {
                $session->setFlashdata('error', '验证码错误');
                return redirect()->to(site_url('login/index/'))->withInput();
            }


            // if ($throttle > 3) {
            //     echo '你的账号密码出错太多数，请重新找回密码，或者一个小时后再来试！！';
            //     echo '这里还没做冻结账号一小时操作';
            //     exit;
            // }
        }

        $adminModel = new \App\Models\AdminsModel();
        $admin = $adminModel->getLogin($login);

        if (!$admin) {
            $session->setFlashdata('error', '无此用户');
            return redirect()->to(site_url('login/index/'))->withInput();
        }

        if ($admin->password != $adminModel->encryption($passwd, $admin->salt)) {
            // echo '密码不正确';
            $session->set('throttle_' . $login, ++$throttle);   //记录密码错误次数

            if ($throttle > 3) {
                // echo '<hr>超过三次密码错误，锁定账号一个小时!<hr>';

                $time = time() + HOUR;
                if ($admin->status != 1 && $time > $admin->status) {
                    //如果非永久禁用，及以前禁用时长超过现在的一小时，那不改变，按以前禁用
                    $adminModel->update($admin->id, ['status' => $time]);
                }
            }

            $session->setFlashdata('error', '密码错误');
            return redirect()->to(site_url('login/index/'))->withInput();
        }

        if ($admin->status) {
            if ($admin->status == 1 || $admin->status > time()) {
                $session->setFlashdata('error', $admin->status == 1 ? '你账号被永久冻结' : '账号被冻结，自动解冻时间为：' . date('Y-m-d H:i:s', $admin->status));
                return redirect()->to(site_url('login/index/'))->withInput();
            }

            //到了自动解冻账号
            $adminModel->update($admin->id, ['status' => 0]);
        }

        //设置登录SESSION，以及跳转
        $session->set((array) $admin);

        //更新最后登录时间
        $adminModel->update($admin->id, ['last_login' => time()]);

        // $jumpUrl=$session->get('jumpUrl');
        $jumpUrl = $session->getFlashdata('jumpUrl');

        if (!$jumpUrl) {
            $rolesModel = new \App\Models\RolesModel();
            $jumpUrl = $rolesModel->getRolesDefault($admin->role);
        }

        return redirect()->to(site_url($jumpUrl ?: ''));
    }

    public function quit()
    {
        $session = \Config\Services::session();
        $session->destroy();
        return redirect()->to(site_url('login/index'));
    }

    public function getCaptcha()
    {
        $show['status'] = FALSE;
        $captch = new \App\Libraries\Captcha();

        $config = [
            'img_path' => 'static/captcha/',
            'font_path' => 'static/captcha/hy.ttf',
            'img_width' => '130',
            'img_height' => '40',
            'img_url' => base_url('static/captcha/')
        ];

        $image = $captch->chinese($config);

        if ($image) {
            $show['status'] = TRUE;
            $show['word'] = $image['word'];
            $show['src'] = $image['src'];
            $show['image'] = $image['image'];

            \Config\Services::session()->setTempdata('captcha', $image['word'], 120);   //120秒内有效
        }


        $this->response->setHeader('Access-Control-Allow-Origin', '*');
        return $this->response->setJSON($show);
    }



    public function succeed()
    {
        $session = \Config\Services::session();
        $jumpUrl = $session->getFlashdata('jumpUrl');
        print_r($jumpUrl);
        echo '登录成功';
        echo '<hr>';
        echo session('elapse');
        echo '<hr>';
        print_r(session());
        exit;
    }

    public function captch()
    {
        $captch = new \App\Libraries\Captcha();

        $config = [
            'img_path' => 'static/captcha/',
            'font_path' => 'static/captcha/hy.ttf',
            'img_width' => '130',
            'img_height' => '40',
            'img_url' => base_url('static/captcha/')
        ];

        $images = $captch->chinese($config);

        print_r($images);
    }

    public function test()
    {
        $elapse = new \App\Libraries\Elapse();
        echo $elapse->Hi();
        exit;
        helper('form');

        if (!$this->validate([
            'title' => 'required|min_length[3]|max_length[255]',
            'body'  => 'required'
        ])) {
            return view($this->request->uri->getSegment(1) . '/' . $this->request->uri->getSegment(2));
        }
    }
}
