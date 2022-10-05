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

liang_zsshare_init();
addAction('index_head', 'liang_zsshare_head');
addAction('index_footer', 'liang_zsshare_footer');
addAction('log_related', 'liang_zsshare_button');
addAction('adm_sidebar_ext', 'Liang_zsshare'); //菜单钩子

function liang_zsshare_head(){
  echo '<link href="'. BLOG_URL .'content/plugins/Liang_zsshare/Liang.popup.min.css" rel="stylesheet" type="text/css">';
  return;
}

function liang_zsshare_button($log) {
  echo liang_zsshare_insert($log);
}

function liang_zsshare_footer() {
  echo '<script type="text/javascript" src="'. BLOG_URL .'content/plugins/Liang_zsshare/liang_zsshare.js"></script>
  <script type="text/javascript" src="'. BLOG_URL .'content/plugins/Liang_zsshare/Liang.popup.min.js"></script>';
}

function liang_zsshare_init() {
  if( @$_POST['plugin'] == 'liang_zsshare' &&
      @$_POST['action'] == 'zsshare' &&
      isset($_POST['id']) ){
    $id = intval($_POST['id']);
    header("Access-Control-Allow-Origin: *");
    liang_zsshare_update($id);
    echo liang_zsshare_getNum($id);
    die;
  }
}

function liang_zsshare_insert($log) {
  require_once 'Liang_zsshare_config.php';
  if(!is_array($log)) $log = array('logid' => $log);
  return '<div id="social">
<div class="social-main">
<span class="like">
<a class="liang_zsshare" data-liang_zsshare="'. $log['logid'] .'" title="我赞"><i class="fa fa-thumbs-o-up"></i>&nbsp;赞 (<span>'. (isset($log['zsshare']) ? $log['zsshare'] : liang_zsshare_getNum($log['logid'])) .'</span>)</a>
</a>
<span class="shang-p">
<a data-dialog="#popup-shang" data-effect="effect-slide-top" title="赞助本站">赏</a>
</span>
<span class="share-s">
<a data-dialog="#popup-share" data-effect="effect-newspaper" title="分享"><i class="fa fa-share-alt"></i>&nbsp;分享</a>
</span>
<div class="clear"></div>
</div>
</div>
<div class="popup effect-fade-scale" id="popup-shang">
<div class="popup-content">
<p class="zanzhu">您可以选择一种方式赞助本站
<form target="_blank" method="POST" action="https://shenghuo.alipay.com/send/payment/fill.htm" accept-charset="GBK">
<input type="hidden" value="'.$Liang_zsshare_config["zfbskr"].'" name="optEmail">
<input type="hidden" value="10" name="payAmount">
<input id="title" type="hidden" value="赞助本站" name="title">
<input type="hidden" value="请填写您的联系方式，以便答谢！" name="memo">
<input type="image" value="赞助本站" src="http://i1.tietuku.com/39d52d451dc7221ds.png" width="280" height="100%" name="pay" title="赞助本站">
</form>支付宝转账赞助
<p><img width="280" height="280" src="'.$Liang_zsshare_config["zfbpr"].'" title="支付宝转账赞助" /></p>
<p><img width="280" height="280" src="'.$Liang_zsshare_config["wxpr"].'" title="微信转账赞助" /></p>
</p>
</div>
</div>
<div class="popup effect-fade-scale" id="popup-share">
<div class="popup-content">
<h3><i class="fa fa-share-alt"></i>分享到各大网站</h3>
<div class="bdsharebuttonbox"><a title="分享到QQ空间" href="#" class="bds_qzone" data-cmd="qzone"></a><a title="分享到新浪微博" href="#" class="bds_tsina" data-cmd="tsina"></a><a title="分享到腾讯微博" href="#" class="bds_tqq" data-cmd="tqq"></a><a title="分享到人人网" href="#" class="bds_renren" data-cmd="renren"></a><a title="分享到微信" href="#" class="bds_weixin" data-cmd="weixin"></a><a title="分享到开心网" href="#" class="bds_kaixin001" data-cmd="kaixin001"></a><a title="分享到腾讯朋友" href="#" class="bds_tqf" data-cmd="tqf"></a><a href="#" class="bds_more" data-cmd="more"></a></div>
</div>
</div>';
}

function Liang_zsshare(){ //子菜单钩子
	echo '<div class="sidebarsubmenu"><a href="./plugin.php?plugin=Liang_zsshare">赞赏分享管理</a></div>';
}

/*function callback_init(){
  $DB = MySql::getInstance();
  if($DB->num_rows($DB->query("show columns from ".DB_PREFIX."blog like 'zsshare'")) == 0){
    $sql = "ALTER TABLE ".DB_PREFIX."blog ADD zsshare int unsigned NOT NULL DEFAULT '0'";
    $DB->query($sql);
  }
}
callback_init();*/

function liang_zsshare_update($logid) {
  $DB = Database::getInstance();
  $DB->query("UPDATE " . DB_PREFIX . "blog SET zsshare=zsshare+1 WHERE gid=$logid");
  setcookie('liang_zsshare_'. $logid, 'true', time() + 31536000);
}

function liang_zsshare_getNum($logid) {
  static $arr = array();
  $DB = Database::getInstance();
  if(isset($arr[$logid])) return $arr[$logid];
  $sql = "SELECT zsshare FROM " . DB_PREFIX . "blog WHERE gid=$logid";
  $res = $DB->query($sql);
  $row = $DB->fetch_array($res);
  $arr[$logid] = intval($row['zsshare']);
  return $arr[$logid];
}
