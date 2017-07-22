CREATE TABLE `extgallery_publiccat` (
  `cat_id`       INT(11)      NOT NULL AUTO_INCREMENT,
  `cat_pid`      INT(11)      NOT NULL DEFAULT '0',
  `nleft`        INT(11)      NOT NULL DEFAULT '0',
  `nright`       INT(11)      NOT NULL DEFAULT '0',
  `nlevel`       INT(11)      NOT NULL DEFAULT '0',
  `cat_name`     VARCHAR(255) NOT NULL DEFAULT '',
  `cat_desc`     TEXT         NULL,
  `cat_date`     INT(11)      NOT NULL DEFAULT '0',
  `cat_isalbum`  TINYINT(1)   NOT NULL DEFAULT '0',
  `cat_weight`   INT(11)      NOT NULL DEFAULT '0',
  `cat_nb_album` INT(11)      NOT NULL DEFAULT '0',
  `cat_nb_photo` INT(11)      NOT NULL DEFAULT '0',
  `cat_imgurl`   VARCHAR(150) NOT NULL DEFAULT '',
  `photo_id`     INT(11)      NOT NULL DEFAULT '0',
  PRIMARY KEY (`cat_id`)
)
  ENGINE = MyISAM
  CHARACTER SET 'utf8'
  COLLATE 'utf8_general_ci';

CREATE TABLE `extgallery_publicecard` (
  `ecard_id`        INT(11)     NOT NULL AUTO_INCREMENT,
  `ecard_cardid`    VARCHAR(32) NOT NULL DEFAULT '',
  `ecard_fromname`  VARCHAR(60) NOT NULL DEFAULT '',
  `ecard_fromemail` VARCHAR(60) NOT NULL DEFAULT '',
  `ecard_toname`    VARCHAR(60) NOT NULL DEFAULT '',
  `ecard_toemail`   VARCHAR(60) NOT NULL DEFAULT '',
  `ecard_greetings` VARCHAR(50) NOT NULL DEFAULT '',
  `ecard_desc`      TEXT        NULL,
  `ecard_date`      INT(11)     NOT NULL DEFAULT '0',
  `ecard_ip`        VARCHAR(15) NOT NULL DEFAULT '',
  `uid`             INT(11)     NOT NULL DEFAULT '0',
  `photo_id`        INT(11)     NOT NULL DEFAULT '0',
  PRIMARY KEY (`ecard_id`)
)
  ENGINE = MyISAM
  CHARACTER SET 'utf8'
  COLLATE 'utf8_general_ci';

CREATE TABLE `extgallery_publicphoto` (
  `photo_id`        INT(11)      NOT NULL AUTO_INCREMENT,
  `photo_title`     VARCHAR(150) NOT NULL DEFAULT '',
  `photo_desc`      TEXT         NULL,
  `photo_serveur`   VARCHAR(255) NOT NULL DEFAULT '',
  `photo_name`      VARCHAR(255) NOT NULL DEFAULT '',
  `photo_orig_name` VARCHAR(40)  NOT NULL DEFAULT '',
  `photo_size`      FLOAT        NOT NULL DEFAULT '0',
  `photo_res_x`     INT(11)      NOT NULL DEFAULT '0',
  `photo_res_y`     INT(11)      NOT NULL DEFAULT '0',
  `photo_hits`      INT(11)      NOT NULL DEFAULT '0',
  `photo_comment`   INT(11)      NOT NULL DEFAULT '0',
  `photo_rating`    TINYINT(4)   NOT NULL DEFAULT '0',
  `photo_nbrating`  INT(11)      NOT NULL DEFAULT '0',
  `photo_download`  INT(11)      NOT NULL DEFAULT '0',
  `photo_ecard`     INT(11)      NOT NULL DEFAULT '0',
  `photo_date`      INT(11)      NOT NULL DEFAULT '0',
  `photo_havelarge` TINYINT(1)   NOT NULL DEFAULT '0',
  `photo_approved`  TINYINT(1)   NOT NULL DEFAULT '0',
  `photo_extra`     TEXT         NULL,
  `photo_weight`    INT(11)      NOT NULL DEFAULT '0',
  `cat_id`          INT(11)      NOT NULL DEFAULT '0',
  `uid`             INT(11)      NOT NULL DEFAULT '0',
  `dohtml`          TINYINT(1)   NOT NULL DEFAULT '0',
  PRIMARY KEY (`photo_id`)
)
  ENGINE = MyISAM
  CHARACTER SET 'utf8'
  COLLATE 'utf8_general_ci';

CREATE TABLE `extgallery_publicrating` (
  `rating_id`   INT(11)    NOT NULL AUTO_INCREMENT,
  `photo_id`    INT(11)    NOT NULL DEFAULT '0',
  `uid`         INT(11)    NOT NULL DEFAULT '0',
  `rating_rate` TINYINT(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`rating_id`)
)
  ENGINE = MyISAM
  CHARACTER SET 'utf8'
  COLLATE 'utf8_general_ci';

CREATE TABLE `extgallery_quota` (
  `quota_id`    INT(11)      NOT NULL AUTO_INCREMENT,
  `groupid`     INT(11)      NOT NULL DEFAULT '0',
  `quota_name`  VARCHAR(255) NOT NULL DEFAULT '',
  `quota_value` INT(11)      NOT NULL DEFAULT '0',
  PRIMARY KEY (`quota_id`)
)
  ENGINE = MyISAM
  CHARACTER SET 'utf8'
  COLLATE 'utf8_general_ci';
