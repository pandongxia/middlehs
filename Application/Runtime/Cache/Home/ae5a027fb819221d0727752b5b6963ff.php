<?php if (!defined('THINK_PATH')) exit();?><html><head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Web消息接受页面</title>
  <script type="text/javascript">
  //WebSocket = null;
  </script>
    <link href="/demo/Public/css/bootstrap.min.css" rel="stylesheet">

  <!-- Include these three JS files: -->
 <script type="text/javascript" src="/demo/Public/js/sender.js"></script>
  <script type="text/javascript">
    // 展示推送的信息，这里只是简单alert出来，开发者可以做想要的效果展示。
    // 将js/sender.js引入想要的接受推送的页面，然后实现show_msg函数即可
    function show_msg(data) {
    	alert('1111111from_client_id:'+data['from_client_id'] + ' to_client_id:' + data['to_client_id'] + '消息:' +data['content'] + '时间:' + data['time']);
    }

  </script>
</head>
<body>


    <div class="container">
	
	    <div class="row clearfix">
	        <div class="col-md-1 column">
	        </div>
	        <div class="col-md-10 column">
	        <br>
	        <h3>这是一个空的页面，通过websocket协议来接收服务器推送过来的消息</h3>
	        <p>展示逻辑在javascript函数show_msg(data)中，本页面只是简单alert出来</p>
	        <p>在你的Web项目中的html页面引入 js/sender.js，可以将ssender.js文件放入你的Web项目中，然后实现show_msg函数遍可以接受到消息</p>
	        <p>不支持websocket的浏览器会请求swf/WebSocketMain.swf，通过flash实现websocket连接，所以你的项目中要保证WebSocketMain.swf能被访问到</p>
	        <pre><code>function show_msg(data) {
        alert('from_client_id:'+data['from_client_id'] + ' to_client_id:' + data['to_client_id'] + '消息:' +data['content'] + '时间:' + data['time']);
    }</code></pre>
	        </div>
	        <div class="col-md-1 column">
	        </div>
	    </div>
    </div>
</body>
</html>