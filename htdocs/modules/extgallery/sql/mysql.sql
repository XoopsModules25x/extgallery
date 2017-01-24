CREATE TABLE `extgallery_publiccat` (
  `cat_id` int(11) NOT NULL auto_increment,
  `cat_pid` int(11) NOT NULL default '0',
  `nleft` int(11) NOT NULL default '0',
  `nright` int(11) NOT NULL default '0',
  `nlevel` int(11) NOT NULL default '0',
  `cat_name` varchar(255) NOT NULL default '' ,
  `cat_desc` text NULL,
  `cat_date` int(11) NOT NULL default '0',
  `cat_isalbum` tinyint(1) NOT NULL default '0',
  `cat_weight` int(11) NOT NULL default '0',
  `cat_nb_album` int(11) NOT NULL default '0',
  `cat_nb_photo` int(11) NOT NULL default '0',
  `cat_imgurl` varchar(150) NOT NULL default '',
  `photo_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`cat_id`)
) ENGINE=MyISAM CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' ;

CREATE TABLE `extgallery_publicecard` (
  `ecard_id` int(11) NOT NULL auto_increment,
  `ecard_cardid` varchar(32) NOT NULL default '',
  `ecard_fromname` varchar(60) NOT NULL default '',
  `ecard_fromemail` varchar(60) NOT NULL default '',
  `ecard_toname` varchar(60) NOT NULL default '',
  `ecard_toemail` varchar(60) NOT NULL default '',
  `ecard_greetings` varchar(50) NOT NULL default '',
  `ecard_desc` text NULL,
  `ecard_date` int(11) NOT NULL default '0',
  `ecard_ip` varchar(15) NOT NULL default '',
  `uid` int(11) NOT NULL default '0',
  `photo_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`ecard_id`)
) ENGINE=MyISAM CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' ;

CREATE TABLE `extgallery_publicphoto` (
  `photo_id` int(11) NOT NULL auto_increment,
  `photo_title` varchar(150) NOT NULL default '',
  `photo_desc` text NULL,
  `photo_serveur` varchar(255) NOT NULL default '',
  `photo_name` varchar(255) NOT NULL default '',
  `photo_orig_name` varchar(40) NOT NULL default '',
  `photo_size` float NOT NULL default '0',
  `photo_res_x` int(11) NOT NULL default '0',
  `photo_res_y` int(11) NOT NULL default '0',
  `photo_hits` int(11) NOT NULL default '0',
  `photo_comment` int(11) NOT NULL default '0',
  `photo_rating` tinyint(4) NOT NULL default '0',
  `photo_nbrating` int(11) NOT NULL default '0',
  `photo_download` int(11) NOT NULL default '0',
  `photo_ecard` int(11) NOT NULL default '0',
  `photo_date` int(11) NOT NULL default '0',
  `photo_havelarge` tinyint(1) NOT NULL default '0',
  `photo_approved` tinyint(1) NOT NULL default '0',
  `photo_extra` text NULL,
  `photo_weight` int(11) NOT NULL default '0',
  `cat_id` int(11) NOT NULL default '0',
  `uid` int(11) NOT NULL default '0',
  `dohtml` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`photo_id`)
) ENGINE=MyISAM CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' ;

CREATE TABLE `extgallery_publicrating` (
  `rating_id` int(11) NOT NULL auto_increment,
  `photo_id` int(11) NOT NULL default '0',
  `uid` int(11) NOT NULL default '0',
  `rating_rate` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`rating_id`)
) ENGINE=MyISAM CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' ;

CREATE TABLE `extgallery_quota` (
  `quota_id` int(11) NOT NULL auto_increment,
  `groupid` int(11) NOT NULL default '0',
  `quota_name` varchar(255) NOT NULL default '',
  `quota_value` int(11) NOT NULL default '0',
  PRIMARY KEY  (`quota_id`)
) ENGINE=MyISAM CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' ;
