<{if $formselectcat}>
    <fieldset>
        <legend style="font-weight:bold; color:#990000;"><{$smarty.const._AM_EXTGALLERY_MODDELETE_PUBLICCAT}></legend>
        <fieldset>
            <legend style="font-weight:bold; color:#990000;"><{$smarty.const._AM_EXTGALLERY_INFORMATION}></legend>
            <div><{$smarty.const._AM_EXTGALLERY_MODDELETE_PUBLICCAT_INFO}></div>
        </fieldset>
        <div><{$formselectcat}></div>
    </fieldset>
<{/if}>

<{if $formcreatecat}>
    <fieldset>
        <legend style="font-weight:bold; color:#990000;"><{$smarty.const._AM_EXTGALLERY_ADD_PUBLIC_CAT}></legend>
        <fieldset>
            <legend style="font-weight:bold; color:#990000;"><{$smarty.const._AM_EXTGALLERY_INFORMATION}></legend>
            <div><{$smarty.const._AM_EXTGALLERY_ADD_PUBLIC_CAT_INFO}></div>
        </fieldset>
        <div><{$formcreatecat}></div>
    </fieldset>
<{/if}>

<{if $formmodifcat}>
    <fieldset>
        <legend style="font-weight:bold; color:#990000;"><{$smarty.const._AM_EXTGALLERY_MOD_PUBLIC_CAT}></legend>
        <div><{$formmodifcat}></div>
    </fieldset>
<{/if}>
