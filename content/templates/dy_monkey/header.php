<?php
ob_clean();
/*
Template Name:Monkey
Description:为程序员打造的一款博客主题，简约清爽，极速畅快！Monkey猴子主题~
Version:3.0
Author:DYBOY
Author Url:https://blog.dyboy.cn
Sidebar Amount:0
*/
if(!defined('EMLOG_ROOT')) {exit('LOST!');}
define("THEME_VER","3.0");
ini_set('date.timezone','Asia/Shanghai');
if(version_compare(PHP_VERSION,'5.4.0','<')){ header("Content-Type: text/html; charset=UTF-8");die('Sorry，不支持 5.4以下的PHP版本.  当前您的PHP版本为：' . PHP_VERSION); }
require_once('dy_config.php');
require_once View::getView('module');
require_once View::getView('function');
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=11,IE=10,IE=9,IE=8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
	<link rel="shortcut icon" href="<?php echo TEMPLATE_URL; ?>img/favicon.ico">
	<title><?php echo $site_title; ?></title>
	<meta name="keywords" content="<?php echo $site_key; ?>" />
	<meta name="description" content="<?php echo $site_description; ?>" />
	<?php gf_url($logid);?> <!-- url唯一化-->
	<meta name="generator" content="emlog" />
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta http-equiv="Cache-Control" content="no-siteapp" />
	<meta http-equiv="Cache-Control" content="no-transform" />
	<meta name="apple-mobile-web-app-title" content="<?php echo $blogname; ?>" />

	<link rel="EditURI" type="application/rsd+xml" title="RSD" href="<?php echo BLOG_URL; ?>xmlrpc.php?rsd" />
	<link rel="wlwmanifest" type="application/wlwmanifest+xml" href="<?php echo BLOG_URL; ?>wlwmanifest.xml" />
	<link rel="alternate" type="application/rss+xml" title="RSS"  href="<?php echo BLOG_URL; ?>rss.php" />

	<link type="text/css" rel="stylesheet" href="<?php echo TEMPLATE_URL; ?>style/prettify.css" />
	<link type="text/css" rel="stylesheet" href="<?php echo TEMPLATE_URL; ?>style/animate.min.css" />
	<link type="text/css" rel="stylesheet" href="<?php echo TEMPLATE_URL; ?>style/bootstrap.min.css" />
	<link type="text/css" rel="stylesheet" href="<?php echo TEMPLATE_URL; ?>style/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="<?php echo TEMPLATE_URL; ?>style/main.css" />

	<script type="text/javascript" src="<?php echo BLOG_URL; ?>include/lib/js/common_tpl.js"></script>
	<script type="text/javascript" src="<?php echo TEMPLATE_URL; ?>js/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo TEMPLATE_URL; ?>js/jquery.pjax.js"></script>
	<script type="text/javascript" src="<?php echo TEMPLATE_URL; ?>js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo TEMPLATE_URL; ?>js/prettify.js"></script>
	<?php if($config['xiongAppid']):?>
  	<script src="//msite.baidu.com/sdk/c.js?appid=<?php echo $config['xiongAppid']; ?>"></script>
  	<?php endif; ?>
	<style type="text/css">
		body{background-image: url("<?php echo $config['backImg']; ?>")}
	</style>
	<?php doAction('index_head'); ?>
</head>
<body>


<!-- 导航模块 -->
<div id="nav"> <?php blog_navi();?></div>
<div class="burger" style="z-index:99999">
    <div class="x"></div>
    <div class="y"></div>
    <div class="z"></div>
</div>
<div class="m_blog_title">
	<a href="<?php echo BLOG_URL; ?>" title="<?php echo $bloginfo; ?>"><?php echo $blogname; ?></a>
</div>


<div id="monkey_pjax">

<!-- 首页全屏展示模块 -->
<?php if(blog_tool_ishome()): ?>
<div id="header">
	<div style="height: 60px;"></div>
	<div class="animated fadeInDown">
		<h1 class="blog_title"><a href="<?php echo BLOG_URL; ?>"><?php echo $blogname; ?></a></h1> <!-- 博客名字 -->
		<p><?php echo $bloginfo; ?></p>  <!-- 博客介绍 -->
		<div class="contact">
			<span class="qq_link">
				<a href="https://wpa.qq.com/msgrd?v=3&uin=<?php echo $config['qq'];?>&site=qq&menu=yes" rel="nofollow" target="_blank" title="使用QQ联系我">
					<i class="fa fa-qq"></i>
				</a>
			</span>
			<span class="github_link">
				<a href="<?php echo $config['github_url'];?>" rel="nofollow" target="_blank" title="Github开源代码仓库">
					<i class="fa fa-github-square"></i>
				</a>
			</span>
			<span class="email_link">
				<a href="<?php echo $config['qqmail_url'];?>" rel="nofollow" target="_blank" title="给我发送电子邮件">
					<i class="fa fa-paper-plane"></i>
				</a>
			</span>
			<span class="email_link">
				<a href="<?php echo BLOG_URL; ?>rss.php" rel="rss" target="_blank" title="RSS订阅">
					<i class="fa fa-rss"></i>
				</a>
			</span>
			<span class="email_link">
				<a href="<?php echo BLOG_URL; ?>resume.html" rel="rss" title="查看博主个人简历">
					<i class="fa fa-user"></i>
				</a>
			</span>
		</div>
		<div class="search">
			<div method="get" class="search_form">
				<input class="search_input" type="text" placeholder="请输入关键字搜索~"><a href="./index.php?keyword=" class="search_a_btn"><button class="search_btn" type="submit"><i class="fa fa-search"></i></button></a>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>

<div id="wrap">