<?php
/*
* 主题自定义扩展功能实现
* author: DYBOY
*/


//URL规范化-SEO
function gf_url($id){
	if ($id){
		echo '<link rel="canonical" href="'.Url::log($id)."\" />";
	}
}

//页面源码压缩
function em_compress_html_main($buffer){
    $initial=strlen($buffer);
    $buffer=explode("<!--dy-html-->", $buffer);
    $count=count ($buffer);
    for ($i = 0; $i <= $count; $i++){
        if (stristr($buffer[$i], '<!--dy-html no compression-->')){
            $buffer[$i]=(str_replace("<!--dy-html no compression-->", " ", $buffer[$i]));
        }else{
            $buffer[$i]=(str_replace("\t", " ", $buffer[$i]));
            $buffer[$i]=(str_replace("\n\n", "\n", $buffer[$i]));
            $buffer[$i]=(str_replace("\n", "", $buffer[$i]));
            $buffer[$i]=(str_replace("\r", "", $buffer[$i]));
            while (stristr($buffer[$i], '  '))
            {
            $buffer[$i]=(str_replace("  ", " ", $buffer[$i]));
            }
        }
        $buffer_out.=$buffer[$i];
    }
    $final=strlen($buffer_out);
    $savings=($initial-$final)/$initial*100;
    $savings=round($savings, 2);
    $buffer_out.="<!--小东Tips:压缩前: $initial bytes; 压缩后: $final bytes; 节约：$savings% -->";
    return $buffer_out;
}

//内容页面PRE禁止压缩
function unCompress($content){
    if(preg_match_all('/(crayon-|<\/pre>)/i', $content, $matches)) {
        $content = '<!--dy-html--><!--dy-html no compression-->'.$content;
        $content.= '<!--dy-html no compression--><!--dy-html-->';
    }
    return $content;
}

//获取文章中图片数量
function pic_num($content){
    if(preg_match_all("/<img.*src=[\"'](.*)[\"']/Ui", $content, $img) && !empty($img[1])){
        $imgNum = count($img[1]);
    }else{
        $imgNum = "0";
    }
    return $imgNum;
}

//文章摘要回复可见输出处理 配合回复可见插件 下载地址：https://blog.dyboy.cn/develop/33.html
function tool_purecontent($content, $strlen = null){
    $content = str_replace('阅读全文&gt;&gt;', '', $content);
    $content = str_replace('&nbsp;','',$content); 
    $content = preg_replace("/[\r\n\t ]/i","",$content);
    $content = preg_replace("/\[cv\](.*)\[\/cv\]/Uims", '|*********此处内容回复可见*********|', strip_tags($content));
    $content = preg_replace("/\[lv\](.*)\[\/lv\]/Uims", '|******此处内容VIP用户登陆可见******|', strip_tags($content));
    if ($strlen) { $content = subString($content, 0,$strlen); }
    return $content;
}

//获取系统随机图片URL
function getrandomim(){ 
	$imgsrc = TEMPLATE_URL."img/random/".rand(1,35).".jpg";
	return $imgsrc; 
}

//获取对应文章的附件图片URL 暂时无用/原图质量太大不利于用户体验
function get_thum_annex($logid){
    $db = MySql::getInstance();
    $sqlimg = "SELECT * FROM ".DB_PREFIX."attachment WHERE blogid=".$logid." AND (`filepath` LIKE '%jpg' OR `filepath` LIKE '%gif' OR `filepath` LIKE '%png') ORDER BY `aid` ASC LIMIT 0,1";
	$img = $db->query($sqlimg);
    while($roww = $db->fetch_array($img)){
	 $thum_url=BLOG_URL.substr($roww['filepath'],3,strlen($roww['filepath']));
    }
    if (empty($thum_url)) {
            $thum_url = getrandomim();
        }
return $thum_url;
}

//从文章中获取缩略图URL
function GetThumFromContent($content){
	preg_match_all("|<img[^>]+src=\"([^>\"]+)\"?[^>]*>|is", $content, $img);
    $imgsrc = '';
	if(!empty($img[1])){ $imgsrc = $img[1][0]; } else{  $imgsrc =getrandomim(); }
	return $imgsrc;
}

