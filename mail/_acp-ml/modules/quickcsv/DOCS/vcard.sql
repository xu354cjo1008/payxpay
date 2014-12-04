DROP TABLE IF EXISTS master_vcard;
CREATE TABLE IF NOT EXISTS master_vcard (
  userid int(11) NOT NULL auto_increment,

  custnum varchar(25) NOT NULL default '',

  gender enum('M','F') NOT NULL default 'M',

  name_formatted varchar(255) NOT NULL default '',
  name_family varchar(64) NOT NULL default '',
  name_given varchar(64) NOT NULL default '',
  name_additional varchar(64) NOT NULL default '',
  name_prefix varchar(64) NOT NULL default '',
  name_suffix varchar(64) NOT NULL default '',
  name_alternate varchar(255) NOT NULL default '',
  
  bday varchar(10) NOT NULL default '',

  addr_locality varchar(15) NOT NULL default 'DOM',

  addr_home_street1 varchar(255) NOT NULL default '',
  addr_home_street2 varchar(255) NOT NULL default '',
  addr_home_city varchar(50) NOT NULL default '',
  addr_home_state varchar(32) NOT NULL default '',
  addr_home_zip varchar(15) NOT NULL default '',
  addr_home_country varchar(15) NOT NULL default '',
  
  addr_work_street1 varchar(255) NOT NULL default '',
  addr_work_street2 varchar(255) NOT NULL default '',
  addr_work_city varchar(50) NOT NULL default '',
  addr_work_state varchar(32) NOT NULL default '',
  addr_work_zip varchar(15) NOT NULL default '',
  addr_work_country varchar(15) NOT NULL default '',
  
  tel_pref varchar(15) default NULL,
  tel_home varchar(15) default NULL,
  tel_work varchar(15) default NULL,
  tel_msg varchar(5) default NULL,
  tel_fax varchar(15) default NULL,
  tel_cell varchar(15) default NULL,
  tel_pager varchar(15) default NULL,

  email varchar(255) default NULL,
  email1 varchar(255) default NULL,
  email2 varchar(255) default NULL,

  followup_email enum('Y','N',' ') NOT NULL default ' ',
  followup_mail enum('Y','N',' ') NOT NULL default ' ',
  followup_phone enum('Y','N',' ') NOT NULL default ' ',

  activity_date varchar(50) default NULL,

  `comment` text,

  PRIMARY KEY  (userid)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;
