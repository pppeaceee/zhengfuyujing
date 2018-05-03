<?php
	class adminController{
		public function __construct(){
			$this->adminView = V("admin");
			$this->adminModel = M("admin");
		}
		public function admin(){
			if($this->adminModel->login() != 0){
				$data = $this->adminModel->admin();
				$this->adminView->index($data);
			}else{
				$this->adminModel->index();
			}
		}
		public function usercommand(){
			$data = $this->adminModel->usercommand();
			// print_r($data);
			$this->adminView->usercommand($data);
		}
		public function commander(){
			$data = $this->adminModel->commander();
			$this->adminView->commander($data);
		}
		public function note(){
			$data = $this->adminModel->note();
			$this->adminView->note($data);
		}

		public function warnData(){
			$this->adminModel->warn_data();
		}
		public function userData(){
			$this->adminModel->user_data();
		}
		public function updateadmin(){
			$this->adminModel->update_admin();
		}
		public function deluser(){
			$this->adminModel->del_user();
		}
		public function actuser(){
			$this->adminModel->act_user();
		}
		public function delnote(){
			$this->adminModel->del_note();
		}
		public function logout(){
			$this->adminModel->logout();
		}
	}
?>