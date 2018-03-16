<div class="extgallery">
    <a title="<{$extgalleryName}>" href="<{xoAppUrl modules/extgallery/}>"><{$extgalleryName}></a>

    <table class="outer">
        <tr>
            <th><{$lang.categoriesAlbums}></th>
            <th class="txtcenter"><{$lang.nbAlbums}></th>
            <th class="txtcenter"><{$lang.nbPhotos}></th>
        </tr>
        <{foreach item=child from=$cats}>
        <tr class="<{cycle values="even,odd"}>">
            <{if $child.cat_nb_album == 0}>
            <td colspan="2">
                <{else}>
            <td>
                <{/if}>

                <!-- Category/album image -->
                <{if $disp_cat_img == 1 }>
                    <{if $child.cat_imgurl != "" }>
                        <div class="catThumb">
                            <{if $child.cat_isalbum}>
                                <a title="<{$child.cat_name}>"
                                   href="<{xoAppUrl modules/extgallery/}>public-<{$display_type}>.php?id=<{$child.cat_id}>"><img
                                            src="<{$child.cat_imgurl}>"
                                            alt="<{$child.cat_name}>"
                                            title="<{$child.cat_name}>"></a>
                            <{else}>
                                <a title="<{$child.cat_name}>"
                                   href="<{xoAppUrl modules/extgallery/}>public-categories.php?id=<{$child.cat_id}>"><img
                                            src="<{$child.cat_imgurl}>"
                                            alt="<{$child.cat_name}>"
                                            title="<{$child.cat_name}>"></a>
                            <{/if}>
                        </div>
                    <{else}>
                        <{if $child.photo}>
                            <div class="catThumb">
                                <{if $child.cat_isalbum}>
                                    <a title="<{$child.cat_name}>"
                                       href="<{xoAppUrl modules/extgallery/}>public-<{$display_type}>.php?id=<{$child.cat_id}>"><img
                                                src="<{$xoops_url}>/uploads/extgallery/public-photo/thumb/thumb_<{$child.photo.photo_name}>"
                                                alt="<{$child.photo.photo_title}>"
                                                title="<{$child.photo.photo_title}>"></a>
                                <{else}>
                                    <a title="<{$child.cat_name}>"
                                       href="<{$extgalleryName}>public-categories.php?id=<{$child.cat_id}>"><img
                                                src="<{$xoops_url}>/uploads/extgallery/public-photo/thumb/thumb_<{$child.photo.photo_name}>"
                                                alt="<{$child.photo.photo_title}>"
                                                title="<{$child.photo.photo_title}>"></a>
                                <{/if}>
                            </div>
                        <{/if}>
                    <{/if}>
                <{else}>
                    <{if $child.photo}>
                        <div class="catThumb">
                            <{if $child.cat_isalbum}>
                                <a title="<{$child.cat_name}>"
                                   href="<{xoAppUrl modules/extgallery/}>public-<{$display_type}>.php?id=<{$child.cat_id}>"><img
                                            src="<{$xoops_url}>/uploads/extgallery/public-photo/thumb/thumb_<{$child.photo.photo_name}>"
                                            alt="<{$child.photo.photo_title}>"
                                            title="<{$child.photo.photo_title}>"></a>
                            <{else}>
                                <a title="<{$child.cat_name}>"
                                   href="<{xoAppUrl modules/extgallery/}>public-categories.php?id=<{$child.cat_id}>"><img
                                            src="<{$xoops_url}>/uploads/extgallery/public-photo/thumb/thumb_<{$child.photo.photo_name}>"
                                            alt="<{$child.photo.photo_title}>"
                                            title="<{$child.photo.photo_title}>"></a>
                            <{/if}>
                        </div>
                    <{/if}>
                <{/if}>

                <{if $child.cat_isalbum}>
                <h2><a title="<{$child.cat_name}>"
                       href="<{xoAppUrl modules/extgallery/}>public-<{$display_type}>.php?id=<{$child.cat_id}>"><{$child.cat_name}></a>
                </h2><br>
                <h3><{$child.cat_desc}></h3></td>
            <{else}>
            <h2><a title="<{$child.cat_name}>"
                   href="<{xoAppUrl modules/extgallery/}>public-categories.php?id=<{$child.cat_id}>"><{$child.cat_name}></a>
            </h2><br><h3><{$child.cat_desc}></h3></td>
            <{/if}>
            <{if $child.cat_nb_album != 0}>
                <td class="txtcenter"><{$child.cat_nb_album}></td>
            <{/if}>
            <td class="txtcenter"><{$child.cat_nb_photo}></td>
        </tr>
        <{/foreach}>
        <!--<tr class="even">
            <td><a href="user-categories.php">User categories</a><br>You can find here all user categories</td>
        </tr>-->
    </table>

     <{*pk ------------------- add upload and view-my-album links to main page*}>
    <div>
        <a title="<{$albumlinkname}>" href="<{xoAppUrl modules/extgallery/}><{$albumurl}>"><{$albumlinkname}></a> <br>
        <a title="<{$uploadlinkname}>" href="<{xoAppUrl modules/extgallery/}><{$uploadurl}>"><{$uploadlinkname}></a>

    </div>
     <{*end pk mod ------------------------------*}>


    <{if $show_rss}>
        <div id="rss">
            <a href="<{xoAppUrl modules/extgallery/public-rss.php}>" title="<{$smarty.const._MD_EXTGALLERY_RSS}>">
                <img src="<{xoAppUrl modules/extgallery/assets/images/feed.png}>"
                     alt="<{$smarty.const._MD_EXTGALLERY_RSS}>">
            </a>
        </div>
    <{/if}>

    <{include file='db:system_notification_select.tpl'}>
</div>
