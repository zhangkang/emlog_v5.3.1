<?php
/**
 * Plugin Name: 点赞 打赏 分享
 * Version: 1.0
 * Plugin URL: http://www.liangge.top
 * Description: 在文章尾部添加 点赞 打赏 分享按钮。（PS:点赞使用的简爱文章点赞插件！）
 * Author: Liangge
 * Author Email: free5252@qq.com
 * Author URL: http://www.liangge.top
 * Date: 20150918
**/
!defined('EMLOG_ROOT') && exit('access deined!');
function plugin_setting_view(){
	require_once 'Liang_zsshare_config.php';
	?>
	<div class="com-hd">
		<b>文章点赞 打赏 分享插件设置</b>
		<?php
		if(isset($_GET['setting'])){
			echo "<span class='actived'>设置保存成功!</span>";
		}
		?>
	</div>
	<form action="plugin.php?plugin=Liang_zsshare&action=setting" method="post">
		<table class="tb-set">
			<tr>
				<td align="right"><b>支付宝收款人：</b></td>
				<td><input type="text" class="txt" name="zfbskr" value="<?php echo $Liang_zsshare_config["zfbskr"]; ?>" /></td>
				<td align="right"></td>
			</tr>
			<tr>
				<td align="right"><b>支付宝转账二维码：</b></td>
				<td><input type="text" class="txt" name="zfbpr" value="<?php echo $Liang_zsshare_config["zfbpr"]; ?>" /></td>
				<td align="right"></td>
			</tr>
			<tr>
				<td align="right"><b>微信转账二维码：</b></td>
				<td><input type="text" class="txt" name="wxpr" value="<?php echo $Liang_zsshare_config["wxpr"]; ?>" /></td>
				<td align="right"></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><input type="submit" name="submit" value="保存" />
				<td align="right"></td>
				</td>
			</tr>
		</table>
	</form>
</div>
	<?php
}
function plugin_setting(){
	require_once 'Liang_zsshare_config.php';
	$zfbskr = addslashes($_POST["zfbskr"]);
	$zfbpr = addslashes($_POST["zfbpr"]);
	$wxpr = addslashes($_POST["wxpr"]);
	$newConfig = '<?php
    $Liang_zsshare_config = array(
	"zfbskr" => "'.$zfbskr.'",
	"zfbpr" => "'.$zfbpr.'",
	"wxpr" => "'.$wxpr.'",
);';
	echo $newConfig;
	@file_put_contents(EMLOG_ROOT.'/content/plugins/Liang_zsshare/Liang_zsshare_config.php', $newConfig);
}
?>