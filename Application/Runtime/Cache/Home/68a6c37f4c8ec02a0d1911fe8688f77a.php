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
                <a class="navbar-brand" href="#" style="color:#1F47AD;">HelenService</a>            
            </div> <!--END navbar-header-->
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li><a href="<?php echo U('home/craftsman/index');?>" class=""><i class="fa fa-home fa-fw"></i>&nbsp;首页</a></li>  
                </ul>
                <ul class="nav navbar-nav navbar-right">
                	<?php if(is_login()): ?><!--li class=""><a href='javascript:void(0)'><i class="fa fa-bell fa-fw"></i>&nbsp;有单可抢</a></li--> 
                    <li class=" dropdown"><a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user fa-fw"></i>&nbsp;<?php echo get_username();?></a>
                            <ul class="dropdown-menu">
                                <li class=""><a href="<?php echo U('home/craftsman/modify_tech');?>" class="animate">我的技能<span class="pull-right glyphicon glyphicon-pencil"></span></a></li>
                                <li class=""><a href="http://bootsnipp.com/resources" class="animate">修改密码<span class="pull-right glyphicon glyphicon-wrench"></span></a></li> 
                            </ul>
                    </li>
                    <li class=""><a href="<?php echo U('home/member/logout');?>"><i class="fa fa-sign-out fa-fw"></i>&nbsp; 退出</a></li>
                    <?php else: ?>
                      <li class="animate"><a href="<?php echo U('home/index/Join');?>" target="_self">注册</a></li>          
                      <li class="animate"><a href="<?php echo U('home/index/Login');?>" target="_self">登录</a></li><?php endif; ?>
                </ul>
            </div> <!--END navbar-collapse-->
            </div>  
            </nav>
            <div><!--start rob order list-->
            	<h3>可以抢的订单</h3>
            	<ul class="list-group" id="ul_container">
                    <li class="list-group-item" id="title">
                        <ul class="list-inline" style="padding-left:3%">
                            <li style="width:5%">序号</li>
                            <li style="width:20%">名称</li>
                            <li style="width:10%">地址</li>
                            <li style="width:10%">价格</li>
                            <li style="width:20%">时间</li>
                            <li style="width:20%">抢单</li>
                        </ul>
                    </li>
                      <?php if(is_array($service1)): $k = 0; $__LIST__ = $service1;if( count($__LIST__)==0 ) : echo "无相关订单" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><li class="list-group-item sl<?php echo ($vo["id"]); ?>">
                        <ul class="list-inline" style="padding-left:3%">
                            <li style="width:5%"><?php echo ($k); ?></li>
                            <li style="width:20%"><?php echo ($vo["servicename"]); ?></li>
                            <li style="width:10%"><?php echo ($vo["address"]); ?></li>
                            <li style="width:10%"><?php echo ($vo["price"]); ?></li>
                            <li style="width:20%"><?php echo (date("Y-m-d H:i:s",$vo["createdate"])); ?></li>
                            <li style="width:20%"><button class="btn btn-primary order-ori" data-user="<?php echo ($vo["id"]); ?>" data-toggle="modal" data-target="#RobOrderModal">抢单</button></li>
                        </ul>
                    </li><?php endforeach; endif; else: echo "无相关订单" ;endif; ?>                    
                 </ul>
            </div> <!--end rob order list-->
            <!-- 模态框(Modal) -->
            <div class="modal fade" id="RobOrderModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                      <div class="modal-content">
                         <div class="modal-header">
                            <button type="button" class="close" 
                               data-dismiss="modal" aria-hidden="true">
                                  &times;
                            </button>
                            <h4 class="modal-title" id="myModalLabel">
                               你确定要抢此订单吗？                           
                            </h4>
                         </div>
                         <div class="modal-body">
                            <div style="font-weight:bold">如果抢单后不能进行服务，将影响你的诚信度。<br />每个人的诚信度总分10分，如果诚信度为0分，你将不能进行抢单。 此值当月有效，此分值每个月的一号重新调整为10分。</div>
                            <div>
                                具体措施：
                                <ul class="list-group">
                                    <li class="list-group-item">1. 如果在预约服务12小时外取消服务，将减少你的诚信度2分</li>
                                    <li class="list-group-item">2. 如果在预约服务12小时内取消服务，将减少你的诚信度5分</li>
                                </ul>                     
                            </div>
                         </div>
                         <div class="modal-footer">
                            <button type="button" data-user="0" class="btn btn-primary grab-order">
                               抢单
                            </button>
                            <button type="button" class="btn btn-primary" data-dismiss="modal">
                               不抢
                            </button>
                         </div>
                      </div><!-- /.modal-content -->
                  </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
            
            
            <div><!--start servicing order list-->
            <h3>正在服务的订单</h3>
            	<ul class="list-group">
                    <li class="list-group-item">
                        <ul class="list-inline" style="padding-left:3%">
                            <li style="width:5%">序号</li>
                            <li style="width:20%">名称</li>
                            <li style="width:10%">地址</li>
                            <li style="width:10%">价格</li>
                            <li style="width:20%">时间</li>
                            <li style="width:10%">取消订单</li>                            
                            <li style="width:10%">完成订单</li>
                        </ul>
                    </li>
                      <?php if(is_array($service2)): $k = 0; $__LIST__ = $service2;if( count($__LIST__)==0 ) : echo "无相关订单" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><li class="list-group-item">
                        <ul class="list-inline" style="padding-left:3%">
                            <li style="width:5%"><?php echo ($k); ?></li>
                            <li style="width:20%"><?php echo ($vo["servicename"]); ?></li>
                            <li style="width:10%"><?php echo ($vo["address"]); ?></li>
                            <li style="width:10%"><?php echo ($vo["price"]); ?></li>
                            <li style="width:20%"><?php echo (date("Y-m-d H:i:s",$vo["createdate"])); ?></li>
                            <li style="width:10%"><button class="btn btn-danger finish-ori" data-user="<?php echo ($vo["id"]); ?>" data-toggle="modal" data-target="#CancelOrderModal">取消订单</button></li>                            
                            <li style="width:10%"><button class="btn btn-success finish-order" data-user="<?php echo ($vo["id"]); ?>" >完成</button></li>
     					</ul>
                    </li><?php endforeach; endif; else: echo "无相关订单" ;endif; ?>   
                 </ul>
            </div><!--end servicing order list-->
            
            <!-- 模态框(Modal) -->
            <div class="modal fade" id="CancelOrderModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                      <div class="modal-content">
                         <div class="modal-header">
                            <button type="button" class="close" 
                               data-dismiss="modal" aria-hidden="true">
                                  &times;
                            </button>
                            <h4 class="modal-title" id="myModalLabel">
                               你确定要取消订单吗？                           
                            </h4>
                         </div>
                         <div class="modal-body">
                            <div style="font-weight:bold">取消订单，将影响你的诚信度。<br />每个人的诚信度总分10分，如果诚信度为0分，你将不能进行抢单。 此值当月有效，此分值每个月的一号重新调整为10分。</div>
                            <div>
                                具体措施：
                                <ul class="list-group">
                                    <li class="list-group-item">1. 如果在预约服务12小时外取消服务，将减少你的诚信度2分</li>
                                    <li class="list-group-item">2. 如果在预约服务12小时内取消服务，将减少你的诚信度5分</li>
                                </ul>                     
                            </div>
                         </div>
                         <div class="modal-footer">
                            <button type="button" class="btn btn-primary finish-remove" data-user="0">
                               取消订单
                            </button>
                            <button type="button" class="btn btn-primary" data-dismiss="modal">
                               不取消
                            </button>
                         </div>
                      </div><!-- /.modal-content -->
                  </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
            
            <div><!--start serviced order list-->
            <h3>一个月内服务的订单</h3>
            	<ul class="list-group">
                    <li class="list-group-item">
                        <ul class="list-inline" style="padding-left:3%">
                            <li style="width:5%">序号</li>
                            <li style="width:20%">服务名称</li>
                            <li style="width:10%">说明</li>
                            <li style="width:10%">价格</li>
                            <li style="width:20%">期望服务时间</li>
                            <li style="width:20%">服务结束时间</li>
                        </ul>
                    </li>
                    <?php if(is_array($service3)): $k = 0; $__LIST__ = $service3;if( count($__LIST__)==0 ) : echo "无相关订单" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><li class="list-group-item">
                        <ul class="list-inline" style="padding-left:3%">
                            <li style="width:5%"><?php echo ($k); ?></li>
                            <li style="width:20%"><?php echo ($vo["servicename"]); ?></li>
                            <li style="width:10%"><?php echo ($vo["address"]); ?></li>
                            <li style="width:10%"><?php echo ($vo["price"]); ?></li> 
                            <li style="width:20%"><?php echo ($vo["expecteddate"]); ?></li>
                            <li style="width:20%"><?php echo ($vo["finishdate"]); ?></li>  
     					</ul>
                    </li><?php endforeach; endif; else: echo "无相关订单" ;endif; ?>                       
                 </ul>
            </div><!--end serviced order list-->
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
	<script type="text/javascript" src="/demo/Public/js/sender.js?4544"></script>
    <script>
