<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>工匠信息登记</title>
    <meta name="description" content="Source code generated using layoutit.com">
    <meta name="author" content="LayoutIt!">

    <link href="/demo/Public/css/bootstrap.min.css" rel="stylesheet">
    <link href="/demo/Public/css/navigation.css" rel="stylesheet"> 
    <link rel="stylesheet" href="/demo/Public/css/font-awesome.min.css">
    
    <script src="/demo/Public/js/PCASClass.js"></script>
<script>
function formSubmit()
{
  var realname = $("#realname").val();
  var idcard = $("#idcard").val();
  var tel = $("#tel").val();
  var province = $("#province").val();
  var city = $("#city").val();
  var area = $("#area").val();
  var skill = $(".skill").val();
  $.ajax({
    	url:"<?php echo U('home/member/craftsmanshipregister');?>",
        type:"post",
        data:{realname:realname,tel:tel,idcard:idcard,province:province,city:city,area:area,skill:skill},
        dataType:"json",
        success:function(res)
        {
        	if (res.status == 1)
            {
            	alert(res.msg);
                window.location.replace("<?php echo U('home/member/index');?>");
            }
            else
            {
            	alert('submit failed');
            }
        }
    });
}
</script> 
  </head>

<body>

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
            <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">HelenService</a>            
            </div> <!--END navbar-header-->
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li><a href="<?php echo U('home/index/index');?>" class="">首页</a></li>                      
                        
                        <li class=" down"><a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">预留 <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Change Time Entry</a></li>
                                <li><a href="#">Report</a></li>
                            </ul>
                        </li>
                        
                </ul>
                <ul class="nav navbar-nav navbar-right">
                	<?php if(($mid) > "0"): ?><li class=" dropdown"><a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo ($username); ?>  <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li class=""><a href="<?php echo U('home/member/index');?>" class="animate">我的订单<span class="pull-right glyphicon glyphicon-pencil"></span></a></li>
                                <li class=""><a href="http://bootsnipp.com/resources" class="animate">修改密码<span class="pull-right glyphicon glyphicon-align-justify"></span></a></li> 
                            </ul>
                    </li>
                    <?php if(($craftsmanshipid) > "0"): ?><li class=" dropdown"><a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">工匠中心  <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li class=""><a href="http://bootsnipp.com/blog" class="animate">可接订单<span class="pull-right glyphicon glyphicon-pencil"></span></a></li>
                                <li class=""><a href="http://bootsnipp.com/resources" class="animate">已服务订单<span class="pull-right glyphicon glyphicon-align-justify"></span></a></li> 
                            </ul>
                    </li><?php endif; ?>
                    <li class=""><a href="<?php echo U('home/member/logout');?>">退出</a></li>
                    <?php else: ?>
                      <li class="animate"><a href="<?php echo U('home/index/Join');?>" target="_self">注册</a></li>          
                      <li class="animate"><a href="<?php echo U('home/index/Login');?>" target="_self">登录</a></li><?php endif; ?>
                </ul>
            </div> <!--END navbar-collapse-->
            </div>  
            </nav>     
    
    
    <div class="row">
    <form id="regform">
        <div class="col-lg-6">
            <div class="form-group">
                <label>真实姓名</label>
                <div class="input-group"> <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                    <input type="text" class="form-control" name="realname" id="realname" placeholder="Requested Name" required>
                </div>
            </div>
            <div class="form-group">
                <label>身份证号</label>
                <div class="input-group"> <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                    <input type="text" class="form-control" name="idcard" id="idcard" placeholder="Requested Idcard" required>
                </div>
            </div>
            <div class="form-group">
                <label>电话</label>
                <div class="input-group"> <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                    <input type="text" class="form-control" name="tel" id="tel" placeholder="tel" required>
                </div>
            </div>
            <div class="form-group">
                <label>服务区域</label>
                <div class="input-group"> <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                    <select name="province" id="province"></select><select name="city" id="city"></select><select name="area" id="area"></select>
                </div>
            </div>
            <div class="form-group">
            <label>技能</label>
            <?php if(is_array($craftsmanships)): foreach($craftsmanships as $k=>$vofirst): if(is_array($vofirst)): foreach($vofirst as $key=>$vo): ?><div class="skillname"><?php echo ($vo["name"]); ?></div>
                    <div class="skill"><?php echo ($vo["craftsmanshipid"]); ?></div><?php endforeach; endif; endforeach; endif; ?>
            </div>             
            <input type="submit" name="submit" id="submit" value="Submit" onclick="formSubmit()" class="btn btn-primary pull-right">
        </div>
        </form>
    </div>
    
    
    
		</div>
	</div>
</div>
    <script src="/demo/Public/js/jquery-2.1.4.min.js"></script>    
    <script src="/demo/Public/js/bootstrap.min.js"></script>
    <script>
    	 new PCAS("province","city","area","江苏省","南京市","江宁区");
    </script>
    
</body>
</html>