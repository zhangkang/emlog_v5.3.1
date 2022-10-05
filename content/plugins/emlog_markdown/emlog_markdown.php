<?php
/*
Plugin Name: MarkDown for Emlog大前端
Version: 2.0
Plugin URL: http://blog.yesfree.pw
Description: 将emlog编辑器替换为markdown，方便写博客
Author: 小草
Author Email: 34109680@qq.com
Author URL: http://blog.yesfree.pw
*/
!defined('EMLOG_ROOT') && exit('access deined!');

// DO HOOK
addAction('adm_writelog_head', 'emlog_markdown');
//addAction('index_head', 'johnlui_markdown_css');

function emlog_markdown() {
  require 'emlog_markdown_html.php';
}
/**
 * 添加
 *
 * @param array $logData
 * @return int
 */
function emlog_markdown_add($logData) {
    $db = MySql::getInstance();
    $kItem = array();
    $dItem = array();
    foreach ($logData as $key => $data) {
        $kItem[] = $key;
        $dItem[] = $data;
    }
    $field = implode(',', $kItem);
    $values = "'" . implode("','", $dItem) . "'";
    $db->query("INSERT INTO " . DB_PREFIX . "markdown ($field) VALUES ($values)");
    $logid = $db->insert_id();
    return $logid;
}

/**
 * 更新
 *
 * @param array $logData
 * @param int $blogId
 */
function emlog_markdown_update($logData, $blogId) {
    $db = MySql::getInstance();
    $Item = array();
    foreach ($logData as $key => $data) {
        $Item[] = "$key='$data'";
    }
    $upStr = implode(',', $Item);
    $db->query("UPDATE " . DB_PREFIX . "markdown SET $upStr WHERE logid=$blogId");
}

function emlog_markdown_save_log($logid){
    $db = MySql::getInstance();
    $data = $db->query("SELECT * FROM ".DB_PREFIX."markdown WHERE logid ='$logid'");
    
    if($db->fetch_array($data) == ""){
        $logData = array('logid' => $logid,
                     'content' => $_POST["aaaaa-markdown-doc"]);
        emlog_markdown_add($logData);
    }else{
        $UplogData = array('content' => $_POST["aaaaa-markdown-doc"]);
        emlog_markdown_update($UplogData, $logid);
    }
    
}
addAction('save_log', 'emlog_markdown_save_log');

function johnlui_markdown_css() {
  //echo '<link rel="stylesheet" href="./content/plugins/johnlui_markdown/styles/markdown.css">';
}