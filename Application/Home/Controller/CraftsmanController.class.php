<?php
namespace Home\Controller;
use Think\Controller;

class CraftsmanController extends HomeController {

	/*
	 * 功能：订单中心
	 * 
	 * ******/		
	public function index(){
		header("Content-type: text/html; charset=utf-8");
		$condition['craftsmanid'] = session('user_auth.uid');
		$data = M('craftsman')->where($condition)->find();
		$tech_list = getTechList($data['craftsmanship']);
		
		//**********获取全部状态下的订单列表*********//
		if(!empty($tech_list)){//如果技能不为空
			//获取当前工匠技能状态下，可以提供的服务ＩＤ列表
			$where['cid'] = array('in',implode(',',$tech_list));
			$service_id_list = M('service_craftsmanship')->where($where)->getField('sid',true);			
			
			//根据服务ＩＤ列表，获取服务的名称列表
			$service_w['serviceid'] = array('in',implode(',',$service_id_list));
			$service_name_list = M('service')->where($service_w)->getField('servicename',true);		
			
			//根据服务名称列表，获取订单列表
			$where_order['servicename'] = array('in',implode(',',$service_name_list));
			$where_order['craftsmanid'] = array('in',array(0,session('user_auth.uid')));
			$order_list = M('order')->where($where_order)->select();
			if(!empty($order_list)){
				foreach($order_list as $val){
					$orderids[]=$val['orderid'];
				}
				//根据订单号orderid获取订单地址信息
				$where_addr['orderid'] = array('in',implode(',',array_unique($orderids)));
		
				$address = M('order_address')->where($where_addr)->select();
		
				foreach($address as $val){
					$name_replace[$val['orderid']] = $val['province'].$val['city'].$val['district'];
				}
				//工匠的注册服务地址
				$craftsman_address =  $data['province'].$data['city'].$data['area'];
				//组合数据
				foreach($order_list as $k=>&$val){
					$val['address']=$name_replace[$val['orderid']];
					if($craftsman_address!=$val['address']){//匹配服务地址
						unset($order_list[$k]);
						continue;
					}
					switch($val['status']){
						case 1:	$service1[]=$val;break;
						case 2:	$service2[]=$val;break;
						case 3:	$service3[]=$val;break;
					}
				}
		
				$this->assign('service1',$service1);
				$this->assign('service2',$service2);
				$this->assign('service3',$service3);
						
			}//order_list endif
			
		}
		$this->display();
	} 
	/*
	 * 功能：完善用户信息
	 * 
	 * ******/			
	public function checkin_self_info()
	{
		$this->display("Craftsman/checkinselfinfo");
	}
	/*
	 * 功能：技能管理页面
	 * 
	 * ******/		
	public function modify_tech() {
		$dao = D("craftsman");
		$where_info['craftsmanid'] = session('user_auth.uid');
		$craftsmanInfo = $dao->where($where_info)->find();
		if ($craftsmanInfo['realname'] == "") { // 工匠还没登记个人信息	
			// 如果还没添加一项技能，在添加技能前需要完善个人信息
			$this->checkin_self_info();			
		}
		else {
			//$this->craftsmanInfo = $dao->where("craftsmanid=".$this->craftsmanID)->find();
			$tech = $craftsmanInfo['craftsmanship'];
			//if ($tech == 0) {// 没有技能
			//}
			//else
			//没有技能，直接输出页面提示“你还没有添加技能！”
			if($tech > 0) {
				//算出有哪些技能
				$techarray = array();
				for ($x=0; $x<10; $x++) { //目前只有10个工匠技能
					if ($tech>>$x&1) {//取第x位，如果为真，说明具备此项技能
						$techarray[] = $x+1;
					} // end if
				} // end for
				
				//根据techarray中数字找出这些技能名称
				// to do 
				$condition['craftsmanshipid'] = array('in',implode(',',$techarray));
				//dump($condition);
				$owner_data = D('Craftsmanship')->where($condition)->select();
				//dump($owner_data);
				$this->assign('owner_data',$owner_data);
			
			} // end else
			//从该方法前面移到这里，将已具备的技能去除掉
			$craftsmanship = D('Craftsmanship')->select();
			foreach($craftsmanship as $key=>$val){
				foreach($owner_data as $k=>$v){
					if($val['craftsmanshipid']==$v['craftsmanshipid']){
						unset($craftsmanship[$key]);
					}  
				}
			
			}
			$this->assign('craftsman', $craftsmanship);	
					
			$this->display("Craftsman/tech");
		} // end else
	}		

