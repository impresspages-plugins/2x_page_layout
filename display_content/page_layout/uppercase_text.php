<?php                
                
namespace Modules\display_content\page_layout;                
                
if (!defined('BACKEND')) exit;  //this file can't be accessed directly                
                
require_once(BASE_DIR.MODULE_DIR.'developer/std_mod/std_mod.php'); //include standard module to manage data records                
                
class UppercaseText extends \Modules\developer\std_mod\ElementText{  //extending standard text field
  
  
  
  
   /**
   * Return array of fields and values that need to be set on update or insert.
   * 
   * reutrn example:
   * array("name"=>"dbFieldName", "value"=>"Lorem ipsum")
   * 
   * @param string $action update or insert
   * @param string $prefix unique field name prefix
   * @param Area $area area class of currently editable table       
   * @return array of database key and value need to be inserted / updated    
   */    
  function getParameters($action, $prefix, $area){
    //$_REQUEST[''.$prefix] stores posted data
    if($action == 'insert'){
      if($this->visibleOnInsert && !$this->disabledOnInsert && $action == 'insert'){
        return array("name"=>$this->dbField, "value"=>mb_strtoupper($_REQUEST[''.$prefix]));
      }else{
        return array("name"=>$this->dbField, "value"=>mb_strtoupper($this->defaultValue));
      }
    }
    if($action == 'update'){
      if($this->visibleOnUpdate && !$this->disabledOnUpdate && $action == 'update'){
        return array("name"=>$this->dbField, "value"=>mb_strtoupper($_REQUEST[''.$prefix]));
      }
    }  
  }
  
  //extend other methods if you like.
  
  
}