<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta name="author" content="wangdong">
<title><?php echo C('SYSTEM_NAME');?></title>
<link rel='shortcut icon' href='/demo/Public/static/favicon.ico' />
<script type="text/javascript">var STATIC_URL = '/demo/Public/static',UPLOAD_ROOT = '/demo/Public/upload/';</script>
<script type="text/javascript" src="/demo/Public/static/js/jquery.min.js"></script>
<script type="text/javascript" src="/demo/Public/static/js/jquery.cookie.js"></script>
<script type="text/javascript" src="/demo/Public/static/js/jquery.json.min.js"></script>
<script type="text/javascript" src="/demo/Public/static/js/easyui/jquery.easyui.min.js"></script>
<script type="text/javascript" src="/demo/Public/static/js/easyui/locale/easyui-lang-zh_CN.js"></script>
<script type="text/javascript" src="/demo/Public/static/js/easyui/plugins/jquery.portal.js"></script>
<link rel="stylesheet" href="/demo/Public/static/js/croppic/croppic.css"/>
<script type="text/javascript" src="/demo/Public/static/js/croppic/croppic.min.js"></script>
<script type="text/javascript" src="/demo/Public/static/js/jquery.app.js"></script>
<link rel="stylesheet" type="text/css" href="/demo/Public/static/css/icons.css" />
<link rel="stylesheet" type="text/css" href="/demo/Public/static/js/easyui/themes/default/easyui.css" title="default" />
<link rel="stylesheet" type="text/css" href="/demo/Public/static/js/easyui/themes/gray/easyui.css" title="gray" />
<link rel="stylesheet" type="text/css" href="/demo/Public/static/js/easyui/themes/bootstrap/easyui.css" title="bootstrap" />
<link rel="stylesheet" type="text/css" href="/demo/Public/static/js/easyui/themes/metro/easyui.css" title="metro" />
<link rel="stylesheet" type="text/css" href="/demo/Public/static/css/admin/default.css" title="default" />
<link rel="stylesheet" type="text/css" href="/demo/Public/static/css/admin/gray.css" title="gray" />
<link rel="stylesheet" type="text/css" href="/demo/Public/static/css/admin/bootstrap.css" title="bootstrap" />
<link rel="stylesheet" type="text/css" href="/demo/Public/static/css/admin/metro.css" title="metro" />
<script type="text/javascript">
var theme = $.cookie('theme') || 'default'; //全局变量
$(document).ready(function(){
	$('link[rel*=style][title]').each(function(i){
		this.disabled = true;
		if (this.getAttribute('title') == theme) this.disabled = false;
	});
});
</script>
</head>
<body class="easyui-layout">

<!-- 头部 -->
<div id="toparea" data-options="region:'north',border:false,height:38">
	<div id="topmenu" class="easyui-panel" data-options="fit:true,border:false">
		<a class="logo"><?php echo C('SYSTEM_NAME');?></a>
		<ul class="nav">
			<?php if(is_array($menuList)): foreach($menuList as $key=>$menu): ?><li><a href="javascript:;" onclick="baseModule.getLeft(<?php echo ($menu["id"]); ?>,'<?php echo ($menu["name"]); ?>', this)"><?php echo ($menu["name"]); ?></a></li><?php endforeach; endif; ?>
		</ul>
		<ul class="nav-right">
			<li>
                <a href="javascript:;" class="easyui-linkbutton" data-options="plain:true,iconCls:'icons-other-house'" onclick="window.open('<?php echo U('/index');?>')">访问首页</a>
                <a href="javascript:;" class="easyui-linkbutton" data-options="plain:true,iconCls:'icons-arrow-arrow_out'" onclick="$(body).requestFullScreen()">全屏</a>
                <a href="javascript:;" class="easyui-splitbutton" data-options="menu:'#toparea-user-info-box',iconCls:'icons-user-user'"><?php echo ($userInfo["rolename"]); ?></a>
				<a href="javascript:;" class="easyui-splitbutton" data-options="menu:'#toparea-help-box',iconCls:'icons-other-help'">帮助</a>
				
				<div id="toparea-user-info-box">
					<div><?php echo ($userInfo["username"]); ?></div>
					<div class="menu-sep"></div>
					<div onclick="baseModule.userinfo()">个人信息</div>
					<div onclick="baseModule.password()">修改密码</div>
					<div class="menu-sep"></div>
					<div onclick="baseModule.logout()">退出登录</div>
				</div>
				
				<div id="toparea-help-box">
					<div onclick="$.messager.alert('问题反馈', '请发邮件到531381545@qq.com提交反馈，谢谢！', 'info');">问题反馈</div>
					<div class="menu-sep"></div>
					<div onclick="baseModule.clearCache()">更新缓存</div>
					<div>
						<span>切换主题</span>
						<div id="toparea-help-theme-box">
							<div onclick="baseModule.theme(this)" theme="default">系统默认</div>
							<div onclick="baseModule.theme(this)" theme="gray">Gray</div>
							<div onclick="baseModule.theme(this)" theme="bootstrap">Bootstrap</div>
							<div onclick="baseModule.theme(this)" theme="metro">Metro</div>
						</div>
					</div>
					<div class="menu-sep"></div>
					<div onclick="baseModule.systemInfo()">服务器信息</div>
					<div onclick="$.messager.alert('关于', '版本号：<?php echo C('SYSTEM_VERSION');?><br /><br />联系QQ：531381545', 'info');">关于</div>
					<div class="menu-sep"></div>
					<div onclick="window.open('https://github.com/531381545/app')">Github获取地址</div>
				</div>
			</li>
		</ul>
		<div style="clear:both;border-bottom:none;border-left:none;border-right:none"></div>
	</div>
