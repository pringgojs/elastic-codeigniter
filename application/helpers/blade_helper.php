<?php

use Jenssegers\Blade\Blade;


defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('view')){
	function view($view, $data = []){
    $path = APPPATH.'views';
		$blade = new Blade($path, $path.'/cache');

    return $blade->make($view, $data)->render();
	}
}