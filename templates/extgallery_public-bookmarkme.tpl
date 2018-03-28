<{if $show_social_book != 0}>

    <{if $show_social_book == 1 || $show_social_book == 3}>
        <div class="socialnetwork">
            <ul>
                <li>
                    <div class="facebook">
                        <script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script>
                        <fb:like
                                href="<{$xoops_url}>/modules/extgallery/public-photo.php?photoId=<{$photo.photo_id}>#photoNav"
                                layout="button_count" show_faces="false"></fb:like>
                    </div>
                </li>
                <li>
                    <div class="twitter">
                        <script src="http://platform.twitter.com/widgets.js" type="text/javascript"></script>
                        <a href="http://twitter.com/share/<{$xoops_url}>/modules/extgallery/public-photo.php?photoId=<{$photo.photo_id}>#photoNav"
                           class="twitter-share-button">Tweet</a></div>
                </li>
                <li>
                    <div class="google">
                        <script src="https://apis.google.com/js/plusone.js" type="text/javascript"></script>
                        <g:plusone size="medium" count="true"></g:plusone>
                    </div>
                </li>
            </ul>
        </div>
    <{/if}>

    <{if $show_social_book == 2 || $show_social_book == 3}>
        <div class="bookmarkme">
            <!-- <div class="head bookmarkmetitle"><{$smarty.const._MD_EXTGALLERY_BOOKMARK_ME}></div> -->
            <div class="bookmarkmeitems">
                <a rel="nofollow external" title="<{$smarty.const._MD_EXTGALLERY_BOOKMARK_TO_BLINKLIST}>"
                   href="http://www.blinklist.com/index.php?Action=Blink/addblink.php&Description=&Url=<{$xoops_url}>/modules/extgallery/public-photo.php?photoId=<{$photo.photo_id}>#photoNav&Title=<{$photo.photo_title}>"><img
                            alt="<{$photo.photo_title}>"
                            src="<{$xoops_url}>/modules/extgallery/assets/assets/images/bookmarks/blinklist.gif"></a>
                <a rel="nofollow external" title="<{$smarty.const._MD_EXTGALLERY_BOOKMARK_TO_DELICIOUS}>"
                   href="http://del.icio.us/post?url=<{$xoops_url}>/modules/extgallery/public-photo.php?photoId=<{$photo.photo_id}>#photoNav&title=<{$photo.photo_title}>"><img
                            alt="<{$photo.photo_title}>"
                            src="<{$xoops_url}>/modules/extgallery/assets/assets/images/bookmarks/delicious.gif"></a>
                <a rel="nofollow external" title="<{$smarty.const._MD_EXTGALLERY_BOOKMARK_TO_DIGG}>"
                   href="http://digg.com/submit?phase=2&url=<{$xoops_url}>/modules/extgallery/public-photo.php?photoId=<{$photo.photo_id}>#photoNav"><img
                            alt="<{$photo.photo_title}>"
                            src="<{$xoops_url}>/modules/extgallery/assets/assets/images/bookmarks/diggman.gif"></a>
                <a rel="nofollow external" title="<{$smarty.const._MD_EXTGALLERY_BOOKMARK_TO_FARK}>"
                   href="http://cgi.fark.com/cgi/fark/edit.pl?new_url=<{$xoops_url}>/modules/extgallery/public-photo.php?photoId=<{$photo.photo_id}>#photoNav&new_comment=<{$photo.photo_title}>&new_link_other=<{$photo.photo_title}>&linktype=Misc"><img
                            alt="<{$photo.photo_title}>"
                            src="<{$xoops_url}>/modules/extgallery/assets/assets/images/bookmarks/fark.gif"></a>
                <a rel="nofollow external" title="<{$smarty.const._MD_EXTGALLERY_BOOKMARK_TO_FURL}>"
                   href="http://www.furl.net/storeIt.jsp?t=<{$photo.photo_title}>&u=<{$xoops_url}>/modules/extgallery/public-photo.php?photoId=<{$photo.photo_id}>#photoNav"><img
                            alt="<{$photo.photo_title}>"
                            src="<{$xoops_url}>/modules/extgallery/assets/images/bookmarks/furl.gif"></a>
                <a rel="nofollow external" title="<{$smarty.const._MD_EXTGALLERY_BOOKMARK_TO_NEWSVINE}>"
                   href="http://www.nwvine.com/_tools/seed&save?u=<{$xoops_url}>/modules/extgallery/public-photo.php?photoId=<{$photo.photo_id}>#photoNav&h=<{$photo.photo_title}>"><img
                            alt="<{$photo.photo_title}>"
                            src="<{$xoops_url}>/modules/extgallery/assets/images/bookmarks/newsvine.gif"></a>
                <a rel="nofollow external" title="<{$smarty.const._MD_EXTGALLERY_BOOKMARK_TO_REDDIT}>"
                   href="http://reddit.com/submit?url=<{$xoops_url}>/modules/extgallery/public-photo.php?photoId=<{$photo.photo_id}>#photoNav&title=<{$photo.photo_title}>"><img
                            alt="<{$photo.photo_title}>"
                            src="<{$xoops_url}>/modules/extgallery/assets/images/bookmarks/reddit.gif"></a>
                <a rel="nofollow external" title="<{$smarty.const._MD_EXTGALLERY_BOOKMARK_TO_SIMPY}>"
                   href="http://www.simpy.com/simpy/LinkAdd.do?href=<{$xoops_url}>/modules/extgallery/public-photo.php?photoId=<{$photo.photo_id}>#photoNav&title=<{$photo.photo_title}>"><img
                            alt="<{$photo.photo_title}>"
                            src="<{$xoops_url}>/modules/extgallery/assets/images/bookmarks/simpy.png"></a>
                <a rel="nofollow external" title="<{$smarty.const._MD_EXTGALLERY_BOOKMARK_TO_SPURL}>"
                   href="http://www.spurl.net/spurl.php?title=<{$photo.photo_title}>&url=<{$xoops_url}>/modules/extgallery/public-photo.php?photoId=<{$photo.photo_id}>#photoNav"><img
                            alt="<{$photo.photo_title}>"
                            src="<{$xoops_url}>/modules/extgallery/assets/images/bookmarks/spurl.gif"></a>
                <a rel="nofollow external" title="<{$smarty.const._MD_EXTGALLERY_BOOKMARK_TO_YAHOO}>"
                   href="http://myweb2.search.yahoo.com/myresults/bookmarklet?t=<{$photo.photo_title}>&u=<{$xoops_url}>/modules/extgallery/public-photo.php?photoId=<{$photo.photo_id}>#photoNav"><img
                            alt="<{$photo.photo_title}>"
                            src="<{$xoops_url}>/modules/extgallery/assets/images/bookmarks/yahoomyweb.gif"></a>
                <a rel="nofollow external" title="<{$smarty.const._MD_EXTGALLERY_BOOKMARK_TO_BALATARIN}>"
                   href="http://balatarin.com/links/submit?phase=2&amp;url=<{$xoops_url}>/modules/extgallery/public-photo.php?photoId=<{$photo.photo_id}>#photoNav"><img
                            alt="<{$photo.photo_title}>"
                            src="<{$xoops_url}>/modules/extgallery/assets/images/bookmarks/balatarin.png"></a>
                <a rel="nofollow external" title="<{$smarty.const._MD_EXTGALLERY_BOOKMARK_TO_FACEBOOK}>"
                   href="http://www.facebook.com/share.php?u=<{$xoops_url}>/modules/extgallery/public-photo.php?photoId=<{$photo.photo_id}>#photoNav"><img
                            alt="<{$photo.photo_title}>"
                            src="<{$xoops_url}>/modules/extgallery/assets/images/bookmarks/facebook_share_icon.gif"></a>
                <a rel="nofollow external" title="<{$smarty.const._MD_EXTGALLERY_BOOKMARK_TO_TWITTER}>"
                   href="http://twitter.com/home?status=Browsing:%20<{$xoops_url}>/modules/extgallery/public-photo.php?photoId=<{$photo.photo_id}>#photoNav"><img
                            alt="<{$photo.photo_title}>"
                            src="<{$xoops_url}>/modules/extgallery/assets/images/bookmarks/twitter_share_icon.gif"></a>
                <a rel="nofollow external" title="<{$smarty.const._MD_EXTGALLERY_BOOKMARK_TO_SCRIPSTYLE}>"
                   href="http://scriptandstyle.com/submit?url=<{$xoops_url}>/modules/extgallery/public-photo.php?photoId=<{$photo.photo_id}>#photoNav"><img
                            alt="<{$photo.photo_title}>"
                            src="<{$xoops_url}>/modules/extgallery/assets/images/bookmarks/scriptandstyle.png"></a>
                <a rel="nofollow external" title="<{$smarty.const._MD_EXTGALLERY_BOOKMARK_TO_STUMBLE}>"
                   href="http://www.stumbleupon.com/submit?url=<{$xoops_url}>/modules/extgallery/public-photo.php?photoId=<{$photo.photo_id}>#photoNav"><img
                            alt="<{$photo.photo_title}>"
                            src="<{$xoops_url}>/modules/extgallery/assets/images/bookmarks/stumbleupon.png"></a>
                <a rel="nofollow external" title="<{$smarty.const._MD_EXTGALLERY_BOOKMARK_TO_TECHNORATI}>"
                   href="http://technorati.com/faves?add=<{$xoops_url}>/modules/extgallery/public-photo.php?photoId=<{$photo.photo_id}>#photoNav"><img
                            alt="<{$photo.photo_title}>"
                            src="<{$xoops_url}>/modules/extgallery/assets/images/bookmarks/technorati.png"></a>
                <a rel="nofollow external" title="<{$smarty.const._MD_EXTGALLERY_BOOKMARK_TO_MIXX}>"
                   href="http://www.mixx.com/submit?page_url=<{$xoops_url}>/modules/extgallery/public-photo.php?photoId=<{$photo.photo_id}>#photoNav"><img
                            alt="<{$photo.photo_title}>"
                            src="<{$xoops_url}>/modules/extgallery/assets/images/bookmarks/mixx.png"></a>
                <a rel="nofollow external" title="<{$smarty.const._MD_EXTGALLERY_BOOKMARK_TO_MYSPACE}>"
                   href="http://www.myspace.com/Modules/PostTo/Pages/?u=<{$xoops_url}>/modules/extgallery/public-photo.php?photoId=<{$photo.photo_id}>#photoNav"><img
                            alt="<{$photo.photo_title}>"
                            src="<{$xoops_url}>/modules/extgallery/assets/images/bookmarks/myspace.jpg"></a>
                <a rel="nofollow external" title="<{$smarty.const._MD_EXTGALLERY_BOOKMARK_TO_DESIGNFLOAT}>"
                   href="http://www.designfloat.com/submit.php?url=<{$xoops_url}>/modules/extgallery/public-photo.php?photoId=<{$photo.photo_id}>#photoNav"><img
                            alt="<{$photo.photo_title}>"
                            src="<{$xoops_url}>/modules/extgallery/assets/images/bookmarks/designfloat.png"></a>
                <a rel="nofollow external" title="<{$smarty.const._MD_EXTGALLERY_BOOKMARK_TO_GOOGLEPLUS}>"
                   href="https://plusone.google.com/_/+1/confirm?hl=en&url=<{$xoops_url}>/modules/extgallery/public-photo.php?photoId=<{$photo.photo_id}>#photoNav"><img
                            alt="<{$photo.photo_title}>"
                            src="<{$xoops_url}>/modules/extgallery/assets/images/bookmarks/google_plus_icon.png"></a>
                <a rel="nofollow external" title="<{$smarty.const._MD_EXTGALLERY_BOOKMARK_TO_GOOGLEREADER}>"
                   href="http://www.google.com/reader/link?url=<{$xoops_url}>/modules/extgallery/public-photo.php?photoId=<{$photo.photo_id}>#photoNav&amp;title=<{$photo.photo_title}>"><img
                            alt="<{$photo.photo_title}>"
                            src="<{$xoops_url}>/modules/extgallery/assets/images/bookmarks/google-reader-icon.png"></a>
                <a rel="nofollow external" title="<{$smarty.const._MD_EXTGALLERY_BOOKMARK_TO_GOOGLEBOOKMARKS}>"
                   href="https://www.google.com/bookmarks/mark?op=add&amp;bkmk=<{$xoops_url}>/modules/extgallery/public-photo.php?photoId=<{$photo.photo_id}>#photoNav&amp;title=<{$photo.photo_title}>"><img
                            alt="<{$photo.photo_title}>"
                            src="<{$xoops_url}>/modules/extgallery/assets/images/bookmarks/google-icon.png"></a>
            </div>
        </div>
    <{/if}>

<{/if}>
