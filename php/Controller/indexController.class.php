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
	}
?>