<?xml version="1.0" encoding="<{$channel_charset}>"?>
<rss version="2.0">
    <channel>
        <title><{$channel_title}></title>
        <link>
        <{$channel_link}></link>
        <description><{$channel_desc}></description>
        <lastBuildDate><{$channel_lastbuild}></lastBuildDate>
        <docs>http://backend.userland.com/rss/</docs>
        <generator><{$channel_generator}></generator>
        <category><{$channel_category}></category>
        <managingEditor><{$channel_editor}></managingEditor>
        <webMaster><{$channel_webmaster}></webMaster>
        <language><{$channel_language}></language>
        <{if $image_url != ""}>
            <image>
                <title><{$channel_title}></title>
                <url><{$image_url}></url>
                <link>
                <{$channel_link}></link>
                <width><{$image_width}></width>
                <height><{$image_height}></height>
            </image>
        <{/if}>
        <{section name=photo loop=$photos}>
            <item>
                <title><{$photos[photo].photo_title}></title>
                <link><{xoAppUrl modules/extgallery/}>public-photo.php?photoId=<{$photos[photo].photo_id}>
                #photoNav</link>
                <description><{$photos[photo].photo_desc}>
                    <![CDATA[<br><img
                            src=<{$xoops_url}>/uploads/extgallery/public-photo/thumb/thumb_<{$photos[photo].photo_name}>
                            alt='<{$photos[photo].photo_title}>'> ]]>
                </description>
            </item>
        <{/section}>
    </channel>
</rss>
