<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends HomeController {
	/*
	 * 功能：首页
	 * 
	 * ******/
    public function index(){
    	//服务项目列表
    	$this->service = D('Service')->select();
    	//默认期望服务时间
    	$this->currenttime = substr(date("Y/m/d H:i:s",time()), 0, -3);
    	//登录后的默认服务地址
    	$where['memberid']= session('user_auth.uid');

    	if($where['memberid']>0){
    		
			$this->data = M('order_address')->where($where)->find();
    	}
        $this->display();
    }
	/*
	 * 功能：注册页面
	 * 
	 * ******/
	public function join(){
		$this->display('index/register');
	}
	/*
	 * 功能：登录页面
	 * 
	 * ******/	
	public function login(){
		$this->display();
	}	
	/*
	 * 功能：注册操作
	 * 
	 * ******/			
	public function doJoin(){
		$type = I('post.type');
		if ($type == 1)
		{		
			$dao = D('Member');
			if ($data = $dao->create()){
				$this->validate_url($data,$type);//发送激活邮件
				$mail_login_url = gotomail($data['email']);
				$id = $dao->add();
				$this->success("注册成功，请先激活邮箱后登录。<a href='http://".$mail_login_url."' style='color:red;'>点击跳转</a>",U('index/login'),10);				
			}
			else{			
				$this->error('注册失败');
			}
		}
		else
		{
			$dao = D('Craftsman');
			if ($data = $dao->create()){
				$id = $dao->add();
				session('craftsmanID', $id);
				$this->validate_url($data,$type);//发送激活邮件
				$mail_login_url = gotomail($data['email']);
				$this->success("注册成功，请先激活邮箱后登录。<a href='http://".$mail_login_url."' style='color:red;'>点击跳转</a>",U('index/login'),10);
				//$this->redirect ("Craftsman/index");			
			}
			else{			
				$this->error('注册失败');
			}
		}
	}
	/*
	 * 功能：登录，支持邮箱、用户名登录
	 * 
	 * ******/	
	public function doLogin(){
		$type = I('post.type');
		$username = I('post.username');
	 	$pattern = "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i";
        if ( preg_match( $pattern, $username ) )
        {
           $where['email']= $username;
        }
        else
        {
            $where['username']= $username;
        }

		if ($type == 1)
		{
			$dao = D("Member");
			$status = 0;
			$msg = "";
			$list=$dao->where($where)->find();
			if (!$list){
				//$this->error ( "username error, do not have this account!");
				$data = array('status'=>0,'info'=>'用户名或邮箱名不正确！','url'=>U("home/index/login"));
				$this->ajaxReturn($data);
			}
			else{
				if (md5($_POST['password']) != $list['password']){
					//$this->error ( "Password error!");
					$data = array('status'=>0,'info'=>'密码错误！','url'=>U("home/index/login"));
					$this->ajaxReturn($data);
				}else if($list['status']<=0){
					$data = array('status'=>0,'info'=>'账号未激活，请进入邮箱['.$list['email'].']激活！','url'=>U("home/index/login"));
					$this->ajaxReturn($data);				
				
				}else{
					$this->autoLogin($list);		
					$data['lastlogintime'] = time();
					$data['lastloginip'] = get_client_ip();
					$dao->where("memberid ='".$list['memberid']."'")->save($data);
					//$status = 1;				
					//$this->jumpUrl=U('Index/index');
					//$this->success("登录成功！",U("home/index/index"));
					$data = array('status'=>1,'type'=>1,'info'=>'登录成功！','url'=>U("home/Member/index"));
					$this->ajaxReturn($data);
				}
			}
		}
		else
		{
			$dao = D("Craftsman");
			$status = 0;
			$msg = "";
			$list=$dao->where($where)->find();
			if (!$list){
				//$this->error ( "username error, do not have this account!");
				$data = array('status'=>0,'info'=>'用户名或邮箱名不正确！','url'=>U("home/index/login"));
				$this->ajaxReturn($data);
			}
			else{
				if (md5($_POST['password']) != $list['password']){
					//$this->error ( "Password error!");
					$data = array('status'=>0,'info'=>'密码错误！','url'=>U("home/index/login"));
					$this->ajaxReturn($data);					
				}else if($list['status']<=0){
					$data = array('status'=>0,'info'=>'账号未激活，请先进入邮箱['.$list['email'].']激活！','url'=>U("home/index/login"));
					$this->ajaxReturn($data);				
				
				}else{

					$this->autoLogin($list);			
					$data['lastlogintime'] = time();
					$data['lastloginip'] = get_client_ip();
					$dao->where("craftsmanid ='".$list['craftsmanid']."'")->save($data);
					//$status = 1;				
					//$this->jumpUrl=U('Index/index');
					//$this->success("登录成功！",U("home/craftsman/index"));
					//$data = array('status'=>1,'type'=>2,'info'=>'登录成功！','url'=>U("home/index/index"),'id'=>$list['craftsmanid']);
					$data = array('status'=>1,'type'=>2,'info'=>'登录成功！','url'=>U("home/Craftsman/index"),'id'=>$list['craftsmanid']);
					$this->ajaxReturn($data);					
				}
			}
		}
		

		
	}		
	/*
	 * 功能：发送注册邮件
	 * 
	 * ******/
	public function validate_url($data,$type=1){
		$args['u'] = $data['username'];
		$args['t'] = $type==1?'member':'craftsman';
		$args['p'] = md5($data['password'].VALIDATE_STRING.'12520');
		$url ='http://localhost/'.U('home/index/validate',$args);//使用时注意将localhost修改为自己的域名
		$content = "尊敬的".$data['username'].":您好，感谢您注册。这是一封注册确认邮件。请点击以下链接完成确认：".$url."如果链接不能点击，请复制地址到浏览器，然后直接打开。";
		SendMail($data['email'],'账号注册验证邮件',$content);
	}
	/*
	 * 功能：验证注册账号
	 * 
	 * ******/	
	public function validate(){
		$url = curPageURL();
		preg_match("/\/u\/(.*)\/t\/(.*)\/p\/(.*)/i", $url, $matches);
		$where['username']=$matches[1];
		$data = M($matches[2])->where($where)->find();
		if($data['status']>0){
			$this->success('该账号已激活，请登录……',U('home/index/login'));
			exit;
		}else if(md5($data['password'].VALIDATE_STRING.'12520')==$matches[3]){
			if(M($matches[2])->where($where)->setField('status',1)){
				$this->success('验证成功，请登录……',U('home/index/login'));
				exit;
			};
		}
		$this->error('验证失败，请稍后手动验证……',U('home/index/index'));
		
		
	}	
	/*
	 * 功能：ajax验证用户名唯一
	 * 
	 * ******/
	public function checkName(){

		$where['username'] = I('username');
			$type = I('type',1);
		switch($type){
			case 1:
				$member = M('Member')->where($where)->find();
				empty($member)? exit('true'):exit('false');
				break;
			default:
				$craftsman = M('craftsman')->where($where)->find();
				empty($craftsman)? exit('true'):exit('false');
		}		
	}
	/*
	 * 功能：ajax验证邮箱唯一
	 * 
	 * ******/	
	public function checkEmail(){
		$where['email'] = I('email');
		$type = I('type',1);
		switch($type){
			case 1:
				$member = M('Member')->where($where)->find();
				empty($member)? exit('true'):exit('false');
				break;
			default:
				$craftsman = M('craftsman')->where($where)->find();
				empty($craftsman)? exit('true'):exit('false');

		}

	}
	/*
	 * 功能：增加登录后session信息保存
	 * 
	 * ******/	
    private function autoLogin($user){

        /* 记录登录SESSION和COOKIES */
        $auth = array(
            'uid'             => $user['memberid']?$user['memberid']:$user['craftsmanid'],
            'username'        => $user['username'],
        );
        session('user_auth', $auth);
        session('user_auth_sign', md5(implode('*_*',$auth)));

    }	
	
	
	public function forgetpassword()
	{
		$this->display();
	}
	
	public function doforgetpassword()
	{
		// to do 
	}
}