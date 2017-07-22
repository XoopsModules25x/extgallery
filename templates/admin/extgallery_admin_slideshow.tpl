<{if $displayslideshow}>
	<fieldset>
		<legend style="font-weight:bold; color:#990000;"><{$smarty.const._AM_EXTGALLERY_SLIDESHOW_CONF}></legend>
		<div class="green bold"><{$smarty.const._AM_EXTGALLERY_SLIDESHOW_ENABLE}></div>
	</fieldset>
<{else}>
	<fieldset>
		<legend style="font-weight:bold; color:#990000;"><{$smarty.const._AM_EXTGALLERY_SLIDESHOW_CONF}></legend>
		<div class="red bold"><{$smarty.const._AM_EXTGALLERY_SLIDESHOW_NOT_ENABLE}></div>
	</fieldset>
<{/if}>

<fieldset>
	<legend style="font-weight:bold; color:#990000;"><{$smarty.const._AM_EXTGALLERY_GVIEW_CONF}></legend>
	<div><{$galleryviewform}></div>
</fieldset>
<fieldset>
	<legend style="font-weight:bold; color:#990000;"><{$smarty.const._AM_EXTGALLERY_GRIA_CONF}></legend>
	<div><{$galleriaform}></div>
</fieldset>
<fieldset>
	<legend style="font-weight:bold; color:#990000;"><{$smarty.const._AM_EXTGALLERY_GFIC_CONF}></legend>
	<div><{$gallerifficform}></div>
</fieldset>