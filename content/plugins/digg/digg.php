<?php !defined('EMLOG_ROOT') && exit('access deined!');
/*
Plugin Name: 赞｜踩
Version: 0.2 beta
Plugin URL: http://www.zakura.net
Description: 在文章页显示顶，踩按钮！
Author: zakura
Author URL: http://www.zakura.net
*/
?>
<?php
	$digg_dir = EMLOG_ROOT . '/content/plugins/digg/';
	$DB = Database::getInstance();
	digg_init();
?>
<?php function digg_digg ( $blogid ) { ?>
	<?php $digg_value = digg_db( $blogid['logid'] ) ; ?>
	<ul class="z_digg">
		<li class="digg"><button class="example zakura"><img src="<?php echo BLOG_URL.'content/plugins/digg/common/digg.png'; ?>" /><span>赞</span><span class="value"><?php echo $digg_value[0]; ?></span></button></li>
		<li><?php 	global $CACHE;
	$user_cache = $CACHE->readCache('user'); ?>
	<?php if (!empty($user_cache[1]['photo']['src'])): ?>
	<img src="<?php echo BLOG_URL.$user_cache[1]['photo']['src']; ?>" width="<?php echo $user_cache[1]['photo']['width']; ?>" height="<?php echo $user_cache[1]['photo']['height']; ?>" alt="blogger" title="<?php echo $user_cache[1]['name']; ?>" />
<?php else : ?>
  <img src="<?php echo BLOG_URL . 'admin/views/images/avatar.jpg'; ?>" alt="blogger" title="<?php echo $user_cache[1]['name']; ?>" />
<?php endif;?></li>
		<li class="undigg"><button class="example zakura"><img src="<?php echo BLOG_URL.'content/plugins/digg/common/undigg.png'; ?>" /><span>踩</span><span class="value"><?php echo $digg_value[1]; ?></span></button></li>
	</ul>
<?php }
addAction('log_related', 'digg_digg'); ?>
<?php function digg_script( $blogid ) {
	/* $digg_ajax = url::log($blogid['logid']); */
	echo "<script type='text/javascript'>
	$(function(){
		var that = $('.z_digg');
		if ( new RegExp('zakura_digg{$blogid['logid']}','i').test( document.cookie ) ) {
			that.children().eq(0).find('span:first').text('已赞过');
			that.children().eq(2).find('span:first').text('不能踩');
		} else if ( new RegExp('zakura_undigg{$blogid['logid']}','i').test( document.cookie ) ) {
			that.children().eq(0).find('span:first').text('不能赞');
			that.children().eq(2).find('span:first').text('已踩过');			
		}
		$('.z_digg li').on('click', function(){
			var that = $(this);
			var mark = that.index(), /* action = '{$digg_ajax}', */ post_ID = {$blogid['logid']};
			ajax_data = { mark: mark, plugin: 'digg', /* action: action, */ id: post_ID };
			var pattern = new RegExp('(zakura_digg{$blogid['logid']}|zakura_undigg{$blogid['logid']})','i');
			if ( !pattern.test( document.cookie ) && that.index() != 1 ) {
				$.post('', ajax_data,function(data){
					that.parent().children().eq(0).find('span:last').html( data.split(',')[0] );
					that.parent().children().eq(2).find('span:last').html( data.split(',')[1] );
					that.find('img').addClass('bounce animated');
					that.find('span:first').addClass('flash animated');
					if ( that.index() == 0 ) {
						that.find('span:last').addClass('bounceInDown animated');
						/* that.addClass('niceIn'); */
					} else if ( that.index() == 2 ) {
						that.find('span:last').addClass('bounceInUp animated');
						/* that.addClass('niceIn'); */
					}
					if ( new RegExp('zakura_digg{$blogid['logid']}','i').test( document.cookie ) ) {
						$('.z_digg').children().eq(0).find('span:first').text('已赞过');
						$('.z_digg').children().eq(2).find('span:first').text('不能踩');
					} else if ( new RegExp('zakura_undigg{$blogid['logid']}','i').test( document.cookie ) ) {
						$('.z_digg').children().eq(0).find('span:first').text('不能赞');
						$('.z_digg').children().eq(2).find('span:first').text('已踩过');			
					}
				})					
			}			
		})
	})
    </script>\n";
}

