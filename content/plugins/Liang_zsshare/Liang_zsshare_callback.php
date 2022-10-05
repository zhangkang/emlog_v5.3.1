<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
function callback_init(){
  $DB = MySql::getInstance();
  if($DB->num_rows($DB->query("show columns from ".DB_PREFIX."blog like 'zsshare'")) == 0){
    $sql = "ALTER TABLE ".DB_PREFIX."blog ADD zsshare int unsigned NOT NULL DEFAULT '0'";
    $DB->query($sql);
  }
}