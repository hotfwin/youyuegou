<?php

/**
 * The goal of this file is to allow developers a location
 * where they can overwrite core procedural functions and
 * replace them with their own. This file is loaded during
 * the bootstrap process and is called during the frameworks
 * execution.
 *
 * This can be looked at as a `master helper` file that is
 * loaded early on, and may also contain additional functions
 * that you'd like to use throughout your entire application
 *
 * @link: https://codeigniter4.github.io/CodeIgniter4/
 */

// exit('公用函数定在这里');

if (!function_exists('echoLuck')) {
	function echoLuck(string $name = '临来笑笑生')
	{
		return $name;
	}
}

if (!function_exists('showQiniu')) {
	function showQiniu($uuid)
	{
		$picturesModel = new \App\Models\PicturesModel();
		return $picturesModel->showUUID($uuid);
	}
}

//商品审核状态:审核状态 1 通过 0 审核失败 2 审核中
if (!function_exists('goodsVerify')) {
	function goodsVerify($verify)
	{
		$return = '';
		switch ($verify) {
			case '0':
				$return = '审核失败';
				break;
			case '1':
				$return = '审核通过';
				break;
			case '2':
				$return = '审核中';
				break;

			default:
				# code...
				break;
		}
		return $return;
	}
}
