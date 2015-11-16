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
    <link rel="stylesheet" href="/demo/Public/Font-Awesome/css/font-awesome.min.css">        
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
                	<?php if(($cid) > "0"): ?><li class=" dropdown"><a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user fa-fw"></i>&nbsp;<?php echo ($username); ?></a>
                            <ul class="dropdown-menu">
                                <li class=""><a href="<?php echo U('home/member/index');?>" class="animate"><i class="fa fa-edit fa-fw"></i>&nbsp; 我的技能</a></li>
                                <li class=""><a href="http://bootsnipp.com/resources" class="animate"><i class="fa fa-user fa-fw"></i>&nbsp; 修改密码</a></li> 
                            </ul>
                    </li>
                    <li class=""><a href="<?php echo U('home/member/logout');?>"><i class="fa fa-sign-out fa-fw"></i>&nbsp; 退出</a></li>
                    <?php else: ?>
                    	<li class="animate"><a href="<?php echo U('home/index/Login');?>" target="_self"><i class="fa fa-sign-in fa-fw"></i>&nbsp; 登录</a></li>
                      <li class="animate"><a href="<?php echo U('home/index/Join');?>" target="_self">注册</a></li><?php endif; ?>
                </ul>
            </div> <!--END navbar-collapse-->
            </div>  
            </nav>
            <div>
            	<h3><span class="label label-danger">注意：请如实填写您的个人信息，我们会进行仔细核实。 如发现虚假信息，立即删除账号！！！</span><h3>
            </div>
            <div><!--start check in personal info-->
            	<form id="regform" action="<?php echo U('home/craftsman/checkininfo');?>" method="post">
            	<div class="col-lg-6">
                    <div class="form-group">
                        <label>真实姓名</label>
                        <div class="input-group"> <span class="input-group-addon"><i class="fa fa-user fa-fw"></i>&nbsp;</span>
                            <input type="text" class="form-control" name="realname" id="realname" placeholder="真实姓名" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>身份证号/护照号</label>
                        <div class="input-group"> <span class="input-group-addon"><i class="fa fa-credit-card fa-fw"></i>&nbsp;</span>
                            <input type="text" class="form-control" name="idcard" id="idcard" placeholder="身份证号/护照号" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>联系电话</label>
                        <div class="input-group"> <span class="input-group-addon"><i class="fa fa-mobile fa-fw"></i>&nbsp;</span>
                            <input type="text" class="form-control" name="tel" id="tel" placeholder="联系电话" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>服务区域</label>
                        <div class="input-group"> <span class="input-group-addon"><i class="fa fa-gear fa-fw"></i>&nbsp;</span>
                            <select name="province" id="province"></select><select name="city" id="city"></select><select name="area" id="area"></select>
                        </div>
                    </div>                    
                    <input type="submit" name="submit" id="submit" value="提交" class="btn btn-primary pull-right">
                </div>
        	</form>
            </div> <!--end check in personal info-->            
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
  $('#myTabContent input').iCheck({
	checkboxClass: 'icheckbox_square-green',
    radioClass: 'iradio_square-green',
    increaseArea: '20%' // optional
  });  
  
  $('.datetimepicker').datetimepicker();
  new PCAS("province","city","area","江苏省","南京市","江宁区"); 
  
  $('#serviceform').validate({ 		
		submitHandler: function(form){
				ordersubmit();
			},
		rules : {  
			customname : {  
				required : true  
			},  
			customphone : {  
				required : true  
			},  
			customarea : {  
				required : true  
			}  
		}, 
		messages : {  
			customname : {  
				required : "请输入您的姓名."  
			},  
			customphone : {  
				required : "请输入您的联系方式."  
			},  
			customarea : {  
				required : "请输入详细地址信息."  
			}  
		},   
		 
	});    

});

 

$('#serviceform input').keypress(function(e) {  
	if (e.which == 13) {  
		if ($('#serviceform').validate().form()) {  
			$('#serviceform').submit();  
		}  
		return false;  
	}  
});

function ordersubmit()
{
	var name = $("#fullname").val();
    var phone = $("#phone").val();
    var province = $("#province").val();
    var city = $("#city").val();
    var area = $("#area").val();
    var detailarea = $("#detailarea").val();
    var arraySrv = new Array();
    $("#order_service_content > li").each(function(j) {
		//if ($("[type='checkbox']").attr("checked",'true'))
		//if ($("[type='checkbox']").prop("checked", true))
		//alert("each list group"+j);
		var test = document.getElementById("square-checkbox-"+(j+1)).checked;
		if (test == true)
		//if ($("#input[name='square-checkbox']").prop("checked", true))
		{
			arraySrv.push(j+1);
			arraySrv.push($(this).find(".datetimepicker").val());
		}
    });
    
	//alert(arraySrv);
    $.ajax({
    	url:"<?php echo U('home/member/submit_order');?>",
        type:"post",
        data:{service:arraySrv,name:name,phone:phone,province:province,city:city,area:area,detailarea:detailarea},
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
  </body>
</html>