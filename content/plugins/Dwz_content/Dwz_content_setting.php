<?php
!defined('EMLOG_ROOT') && exit('access deined!');

function plugin_setting_view() {
  	include 'Dwz_config.php';
	echo '<div class=containertitle><b>插件设置</b>';
	if (isset($_GET['setting']))
		echo '<span class="actived">插件设置完成</span>';
  	echo '</div>';?>
<form action="plugin.php?plugin=Dwz_content&action=setting" method="post">
	<div style="margin-left:10px;">
      <p>二维码宽度</p>
    <input type="text" name="width" value="<?php echo $config["width"];?>">
      <p>二维码高度</p>
    <input type="text" name="height" value="<?php echo $config["height"];?>">
      <p>二维码前景色(仅支持RGB)</p>
    <input type="text" name="colorDark" value="<?php echo $config["colorDark"];?>">
      <p>二维码背景色(仅支持RGB)</p>
    <input type="text" name="colorLight" value="<?php echo $config["colorLight"];?>">
      <p>二维码开关</p>
    <input type="radio" name="qrcode" value="1" <?php if ($config["qrcode"] == 1) { echo 'checked'; } ?>>开启二维码
    <input type="radio" name="qrcode" value="0" <?php if ($config["qrcode"] != 1) { echo 'checked'; } ?>>关闭二维码
	<p><input type="submit" value="保存设置"  class="button"/></p>
	</div>
</form>
<?php
}

function plugin_setting() {
	$newConfig = '<?php
$config = array(
	"qrcode" => "'.$_POST["qrcode"].'",
    "width" => "'.$_POST["width"].'",
    "height" => "'.$_POST["height"].'",
	"colorDark" => "'.$_POST["colorDark"].'",
    "colorLight" => "'.$_POST["colorLight"].'"
);';
	@file_put_contents(EMLOG_ROOT.'/content/plugins/Dwz_content/Dwz_config.php', $newConfig);
}
?>