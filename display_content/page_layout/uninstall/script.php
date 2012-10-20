<?php             
             
namespace Modules\display_content\page_layout;             
             
if (!defined('CMS')) exit; //this file can't bee accessed directly             
             
class Uninstall{             
             
  public function execute(){             
             
    $sql = "DROP TABLE `".DB_PREF."m_display_content_page_layout` ";             
                 
    $rs = mysql_query($sql);             
                 
    if(!$rs){              
      trigger_error($sql." ".mysql_error());             
    } 
    
    $sql = "DROP TABLE `".DB_PREF."m_display_content_page_layout_to_page` ";             
                 
    $rs = mysql_query($sql);             
                 
    if(!$rs){              
      trigger_error($sql." ".mysql_error());             
    }                         
                 
  }             
}     
