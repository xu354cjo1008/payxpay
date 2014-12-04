CREATE TABLE IF NOT EXISTS master_vcard (
  userid int(11) NOT NULL auto_increment,

  custnum varchar(25) default NULL,

  gender enum('M','F') default NULL,

  name_formatted varchar(255) default NULL,
  name_family varchar(64) default NULL,
  name_given varchar(64) default NULL,
  name_additional varchar(64) default NULL,
  name_prefix varchar(64) default NULL,
  name_suffix varchar(64) default NULL,
  name_alternate varchar(255) default NULL,
  
  bday varchar(10) default NULL,

  addr_locality varchar(15) NOT NULL default 'DOM',

  addr_home_street1 varchar(255) default NULL,
  addr_home_street2 varchar(255) default NULL,
  addr_home_city varchar(50) default NULL,
  addr_home_state varchar(32) default NULL,
  addr_home_zip varchar(15) default NULL,
  addr_home_country varchar(15) default NULL,
  
  addr_work_street1 varchar(255) default NULL,
  addr_work_street2 varchar(255) default NULL,
  addr_work_city varchar(50) default NULL,
  addr_work_state varchar(32) default NULL,
  addr_work_zip varchar(15) default NULL,
  addr_work_country varchar(15) default NULL,
  
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
