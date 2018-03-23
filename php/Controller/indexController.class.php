<?php
	class indexController{
		public function index(){
			$indexModel = M("index");
			$yj_data = $indexModel->yujing();
			$dz_data = $indexModel->dizheng();
			$indexView = V("index");
			$indexView->index($yj_data);
		}
	}
?>