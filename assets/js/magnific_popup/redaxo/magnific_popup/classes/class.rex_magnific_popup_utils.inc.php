<?php

/**
 * Class rex_magnific_popup_utils
 */
class rex_magnific_popup_utils
{
    /**
     * @param $params
     * @return mixed
     */
    public static function includeMagnificPopup($params)
    {
        global $REX;

        $insert = PHP_EOL;
        $insert .= "\t" . '<!-- BEGIN AddOn Magnific Popup -->' . PHP_EOL;
        $insert .= "\t" . '<link rel="stylesheet" type="text/css" href="' . $REX['HTDOCS_PATH'] . 'files/addons/magnific_popup/magnific-popup.css" media="screen" >' . PHP_EOL;
        $insert .= "\t" . '<link rel="stylesheet" type="text/css" href="' . $REX['HTDOCS_PATH'] . 'files/addons/magnific_popup/custom.css" media="screen" >' . PHP_EOL;

        if (1 == $REX['ADDON']['magnific_popup']['settings']['include_jquery']) {
            $insert .= "\t" . '<script type="text/javascript" src="' . $REX['HTDOCS_PATH'] . 'files/addons/magnific_popup/jquery.min.js"></script>' . PHP_EOL;
        }

        $insert .= "\t" . '<script type="text/javascript" src="' . $REX['HTDOCS_PATH'] . 'files/addons/magnific_popup/jquery.magnific-popup.min.js"></script>' . PHP_EOL;
        $insert .= "\t" . '<script type="text/javascript" src="' . $REX['HTDOCS_PATH'] . 'files/addons/magnific_popup/init.js"></script>' . PHP_EOL;
        $insert .= "\t" . '<!-- END AddOn Magnific Popup -->' . PHP_EOL;

        return str_replace('</head>', $insert . '</head>', $params['subject']);
    }

    /**
     * @param       $mdFile
     * @param array $search
     * @param array $replace
     * @return mixed|string
     */
    public static function getHtmlFromMDFile($mdFile, $search = array(), $replace = array())
    {
        global $REX;

        $curLocale = strtolower($REX['LANG']);

        if ('de_de' === $curLocale) {
            $file = $REX['INCLUDE_PATH'] . '/addons/magnific_popup/' . $mdFile;
        } else {
            $file = $REX['INCLUDE_PATH'] . '/addons/magnific_popup/lang/' . $curLocale . '/' . $mdFile;
        }

        if (file_exists($file)) {
            $md = file_get_contents($file);
            $md = str_replace($search, $replace, $md);
            $md = self::makeHeadlinePretty($md);

            return Parsedown::instance()->parse($md);
        } else {
            return '[translate:' . $file . ']';
        }
    }

    /**
     * @param $md
     * @return mixed
     */
    public static function makeHeadlinePretty($md)
    {
        return str_replace('Magnific Popup AddOn - ', '', $md);
    }
}
