<{if $uploadfont}>
    <div>
        <fieldset>
            <legend style="font-weight:bold; color:#990000;"><{$smarty.const._AM_EXTGALLERY_AVAILABLE_FONT}></legend>
            <{foreach item=font from=$fonts}>
                <{$font}> ,
            <{/foreach}>
            <{$fontform}>
        </fieldset>
    </div>
<{else}>
    <div>
        <fieldset>
            <legend style="font-weight:bold; color:#990000;"><{$smarty.const._AM_EXTGALLERY_FONT_MANAGMENT}></legend>
            <div><{$nbfonts}></div>
            <{foreach item=font from=$fonts}>
                <{$font}> ,
            <{/foreach}>
        </fieldset>
    </div>
    <div>
        <fieldset>
            <legend style="font-weight:bold; color:#990000;"><{$smarty.const._AM_EXTGALLERY_WATERMARK_CONF}></legend>
            <{if $imagettfbbox}>
                <{$watermarkform}>
            <{else}>
                <{$freetypewarn}>
            <{/if}>
        </fieldset>
    </div>
    <div>
        <fieldset>
            <legend style="font-weight:bold; color:#990000;"><{$smarty.const._AM_EXTGALLERY_BORDER_CONF}></legend>
            <{$borderform}>
        </fieldset>
    </div>
    <div>
        <fieldset>
            <legend style="font-weight:bold; color:#990000;"><{$smarty.const._AM_EXTGALLERY_WATERMARK_BORDER_EXEMPLE}></legend>
            <fieldset>
                <legend style="font-weight:bold; color:#0A3760;"><{$smarty.const._AM_EXTGALLERY_INFORMATION}></legend>
                <{$smarty.const._AM_EXTGALLERY_WATERMARK_BORDER_EXEMPLE_INFO}>
            </fieldset>
            <div style="text-align:center; padding:10px;"><img src="../assets/images/<{$imagetest}>"></div>
        </fieldset>
    </div>
<{/if}>
