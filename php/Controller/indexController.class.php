<?php
	class indexController{
		public function index(){
			$indexModel = M("index");
			$yj_data = $indexModel->yujing();
			$dz_data = $indexModel->dizheng();
			$data = $indexModel->merge($yj_data,$dz_data);
			$indexView = V("index");
			$indexView->index($data);
		}
		public function login(){
			if($_POST){
				$loginModel = M("login");
				$loginModel->login();
			}else{

			}
		}
		public function register(){
			if(isset($_POST)){
				$registerModel = M("register");
				$registerModel->register();
			}else{

			}
		}
		public function page(){
			if(isset($_GET)){
				$pageModel = M("page");
				$data = $pageModel->page();
			}else{

			}
		}
	}
?>