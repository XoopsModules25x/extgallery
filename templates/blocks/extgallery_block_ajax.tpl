<{if $block.jquery}>
    <{if $block.ajaxeffect == 'galleryview'}>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#gallery').galleryView({
                    panel_width: <{$block.panel_width}>,
                    panel_height: <{$block.panel_height}>,
                    frame_width: <{$block.frame_width}>,
                    frame_height: <{$block.frame_height}>,
                    transition_speed: <{$block.transition_speed}>,
                    transition_interval: <{$block.transition_interval}>,
                    overlay_color: '#<{$block.overlay_color}>',
                    overlay_opacity: '<{$block.overlay_opacity}>',
                    nav_theme: '<{$block.nav_theme}>',
                    filmstrip_position: '<{$block.position}>',
                    overlay_position: '<{$block.position}>',
                    easing: '<{$block.easing}>',
                    theme_path: '<{xoAppUrl browse.php?modules/extgallery/assets/images/galleryview/}>'
                });
            });
        </script>
        <style type="text/css">
            .gallery {
                background: #<{$block.background_color}>;
            }

            .overlay-background {
                height: <{$block.overlay_height}>px;
            }

            .overlay-background {
                background: #<{$block.overlay_color}>;
            }

            .panel-overlay {
                color: #<{$block.overlay_text_color}>;
                font-size: <{$block.overlay_font_size}>px;
            }

            .panel-overlay a {
                color: #<{$block.overlay_text_color}>;
            }

            .frame.current .img_wrap {
                border-color: #<{$block.caption_text_color}>;
            }

            .pointer {
                border-color: #<{$block.caption_text_color}>;
            }

            .galleryview_imagesize {
                max-width: <{$galleryview_framewidth}>;
                max-height: <{$galleryview_frameheight}>;
            }
        </style>
    <{/if}>
    <{if $block.ajaxeffect == 'galleria'}>
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
                background: url(<{xoAppUrl modules/extgallery/}>assets/images/galleria/<{$galleria_bgimg}>.png
            }

            .content {
                color: #eee;
                font: 14px/1.4 "helvetica neue", arial, sans-serif;
                width: <{$block.galleria_panelwidth}>px;
                margin: 20px auto
            }

            #galleria {
                height: <{$block.galleria_height}>px;
            }

            .galleria-container {
                background-color: <{$block.galleria_bgcolor}> !important;
            }

            .galleria-thumbnails .galleria-image {
                border: 1px solid <{$block.galleria_bcolor}>;
            }

            .galleria-thumb-nav-left, .galleria-thumb-nav-right, .galleria-info-link, .galleria-info-close, .galleria-image-nav-left, .galleria-image-nav-right {
                background: url(<{$xoops_url}>/modules/extgallery/assets/images/galleria/<{$block.galleria_bgimg}>.png) no-repeat !important;
            }
        </style>
    <{/if}>
    <{if $block.ajaxeffect == 'microgallery'}>
        <script type="text/javascript">
            $(function () {
                $("#mG1").microgallery({
                    menu: true,
                    size: '<{$block.micro_size}>',
                    mode: 'single'
                });
            });
        </script>
    <{/if}>
