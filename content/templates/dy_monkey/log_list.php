<?php 
/**
 * 站点首页模板
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<div id="content">
<?php doAction('index_loglist_top'); ?>
<?php 
if (!empty($logs)){
			if(blog_tool_ishome() && empty($keyword)) {
				;
			}
			if(!empty($sort)) {
				$des = $sort['description']?$sort['description']:'这家伙很懒，还没填写该栏目的介绍呢~';
				echo '<div class="content_catag_container"><h2 class="content_catag_title isKeywords font_title">'.$sortName.'</h2><p>'.$des.'</p></div>';
			}
			if(!empty($record)) {
				$year    = substr($record,0,4);
				$month   = ltrim(substr($record,4,2),'0');
				$day     = substr($record,6,2);
				$archive = $day?$year.'年'.$month.'月'.ltrim($day,'0').'日':$year.'年'.$month.'月';
				echo '<div class="content_catag_container"><h2 class="content_catag_title isKeywords font_title">日志归档</h2><p>'.$archive.'发布的文章</p></div>';
			}
			if(!empty($author_name)) {			
				echo '<div class="content_catag_container"><h2 class="content_catag_title isKeywords font_title">作者</h2><p>本站作者<strong>'.$author_name.'</strong> 共计发布文章'.$lognum.'篇</p></div>';
			}
			if(!empty($keyword)) {
				echo '<div class="content_catag_container"><h2 class="content_catag_title isKeywords font_title">站内搜索</h2><p>本次搜索帮您找到有关 <strong>'.$keyword.'</strong> 的结果'.$lognum.'条</p></div>';
			}
			if(!empty($tag)) {
				echo '<div class="content_catag_container"><h2 class="content_catag_title isKeywords font_title">标签关键词</h2><p>关于 <strong>'.$tag.'</strong> 的文章共有'.$lognum.'条</p></div>';
			}
			else{
				//echo '<div class="content_catag_container"><h2 class="content_catag_title isKeywords font_title">未找到</h2><p> <strong>啥都木有</strong></p></div>';
			}
		}
?>
<?php 
if (!empty($logs)):
foreach($logs as $value): 
?>
<!-- card -->

<?php
//$flag == 文章图片数量
$flag = pic_num($value['content']);
?>
	<div class="animated fadeInUp">
		<div class="card_box">
			<a href="<?php echo $value['log_url']; ?>" class="noview">
				<img src="<?php if($flag){ echo GetThumFromContent($value['content']); }else{ echo getrandomim(); } ?>" class="card_img" />
			</a>
			<span class="sort_tag"><?php blog_sort($value['logid']); ?></span>
			<div class="card_body">
				<a class="card_title" href="<?php echo $value['log_url']; ?>"><?php echo $value['log_title']; ?></a>
				<p class="card_line"></p>
				<p class="line_colors"></p>
				<p class="description"><?php echo tool_purecontent($value['log_description']); ?></p>
			</div>
			<div class="card_footer">
				<span class="author"><img class="user_head img_rotate" src="<?php echo author_head($value['author']); ?>"><?php author_name($value['author']); ?> </span>
				<span class="data"><i class="fa fa-clock-o"></i><?php echo gmdate('Y-n-j', $value['date']); ?> </span>
				<span class="view"><i class="fa fa-eye"></i><?php echo $value['views']; ?></span>
				<span class="readmore_diy"><a href="<?php echo $value['log_url']; ?>">阅读全文<i class="fa fa-chevron-circle-right"></i></a></span>
			</div>
		</div>
	</div>
<?php 
endforeach;
else:
?>
	<h2>未找到</h2>
	<p>抱歉，没有符合您查询条件的结果。</p>
<?php endif;?>


<div class="pagenavi"><ul><?php echo sheli_fy($lognum,$index_lognum,$page,$pageurl);?></ul></div>

<div class="friend_links">
	<h4 class="friend_h4">
		友情链接
		<a class="friend_sub" href="https://wpa.qq.com/msgrd?v=3&uin=<?php echo $config['qq'];?>&site=qq&menu=yes" target="_blank">申请友链 <i class="fa fa-location-arrow"></i></a>
	</h4>
		<?php pages_links();?>
</div>
<?php
 include View::getView('footer');
?>