//获取文章中所有图片链接，用于熊掌号，允许0,1,3张数量的图片
function getAllImg($content){
    preg_match_all("|<img[^>]+src=\"([^>\"]+)\"?[^>]*>|is", $content, $imgs);
    if(!empty($imgs[1])){
        $strArr = '';
        $imgNum = count($imgs[1]);
        if($imgNum >= 3){ $strArr = '"'.$imgs[1][0].'","'.$imgs[1][1].'","'.$imgs[1][2].'"'; }
        else{ $strArr = '"'.$imgs[1][0].'"'; }
        return $strArr;
    }
    else{
        // 没有图片
        return '"'.TEMPLATE_URL.'/img/noImgAll.jpg"';
    }
}

//代替file_getcontents();
function getContent($rs){
	$ch=curl_init($rs);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Chrome/55.0.2883.87 DYBOY');
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    $content=curl_exec($ch);
    curl_close($ch);
    return $content;
}

//返回当前页面URL
function blog_url(){
    $pageURL = 'http';
    if ($_SERVER["HTTPS"] == "on"){
        $pageURL .= "s";
    }
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80"){
        $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
    }else{
        $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    }
    return $pageURL;
}

//判断当前页面是否为首页
function blog_tool_ishome(){
    $self_domain = explode("/",BLOG_URL);
    if (($_SERVER['HTTP_HOST'].$_SERVER["REQUEST_URI"] == $self_domain[2]."/index.php") || ($_SERVER['HTTP_HOST'].$_SERVER["REQUEST_URI"] == $self_domain[2]."/") || ($_SERVER['HTTP_HOST'].$_SERVER["REQUEST_URI"]== $self_domain[2]."/?_pjax=%23monkey_pjax")){
        return TRUE;
    } else {
        return FALSE;
    }
}

//输出作者名字
function author_name($uid){
	global $CACHE;
	$user_cache = $CACHE->readCache('user');
	$author = $user_cache[$uid]['name'];
	echo '<a title="了解更多" href="'.BLOG_URL.'resume.html" >'.htmlspecialchars($author)."</a>";
}

//输出作者信息
function author_des($uid){
    global $CACHE;
    $user_cache = $CACHE->readCache('user');
    $des = $user_cache[$uid]['des'];
    if($des) return $des;
    else{
        return "这个家伙很懒什么也没说...";
    }
}

//输出作者头像URL
function author_head($uid){
    global $CACHE;
    $user_cache = $CACHE->readCache('user');
    if($user_cache[$uid]['photo']['src']){
        $head_url = BLOG_URL.$user_cache[$uid]['photo']['src'];
    }
    else{
        $head_url = BLOG_URL."content/templates/dy_monkey/img/noAvator.jpg";
    }
    return $head_url;
}

//翻页
function sheli_fy($count,$perlogs,$page,$url,$anchor=''){
    $pnums = @ceil($count / $perlogs);
    $page = @min($pnums,$page);
    $prepg=$page-1;                
    $nextpg=($page==$pnums ? 0 : $page+1); 
    $urlHome = preg_replace("|[\?&/][^\./\?&=]*page[=/\-]|","",$url);
    $re = "";
    if($pnums<=1) return false;
    if($page!=1) $re .=" <a href=\"$urlHome$anchor\">首页</a> "; 
    if($prepg) $re .=" <a href=\"$url$prepg$anchor\" >‹‹</a> ";
    for ($i = $page-2;$i <= $page+2 && $i <= $pnums; $i++){
    	if ($i > 0){
    		if ($i == $page){$re .= " <span class='page now-page'>$i</span> ";
    	}
    	elseif($i == 1){
    		$re .= " <a href=\"$urlHome$anchor\">$i</a> ";
    		}
    		else{
    			$re .= " <a href=\"$url$i$anchor\">$i</a> ";}
    		}
    }
    if($nextpg) $re .=" <a href=\"$url$nextpg$anchor\" class='nextpages'>››</a> "; 
    if($page!=$pnums) $re.=" <a href=\"$url$pnums$anchor\" title=\"尾页\">尾页</a>";
    return $re;
}

