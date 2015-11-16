<?php
return array(
	//'配置项'=>'配置值'
	'DB_PREFIX'     => 'hs_',
	'DB_TYPE'       => 'mysql',
	'DB_HOST'       => '127.0.0.1',
	'DB_NAME'       => 'helenservice',
	'DB_USER'       => 'root',
	'DB_PWD'        => 'root',
	'DB_PORT'       => 3306,
	'DB_CHARSET'    => 'utf8',
	
	'DEFAULT_MODULE'        => 'Home',
	'MODULE_DENY_LIST'      => array('Common', 'Runtime'),
	'MODULE_ALLOW_LIST'     => array('Home', 'Admin', 'Install'),
	
	//伪静态
	'URL_HTML_SUFFIX' => '',
	
	//大小写敏感
	'URL_CASE_INSENSITIVE' => true,
//	'URL_MODEL'             => 2,            // URL模式
	'URL_PATHINFO_DEPR'     => '/',          // PATHINFO URL分割符
	'URL_ROUTER_ON'         => false,        // 是否开启URL路由
	'URL_ROUTE_RULES'       => array(),      // 默认路由规则 针对模块
	
	/* 模板解析设置 */
	'TMPL_PARSE_STRING' => array(
		'./Public/upload/'  => SCRIPT_DIR . '/Public/upload/',
		'__PUBLIC__'        => SCRIPT_DIR . '/Public',
		'__STATIC__'        => SCRIPT_DIR . '/Public/static',
	),
	
		// 配置邮件发送服务器
    'MAIL_HOST' =>'smtp.163.com',//smtp服务器的名称
    'MAIL_SMTPAUTH' =>TRUE, //启用smtp认证
    'MAIL_USERNAME' =>'dxpan2002@163.com',//你的邮箱名
    'MAIL_FROM' =>'dxpan2002@163.com',//发件人地址
    'MAIL_FROMNAME'=>'发件人姓名',//发件人姓名
    'MAIL_PASSWORD' =>'helenservice',//邮箱密码
    'MAIL_CHARSET' =>'utf-8',//设置邮件编码
    'MAIL_ISHTML' =>TRUE, // 是否HTML格式邮件
);