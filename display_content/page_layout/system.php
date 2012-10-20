<?php
/**
 * @package ImpressPages
 * @copyright   Copyright (C) 2011 ImpressPages LTD.
 * @license GNU/GPL, see ip_license.html
 */
namespace Modules\display_content\page_layout;

if (!defined('CMS')) exit; //restrict direct access to file

class System
{

    function init()
    {
        global $site;

        if ($site->getCurrentElement()) {

            //get layout, associated to current language
            require_once(BASE_DIR . PLUGIN_DIR . 'display_content/page_layout/db.php');
            $layouts = \Modules\display_content\page_layout\Db::getElementImages();
            if (empty($layouts)) {
                $layouts = \Modules\display_content\page_layout\Db::getZoneImages();
            }
            if (empty($layouts)) {
                $layouts = \Modules\display_content\page_layout\Db::getLanguageImages();
            }


            // If there is a layout configured for this language/zone/element
            if (!empty($layouts)) {
                foreach ($layouts as $key => $layout) {
                    $site->getCurrentZone()->setLayout($layout['title']);
                }
            }
        }
    }

}

?>