</div>

<!-- 左侧菜单 -->
<div id="leftarea" data-options="iconCls:'icons-application-application_side_boxes',region:'west',title:'加载中...',split:true,width:220">
	<div id="leftmenu" class="easyui-accordion" data-options="fit:true,border:false"></div>
</div>

<!-- 内容 -->
<div id="mainarea" data-options="region:'center'">
	<div id="pagetabs" class="easyui-tabs" data-options="tabPosition:'<?php echo C("TABLES_TOOLS_POSITION");?>',fit:true,border:false,plain:false">
		<div title="后台首页" href="<?php echo U('Index/public_main');?>" data-options="cache:false"></div>
	</div>
</div>
<div id="rcmenu" class="easyui-menu" style="">
    <div id="refreshcur" data-options="iconCls:'icons-arrow-arrow_refresh'">刷新</div>
    <div id="closecur" data-options="iconCls:'icons-arrow-cross'">关闭</div>
    <div id="closeother">关闭其他</div>
    <div id="closeall">关闭全部</div>
    <div class="menu-sep"></div>
    <div id="closeright">关闭右侧标签页</div>
    <div id="closeleft">关闭左侧标签页</div>
</div>
<!-- 公共部分 -->
<div id="globel-dialog-div" class="word-wrap" style="line-height:1.5"></div>
<div id="globel-dialog2-div" class="word-wrap" style="line-height:1.5"></div> <!-- 特殊情况可能需要弹出第2个弹出层 -->

