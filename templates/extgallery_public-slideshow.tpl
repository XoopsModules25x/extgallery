<{if $jquery}>
    <{if $use_slideshow_effects == galleryview}>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#gallery').galleryView({
                    panel_width: <{$galleryview_panelwidth}>,
                    panel_height: <{$galleryview_panelheight}>,
                    frame_width: <{$galleryview_framewidth}>,
                    frame_height: <{$galleryview_frameheight}>,
                    transition_speed: <{$galleryview_transitionspeed}>,
                    transition_interval: <{$galleryview_transitioninterval}>,
                    overlay_color: '<{$galleryview_overlaycolor}>',
                    overlay_opacity: '<{$galleryview_overlayopacity}>',
                    nav_theme: '<{$galleryview_navtheme}>',
                    filmstrip_position: '<{$galleryview_position}>',
                    overlay_position: '<{$galleryview_position}>',
                    easing: '<{$galleryview_easing}>',
                    theme_path: '<{xoAppUrl browse.php?modules/extgallery/assets/images/galleryview/}>'
                });
            });
        </script>
        <style type="text/css">
            .gallery {
                background: <{$galleryview_backgroundcolor}>;
            }

            .overlay-background {
                height: <{$galleryview_overlayheight}>px;
            }

            .overlay-background {
                background: <{$galleryview_overlaycolor}>;
            }

            .panel-overlay {
                color: <{$galleryview_overlaytextcolor}>;
                font-size: <{$galleryview_overlayfontsize}>px;
            }

            .panel-overlay a {
                color: <{$galleryview_overlaytextcolor}>;
            }

            .frame.current .img_wrap {
                border-color: <{$galleryview_captiontextcolor}>;
            }

            .pointer {
                border-color: <{$galleryview_captiontextcolor}>;
            }

            .galleryview_imagesize {
                max-width: <{$galleryview_framewidth}>;
                max-height: <{$galleryview_frameheight}>;
            }
        </style>
    <{/if}>
    <{if $use_slideshow_effects == galleria}>
        <style>
            .content {
                color: #eee;
                font: 14px/1.4 "helvetica neue", arial, sans-serif;
                width: <{$galleria_panelwidth}>px;
                margin: 20px auto;
            }

            #galleria {
                height: <{$galleria_height}>px;
            }

            .galleria-container {
                background-color: <{$galleria_bgcolor}> !important;
            }

            .galleria-thumbnails .galleria-image {
                border: 1px solid <{$galleria_bcolor}>;
            }

            .galleria-thumb-nav-left, .galleria-thumb-nav-right, .galleria-info-link, .galleria-info-close, .galleria-image-nav-left, .galleria-image-nav-right {
                background: url(<{xoAppUrl modules/extgallery/}> assets/images/galleria/ <{$galleria_bgimg}> .png };;
        </style>
    <{/if}>
    <{if $use_slideshow_effects == microgallery}>
        <script type="text/javascript">
            $(function () {
                $("#mG1").microgallery({
                    menu: true,
                    size: 'large',
                    mode: 'single'
                });
            });
        </script>
    <{/if}>
<{else}>
    <{if $use_slideshow_effects == galleryview}>
        <link rel="stylesheet" type="text/css"
              href="<{xoAppUrl browse.php?modules/extgallery/assets/js/galleryview/galleryview.css}>">
        <script type="text/javascript"
                src="<{xoAppUrl browse.php?modules/extgallery/assets/js/galleryview/galleryview.js}>"></script>
        <script type="text/javascript"
                src="<{xoAppUrl browse.php?modules/extgallery/assets/js/galleryview/timers.js}>"></script>
        <script type="text/javascript"
                src="<{xoAppUrl browse.php?modules/extgallery/assets/js/galleryview/easing.js}>"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#gallery').galleryView({
                    panel_width: <{$galleryview_panelwidth}>,
                    panel_height: <{$galleryview_panelheight}>,
                    frame_width: <{$galleryview_framewidth}>,
                    frame_height: <{$galleryview_frameheight}>,
                    transition_speed: <{$galleryview_transitionspeed}>,
                    transition_interval: <{$galleryview_transitioninterval}>,
                    overlay_color: '<{$galleryview_overlaycolor}>',
                    overlay_opacity: '<{$galleryview_overlayopacity}>',
                    nav_theme: '<{$galleryview_navtheme}>',
                    filmstrip_position: '<{$galleryview_position}>',
                    overlay_position: '<{$galleryview_position}>',
                    easing: '<{$galleryview_easing}>',
                    theme_path: '<{xoAppUrl browse.php?modules/extgallery/assets/images/galleryview/}>'
                });
            });
        </script>
        <style type="text/css">
            .gallery {
                background: <{$galleryview_backgroundcolor}>;
            }

            .overlay-background {
                height: <{$galleryview_overlayheight}>px;
            }

            .overlay-background {
                background: <{$galleryview_overlaycolor}>;
            }

            .panel-overlay {
                color: <{$galleryview_overlaytextcolor}>;
                font-size: <{$galleryview_overlayfontsize}>px;
            }

            .panel-overlay a {
                color: <{$galleryview_overlaytextcolor}>;
            }

            .frame.current .img_wrap {
                border-color: <{$galleryview_captiontextcolor}>;
            }

            .pointer {
                border-color: <{$galleryview_captiontextcolor}>;
            }

            .galleryview_imagesize {
                max-width: <{$galleryview_framewidth}>;
                max-height: <{$galleryview_frameheight}>;
            }
        </style>
    <{/if}>
    <{if $use_slideshow_effects == galleria}>
        <script type="text/javascript"
                src="<{xoAppUrl browse.php?modules/extgallery/assets/js/galleria/galleria.js}>"></script>
        <style>
            .content {
                color: #eee;
                font: 14px/1.4 "helvetica neue", arial, sans-serif;
                width: <{$galleria_panelwidth}>px;
                margin: 20px auto;
            }

            #galleria {
                height: <{$galleria_height}>px;
            }

            .galleria-container {
                background-color: <{$galleria_bgcolor}> !important;
            }

            .galleria-thumbnails .galleria-image {
                border: 1px solid <{$galleria_bcolor}>;
            }

            .galleria-thumb-nav-left, .galleria-thumb-nav-right, .galleria-info-link, .galleria-info-close, .galleria-image-nav-left, .galleria-image-nav-right {
                background: url(<{xoAppUrl modules/extgallery/}> assets/images/galleria/ <{$galleria_bgimg}> .png };;
        </style>
    <{/if}>
    <{if $use_slideshow_effects == microgallery}>
        <script type="text/javascript"
                src="<{xoAppUrl browse.php?modules/extgallery/assets/js/microgallery/jquery.microgallery.js}>"></script>
        <script type="text/javascript">
            $(function () {
                $("#mG1").microgallery({
                    menu: true,
                    size: 'large',
                    mode: 'single'
                });
            });
        </script>
        <link rel="stylesheet" type="text/css"
              href="<{xoAppUrl browse.php?modules/extgallery/assets/js/microgallery/style.css}>">
    <{/if}>
    <{if $use_slideshow_effects == galleriffic}>
        <link rel="stylesheet" type="text/css"
              href="<{xoAppUrl browse.php?modules/extgallery/assets/js/galleriffic/galleriffic2.css}>">
        <script type="text/javascript"
                src="<{xoAppUrl browse.php?modules/extgallery/assets/js/galleriffic/jquery.galleriffic.js}>"></script>
        <script type="text/javascript"
                src="<{xoAppUrl browse.php?modules/extgallery/assets/js/galleriffic/jquery.history.js}>"></script>
        <script type="text/javascript"
                src="<{xoAppUrl browse.php?modules/extgallery/assets/js/galleriffic/jquery.opacityrollover.js}>"></script>
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

    <{if $use_slideshow_effects == galleryview}>
        <ul id="gallery">
            <{foreach item=photo from=$photos}>
                <li>
                    <div class="panel-overlay">
                        <h2><{$photo.photo_title}></h2>
                        <{$photo.photo_desc}> <a title="<{$photo.photo_title}>"
                                                 href="<{xoAppUrl modules/extgallery/}>public-photo.php?photoId=<{$photo.photo_id}>"><{$smarty.const._MD_EXTGALLERY_MOREINFO}></a></p>
                    </div>
                    <img class="galleryview_imagesize"
                         src="<{$xoops_url}>/uploads/extgallery/public-photo/medium/<{$photo.photo_name}>"
                         alt="<{$photo.photo_title}>" title="<{$photo.photo_title}>">
                </li>
            <{/foreach}>
        </ul>
    <{/if}>


    <{if $use_slideshow_effects == galleria}>
        <div class="content">
            <div id="galleria">
                <{foreach item=photo from=$photos}>
                    <img src="<{$xoops_url}>/uploads/extgallery/public-photo/medium/<{$photo.photo_name}>"
                         alt="<{$photo.photo_desc}>" title="<{$photo.photo_title}>">
                <{/foreach}>
            </div>
        </div>
    <{/if}>

    <{if $use_slideshow_effects == microgallery}>
        <div class="extmicrogallery">
            <div id="mG1" class="microGallery">
                <{foreach item=photo from=$photos}>
                    <img src="<{$xoops_url}>/uploads/extgallery/public-photo/medium/<{$photo.photo_name}>"
                         alt="<{$photo.photo_desc}>" title="<{$photo.photo_title}>">
                <{/foreach}>
            </div>
        </div>
    <{/if}>

    <{if $use_slideshow_effects == galleriffic}>
        <div id="galleriffic_page" class="page">
            <div id="galleriffic_container" class="container">
                <div id="gallery" class="content">
                    <div id="controls" class="controls"></div>
                    <div class="slideshow-container">
                        <div id="loading" class="loader"></div>
                        <div id="slideshow" class="slideshow"></div>
                    </div>
                    <div id="caption" class="caption-container">
                        <div class="photo-index"></div>
                    </div>
                </div>
                <div id="thumbs" class="navigation">
                    <ul class="thumbs noscript">
                        <{foreach item=photo from=$photos}>
                            <li>
                                <a class="thumb" name="<{$photo.photo_name}>"
                                   href="<{$xoops_url}>/uploads/extgallery/public-photo/medium/<{$photo.photo_name}>"
                                   title="<{$photo.photo_title}>">
                                    <img width="75" height="75"
                                         src="<{$xoops_url}>/uploads/extgallery/public-photo/thumb/thumb_<{$photo.photo_name}>"
                                         alt="<{$photo.photo_title}>">
                                </a>
                                <div class="caption">
                                    <div class="image-title"><{$photo.photo_title}></div>
                                    <div class="image-desc"><{if $galleriffic_show_descr == 1}><{$photo.photo_desc}><{/if}></div>
                                    <div class="download"><{if $galleriffic_download == 1}><a
                                            title="<{$photo.photo_title}>"
                                            href="<{xoAppUrl modules/extgallery/}>public-download.php?id=<{$photo.photo_id}>"><{$smarty.const._MD_EXTGALLERY_GFIC_DOWNLOAD}></a><{/if}>
                                    </div>
                                    <div class="info"><a title="<{$photo.photo_title}>"
                                                         href="<{xoAppUrl modules/extgallery/}>public-photo.php?photoId=<{$photo.photo_id}>"><{$smarty.const._MD_EXTGALLERY_MOREINFO}></a>
                                    </div>
                                </div>
                            </li>
                        <{/foreach}>
                    </ul>
                </div>
                <div style="clear: both;"></div>
            </div>
        </div>
    <{/if}>

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

<{if $use_slideshow_effects == galleria}>
    <script type="text/javascript">
        // Load the classic theme
        Galleria.loadTheme('<{xoAppUrl browse.php?modules/extgallery/assets/js/galleria/galleria.classic.min.js}>');

        // Initialize Galleria
        Galleria.run('#galleria');


        // Initialize Galleria
        //    $('#galleria').galleria({
        //          transition:        '<{$galleria_transition}>',
        //      transition_speed:  <{$galleria_tspeed}>,
        //      autoplay:          <{$galleria_autoplay}>
        //    });
    </script>
<{/if}>

<{if $use_slideshow_effects == galleriffic}>
    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            // Initially set opacity on thumbs and add
            // additional styling for hover effect on thumbs
            var onMouseOutOpacity = 0.67;
            $('#thumbs ul.thumbs li').opacityrollover({
                mouseOutOpacity: onMouseOutOpacity,
                mouseOverOpacity: 1.0,
                fadeSpeed: 'fast',
                exemptionSelector: '.selected'
            });

            // Initialize Advanced Galleriffic Gallery
            var gallery = $('#thumbs').galleriffic({
                delay:                     <{$galleriffic_tdelay}>,
                numThumbs:                 <{$galleriffic_nb_thumbs}>,
                preloadAhead:              <{$galleriffic_nb_preload}>,
                enableTopPager: true,
                enableBottomPager: true,
                maxPagesToShow: 5,
                imageContainerSel: '#slideshow',
                controlsContainerSel: '#controls',
                captionContainerSel: '#caption',
                loadingContainerSel: '#loading',
                renderSSControls: true,
                renderNavControls: true,
                enableHistory: false,
                syncTransitions: true,
                playLinkText: '<{$smarty.const._MD_EXTGALLERY_GFIC_PLAY}>',
                pauseLinkText: '<{$smarty.const._MD_EXTGALLERY_GFIC_PAUSE}>',
                prevLinkText: '<{$smarty.const._MD_EXTGALLERY_GFIC_PREVIOUS}>',
                nextLinkText: '<{$smarty.const._MD_EXTGALLERY_GFIC_NEXT}>',
                nextPageLinkText: '<{$smarty.const._MD_EXTGALLERY_GFIC_NEXTP}>',
                prevPageLinkText: '<{$smarty.const._MD_EXTGALLERY_GFIC_PREVIOUSP}>',
                autoStart: '<{$smarty.const._MD_EXTGALLERY_MOREINFO}><{$galleriffic_autoplay}>',
                defaultTransitionDuration: '<{$smarty.const._MD_EXTGALLERY_MOREINFO}><{$galleriffic_tspeed}>',
                onSlideChange: function (prevIndex, nextIndex) {
                    // 'this' refers to the gallery, which is an extension of $('#thumbs')
                    this.find('ul.thumbs').children()
                            .eq(prevIndex).fadeTo('fast', onMouseOutOpacity).end()
                            .eq(nextIndex).fadeTo('fast', 1.0);

                    // Update the photo index display
                    this.$captionContainer.find('div.photo-index')
                            .html('Photo ' + (nextIndex + 1) + ' of ' + this.data.length);
                },
                onPageTransitionOut: function (callback) {
                    this.fadeTo('fast', 0.0, callback);
                },
                onPageTransitionIn: function () {
                    var prevPageLink = this.find('a.prev').css('visibility', 'hidden');
                    var nextPageLink = this.find('a.next').css('visibility', 'hidden');

                    // Show appropriate next / prev page links
                    if (this.displayedPage > 0)
                        prevPageLink.css('visibility', 'visible');

                    var lastPage = this.getNumPages() - 1;
                    if (this.displayedPage < lastPage)
                        nextPageLink.css('visibility', 'visible');

                    this.fadeTo('fast', 1.0);
                }
            });

            gallery.find('a.prev').click(function (e) {
                gallery.previousPage();
                e.preventDefault();
            });
            gallery.find('a.next').click(function (e) {
                gallery.nextPage();
                e.preventDefault();
            });
            function pageload(hash) {
                if (hash) {
                    $.galleriffic.gotoImage(hash);
                } else {
                    gallery.gotoIndex(0);
                }
            }

            $.historyInit(pageload, "advanced.html");
            $("a[rel='history']").live('click', function (e) {
                if (e.button !== 0) return true;
                var hash = this.href;
                hash = hash.replace(/^.*#/, '');
                $.historyLoad(hash);
                return false;
            });
        });
    </script>
    <style type="text/css">
        div#galleriffic_page {
            background-color: <{$galleriffic_bgcolor}> !important;
            border-color: <{$galleriffic_bordercolor}>;
            width: <{$page_width}>px;
        }

        div#galleriffic_container {
            background-color: <{$galleriffic_bgcolor}> !important;
            border-color: <{$galleriffic_bordercolor}>;
        }

        div.navigation {
            width: <{$nav_width}>px;
            visibility: <{$nav_visibility}>;
        }

        div.content {
            width: <{$content_width}>px;
        }

        div.slideshow-container {
            height: <{$pic_height}>px;
        }

        div.loader {
            height: <{$pic_height}>px;
            width: <{$pic_width}>px;
        }

        div.slideshow a.advance-link {
            height: <{$pic_height}>px;
            line-height: <{$pic_height}>px;
            width: <{$content_width}>px;
        }

        span.image-caption {
            width: <{$pic_width}>px;
        }

        div.content a, div.navigation a {
            color: <{$galleriffic_fontcolor}>;
        }
    </style>
<{/if}>
