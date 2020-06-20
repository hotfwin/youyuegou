<?php

namespace App\Libraries;

/***
 *|----------------------------
 *| MyUpload.php
 *|----------------------------
 *| 我的文件上传类
 *| 问题： 主要处理fileuploader文件上传
 *|------------------------------------------------------------------------
 *| Author:临来笑笑生    Email:luck@fmail.pro      Modify: 2018.06.20
 *|------------------------------------------------------------------------
 * ***/
class MyUpload
{
    private $field = [
        'name' => 'files',      //默认<input type="file" name="files">
        'input' => null,
        'listInput' => null
    ];

    private $options = [
        'limit' => null,
        'maxSize' => null,
        'fileMaxSize' => null,
        'extensions' => null,
        'required' => false,
        'uploadDir' => 'uploads/',
        'title' => array('auto', 18),    //自动重命名，文件名长度为18
        'replace' => false,
        'listInput' => true,
        'files' => array()
    ];

    public function __construct($options = null)
    {
        $this->options = $options ? array_merge($this->options, $options) : $this->options;
        if (!is_array($this->options['files'])) {
            $this->options['files'] = array();
        }

        //目录不存在则新建
        if (!is_dir($this->options['uploadDir'])) {
            mkdir($this->options['uploadDir'], 0777, true);
        }
    }

    public function uploads($name = null)
    {
        $this->field['name'] = $name ?: $this->field['name'];
        $this->field['listInput'] = $this->getListInputFiles($name);

        if (isset($_FILES[$this->field['name']])) {
            $this->field['input'] = $_FILES[$this->field['name']];

            if (!is_array($this->field['input']['name'])) {
                $this->field['input'] = array_merge($this->field['input'], array(
                    "name" => array($this->field['input']['name']),
                    "tmp_name" => array($this->field['input']['tmp_name']),
                    "type" => array($this->field['input']['type']),
                    "error" => array($this->field['input']['error']),
                    "size" => array($this->field['input']['size'])
                ));
            }

            foreach ($this->field['input']['name'] as $key => $value) {
                if (empty($value)) {
                    unset($this->field['input']['name'][$key]);
                    unset($this->field['input']['type'][$key]);
                    unset($this->field['input']['tmp_name'][$key]);
                    unset($this->field['input']['error'][$key]);
                    unset($this->field['input']['size'][$key]);
                }
            }

            $this->field['count'] = count($this->field['input']['name']);   //上传了几个文件


        }

        // 开始处理上传
        $data = [
            "hasWarnings" => false,
            "isSuccess" => false,
            "warnings" => array(),
            "files" => array()
        ];

        $listInput = $this->field['listInput'];      //文件列表

        if ($this->field['input']) {
            //存在文件上传
            $validate = $this->validate();
            $data['isSuccess'] = true;

            if ($validate === true) {
                // echo '开始处理文件上传';
                foreach ($this->field['input']['name'] as $key => $value) {
                    /*上传的文件*/
                    $file = [
                        'name' => $this->field['input']['name'][$key],
                        'type' => $this->field['input']['type'][$key],
                        'tmp_name' => $this->field['input']['tmp_name'][$key],
                        'error' => $this->field['input']['error'][$key],
                        'size' => $this->field['input']['size'][$key]
                    ];

                    $metas = array();
                    $metas['tmp_name'] = $file['tmp_name'];     //临时文件
                    $metas['extension'] = substr(strrchr($file['name'], "."), 1);  //扩展名
                    $metas['size'] = $file['size'];  //文件大小
                    $metas['type'] = $file['type'];
                    $metas['old_name'] = $file['name'];
                    $metas['old_title'] = substr($metas['old_name'], 0, (strlen($metas['extension']) > 0 ? - (strlen($metas['extension']) + 1) : strlen($metas['old_name'])));    //上传原名，不过扩展
                    $metas['size2'] = $this->formatSize($file['size']); //人类可读文件大小

                    $metas['name'] = $this->generateFileName($this->options['title'], array(
                        'title' => $metas['old_title'],
                        'size' => $metas['size'],
                        'extension' => $metas['extension']
                    ));    //得到新的文件名

                    $metas['title'] = substr($metas['name'], 0, (strlen($metas['extension']) > 0 ? - (strlen($metas['extension']) + 1) : strlen($metas['name'])));
                    $metas['file'] = str_replace(getcwd() . '/', '', $this->options['uploadDir']) . $metas['name'];
                    $metas['replaced'] = file_exists($metas['file']);

                    $metas['date'] = date('r');
                    ksort($metas);   //按键名排序

                    $validateFile = $this->validate(array_merge($metas, array('index' => $key, 'tmp' => $file['tmp_name'])));
                    $listInputName = '0:/' . $metas['old_name'];
                    $fileInList = $listInput === null || in_array($listInputName, $listInput);

                    if ($validateFile === true) {
                        if ($fileInList) {
                            $data['files'][] = $metas;

                            if ($listInput)
                                unset($listInput[array_search($listInputName, $listInput)]);
                        }
                    } else {
                        $data['isSuccess'] = false;
                        $data['hasWarnings'] = true;
                        $data['warnings'][] = $validateFile;
                        $data['files'] = array();

                        break;
                    }
                }

                if (!$data['hasWarnings']) {
                    foreach ($data['files'] as $key => $file) {
                        if (move_uploaded_file($file['tmp_name'], $file['file'])) {
                            unset($data['files'][$key]['tmp_name']);
                            $data['files'][$key]['uploaded'] = true;
                            $this->options['files'][] = $data['files'][$key];
                        } else {
                            unset($data['files'][$key]);
                        }
                    }
                }
            } else {
                $data['isSuccess'] = false;
                $data['hasWarnings'] = true;
                $data['warnings'][] = $validate;
            }
        } else {
            if ($this->options['required'] && (isset($_SERVER) && strtolower($_SERVER['REQUEST_METHOD']) == "post")) {
                $data['hasWarnings'] = true;
                $data['warnings'][] = $this->codeToMessage('required_and_no_file');
            }
        }

        return $data;
    }

