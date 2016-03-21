<?php
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
 * @copyright   {@link http://xoops.org/ XOOPS Project}
 * @license     GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @author      Zoullou (http://www.zoullou.net)
 * @package     ExtGallery
 * @version     $Id: extgalleryMailer.php 8088 2011-11-06 09:38:12Z beckmi $
 */

// defined('XOOPS_ROOT_PATH') || exit('XOOPS root path not defined');

include_once XOOPS_ROOT_PATH . '/class/mail/xoopsmultimailer.php';

/**
 * Class extgalleryMailer
 */
class extgalleryMailer
{
    public $mailer;
    public $type;
    public $tags = array();

    public $ecardId;
    public $subject;
    public $toEmail;
    public $toName;
    public $fromEmail;
    public $fromName;
    public $greetings;
    public $description;
    public $photo;

    /**
     * @param $type
     */
    public function __construct($type)
    {
        $this->mailer = new XoopsMultiMailer();
        $this->type   = $type;
    }

    public function imageIncluded()
    {
        if ($this->photo->getVar('photo_serveur') == '') {
            $photoPath = XOOPS_ROOT_PATH . '/uploads/extgallery/public-photo/medium/' . $this->photo->getVar('photo_name');
        } else {
            $photoPath = $this->photo->getVar('photo_serveur') . $this->photo->getVar('photo_name');
        }
        $this->tags['PHOTO_SRC'] = 'cid:photo';
        $this->tags['STAMP_SRC'] = 'cid:stamp';
        $this->mailer->addEmbeddedImage($photoPath, 'photo');
        $this->mailer->addEmbeddedImage(XOOPS_ROOT_PATH . '/modules/extgallery/assets/images/stamp.gif', 'stamp');
    }

    public function imageLinked()
    {
        if ($this->photo->getVar('photo_serveur') == '') {
            $photoUrl = XOOPS_URL . '/uploads/extgallery/public-photo/medium/' . $this->photo->getVar('photo_name');
        } else {
            $photoUrl = $this->photo->getVar('photo_serveur') . $this->photo->getVar('photo_name');
        }
        $this->tags['PHOTO_SRC'] = $photoUrl;
        $this->tags['STAMP_SRC'] = XOOPS_URL . '/modules/extgallery/assets/images/stamp.gif';
    }

    public function send()
    {
        $this->assignTags();
        if ($this->type === 'included') {
            $this->imageIncluded();
        } elseif ($this->type === 'linked') {
            $this->imageLinked();
        }

        $this->mailer->From     = $this->fromEmail;
        $this->mailer->FromName = $this->fromName;
        $this->mailer->Subject  = $this->subject;
        $this->mailer->Body     = $this->loadTemplate('ecard_html.tpl');
        $this->mailer->AltBody  = $this->loadTemplate('ecard_text.tpl');
        $this->mailer->addAddress($this->toEmail, $this->toName);
        //$this->mailer->AddReplyTo($this->fromEmail, $this->fromName);
        $this->mailer->send();
    }

    public function assignTags()
    {
        $this->tags['ECARD_LINK']  = XOOPS_URL . '/modules/extgallery/public-viewecard.php?id=' . $this->ecardId;
        $this->tags['EXP_EMAIL']   = $this->fromEmail;
        $this->tags['EXP_NAME']    = $this->fromName;
        $this->tags['REC_NAME']    = $this->toName;
        $this->tags['GREETINGS']   = $this->greetings;
        $this->tags['DESCRIPTION'] = $this->description;
        $this->tags['MODULE_LINK'] = XOOPS_URL . '/modules/extgallery/';
        $this->tags['SITE_NAME']   = $GLOBALS['xoopsConfig']['sitename'];
        $this->tags['SITE_URL']    = XOOPS_URL;
    }

    /**
     * @param $name
     *
     * @return mixed|string
     */
    public function loadTemplate($name)
    {
        global $xoopsConfig;

        if (file_exists(XOOPS_ROOT_PATH . '/modules/extgallery/language/' . $xoopsConfig['language'] . '/mail_template/' . $name)) {
            $path = XOOPS_ROOT_PATH . '/modules/extgallery/language/' . $xoopsConfig['language'] . '/mail_template/' . $name;
        } else {
            $path = XOOPS_ROOT_PATH . '/modules/extgallery/language/english/mail_template/' . $name;
        }
        $fd   = @fopen($path, 'r');
        $body = fread($fd, filesize($path));
        // replace tags with actual values
        foreach ($this->tags as $k => $v) {
            $body = str_replace('{' . $k . '}', $v, $body);
        }

        return $body;
    }

    /**
     * @param $ecardId
     */
    public function setEcardId($ecardId)
    {
        $this->ecardId = $ecardId;
    }

    /**
     * @param $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * @param $email
     */
    public function setToEmail($email)
    {
        $this->toEmail = $email;
    }

    /**
     * @param $name
     */
    public function setToName($name)
    {
        $this->toName = $name;
    }

    /**
     * @param $email
     */
    public function setFromEmail($email)
    {
        $this->fromEmail = $email;
    }

    /**
     * @param $name
     */
    public function setFromName($name)
    {
        $this->fromName = $name;
    }

    /**
     * @param $greetings
     */
    public function setGreetings($greetings)
    {
        $this->greetings = $greetings;
    }

    /**
     * @param $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @param $photo
     */
    public function setPhoto(&$photo)
    {
        $this->photo = $photo;
    }
}
