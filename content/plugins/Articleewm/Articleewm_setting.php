<?php
!defined('EMLOG_ROOT') && exit('access deined!');
function plugin_setting_view() {
	include 'Articleewm_config.php';
	echo '<div class=containertitle><b>文章二维码</b>';
	if (isset($_GET['setting']))
		echo '<span class="actived">插件设置完成</span>';
	echo '</div><div class=line></div>';
?>
<div class="post">
  <div class="des" style="margin: 5px 0; width: 500px;background-color: #FFFFE5;padding: 5px 10px;border: 1px #CCCCCC solid;clear: both;border-radius: 4px;">请选择二维码接口<br/>如有问题联系<a href="http://www.youngxj.cn">杨小杰博客</a></div>
<form action="plugin.php?plugin=Articleewm&action=setting" method="post">
    <div>
    二维码渠道
  	<input type="radio" name="api" value="1" <?php if ($config["api"] == 1) { echo 'checked'; } ?>>本地qrcode.js
    <input type="radio" name="api" value="0" <?php if ($config["api"] != 1) { echo 'checked'; } ?>>草料api
    <div class="qrcode" style="<?php if ($config["api"] == 0) { echo 'display:none;'; } ?>">
    <br/>二维码高度：<input type="text" name="w" value='<?php echo $config["w"];?>'>
    <br/>二维码宽度：<input type="text" name="h" value='<?php echo $config["h"];?>'>
    <br/>二维码颜色：<input type="text" name="c" value='<?php echo $config["c"];?>'>
    <br/>二维码背景色：<input type="text" name="b" value='<?php echo $config["b"];?>'>
    </div>
    <br/>ssl是否开启
  	<input type="radio" name="ssl" value="1" <?php if ($config["ssl"] == 1) { echo 'checked'; } ?>>是
    <input type="radio" name="ssl" value="0" <?php if ($config["ssl"] != 1) { echo 'checked'; } ?>>否
	<p><input type="submit" value="保存设置"  class="button"/></p>
  	</div>
</form>
</div>
<?php
}

function plugin_setting() {
	$newConfig = '<?php
$config = array(
	"api" => "'.$_POST["api"].'",
    "w" => "'.$_POST["w"].'",
    "h" => "'.$_POST["h"].'",
    "c" => "'.$_POST["c"].'",
    "b" => "'.$_POST["b"].'",
    "ssl" => "'.$_POST["ssl"].'"
);';
	@file_put_contents(EMLOG_ROOT.'/content/plugins/Articleewm/Articleewm_config.php', $newConfig);
}
?>