<{else}>
    <{if $block.ajaxeffect == 'galleryview'}>
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
                    panel_width: <{$block.panel_width}>,
                    panel_height: <{$block.panel_height}>,
                    frame_width: <{$block.frame_width}>,
                    frame_height: <{$block.frame_height}>,
                    transition_speed: <{$block.transition_speed}>,
                    transition_interval: <{$block.transition_interval}>,
                    overlay_color: '#<{$block.overlay_color}>',
                    overlay_opacity: '<{$block.overlay_opacity}>',
                    nav_theme: '<{$block.nav_theme}>',
                    filmstrip_position: '<{$block.position}>',
                    overlay_position: '<{$block.position}>',
                    easing: '<{$block.easing}>',
                    theme_path: '<{xoAppUrl browse.php?modules/extgallery/assets/images/galleryview/}>'
                });
            });
        </script>
        <style type="text/css">
            .gallery {
                background: #<{$block.background_color}>;
            }

            .overlay-background {
                height: <{$block.overlay_height}>px;
            }

            .overlay-background {
                background: #<{$block.overlay_color}>;
            }

            .panel-overlay {
                color: #<{$block.overlay_text_color}>;
                font-size: <{$block.overlay_font_size}>px;
            }

            .panel-overlay a {
                color: #<{$block.overlay_text_color}>;
            }

            .frame.current .img_wrap {
                border-color: #<{$block.caption_text_color}>;
            }

            .pointer {
                border-color: #<{$block.caption_text_color}>;
            }

            .galleryview_imagesize {
                max-width: <{$galleryview_framewidth}>;
                max-height: <{$galleryview_frameheight}>;
            }
        </style>
    <{/if}>
    <{if $block.ajaxeffect == 'galleria'}>
        <script type="text/javascript"
                src="<{xoAppUrl browse.php?modules/extgallery/assets/js/galleria/galleria.js}>"></script>
        <style>
            .content {
                color: #eee;
                font: 14px/1.4 "helvetica neue", arial, sans-serif;
                width: <{$block.galleria_panelwidth}>px;
                margin: 20px auto;
            }

            #galleria {
                height: <{$block.galleria_height}>px;
            }

            .galleria-container {
                background-color: <{$block.galleria_bgcolor}> !important;
            }

            .galleria-thumbnails .galleria-image {
                border: 1px solid <{$block.galleria_bcolor}>;
            }

            .galleria-thumb-nav-left, .galleria-thumb-nav-right, .galleria-info-link, .galleria-info-close, .galleria-image-nav-left, .galleria-image-nav-right {
                background: url(<{$xoops_url}>/modules/extgallery/assets/images/galleria/<{$block.galleria_bgimg}>.png) no-repeat !important;
            }
        </style>
    <{/if}>
    <{if $block.ajaxeffect == 'microgallery'}>
        <script type="text/javascript"
                src="<{xoAppUrl browse.php?modules/extgallery/assets/js/microgallery/jquery.microgallery.js}>"></script>
        <script type="text/javascript">
            $(function () {
                $("#mG1").microgallery({
                    menu: true,
                    size: '<{$block.micro_size}>',
                    mode: 'single'
                });
            });
        </script>
        <link rel="stylesheet" type="text/css"
              href="<{xoAppUrl browse.php?modules/extgallery/assets/js/microgallery/style.css}>">
    <{/if}>
<{/if}>

<{if $block.ajaxeffect == 'galleryview'}>
    <ul id="gallery">
        <{foreach item=photo from=$block.photos}>
            <li>
                <div class="panel-overlay">
                    <h2><{$photo.photo_title}></h2>
                    <{$photo.photo_desc}> <a title="<{$photo.photo_title}>"
                                             href="<{$xoops_url}>/modules/extgallery/public-photo.php?photoId=<{$photo.photo_id}>"><{$smarty.const._MB_EXTGALLERY_MOREINFO}></a></p>
                </div>
                <img class="galleryview_imagesize"
                     src="<{$xoops_url}>/uploads/extgallery/public-photo/medium/<{$photo.photo_name}>"
                     alt="<{$photo.photo_title}>" title="<{$photo.photo_title}>">
            </li>
        <{/foreach}>
    </ul>
<{/if}>

<{if $block.ajaxeffect == 'galleria'}>
    <div class="content">
        <div id="galleria">
            <{foreach item=photo from=$block.photos}>
                <img src="<{$xoops_url}>/uploads/extgallery/public-photo/medium/<{$photo.photo_name}>"
                     alt="<{$photo.photo_desc}>" title="<{$photo.photo_title}>">
            <{/foreach}>
        </div>
    </div>
    <script type="text/javascript">
        // Load the classic theme
        Galleria.loadTheme('<{xoAppUrl browse.php?modules/extgallery/assets/js/galleria/galleria.classic.min.js}>');
        // Initialize Galleria

        // Initialize Galleria
        Galleria.run('#galleria');

        //    $('#galleria').galleria({
        //      transition:        '<{$block.galleria_transition}>',
        //      transition_speed:  <{$block.galleria_tspeed}>,
        //      autoplay:          <{$block.galleria_autoplay}>
        //    });
    </script>
<{/if}>

<{if $block.ajaxeffect == 'microgallery'}>
    <div class="extmicrogalleryblock">
        <div id="mG1" class="microGallery">
            <{foreach item=photo from=$block.photos}>
                <img src="<{$xoops_url}>/uploads/extgallery/public-photo/medium/<{$photo.photo_name}>"
                     alt="<{$photo.photo_desc}>" title="<{$photo.photo_title}>">
            <{/foreach}>
        </div>
    </div>
<{/if}>
