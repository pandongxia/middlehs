<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black" />
<link href="/1114/Public/css/style.css" rel="stylesheet" type="text/css" />
<link href="/1114/Public/css/common.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="/1114/Public/js/datetimepicker/jquery.datetimepicker.css"/>
<title>海伦服务</title>
</head>
<body>
<div class="container">
<!--头部-->
	<div class="header">
		<div class="w1200px">
			<h1 class="fl"><a href="#" title=""><img src="/1114/Public/img/logo.png" width="277" height="40" alt=""></a></h1>
			<div class="nav clearfix">
				<a href="#" title="首页" class="cur">首页</a><!--a href="#" title="">其它</a-->
			</div>
			<ul class="sitenav fr">
            <?php if(is_login()): ?><li><a href="#" title="用户名"><?php echo get_username();?></a><span></span></li>
				<li><a href="<?php echo U('home/member/index');?>" title="我的订单">我的订单</a><span></span></li>
				<li><a href="#" title="账号设置">账号设置</a><span></span>
						<!--div class="subnav"><a href="#">修改密码</a><a href="#">修改邮箱</a><a href="#">修改服务地址</a></div-->
					
				</li>
                <li><a href="<?php echo U('home/member/logout');?>">退出</a></li>
            <?php else: ?>
                <li><a href="<?php echo U('home/index/login');?>">登录</a><span></span></li>
          		<li><a href="<?php echo U('home/index/join');?>">注册</a></li><?php endif; ?>
			</ul>
			<div class="clr"></div>
		</div>
	</div>
<!--头部 END-->

<!--main-->
	<div class="main">
		<!--焦点图-->
		<div class="top_slide_wrap">
			<ul class="slide_box bxslider">
				<li>
					<a href="#"><img src="/1114/Public/img/banner1.jpg" alt=""></a>
					<div class="slide_info">
						<div class="slide_info_card">
							<a href="#">
								<div class="slide_info_card_text">
									<h2>诚信的服务</h2>
									<p>标题1描述</p>
									<p><strong>点击进入&gt;</strong></p>
								</div>
							</a>
							<div class="slide_info_card_bg"></div>
						</div>
					</div>
				</li>
				<li>
					<a href="#"><img src="/1114/Public/img/banner2.jpg" alt="" title="城市预测"></a>
					<div class="slide_info">
						<div class="slide_info_card">
							<a href="#">
								<div class="slide_info_card_text">
									<h2>专业的服务</h2>
									<p>标题2描述</p>
									<p><strong>点击进入&gt;</strong></p>
								</div>
							</a>
							<div class="slide_info_card_bg"></div>
						</div>
					</div>
				</li>
				<li>
					<a href="#"><img src="/1114/Public/img/banner3.jpg" alt=""></a>
					<div class="slide_info">
						<div class="slide_info_card">
							<a href="#">
								<div class="slide_info_card_text">
									<h2>优雅的服务</h2>
									<p>标题3描述</p>
									<p><strong>点击进入&gt;</strong></p>
								</div>
							</a>
							<div class="slide_info_card_bg"></div>
						</div>
					</div>
				</li>
			</ul>
			
			<div class="op_btns clearfix">
				<a href="#" class="op_btn op_prev"><span></span></a>
				<a href="#" class="op_btn op_next"><span></span></a>
			</div>
		</div>
		<!--焦点图 END-->

		<div class="notice-bg">
			<div class="w1200px">
				<div class="notice">
					<span></span>
					<a href="#" title=""><i>[11-13]</i>网站处于测试阶段，请勿使用</a>
					<a href="#" title=""><i>[11-13]</i>预计于2016-1-1开始使用，敬请期待</a>
					<a href="#" title=""><i>[11-13]</i>网站处于测试阶段，请勿使用</a>
					<a href="#" title="更多" class="more">更多&gt;&gt;</a>
				</div>
			</div>
		</div>

		<!--预约服务-->
		<div class="w1200px">
			<div class="lm-tit mt20"><img src="/1114/Public/img/lm-tit.gif" alt=""><strong>预约服务</strong></div>
			<ul class="service-list">
             	<?php if(is_array($service)): $k = 0; $__LIST__ = $service;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><li>
                	<div class="service-img">
						<div class="check">
							<input type="checkbox" class="icheck" value="<?php echo ($vo["serviceid"]); ?>">预约
						</div>
						<img src="/1114/Public/img/<?php echo ($vo["picture"]); ?>" width="260" height="260" alt="">
						<div class="trans">
							<div class="service-title ml5 fl"><?php echo ($vo["servicename"]); ?></div>
							<div class="price mr5 fr">价格：约<span>￥<?php echo ($vo["price"]); ?></span></div>
						</div>
					</div>
					<div class="timer">
						期望服务时间&nbsp;:&nbsp;<input type="text" value="<?php echo ($currenttime); ?>" class="datetimepicker"/>
					</div>
                </li><?php endforeach; endif; else: echo "" ;endif; ?>				
				<div class="clr"></div>
				<div class="submit-btn"><input type="submit" value=""></div>
			</ul>
		</div>
		<!--预约服务 END-->
	</div>
<!--main END-->

<!--footer-->
	<!--div class="footer">
    	<HR style="FILTER: alpha(opacity=100,finishopacity=0,style=3)" width="100%" color=#919191 SIZE=1>
<div class="footer" style=text-align:center;padding-bottom:10px;">Copyright &copy; 2015-2016 www.helenservice.com</div>
    </div-->
    
    <div class="footer mt20">
		<div class="w1200px">
			<div class="footer-nav">
            	<a href="#" title="">关于我们</a>
                <span>|</span><a href="#" title="">联系我们</a>
                <span>|</span><a href="#" title="">广告服务</a>
                <span>|</span><a href="#" title="">法律声明</a>
                <span>|</span><a href="#" title="">投诉举报</a>
                <span>|</span><a href="#" title="">意见反馈</a>
            </div>
			<!--p>地址：中国江苏连云港南街29号 &nbsp;&nbsp; 联系电话：15228881427</p-->
			<p>Copyright © 2015 helenservice.com, All Rights Reserved - 苏ICP备15054368号</p>
		</div>
	</div>
<!--footer END-->
</div>
</body>
<script type="text/javascript" src="/1114/Public/js/jquery-2.1.4.min.js"></script>
<script type="text/javascript" src="/1114/Public/js/mousemove.js"></script>
<script type="text/javascript" src="/1114/Public/js/focus.js"></script><!--焦点图-->
<script src="/1114/Public/js/datetimepicker/jquery.datetimepicker.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  $('.datetimepicker').datetimepicker({lang:'ch',minDate:'-1970/01/01',maxDate:'+1970/03/01'});
});

(function(){
	$(".bxslider").bxSlider({
		auto:true,
		prevSelector:$(".top_slide_wrap .op_prev")[0],nextSelector:$(".top_slide_wrap .op_next")[0]
	});
})();
</script>
</html>