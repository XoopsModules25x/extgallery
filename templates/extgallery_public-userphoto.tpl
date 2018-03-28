<div class="extgallery">
    <a title="<{$extgalleryName}>" href="<{xoAppUrl modules/extgallery/}>"><{$extgalleryName}></a> <img
            src="assets/images/breadcrumb-link.gif" alt="BreadCrumb"> <a
            href="<{xoAppUrl modules/extgallery/}>public-useralbum.php?id=<{$photo.user.uid}>"><{$lang.albumName}></a>
    <img src="assets/images/breadcrumb-link.gif"
         alt="BreadCrumb"> <{$photo.photo_title}>
    <table id="photoNav" class="outer">
        <tr>
            <td id="photoNavLeft" class="even"><{if $prevId != 0}><a
                    href="<{xoAppUrl modules/extgallery/}>public-userphoto.php?photoId=<{$prevId}>">&lt;
                    &lt; <{$lang.preview}></a><{else}>&nbsp;<{/if}>
            </td>
            <td id="photoNavCenter" class="even"><{$currentPhoto}> <{$lang.of}> <{$totalPhoto}></td>
            <td id="photoNavRight" class="even"><{if $nextId != 0}><a
                    href="<{xoAppUrl modules/extgallery/}>public-userphoto.php?photoId=<{$nextId}>"><{$lang.next}> >
                    ></a><{else}>&nbsp;<{/if}>
            </td>
        </tr>
    </table>

    <div id="photo">
        <{if $photo.photo_serveur}>
            <img src="<{$photo.photo_serveur}><{$photo.photo_name}>" alt="<{$photo.photo_title}>"
                 title="<{$photo.photo_title}>">
        <{else}>
            <img src="<{$xoops_url}>/uploads/extgallery/public-photo/medium/<{$photo.photo_name}>"
                 alt="<{$photo.photo_title}>" title="<{$photo.photo_title}>">
        <{/if}>
    </div>

    <{if $disp_ph_title == 1 }>
        <!-- Start Photo Title -->
        <div class="photoTitle"><h2><{$photo.photo_title}></h2></div>
        <!-- End Photo Title -->
    <{/if}>

    <!-- Start Photo desc -->
    <div class="photoDesc"><{$photo.photo_desc}></div>
    <!-- End Photo desc -->

    <{if $enableExtra}>
        <!-- Start extra field -->
        <div class="photoExtra"><{$photo.photo_extra}></div>
        <!-- End extra filed -->
    <{/if}>

    <!-- Start Admin link -->
    <{if $xoops_isadmin}>
        <div class="adminLink">
            <a title="edit" href="<{xoAppUrl modules/extgallery/}>public-modify.php?op=edit&id=<{$photo.photo_id}>"><img
                        src="assets/images/edit.png" alt="edit"></a>&nbsp;
            <a title="delete" href="<{xoAppUrl modules/extgallery/}>public-modify.php?op=delete&id=<{$photo.photo_id}>"><img
                        src="assets/images/delete.png" alt="delete"></a>
        </div>
    <{/if}>
    <!-- End Admin link -->

    <!-- Start XOOPS Tag -->
    <{if $tags}>
        <div class="tagbar"> <{include file="db:tag_bar.tpl"}></div>
    <{/if}>
    <!-- End XOOPS Tag -->

    <!-- Start Rating part -->
    <{if $canRate}>
        <table id="rateTable" class="outer">
            <tr>
                <th colspan="5"><{$lang.voteFor}></th>
            </tr>
            <tr>
                <td class="even"><a title="<{$lang.voteFor}> : 1"
                                    href="<{xoAppUrl modules/extgallery/}>public-rating.php?id=<{$photo.photo_id}>&amp;rate=1"><img
                                src="assets/images/rating_1.gif"
                                alt="<{$lang.voteFor}> : 1"
                                title="<{$lang.voteFor}> : 1"></a>
                </td>
                <td class="even"><a title="<{$lang.voteFor}> : 2"
                                    href="<{xoAppUrl modules/extgallery/}>public-rating.php?id=<{$photo.photo_id}>&amp;rate=2"><img
                                src="assets/images/rating_2.gif"
                                alt="<{$lang.voteFor}> : 2"
                                title="<{$lang.voteFor}> : 2"></a>
                </td>
                <td class="even"><a title="<{$lang.voteFor}> : 3"
                                    href="<{xoAppUrl modules/extgallery/}>public-rating.php?id=<{$photo.photo_id}>&amp;rate=3"><img
                                src="assets/images/rating_3.gif"
                                alt="<{$lang.voteFor}> : 3"
                                title="<{$lang.voteFor}> : 3"></a>
                </td>
                <td class="even"><a title="<{$lang.voteFor}> : 4"
                                    href="<{xoAppUrl modules/extgallery/}>public-rating.php?id=<{$photo.photo_id}>&amp;rate=4"><img
                                src="assets/images/rating_4.gif"
                                alt="<{$lang.voteFor}> : 4"
                                title="<{$lang.voteFor}> : 4"></a>
                </td>
                <td class="even"><a title="<{$lang.voteFor}> : 5"
                                    href="<{xoAppUrl modules/extgallery/}>public-rating.php?id=<{$photo.photo_id}>&amp;rate=5"><img
                                src="assets/images/rating_5.gif"
                                alt="<{$lang.voteFor}> : 5"
                                title="<{$lang.voteFor}> : 5"></a>
                </td>
            </tr>
        </table>
    <{/if}>
    <!-- End Rating part -->

    <!-- Start Photo Information -->
    <{if $enable_info}>
        <table class="outer">
            <tr>
                <th colspan="2"><{$lang.photoInfo}></th>
            </tr>
            <tr>
                <{if $enable_submitter_lnk}>
                    <td <{if !$enable_photo_hits}>colspan="2"<{/if}> class="even"><{$lang.submitter}> : <a
                                title="<{$photo.user.uname}>"
                                href="<{$xoops_url}>/userinfo.php?uid=<{$photo.user.uid}>"><{$photo.user.uname}></a>, <a
                                title="<{$lang.allPhotoBy}> <{$photo.user.uname}>"
                                href="<{xoAppUrl modules/extgallery/}>public-useralbum.php?id=<{$photo.user.uid}>"><{$lang.allPhotoBy}> <{$photo.user.uname}></a>
                    </td>
                <{/if}>
                <{if $enable_photo_hits}>
                    <td <{if !$enable_submitter_lnk}>colspan="2"<{/if}> class="even"><{$lang.view}>
                        : <{$photo.photo_hits}> <{$lang.hits}></td>
                <{/if}>
            </tr>
            <tr>
                <{if $enable_resolution}>
                    <td <{if !$enable_date}>colspan="2"<{/if}> class="even"><{$lang.resolution}>
                        : <{$photo.photo_res_x}> x <{$photo.photo_res_y}> <{$lang.pixels}><br><{$lang.fileSize}>
                        : <{$photo.photo_size}> Kb
                    </td>
                <{/if}>
                <{if $enable_date}>
                    <td <{if !$enable_resolution}>colspan="2"<{/if}> class="even"><{$lang.added}>
                        : <{$photo.photo_date}></td>
                <{/if}>
            </tr>
            <{if $canRate}>
                <tr>
                    <td class="even"><{$lang.score}> : <img src="assets/images/rating_<{$rating}>.gif" alt="rating">
                    </td>
                    <td class="even"><{$photo.photo_nbrating}> <{$lang.votes}></td>
                </tr>
            <{/if}>
            <{if $canDownload && $enable_download}>
                <tr>
                    <td class="even"><a title="<{$lang.downloadOrig}>"
                                        href="<{xoAppUrl modules/extgallery/}>public-download.php?id=<{$photo.photo_id}>"><{$lang.downloadOrig}>
                            <img
                                    src="assets/images/download.png" alt="<{$lang.downloadOrig}>"></a></td>
                    <td class="even"><{$photo.photo_download}> <{$lang.donwloads}></td>
                </tr>
            <{/if}>
            <{if $canSendEcard && $enable_ecards}>
                <tr>
                    <td class="even"><a title="<{$lang.sendEcard}>"
                                        href="<{xoAppUrl modules/extgallery/}>public-sendecard.php?id=<{$photo.photo_id}>"><{$lang.sendEcard}>
                            <img
                                    src="assets/images/mail_forward.png" alt="<{$lang.sendEcard}>"></a></td>
                    <td class="even"><{$photo.photo_ecard}> <{$lang.sends}></td>
                </tr>
            <{/if}>
        </table>
    <{/if}>
    <!-- End Photo Information -->

    <{if $show_rss}>
        <div id="rss">
            <a href="<{xoAppUrl modules/extgallery/public-rss.php}>" title="<{$smarty.const._MD_EXTGALLERY_RSS}>">
                <img src="<{xoAppUrl modules/extgallery/assets/images/feed.png}>"
                     alt="<{$smarty.const._MD_EXTGALLERY_RSS}>">
            </a>
        </div>
    <{/if}>

    <div class="txtcenter comments">
        <{$commentsnav}>
        <{$lang_notice}>
    </div>

    <div class="comments">
        <!-- start comments loop -->
        <{if $comment_mode == "flat"}>
            <{include file="db:system_comments_flat.tpl"}>
        <{elseif $comment_mode == "thread"}>
            <{include file="db:system_comments_thread.tpl"}>
        <{elseif $comment_mode == "nest"}>
            <{include file="db:system_comments_nest.tpl"}>
        <{/if}>
        <!-- end comments loop -->
    </div>

    <{include file='db:system_notification_select.tpl'}>
</div>
