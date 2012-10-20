<?php                  
                  
namespace Modules\display_content\page_layout;                  
                  
if (!defined('CMS')) exit; //this file can't bee accessed directly                  
                  
class Install{                  
                  
  public function execute(){                  
                  
    $sql="                  
    CREATE TABLE IF NOT EXISTS `".DB_PREF."m_display_content_page_layout` (                  
      `id` int(11) NOT NULL AUTO_INCREMENT,                  
      `row_number` int(11) NOT NULL,                  
      `title` varchar(255) DEFAULT NULL,
	  `zoneName` varchar(50) DEFAULT NULL,
	  `pageId` varchar(50) DEFAULT NULL,                                 
      PRIMARY KEY (`id`)                  
    ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=121 ;                  
    ";                  
                      
    $rs = mysql_query($sql);                  
                      
    if(!$rs){                   
      trigger_error($sql." ".mysql_error());                  
    }     
    
   
    $sql="
    CREATE TABLE IF NOT EXISTS `".DB_PREF."m_display_content_page_layout_to_page` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `layoutId` int(11) NOT NULL,
    `languageId` int(11) NOT NULL,
    `zoneName` varchar(50) DEFAULT NULL,
    `pageId` varchar(50) DEFAULT NULL,
    PRIMARY KEY (`id`)
    ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

    ";

    $rs = mysql_query($sql);

    if(!$rs){
        trigger_error($sql." ".mysql_error());
    }             
                      
  }                  
}