	/*
	 * 功能：删除技能
	 * 
	 * ******/		
	public function deltech()
	{
		$dao = D("craftsman");
		$where_info['craftsmanid'] = session('user_auth.uid');
		$craftsmanInfo = $dao->where($where_info)->find();		

		$tech = $craftsmanInfo['craftsmanship'];	
		$strbin = decbin($tech);
		$str_arr = str_split($strbin);
		$str_arr = array_reverse($str_arr);
		$str_arr[$_POST['id']-1]=0;
		$str_val = implode('',array_reverse($str_arr));
		$res = $dao->where($where_info)->save(array('craftsmanship'=>bindec($str_val)));
		if($res){
			$this->success('删除成功！');
		}else{
			$this->error('删除失败！');
		}
	
	}
	/*
	 * 功能：添加技能
	 * 
	 * ******/	
	public function addtech()
	{
		$tech_arr=I('tech');
		if(empty($tech_arr)){
			$this->error('请选择技能，再提交',U("craftsman/modify_tech"));
		}
		//获取已有的技能
		$dao = D("craftsman");
		$where_info['craftsmanid'] = session('user_auth.uid');
		$craftsmanInfo = $dao->where($where_info)->find();			

		$tech = $craftsmanInfo['craftsmanship'];
		//dump($_POST['tech']);
		$techarray = array();
		if($tech > 0) {
			//算出有哪些技能
			
			for ($x=0; $x<10; $x++) { //目前只有10个工匠技能
				if ($tech>>$x&1) {//取第x位，如果为真，说明具备此项技能
					$techarray[] = strval($x+1);
				}
			}//for
		} 	
		//合并新旧技能
		//dump($techarray);
		$techs = array_merge($techarray,$_POST['tech']);
		//进行位操作，生成craftsmanship值
		$str = str_repeat('0',32);
		$str_arr = str_split($str);
		
		foreach($techs as $v){
			$str_arr[$v-1]=1;
		}
		$bin = implode('',array_reverse($str_arr));
		//dump($bin);
		$where_dao['craftsmanid']= session('user_auth.uid');
		$res = $dao->where($where_dao)->save(array('craftsmanship'=>bindec($bin)));
		if($res){
			$this->success('添加成功！');
		}else{
			$this->error('添加失败！');
		}
		
	}
	/*
	 * 功能：完善用户信息
	 * 
	 * ******/		
	public function checkininfo()
	{
		if(!empty($_POST['realname'])){
			$dao = M("Craftsman");		
			$dao->realname = I('post.realname');
			$dao->idcard = I('post.idcard');
			$dao->tel = I('post.tel');
			$dao->province = I('post.province');
			$dao->city = I('post.city');
			$dao->area = I('post.area');		
			$condition['craftsmanid'] = session('user_auth.uid');
			$dao->where($condition)->save();		
		}
		$this->redirect('modify_tech');exit;
		//$this->display("Craftsman/tech");
	}
	/*
	 * 功能：ajax方式推送可以抢的订单
	 * 
	 * ******/	
	public function getOrder(){
		if(!empty($_POST['id'])){
			$where['id'] = $_POST['id'];
			$data = M('order')->where($where)->find();
			$where_addr['orderid'] = $data['orderid'];
			$address = M('order_address')->where($where_addr)->find();
			$data['address'] = $address['province'].$address['city'].$address['district'];	
		}else{
			$data = array();
		}
		$this->ajaxReturn($data);
	}
	/*
	 * 功能：ajax方式抢单操作
	 * 
	 * ******/		
	public function grabOrder(){
		$where['id'] = $_POST['id'];

		$cid = M('order')->where($where)->getField('craftsmanid');
		
		if($cid){
			$ajax['status'] = 0;
			$ajax['info'] = '订单已被抢，很抱歉，您迟了一步！';
			
		}else{
			$data['craftsmanid']= session('user_auth.uid');			
			$data['status']= 2;			
			$res = M('order')->where($where)->save($data);
			if($res){
				//抢单成功，再做一次推送，取消在其他工匠面前显示
				
				$order = M('order')->where($where)->find();
		
				$where1['servicename'] = $order['servicename'];
				$serviceid = M('service')->where($where1)->getField("serviceid");
				
				$where2['sid'] = $serviceid;
				$cid = M('service_craftsmanship')->where($where2)->getField("cid");
				
				$where3['orderid'] = $order['orderid'];
				$address = M('order_address')->where($where2)->find();
				
				$where4['province'] = $address['province'];
				$where4['city'] = $address['city'];
				$where4['district'] = $address['district'];
				$where4['client_id'] = array('neq',0);
				$craftsmaninline = D("craftsman")->where($where4)->select();   ///所有订单区域的在线工匠		
	
				foreach($craftsmaninline as $craftman){
					if ($craftman['craftsmanship']>>($cid-1)&1)
					{
						$event['to_client_id'][]=intval($craftman['client_id']);		
					}
		
				}	
				$event['orderid'] = $_POST['id'];
				$event['order_type'] = 'grab';
				
				if(!empty($event['to_client_id'])){
					$ws_data[]=$event;
				}else{
					$ws_data = array();
				}
				if(!empty($ws_data)){
					$ajax['data']  = $ws_data;
					$ajax['type']  = 'order';
				}					
				//
				$ajax['status'] = 1;
				$ajax['info'] = '恭喜您抢单成功！';
			}else{
				$ajax['status'] = 0;
				$ajax['info'] = '抢单失败，刷新页面重试！';
			}		
		
		}

		$this->ajaxReturn($ajax);
	}
	/*
	 * 
	 * ajax方式完成订单操作
	 * ******/	
	public function finishOrder(){
		$where['id'] = $_POST['id'];
	    $data['finishdate']= date("Y-m-d H:i:s");			
		$data['status']= 3;			
		$res = M('order')->where($where)->save($data);
		if($res){
			$ajax['status'] = 1;
			$ajax['info'] = '恭喜您完成订单！';
		}else{
			$ajax['status'] = 0;
			$ajax['info'] = '完成操作失败，刷新页面重试！';
		}		
		$this->ajaxReturn($ajax);
	}
	
