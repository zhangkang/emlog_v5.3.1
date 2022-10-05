<?php
/*
Plugin Name: 百度熊掌号集成+推送
Version: 1.06
Time: 2019-3-24 00:03:25
Plugin URL: https://blog.dyboy.cn/develop/115.html
Description: Emlog用户百度熊掌号自动推送，一键配置，无需大量修改代码，只需在模版中添加挂载点即可，方便所有站长使用！
Author: DYBOY
Author URL: https://blog.dyboy.cn
*/

!defined('EMLOG_ROOT') && exit('error');
define('BAIDU_XZ_ROOT',EMLOG_ROOT.'/content/plugins/baidu_xz/');
date_default_timezone_set('Asia/Shanghai'); 


/*
*	插入后台导航侧边栏
*/
function baidu_xz_menu(){
	echo '<div class="sidebarsubmenu"><a href="./plugin.php?plugin=baidu_xz">百度熊掌号</a></div>';
}


/*
*	在头部插入脚本及URL唯一化信息
*/
function baidu_xz_head($logid){
	if($logid){
		include 'baidu_xz_config.php';
		echo '<link rel="canonical" href="'.Url::log($logid).'" />
		<script src="//msite.baidu.com/sdk/c.js?appid='.$config['X_Appid'].'"></script>';
	}
}

/*
*	判断是否为文章首页
*/
function isHomePage(){
	if (BLOG_URL . trim(Dispatcher::setPath(), '/') == BLOG_URL){  
		return true;
	} else { 
		return FALSE;
	}
}

/*
*	测试输出
*/
function test_echo($msg){
	echo $msg;
}

/*
*	文章页插入推送文章的信息
*/
function baidu_xz_log($logid, $log_title, $log_content, $date){
	if($logid){
		include 'baidu_xz_config.php';
		$htmlStr = '<script type="application/ld+json">
		        {
		            "@context": "https://ziyuan.baidu.com/contexts/cambrian.jsonld",
		            "@id": "'.Url::log($logid).'",
		            "appid": "'.$config['X_Appid'].'",
		            "title": "'.$log_title.'",
		            "images": [ '.getAllImg($log_content).' ],
		            "description": "'.logAbstract($log_content).'",
		            "pubDate": "'.gmdate('Y-m-d\TH:i:s', $date).'",
		            "upDate": "'.gmdate('Y-m-d\TH:i:s', $date).'",
		            "lrDate": "'.gmdate('Y-m-d\TH:i:s', $date).'"
		        }
		    </script>';
		echo $htmlStr;
	}
}

/*
*	文章自动摘要
*/
function logAbstract($content){
	$content = strip_tags($content);
	$pattern = '/\s/';//去除空白
	$content = preg_replace($pattern, '', $content);  
	return mb_substr($content, 0, 108,"UTF-8");
}

/*
*	获取文章中所有图片链接，用于熊掌号，允许0,1,3张数量的图片
*/
function getAllImg($content){
    preg_match_all("|<img[^>]+src=\"([^>\"]+)\"?[^>]*>|is", $content, $imgs);
    if(!empty($imgs[1])) {
        $strArr = '';
        $imgNum = count($imgs[1]);
        if($imgNum >= 3){ $strArr = '"'.$imgs[1][0].'","'.$imgs[1][1].'","'.$imgs[1][2].'"'; }
        else{ $strArr = '"'.$imgs[1][0].'"'; }
        return $strArr;
    } else {
        // 没有图片
        return '"'.BLOG_URL.'content/plugins/baidu_xz/img/noImgAll.jpg"';
    }
}

/*
*	创建数据表如果不存在
*/
function createTable($db){
	$createsql = 'CREATE TABLE IF NOT EXISTS `emlog_xiongzhang` (
	`id`  int UNSIGNED NOT NULL AUTO_INCREMENT ,
	`link`  varchar(255) NOT NULL ,
	`uptime`  datetime NOT NULL ,
	`status`  varchar(255) NOT NULL ,
	`type`  varchar(255) NOT NULL ,
	PRIMARY KEY (`id`)
	)';
	$db->query($createsql);
}


/*
*	推送功能
*/
function sendBaidu($urls,$id, $token, $type){
	$type = ($type==1)?'realtime':'batch';
	$api = 'http://data.zz.baidu.com/urls?appid='.$id.'&token='.$token.'&type='.$type;
	$ch = curl_init();
	$options =  array(
	    CURLOPT_URL => $api,
	    CURLOPT_POST => true,
	    CURLOPT_RETURNTRANSFER => true,
	    CURLOPT_POSTFIELDS =>  $urls,
	    CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
	);
	curl_setopt_array($ch, $options);
	$result = curl_exec($ch);
	return $result;
}

/*
*	自动推送保存部分
*/
function baidu_xz_main($logid){
	include 'baidu_xz_config.php';
	$DB = MySqlii::getInstance();
	// createTable($DB);
	$log_model = new  Log_Model();
	$log = $log_model->getOneLogForAdmin($logid);
	$now_url = Url::log($logid);

	//检查是否存在
	$sql = 'SELECT * FROM emlog_xiongzhang WHERE link="'.$now_url.'" LIMIT 0,1';
	$result = mysqli_fetch_assoc($DB->query($sql));
	if($result['link']==''){
		$type = $config['X_Type'];
		if($config["X_Appid"] && $config["X_Token"]){
			// 如果结果为空，，并执行上传操作,再插入数据
			$insertSql = '';	//插入执行的SQL语句
			if($config["X_Type"] == '1') {
				//天级收录
				$jsonData = json_decode(sendBaidu($now_url, $config["X_Appid"], $config["X_Token"], 1), true);
				$tipMsg = '提交成功';
				if($jsonData['message']){
					//提交成功
					$tipMsg = $jsonData['message'];
				}
				//插入数据库
				$insertSql = 'INSERT INTO emlog_xiongzhang (link, uptime, status, type) VALUES ("'.$now_url.'","'.date("Y-m-d H:i:s").'","'.$tipMsg.'","'.(($type=='1')?"天级收录":"周级收录").'")';
			}
			else{
				// 周级收录
				$jsonData = json_decode(sendBaidu($now_url, $config["X_Appid"], $config["X_Token"], 0), true);
				$tipMsg = '提交成功';
				if($jsonData['message']){
					$tipMsg = $jsonData['message'];
				}
				$insertSql = 'INSERT INTO emlog_xiongzhang (link, uptime, status, type) VALUES ("'.$now_url.'","'.date("Y-m-d H:i:s").'","'.$tipMsg.'","'.(($type=='1')?"天级收录":"周级收录").'")';
			}
			$DB->query($insertSql);
		}
		else{
			$tipMsg = "配置信息错误";
			$errorSql = 'INSERT INTO emlog_xiongzhang (link, uptime, status, type) VALUES ("'.$now_url.'","'.date("Y-m-d H:i:s").'","'.$tipMsg.'","'.(($type=='1')?"天级收录":"周级收录").'")';
			$DB->query($errorSql);
		}
	}
}

addAction('adm_sidebar_ext', 'baidu_xz_menu');		// 插入导航侧边栏
addAction('save_log','baidu_xz_main');				// 保存文章时候发布
addAction('baidu_xz_echo', 'baidu_xz_head');		// 插入head
addAction('baidu_xz_echo', 'baidu_xz_log');			// 插入文章页

?>