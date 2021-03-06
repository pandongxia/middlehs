<?php if (!defined('THINK_PATH')) exit();?>
<table id="system_email_datagrid" class="easyui-datagrid" data-options='<?php $dataOptions = array_merge(array ( 'border' => false, 'fit' => true, 'fitColumns' => true, 'rownumbers' => true, 'singleSelect' => true, 'striped' => true, 'pagination' => true, 'pageList' => array ( 0 => 20, 1 => 30, 2 => 50, 3 => 80, 4 => 100, ), 'pageSize' => '20', ), $datagrid["options"]);if(isset($dataOptions['toolbar']) && substr($dataOptions['toolbar'],0,1) != '#'): unset($dataOptions['toolbar']); endif; echo trim(json_encode($dataOptions), '{}[]').((isset($datagrid["options"]['toolbar']) && substr($datagrid["options"]['toolbar'],0,1) != '#')?',"toolbar":'.$datagrid["options"]['toolbar']:null); ?>' style=""><thead><tr><?php if(is_array($datagrid["fields"])):foreach ($datagrid["fields"] as $key=>$arr):if(isset($arr['formatter'])):unset($arr['formatter']);endif;echo "<th data-options='".trim(json_encode($arr), '{}[]').(isset($datagrid["fields"][$key]['formatter'])?",\"formatter\":".$datagrid["fields"][$key]['formatter']:null)."'>".$key."</th>";endforeach;endif; ?></tr></thead></table>

<div id="system-email-datagrid-toolbar" style="padding:1px;height:auto">
	<form style="border-bottom:1px solid #ddd;margin-bottom:1px;padding:5px">
		编号: <input type="text" name="search[code]" style="width:100px;padding:2px"/>
		主题: <input type="text" name="search[subject]" style="width:100px;padding:2px"/>
		添加时间: <input name="search[begin]" class="easyui-datebox" style="width:100px">
		至: <input name="search[end]" class="easyui-datebox" style="width:100px">
		
		<a href="javascript:;" onclick="systemEmailModule.search(this);" class="easyui-linkbutton" iconCls="icons-table-table">搜索</a>
	</form>
	<div>
		<a href="javascript:;" class="easyui-linkbutton" data-options="plain:true,iconCls:'icons-table-table_add'" onclick="systemEmailModule.add()">添加</a>
		<a href="javascript:;" class="easyui-linkbutton" data-options="plain:true,iconCls:'icons-table-table_delete'" onclick="systemEmailModule.delete()">删除</a>
		<a href="javascript:;" class="easyui-linkbutton" data-options="plain:true,iconCls:'icons-table-table_refresh'" onclick="systemEmailModule.refresh()">刷新</a>
	</div>
</div>

<script type="text/javascript">
var systemEmailModule = {
	dialog:   '#globel-dialog-div',
	datagrid: '#system_email_datagrid',

	//操作格式化
	operate: function(val, arr){
		var btn = [];
		btn.push('<a href="javascript:;" onclick="systemEmailModule.edit('+arr.id+')">编辑</a>');
		btn.push('<a href="javascript:;" onclick="systemEmailModule.delete('+arr.id+')">删除</a>');
		return btn.join(' | ');
	},

	//刷新
	refresh: function(){
		$(this.datagrid).datagrid('reload');
	},
	
	//搜索
	search: function(that){
		var queryParams = $(this.datagrid).datagrid('options').queryParams;
		$.each($(that).parent('form').serializeArray(), function() {
			queryParams[this['name']] = this['value'];
		});
		$(this.datagrid).datagrid({pageNumber: 1});
	},

	//添加
	add: function () {
		var that = this;
		$(that.dialog).dialog({
			title: '添加模板',
			iconCls: 'icons-application-application_add',
			width: 490,
			height: 390,
			cache: false,
			href: '<?php echo U("System/emailAdd");?>',
			modal: true,
			collapsible: false,
			minimizable: false,
			resizable: false,
			maximizable: false,
			buttons:[{
				text:'确定',
				iconCls:'icons-other-tick',
				handler: function(){
					$(that.dialog).find('form:first').form('submit', {
						onSubmit: function(){
							var isValid = $(this).form('validate');
							if (!isValid) return false;

							$.messager.progress({text:'处理中，请稍候...'});
							$.post("<?php echo U('System/emailAdd?dosubmit=1');?>", $(this).serialize(), function(res){
								$.messager.progress('close');

								if(!res.status){
									$.app.method.tip('提示信息', res.info, 'error');
								}else{
									$.app.method.tip('提示信息', res.info, 'info');
									$(that.dialog).dialog('close');
									that.refresh();
								}
							}, 'json');

							return false;
						}
					});
				}
			},{
				text:'取消',
				iconCls:'icons-arrow-cross',
				handler: function(){
					$(that.dialog).dialog('close');
				}
			}]
		});
	},

	//编辑
	edit: function(id){
		if(typeof(id) !== 'number'){
			$.app.method.tip('提示信息', '未选择数据', 'error');
			return false;
		}
		var href = '<?php echo U('System/emailEdit');?>';
		href += href.indexOf('?') != -1 ? '&id='+id : '?id='+id;

		var that = this;
		$(that.dialog).dialog({
			title: '编辑模板',
			iconCls: 'icons-application-application_edit',
			width: 490,
			height: 390,
			cache: false,
			href: href,
			modal: true,
			collapsible: false,
			minimizable: false,
			resizable: false,
			maximizable: false,
			buttons:[{
				text:'确定',
				iconCls:'icons-other-tick',
				handler: function(){
					$(that.dialog).find('form:first').form('submit', {
						onSubmit: function(){
							var isValid = $(this).form('validate');
							if (!isValid) return false;

							$.messager.progress({text:'处理中，请稍候...'});
							var action = '<?php echo U('System/emailEdit', array('dosubmit'=>1));?>';
							action += action.indexOf('?') != -1 ? '&id='+id : '?id='+id;
							$.post(action, $(this).serialize(), function(res){
								$.messager.progress('close');

								if(!res.status){
									$.app.method.tip('提示信息', res.info, 'error');
								}else{
									$.app.method.tip('提示信息', res.info, 'info');
									$(that.dialog).dialog('close');
									that.refresh();
								}
							}, 'json');

							return false;
						}
					});
				}
			},{
				text:'取消',
				iconCls:'icons-arrow-cross',
				handler: function(){
					$(that.dialog).dialog('close');
				}
			}]
		});
	},

	//删除
	delete: function(id){
		var that = this;

		var ids = [];
		if(!id){
			var obj = $(that.datagrid).datagrid('getSelections');
			if(obj) for(var i = 0; i < obj.length; i++) ids.push(obj[i].id);
		}else{
			if(typeof(id) == 'number') ids.push(id);
		}
		if(ids.length == 0){
			$.app.method.tip('提示信息', '未选择数据', 'error');
			return false;
		}
		$.messager.confirm('提示信息', '确定要删除吗？', function(result){
			if(!result) return false;

			$.messager.progress({text:'处理中，请稍候...'});
			$.post("<?php echo U('System/emailDelete');?>", {ids: ids}, function(res){
				$.messager.progress('close');

				if(!res.status){
					$.app.method.tip('提示信息', res.info, 'error');
				}else{
					$.app.method.tip('提示信息', res.info, 'info');
					that.refresh();
				}
			}, 'json');
		});
	}

};
</script>