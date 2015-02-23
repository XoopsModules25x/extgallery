<{if $displayalbum}>
	<fieldset>
		<legend style="font-weight:bold; color:#990000;"><{$smarty.const._AM_EXTGALLERY_ALBUM_CONF}></legend>
		<div class="green bold"><{$smarty.const._AM_EXTGALLERY_ALBUM_ENABLE}></div>
	</fieldset>
<{else}>
	<fieldset>
		<legend style="font-weight:bold; color:#990000;"><{$smarty.const._AM_EXTGALLERY_ALBUM_CONF}></legend>
		<div class="red bold"><{$smarty.const._AM_EXTGALLERY_ALBUM_NOT_ENABLE}></div>
	</fieldset>
<{/if}>

<fieldset>
	<legend style="font-weight:bold; color:#990000;"><{$smarty.const._AM_EXTGALLERY_OVERLAY_CONF}></legend>
	<{$overlayform}>
</fieldset>

<fieldset>
	<legend style="font-weight:bold; color:#990000;"><{$smarty.const._AM_EXTGALLERY_TOOLTIP_CONF}></legend>
	<{$tooltipform}>
</fieldset>

<fieldset>
	<legend style="font-weight:bold; color:#990000;"><{$smarty.const._AM_EXTGALLERY_FANCYBOX_CONF}></legend>
	<{$fancyboxform}>
</fieldset>

<fieldset>
	<legend style="font-weight:bold; color:#990000;"><{$smarty.const._AM_EXTGALLERY_PRETTPHOTO_CONF}></legend>
	<{$prettyphotoform}>
</fieldset>