<?php
/*
Plugin Name:文章版权
Version: 2.1
Plugin URL: http://eps.gs/jD
Description: 在文章底部添加版权(DWZ+QRCode)
Author: liming
Author Email: admin@likinming.com
Author URL: http://eps.gs
*/

!defined('EMLOG_ROOT') && exit('access deined!');
addAction('log_related', 'Dwz_content_f');

// 文章底部显示短链接版权
function Dwz_content_f($arr){
  include 'Dwz_config.php';
  $w = $config["width"];
  $h = $config["height"];
  $D = $config["colorDark"];
  $L = $config["colorLight"];
  $blogname = Option::get('blogname');
  //$url = BLOG_URL."?post=".$arr['logid'];
  $url = Url::log($arr['logid']);
  $nameurl=BLOG_URL;
  //$namedwz=$return=file_get_contents("http://eps.gs/api/make.php?url=$nameurl");
  //$resulta=json_decode($namedwz);
  //$nameurla=$resulta->url_short;
  $name = "<a style=\"color:red;\" href=\"".$nameurl."\">".$blogname."</a>";
  ?>
  <p>
     <form action="" id="mfp-form" style="height:0.1px;overflow:hidden"><input name="url" value="<?php echo $url ?>" id="url2" type="text"/></form>
  版权所有：《<?php echo $name; ?>》<br />
  文章标题：《<a href="<?php echo $url; ?>"><?php echo $arr['log_title'];  ?></a>》<br />
  除非注明，文章均为 《<?php echo $name; ?>》 原创<br />
  转载请注明本文短网址：<a href="<?php echo $url; ?>" id="urllink"><?php echo $url; ?></a>&nbsp;&nbsp;<a href="javascript:void(0)" style="color:red" onclick="get_duanwangzhi()" class="makeurl">[生成短网址]</a><br />
	<style>#qrcodeaa img{width:<?php echo $w.'px';?>;height:<?php echo $h.'px';?>;margin:0 auto;}</style>
<script type="text/jscript" src="http://eps.gs/api/js/qrcode.js"></script>
	<div id="qrcodeaa"></div>
  </p>
    <script>
      
    function get_duanwangzhi(){
        $(".makeurl").text("[Loading...]");
    	$.post("<?php echo $nameurl ?>content/plugins/Dwz_content/ajax.php",
    		{
    		"url":$("input[name='url']").val(),
    		},
    		function(data){
    			var s =data;
    			if(s)
    			{
    				$("#urllink").text(s);
    				$("#urllink").attr("href",s); 
    				$("#url2").attr("value",s); 
    				$(".makeurl").attr("onclick",'fuzhi()'); 
    				$(".makeurl").text("[复制短网址]");
                  	<?php if($config['qrcode']){echo "var qrcode = new QRCode(\"qrcodeaa\", {text: s,width: $w,height: $h,colorDark : \"$D\",colorLight : \"$L\",correctLevel : QRCode.CorrectLevel.H});";}?>
    			}
    		}
    	);
		
        return false;
    }
    function fuzhi(){
        var e=document.getElementById("url2");
        e.select();
        document.execCommand("Copy");
        alert("复制成功");  
    }
    </script>
  <?php
}

function Dwz_menu()
{
	echo '<div class="sidebarsubmenu" id="wxts"><a href="./plugin.php?plugin=Dwz_content">文章版权</a></div>';
}
addAction('adm_sidebar_ext', 'Dwz_menu');