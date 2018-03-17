<?php

use XoopsModules\Extgallery;

/**
 * @param $items
 *
 * @return bool
 */


function extgallery_tag_iteminfo(&$items)
{
    if (empty($items) || !is_array($items)) {
        return false;
    }

    $items_id = [];
    foreach (array_keys($items) as $cat_id) {
        foreach (array_keys($items[$cat_id]) as $item_id) {
            $items_id[] = (int)$item_id;
        }
    }

    /** @var Extgallery\PublicPhotoHandler $itemHandler */
    $itemHandler = Extgallery\Helper::getInstance()->getHandler('PublicPhoto');
    $items_obj   = $itemHandler->getObjects(new \Criteria('photo_id', '(' . implode(', ', $items_id) . ')', 'IN'), true);

    foreach (array_keys($items) as $cat_id) {
        foreach (array_keys($items[$cat_id]) as $item_id) {
            if (isset($items_obj[$item_id])) {
                $item_obj                 =& $items_obj[$item_id];
                $items[$cat_id][$item_id] = [
                    'title'   => $item_obj->getVar('photo_title'),
                    'uid'     => $item_obj->getVar('uid'),
                    'link'    => "public-photo.php?photoId={$item_id}#photoNav",
                    'time'    => $item_obj->getVar('photo_date'),
                    'tags'    => '',
                    'content' => ''
                ];
            }
        }
    }
    unset($items_obj);
}

/**
 * @param $mid
 */
function extgallery_tag_synchronization($mid)
{
    global $XoopsDB;
    /** @var Extgallery\PublicPhotoHandler $itemHandler */
    $itemHandler = Extgallery\Helper::getInstance()->getHandler('PublicPhoto');
    /** @var \TagLinkHandler $linkHandler */
    $linkHandler = \XoopsModules\Tag\Helper::getInstance()->getHandler('Link'); //@var \XoopsModules\Tag\Handler $tagHandler

    /* clear tag-item links */
    if (version_compare(mysqli_get_server_info($XoopsDB->conn), '4.1.0', 'ge')):

        $sql = "    DELETE FROM {$linkHandler->table}"
               . '    WHERE '
               . "        tag_modid = {$mid}"
               . '        AND '
               . '        ( tag_itemid NOT IN '
               . "            ( SELECT DISTINCT {$itemHandler->keyName} "
               . "                FROM {$itemHandler->table} "
               . "                WHERE {$itemHandler->table}.photo_approved > 0"
               . '            ) '
               . '        )'; else:
        $sql = "    DELETE {$linkHandler->table} FROM {$linkHandler->table}"
               . "    LEFT JOIN {$itemHandler->table} AS aa ON {$linkHandler->table}.tag_itemid = aa.{$itemHandler->keyName} "
               . '    WHERE '
               . "        tag_modid = {$mid}"
               . '        AND '
               . "        ( aa.{$itemHandler->keyName} IS NULL"
               . '            OR aa.photo_approved < 1'
               . '        )';
    endif;
    if (!$result = $linkHandler->db->queryF($sql)) {
        //xoops_error($linkHandler->db->error());
    }
}
