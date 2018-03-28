<?php
// module: magnific_popup_gallery_out

$imageType = 'magnific_popup_gallery_thumb';
$mediaList = 'REX_MEDIALIST[1]';

if ('' != $mediaList) {
    echo '<div class="magnific-popup-gallery">';

    // get media dir
    if (isset($REX['MEDIA_DIR'])) {
        $mediaDir = $REX['MEDIA_DIR'];
    } else {
        $mediaDir = 'files';
    }

    // get list with all images
    $images = explode(',', $mediaList);

    // make thumbs
    foreach ($images as $imageFile) {
        $media = OOMedia::getMediaByFilename($imageFile);

        // get title and description
        if (OOMedia::isValid($media)) {
            $title       = $media->getValue('title');
            $description = $media->getValue('med_description');
        } else {
            $title       = '';
            $description = '';
        }

        // generate image url
        $imageUrl = $REX['HTDOCS_PATH'] . $mediaDir . '/' . $imageFile;

        // generate image manager url
        if (class_exists('seo42')) {
            $imageManagerUrl = seo42::getImageManagerUrl($imageFile, $imageType);
        } else {
            if ($REX['REDAXO']) {
                $imageManagerUrl = $REX['HTDOCS_PATH'] . 'redaxo/index.php?rex_img_type=' . $imageType . '&amp;rex_img_file=' . $imageFile;
            } else {
                $imageManagerUrl = $REX['HTDOCS_PATH'] . 'index.php?rex_img_type=' . $imageType . '&amp;rex_img_file=' . $imageFile;
            }
        }

        // get dimensions of image manager image
        $resizedFile = $REX['INCLUDE_PATH'] . '/generated/files/image_manager__' . $imageType . '_' . $imageFile;
        $imageSize   = @getimagesize($resizedFile);

        if (false != $imageSize) {
            $imageDimensions = ' width="' . $imageSize[0] . '" height="' . $imageSize[1] . '"';
        } else {
            $imageDimensions = '';
        }

        // html code
        echo '<a href="' . $imageUrl . '" title="' . $description . '">';
        echo '<img src="' . $imageManagerUrl . '"' . $imageDimensions . ' alt="' . $title . '" >';
        echo '</a>';
    }

    echo '<div class="clearer"></div>';
    echo '</div>';
}