<script type="text/javascript">
window.baseModule = {
	dialog:   '#globel-dialog-div',
	
	//初始化
	init: function(){
		$('#topmenu > ul.nav > li:first > a:first').click(); //默认选中第一个菜单

		this.sessionLife();
		this.tip();
		this.mousemenu();
	},
	
	//登录默认提示
	tip: function(){
		$.messager.show({
			title:'登录提示',
			msg:'您好！<?php echo ($userInfo["username"]); ?> 欢迎回来！<br/>最后登录时间：<?php if($userInfo['lastlogintime']): echo (date('Y-m-d H:i:s',$userInfo["lastlogintime"])); else: ?>-<?php endif; ?><br/>最后登录IP：<?php echo ($userInfo["lastloginip"]); ?>',
			timeout:5000,
			showType:'slide'
		});	
	},
	
	//切换主题
	theme: function(that){
		var theme = that.getAttribute('theme');
		$('link[rel*=style][title]').each(function(i){
			this.disabled = true;
			if (this.getAttribute('title') == theme) this.disabled = false;
		});
		$('iframe').contents().find('link[rel*=style][title]').each(function(i){
			this.disabled = true;
			if (this.getAttribute('title') == theme) this.disabled = false;
		});
		$.cookie('theme', theme, {path:'/', expires:3650});
	},
	
	//移除左侧栏目  TODO 发现需要执行两次才能彻底清除
	removeLeft: function(stop, titles){
		var pp = $("#leftmenu").accordion("panels");
		$.each(pp, function(i, n) {
			if(n){
				var t = n.panel("options").title;
				if(titles && titles.length){
					for(var k = 0; k < titles.length; k++){
						if(titles[k] == t) $("#leftmenu").accordion("remove", t);
					}
				}else{
					$("#leftmenu").accordion("remove", t);
				}
			}
		});
		var pp = $('#leftmenu').accordion('getSelected');
		if(pp) {
			var t = pp.panel('options').title;
			if(titles && titles.length){
				for(var k = 0; k < titles.length; k++){
					if(titles[k] == t) $("#leftmenu").accordion("remove", t);
				}
			}else{
				$("#leftmenu").accordion("remove", t);
			}
		}
		if(!stop) this.removeLeft(true, titles);
	},
	
	//获取左侧栏目
	getLeft: function(menuid, title, object){
		var that = this;
		
		//加个判断，防止多次点击重复加载
		var options = $('body').layout('panel', 'west').panel('options');
		if(title == options.title) return false;
		
		//开始获取左侧栏目
		$.ajax({
			type: 'POST',
			url: '<?php echo U('Index/public_menuLeft');?>',
			data: {menuid: menuid},
			cache: false,
			beforeSend: function(){
				that.removeLeft();
				//更新标题名称
				$('body').layout('panel', 'west').panel({title: title});
				var loading = '<div class="panel-loading">Loading...</div>';
				$("#leftmenu").accordion("add", {content: loading});
			},
			success: function(data){
				that.removeLeft();
				//左侧内容更新
				$.each(data, function(i, menu) {
					var content = '';
					if(menu.son){
						var treedata = $.toJSON(menu.son);
						content = '<ul class="easyui-tree" data-options=\'data:' + treedata + ',animate:true,lines:true,onClick:function(node){baseModule.openUrl(node.url, node.text)}\'></ul>';
					}
					$("#leftmenu").accordion("add", {title: menu.name, content: content, iconCls:'icons-application-application_side_list'});
				});
			}
		});
		//默认选中头部菜单
		if(object){
			$('#topmenu .nav li').each(function(){
				$(this).children().removeClass('focus');
			});
			$(object).addClass('focus');
		}

		//如果左侧隐藏则进行展开
		if($('body').layout('panel', 'west').panel("options").collapsed){
			$('body').layout('expand', 'west');
		}
	},
	
	//显示打开内容
	openUrl: function(url, title){	
		if($('#pagetabs').tabs('exists', title)){
			$('#pagetabs').tabs('select', title);
		}else{
			$('#pagetabs').tabs('add',{title: title, href: url, closable: true, cache: true});
		}
	},
	//鼠标右键菜单
	mousemenu:function(){
		$(".tabs-header").bind('contextmenu',function(e){
	        e.preventDefault();
	        $('#rcmenu').menu('show', {
	            left: e.pageX,
	            top: e.pageY
	        });
	    });
	    //刷新
	    $("#refreshcur").bind("click",function(){
	    	var tab = $('#pagetabs').tabs('getSelected');
	    	var index = $('#pagetabs').tabs('getTabIndex',tab);
	    	$('#pagetabs').tabs('getTab',index).panel('refresh');
	    });
	    //关闭当前标签页
	    $("#closecur").bind("click",function(){
	        var tab = $('#pagetabs').tabs('getSelected');
	        var index = $('#pagetabs').tabs('getTabIndex',tab);
	        if(index==0){return false;}
	        $('#pagetabs').tabs('close',index);
	    });
	    //关闭所有标签页
	    $("#closeall").bind("click",function(){
	        var tablist = $('#pagetabs').tabs('tabs');
	        for(var i=tablist.length-1;i>0;i--){
	            $('#pagetabs').tabs('close',i);
	        }
	    });
	    //关闭非当前标签页（先关闭右侧，再关闭左侧）
	    $("#closeother").bind("click",function(){
	        var tablist = $('#pagetabs').tabs('tabs');
	        var tab = $('#pagetabs').tabs('getSelected');
	        var index = $('#pagetabs').tabs('getTabIndex',tab);
	        for(var i=tablist.length-1;i>index;i--){
	            $('#pagetabs').tabs('close',i);
	        }
	        var num = index-1;
	        for(var i=num;i>0;i--){
	            $('#pagetabs').tabs('close',1);
	        }
	         $('#pagetabs').tabs('select',1);
	    });
	    //关闭当前标签页右侧标签页
	    $("#closeright").bind("click",function(){
	        var tablist = $('#pagetabs').tabs('tabs');
	        var tab = $('#pagetabs').tabs('getSelected');
	        var index = $('#pagetabs').tabs('getTabIndex',tab);
	        for(var i=tablist.length-1;i>index;i--){
	            $('#pagetabs').tabs('close',i);
	        }
	    });
	    //关闭当前标签页左侧标签页
	    $("#closeleft").bind("click",function(){
	        var tab = $('#pagetabs').tabs('getSelected');
	        var index = $('#pagetabs').tabs('getTabIndex',tab);
	        var num = index-1;
	        for(var i=0;i<num;i++){
	            $('#pagetabs').tabs('close',1);
	        }
	    });
	},
	
	//更新缓存
	clearCache: function(){
		$.post('<?php echo U('Index/public_clearCatche');?>', function(data){
			var type = data.status ? 'info' : 'error';
			$.app.method.tip('提示信息', data.info, type);
		}, 'json');
	},
	
	//退出登录
	logout: function(){
		$.messager.confirm('提示信息', '确定要退出登录吗？', function(result){
			if(result) window.location.href = '<?php echo U('Index/logout');?>';
		});
	},

	//服务器信息
	systemInfo: function(type){
		var that = this;
		$(that.dialog).dialog({
			title: '服务器信息',
			iconCls: 'icons-application-application_view_detail',
			width: 550,
			height: 400,
			cache: false,
			href: '<?php echo U('Index/systemInfo');?>',
			modal: true,
			collapsible: false,
			minimizable: false,
			resizable: true,
			maximizable: true,
			buttons:[{
				text: '关闭',
				iconCls: 'icons-arrow-cross',
				handler: function(){
					$(that.dialog).dialog('close');
				}
			}]
		});
	},
	
	//防止登录超时
	sessionLife: function(){
		setInterval(function(){
			$.post('<?php echo U('Index/public_sessionLife');?>', function(data){
				if(!data.status){
					$.messager.show({
						title: '系统提示',
						msg: data.info,
						timeout:3000,
						showType:'slide'
					});
					setTimeout(function(){
						window.location.href = data.url;
					}, 3000);
				}
			}, 'json');
		}, 15000);
	},
	
	//个人信息
	userinfo: function(){
		var that = this;
		$(that.dialog).dialog({
			title: '个人信息',
			iconCls: 'icons-application-application_form_edit',
			width: 360,
			height: 270,
			cache: false,
			href: '<?php echo U('Admin/public_editInfo');?>',
			modal: true,
			collapsible: false,
			minimizable: false,
			resizable: false,
			maximizable: false,
			buttons:[{
				text: '确定',
				iconCls: 'icons-other-tick',
				handler: function(){
					$(that.dialog).find('form').eq(0).form('submit', {
						onSubmit: function(){
							var isValid = $(this).form('validate');
							if (!isValid) return false;
							
							$.messager.progress({text:'处理中，请稍候...'});
							$.post('<?php echo U('Admin/public_editInfo?dosubmit=1');?>', $(this).serialize(), function(res){
								$.messager.progress('close');
								if(!res.status){
									$.app.method.tip('提示信息', res.info, 'error');
								}else{
									$.app.method.tip('提示信息', res.info, 'info');
									$('#globel-dialog-div').dialog('close');
								}
							}, 'json');
							
							return false;
						}
					});
				}
			},{
				text: '取消',
				iconCls: 'icons-arrow-cross',
				handler: function(){
					$(that.dialog).dialog('close');
				}
			}]
		});
	},
	
	//修改密码
	password: function(){
		var that = this;
		$(that.dialog).dialog({
			title: '修改密码',
			iconCls: 'icons-application-application_form_edit',
			width: 360,
			height: 270,
			cache: false,
			href: '<?php echo U('Admin/public_editPwd');?>',
			modal: true,
			collapsible: false,
			minimizable: false,
			resizable: false,
			maximizable: false,
			buttons:[{
				text: '确定',
				iconCls: 'icons-other-tick',
				handler: function(){
					$(that.dialog).find('form').eq(0).form('submit', {
						onSubmit: function(){
							var isValid = $(this).form('validate');
							if (!isValid) return false;
							
							$.messager.progress({text:'处理中，请稍候...'});
							$.post('<?php echo U('Admin/public_editPwd?dosubmit=1');?>', $(this).serialize(), function(res){
								$.messager.progress('close');
								if(!res.status){
									$.app.method.tip('提示信息', res.info, 'error');
								}else{
									$.messager.confirm('提示信息', res.info, function(result){
										if(result) window.location.href = res.url;
									});
								}
							}, 'json');
							
							return false;
						}
					});
				}
			},{
				text: '取消',
				iconCls: 'icons-arrow-cross',
				handler: function(){
					$(that.dialog).dialog('close');
				}
			}]
		});
	}
};
$(function(){baseModule.init();});
</script>
</body>
</html>