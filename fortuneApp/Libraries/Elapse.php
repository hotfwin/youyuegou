<?php
namespace App\Libraries;

class Elapse 
{
    public function Hi(){
        echo echoLuck('世界末日');
        $session=\Config\Services::session();   //使用CI的session

        $session->set('elapse','临来笑笑生,888');  //设置session

        return 'Hi,临来笑笑生';
    }
    
}
