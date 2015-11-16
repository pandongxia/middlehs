<?php if (!defined('THINK_PATH')) exit();?><div class="easyui-panel" data-options="fit:true,title:'后台首页',border:false,onResize:function(){$('#index-main-portal').portal({border:false,fit:true});}">
	<div id="index-main-portal">
		<div style="width:50%">
			<div title="我的个人信息" collapsible="true" style="padding:8px;line-height:1.8;height: 132px;">
				您好，<?php echo ($userInfo["username"]); ?><br />
				所属角色：<?php echo ($userInfo["rolename"]); ?> <br />
				最后登录时间：<?php if($userInfo['lastlogintime'] > 0): echo (date('Y-m-d H:i:s',$userInfo["lastlogintime"])); endif; ?><br />
				最后登录IP：<?php echo ($userInfo["lastloginip"]); ?> <br />
			</div>

			<div title="近期登录" collapsible="true" style="padding:8px;line-height:1.8">
				<?php if(is_array($loginList)): foreach($loginList as $key=>$log): ?>[<?php echo ($log["time"]); ?>] 登录IP：<?php echo ($log["ip"]); ?><br/><?php endforeach; endif; ?>
			</div>

			<div title="改动日志" collapsible="true" style="padding:8px;line-height:1.8">
				<?php if(is_array($changeList)): $i = 0; $__LIST__ = array_slice($changeList,0,9,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$change): $mod = ($i % 2 );++$i; echo ($change); ?><br/><?php endforeach; endif; else: echo "" ;endif; ?>
				<?php if(count($changeList) > 9): ?>......<?php endif; ?>
			</div>
		</div>

		<div style="width:50%">
			<div title="安全提示" collapsible="true" style="padding:8px;line-height:1.8;height: 132px;">
				<?php if(is_writeable(SITE_DIR . DS . 'Libs')): ?>建议设置Libs目录权限为<?php if(IS_WIN): ?>只读<?php else: ?>755<?php endif; ?>  <br /><?php endif; ?>
				<?php if(APP_DEBUG): ?>网站上线后建议关闭DEBUG调试模式 <br /><?php endif; ?>
				<?php if(!C('SAVE_LOG_OPEN')): ?>建议开启后台日志记录功能<br /><?php endif; ?>
				<?php if(!C('LOGIN_ONLY_ONE')): ?>建议开启单点登录功能<br /><?php endif; ?>
			</div>


			<div title="系统说明" collapsible="true" style="padding:8px;line-height:1.8">
				版本号：<?php echo C('SYSTEM_VERSION');?> （联系QQ：531381545）<br />
				兼容性：IE9、IE10、IE11、FireFox、Chrome、Safari等主流浏览器<br/>
				采用 ThinkPHP：<?php echo (THINK_VERSION); ?> + jQuery EasyUI：1.4.2 开发<br/>
				http://doc.thinkphp.cn/（ThinkPHP开发手册）<br/>
				http://jeasyui.com/documentation/（EasyUI开发手册）<br/>
			</div>

			<div title="捐赠作者" collapsible="true" style="height: 260px;">
				<div class="easyui-tabs" data-options="fit:true,border:false,plain:true">
					<div title="支付宝捐赠" style="padding:8px;line-height:1.8">
						<img src="/demo/Public/static/img/alipay.jpg"  alt="捐赠我们" height="155" /><br />
						<b style="margin-left:15px">用手机扫描二位码支付</b>
					</div>

					<div title="捐赠详情（截止到2015-07-07）">
						<table class="easyui-datagrid" data-options="fit:true,border:false,fitColumns:true,singleSelect:true,url:'<?php echo U('Index/public_donate');?>'">
							<thead>
							<tr>
								<th data-options="field:'money',width:20">金额（元）</th>
								<th data-options="field:'name',width:30">捐赠人</th>
								<th data-options="field:'type',width:20">捐赠方式</th>
								<th data-options="field:'time',width:30">捐赠时间</th>
							</tr>
							</thead>
						</table>
					</div>

			</div>

		</div>
	</div>

</div>