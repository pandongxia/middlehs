<?php
namespace Home\Controller;
use Think\Controller;
class HomeController extends Controller {
	function _initialize(){

	}
	
	/*
	 * 功能：退出操作
	 * 
	 * ******/		
	public function Logout(){
		//退出就删除所有clientID临时表
		$where['ip']=session('user_auth.uid');
		M('test')->where($where)->delete();
		session(null);
		$this->redirect("Index/index");
	}
	/*
	 * 功能：获取用户ID
	 * 
	 * ******/			
	public function getUid(){
		$ajax['id']  = session('user_auth.uid');
		$this->ajaxReturn($ajax);		 
	
	}	
	
}
