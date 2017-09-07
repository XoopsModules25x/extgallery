<?php
/**
 * ExtGallery functions
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright   XOOPS Project (https://xoops.org)
 * @license     GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @author      Zoullou (http://www.zoullou.net)
 * @package     ExtGallery
 */

return $config = [
    'modulePerm' => [
        1 => [
            'maskId'    => 1,
            'name'      => 'public_access',
            'maskTitle' => '_AM_EXTGALLERY_CAN_ACCESS',
            'title'     => '_AM_EXTGALLERY_ACCESS_PERM',
            'desc'      => '_AM_EXTGALLERY_ACCESS_PERM_DESC',
            'info'      => '_AM_EXTGALLERY_ACCESS_PERM_INFO'
        ],
        2 => [
            'maskId'    => 2,
            'name'      => 'public_rate',
            'maskTitle' => '_AM_EXTGALLERY_CAN_RATE',
            'title'     => '_AM_EXTGALLERY_RATE_PERM',
            'desc'      => '_AM_EXTGALLERY_RATE_PERM_DESC',
            'info'      => '_AM_EXTGALLERY_RATE_PERM_INFO'
        ],
        3 => [
            'maskId'    => 4,
            'name'      => 'public_ecard',
            'maskTitle' => '_AM_EXTGALLERY_CAN_SEND_ECARD',
            'title'     => '_AM_EXTGALLERY_PUBLIC_ECARD',
            'desc'      => '_AM_EXTGALLERY_PUBLIC_ECARD_DESC',
            'info'      => '_AM_EXTGALLERY_PUBLIC_ECARD_INFO'
        ],
        4 => [
            'maskId'    => 8,
            'name'      => 'public_download',
            'maskTitle' => '_AM_EXTGALLERY_CAN_DOWNLOAD',
            'title'     => '_AM_EXTGALLERY_PUBLIC_DOWNLOAD',
            'desc'      => '_AM_EXTGALLERY_PUBLIC_DOWNLOAD_DESC',
            'info'      => '_AM_EXTGALLERY_PUBLIC_DOWNLOAD_INFO'
        ],
        5 => [
            'maskId'    => 16,
            'name'      => 'public_download_original',
            'maskTitle' => '_AM_EXTGALLERY_CAN_DOWNLOAD_ORIG',
            'title'     => '_AM_EXTGALLERY_PUBLIC_DOWNLOAD_ORIG',
            'desc'      => '_AM_EXTGALLERY_PUBLIC_DOWNLOAD_ORIG_DESC',
            'info'      => '_AM_EXTGALLERY_PUBLIC_DOWNLOAD_ORIG_INFO'
        ],
        6 => [
            'maskId'    => 32,
            'name'      => 'public_upload',
            'maskTitle' => '_AM_EXTGALLERY_CAN_UPLOAD',
            'title'     => '_AM_EXTGALLERY_PUBLIC_UPLOAD',
            'desc'      => '_AM_EXTGALLERY_PUBLIC_UPLOAD_DESC',
            'info'      => '_AM_EXTGALLERY_PUBLIC_UPLOAD_INFO'
        ],
        7 => [
            'maskId'    => 64,
            'name'      => 'public_autoapprove',
            'maskTitle' => '_AM_EXTGALLERY_AUTOAPPROVE',
            'title'     => '_AM_EXTGALLERY_PUBLIC_AUTOAPROVE',
            'desc'      => '_AM_EXTGALLERY_PUBLIC_AUTOAPROVE_DESC',
            'info'      => '_AM_EXTGALLERY_PUBLIC_AUTOAPROVE_INFO'
        ],
        8 => [
            'maskId'    => 128,
            'name'      => 'public_displayed',
            'maskTitle' => '_AM_EXTGALLERY_DISPLAYED',
            'title'     => '_AM_EXTGALLERY_PUBLIC_DISPLAYED',
            'desc'      => '_AM_EXTGALLERY_PUBLIC_DISPLAYED_DESC',
            'info'      => '_AM_EXTGALLERY_PUBLIC_DISPLAYED_INFO'
        ]
    ],
    'pluginPerm' => []
];
