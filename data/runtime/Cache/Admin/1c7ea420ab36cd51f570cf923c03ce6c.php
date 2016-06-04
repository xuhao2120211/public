<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<!-- Set render engine for 360 browser -->
	<meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- HTML5 shim for IE8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <![endif]-->

	<link href="/admin/Public/simpleboot/themes/<?php echo C('SP_ADMIN_STYLE');?>/theme.min.css" rel="stylesheet">
    <link href="/admin/Public/simpleboot/css/simplebootadmin.css" rel="stylesheet">
    <link href="/admin/Public/js/artDialog/skins/default.css" rel="stylesheet" />
    <link href="/admin/Public/simpleboot/font-awesome/4.4.0/css/font-awesome.min.css"  rel="stylesheet" type="text/css">
    <style>
		.length_3{width: 180px;}
		form .input-order{margin-bottom: 0px;padding:3px;width:40px;}
		.table-actions{margin-top: 5px; margin-bottom: 5px;padding:0px;}
		.table-list{margin-bottom: 0px;}
	</style>
	<!--[if IE 7]>
	<link rel="stylesheet" href="/admin/Public/simpleboot/font-awesome/4.4.0/css/font-awesome-ie7.min.css">
	<![endif]-->
<script type="text/javascript">
//全局变量
var GV = {
    DIMAUB: "/admin/",
    JS_ROOT: "public/js/",
    TOKEN: ""
};
</script>
<!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/admin/Public/js/jquery.js"></script>
    <script src="/admin/Public/js/wind.js"></script>
    <script src="/admin/Public/simpleboot/bootstrap/js/bootstrap.min.js"></script>
<?php if(APP_DEBUG): ?><style>
		#think_page_trace_open{
			z-index:9999;
		}
	</style><?php endif; ?>
<style>
li {
	list-style: none;
}
</style>
</head>
<body>
	<div class="wrap">
		<div id="error_tips">
			<h2><?php echo ($msgTitle); ?></h2>
			<div class="error_cont">
				<ul>
					<li><?php echo ($error); ?></li>
				</ul>
				<div class="error_return">
					<a href="<?php echo ($jumpUrl); ?>" class="btn">返回</a>
				</div>
			</div>
		</div>
	</div>
	<script src="/admin/Public/js/common.js"></script>
	<script>
		setTimeout(function() {
			location.href = '<?php echo ($jumpUrl); ?>';
		}, 3000);
	</script>
</body>
</html>