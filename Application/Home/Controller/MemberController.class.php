<?php
namespace Home\Controller;
use Think\Controller;

class MemberController extends HomeController {
	/*
	 * 功能：用户首页
	 * 
	 * ******/	
	public function index(){
		$dao = M("Order");
		$condition['memberid'] = session('user_auth.uid');
		//$condition['status'] = 1;
		$map['status'] = array('lt', 3);
		$service_notcomplete = $dao->where($condition)->where($map)->select();
		if ($service_notcomplete)
		{
			$this->assign('service_num', 1);
			$this->assign('booked_service', $service_notcomplete);
		}
		else
		{
			$this->assign('service_num', 0);
		}
		
		$map1['status'] = 3;
		$service_complete = $dao->where($condition)->where($map1)->select();
		if ($service_complete)
		{
			$this->assign('serviced_num', 1);
			$this->assign('completed_service', $service_complete);
		}
		else
		{
			$this->assign('serviced_num', 0);
		}
		$this->display();
	}   
	/*
	 * 功能：提交服务需求
	 * 
	 * ******/	
	public function submit_order(){
		is_login()||$this->error('请先登录！',U('Index/login'));
		//data:{service:arraySrv,name:name,phone:phone,province:province,city:city,area:area,detailarea:detailarea}
		$loop_var = 1;
		$order_id = md5(uniqid(rand()));		
		$data1['memberid'] = session('user_auth.uid');
		$data1['orderid'] = $order_id;
		$data1['clientname'] = I('post.name');
		$data1['tel'] = I('post.phone');
		$data1['province'] = I('post.province');
		$data1['city'] = I('post.city');
		$data1['district'] = I('post.area');
		$data1['housingestate'] = I('post.detailarea');		
		
		$OrderAddress = D("Order_address");
		$OrderAddress->add($data1);

		$condition1['province'] = I('post.province');
		$condition1['city'] = I('post.city');
		$condition1['area'] = I('post.area');
		$condition1['client_id'] = array('neq',0);
		$craftsmaninline = D("craftsman")->where($condition1)->select();   ///所有订单区域的在线工匠		
		
		
		//$msg = "订单信息\n";
		
		$service = array();
		$service = I('post.service');
		//dump($service);
		
		$Order = M("Order");
		$createdate = time();
		$ipaddress = get_client_ip();
		
		$Srv= M("Service");
		for ($i= 0; $i < count($service); $i++){
			
			if ($i % 2 == 0){
				$condition['serviceid'] = $service[$i];
				$tempserviceid = $service[$i];   ///暂时保存，下面使用
				$tempitem = $Srv->where($condition)->find();
				$data['servicename'] = $tempitem['servicename'];
				$data['price'] = $tempitem['price'];				
			}		
			
			if ($i % 2 == 1){
				$data['expecteddate'] = $service[$i];
			}		
			
			//$msg .= $service[$i];
			
			if ($loop_var == 2)	{
				$data['memberid'] = session('user_auth.uid');
				$data['orderid'] = $order_id;
								
				//$data[''] = date("Y-m-d H:i:s", time());
				$data['status'] = 1;  ///! 1 : 初始状态，无人接单， 2 ： 已接受   3. 订单完成
				$data['createdate'] = $createdate;
				$data['ipaddress'] = $ipaddress;								
				$order = $Order->add($data);

				$event['orderid'] = $order;
				$event['order_type'] = 'new';
				//组装数据

				foreach($craftsmaninline as $craftman){
					if ($craftman['craftsmanship']>>(self::getCid($tempserviceid)-1)&1)
					{
						$event['to_client_id'][]=intval($craftman['client_id']);
					// 如何组装消息
					//最后传到html中是一个数组，每个元素包含一个id(order表里面第一个字段) 和 client id列表
					//有了这个数组，client可以直接发消息给工匠了。工匠知道id就能找到订单了。  
					
					}

				}
				
				if(!empty($event['to_client_id'])){
					$ws_data[]=$event;
				}else{
					$ws_data = array();
				}
				
				$loop_var = 1;
				$event =array();
				//$msg .= "\n";

			} else {			
				$loop_var++;
			}
			
		}	
		//dump($ws_data);	exit;
		if(!empty($ws_data)){
			$return['data']  = $ws_data;
			$return['type']  = 'order';
		}			

		$return['status'] = 1;

		$this->ajaxReturn($return);
	}
	/*
	 * 功能：获取服务对应技能ID
	 * 
	 * ******/
	public static function getCid($sid){
		$where['sid'] = $sid;
		$data = M('service_craftsmanship')->where($where)->getField('cid');
		return $data;
	}
	/*
	 * 功能：删除订单
	 * 
	 * ******/	
	public function delorder(){
		$id_m = explode('_',I('id'));
		if(empty($id_m[0])||empty($id_m[1])){$this->error('参数错误！');}
		if($id_m[1]!=session('user_auth.uid')){$this->error('非法操作！');}
		
		$where['id'] = $id_m[0];
		$where['memberid'] = $id_m[1];
		$order = M("order");
		$orderResult = $order->where($where)->delete();

		if($orderResult){
			$this->success('删除成功！');
			
		}else{
			$this->error('删除失败！');
		}	
	
	}
	/*
	 * 功能：评价操作
	 * 
	 * ******/	
	public function saveComment(){
		$id_s= I('id');
		list($id,$cid)= explode('-',$id_s);
		$where['id']=$id;
		$data['score']=$score = I('score');
		$data['comment']=$comment = I('comment');
		$data['iscommented']=1;
		if($id&&$score&&$comment){
			$orderResult = M('order')->where($where)->save($data);
			$user['craftsmanid'] = $cid;
			$userResult = M('craftsman')->where($user)->setInc('credibility',$score); 
			if($orderResult&&$userResult){
				$ajax['status'] = 1;
				$ajax['info'] = '评价成功！';

				
			}else{
				$ajax['status'] = 0;
				$ajax['info'] = '评价失败！';
			}				
			$this->ajaxReturn($ajax);
		}

	}
	/*
	 * 功能：
	 * 
	 * ******/		
	public function craftsmanship() {
		$arr = array();
		$arr = I('post.checkbox');
		/* 即使不选择，$arr也会有一个string ""存在，所以需要用count(I('post.')) == 1去判断 */		
		if (count(I('post.')) == 1)
		{
			$this->error("请至少选择一项服务,谢谢!");
		}
		
		$AllService = D('craftsmanship');
		$ship = array();
		foreach ($arr as $key => $value) 
		{ 
			$condition['craftsmanshipid'] = $value;
			//dump($AllService->where($condition)->select());
			$ship[] = $AllService->where($condition)->select();
		}
		$this->craftsmanships = $ship;	
		//dump($this->craftsmanship);
		$this->display();
	}
	/*
	 * 功能：
	 * 
	 * ******/		
	public function craftsmanshipregister(){		
		//$condition['name'] = I('post.skill');
		//$craftsmanshipid = M("Craftsmanship")->field('craftsmanshipid')->where($condition)->select();

		$dao = D("Journeyman");
		$data1['realname'] = I('post.realname');
		$data1['idcard'] = I('post.idcard');
		$data1['tel'] = I('post.tel');
		$data1['gender'] = 1;// I('post.gender');
		$data1['serviceprovince'] = I('post.province');
		$data1['servicecity'] = I('post.city');
		$data1['servicedistrict'] = I('post.area');
		$data1['memberid'] = session('user_auth.uid');
		$data1['createdate'] = time();
		$data1['craftsmanship'] = (int)I('post.skill');
		$dao->add($data1);
		//dump($data);
		$msg = "gao ding";
		$data = array('status'=>1,'msg'=>$msg);
		$this->ajaxReturn($data);
	}

}