$(document).ready(function(){
	//取消订单
/*$("#ul_container").click(function(){
	var obj = $("#ul_container").children("li").not("#title");
	obj.each(function(index){
		$(this).find("ul").children("li:first-child").text(index);

	});
	});*/
	
  $('#myTabContent input').iCheck({
	checkboxClass: 'icheckbox_square-green',
    radioClass: 'iradio_square-green',
    increaseArea: '20%' // optional
  });  

  //$('.datetimepicker').datetimepicker();
  //new PCAS("province","city","area","江苏省","南京市","江宁区"); 

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
	//抢单
	$('body').delegate('.order-ori','click', function() {
		var orderid = $(this).attr("data-user");
		$(".grab-order").attr("data-user",orderid);
    });
	$(".grab-order").click(function(){
		var id = $(this).attr("data-user");
		$.post("grabOrder", {"id":id}, function(data){
			$("#RobOrderModal").modal('hide');
			if(data.status==1){
				//
				if(data.type=='order'){
					ws.send(JSON.stringify({"type":data.type,"data":data.data}));
				}
				//				
				alert(data.info);
				window.location.reload();
			}else{
				alert(data.info);
			}
		},"json");

	}); 
	//取消订单
	$(".finish-ori").click(function(){
		var orderid = $(this).attr("data-user");
		$(".finish-remove").attr("data-user",orderid);
	});
	$(".finish-remove").click(function(){
		var id = $(this).attr("data-user");
		
		$.post("removeOrder", {"id":id}, function(res){
			$("#CancelOrderModal").modal('hide');
			var data = res.data;
			if(res.status==1){
				if(res.type=='order'){
					ws.send(JSON.stringify({"type":res.type,"data":data}));
				}
				alert(res.info);
				window.location.reload();
			}else{
				alert(res.info);
			}
		},"json");

	}); 
	//完成按钮
	$(".finish-order").click(function(){
		var orderid = $(this).attr("data-user");
		$(".grab-order").attr("data-user",orderid)
	});
	$(".finish-order").click(function(){
		var id = $(this).attr("data-user");
		$.post("finishOrder", {"id":id}, function(data){
			if(data.status==1){
				alert(data.info);
				window.location.reload();
			}else{
				alert(data.info);
			}
		},"json");

	}); 

});