addAction('log_related', 'digg_script');
?>
<?php function digg_css() {
	$font = BLOG_URL.'content/plugins/digg/';
	$animate = BLOG_URL.'content/plugins/digg/common/animate.css';
	echo "<style type='text/css'>
	@import url('{$animate}');
	.z_digg {
		margin: 0;
		padding: 0;
		list-style-type: none;
		text-align: center;
		position: relative;
	}
	.z_digg li {
		display: inline-block;
		width: 160px;
		line-height: 30px;
		margin: 0 auto;
		vertical-align: middle;
	}
	@media screen and (max-width: 600px) { 
		.z_digg li {
			width: 360px;
		}
	} 
	.z_digg li span {
		display: inline-block;
		font: normal normal normal 12px/14px 'Microsoft YaHei';
		/* vertical-align: 18%; */
	}
	.z_digg li:nth-child(1) {
	
	}
	.z_digg li:nth-child(1) img {
		width: 18px;
		height: 18px;
		margin: 0 5px 0 0;
		vertical-align: middle;
	}
	.z_digg li:nth-child(1) span {
		vertical-align: -15%;
	}
	.z_digg li:nth-child(1) span:nth-child(2) {
		margin: 0 5px 0 0;
	}
	.z_digg li:nth-child(3) {

	}
	.z_digg li:nth-child(3) img {
		width: 18px;
		height: 18px;
		margin: 0 5px 0 0;
		vertical-align: middle;
	}
	.z_digg li:nth-child(3) span {
		vertical-align: -15%;
	}
	.z_digg li:nth-child(3) span:nth-child(2) {
		margin: 0 5px 0 0;
	}
	.z_digg li:nth-child(2) {
	}
	.z_digg li:nth-child(2) img {
		width: 70px;
		height: 70px;
		box-shadow: 0 1px 3px rgba(34,25,25,.5);
		border: 3px #fff solid;
		border-radius: 100%;
		transition: all 1s ease 0s;
	}
	button.example {
		-webkit-transition: all 0s ease-out;
		-moz-transition: all 0s ease-out;
		-o-transition: all 0s ease-out;
		-ms-transition: all 0s ease-out;
		transition: all 0s ease-out;
		width: 130px;
		height: 35px;
		display: block;
		color: #fff;
		text-decoration: none;
		text-align: center;
		text-shadow: 0px -1px 0px rgba(0,0,0,0.4);
		margin: 20px auto;
		position: relative;
		cursor: pointer;
		border: none;
		border-radius: 6px;
	}
	button.zakura {
		border-left: solid 1px #2E4476;
		background: #3B5999;

		-webkit-box-shadow: 0px 5px 0px 0px #2E4476 !important;;
		box-shadow: 0px 5px 0px 0px #2E4476 !important;;
	}
	button.example:active {
		top: 3px;
	}
	button.zakura:active {
		-webkit-box-shadow: 0px 2px 0px 0px #2E4476 !important;;
		box-shadow: 0px 2px 0px 0px #2E4476 !important;
	}
	button.example:active:before {
		top: -3px;
	}
	button:focus,
	button:active,
	button:hover {
		outline: none !important;
	}
    </style>\n";
}

addAction('index_head', 'digg_css');
?>
<?php function digg_script_init ( ) {
	$jquery =BLOG_URL.'content/plugins/digg/common/jquery.min.js';
	echo "<script type='text/javascript'>
	if ( typeof jQuery != 'undefined' ) {
	} else {
		document.write(\"<script src='{$jquery}'><\/script>\");
	}
	/*
		- 定义getCookies函数（获取所有cookie并转为数组）
		- 定义cookies变量（调用getCookies函数并将返回的数组储存在变量内）
	*/
	var getCookies = function(){
		var pairs = document.cookie.split(';');
		var cookies = {};
		for (var i = 0; i < pairs.length; i++){
			var pair = pairs[i].split('=');
			cookies[pair[0]] = unescape(pair[1]);
		}
		return cookies;
	}
	 
	// 遍历，i为cookie的名字，cookies[i]为值
    </script>\n";
}

addAction('index_head', 'digg_script_init');
?>
<?php function digg_init() {
	global $DB;
	if ( mysql_fetch_array( $DB->query( "Describe ".DB_PREFIX."blog digg" ) ) == false ) {
			$sql = "ALTER TABLE ".DB_PREFIX."blog ADD digg varchar(10) NOT NULL DEFAULT '0,0'";
			$DB->query($sql);
	} 
	function digg_db ( $logid ) {
		global $DB;
		if ( $logid ) {
			 $sql = "SELECT digg FROM " . DB_PREFIX . "blog WHERE gid=$logid";
			  $res = $DB->query($sql);
			  $row = $DB->fetch_array($res);
			  return explode(',',$row['digg']);
		}
	}
	if ( $_POST['plugin'] == 'digg' ) {
		header("Access-Control-Allow-Origin: *");
		echo digg_updata( $_POST );
		 die;
	}
}
?>
<?php function digg_updata ( $ajax_data ) {
	global $DB;
	$digg_value = digg_db(  $ajax_data['id'] ) ;
	if ( $ajax_data['mark'] == 0 ) {
		$digg_value[0] += 1;
		$value = $digg_value[0].','.$digg_value[1];
		$DB->query("UPDATE " . DB_PREFIX . "blog SET digg='{$value}' WHERE gid={$ajax_data['id']}");
		setcookie('zakura_digg'.$ajax_data['id'], $ajax_data['id'], time() + (10 * 365 * 24 * 60 * 60) );
		return $value;
	} elseif ( $ajax_data['mark'] == 2 ) {
		$digg_value[1] += 1;
		$value = $digg_value[0].','.$digg_value[1];
		$DB->query("UPDATE " . DB_PREFIX . "blog SET digg='{$value}' WHERE gid={$ajax_data['id']}");
		setcookie('zakura_undigg'.$ajax_data['id'],  $ajax_data['id'], time() + (10 * 365 * 24 * 60 * 60) );
		return $value;
	}
}
?>