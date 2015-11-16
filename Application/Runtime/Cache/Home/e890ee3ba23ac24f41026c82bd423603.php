<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black" />
<link href="/1114/Public/css/style.css" rel="stylesheet" type="text/css" />
<link href="/1114/Public/css/common.css" rel="stylesheet" type="text/css" />
<link href="/1114/Public/css/plus.css" rel="stylesheet" type="text/css" />
<title>注册</title>
</head>
<body>
<div class="container">
<!--头部-->
	<div class="header">
		<div class="w1200px">
			<h1 class="logo fl"><a href="#" title=""><img src="/1114/Public/img/logo.png" width="277" height="40" alt=""></a></h1>
			<div class="nav clearfix">
				
			</div>			
			<div class="clr"></div>
		</div>
	</div>
<!--头部 END-->

<!--main-->
	<div class="main">
		<div class="w1200px">
			<div class="register">
				<h2>欢迎注册海伦服务！</h2>
				<ul class="t-formlist">
					<li><b>注册类型</b><i>*</i>
							<span class="t-input-2">
								<select class="t-select">									
                                    <option value="1" selected="selected">普通用户</option>
                       				<option value="2">工匠</option>
								</select>
							</span>
							<div class="clr"></div>
						</li>
					<li><b>用户名</b><i>*</i><input type="text" class="t-input-1" name="username" id="username" placeholder="用户名" required/></li>
					<li><b>邮箱</b><i>*</i><input type="text" class="t-input-1" name="email" id="email" placeholder="邮箱" required/></li>
					<li><b>密码</b><i>*</i><input type="password" class="t-input-1" name="password" id="password" placeholder="密码" required data-toggle="popover" title="密码强度" data-content="请输入密码..."/></li>
					<li><b>确认密码</b><i>*</i><input type="password" class="t-input-1" name="confirm" id="confirm" placeholder="确认密码" required/></li>
					<li style="margin-left:117px;"><input type="checkbox"> 我已同意并看过<a href="#" style="color:#39cce6;">《海伦服务使用协议》</a></li>
					<li class="t-submit"><input type="submit" value="立即注册" /></li>
				</ul>
			</div>
		</div>  
	</div>
<!--main END-->

<!--footer-->
	<div class="footer mt20" id="footer-n">
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
			<p>Copyright © 2015 helenservice.com, All Rights Reserved - <a href="http://www.miitbeian.gov.cn/">苏ICP备15054368号</a></p>
		</div>
	</div>
<!--footer END-->
</div>
</body>
<script src="/1114/Public/js/jquery-2.1.4.min.js"></script>
<script src="/1114/Public/js/jquery.validate.js"></script>        
<script>
$(document).ready(function(){

//minimum 8 characters
var bad = /(?=.{8,}).*/;
//Alpha Numeric plus minimum 8
var good = /^(?=\S*?[a-z])(?=\S*?[0-9])\S{8,}$/;
//Must contain at least one upper case letter, one lower case letter and (one number OR one special char).
var better = /^(?=\S*?[A-Z])(?=\S*?[a-z])((?=\S*?[0-9])|(?=\S*?[^\w\*]))\S{8,}$/;
//Must contain at least one upper case letter, one lower case letter and (one number AND one special char).
var best = /^(?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9])(?=\S*?[^\w\*])\S{8,}$/;

$('#password').on('keyup', function () {
    var password = $(this);
    var pass = password.val();
    var passLabel = $('[for="password"]');
    var stength = '弱';
    var pclass = 'danger';
    if (best.test(pass) == true) {
        stength = '高强度';
        pclass = 'success';
    } else if (better.test(pass) == true) {
        stength = '中等强度';
        pclass = 'warning';

    } else if (good.test(pass) == true) {
        stength = '一般强度';
        pclass = 'warning';
    } else if (bad.test(pass) == true) {
        stength = '差';
    } else {
        stength = '非常差';
    }

    var popover = password.attr('data-content', stength).data('bs.popover');
    popover.setContent();
    popover.$tip.addClass(popover.options.placement).removeClass('danger success info warning primary').addClass(pclass);

});

$('input[data-toggle="popover"]').popover({
    placement: 'top',
    trigger: 'focus'
});

$("#username").focus();
	jQuery.validator.addMethod("userFormat", function(value, element) {   
	    var user = /^[a-zA-Z][a-zA-Z0-9_]{5,17}$/;
	    return this.optional(element) || (user.test(value));
	}, "6~18个字符，可使用字母、数字、下划线，需以字母开头");		
	var validate = $("#regform").validate({
		submitHandler: function(form){
			form.submit();
		},
		
		rules:
		{
			username:{
				required:true,
				userFormat:true,
				remote: {
				    url: "<?php echo U('home/index/checkName');?>",     //后台处理程序
				    type: "post",               //数据发送方式
				    dataType: "json",
				    data: {      
					    type: function() {
				            return $("#select option:selected").val();
				        }
				    }
				}
			},
			email:{
				required:true,
				email:true,
				//remote:"<?php echo U('home/index/checkEmail');?>"
				remote: {
				    url: "<?php echo U('home/index/checkEmail');?>",     //后台处理程序
				    type: "post",               //数据发送方式
				    dataType: "json",
				    data: {      
					    type: function() {
				            return $("#select option:selected").val();
				        }
				    }
				}
			},
			password:{
				required:true,
				rangelength:[6,32]
			},
			confirm:{
				equalTo:"#password"
			}
		},
		
		messages:
		{
			username:{
				required:"必填",
				remote:'用户名已被占用 ！'
			},
			email:{
				required:"必填",
				email:"E-Mail格式不正确",
				remote:'邮箱已被占用 ！'
			},
			password:{
				required:"必填",
				rangelength:$.format("密码最小长度:{0}, 最大长度:{1}")
			},
			confirm: {
				required:"必填",
				equalTo:"两次密码输入不一致"
			}
		}
	});	
	$("#select").change(function(){
		$('#email').removeData("previousValue").valid(); 
		$('#username').removeData("previousValue").valid(); 
	
	});
})
</script>
</html>