<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login</title>

    <meta name="description" content="Source code generated using layoutit.com">
    <meta name="author" content="LayoutIt!">
    <link href="/hs112/Public/css/bootstrap.min.css" rel="stylesheet">  
    <link rel="stylesheet" href="/hs112/Public/Font-Awesome/css/font-awesome.min.css"> 
  </head>
  <body> 
<div class="container">
     <h3>登录---请选择正确的用户类型进行登录</h3>
    <hr>
    <div class="row">
    <form action="<?php echo U('home/index/dologin');?>" method="post">
        <div class="col-lg-6">
        	<div class="form-group">
                <label>用户类型</label>
                <div class="input-group"> <span class="input-group-addon"><i class="fa fa-sort fa-fw"></i>&nbsp; </span>
                	<select name="type" class="form-control">
                    	<option value="1" selected="selected">普通用户</option>
                        <option value="2">工匠</option>
                    </select>                    
                </div>
            </div>
            <div class="form-group">
                <label>用户名/邮箱</label>
                <div class="input-group"> <span class="input-group-addon"><i class="fa fa-user fa-fw"></i>&nbsp; </span>
                    <input type="text" class="form-control" name="username" id="Username" placeholder="用户名/邮箱" required>
                </div>
            </div>
            <div class="form-group">
                <label>密码</label>
                <div class="input-group"> <span class="input-group-addon"><i class="fa fa-lock fa-fw"></i>&nbsp; </span>
                    <input type="password" class="form-control" name="password" id="password" placeholder="密码" required>
                </div>
            </div>
            <input type="submit" name="submit" id="submit" value="提交" class="btn btn-primary pull-left">            
            <a href="<?php echo U('home/index/forgetpassword');?>" class="btn btn-primary pull-right">已有账号，忘记密码</a>
        </div>
    </form>       
    </div>     
</div>
<script src="/hs112/Public/js/jquery-2.1.4.min.js"></script>    
<script src="/hs112/Public/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/hs112/Public/js/sender.js?12221"></script>
<script type="text/javascript">
$("form").submit(function(){
	var self = $(this);
	$.post(self.attr("action"), self.serialize(), success, "json");
	return false;

	function success(data){
		//alert(data.join());exit;
		if(data.status){
			if(data.type==2){
				ws.send(JSON.stringify({"type":"login","id":data.id}));
			}
			setTimeout(function(){
				alert(data.info);
				window.location.href=data.url;
			}, 500 );
		} else {
			//alert('登录失败');
			setTimeout(function(){
				alert(data.info);
				window.location.href=data.url;
			}, 500 );
		}
	}
});
	





</script>
</body>
</html>