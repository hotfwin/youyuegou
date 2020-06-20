<?php
// Valid PHP Version?
$minPHPVersion = '7.2';
if (phpversion() < $minPHPVersion) {
	die("你的PHP版本必须大于{$minPHPVersion}. 你当前的PHP版本: " . phpversion());
}
unset($minPHPVersion);

//定义当前目录
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);     

//路径配置文件，根据自己的来配置
$pathsPath = realpath(FCPATH . '../fortuneApp/Config/Paths.php');
// ^^^ 如果您移动您的应用程序文件夹，请更改此选项

/*
 *---------------------------------------------------------------
 * BOOTSTRAP THE APPLICATION
 *---------------------------------------------------------------
 * This process sets up the path constants, loads and registers
 * our autoloader, along with Composer's, loads our constants
 * and fires up an environment-specific bootstrapping.
 */

// Ensure the current directory is pointing to the front controller's directory
chdir(__DIR__);

// Load our paths config file
require $pathsPath;
$paths = new Config\Paths();

// Location of the framework bootstrap file.
$app = require rtrim($paths->systemDirectory, '/ ') . '/bootstrap.php';  //包含vendor/codeigniter4/framework/system/bootstrap.php

/*
 *---------------------------------------------------------------
 * LAUNCH THE APPLICATION
 *---------------------------------------------------------------
 * Now that everything is setup, it's time to actually fire
 * up the engines and make this app do its thang.
 */
$app->run();