    /*文件名处理*/
    private function generateFilename($conf, $file, $skip_replace_check = false)
    {
        $conf = !is_array($conf) ? array($conf) : $conf;
        $type = $conf[0];         //传入title 标题
        $length = isset($conf[1]) ? (int) $conf[1] : 12;
        $random_string = substr(str_shuffle("_0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
        $extension = !empty($file['extension']) ? "." . $file['extension'] : "";
        $string = "";

        switch ($type) {
            case null:
            case "auto":
                $string = $random_string;
                break;
            case "name":
                $string = $file['title'];
                break;
            default:
                $string = $type;

                $string = str_replace("{random}", $random_string, $string);
                $string = str_replace("{file_name}", $file['title'], $string);
                $string = str_replace("{file_size}", $file['size'], $string);
                $string = str_replace("{timestamp}", time(), $string);
                $string = str_replace("{date}", date('Y-n-d_H-i-s'), $string);
                $string = str_replace("{extension}", $file['extension'], $string);
        }
        $string .= $extension;

        /*默认存在同名文件时就，重新命名*/
        if (!$this->options['replace'] && !$skip_replace_check) {
            $title = $file['title'];
            $i = 1;
            while (file_exists($this->options['uploadDir'] . $string)) {
                $file['title'] = $title . " ({$i})";
                $conf[0] = $type == "auto" || $type == "name" || strpos($string, "{random}") !== false ? $type : $type  . " ({$i})";
                $string = $this->generateFileName($conf, $file, true);
                $i++;
            }
        }

        return $this->filterFilename($string);
    }

    /*删除不可用的文件名字符*/
    private function filterFilename($filename)
    {
        $delimiter = '_';
        $invalidCharacters = array_merge(array_map('chr', range(0, 31)), array("<", ">", ":", '"', "/", "\\", "|", "?", "*"));

        // remove invalid characters
        $filename = str_replace($invalidCharacters, $delimiter, $filename);
        // remove duplicate delimiters
        $filename = preg_replace('/(' . preg_quote($delimiter, '/') . '){2,}/', '$1', $filename);

        return $filename;
    }



    private function validate($file = null)
    {
        if ($file == null) {
            // check ini settings and some generally options
            $ini = array(
                (bool) ini_get('file_uploads'),
                (int) ini_get('upload_max_filesize'),
                (int) ini_get('post_max_size'),
                (int) ini_get('max_file_uploads'),
                (int) ini_get('memory_limit')
            );

            if (!$ini[0])
                return $this->codeToMessage('file_uploads');
            if ($this->options['required'] && (isset($_SERVER) && strtolower($_SERVER['REQUEST_METHOD']) == "post") && $this->field['count'] + count($this->options['files']) == 0)
                return $this->codeToMessage('required_and_no_file');
            if (($this->options['limit'] && $this->field['count'] + count($this->options['files']) > $this->options['limit']) || ($ini[3] != 0 && ($this->field['count']) > $ini[3]))
                return $this->codeToMessage('max_number_of_files');
            if (!file_exists($this->options['uploadDir']) && !is_writable($this->options['uploadDir']))
                return $this->codeToMessage('invalid_folder_path');

            $total_size = 0;
            foreach ($this->field['input']['size'] as $key => $value) {
                $total_size += $value;
            }
            $total_size = $total_size / 1000000;
            if ($ini[2] != 0 && $total_size > $ini[2])
                return $this->codeToMessage('post_max_size');
            if ($this->options['maxSize'] && $total_size > $this->options['maxSize'])
                return $this->codeToMessage('max_files_size');
        } else {
            // check file
            if ($this->field['input']['error'][$file['index']] > 0)
                return $this->codeToMessage($this->field['error'][$file['index']], $file);
            if ($this->options['extensions'] && (!in_array($file['extension'], $this->options['extensions']) && !in_array($file['type'], $this->options['extensions'])))
                return $this->codeToMessage('accepted_file_types', $file);
            if ($this->options['fileMaxSize'] && $file['size'] / 1000000 > $this->options['fileMaxSize'])
                return $this->codeToMessage('max_file_size', $file);
            if ($this->options['maxSize'] && $file['size'] / 1000000 > $this->options['maxSize'])
                return $this->codeToMessage('max_file_size', $file);
        }

        return true;
    }

    /*格式化文件大小*/
    private function formatSize($bytes)
    {
        if ($bytes >= 1073741824) {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes > 0) {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        } else {
            $bytes = '0 bytes';
        }

        return $bytes;
    }

    /*文件上传错误代码*/
    private function codeToMessage($code, $file = null)
    {
        $message = null;

        switch ($code) {
            case UPLOAD_ERR_INI_SIZE:
                $message = "文件大小超过了PHP.INI中upload_max_filesize选项限制的值 ";
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $message = "上传文件的大小超过了HTML表单中MAX_FILE_SIZE选项值";
                break;
            case UPLOAD_ERR_PARTIAL:
                $message = "文件只有部分被上传";
                break;
            case UPLOAD_ERR_NO_FILE:
                $message = "用户没有提供任何文件上传";
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $message = "Missing a temporary folder";
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $message = "Failed to write file to disk";
                break;
            case UPLOAD_ERR_EXTENSION:
                $message = "File upload stopped by extension";
                break;
            case 'accepted_file_types':
                $message = "File type is not allowed for " . $file['old_name'];
                break;
            case 'file_uploads':
                $message = "在php.ini中禁用文件上传选项";
                break;
            case 'max_file_size':
                $message = $file['old_name'] . " is too large";
                break;
            case 'max_files_size':
                $message = "Files are too big";
                break;
            case 'max_number_of_files':
                $message = "Maximum number of files is exceeded";
                break;
            case 'required_and_no_file':
                $message = "没有文件上传,请选择一个";
                break;
            case 'invalid_folder_path':
                $message = "Upload folder doesn't exist or is not writable";
                break;
            default:
                $message = "Unknown upload error";
                break;
        }

        return $message;
    }



    public function getListInputFiles($name = null)
    {
        $inputName = 'fileuploader-list-' . ($name ?: $this->field['name']);

        if (is_string($this->options['listInput'])) {
            $inputName = $this->options['listInput'];
        }

        if (isset($_POST[$inputName]) && $this->isJSON($_POST[$inputName])) {
            $fileList = json_decode($_POST[$inputName], true);

            return $fileList;
        }

        return null;
    }

    private function isJson($string)
    {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    public function test()
    {
        print_r($this->options);
        echo 'here';
    }
}