	/*
	 * 
	 * ajax方式取消订单操作
	 * ******/	
	public function  removeOrder(){
		$where['id'] = $_POST['id'];
		$update['craftsmanid']=0;
		$update['status']=1;
		$update = M('order')->where($where)->save($update);
		if($update){
			$order = M('order')->where($where)->find();
	
			$where1['servicename'] = $order['servicename'];
			$serviceid = M('service')->where($where1)->getField("serviceid");
			
			$where2['sid'] = $serviceid;
			$cid = M('service_craftsmanship')->where($where2)->getField("cid");
			
			$where3['orderid'] = $order['orderid'];
			$address = M('order_address')->where($where2)->find();
			
			$where4['province'] = $address['province'];
			$where4['city'] = $address['city'];
			$where4['district'] = $address['district'];
			$where4['client_id'] = array('neq',0);
			$craftsmaninline = D("craftsman")->where($where4)->select();   ///所有订单区域的在线工匠		

			foreach($craftsmaninline as $craftman){
				if ($craftman['craftsmanship']>>($cid-1)&1)
				{
					$event['to_client_id'][]=intval($craftman['client_id']);		
				}
	
			}	
			$event['orderid'] = $_POST['id'];
			$event['order_type'] = 'remove';
			
			if(!empty($event['to_client_id'])){
				$ws_data[]=$event;
			}else{
				$ws_data = array();
			}
			$ajax['info']  = '取消成功！';		
			$ajax['status'] = 1;
			if(!empty($ws_data)){
				$ajax['data']  = $ws_data;
				$ajax['type']  = 'order';
			}	
		}else{
			$ajax['info']  = '取消失败，请重试！';
			$ajax['status'] = 0;
		}	
		$this->ajaxReturn($ajax);		
	}

}