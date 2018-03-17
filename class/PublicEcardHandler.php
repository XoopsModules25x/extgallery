<?php namespace XoopsModules\Extgallery;

/**
 * ExtGallery Class Manager
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright   {@link https://xoops.org/ XOOPS Project}
 * @license     GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @author      Zoullou (http://www.zoullou.net)
 * @package     ExtGallery
 */


use XoopsModules\Extgallery;

// defined('XOOPS_ROOT_PATH') || die('Restricted access');


/**
 * Class Extgallery\PublicEcardHandler
 */
class PublicEcardHandler extends Extgallery\PersistableObjectHandler
{
    /**
     * Extgallery\PublicEcardHandler constructor.
     * @param \XoopsDatabase $db
     */
    public function __construct(\XoopsDatabase $db)
    {
        parent::__construct($db, 'extgallery_publicecard', Extgallery\PublicEcard::class, 'ecard_id');
    }

    /**
     * @param $data
     *
     * @return bool
     */
    public function createEcard($data)
    {
        $ecard = $this->create();
        $ecard->setVars($data);
        $ecard->setVar('ecard_date', time());
        $uid = is_a($GLOBALS['xoopsUser'], 'XoopsUser') ? $GLOBALS['xoopsUser']->getVar('uid') : 0;
        $ecard->setVar('uid', $uid);
        $ecard->setVar('ecard_cardid', md5(uniqid(mt_rand(), true)));

        if (!$this->insert($ecard, true)) {
            return false;
        }
        $this->send($ecard);
    }

    /**
     * @param $ecard
     */
    public function send(&$ecard)
    {
        /** @var Extgallery\PublicPhotoHandler $photoHandler */
        $photoHandler = Extgallery\Helper::getInstance()->getHandler('PublicPhoto');
        $photo        = $photoHandler->get($ecard->getVar('photo_id'));

        $mailer = new Extgallery\Mailer('included');

        $mailer->setEcardId($ecard->getVar('ecard_cardid', 'p'));
        $mailer->setSubject(sprintf(_MD_EXTGALLERY_ECARD_TITLE, $ecard->getVar('ecard_fromname', 'p')));
        $mailer->setToEmail($ecard->getVar('ecard_toemail', 'p'));
        $mailer->setToName($ecard->getVar('ecard_toname', 'p'));
        $mailer->setFromEmail($ecard->getVar('ecard_fromemail', 'p'));
        $mailer->setFromName($ecard->getVar('ecard_fromname', 'p'));
        $mailer->setGreetings($ecard->getVar('ecard_greetings', 'p'));
        $mailer->setDescription($ecard->getVar('ecard_desc', 'p'));
        $mailer->setPhoto($photo);
        $mailer->send();
    }

    /**
     * @param $ecardId
     *
     * @return bool
     */
    public function getEcard($ecardId)
    {
        $criteria = new \Criteria('ecard_cardid', $ecardId);
        $ecard    =& $this->getObjects($criteria);
        if (1 != count($ecard)) {
            return false;
        }

        return $ecard[0];
    }
}