//相关文章推荐
function related_logs($logData = array())
{
    $related_log_type = 'sort';
    $related_log_sort = 'rand';
    $related_log_num = '6'; 
    $related_inrss = 'y'; 
    
    global $value;
    $DB = MySql::getInstance();
    $CACHE = Cache::getInstance();
    extract($logData);
    if($value)
    {
        global $abstract;
    }
    $sql = "SELECT gid,title FROM ".DB_PREFIX."blog WHERE hide='n' AND type='blog'";
    if($related_log_type == 'tag')
    {
        $log_cache_tags = $CACHE->readCache('logtags');
        $Tag_Model = new Tag_Model();
        $related_log_id_str = '0';
        foreach($log_cache_tags[$logid] as $key => $val)
        {
            $related_log_id_str .= ','.$Tag_Model->getTagByName($val['tagname']);
        }
        $sql .= " AND gid!=$logid AND gid IN ($related_log_id_str)";
    }else{
        $sql .= " AND gid!=$logid AND sortid=$sortid";
    }
    switch ($related_log_sort)
    {
        case 'views_desc':
        {
            $sql .= " ORDER BY views DESC";
            break;
        }
        case 'views_asc':
        {
            $sql .= " ORDER BY views ASC";
            break;
        }
        case 'comnum_desc':
        {
            $sql .= " ORDER BY comnum DESC";
            break;
        }
        case 'comnum_asc':
        {
            $sql .= " ORDER BY comnum ASC";
            break;
        }
        case 'rand':
        {
            $sql .= " ORDER BY rand()";
            break;
        }
    }
    $sql .= " LIMIT 0,$related_log_num";
    $related_logs = array();
    $query = $DB->query($sql);
    while($row = $DB->fetch_array($query))
    {
        $row['gid'] = intval($row['gid']);
        $row['title'] = htmlspecialchars($row['title']);
        $related_logs[] = $row;
    }
    $out = '';
    if(!empty($related_logs))
    {
        $out.='<div class="title"><h3>相关推荐:</h3></div>
<div class="relates"><ul>';
        foreach($related_logs as $val)
        {
            $out .= "<li><a href=\"".Url::log($val['gid'])."\">{$val['title']}</a></li>";
        }
        $out.='</ul></div>';
    }
    if(!empty($value['content']))
    {
        if($related_inrss == 'y')
        {
            $abstract .= $out;
        }
    }else{
        echo $out;
    }
}

//友情链接
function pages_links(){
    global $CACHE; 
    $link_cache = $CACHE->readCache('link');
    echo '<ul>';
    foreach($link_cache as $value): ?>
    <li><a href="<?php echo $value['url']; ?>?from=<?php echo BLOG_URL;?>" title="<?php echo $value['des']; ?>" target="_blank" rel="nofollow"><?php echo $value['link']; ?></a></li>
    <?php endforeach;
    echo "</ul>";
}

// 返回Gravtar头像
function myGravatar($email,$role='' ,$s = 50, $d = 'wavatar', $g = 'g') {
    if(!empty($role)){ return $role; }
    $hash = md5($email);
    $avatar = "https://dn-qiniu-avatar.qbox.me/avatar/$hash?s=$s&d=$d&r=$g";
    return $avatar;
}

//获取QQ头像
function getqqtx($qq){
    $url="//q.qlogo.cn/headimg_dl?dst_uin=$qq&spec=3";
    return $url;
}

//获取QQ信息
function getqqxx($qq,$role=''){if(!empty($role)){ return $role; }
    $ssud=explode("@",$qq,2);
    if($ssud[1]=='qq.com'){ return getqqtx($ssud[0]); }else{ return MyGravatar($qq,$role); }
}

if(isset($_POST['qq'])){
    if(!$_POST['qq']){
        echo "@@({comname:'请填写QQ号',commail:'请填写QQ号',comurl:'',toux:'https://q.qlogo.cn/headimg_dl?dst_uin=1099718640&spec=3'})@@";return ;
    }
    $spurl = "https://api.dyboy.cn/qqinfo/info.php?qq={$_POST['qq']}";
    $data = @getContent($spurl);
    $nc=explode('"',$data);
    $s=$nc[5];
    $bm=mb_convert_encoding($s,'UTF-8','UTF-8,GBK,GB2312,BIG5');
    if(empty($bm)){ echo "@@({comname:'QQ账号不存在',commail:'QQ账号不存在',comurl:'',toux:'https://q.qlogo.cn/headimg_dl?dst_uin=1099718640&spec=3'})@@"; }
    else{ echo "@@({comname:'{$bm}',commail:'{$_POST['qq']}@qq.com',comurl:'',toux:'https://q.qlogo.cn/headimg_dl?dst_uin={$_POST['qq']}&spec=3'})@@"; }
}

?>