function refresh_order(id){
	$.post("getOrder", {"id":id}, function(data){
		if(data.length<=0){return;}
		var html='';
		   html+=  ' <li class="list-group-item sl'+data['id']+'">';
	       html+=  '<ul class="list-inline" style="padding-left:3%">';
	       html+=  '<li style="width:5%"></li>';
	       html+=  '<li style="width:20%">'+data['servicename']+'</li>';
	       html+=  '<li style="width:10%">'+data['address']+'</li>';
	       html+=  ' <li style="width:10%">'+data['price']+'</li>';
	       html+=  ' <li style="width:20%">'+data['expecteddate']+'</li>';
	       html+=  '<li style="width:20%"><button class="btn btn-primary order-ori" data-user="'+data['id']+'" data-toggle="modal" data-target="#RobOrderModal">抢单</button></li>';
	       html+=  '</ul>';
	       html+=  '</li>';
	    $("#ul_container").append(html); 
	   	var obj = $("#ul_container").children("li").not("#title");
		obj.each(function(index){
			$(this).find("ul").children("li:first-child").text(index+1);
		});
		     
		}, "json");
}; 
function refresh_grab(id){
	$(".sl"+id).remove();
	var obj = $("#ul_container").children("li").not("#title");
	obj.each(function(index){
		$(this).find("ul").children("li:first-child").text(index+1);
	});
}; 

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
<div style="display:none;" id="neworder"></div><!-- 标识符，保留 -->
  </body>
</html>