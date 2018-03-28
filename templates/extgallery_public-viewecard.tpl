<div class="extgallery">
    <table id="viewecard">
        <tr>
            <td>
                <img src="<{$ecard.photoUrl}>" alt="<{$ecard.ecard_greetings}>"
                     title="eCard from <{$ecard.ecard_fromname}>"><br>
            </td>
            <td id="viewecardtd">
                <div class="txtright">
                    <img src="<{xoAppUrl modules/extgallery/}>assets/images/stamp.gif"
                         alt="<{$ecard.ecard_greetings}>">
                </div>
                <h2><{$ecard.ecard_greetings}></h2>
                <p><{$ecard.ecard_desc}></p>
                <p><{$ecard.ecard_fromname}><br>
                    (<a title="<{$ecard.ecard_fromemail}>"
                        href="mailto:<{$ecard.ecard_fromemail}>"><{$ecard.ecard_fromemail}></a>)</p>
            </td>
        </tr>
    </table>
    <p class="txtcenter">
        <a title="<{$lang.clickFormMore}>" href="<{xoAppUrl modules/extgallery/}>"><{$lang.clickFormMore}></a>
    </p>
</div>
