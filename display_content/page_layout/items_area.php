<?php                
                
namespace Modules\display_content\page_layout;                
                
if (!defined('BACKEND')) exit;  //this file can't be accessed directly                
                
require_once(BASE_DIR.MODULE_DIR.'developer/std_mod/std_mod.php'); //include standard module to manage data records                
                
class ItemsArea extends \Modules\developer\std_mod\Area{  //extending standard data management module area                
                
  function __construct(){                 
    global $parametersMod;  //global object to get parameters                
                
    parent::__construct(                
      array(                
      'dbTable' => 'm_display_content_page_layout',  //table of data we need to manage                
      'title' => 'Page layout', //Table title above the table (choose any)                
      'dbPrimaryKey' => 'id',  //Primary key of that table                
      'searchable' => true,  //User will have search button or not                
      'orderBy' => 'row_number',  //Database field, by which the records should be ordered by default                
      'sortable' => true,  //Does user have a right to change the order of records                
      'sortField' => 'row_number'  //Database field which is used to sort records                
      )                    
    );                
    
    // Get list of available layouts 
    require_once(__DIR__.'/db.php');
    $templates = Db::getAvailableTemplates();
    
    sort($templates);
    $values = array();
    $values[] = array("", "");
    foreach($templates as $key => $template){
        $value = array();
        $value[] = $template;
        $value[] = $template;
        $values[] = $value;
    }

    // Put all retrieved layouts into a HTML selection          
    $element = new \Modules\developer\std_mod\ElementSelect(  //text field                
    array(                     
    'title' => 'Select',  //Field name                
    'showOnList' => true,  //Show field value in list of all records                
    'dbField' => 'title',  //Database field name                
    'required' => true, //true if this field is required            
    'searchable' => true,  //Allow to search by this field         
    'values' => $values //Values to choose       
    )                
    );                
    $this->addElement($element);   
                                      
    require_once(__DIR__.'/element_layouts.php');
    $element = new ElementPages(
            array (
                    'title' => $parametersMod->getValue('display_content', 'page_layout', 'translations', 'page_layout'),
                    'showOnList' => false,  //Show field value in list of all records
                    'previewLength' => 50,
                    'searchable' => false
            )
    );
    $this->addElement($element);
             
                    
  }                
                
}