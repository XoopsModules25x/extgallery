CREATE TABLE `extgallery_publiccat` (
  `cat_id` int(11) NOT NULL auto_increment,
  `cat_pid` int(11) NOT NULL default '0',
  `nleft` int(11) NOT NULL default '0',
  `nright` int(11) NOT NULL default '0',
  `nlevel` int(11) NOT NULL default '0',
  `cat_name` varchar(255) NOT NULL,
  `cat_desc` text NOT NULL,
  `cat_date` int(11) NOT NULL default '0',
  `cat_isalbum` tinyint(1) NOT NULL default '0',
  `cat_weight` int(11) NOT NULL default '0',
  `cat_nb_album` int(11) NOT NULL default '0',
  `cat_nb_photo` int(11) NOT NULL default '0',
  `cat_imgurl` varchar(150) NOT NULL,
  `photo_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`cat_id`)
) ENGINE=MyISAM CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' COMMENT='eXtGallery By Zoullou (www.Zoullou.net)' ;

CREATE TABLE `extgallery_publicecard` (
  `ecard_id` int(11) NOT NULL auto_increment,
  `ecard_cardid` varchar(32) NOT NULL,
  `ecard_fromname` varchar(60) NOT NULL,
  `ecard_fromemail` varchar(60) NOT NULL,
  `ecard_toname` varchar(60) NOT NULL,
  `ecard_toemail` varchar(60) NOT NULL,
  `ecard_greetings` varchar(50) NOT NULL,
  `ecard_desc` text NOT NULL,
  `ecard_date` int(11) NOT NULL default '0',
  `ecard_ip` varchar(15) NOT NULL,
  `uid` int(11) NOT NULL default '0',
  `photo_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`ecard_id`)
) ENGINE=MyISAM CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' COMMENT='eXtGallery By Zoullou (www.Zoullou.net)' ;

CREATE TABLE `extgallery_publicphoto` (
  `photo_id` int(11) NOT NULL auto_increment,
  `photo_title` varchar(150) NOT NULL,
  `photo_desc` text NOT NULL,
  `photo_serveur` varchar(255) NOT NULL,
  `photo_name` varchar(255) NOT NULL,
  `photo_orig_name` varchar(40) NOT NULL,
  `photo_size` float NOT NULL,
  `photo_res_x` int(11) NOT NULL,
  `photo_res_y` int(11) NOT NULL,
  `photo_hits` int(11) NOT NULL,
  `photo_comment` int(11) NOT NULL,
  `photo_rating` tinyint(4) NOT NULL,
  `photo_nbrating` int(11) NOT NULL,
  `photo_download` int(11) NOT NULL,
  `photo_ecard` int(11) NOT NULL,
  `photo_date` int(11) NOT NULL,
  `photo_havelarge` tinyint(1) NOT NULL,
  `photo_approved` tinyint(1) NOT NULL,
  `photo_extra` text NOT NULL,
  `photo_weight` int(11) NOT NULL default '0',
  `cat_id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `dohtml` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`photo_id`)
) ENGINE=MyISAM CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' COMMENT='eXtGallery By Zoullou (www.Zoullou.net)' ;

CREATE TABLE `extgallery_publicrating` (
  `rating_id` int(11) NOT NULL auto_increment,
  `photo_id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `rating_rate` tinyint(4) NOT NULL,
  PRIMARY KEY  (`rating_id`)
) ENGINE=MyISAM CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' COMMENT='eXtGallery By Zoullou (www.Zoullou.net)' ;

CREATE TABLE `extgallery_quota` (
  `quota_id` int(11) NOT NULL auto_increment,
  `groupid` int(11) NOT NULL,
  `quota_name` varchar(255) NOT NULL,
  `quota_value` int(11) NOT NULL,
  PRIMARY KEY  (`quota_id`)
) ENGINE=MyISAM CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' COMMENT='eXtGallery By Zoullou (www.Zoullou.net)' ;
