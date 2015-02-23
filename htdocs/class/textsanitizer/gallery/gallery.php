<?php

class MytsGallery extends MyTextSanitizerExtension
{
    function encode($textarea_id)
    {
        xoops_loadLanguage('extention', 'extgallery'); 
    
        $code = "<img src='".XOOPS_URL."/modules/extgallery/images/extgallery-posticon.gif' alt='" . _EXT_EXTGALLERY_ALTWMP . "' onclick='xoopsCodeGallery(\"{$textarea_id}\", \""._EXT_EXTGALLERY_TEXTID."\", \""._EXT_EXTGALLERY_TEXTTITLE."\");'  onmouseover='style.cursor=\"hand\"'/>&nbsp;";
        $javascript = <<<EOH
            function xoopsCodeGallery(id, textId, photoTitle) {
                var selection = xoopsGetSelect(id);
                if (selection.length > 0) {
                    var text = selection;
                } else {
                    var text = prompt(textId, "");
                }
                if(text == null) {
                 return false;
                }
                var domobj = xoopsGetElementById(id);
                if ( text.length > 0 ) {
                    if(isNaN(text)) {
                     return false;
                    }
                    var title = prompt(photoTitle, "");
                    if(text != null && title.length > 0) {
                     title = " title='" + title + "'";
                    } else {
                     title = "";
                    }
                    var result = "[gallery" + title + "]" + parseInt(text,10) + "[/gallery]";
                    xoopsInsertText(domobj, result);
                }
                domobj.focus();
            }
EOH;
        return array($code, $javascript);
    }
    
    function load(&$ts) 
    {
        $ts->patterns[] = "/\[gallery]([0-9]*)\[\/gallery\]/sU";
        $ts->replacements[] = '<a href="'.XOOPS_URL.'/modules/extgallery/hook-photo.php?id=\\1" rel="lightbox"><img src="'.XOOPS_URL.'/modules/extgallery/hook-thumb.php?id=\\1" alt="" /></a>';

        $ts->patterns[] = "/\[gallery title=(['\"]?)([ a-zA-Z0-9]*)\\1]([0-9]*)\[\/gallery\]/sU";
        $ts->replacements[] = '<a href="'.XOOPS_URL.'/modules/extgallery/hook-photo.php?id=\\3" rel="lightbox" title="\\2" alt="\\2"><img src="'.XOOPS_URL.'/modules/extgallery/hook-thumb.php?id=\\3" alt="\\2" title="\\2" /></a>';

        $ts->patterns[] = "/\[gallery group=(['\"]?)([a-zA-Z0-9]*)\\1]([0-9]*)\[\/gallery\]/sU";
        $ts->replacements[] = '<a href="'.XOOPS_URL.'/modules/extgallery/hook-photo.php?id=\\3" rel="lightbox[\\2]"><img src="'.XOOPS_URL.'/modules/extgallery/hook-thumb.php?id=\\3" alt="" /></a>';

        $ts->patterns[] = "/\[gallery group=(['\"]?)([a-zA-Z0-9]*)\\1 title=(['\"]?)([ a-zA-Z0-9]*)\\3]([0-9]*)\[\/gallery\]/sU";
        $ts->replacements[] = '<a href="'.XOOPS_URL.'/modules/extgallery/hook-photo.php?id=\\5" rel="lightbox[\\2]" title="\\4" alt="\\4"><img src="'.XOOPS_URL.'/modules/extgallery/hook-thumb.php?id=\\5" title="\\4" alt="\\4" /></a>';

        $ts->patterns[] = "/\[gallery title=(['\"]?)([ a-zA-Z0-9]*)\\1 group=(['\"]?)([a-zA-Z0-9]*)\\3]([0-9]*)\[\/gallery\]/sU";
        $ts->replacements[] = '<a href="'.XOOPS_URL.'/modules/extgallery/hook-photo.php?id=\\5" rel="lightbox[\\4]" title="\\2" alt="\\2"><img src="'.XOOPS_URL.'/modules/extgallery/hook-thumb.php?id=\\5" title="\\2" alt="\\2" /></a>';
    }
    
}

?>