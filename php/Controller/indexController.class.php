<?php
	class indexController{
		public function index(){
			$indexModel = M("index");
			$indexModel->view();
			$yj_data = $indexModel->yujing();
			$dz_data = $indexModel->dizheng();
			$data = $indexModel->merge($yj_data,$dz_data);
			$data = $indexModel->autologin($data);
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
			if(isset($_POST)){
				$pageModel = M("page");
				$pageModel->page();
			}else{

			}
		}
		public function search(){
			if(isset($_POST)){
				$searchModel = M('search');
				$searchModel->search();
			}
		}
		public function searchpage(){
			if(isset($_POST)){
				$searchModel = M('search');
				$searchModel->search_page();
			}
		}
		public function message(){
			if(isset($_POST)){
				$messageModel = M('message');
				$messageModel->message_send();
			}
		}
		public function delmsg(){
			if(isset($_POST)){
				$messageModel = M('message');
				$messageModel->del_message();
			}
		}
		public function updateUser(){
			if(isset($_POST)){
				$userModel = M('index');
				$userModel->update_user();
			}
		}
		public function findpass(){
			if(isset($_POST)){
				$userModel = M('index');
				$userModel->update_pass();
			}
		}
	}
?>