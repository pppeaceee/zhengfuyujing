<?php
	function C($name,$method){
		require_once('php/Controller/'.$name.'Controller.class.php');
		eval('$obj = new '.$name.'Controller();$obj->'.$method."();");
	}
	function M($name){
		require_once('php/Model/'.$name.'Model.class.php');
		eval('$obj = new '.$name.'Model();');
		return $obj;
	}
	function V($name){
		require_once('php/View/'.$name.'View.class.php');
		eval('$obj = new '.$name.'View();');
		return $obj;
	}
?>