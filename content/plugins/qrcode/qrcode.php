<?php defined('EMLOG_ROOT') or die('本页面禁止直接访问!');
/*
Plugin Name: 二维码
Version: 1.0.1
Plugin URL: http://www.piracy.cn
Description: 二维码
Author: 全能小白
Author URL: http://www.piracy.cn | http://www.zisei.com | http://www.ik6.net
*/
function qrcode(){
        echo "<script src='".BLOG_URL."content/plugins/qrcode/qrcode.js' type='text/javascript' /></script>";
        echo '<center><div id="qrcode"></div><center><script>window.onload =function(){var qrcode = new QRCode(document.getElementById("qrcode"), {width : 100,height : 100});thisURL = document.URL;qrcode.makeCode(thisURL);}</script>';
}
addAction('log_related','qrcode');
