<{if $jquery}>
    <{if $use_ajax_effects == lightbox}>
        <script type="text/javascript">
            $(function () {
                $('#gallery a').lightBox({
                    imageLoading: '<{xoAppUrl modules/extgallery/assets/images/lightbox/lightbox-ico-loading.gif}>',
                    imageBtnClose: '<{xoAppUrl modules/extgallery/assets/images/lightbox/lightbox-btn-close.gif}>',
                    imageBtnNext: '<{xoAppUrl modules/extgallery/assets/images/lightbox/lightbox-btn-next.gif}>',
                    imageBtnPrev: '<{xoAppUrl modules/extgallery/assets/images/lightbox/lightbox-btn-prev.gif}>',
                    imageBlank: '<{xoAppUrl modules/extgallery/assets/images/lightbox/lightbox-blank.gif}>'
                });
            });
        </script>
    <{/if}>
    <{if $use_ajax_effects == tooltip}>
        <style>#screenshot img {
                max-width: <{$album_tooltip_width}>px;
                border: <{$album_tooltip_borderwidth}>px solid <{$album_tooltip_bordercolor}>;
            }</style>
    <{/if}>
    <{if $use_ajax_effects == overlay}>
        <style>
            .apple_overlay {
                background-color: <{$album_overlay_bg}>;
                width: <{$album_overlay_width}>px !important;
                height: <{$album_overlay_height}>px !important;
            }

            .apple_overlay img {
                max-width: <{$album_overlay_width}>px !important;
                max-height: <{$album_overlay_height}>px !important;
            }
        </style>
    <{/if}>
    <{if $use_ajax_effects == fancybox}>
        <script type="text/javascript">
            $(document).ready(function () {
                <{if $album_fancybox_showtype == group }>
                $("a[rel=example_group]").fancybox({
                    <{else}>
                    $("a.example").fancybox({
                    <{/if}>
                    'overlayColor': '<{$album_fancybox_color}>',
                    'overlayOpacity': <{$album_fancybox_opacity}>,
                    'transitionIn': '<{$album_fancybox_tin}>',
                    'transitionOut': '<{$album_fancybox_tout}>',
                    'titlePosition': '<{$album_fancybox_title}>',
                    'titleFormat': function (title, currentArray, currentIndex, currentOpts) {
                        return '<span id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
                    }
                });
            })
        </script>
    <{/if}>
<{else}>
    <{if $use_ajax_effects == lightbox}>
        <script type="text/javascript"
                src="<{xoAppUrl browse.php?Frameworks/jquery/plugins/jquery.lightbox.js}>"></script>
        <link rel="stylesheet" type="text/css" href="<{xoAppUrl browse.php?modules/system/css/lightbox.css}>">
        <script type="text/javascript">
            $(function () {
                $('#gallery a').lightBox({
                    imageLoading: '<{xoAppUrl modules/extgallery/assets/images/lightbox/lightbox-ico-loading.gif}>',
                    imageBtnClose: '<{xoAppUrl modules/extgallery/assets/images/lightbox/lightbox-btn-close.gif}>',
                    imageBtnNext: '<{xoAppUrl modules/extgallery/assets/images/lightbox/lightbox-btn-next.gif}>',
                    imageBtnPrev: '<{xoAppUrl modules/extgallery/assets/images/lightbox/lightbox-btn-prev.gif}>',
                    imageBlank: '<{xoAppUrl modules/extgallery/assets/images/lightbox/lightbox-blank.gif}>'
                });
            });
        </script>
    <{/if}>
    <{if $use_ajax_effects == tooltip}>
        <script type="text/javascript"
                src="<{xoAppUrl browse.php?modules/extgallery/assets/js/tooltip/image.tooltip.js}>"></script>
        <link rel="stylesheet" type="text/css"
              href="<{xoAppUrl browse.php?modules/extgallery/assets/js/tooltip/image.tooltip.css}>">
        <style>#screenshot img {
                max-width: <{$album_tooltip_width}>px;
                border: <{$album_tooltip_borderwidth}>px solid <{$album_tooltip_bordercolor}>;
            }</style>
    <{/if}>
    <{if $use_ajax_effects == overlay}>
        <script type="text/javascript"
                src="<{xoAppUrl browse.php?modules/extgallery/assets/js/overlay/overlay.jquery.tools.min.js}>"></script>
        <link rel="stylesheet" type="text/css"
              href="<{xoAppUrl browse.php?modules/extgallery/assets/js/overlay/overlay.css}>" media="screen">
        <style>
            .apple_overlay {
                background-color: <{$album_overlay_bg}>;
                width: <{$album_overlay_width}>px !important;
                height: <{$album_overlay_height}>px !important;
            }

            .apple_overlay img {
                max-width: <{$album_overlay_width}>px !important;
                max-height: <{$album_overlay_height}>px !important;
            }
        </style>
    <{/if}>
    <{if $use_ajax_effects == fancybox}>
        <script type="text/javascript"
                src="<{xoAppUrl browse.php?modules/extgallery/assets/js/fancybox/mousewheel.js}>"></script>
        <script type="text/javascript"
                src="<{xoAppUrl browse.php?modules/extgallery/assets/js/fancybox/fancybox.pack.js}>"></script>
        <link rel="stylesheet" type="text/css"
              href="<{xoAppUrl browse.php?modules/extgallery/assets/js/fancybox/fancybox.css}>">
        <script type="text/javascript">
            $(document).ready(function () {
                <{if $album_fancybox_showtype == group }>
                $("a[rel=example_group]").fancybox({
                    <{else}>
                    $("a.example").fancybox({
                    <{/if}>
                    'overlayColor': '<{$album_fancybox_color}>',
                    'overlayOpacity': <{$album_fancybox_opacity}>,
                    'transitionIn': '<{$album_fancybox_tin}>',
                    'transitionOut': '<{$album_fancybox_tout}>',
                    'titlePosition': '<{$album_fancybox_title}>',
                    'titleFormat': function (title, currentArray, currentIndex, currentOpts) {
                        return '<span id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
                    }
                });
            })
        </script>
    <{/if}>
    <{if $use_ajax_effects == prettyphoto}>
        <script type="text/javascript"
                src="<{xoAppUrl browse.php?modules/extgallery/assets/js/prettyphoto/jquery.prettyPhoto.js}>"></script>
        <link rel="stylesheet" type="text/css"
              href="<{xoAppUrl browse.php?modules/extgallery/assets/js/prettyphoto/prettyPhoto.css}>">
    <{/if}>
<{/if}>

<div class="extgallery">
    <a title="<{$extgalleryName}>"
       href="<{xoAppUrl modules/extgallery/}>"><{$extgalleryName}></a><{foreach item=node from=$catPath name=breadcrumb}>
    <img src="assets/images/breadcrumb-link.gif"
         alt="BreadCrumb"> <a
            title="<{$node.cat_name}>"
            href="<{xoAppUrl modules/extgallery/}>public-categories.php?id=<{$node.cat_id}>"><{$node.cat_name}></a><{/foreach}>
    <img src="assets/images/breadcrumb-link.gif"
         alt="BreadCrumb"> <{$cat.cat_name}>
    <div class="center">
        <div class="bold"><{$extgallerySortbyOrderby}></div>
        <div class="margin-top10">
            <a href="<{xoAppUrl modules/extgallery/}>public-album.php?id=<{$extgalleryID}>&amp;start=<{$extgalleryStart}>&amp;sortby=photo_date&amp;orderby=DESC"
               title="<{$smarty.const._MD_EXTGALLERY_SORTDATEDESC}>"><img
                        src="<{xoAppUrl /modules/extgallery/assets/images/sort_up.png}>" width="16" height="16"
                        border="0" align="middle"
                        alt="<{$smarty.const._MD_EXTGALLERY_SORTDATEDESC}>"></a>
            <span class="smallsort"><{$smarty.const._MD_EXTGALLERY_SORTDATE}></span>
            <a href="<{xoAppUrl modules/extgallery/}>public-album.php?id=<{$extgalleryID}>&amp;start=<{$extgalleryStart}>&amp;sortby=photo_date&amp;orderby=ASC"
               title="<{$smarty.const._MD_EXTGALLERY_SORTDATEASC}>"><img
                        src="<{xoAppUrl /modules/extgallery/assets/images/sort_down.png}>" width="16" height="16"
                        border="0" align="middle"
                        alt="<{$smarty.const._MD_EXTGALLERY_SORTDATEASC}>"></a>&nbsp;
            <a href="<{xoAppUrl modules/extgallery/}>public-album.php?id=<{$extgalleryID}>&amp;start=<{$extgalleryStart}>&amp;sortby=photo_title&amp;orderby=ASC"
               title="<{$smarty.const._MD_EXTGALLERY_SORTNAMEASC}>"><img
                        src="<{xoAppUrl /modules/extgallery/assets/images/sort_up.png}>" width="16" height="16"
                        border="0" align="middle"
                        alt="<{$smarty.const._MD_EXTGALLERY_SORTNAMEASC}>"></a>
            <span class="smallsort"><{$smarty.const._MD_EXTGALLERY_SORTNAME}></span>
            <a href="<{xoAppUrl modules/extgallery/}>public-album.php?id=<{$extgalleryID}>&amp;start=<{$extgalleryStart}>&amp;sortby=photo_title&amp;orderby=DESC"
               title="<{$smarty.const._MD_EXTGALLERY_SORTNAMEDESC}>"><img
                        src="<{xoAppUrl /modules/extgallery/assets/images/sort_down.png}>" width="16" height="16"
                        border="0" align="middle"
                        alt="<{$smarty.const._MD_EXTGALLERY_SORTNAMEDESC}>"></a>&nbsp;
            <a href="<{xoAppUrl modules/extgallery/}>public-album.php?id=<{$extgalleryID}>&amp;start=<{$extgalleryStart}>&amp;sortby=photo_hits&amp;orderby=DESC"
               title="<{$smarty.const._MD_EXTGALLERY_SORTHITSDESC}>"><img
                        src="<{xoAppUrl /modules/extgallery/assets/images/sort_up.png}>" width="16" height="16"
                        border="0" align="middle"
                        alt="<{$smarty.const._MD_EXTGALLERY_SORTHITSDESC}>"></a>
            <span class="smallsort"><{$smarty.const._MD_EXTGALLERY_SORTHITS}></span>
            <a href="<{xoAppUrl modules/extgallery/}>public-album.php?id=<{$extgalleryID}>&amp;start=<{$extgalleryStart}>&amp;sortby=photo_hits&amp;orderby=ASC"
               title="<{$smarty.const._MD_EXTGALLERY_SORTHITSASC}>"><img
                        src="<{xoAppUrl /modules/extgallery/assets/images/sort_down.png}>" width="16" height="16"
                        border="0" align="middle"
                        alt="<{$smarty.const._MD_EXTGALLERY_SORTHITSASC}>"></a>&nbsp;
            <a href="<{xoAppUrl modules/extgallery/}>public-album.php?id=<{$extgalleryID}>&amp;start=<{$extgalleryStart}>&amp;sortby=photo_rating&amp;orderby=DESC"
               title="<{$smarty.const._MD_EXTGALLERY_SORTNOTEDESC}>"><img
                        src="<{xoAppUrl /modules/extgallery/assets/images/sort_up.png}>" width="16" height="16"
                        border="0" align="middle"
                        alt="<{$smarty.const._MD_EXTGALLERY_SORTNOTEDESC}>"></a>
            <span class="smallsort"><{$smarty.const._MD_EXTGALLERY_SORTNOTE}></span>
            <a href="<{xoAppUrl modules/extgallery/}>public-album.php?id=<{$extgalleryID}>&amp;start=<{$extgalleryStart}>&amp;sortby=photo_rating&amp;orderby=ASC"
               title="<{$smarty.const._MD_EXTGALLERY_SORTNOTEASC}>"><img
                        src="<{xoAppUrl /modules/extgallery/assets/images/sort_down.png}>" width="16" height="16"
                        border="0" align="middle"
                        alt="<{$smarty.const._MD_EXTGALLERY_SORTNOTEASC}>"></a>
        </div>
    </div>
    <div class="pageNav">
        <{$pageNav}>
    </div>
    <table id="thumbTable" class="outer">
        <tr>
            <th colspan="<{$nbColumn}>"><{$cat.cat_name}></th>
        </tr>
        <tr class="even">
            <{if $use_ajax_effects == prettyphoto}>
            <ul class="gallery clearfix">
                <{/if}>
                <{section name=photo loop=$photos}>
                <{if $smarty.section.photo.index % $nbColumn == 0 && !$smarty.section.photo.first}>
        </tr>
        <tr class="even">
            <{/if}>
            <td>
                <{if $photos[photo].photo_id}>

                    <!-- Start Admin link -->
                    <{if $xoops_isadmin}>
                        <div class="adminLink">
                            <a title="edit"
                               href="<{xoAppUrl modules/extgallery/}>public-modify.php?op=edit&id=<{$photos[photo].photo_id}>"><img
                                        src="assets/images/edit.png" alt="edit"></a>&nbsp;
                            <a title="delete"
                               href="<{xoAppUrl modules/extgallery/}>public-modify.php?op=delete&id=<{$photos[photo].photo_id}>"><img
                                        src="assets/images/delete.png" alt="delete"></a>
                        </div>
                    <{/if}>
                    <!-- End Admin link -->

                    <!-- Start Normal show -->
                    <{if $use_ajax_effects == none}>
                        <{if $photos[photo].photo_serveur && $photos[photo].photo_name}>
                            <a href="<{xoAppUrl modules/extgallery/}>public-photo.php?photoId=<{$photos[photo].photo_id}>"><img
                                        class="thumb"
                                        src="<{$photos[photo].photo_serveur}>thumb_<{$photos[photo].photo_name}>"
                                        alt="<{$photos[photo].photo_title}>"
                                        title="<{$photos[photo].photo_title}>"></a>
                        <{elseif $photos[photo].photo_name}>
                            <a href="<{xoAppUrl modules/extgallery/}>public-photo.php?photoId=<{$photos[photo].photo_id}>"><img
                                        class="thumb"
                                        src="<{$xoops_url}>/uploads/extgallery/public-photo/thumb/thumb_<{$photos[photo].photo_name}>"
                                        alt="<{$photos[photo].photo_title}>"
                                        title="<{$photos[photo].photo_title}>"></a>
                        <{/if}>
                    <{/if}>
                    <!-- End Normal show -->

                    <!-- Start Tooltip show -->
                    <{if $use_ajax_effects == tooltip}>
                        <{if $photos[photo].photo_serveur && $photos[photo].photo_name}>
                            <a class="screenshot"
                               href="<{xoAppUrl modules/extgallery/}>public-photo.php?photoId=<{$photos[photo].photo_id}>"
                               rel="<{$xoops_url}>/uploads/extgallery/public-photo/medium/<{$photos[photo].photo_name}>"><img
                                        class="thumb"
                                        src="<{$photos[photo].photo_serveur}>thumb_<{$photos[photo].photo_name}>"
                                        alt="<{$photos[photo].photo_title}>"
                                        title="<{$photos[photo].photo_title}>"></a>
                        <{elseif $photos[photo].photo_name}>
                            <a class="screenshot"
                               href="<{xoAppUrl modules/extgallery/}>public-photo.php?photoId=<{$photos[photo].photo_id}>"
                               rel="<{$xoops_url}>/uploads/extgallery/public-photo/medium/<{$photos[photo].photo_name}>"><img
                                        class="thumb"
                                        src="<{$xoops_url}>/uploads/extgallery/public-photo/thumb/thumb_<{$photos[photo].photo_name}>"
                                        alt="<{$photos[photo].photo_title}>"
                                        title="<{$photos[photo].photo_title}>"></a>
                        <{/if}>
                    <{/if}>
                    <!-- End Tooltip show -->

                    <!-- Start Lightbox -->
                    <{if $use_ajax_effects == lightbox}>
                        <div id="gallery">
                            <{if $photos[photo].photo_serveur && $photos[photo].photo_name}>
                                <a title="<{$photos[photo].photo_title}>"
                                   href="<{$xoops_url}>/uploads/extgallery/public-photo/medium/<{$photos[photo].photo_name}>"><img
                                            class="thumb"
                                            src="<{$photos[photo].photo_serveur}>thumb_<{$photos[photo].photo_name}>"
                                            alt="<{$photos[photo].photo_title}>"
                                            title="<{$photos[photo].photo_title}>"></a>
                            <{elseif $photos[photo].photo_name}>
                                <a title="<{$photos[photo].photo_title}>"
                                   href="<{$xoops_url}>/uploads/extgallery/public-photo/medium/<{$photos[photo].photo_name}>"><img
                                            class="thumb"
                                            src="<{$xoops_url}>/uploads/extgallery/public-photo/thumb/thumb_<{$photos[photo].photo_name}>"
                                            alt="<{$photos[photo].photo_title}>"
                                            title="<{$photos[photo].photo_title}>"></a>
                            <{/if}>
                        </div>
                    <{/if}>
                    <!-- End Lightbox -->

                    <!-- Start Overlay -->
                    <{if $use_ajax_effects == overlay}>
                        <div align="center" id="apple">
                            <{if $photos[photo].photo_serveur && $photos[photo].photo_name}>
                                <img rel="#photo<{$photos[photo].photo_id}>" class="thumb"
                                     src="<{$photos[photo].photo_serveur}>thumb_<{$photos[photo].photo_name}>"
                                     alt="<{$photos[photo].photo_title}>" title="<{$photos[photo].photo_title}>">
                            <{elseif $photos[photo].photo_name}>
                                <img rel="#photo<{$photos[photo].photo_id}>" class="thumb"
                                     src="<{$xoops_url}>/uploads/extgallery/public-photo/thumb/thumb_<{$photos[photo].photo_name}>"
                                     alt="<{$photos[photo].photo_title}>" title="<{$photos[photo].photo_title}>">
                            <{/if}>
                        </div>
                        <div class="apple_overlay" id="photo<{$photos[photo].photo_id}>"><a class="close"></a>
                            <img src="<{$xoops_url}>/uploads/extgallery/public-photo/medium/<{$photos[photo].photo_name}>">
                            <div class="details">
                                <{if $photos[photo].photo_serveur && $photos[photo].photo_name}>
                                    <div align="center"><a
                                                href="<{xoAppUrl modules/extgallery/}>public-photo.php?photoId=<{$photos[photo].photo_id}>"><{$photos[photo].photo_title}></a>
                                    </div>
                                <{elseif $photos[photo].photo_name}>
                                    <div align="center"><a
                                                href="<{xoAppUrl modules/extgallery/}>public-photo.php?photoId=<{$photos[photo].photo_id}>"><{$photos[photo].photo_title}></a>
                                    </div>
                                <{/if}>
                                <p><{$photos[photo].photo_desc}></p>
                            </div>
                        </div>
                    <{/if}>
                    <!-- End Overlay -->

                    <!-- Start Fansybox -->
                    <{if $use_ajax_effects == fancybox}>
                        <a <{if $album_fancybox_showtype == group }>rel="example_group" <{else}>class="example"<{/if}>
                           href="<{$xoops_url}>/uploads/extgallery/public-photo/medium/<{$photos[photo].photo_name}>"
                           title="<{$photos[photo].photo_title}>"><img class="last thumb"
                                                                       alt="<{$photos[photo].photo_title}>"
                                                                       src="<{$xoops_url}>/uploads/extgallery/public-photo/thumb/thumb_<{$photos[photo].photo_name}>"></a>
                    <{/if}>
                    <!-- End Fansybox -->

                    <!-- Start prettyPhoto show -->
                    <{if $use_ajax_effects == prettyphoto}>
                        <ul class="gallery clearfix">
                            <{if $photos[photo].photo_serveur && $photos[photo].photo_name}>
                                <li><a title="<{$photos[photo].photo_title}>"
                                       href="<{$xoops_url}>/uploads/extgallery/public-photo/medium/<{$photos[photo].photo_name}>"
                                       rel="prettyPhoto[gallery2]"><img class="thumb"
                                                                        src="<{$photos[photo].photo_serveur}>thumb_<{$photos[photo].photo_name}>"
                                                                        alt="<{$photos[photo].photo_title}>"></a></li>
                            <{elseif $photos[photo].photo_name}>
                                <li><a title="<{$photos[photo].photo_title}>"
                                       href="<{$xoops_url}>/uploads/extgallery/public-photo/medium/<{$photos[photo].photo_name}>"
                                       rel="prettyPhoto[gallery2]"><img class="thumb"
                                                                        src="<{$xoops_url}>/uploads/extgallery/public-photo/thumb/thumb_<{$photos[photo].photo_name}>"
                                                                        alt="<{$photos[photo].photo_title}>"></a></li>
                            <{/if}>
                        </ul>
                    <{/if}>
                    <!-- End prettyPhoto show -->

                    <{if $enable_info}>

                        <!-- Photo Title -->
                        <{if $disp_ph_title == 1 }>
                            <div class="PhotoTitle"><h2><a
                                            href="<{xoAppUrl modules/extgallery/}>public-photo.php?photoId=<{$photos[photo].photo_id}>"><{$photos[photo].photo_title}></a>
                                </h2></div>
                        <{/if}>

                        <!-- Start Hit count -->
                        <{if $enable_photo_hits}>
                            <div class="photoHit"><h5><{$photos[photo].photo_hits}> <{$lang.hits}></h5></div>
                        <{/if}>
                        <!-- End Hit count -->

                        <!-- Start Comment count -->
                        <{if $enable_show_comments}>
                            <div class="photoComment"><h5><{$photos[photo].photo_comment}> <{$lang.comments}></h5></div>
                        <{/if}>
                        <!-- End Comment count -->

                        <!-- Start photo date -->
                        <{if $enable_date}>
                            <div class="photoDate">
                                <h5><{$smarty.const._MD_EXTGALLERY_INFODATE}> <{$photos[photo].photo_date}></h5></div>
                        <{/if}>
                        <!-- End photo date -->

                        <!-- Start Submitter link -->
                        <{if $enable_submitter_lnk}>
                            <div class="photoSubmitter"><h4><a title="<{$photos[photo].user.uname}>"
                                                               href="<{$xoops_url}>/userinfo.php?uid=<{$photos[photo].user.uid}>"><{$photos[photo].user.uname}></a>
                                </h4></div>
                        <{/if}>
                        <!-- End Submitter link -->

                        <{if $enableRating}>
                            <!-- Start Rating score -->
                            <div class="photoRating"><img
                                        src="<{xoAppUrl modules/extgallery/}>assets/images/rating_<{$photos[photo].photo_rating}>.gif"
                                        alt="<{$lang.rate_score}> : <{$photos[photo].photo_rating}>"
                                        title="<{$lang.rate_score}>"></div>
                            <!-- End Rating score -->
                        <{/if}>

                        <{if $enableExtra}>
                            <!-- Start extra field -->
                            <div class="photoExtra"><{$photos[photo].photo_extra}></div>
                            <!-- End extra filed -->
                        <{/if}>

                    <{/if}>

                    <{foreach item=pluginLink from=$photos[photo].link}>
                    <a href="<{$pluginLink.link}><{$photos[photo].photo_id}>"
                       title="<{$pluginLink.name}>"><{$pluginLink.name}></a>
                <{/foreach}>

                    <!-- Start Displaying Hook code -->
                    <!--            <{if $xoops_isadmin}>
                    <div class=""> <input type="text" value='[gallery title="<{$photos[photo].photo_title}>"]<{$photos[photo].photo_id}>[/gallery]' ></div>
                <{/if}>
    -->
                    <!-- End Displaying Hook code -->
                <{/if}>
            </td>
            <{/section}>
            <{if $use_ajax_effects == prettyphoto}>
                </ul>
            <{/if}>
        </tr>
    </table>
    <div class="pageNav">
        <{$pageNav}>
    </div>

    <{if $show_rss}>
        <div id="rss">
            <a href="<{xoAppUrl modules/extgallery/public-rss.php?id=}><{$extgalleryID}>"
               title="<{$smarty.const._MD_EXTGALLERY_ALBUMRSS}>">
                <img src="<{xoAppUrl modules/extgallery/assets/images/feedblue.png}>"
                     alt="<{$smarty.const._MD_EXTGALLERY_ALBUMRSS}>">
            </a>
            <a href="<{xoAppUrl modules/extgallery/public-rss.php}>" title="<{$smarty.const._MD_EXTGALLERY_RSS}>">
                <img src="<{xoAppUrl modules/extgallery/assets/images/feed.png}>"
                     alt="<{$smarty.const._MD_EXTGALLERY_RSS}>">
            </a>
        </div>
    <{/if}>

    <{include file='db:system_notification_select.tpl'}>
</div>

<{if $use_ajax_effects == overlay}>
    <script type="text/javascript">
        $(function () {
            $("#apple img[rel]").overlay({effect: 'apple'});
        });
    </script>
<{/if}>

<{if $use_ajax_effects == prettyphoto}>
    <script type="text/javascript" charset="utf-8">
        $(document).ready(function () {
            $(".gallery:gt(0) a[rel^='prettyPhoto']").prettyPhoto({
                animationSpeed: '<{$album_prettyphoto_speed}>',
                theme: '<{$album_prettyphoto_theme}>',
                slideshow:<{$album_prettyphoto_slidspeed}>,
                autoplay_slideshow: <{$album_prettyphoto_autoplay}>});
        });
    </script>
<{/if}>
