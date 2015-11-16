<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html;charset=utf-8">
<meta name="keywords" content="家庭清洁,马桶维修,管道疏通"></meta>
<meta name="description" content="海伦服务集各种家庭服务于一身，给消费者提供更加便利和快捷的生活方式。""></meta>
<title>海伦服务</title>
<Link href="/demo/Public/css/main.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="/demo/Public/js/jquery.min.js"></script>
<script src="/demo/Public/js/PCASClass.js"></script>
<script>
function formSubmit()
{
  var realname = $("#realname").val();
  var gender = $("#gender").val();
  var idcard = $("#idcard").val();
  var tel = $("#tel").val();
  var province = $("#province").val();
  var city = $("#city").val();
  var area = $("#area").val();
  var skill = $(".skill").val();
  $.ajax({
    	url:"<?php echo U('home/member/craftsmanship');?>",
        type:"post",
        data:{realname:realname,gender:gender,tel:tel,idcard:idcard,province:province,city:city,area:area,skill:skill},
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
<div class="mainpage">
    <div class="welcome">
    <div class="welcome_in"><b>&nbsp;&nbsp;欢迎光临海伦服务</b></div>
    <div class="welcome_login">
        <?php if(($mid) > "0"): ?><a href=""><?php echo ($username); ?></a>
            <a href="<?php echo U('home/member/Logout');?>" target="_self">退出</a>     
        <?php else: ?>
            <a href="<?php echo U('home/index/Login');?>">登录</a>
            <a href="<?php echo U('home/index/Join');?>" target="_self">注册</a><?php endif; ?>
        <a href="" target="_blank">帮助</a>&nbsp;&nbsp;
    </div>
</div>	
<div class="logo">
    <img src="/demo/Public/img/logo.jpg" alt="helenservice"/>
</div>
    
	<div class="order_navagate">首页 &nbsp;&nbsp;&nbsp; 技能注册</div>
    
	<div>
    信息登记
    <br />
    <form name="craftsmanship_register" id="myForm">
    真实姓名<input type="text" name="realname" id="realname" /><br />
    性别<input type="text" name="gender" id="gender" /><br />
    身份证号<input type="text" name="idcard" id="idcard" /><br />   
    联系电话<input type="text" name="tel" id="tel" /><br />
    可以服务区域<select name="province" id="province"></select><select name="city" id="city"></select><select name="area" id="area"></select><br />
    <?php if(is_array($craftsmanships)): foreach($craftsmanships as $k=>$vofirst): if(is_array($vofirst)): foreach($vofirst as $key=>$vo): ?><div class="skillname"><?php echo ($vo["name"]); ?></div>
            <div class="skill"><?php echo ($vo["craftsmanshipid"]); ?></div><?php endforeach; endif; endforeach; endif; ?>
    <input type="button" name="submit" onclick="formSubmit()" value="提交">
    </form>
    </div>
    
	<div class="footer">Copyright &copy; 2015-2016 www.helenservice.com</div>
</div>
<script>
    new PCAS("province","city","area","江苏省","南京市","江宁区");
</script>
</body>
</html>