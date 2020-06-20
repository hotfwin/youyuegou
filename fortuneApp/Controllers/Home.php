<?php

namespace App\Controllers;

class Home extends FortuneController
{
	public function index()
	{

		// echo echoLuck();

		

		return view('welcome_message');
	}

	//--------------------------------------------------------------------

}
