#
# Table structure for table 'tx_otfaq_domain_model_question'
#
CREATE TABLE tx_otfaq_domain_model_question
(
	question          varchar(255)     DEFAULT '' NOT NULL,
	answer            text             DEFAULT '' NOT NULL,
	link              varchar(1024)    DEFAULT '' NOT NULL,
	related_questions int(11) unsigned DEFAULT 0  NOT NULL,
	tags              int(11) unsigned DEFAULT 0  NOT NULL,
	categories        int(11) unsigned DEFAULT 0  NOT NULL,
);

#
# Table structure for table 'tx_otfaq_domain_model_tag'
#
CREATE TABLE tx_otfaq_domain_model_tag
(
	tag varchar(255) DEFAULT '' NOT NULL,
);

#
# Table structure for table 'tx_otfaq_question_question_mm'
#
CREATE TABLE tx_otfaq_question_question_mm
(
	uid_local       int(11) unsigned DEFAULT '0' NOT NULL,
	uid_foreign     int(11) unsigned DEFAULT '0' NOT NULL,
	sorting         int(11) unsigned DEFAULT '0' NOT NULL,
	sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid_local, uid_foreign),
	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)
);

#
# Table structure for table 'tx_otfaq_question_question_mm'
#
CREATE TABLE tx_otfaq_question_tag_mm
(
	uid_local       int(11) unsigned DEFAULT '0' NOT NULL,
	uid_foreign     int(11) unsigned DEFAULT '0' NOT NULL,
	sorting         int(11) unsigned DEFAULT '0' NOT NULL,
	sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid_local, uid_foreign),
	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)
);
