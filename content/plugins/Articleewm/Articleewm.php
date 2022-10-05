<?php
/*
Plugin Name: 文章二维码
Version: 1.1
Plugin URL: http://www.youngxj.cn
Description:文章二维码
ForEmlog:5.3.x
Author: 杨小杰
Author URL: http://www.youngxj.cn
*/

!defined('EMLOG_ROOT') && exit('access deined!');
function Articleewm(){
  	include 'Articleewm_config.php';
  	$api = $config['api'];
  	if($config['ssl']){
    	$ssl = 'https://';
    }else{
    	$ssl = "http://";
    }
  	$url=$ssl.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
  	$w = $config['w'];
	$h = $config['h'];
	$c = $config['c'];
	$b = $config['b'];
  	?>
	<link href="<?php echo BLOG_URL;?>content/plugins/Articleewm/Articleewm.css" rel="stylesheet" type="text/css" />
	<?php
  	if(!$api){
	$html = file_get_contents("https://cli.im/api/qrcode/code?text=$url&mhid=tUaVBVm7n58hMHctKddcOqI");
    preg_match_all('<img src="(.*?)" id="(.*?)" class="(.*?)" style="(.*?)">',$html,$cc);
    echo '<div class="Articleewm" title="手机扫描进入此页面"><img src="'.$cc[1][0].'" alt="扫描进入手机浏览"></div>';
}else{
    ?>

	<script src="<?php echo BLOG_URL;?>content/plugins/Articleewm/qrcode.js"></script>
<div class="Articleewm" title="手机扫描进入此页面"><div id="qrcode"></div><a href ="javascript:return false;">手机扫描二维码<br/>阅读体验更佳</a></div>
	<script type="text/javascript">
	var qrcode = new QRCode("qrcode", {
    text: "<?php echo $url;?>",
    width: <?php echo $w;?>,
    height: <?php echo $h;?>,
    colorDark : "<?php echo $c;?>",
    colorLight : "<?php echo $b;?>",
    correctLevel : QRCode.CorrectLevel.H
	});
 	</script>
	<?php
    }
}
function Articleewm_menu(){
	echo '<div class="sidebarsubmenu"><a href="./plugin.php?plugin=Articleewm">文章二维码</a></div>';
}
?>
<?php 
addAction('log_related','Articleewm');
addAction('adm_sidebar_ext', 'Articleewm_menu');
?>