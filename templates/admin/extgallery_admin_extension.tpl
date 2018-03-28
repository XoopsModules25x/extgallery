<fieldset>
    <legend style="font-weight:bold; color:#990000;"><{$smarty.const._AM_EXTGALLERY_EXTENSION_INFO}></legend>
    <{if $extensioninstalled}>
        <div class="marg5 bold green big"><{$smarty.const._AM_EXTGALLERY_EXTENSION_OK}></div>
    <{else}>
        <div class="marg5 bold red maxi"><{$smarty.const._AM_EXTGALLERY_EXTENSION_NOT_INSTALLED}></div>
        <br>
        <form action="install-extension.php" method="post">
            <{securityToken}><{*//mb*}>
            <input type="hidden" name="step" value="download">
            <input class="formButton" value="<{$smarty.const._AM_EXTGALLERY_INSTALL_EXTENSION}>" type="submit">
        </form>
    <{/if}>
    <div class="marg10"><{$smarty.const._AM_EXTGALLERY_EXTENSION_NOTICE}></div>
</fieldset>

<fieldset>
    <legend style="font-weight:bold; color:#990000;"><{$smarty.const._AM_EXTGALLERY_EXTENSION_HOWTO}></legend>
    <div class="marg10 bold"><{$smarty.const._AM_EXTGALLERY_EXTENSION_HOWTO}></div>
    <div class="marg10"><{$smarty.const._AM_EXTGALLERY_EXTENSION_HOWTODESC}></div>
    <div class="marg10 center">
        <a href="http://xoops.svn.sourceforge.net/viewvc/xoops/XoopsModules/extgallery/trunk/class/?view=tar"><{$smarty.const._AM_EXTGALLERY_EXTENSION_DOWNLOAD}></a>
    </div>
</fieldset>
