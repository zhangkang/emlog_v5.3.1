<?php 
/**
 * 页面底部信息
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>

</div><!--end #content-->
</div><!-- end #wrap -->
</div><!-- end #monkey_pjax -->

<div style="clear:both;"></div>
<!-- top -->
<div id="to_top">
	TOP
</div>

<div id="footerbar">
	<!-- 请不要修改版权哦，尊重版权就是对作者最大的支持 DYBOY -->
	Powered by <a href="http://www.emlog.net" title="Emlog系统强力驱动">Emlog</a> | Theme：<span>Monkey</span> by <a href="https://blog.dyboy.cn">DYBOY</a>
	<br/><a href="http://www.beian.miit.gov.cn" rel="nofollow" target="_blank"><?php echo $icp; ?></a> <br/> <?php echo $footer_info; ?>
	<?php doAction('index_footer'); ?>
</div>

<!-- pjax 动画 -->
<div class="loading">
	<div id="loader"></div>
</div>

<script type="text/javascript" src="<?php echo TEMPLATE_URL; ?>js/jquery.swipebox.js"></script>
<script type="text/javascript" src="<?php echo TEMPLATE_URL; ?>js/main.js"></script>
<script type="text/javascript" src="<?php echo TEMPLATE_URL; ?>js/pjax.js"></script>

</body>
</html>
<?php $html=ob_get_contents();ob_get_clean();echo em_compress_html_main($html); ?>