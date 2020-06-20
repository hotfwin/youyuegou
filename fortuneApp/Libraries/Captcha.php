<?php

namespace App\Libraries;

class Captcha
{
    var $data = [
        'img_path' => 'static/captcha/',
        'img_url' => 'http://hotf.net/static/captcha/',
        'font_path' => 'static/captcha/hy.ttf',
        'img_width' => '130',
        'img_height' => '40',
    ];

    public function __construct()
    {
        $this->data['img_url'] = base_url('static/captcha/');
        // $this->data['font_path']=base_url('static/captcha/hy.ttf');
        // print_r($this->data);exit;
    }

    public function chinese($data = '')
    {
        if (!function_exists('imagettftext')) {
            return '没有freetype扩展，不用使用中文认证码.';
        }

        $defaults = [
            'img_path' => './static/captcha/',
            'img_url' => 'http://future.win/static/captcha/',
            'font_path' => './static/captcha/hy.ttf',
            'img_width' => '150',
            'img_height' => '30',
        ];

        foreach ($defaults as $key => $value) {
            if (is_array($data) && !empty($data)) {
                // $value = isset($data[$key]) ? $data[$key] : $value;
                $value = $data[$key] ?? $value;
                if (isset($data[$key])) {
                    $defaults[$key] = $data[$key];
                }
            }
        }

        //取得随机中文
        $random = $this->randomChar(2);
        $random2 = $this->randomChar(2);

        $image = imagecreate($defaults['img_width'], $defaults['img_height']);   //图片大小

        $bg = imagecolorallocate($image, 0, 0, 0); //背景颜色

        //随机突出表现五种颜色中一种
        switch (mt_rand(1, 5)) {
            case 1:
                $color = imagecolorallocate($image, 164, 0, 84);
                break;
            case 2:
                $color = imagecolorallocate($image, 0, 88, 130);  ###a蓝色
                break;
            case 3:
                $color = imagecolorallocate($image, 255, 255, 255); ###白色
                break;
            case 4:
                $color = imagecolorallocate($image, 255, 255, 0); ###黄色
                break;
            case 5:
                $color = imagecolorallocate($image, 0, 255, 0); ###绿色
                break;
            default:
                $color = imagecolorallocate($image, 255, 255, 0);
        }

        // echo $defaults['font_path'];exit;

        imagettftext($image, mt_rand(13, 19), mt_rand(-7, 3), mt_rand(2, $defaults['img_width'] / 5), 20, $color, $defaults['font_path'], $random);

        switch (mt_rand(1, 5)) {
            case 1:
                $color = imagecolorallocate($image, 164, 0, 84);
                break;
            case 2:
                $color = imagecolorallocate($image, 0, 88, 130);  ###a蓝色
                break;
            case 3:
                $color = imagecolorallocate($image, 255, 255, 255); ###白色
                break;
            case 4:
                $color = imagecolorallocate($image, 255, 255, 0); ###黄色
                break;
            case 5:
                $color = imagecolorallocate($image, 0, 255, 0); ###绿色
                break;
            default:
                $color = imagecolorallocate($image, 255, 255, 0);
        }

        imagettftext($image, mt_rand(13, 19), mt_rand(3, 7), mt_rand($defaults['img_width'] / 2, $defaults['img_width'] - 60), 25, $color, $defaults['font_path'], $random2);

        for ($i = 0; $i < 200; $i++) {
            $we = imagecolorallocate($image, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
            imagesetpixel($image, mt_rand() % $defaults['img_width'], mt_rand() % $defaults['img_height'], $we);
        }
        for ($i = 0; $i < 3; $i++) {
            imageline($image, mt_rand(0, $defaults['img_width']), 12, 12, mt_rand(0, $defaults['img_height']), $we);
        }

        ###输出图像###
        $now = microtime(TRUE);
        $img_path = $defaults['img_path'];

        //删除旧的文件
        $current_dir = @opendir($img_path);
        while ($filename = @readdir($current_dir)) {
            if (
                in_array(substr($filename, -4), array('.jpg', '.png'))
                && (str_replace(array('.jpg', '.png'), '', $filename) + 6600) < $now
            ) {
                @unlink($img_path . $filename);
            }
        }
        @closedir($current_dir);

        if (function_exists('imagepng')) {
            $img_filename = $now . '.png';
            imagepng($image, $img_path . $img_filename);
        } elseif (function_exists('imagejpeg')) {
            $img_filename = $now . '.jpg';
            imagejpeg($image, $img_path . $img_filename);
        } else {
            return FALSE;
        }

        $img = '<img src="' . $defaults['img_url'] . '/' . $img_filename . '" style="width: ' . $defaults['img_width'] . '; height: ' . $defaults['img_height'] . '; border: 0;" alt=" " />';
        ImageDestroy($image);

        $return['word'] = $random . $random2;
        $return['src'] = $defaults['img_url'] . '/' . $img_filename;
        $return['image'] = $img;

        return $return;
    }

    ##产生随机中中文字符###
    function randomChar($num = 4)
    {
        $char = array();
        for ($i = 0; $i < $num; $i++) {
            $c = mt_rand(176, 215);     ###生成随机数，中文应该在176到215中
            ###生成随机中文字符###
            if ($c == 215) {
                $random = chr($c) . chr(mt_rand(161, 249));
            } else {
                $random = chr($c) . chr(mt_rand(161, 254));
            }
            /*检查文字是否重复*/
            if (in_array($random, $char)) {
                $i--;
                continue;
            }
            $char[] = iconv("GB2312", "UTF-8", $random);
        }
        return implode($char);   //直接返回字符串
    }

    /***随机返回英文字符串***/
    function randomEChar($num = 4)
    {
        $char = '';
        $aZ09 = array_merge(range('A', 'Z'), range('a', 'z'), range('0', '9'));
        for ($i = 0; $i < $num; $i++) {
            $char .= $aZ09[mt_rand(0, count($aZ09) - 1)];
        }
        return $char;
    }
}
