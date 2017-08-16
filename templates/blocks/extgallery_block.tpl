<{if $block.jquery == 'true'}>
    <{if $block.ajaxeffect == 'lightbox'}>
        <script type="text/javascript">
        $(function() {
        $('#gallery a').lightBox({
        imageLoading:'<{xoAppUrl modules/extgallery/assets/images/lightbox/lightbox-ico-loading.gif}>',
        imageBtnClose:'<{xoAppUrl modules/extgallery/assets/images/lightbox/lightbox-btn-close.gif}>',
        imageBtnNext:'<{xoAppUrl modules/extgallery/assets/images/lightbox/lightbox-btn-next.gif}>',
        imageBtnPrev:'<{xoAppUrl modules/extgallery/assets/images/lightbox/lightbox-btn-prev.gif}>',
        imageBlank:'<{xoAppUrl modules/extgallery/assets/images/lightbox/lightbox-blank.gif}>'
        });
        });
        </script>
    <{/if}>
    <{if $block.ajaxeffect == 'TosRUs'}>
        <script type="text/javascript">
            $(document).ready(function() {
                $('a.TosRUs-gallery').TosRUs({
                    // configuration goes here
                });
            });
        </script>
    <{/if}>
    <{if $block.ajaxeffect == 'tooltip'}>
        <style>
            #screenshot img {max-width: <{$block.tooltipw}>px; border: <{$block.tooltipbw}>px solid <{$block.tooltipbbg}> !important;}
        </style>
    <{/if}>
    <{if $block.ajaxeffect == 'overlay'}>
        <style>
            .apple_overlay {
                background-color: <{$block.overlyabg}>;
                width: <{$block.overlyaw}>px !important;
                height: <{$block.overlyah}>px !important;
                }
            .apple_overlay img {
            max-width: <{$block.overlyaw}>px !important;
            max-height: <{$block.overlyah}>px !important;
            }
        </style>
    <{/if}>
    <{if $block.ajaxeffect == 'fancybox'}>
        <script type="text/javascript">
            $(document).ready(function() {
            <{if $block.fancyboxshow == group}>
                $("a[rel=example_group]").fancybox({
            <{else}>
                $("a.example").fancybox({
            <{/if}>
                    'overlayColor'      : '<{$block.fancyboxbg}>',
                    'overlayOpacity'    : <{$block.fancyboxop}>,
                    'transitionIn'      : '<{$block.fancyboxtin}>',
                    'transitionOut'     : '<{$block.fancyboxtout}>',
                    'titlePosition'     : '<{$block.fancyboxtp}>',
                    'titleFormat'       : function(title, currentArray, currentIndex, currentOpts) {
                    return '<span id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
                    }
                });
            })
        </script>
    <{/if}>
    <{if $block.ajaxeffect == 'jcarousel'}>
        <script type="text/javascript">
            jQuery(document).ready(function() {
                jQuery('#mycarousel').jcarousel(<{if $block.direction == 1}>{vertical: true, scroll: 2}<{/if}>);
            });
        </script>
        <style>
            .jcarousel-skin-tango .jcarousel-container-horizontal {width: <{$block.jcarouselhwidth}>px;}
            .jcarousel-skin-tango .jcarousel-container-vertical {height: <{$block.jcarouselvheight}>px; width: <{$block.jcarouselvwidth}>px;}
            .jcarousel-skin-tango .jcarousel-clip-vertical {height: <{$block.jcarouselvheight}>px;}
        </style>
    <{/if}>
<{else}>
    <{if $block.ajaxeffect == 'lightbox'}>
        <script type="text/javascript" src="<{xoAppUrl browse.php?Frameworks/jquery/plugins/jquery.lightbox.js}>"></script>
        <link rel="stylesheet" type="text/css" href="<{xoAppUrl browse.php?modules/system/css/lightbox.css}>">
        <script type="text/javascript">
            $(function() {
            $('#gallery a').lightBox({
                imageLoading:'<{xoAppUrl modules/extgallery/assets/images/lightbox/lightbox-ico-loading.gif}>',
                imageBtnClose:'<{xoAppUrl modules/extgallery/assets/images/lightbox/lightbox-btn-close.gif}>',
                imageBtnNext:'<{xoAppUrl modules/extgallery/assets/images/lightbox/lightbox-btn-next.gif}>',
                imageBtnPrev:'<{xoAppUrl modules/extgallery/assets/images/lightbox/lightbox-btn-prev.gif}>',
                imageBlank:'<{xoAppUrl modules/extgallery/assets/images/lightbox/lightbox-blank.gif}>'
                });
            });
        </script>
    <{/if}>
    <{if $block.ajaxeffect == 'TosRUs'}>
        <script type="text/javascript" src="<{xoAppUrl browse.php?modules/extgallery/assets/js/TosRUs/src/js/jquery.tosrus.js}>"></script>
        <link rel="stylesheet" type="text/css" href="<{xoAppUrl modules/extgallery/assets/js/TosRUs/src/css/jquery.tosrus.css}>">
        <script type="text/javascript" src="<{xoAppUrl browse.php?modules/extgallery/assets/js/TosRUs/lib/jquery.hammer.min.js}>"></script>
        <script type="text/javascript" src="<{xoAppUrl browse.php?modules/extgallery/assets/js/TosRUs/lib/FlameViewportScale.js}>"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('a.TosRUs-gallery').TosRUs({
                    // configuration goes here
                });
            });
        </script>
    <{/if}>
    <{if $block.ajaxeffect == 'tooltip'}>
        <script type="text/javascript" src="<{xoAppUrl browse.php?modules/extgallery/assets/js/tooltip/image.tooltip.js}>"></script>
        <link rel="stylesheet" type="text/css" href="<{xoAppUrl browse.php?modules/extgallery/assets/js/tooltip/image.tooltip.css}>">
        <style>
            #screenshot img {max-width: <{$block.tooltipw}>px; border: <{$block.tooltipbw}>px solid <{$block.tooltipbbg}> !important;}
        </style>
    <{/if}>
    <{if $block.ajaxeffect == 'overlay'}>
        <script type="text/javascript" src="<{xoAppUrl browse.php?modules/extgallery/assets/js/overlay/overlay.jquery.tools.min.js}>"></script>
        <link rel="stylesheet" type="text/css" href="<{xoAppUrl browse.php?modules/extgallery/assets/js/overlay/overlay.css}>" media="screen">
        <style>
            .apple_overlay {
                background-color: <{$block.overlyabg}>;
                width: <{$block.overlyaw}>px !important;
                height: <{$block.overlyah}>px !important;
                }
            .apple_overlay img {
                max-width: <{$block.overlyaw}>px !important;
                max-height: <{$block.overlyah}>px !important;
                }
        </style>
    <{/if}>
    <{if $block.ajaxeffect == 'fancybox'}>
        <script type="text/javascript" src="<{xoAppUrl browse.php?modules/extgallery/assets/js/fancybox/mousewheel.js}>"></script>
        <script type="text/javascript" src="<{xoAppUrl browse.php?modules/extgallery/assets/js/fancybox/fancybox.pack.js}>"></script>
        <link rel="stylesheet" type="text/css" href="<{xoAppUrl browse.php?modules/extgallery/assets/js/fancybox/fancybox.css}>">
        <script type="text/javascript">
            $(document).ready(function() {
            <{if $block.fancyboxshow == group}>
                $("a[rel=example_group]").fancybox({
            <{else}>
                $("a.example").fancybox({
            <{/if}>
                    'overlayColor'      : '<{$block.fancyboxbg}>',
                    'overlayOpacity'    : <{$block.fancyboxop}>,
                    'transitionIn'      : '<{$block.fancyboxtin}>',
                    'transitionOut'     : '<{$block.fancyboxtout}>',
                    'titlePosition'     : '<{$block.fancyboxtp}>',
                    'titleFormat'   : function(title, currentArray, currentIndex, currentOpts) {
                    return '<span id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
                    }
                });
            })
        </script>
    <{/if}>
    <{if $block.ajaxeffect == 'prettyphoto'}>
        <script type="text/javascript" src="<{xoAppUrl browse.php?modules/extgallery/assets/js/prettyphoto/jquery.prettyPhoto.js}>"></script>
        <link rel="stylesheet" type="text/css" href="<{xoAppUrl browse.php?modules/extgallery/assets/js/prettyphoto/prettyPhoto.css}>">
    <{/if}>
    <{if $block.ajaxeffect == 'jcarousel'}>
        <script type="text/javascript" src="<{xoAppUrl browse.php?modules/extgallery/assets/js/jcarousel/jquery.jcarousel.min.js}>"></script>
        <link rel="stylesheet" type="text/css" href="<{xoAppUrl browse.php?modules/extgallery/assets/js/jcarousel/skin.css}>">
        <script type="text/javascript">
            jQuery(document).ready(function() {
                jQuery('#mycarousel').jcarousel(<{if $block.direction == 1}>{vertical: true, scroll: 2}<{/if}>);
            });
        </script>
        <style>
            .jcarousel-skin-tango .jcarousel-container-horizontal {width: <{$block.jcarouselhwidth}>px;}
            .jcarousel-skin-tango .jcarousel-container-vertical {height: <{$block.jcarouselvheight}>px; width: <{$block.jcarouselvwidth}>px;}
            .jcarousel-skin-tango .jcarousel-clip-vertical {height: <{$block.jcarouselvheight}>px;}
        </style>
    <{/if}>
<{/if}>



<!-- Start prettyPhoto show -->
<{if $block.ajaxeffect == 'prettyphoto'}>
    <ul class="gallery clearfix">
<{/if}>
<!-- End prettyPhoto show -->

<table style="width:100%;">
<{if $block.direction == 0}>
    <tr>
        <{if $block.ajaxeffect == 'jcarousel'}>
        <!-- Start jcarousel show -->
             <ul id="mycarousel" class="jcarousel-skin-tango">
        <!-- End jcarousel show -->
        <{/if}>
        <{foreach item=photo from=$block.photos}>
            <{if $block.ajaxeffect != 'jcarousel'}>
                <td style="text-align:center; vertical-align:middle;">
            <{/if}>
                <{if $block.ajaxeffect == 'none'}>
                <!-- Start Normal show -->
                    <a title="<{$photo.photo_title}>" href="<{$xoops_url}>/modules/extgallery/public-photo.php?photoId=<{$photo.photo_id}>">
                        <img class="thumb" src="<{$xoops_url}>/uploads/extgallery/public-photo/thumb/thumb_<{$photo.photo_name}>" alt="<{$photo.photo_title}>" title="<{$photo.photo_title}>">
                    </a>
                <!-- End Normal show -->
                <{/if}>
                <{if $block.ajaxeffect == 'tooltip'}>
                <!-- Start Tooltip show -->
                    <a class="screenshot" title="<{$photo.photo_title}>" href="<{$xoops_url}>/modules/extgallery/public-photo.php?photoId=<{$photo.photo_id}>" rel="<{$xoops_url}>/uploads/extgallery/public-photo/medium/<{$photo.photo_name}>">
                        <img class="thumb" src="<{$xoops_url}>/uploads/extgallery/public-photo/thumb/thumb_<{$photo.photo_name}>" alt="<{$photo.photo_title}>" title="<{$photo.photo_title}>">
                    </a>
                <!-- End Tooltip show -->
                <{/if}>
                <{if $block.ajaxeffect == 'lightbox'}>
                <!-- Start Lightbox -->
                <div id="gallery">
                    <a title="<{$photo.photo_title}>" href="<{$xoops_url}>/uploads/extgallery/public-photo/medium/<{$photo.photo_name}>">
                        <img class="thumb" src="<{$xoops_url}>/uploads/extgallery/public-photo/thumb/thumb_<{$photo.photo_name}>" alt="<{$photo.photo_title}>" title="<{$photo.photo_title}>">
                    </a>
                </div>
                <!-- End Lightbox -->
                <{/if}>
                <{if $block.ajaxeffect == 'TosRUs'}>
                <!-- Start TosRUs -->
                    <a class="TosRUs-gallery" href="<{$xoops_url}>/uploads/extgallery/public-photo/medium/<{$photo.photo_name}>" title="<{$photo.photo_title}>">
                        <img src="<{$xoops_url}>/uploads/extgallery/public-photo/thumb/thumb_<{$photo.photo_name}>"></a>
                <!-- End TosRUs -->
                <{/if}>
                <{if $block.ajaxeffect == 'overlay'}>
                <!-- Start Overlay -->
                    <div align="center" id="apple">
                        <img rel="#photo<{$photo.photo_id}>" class="thumb" src="<{$xoops_url}>/uploads/extgallery/public-photo/thumb/thumb_<{$photo.photo_name}>" alt="<{$photo.photo_title}>" title="<{$photo.photo_title}>">
                    </div>
                    <div class="apple_overlay" id="photo<{$photo.photo_id}>"><a class="close"></a>
                        <img src="<{$xoops_url}>/uploads/extgallery/public-photo/medium/<{$photo.photo_name}>" alt="<{$photo.photo_title}>">
                        <div class="details">
                            <div align="center"><a href="<{$xoops_url}>/modules/extgallery/public-photo.php?photoId=<{$photo.photo_id}>"><{$photo.photo_title}></a></div>
                            <p><{$photo.photo_desc}></p>
                        </div>
                    </div>
                <!-- End Overlay -->
                <{/if}>
                <{if $block.ajaxeffect == 'fancybox'}>
                <!-- Start Fansybox -->
                    <a <{if $block.fancyboxshow == group }>rel="example_group"<{else}>class="example"<{/if}> href="<{$xoops_url}>/uploads/extgallery/public-photo/medium/<{$photo.photo_name}>" title="<{$photo.photo_title}>"><img class="last" alt="<{$photo.photo_title}>" src="<{$xoops_url}>/uploads/extgallery/public-photo/thumb/thumb_<{$photo.photo_name}>"></a>
                <!-- End Fansybox -->
                <{/if}>
                <{if $block.ajaxeffect == 'prettyphoto'}>
                <!-- Start prettyPhoto show -->
                    <ul class="gallery clearfix">
                        <li><a title="<{$photo.photo_title}>" href="<{$xoops_url}>/uploads/extgallery/public-photo/medium/<{$photo.photo_name}>" rel="prettyPhoto[gallery2]"><img class="thumb" src="<{$xoops_url}>/uploads/extgallery/public-photo/thumb/thumb_<{$photo.photo_name}>" alt="<{$photo.photo_title}>"></a></li>
                    </ul>
                <!-- End prettyPhoto show -->
                <{/if}>
                <{if $block.ajaxeffect == 'jcarousel'}>
                <!-- Start jcarousel show -->
                    <li><a title="<{$photo.photo_title}>" href="<{$xoops_url}>/modules/extgallery/public-photo.php?photoId=<{$photo.photo_id}>"><img class="thumb" src="<{$xoops_url}>/uploads/extgallery/public-photo/thumb/thumb_<{$photo.photo_name}>" alt="<{$photo.photo_title}>" title="<{$photo.photo_title}>"></a></li>
                <!-- End jcarousel show -->
                <{/if}>
                <{if $block.title}>
                    <div class="center"><a title="<{$photo.photo_title}>" href="<{$xoops_url}>/modules/extgallery/public-photo.php?photoId=<{$photo.photo_id}>"><{$photo.photo_title}></a></div>
                <{/if}>
            <{if $block.ajaxeffect != 'jcarousel'}>
                </td>
            <{/if}>
        <{/foreach}>
        <!-- Start jcarousel show -->
        <{if $block.ajaxeffect == 'jcarousel'}>
            </ul>
        <{/if}>
        <!-- End jcarousel show -->
    </tr>
<{/if}><{* End if $block.direction == 0*}>



<{if $block.direction == 1}>
    <{if $block.ajaxeffect == 'jcarousel'}>
    <!-- Start jcarousel show -->
        <ul id="mycarousel" class="jcarousel-skin-tango">
   <!-- End jcarousel show -->
    <{/if}>
    <{foreach item=photo from=$block.photos}>
        <{if $block.ajaxeffect != 'jcarousel'}>
        <tr>
            <td style="text-align:center; vertical-align:middle;">
        <{/if}>
                <{if $block.ajaxeffect == 'none'}>
                <!-- Start Normal show -->
                    <a title="<{$photo.photo_title}>" href="<{$xoops_url}>/modules/extgallery/public-photo.php?photoId=<{$photo.photo_id}>"><img class="thumb" src="<{$xoops_url}>/uploads/extgallery/public-photo/thumb/thumb_<{$photo.photo_name}>" alt="<{$photo.photo_title}>" title="<{$photo.photo_title}>"></a>
                <!-- End Normal show -->
                <{/if}>
                <{if $block.ajaxeffect == 'tooltip'}>
                <!-- Start Tooltip show -->
                    <a class="screenshot" title="<{$photo.photo_title}>" href="<{$xoops_url}>/modules/extgallery/public-photo.php?photoId=<{$photo.photo_id}>" rel="<{$xoops_url}>/uploads/extgallery/public-photo/medium/<{$photo.photo_name}>"><img class="thumb" src="<{$xoops_url}>/uploads/extgallery/public-photo/thumb/thumb_<{$photo.photo_name}>" alt="<{$photo.photo_title}>" title="<{$photo.photo_title}>"></a>
                <!-- End Tooltip show -->
                <{/if}>
                <{if $block.ajaxeffect == 'lightbox'}>
                <!-- Start Lightbox -->
                    <div id="gallery">
                        <a title="<{$photo.photo_title}>" href="<{$xoops_url}>/uploads/extgallery/public-photo/medium/<{$photo.photo_name}>"><img class="thumb" src="<{$xoops_url}>/uploads/extgallery/public-photo/thumb/thumb_<{$photo.photo_name}>" alt="<{$photo.photo_title}>" title="<{$photo.photo_title}>"></a>
                    </div>
                 <!-- End Lightbox -->
                 <{/if}>
                <{if $block.ajaxeffect == 'TosRUs'}>
                <!-- Start TosRUs -->
                    <a class="TosRUs-gallery" href="<{$xoops_url}>/uploads/extgallery/public-photo/medium/<{$photo.photo_name}>" title="<{$photo.photo_title}>">
                        <img src="<{$xoops_url}>/uploads/extgallery/public-photo/thumb/thumb_<{$photo.photo_name}>"></a>
                <!-- End TosRUs -->
                <{/if}>
                <{if $block.ajaxeffect == 'overlay'}>
                <!-- Start Overlay -->
                    <div align="center" id="apple">
                        <img rel="#photo<{$photo.photo_id}>" class="thumb" src="<{$xoops_url}>/uploads/extgallery/public-photo/thumb/thumb_<{$photo.photo_name}>" alt="<{$photo.photo_title}>" title="<{$photo.photo_title}>">
                    </div>
                    <div class="apple_overlay" id="photo<{$photo.photo_id}>"><a class="close"></a>
                        <img alt="<{$photo.photo_title}>" src="<{$xoops_url}>/uploads/extgallery/public-photo/medium/<{$photo.photo_name}>">
                        <div class="details">
                            <div align="center"><a title="<{$photo.photo_title}>" href="<{$xoops_url}>/modules/extgallery/public-photo.php?photoId=<{$photo.photo_id}>"><{$photo.photo_title}></a></div>
                            <p><{$photo.photo_desc}></p>
                        </div>
                    </div>
                <!-- End Overlay -->
                <{/if}>
                <{if $block.ajaxeffect == 'fancybox'}>
                <!-- Start Fansybox -->
                    <a <{if $block.fancyboxshow == group }>rel="example_group"<{else}>class="example"<{/if}> href="<{$xoops_url}>/uploads/extgallery/public-photo/medium/<{$photo.photo_name}>" title="<{$photo.photo_title}>"><img class="last" alt="<{$photo.photo_title}>" src="<{$xoops_url}>/uploads/extgallery/public-photo/thumb/thumb_<{$photo.photo_name}>"></a>
                <!-- End Fansybox -->
                <{/if}>
                <{if $block.ajaxeffect == 'prettyphoto'}>
                <!-- Start prettyPhoto show -->
                    <ul class="gallery clearfix">
                        <li><a title="<{$photo.photo_title}>" href="<{$xoops_url}>/uploads/extgallery/public-photo/medium/<{$photo.photo_name}>" rel="prettyPhoto[gallery2]"><img class="thumb" src="<{$xoops_url}>/uploads/extgallery/public-photo/thumb/thumb_<{$photo.photo_name}>" alt="<{$photo.photo_title}>"></a></li>
                    </ul>
                <!-- End prettyPhoto show -->
                <{/if}>
                <{if $block.ajaxeffect == 'jcarousel'}>
                <!-- Start jcarousel show -->
                    <li><a title="<{$photo.photo_title}>" href="<{$xoops_url}>/modules/extgallery/public-photo.php?photoId=<{$photo.photo_id}>"><img class="thumb" src="<{$xoops_url}>/uploads/extgallery/public-photo/thumb/thumb_<{$photo.photo_name}>" alt="<{$photo.photo_title}>" title="<{$photo.photo_title}>"></a></li>
                <!-- End jcarousel show -->
                <{/if}>
            <{if $block.title}>
                <div class="center"><a title="<{$photo.photo_title}>" href="<{$xoops_url}>/modules/extgallery/public-photo.php?photoId=<{$photo.photo_id}>"><{$photo.photo_title}></a></div>
            <{/if}>
    <{if $block.ajaxeffect != 'jcarousel'}>
        </td>
    </tr>
    <{/if}>
    <{/foreach}>
   <!-- Start jcarousel show -->
   <{if $block.ajaxeffect == 'jcarousel'}>
      </ul>
   <{/if}>
   <!-- End jcarousel show -->
    <{/if}><{*End if $block.direction == 1*}>



    <{if $block.direction == 2}>
        <tr>
        <!-- Start jcarousel show -->
        <{if $block.ajaxeffect == 'jcarousel'}>
            <ul id="mycarousel" class="jcarousel-skin-tango">
        <{/if}>
        <!-- End jcarousel show -->
        <{section name=photo loop=$block.photos}>
        <{if $smarty.section.photo.index % $block.column == 0 && !$smarty.section.photo.first}>
        </tr>
        <tr>
        <{/if}>
        <td>
            <{if $block.ajaxeffect != 'jcarousel'}>
                <td style="text-align:center; vertical-align:middle;">
            <{/if}>
                <!-- Start Normal show -->
                <{if $block.ajaxeffect == 'none'}>
                    <a title="<{$block.photos[photo].photo_title}>" href="<{$xoops_url}>/modules/extgallery/public-photo.php?photoId=<{$block.photos[photo].photo_id}>"><img class="thumb" src="<{$xoops_url}>/uploads/extgallery/public-photo/thumb/thumb_<{$block.photos[photo].photo_name}>" alt="<{$block.photos[photo].photo_title}>" title="<{$block.photos[photo].photo_title}>"></a>
                <{/if}>
                <!-- End Normal show -->
               <!-- Start Tooltip show -->
                <{if $block.ajaxeffect == 'tooltip'}>
                    <a title="<{$block.photos[photo].photo_title}>" class="screenshot" href="<{$xoops_url}>/modules/extgallery/public-photo.php?photoId=<{$block.photos[photo].photo_id}>" rel="<{$xoops_url}>/uploads/extgallery/public-photo/medium/<{$block.photos[photo].photo_name}>"><img class="thumb" src="<{$xoops_url}>/uploads/extgallery/public-photo/thumb/thumb_<{$block.photos[photo].photo_name}>" alt="<{$block.photos[photo].photo_title}>" title="<{$block.photos[photo].photo_title}>"></a>
                <{/if}>
                <!-- End Tooltip show -->
                <!-- Start Lightbox -->
                <{if $block.ajaxeffect == 'lightbox'}>
                <div id="gallery">
                    <a title="<{$block.photos[photo].photo_title}>" href="<{$xoops_url}>/uploads/extgallery/public-photo/medium/<{$block.photos[photo].photo_name}>"><img class="thumb" src="<{$xoops_url}>/uploads/extgallery/public-photo/thumb/thumb_<{$block.photos[photo].photo_name}>" alt="<{$block.photos[photo].photo_title}>" title="<{$block.photos[photo].photo_title}>"></a>
                </div>
                <{/if}>
                <!-- End Lightbox -->
                <{if $block.ajaxeffect == 'TosRUs'}>
                <!-- Start TosRUs -->
                    <a class="TosRUs-gallery" href="<{$xoops_url}>/uploads/extgallery/public-photo/medium/<{$block.photos[photo].photo_name}>" title="<{$block.photos[photo].photo_title}>">
                        <img src="<{$xoops_url}>/uploads/extgallery/public-photo/thumb/thumb_<{$block.photos[photo].photo_name}>"></a>
                <!-- End TosRUs -->
                <{/if}>
                <!-- Start Overlay -->
                <{if $block.ajaxeffect == 'overlay'}>
                    <div align="center" id="apple">
                        <img alt="<{$block.photos[photo].photo_title}>" rel="#photo<{$block.photos[photo].photo_id}>" class="thumb" src="<{$xoops_url}>/uploads/extgallery/public-photo/thumb/thumb_<{$block.photos[photo].photo_name}>" alt="<{$block.photos[photo].photo_title}>" title="<{$block.photos[photo].photo_title}>">
                    </div>
                    <div class="apple_overlay" id="photo<{$block.photos[photo].photo_id}>"><a class="close"></a>
                        <img alt="<{$block.photos[photo].photo_title}>" src="<{$xoops_url}>/uploads/extgallery/public-photo/medium/<{$block.photos[photo].photo_name}>">
                        <div class="details">
                            <div align="center"><a title="<{$block.photos[photo].photo_title}>" href="<{$xoops_url}>/modules/extgallery/public-photo.php?photoId=<{$block.photos[photo].photo_id}>"><{$block.photos[photo].photo_title}></a></div>
                            <p><{$block.photos[photo].photo_desc}></p>
                        </div>
                    </div>
                <{/if}>
                <!-- End Overlay -->
                <!-- Start Fansybox -->
                <{if $block.ajaxeffect == 'fancybox'}>
                    <a <{if $block.fancyboxshow == group }>rel="example_group"<{else}>class="example"<{/if}> href="<{$xoops_url}>/uploads/extgallery/public-photo/medium/<{$block.photos[photo].photo_name}>" title="<{$block.photos[photo].photo_title}>"><img class="last" alt="<{$block.photos[photo].photo_title}>" src="<{$xoops_url}>/uploads/extgallery/public-photo/thumb/thumb_<{$block.photos[photo].photo_name}>"></a>
                <{/if}>
                <!-- End Fansybox -->
                <!-- Start prettyPhoto show -->
                <{if $block.ajaxeffect == 'prettyphoto'}>
                    <ul class="gallery clearfix">
                        <li><a title="<{$block.photos[photo].photo_title}>" href="<{$xoops_url}>/uploads/extgallery/public-photo/medium/<{$block.photos[photo].photo_name}>" rel="prettyPhoto[gallery2]"><img class="thumb" src="<{$xoops_url}>/uploads/extgallery/public-photo/thumb/thumb_<{$block.photos[photo].photo_name}>" alt="<{$block.photos[photo].photo_title}>"></a></li>
                    </ul>
                <{/if}>
                <!-- End prettyPhoto show -->
                <!-- Start jcarousel show -->
                <{if $block.ajaxeffect == 'jcarousel'}>
                    <li><a title="<{$block.photos[photo].photo_title}>" href="<{$xoops_url}>/modules/extgallery/public-photo.php?photoId=<{$block.photos[photo].photo_id}>"><img class="thumb" src="<{$xoops_url}>/uploads/extgallery/public-photo/thumb/thumb_<{$block.photos[photo].photo_name}>" alt="<{$block.photos[photo].photo_title}>" title="<{$block.photos[photo].photo_title}>"></a></li>
                <{/if}>
                <!-- End jcarousel show -->
            <{if $block.title}>
                <div class="center"><a title="<{$block.photos[photo].photo_title}>" href="<{$xoops_url}>/modules/extgallery/public-photo.php?photoId=<{$block.photos[photo].photo_id}>"><{$block.photos[photo].photo_title}></a></div>
            <{/if}>
            <{if $block.ajaxeffect != 'jcarousel'}>
            </td>
        <{/if}>
        </td>
        <{/section}>
        <!-- Start jcarousel show -->
        <{if $block.ajaxeffect == 'jcarousel'}>
            </ul>
        <{/if}>
      <!-- End jcarousel show -->
        </tr>
    <{/if}><{*End if $block.direction == 2*}>
</table>



<!-- Start prettyPhoto show -->
<{if $block.ajaxeffect == 'prettyphoto'}>
    </ul>
<{/if}>
<!-- End prettyPhoto show -->



<{if $block.ajaxeffect == 'overlay'}>
    <script type="text/javascript">
        $(function() {
            $("#apple img[rel]").overlay({effect: 'apple'});
        });
    </script>
<{/if}>



<{if $block.ajaxeffect == 'prettyphoto'}>
    <script type="text/javascript" charset="utf-8">
        $(document).ready(function(){
            $(".gallery:gt(0) a[rel^='prettyPhoto']").prettyPhoto({animationSpeed:'<{$block.prettyphotospeed}>',theme:'<{$block.prettyphototheme}>',slideshow:<{$block.prettyphotoslidspeed}>, autoplay_slideshow: <{$block.prettyphotoautoplay}>});
        });
    </script>
<{/if}>
