<?php

/**
 * @package	ImpressPages
 * @copyright	Copyright (C) 2011 ImpressPages LTD.
 * @license	GNU/GPL, see ip_license.html
 */

namespace Modules\display_content\page_layout;

if (!defined('CMS'))
    exit;  //this file can't be acessed directly

class Db {





    /**
     * get associated images by language id
     * @param int $languageId
     * @return string image file in directory BASE_URL.IMAGE_DIR
     */
    public static function getLanguageImages($languageId = null) {
        global $site;

        if ($languageId == null) {
            $languageId = $site->getCurrentLanguage()->getId();
        }


        $sql = "
        SELECT
        title
        FROM
        " . DB_PREF . "m_display_content_page_layout i,
        " . DB_PREF . "m_display_content_page_layout_to_page itp
        WHERE
        i.id = itp.layoutId AND
        itp.languageId = '" . (int) $languageId . "' AND
        itp.zoneName IS NULL AND
        itp.pageId IS NULL
        ";

        $rs = mysql_query($sql);
        if (!$rs) {
            trigger_error("Can't find layout " . $sql . ' ' . mysql_error());
            return false;
        }

        $answer = array();
        while($lock = mysql_fetch_assoc($rs)) {
            $answer[] = $lock;
        }
        return $answer;
    }


    /**
     * get associated image by language id and zone name
     * @param int $languageId
     * @param string $zoneName
     * @return string image file in directory BASE_URL.IMAGE_DIR
     */
    public static function getZoneImages($languageId = null, $zoneName = null) {
        global $site;

        if ($languageId == null) {
            $languageId = $site->getCurrentLanguage()->getId();
        }

        if ($zoneName == null) {
            $zoneName = $site->getCurrentZone()->getName();
        }

        $sql = "
        SELECT
        title
        FROM
        " . DB_PREF . "m_display_content_page_layout i,
        " . DB_PREF . "m_display_content_page_layout_to_page itp
        WHERE
        i.id = itp.layoutId AND
        itp.languageId = '" . (int) $languageId . "' AND
        itp.zoneName = '" . mysql_real_escape_string($zoneName) . "' AND
        itp.pageId IS NULL
        ";

        $rs = mysql_query($sql);
        if (!$rs) {
            trigger_error("Can't find layout " . $sql . ' ' . mysql_error());
            return false;
        }

        $answer = array();
        while($lock = mysql_fetch_assoc($rs)) {
            $answer[] = $lock;
        }
        return $answer;
    }

    /**
     * Tries to find images starting from current (or specified) page elemnt and going up in breadcrumb.
     * @param Element $element
     * @return
     */
    public static function getBreadcrumbImages($element = null)
    {
        global $site;
        $breadcrumbPages = array_reverse($site->getBreadcrumb());
        
        foreach($breadcrumbPages as $breadcrumbPage) {
            $images = \Modules\display_content\page_layout\Db::getElementImages($breadcrumbPage);
            if ($images) {
                return $images;
            }
        }
        
        return array();
    }

    /**
     * get associated image by element (page)
     * @param Element $element
     * @return string image file in directory BASE_URL.IMAGE_DIR
     */
    public static function getElementImages($element = null) {
        global $site;

        if ($element == null) {
            $element = $site->getCurrentElement();
        }

        $sql = "
        SELECT
        title
        FROM
        " . DB_PREF . "m_display_content_page_layout i,
        " . DB_PREF . "m_display_content_page_layout_to_page itp
        WHERE
        i.id = itp.layoutId AND
        itp.zoneName = '" . mysql_real_escape_string($element->getZoneName()) . "' AND
        itp.pageId = " . (int) $element->getId() . "
        ";
        $rs = mysql_query($sql);
        if (!$rs) {
            trigger_error("Can't find layout " . $sql . ' ' . mysql_error());
            return false;
        }

        $answer = array();
        while($lock = mysql_fetch_assoc($rs)) {
            $answer[] = $lock;
        }
        return $answer;
    }



    public static function insertLanguageImage($languageId, $layoutId) {
        $sql = "
        INSERT INTO
        `" . DB_PREF . "m_display_content_page_layout_to_page`
        SET
        `layoutId` = " . (int) $layoutId . ",
        `languageId` = " . (int) $languageId . ",
        `zoneName` = NULL,
        `pageId` = NULL
         
        ";
        $rs = mysql_query($sql);
        if (!$rs) {
            trigger_error($sql . ' ' . mysql_error());
        }
    }

    public static function insertZoneImage($languageId, $zoneName, $imageId) {
        $sql = "
        INSERT INTO
        `" . DB_PREF . "m_display_content_page_layout_to_page`
        SET
        `layoutId` = " . (int) $imageId . ",
        `languageId` = " . (int) $languageId . ",
        `zoneName` = '" . mysql_real_escape_string($zoneName) . "',
        `pageId` = NULL
         
        ";
        $rs = mysql_query($sql);
        if (!$rs) {
            trigger_error($sql . ' ' . mysql_error());
        }
    }

    public static function insertPageImage($languageId, $zoneName, $pageId, $layoutId) {
        $sql = "
        INSERT INTO
        `" . DB_PREF . "m_display_content_page_layout_to_page`
        SET
        `layoutId` = " . (int) $layoutId . ",
        `languageId` = " . (int) $languageId . ",
        `zoneName` = '" . mysql_real_escape_string($zoneName) . "',
        `pageId` = " . (int) $pageId . "
         
        ";
        $rs = mysql_query($sql);
        if (!$rs) {
            trigger_error($sql . ' ' . mysql_error());
        }
    }
    
    public static function getAvailableTemplates(){
        $answer = array();
        if(is_dir(THEME_DIR.THEME)){
            $handle = opendir(THEME_DIR.THEME);
            if($handle !== false){
                while (false !== ($file = readdir($handle))) {
                    if(strtolower(substr($file, -4, 4)) == '.php' && file_exists(THEME_DIR.THEME.'/'.$file) && is_file(THEME_DIR.THEME.'/'.$file) && $file != '..' && $file != '.')
                    $answer[$file] = $file;
                }
                return $answer;
            }
        }
    }    
    

}