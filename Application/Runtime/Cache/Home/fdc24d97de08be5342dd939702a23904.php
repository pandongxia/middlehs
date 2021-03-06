<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>我的订单</title>
<link href="/hs112/Public/jBox/Source/jBox.css" rel="stylesheet">  
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
                    <li><a href="<?php echo U('home/index/index');?>" class="">首页</a></li> 
                </ul>
                <ul class="nav navbar-nav navbar-right">
                <?php if(is_login()): ?><li class=""><a href="#"><?php echo get_username();?></a></li>
                    <li class=""><a href="http://bootsnipp.com/resources" class="animate">账号设置</a></li>                    
                    <li class=""><a href="<?php echo U('home/member/logout');?>">退出</a></li>
                    <?php else: ?>
                    	<li class="animate"><a href="<?php echo U('home/index/Login');?>" target="_self">登录</a></li>
                        <li class="animate"><a href="<?php echo U('home/index/Join');?>" target="_self">注册</a></li><?php endif; ?>
                </ul>
            </div> <!--END navbar-collapse-->
            </div>  
            </nav>
            <?php if($service_num == 0): ?><h4>没有未处理的订单</h4>
            <?php else: ?>
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th>
							#
						</th>
						<th>
							服务名称
						</th>
						<th>
							期望日期
						</th>
						<th>
							状态
						</th>
					</tr>
				</thead>
				<tbody>
                 <?php if(is_array($booked_service)): foreach($booked_service as $k=>$vo): ?><tr>
						<td><?php echo ($k+1); ?></td>
						<td><?php echo ($vo["servicename"]); ?></td>
						<td><?php echo ($vo["expecteddate"]); ?></td>                        
						<td>       
							<?php if($vo["status"] == 1): ?>暂时无工匠接单<?php else: ?>工匠已接单，等待服务<?php endif; ?>                       
                        </td>
                        <!--td><button class="btn btn-primary remove-ori" data-user="<?php echo ($vo["id"]); ?>_<?php echo ($vo["memberid"]); ?>" data-toggle="modal" data-target="#CancelThisOrderModal">删除</button></td-->
                        <td><button data-user="<?php echo ($vo["id"]); ?>_<?php echo ($vo["memberid"]); ?>" onclick="showDeletePop();">删除</button></td>
					</tr><?php endforeach; endif; ?>					
				</tbody>
			</table><?php endif; ?>
            <h4>完成的订单</h4>
            <div>
                <?php if($serviced_num != 0): ?><table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>服务名称</th>
                            <th>期望日期</th>
                            <th>完成日期</th>
                            <th>工匠编号</th>
                            <th>评分</th>
                            <th>评价</th>
                        </tr>
                    </thead>
                    <tbody>
                     <?php if(is_array($completed_service)): foreach($completed_service as $k=>$vo): ?><tr>
                            <td><?php echo ($k+1); ?></td>
                            <td><?php echo ($vo["servicename"]); ?></td>
                            <td><?php echo ($vo["expecteddate"]); ?></td>                        
                            <td><?php echo ($vo["finishdate"]); ?></td>
                            <td><?php echo ($vo["craftsmanid"]); ?></td>
                            <!-- 如果iscommented字段为1，显示评价内容，不允许二次评价-->
                            <?php if($vo["iscommented"] == 0): ?><td><select id="comment-score" name="comment-score">
                                  <option value ="10">敬业</option>
                                  <option value ="0">服务态度差、服务技能差</option>
                                  <option value="1">服务态度差</option>
                                  <option value="2">服务技能差</option>
                                    <option value ="3">服务态度一般</option>
                                  <option value ="4">服务技能一般</option>
                                  <option value="5">态度一般、技能还行</option>
                                  <option value="6">态度很好、技能一般</option>
                                    <option value ="7">态度很好、技能很好</option>
                                  <option value ="8">热情、技能好</option>
                                  <option value="9">专业</option>  
                                </select></td>
                            <td><input name="comment" type="text" value="填写您的客观评价" /></td>
                            <td><button comment-user="<?php echo ($vo["id"]); ?>-<?php echo ($vo["craftsmanid"]); ?>" class="btn btn-primary comment-button">提交评价</button></td>
                            <?php else: ?>
                            <td><?php echo ($vo["score"]); ?></td>
                            <td><?php echo ($vo["comment"]); ?></td><?php endif; ?>
                        </tr><?php endforeach; endif; ?>					
                    </tbody>
                </table><?php endif; ?>
            </div>
		</div>
        
        <!-- 模态框(Modal) -->
        <!--div class="modal fade" id="CancelThisOrderModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                     </div>
                     <div class="modal-footer">
                        <button id="CancelThisService" data-user="0" type="button" class="btn btn-primary remove-submit">
                           取消订单
                        </button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal">
                           不取消
                        </button>
                     </div>
                  </div>
              </div>
        </div><!-- /.modal -->
        
        <!-- jBox Modal -->
        
	</div>
</div>
<script src="/hs112/Public/js/jquery-2.1.4.min.js"></script>    
<script src="/hs112/Public/jBox/Source/jBox.min.js"></script>
<script>
$(document).ready(function(){
	$('body').delegate('.remove-ori','click', function() {
		var orderid = $(this).attr("data-user");
		$(".remove-submit").attr("data-user",orderid);
	});
	$(".remove-submit").click(function(){
		var id = $(this).attr("data-user");
		$.post("<?php echo U('home/Member/delOrder');?>", {"id":id}, function(data){
			$("#CancelThisOrderModal").modal('hide');
				if (data.status == 1)
			    {
					alert('删除成功！');
					setTimeout(function(){
						window.location.replace("<?php echo U('home/Member/index');?>");
					}, 500 );
	
				}else
			    {
			          	alert('删除失败！');
			    }
		},"json");
	
	}); 

	$(".comment-button").click(function(){
		var score = $("#comment-score").find("option:selected").val(); 
		var id = $(this).attr('comment-user')
		 var comment = $("input[name='comment']").val();
		 $.post("<?php echo U('home/Member/saveComment');?>", {"id":id,"score":score,"comment":comment}, function(data){
			 	alert(data.info);
				if (data.status == 1){
					window.location.reload();
				}
			},"json");

		});	
});

var submit = function(v, h, f) {
	if (v == true)
		var id = $(this).attr("data-user");
		$.post("<?php echo U('home/Member/delOrder');?>", {"id":id}, function(data){
			//$("#CancelThisOrderModal").modal('hide');
				if (data.status == 1)
			    {
					alert('删除成功！');
					setTimeout(function(){
						window.location.replace("<?php echo U('home/Member/index');?>");
					}, 500 );
	
				}else
			    {
			          	alert('删除失败！');
			    }
		},"json");
		
	return true;
};

function showDeletePop(type,url) {
	$.jBox.confirm("您确定要删除这个订单？", "删除订单",  submit, { buttons: {'确定':true,'取消':false}});
}
</script>    
        
</body>
</html>