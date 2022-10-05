<?php 
/**
 * 阅读文章页面
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<div id="content">
	<!-- 内容页面log_content -->
	<article class="log_contet">
		<?php mianbao_sort($logid,$log_title);?>
		<div class="content_head">
			<h2 class="h2_title"><?php echo $log_title; ?></h2>
			<!-- 小图标/简介 -->
			<div class="article-meta">
				<span><i class="fa fa-calendar fa-fw"></i>日期:<?php echo gmdate('Y-n-j', $date); ?>&nbsp;</span>
				<span><i class="fa fa-user"></i><?php echo blog_author($author); ?>&nbsp;</span>
				<span><i class="fa fa-folder"></i><?php blog_sort($logid); ?>&nbsp;</span>
				<span><i class="fa fa-fire fa-comment"></i> 吐槽:<?php echo $comnum; ?>℃</span>
				<?php editflg($logid,$author); ?>
			</div>
		</div>
		<!-- 输出文章内容 -->
		<div class="content_body">
			<?php echo unCompress($log_content); ?>
		</div>
		<!-- 上下一篇文章 -->
		<div class="neigborhood">
			<?php 
				extract($neighborLog);
				if($prevLog){
					echo '<div class="prevlog">上一篇<br/><a href="'.Url::log($prevLog['gid']).'" title="'.$prevLog['title'].'">'.$prevLog['title'].'</a></div>';}
				else{
					echo '<div class="prevlog"><a href="#" title="没有上一篇了">没有上一篇了</a></div>';
				}
				if($nextLog){
					echo '<div class="nextlog">下一篇<br/><a href="'.Url::log($nextLog['gid']).'" title="'.$nextLog['title'].'">'.$nextLog['title'].'</a></div>';}
				else{
					echo '<div class="nextlog"><a href="#" title="没有下一篇了">没有下一篇了</a></div>';
				}
			?>
		</div>
		<!-- 文章标签 -->
		<div class="essay_tags">
			标签：<?php blog_tag($logid); ?>
		</div>
		<!-- 文章版权声明 -->
		<div class="post-copyright">
			版权声明：《 <a href="<?php echo Url::log($logid); ?>" title="<?php echo $log_title; ?>"><?php echo $log_title; ?></a> 》为<?php echo blog_author($author); ?>原创文章未经允许不得转载。
		</div>
		
		<!-- 点赞 -->
		<div class="like">
			
		</div>
		<!-- 作者信息 -->
		<div class="author_info">
			<blockquote style="padding:20px;margin:0px 0px 25px;border-left-width:6px;border-left-style:solid;border-left-color:#0c85ff;word-break:break-word;font-size:16px;line-height:30px;color:#2F2F2F;white-space:normal;background-color:#f7f9fa;"><div><img src="<?php echo author_head($author); ?>" width="50px" height="50px" style="float:left!important;margin:0px;"></div><p style="margin-left:40px;padding-left:15px;line-height:1.4;word-break:break-word;"><strong><i class="fa fa-user"></i>&nbsp;<?php author_name($author); ?></strong><br/><span style="color:#666;font-size: 14px;">&nbsp;作者签名：<?php echo htmlspecialchars(author_des($author)); ?></span></p></blockquote>
		</div>
		
		<!-- 底部 相关文章推荐 -->
		<div class="content_footer">
			<?php related_logs($logData);?>
		</div>
		<div style="clear:both;"></div>
	</article>
  	<!-- 熊掌号信息 -->
  	<?php if($config['xiongAppid']): ?>
	<script type="application/ld+json">
        {
            "@context": "https://ziyuan.baidu.com/contexts/cambrian.jsonld",
            "@id": "<?php echo Url::log($logid);?>",
            "appid": "<?php echo $config['xiongAppid']; ?>",
            "title": "<?php echo $log_title; ?>",
            "images": [ <?php echo getAllImg($log_content) ?> ],
            "description": "<?php echo $site_description; ?>",
            "pubDate": "<?php echo gmdate('Y-m-d\TH:i:s', $date);?>",
            "upDate": "<?php echo gmdate('Y-m-d\TH:i:s', $date);?>",
            "lrDate": "<?php echo gmdate('Y-m-d\TH:i:s', $date);?>"
        }
    </script>
	<?php endif; ?>

	<!-- 评论模块 -->
	<div class="comment_div">
		<?php blog_comments_post($logid,$ckname,$ckmail,$ckurl,$verifyCode,$allow_remark); ?>
		<?php blog_comments($comments); ?>
	</div>
<?php
 include View::getView('footer');
?>