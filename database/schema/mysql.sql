CREATE TABLE IF NOT EXISTS `paste` (
  `pid` int(11) NOT NULL auto_increment,
  `poster` varchar(16) default NULL,
  `posted` datetime default NULL,
  `code` text,
  `parent_pid` int(11) default '0',
  `format` varchar(16) default NULL,
  `codefmt` mediumtext,
  `codecss` text,
  `expires` datetime default NULL,
  `expiry_flag` enum('d','m','f') NOT NULL default 'f',
  `password` varchar(250) default NULL,
  PRIMARY KEY  (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE `dbrev` (
    `id` int(11) NOT NULL auto_increment,
    `revision` varchar(32) NOT NULL,
    `updated` datetime NOT NULL DEFAULT NOW(),
    `updatename` VARCHAR(100) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE (`revision`, `updatename`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE `user` (
    `id` serial NOT NULL,
    `username` VARCHAR(40) NOT NULL,
    `password` VARCHAR(40) NOT NULL,
    `active` BOOLEAN NOT NULL DEFAULT true,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_general_ci AUTO_INCREMENT=1;

CREATE TABLE `group` (
    `id` serial NOT NULL,
    `groupname` VARCHAR(40) NOT NULL,
    `parent_group` INTEGER,
    PRIMARY KEY (`id`   )
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_general_ci AUTO_INCREMENT=1;

CREATE TABLE `membership` (
    `id` serial NOT NULL,
    `group_id` INTEGER,
    `user_id` INTEGER,
    PRIMARY KEY(`id`),
    UNIQUE(`group_id`, `user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE utf8_general_ci AUTO_INCREMENT=1;