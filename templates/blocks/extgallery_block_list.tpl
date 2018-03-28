<div class="listphotos">
    <ul>
        <{foreach item=photo from=$block.photos}>
            <li>
                <a title="<{$photo.photo_title}>"
                   href="<{$xoops_url}>/modules/extgallery/public-photo.php?photoId=<{$photo.photo_id}>"><{$photo.photo_title}></a>
                <{if $block.hits}> [ <{$photo.photo_hits}> ] <{/if}>
                <{if $block.date}> [ <{$photo.photo_date}> ] <{/if}>
                <{if $block.rate}> [ <{$photo.photo_rating}> ] <{/if}>
            </li>
        <{/foreach}>
    </ul>
</div>
