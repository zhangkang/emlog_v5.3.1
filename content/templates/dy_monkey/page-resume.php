<?php 
/**
 * 自建页面模板
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<div id="content">	
	<!-- 内容页面log_content -->
	<article class="log_contet">
		<?php mianbao_sort($logid,$log_title);?>
		<div class="content_head">
			<h2 class="h2_title"><?php echo $log_title; ?></h2>
		</div>
		<!-- 输出文章内容 -->
		<div class="content_body">
			<?php echo unCompress($log_content); ?>
		</div>
		
		<div style="clear:both;"></div>
	</article>
	<!-- 评论模块 -->
	<div class="comment_div">
		
	</div>
<?php
 include View::getView('footer');
?>