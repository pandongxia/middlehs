<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HelenService</title>
    <meta name="description" content="Source code generated using layoutit.com">
    <meta name="author" content="LayoutIt!">

    <link href="/demo/Public/css/bootstrap.min.css" rel="stylesheet">
    <link href="/demo/Public/square/green.css" rel="stylesheet">  
    <link href="/demo/Public/css/navigation.css" rel="stylesheet">   
    <link rel="stylesheet" href="/demo/Public/css/font-awesome.min.css">        
    <link rel="stylesheet" href="/demo/Public/js/datetimepicker/jquery.datetimepicker.css"/>

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
                    <li><a href="<?php echo U('home/craftsman/index');?>" class="">首页</a></li>                      
                        
                        <li class=" down"><a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">预留 <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Change Time Entry</a></li>
                                <li><a href="#">Report</a></li>
                            </ul>
                        </li>
                        
                </ul>
                <ul class="nav navbar-nav navbar-right">
                	<?php if(($cid) > "0"): ?><li class=" dropdown"><a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo ($username); ?>  <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li class=""><a href="<?php echo U('home/member/index');?>" class="animate">我的技能<span class="pull-right glyphicon glyphicon-pencil"></span></a></li>
                                <li class=""><a href="http://bootsnipp.com/resources" class="animate">修改密码<span class="pull-right glyphicon glyphicon-align-justify"></span></a></li> 
                            </ul>
                    </li>
                    <li class=""><a href="<?php echo U('home/member/logout');?>">退出</a></li>
                    <?php else: ?>
                      <li class="animate"><a href="<?php echo U('home/index/Join');?>" target="_self">注册</a></li>          
                      <li class="animate"><a href="<?php echo U('home/index/Login');?>" target="_self">登录</a></li><?php endif; ?>
                </ul>
            </div> <!--END navbar-collapse-->
            </div>  
            </nav>
            <h3>当前技能列表</h3>
            <div>
            	<ul class="list-group">
                	<li class="list-group-item">
                    	<ul class="list-inline" style="padding-left:3%">
                        	<li style="width:5%">序号</li>
                            <li style="width:20%">技能</li>
                        </ul>
                    </li>
	            	<?php if(is_array($owner_data)): $k = 0; $__LIST__ = $owner_data;if( count($__LIST__)==0 ) : echo "你还没有技能！" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><li class="list-group-item">
	                    	<ul class="list-inline" style="padding-left:3%">
	                        	<li style="width:5%"><?php echo ($k); ?></li>
	                            <li style="width:20%"><?php echo ($vo["name"]); ?></li>
	                       		 <li style="width:70%"><button cid="<?php echo ($vo["craftsmanshipid"]); ?>">删除</button></li>
	                        </ul>
	                    </li><?php endforeach; endif; else: echo "你还没有技能！" ;endif; ?>                    
                </ul>
            </div>
            <h3>添加技能</h3>
            <div id="techlist"><!--start current tech list-->
            	<form name="craftsmancheckbox" method="post" action="<?php echo U('home/craftsman/addtech');?>">
                	<ul class="list-group">
                    	<li class="list-group-item">
                        	<ul class="list-inline" style="padding-left:3%">
                            	<li style="width:5%">序号</li>
                                <li style="width:20%">技能</li>
                                <li style="width:70%">说明</li>                                
                            </ul>
                        </li>                                    
                        <?php if(is_array($craftsman)): $k = 0; $__LIST__ = $craftsman;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><li class="list-group-item">
                            <ul class="list-inline" style="padding-left:3%">
                                <li style="width:5%"><?php echo ($k); ?></li>                           
                                <li style="width:20%">
                                    <input tabindex=<?php echo ($k); ?> type="checkbox" id="square-checkbox-<?php echo ($k+1); ?>" name="tech[]" value="<?php echo ($vo["craftsmanshipid"]); ?>" />
                                    <label for="square-checkbox-<?php echo ($k+1); ?>"><?php echo ($vo["name"]); ?></label>
                                </li>
                                <li style="width:70%"> 这个工作很好胜任</li>
                            </ul> 
                        </li><?php endforeach; endif; else: echo "" ;endif; ?>
                        <li class="list-group-item"><input type="submit" name="Submit" value="提交"></li>
                    </ul> 
                </form>
            </div> <!--end current tech list-->            
		</div>
	</div>	
	<div class="row">
		<div class="col-md-12">
        </div>
	</div>   
</div>

       
    <script src="/demo/Public/js/jquery-2.1.4.min.js"></script>
    <script src="/demo/Public/js/jquery.validate.js"></script>    
    <script src="/demo/Public/js/bootstrap.min.js"></script>
    <script src="/demo/Public/js/icheck.js?v=1.0.2"></script>    
    <script src="/demo/Public/js/datetimepicker/jquery.datetimepicker.js"></script>
	<script src="/demo/Public/js/PCASClass.js"></script>
    <script>
$(document).ready(function(){
  $('#techlist input').iCheck({
	checkboxClass: 'icheckbox_square-green',
    radioClass: 'iradio_square-green',
    increaseArea: '20%' // optional
  });  

  $("button").click(function(){
		$.ajax({
		  	url:"<?php echo U('home/craftsman/deltech');?>",
		      type:"post",
		      data:{id:$(this).attr('cid')},
		      dataType:"json",
		      success:function(res)
		      {
		      	if (res.status == 1)
		          {
		              window.location.replace("<?php echo U('home/craftsman/modify_tech');?>");
		          }
		          else
		          {
		          	alert('删除失败！');
		          }
		      }
		  });
	});


});
</script>
  </body>
</html>