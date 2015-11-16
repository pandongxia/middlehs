<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login</title>

    <meta name="description" content="Source code generated using layoutit.com">
    <meta name="author" content="LayoutIt!">
    <link href="/demo/Public/css/bootstrap.min.css" rel="stylesheet">  
    <link rel="stylesheet" href="/demo/Public/Font-Awesome/css/font-awesome.min.css"> 
  </head>
  <body> 
<div class="container">
<div  class="row">
    <form action="<?php echo U('home/index/doforgetpassword');?>" method="post">
    <div class="col-lg-6">
    	<div class="form-group">
                <label>用户类型</label>
                <div class="input-group"> <span class="input-group-addon"><i class="fa fa-sort fa-fw"></i>&nbsp; </span>
                	<select name="type" class="form-control" id="select">
                    	<option value="1" selected="selected">普通用户</option>
                        <option value="2">工匠</option>
                    </select>                    
                </div>
            </div>
        <div class="form-group">            
            <label>邮箱</label>
            <div class="input-group"> <span class="input-group-addon"><i class="fa fa-envelope fa-fw"></i>&nbsp; </span>
                <input type="text" class="form-control" name="email" id="email" placeholder="邮箱" required>
            </div>
        </div>               
            
        <input type="submit" name="submit" class="btn btn-default-outline btn-block" value="发送密码到邮箱">
    </div>
    </form>
</div>
</div>
</body>
</html>