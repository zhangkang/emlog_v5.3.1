<?php

!defined('EMLOG_ROOT') && exit('access deined!');

function callback_init() {
    $db = MySql::getInstance();
    $db->query("CREATE TABLE IF NOT EXISTS `".DB_PREFIX."markdown` (
      `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
      `logid` int(10) NOT NULL,
      `content` text NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");
}

function callback_rm() {

}