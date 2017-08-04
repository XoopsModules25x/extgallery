<div class="extgallery">
    <form id="<{$send_ecard.name}>" action="<{$send_ecard.action}>"
          method="<{$send_ecard.method}>" <{$send_ecard.extra}>>
        <table class="outer">
            <tr>
                <th colspan="3"><{$send_ecard.title}></th>
            </tr>
            <tr>
                <td class="head bold" colspan="2"><{$lang.from}></td>
                <td class="txtcenter" rowspan="6"><img src="<{$photo}>" alt="<{$lang.from}>"></td>
            </tr>
            <tr>
                <td class="odd"><{$send_ecard.elements.ecard_fromname.caption}></td>
                <td class="odd"><{$send_ecard.elements.ecard_fromname.body}></td>
            </tr>
            <tr>
                <td class="odd"><{$send_ecard.elements.ecard_fromemail.caption}></td>
                <td class="odd"><{$send_ecard.elements.ecard_fromemail.body}></td>
            </tr>
            <tr>
                <td class="head bold" colspan="2"><{$lang.to}></td>
            </tr>
            <tr>
                <td class="odd"><{$send_ecard.elements.ecard_toname.caption}></td>
                <td class="odd"><{$send_ecard.elements.ecard_toname.body}></td>
            </tr>
            <tr>
                <td class="odd"><{$send_ecard.elements.ecard_toemail.caption}></td>
                <td class="odd"><{$send_ecard.elements.ecard_toemail.body}></td>
            </tr>
            <tr>
                <td class="head bold" colspan="3"><{$send_ecard.elements.ecard_greetings.caption}></td>
            </tr>
            <tr>
                <td colspan="3" class="odd"><{$send_ecard.elements.ecard_greetings.body}></td>
            </tr>
            <tr>
                <td class="head bold" colspan="3"><{$send_ecard.elements.ecard_desc.caption}></td>
            </tr>
            <tr>
                <td colspan="3" class="odd"><{$send_ecard.elements.ecard_desc.body}></td>
            </tr>
            <{if $send_ecard.elements.captcha.body}>
                <tr>
                    <td class="head bold" colspan="3"><{$send_ecard.elements.captcha.caption}></td>
                </tr>
                <tr>
                    <td class="odd"><img src="<{xoAppUrl modules/extgallery/}>assets/images/captcha.php" alt="captcha">
                    </td>
                    <td class="odd" colspan="2"><{$send_ecard.elements.captcha.body}></td>
                </tr>
            <{/if}>
            <tr>
                <td class="txtcenter" colspan="3" class="even">
                    <{$send_ecard.elements.step.body}>
                    <{$send_ecard.elements.photo_id.body}>
                    <{$send_ecard.elements.submit.body}>
                </td>
            </tr>
        </table>
    </form>
</div>
