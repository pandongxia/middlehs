<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Register</title>

    <meta name="description" content="Source code generated using layoutit.com">
    <meta name="author" content="LayoutIt!">
    <link href="/demo/Public/css/bootstrap.min.css" rel="stylesheet">  
    <link rel="stylesheet" href="/demo/Public/css/font-awesome.min.css">
    <link rel="stylesheet" href="/demo/Public/css/register.css">  
  </head>
  <body> 
<div class="container">
     <h3>注册</h3>
    <hr>
    <div class="row">
    <form id="regform" action="<?php echo U('home/index/dojoin');?>" method="post">
        <div class="col-lg-6">
        	<div class="form-group">
                <label>用户类型</label>
                <div class="input-group"> <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
                	<select name="type" class="form-control" id="select">
                    	<option value="1" selected="selected">普通用户</option>
                        <option value="2">工匠</option>
                    </select>                    
                </div>
            </div>
            <div class="form-group">
                <label>用户名</label>
                <div class="input-group"> <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                    <input type="text" class="form-control" name=username id="username" placeholder="用户名">
                </div>
            </div>
            <div class="form-group">
                <label>邮箱</label>
                <div class="input-group"> <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                    <input type="email" class="form-control" name="email" id="email" placeholder="邮箱" required>
                </div>
            </div>
            <div class="form-group">
                <label>密码</label>
                <div class="input-group"> <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                    <input type="password" class="form-control" name="password" id="password" placeholder="密码" required data-toggle="popover" title="密码强度" data-content="请输入密码...">
                </div>
            </div>
            <div class="form-group">
                <label>确认密码</label>
                <div class="input-group"> <span class="input-group-addon"><span class="glyphicon glyphicon-resize-vertical"></span></span>
                    <input type="password" class="form-control" name="confirm" id="confirm" placeholder="确认密码" required>
                </div>
            </div>
            
            <input type="submit" name="submit" id="submit" value="提交" class="btn btn-primary pull-right">
        </div>
        </form>
    </div>
</div>
<script src="/demo/Public/js/jquery-2.1.4.min.js"></script>
<script src="/demo/Public/js/jquery.validate.js"></script>        
<script src="/demo/Public/js/bootstrap.min.js"></script>
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
/*$("#username").blur(
	function() {
		var username = $("#username").val();	
		if (username == null || username == undefined || username == '') {
				return false;
		}
		$.post("<?php echo U('home/index/checkName');?>", {'username' : username }, function(data) {
			if (data == 0) {
				//alert("用户名可用");
				//error['username'] = 0;
				//$('#tooltip1').attr('class','tooltip-info visible-inline success');
			} else {
				//error['username'] = 1;
				//$('#tooltip1').attr('class','tooltip-info visible-inline error');
				//$('#mess1').html(data);
				alert("用户名已存在");
			}
		})
		return false;
	});*/
	jQuery.validator.addMethod("userFormat", function(value, element) {   
	    var user = /^[a-zA-Z][a-zA-Z0-9_]{6,18}$/;
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
				/*remote: {
				    url: "<?php echo U('home/index/checkName');?>",     //后台处理程序
				    type: "post",               //数据发送方式
				    dataType: "json",           //接受数据格式   
				    data: {      
					    type: function() {
				            return $("#select option:selected").val();
				        }
				    }
				}*/
				remote: "<?php echo U('home/index/checkName');?>"
			},
			email:{
				required:true,
				email:true,
				remote:"<?php echo U('home/index/checkEmail');?>"
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

})
</script>
</body>
</html>