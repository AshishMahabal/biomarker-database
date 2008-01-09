CREATE TABLE `Biomarker` (
	`objId`  int(10) unsigned   NOT NULL     auto_increment   COMMENT 'Auto Generated unique MySQL ID' ,
	`EKE_ID`  varchar(80)   NOT NULL      COMMENT '...' ,
	`BiomarkerID`  varchar(80)   NOT NULL      COMMENT '...' ,
	`PanelID`  varchar(80)   NOT NULL      COMMENT '...' ,
	`Title`  varchar(80)   NOT NULL      COMMENT '...' ,
	`Description`  text   NOT NULL      COMMENT '...' ,
	`QAState` ENUM('New','Under Review','Approved','Rejected')   NOT NULL      COMMENT '...' ,
	`Phase` ENUM('One (I)','Two (II)','Three (III)','Four (IV)','Five (V)')   NOT NULL      COMMENT '...' ,
	`Security` ENUM('Public','Private')   NOT NULL      COMMENT '...' ,
	`Type` ENUM('Epigenetic','Gene','Protein')   NOT NULL      COMMENT '...' ,
	PRIMARY KEY (`objId`),
	UNIQUE KEY `Title` (`Title`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1; 

CREATE TABLE `BiomarkerAlias` (
	`objId`  int(10) unsigned   NOT NULL     auto_increment  ,
	`Alias`  varchar(80)   NOT NULL     ,
	PRIMARY KEY (`objId`)) ENGINE=MyISAM DEFAULT CHARSET=latin1; 

CREATE TABLE `Study` (
	`objId`  int(10) unsigned   NOT NULL     auto_increment  ,
	`EDRNID`  int(10) unsigned   NOT NULL     ,
	`FHCRC_ID`  int(10) unsigned   NOT NULL      COMMENT 'from the fhcrc website url' ,
	`DMCC_ID`  varchar(80)   NOT NULL      COMMENT 'from fhcrc website' ,
	`Title`  varchar(80)   NOT NULL     ,
	`Abstract`  text   NOT NULL     ,
	`BiomarkerPopulationCharacteristics` ENUM('Case Control','Second Choice','Third Choice')   NOT NULL     ,
	`Design`  varchar(50)   NOT NULL      COMMENT 'fhcrc StudyDesign field' ,
	`BiomarkerStudyType` ENUM('Registered','Unregistered')   NOT NULL  DEFAULT 'Unregistered'     COMMENT 'whether or not the study is an EDRN study' ,
	PRIMARY KEY (`objId`),
	UNIQUE KEY `Title` (`Title`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1; 

CREATE TABLE `BiomarkerStudyData` (
	`objId`  int(10) unsigned   NULL     auto_increment  ,
	`Sensitivity` float   NOT NULL     ,
	`Specificity` float   NOT NULL     ,
	`PPV` float   NOT NULL     ,
	`NPV` float   NOT NULL     ,
	`Assay`  int(10) unsigned   NOT NULL     ,
	`Technology`  int(10) unsigned   NOT NULL     ,
	PRIMARY KEY (`objId`)) ENGINE=MyISAM DEFAULT CHARSET=latin1; 

CREATE TABLE `Organ` (
	`objId`  int(10) unsigned   NOT NULL     auto_increment   COMMENT 'A unique ID for this organ' ,
	`Name`  varchar(40)   NOT NULL      COMMENT 'The text of this alias' ,
	PRIMARY KEY (`objId`),
	UNIQUE KEY `Name` (`Name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1; 

CREATE TABLE `BiomarkerOrganData` (
	`objId`  int(10) unsigned   NULL     auto_increment  ,
	`SensitivityMin` float   NOT NULL     ,
	`SensitivityMax` float   NOT NULL     ,
	`SensitivityComment`  text   NOT NULL     ,
	`SpecificityMin` float   NOT NULL     ,
	`SpecificityMax` float   NOT NULL     ,
	`SpecificityComment`  text   NOT NULL     ,
	`PPVMin` float   NOT NULL     ,
	`PPVMax` float   NOT NULL     ,
	`PPVComment`  text   NOT NULL     ,
	`NPVMin` float   NOT NULL     ,
	`NPVMax` float   NOT NULL     ,
	`NPVComment`  text   NOT NULL     ,
	PRIMARY KEY (`objId`)) ENGINE=MyISAM DEFAULT CHARSET=latin1; 

CREATE TABLE `BiomarkerOrganStudyData` (
	`objId`  int(10) unsigned   NULL     auto_increment  ,
	`Sensitivity` float   NOT NULL     ,
	`Specificity` float   NOT NULL     ,
	`PPV` float   NOT NULL     ,
	`NPV` float   NOT NULL     ,
	`Assay`  int(10) unsigned   NOT NULL     ,
	`Technology`  int(10) unsigned   NOT NULL     ,
	PRIMARY KEY (`objId`)) ENGINE=MyISAM DEFAULT CHARSET=latin1; 

CREATE TABLE `Publication` (
	`objId`  int(10) unsigned   NOT NULL     auto_increment  ,
	`PubMedID`  varchar(40)   NOT NULL     ,
	`Title`  varchar(120)   NOT NULL     ,
	`Author`  varchar(120)   NOT NULL     ,
	`Journal`  varchar(120)   NOT NULL     ,
	`Volume`  varchar(40)   NOT NULL     ,
	`Issue`  varchar(40)   NOT NULL     ,
	`Year`  int(10) unsigned   NOT NULL     ,
	PRIMARY KEY (`objId`),
	UNIQUE KEY `PubMedID` (`PubMedID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1; 

CREATE TABLE `Resource` (
	`objId`  int(10) unsigned   NOT NULL     auto_increment   COMMENT '...' ,
	`Name`  varchar(60)   NOT NULL      COMMENT '...' ,
	`URL`  varchar(128)   NOT NULL     ,
	PRIMARY KEY (`objId`)) ENGINE=MyISAM DEFAULT CHARSET=latin1; 

CREATE TABLE `Site` (
	`objId`  int(10) unsigned   NOT NULL     auto_increment   COMMENT '...' ,
	`Name`  varchar(120)   NOT NULL     ,
	PRIMARY KEY (`objId`)) ENGINE=MyISAM DEFAULT CHARSET=latin1; 

CREATE TABLE `Person` (
	`objId`  int(10) unsigned   NULL     auto_increment  ,
	`FirstName`  varchar(20)   NOT NULL     ,
	`LastName`  varchar(20)   NOT NULL     ,
	`Title`  varchar(80)   NOT NULL     ,
	`Specialty`  varchar(80)   NOT NULL     ,
	`Phone`  varchar(20)   NOT NULL     ,
	`Fax`  varchar(20)   NOT NULL     ,
	`Email`  varchar(80)   NOT NULL     ,
	PRIMARY KEY (`objId`)) ENGINE=MyISAM DEFAULT CHARSET=latin1; 

CREATE TABLE xr_Person_Site (
	`PersonID` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'the unique ID of the Person',
	`SiteID` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'the unique ID of the Site',
	`PersonVar` enum('null','Site') DEFAULT 'null' COMMENT 'the Person variable for this relationship',
	`SiteVar` enum('null','Staff') DEFAULT 'null' COMMENT 'the Site variable for this relationship',
	PRIMARY KEY (`PersonID`,`SiteID`,`PersonVar`,`SiteVar`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ;

CREATE TABLE xr_Biomarker_BiomarkerAlias (
	`BiomarkerID` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'the unique ID of the Biomarker',
	`BiomarkerAliasID` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'the unique ID of the BiomarkerAlias',
	`BiomarkerVar` enum('null','Aliases') DEFAULT 'null' COMMENT 'the Biomarker variable for this relationship',
	`BiomarkerAliasVar` enum('null','Biomarker') DEFAULT 'null' COMMENT 'the BiomarkerAlias variable for this relationship',
	PRIMARY KEY (`BiomarkerID`,`BiomarkerAliasID`,`BiomarkerVar`,`BiomarkerAliasVar`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ;

CREATE TABLE xr_Biomarker_BiomarkerStudyData (
	`BiomarkerID` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'the unique ID of the Biomarker',
	`BiomarkerStudyDataID` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'the unique ID of the BiomarkerStudyData',
	`BiomarkerVar` enum('null','Studies') DEFAULT 'null' COMMENT 'the Biomarker variable for this relationship',
	`BiomarkerStudyDataVar` enum('null','Biomarker') DEFAULT 'null' COMMENT 'the BiomarkerStudyData variable for this relationship',
	PRIMARY KEY (`BiomarkerID`,`BiomarkerStudyDataID`,`BiomarkerVar`,`BiomarkerStudyDataVar`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ;

CREATE TABLE xr_Biomarker_BiomarkerOrganData (
	`BiomarkerID` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'the unique ID of the Biomarker',
	`BiomarkerOrganDataID` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'the unique ID of the BiomarkerOrganData',
	`BiomarkerVar` enum('null','OrganDatas') DEFAULT 'null' COMMENT 'the Biomarker variable for this relationship',
	`BiomarkerOrganDataVar` enum('null','Biomarker') DEFAULT 'null' COMMENT 'the BiomarkerOrganData variable for this relationship',
	PRIMARY KEY (`BiomarkerID`,`BiomarkerOrganDataID`,`BiomarkerVar`,`BiomarkerOrganDataVar`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ;

CREATE TABLE xr_Biomarker_Publication (
	`BiomarkerID` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'the unique ID of the Biomarker',
	`PublicationID` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'the unique ID of the Publication',
	`BiomarkerVar` enum('null','Publications') DEFAULT 'null' COMMENT 'the Biomarker variable for this relationship',
	`PublicationVar` enum('null','Biomarkers') DEFAULT 'null' COMMENT 'the Publication variable for this relationship',
	PRIMARY KEY (`BiomarkerID`,`PublicationID`,`BiomarkerVar`,`PublicationVar`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ;

CREATE TABLE xr_Biomarker_Resource (
	`BiomarkerID` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'the unique ID of the Biomarker',
	`ResourceID` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'the unique ID of the Resource',
	`BiomarkerVar` enum('null','Resources') DEFAULT 'null' COMMENT 'the Biomarker variable for this relationship',
	`ResourceVar` enum('null','Biomarkers') DEFAULT 'null' COMMENT 'the Resource variable for this relationship',
	PRIMARY KEY (`BiomarkerID`,`ResourceID`,`BiomarkerVar`,`ResourceVar`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ;

CREATE TABLE xr_BiomarkerStudyData_Study (
	`BiomarkerStudyDataID` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'the unique ID of the BiomarkerStudyData',
	`StudyID` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'the unique ID of the Study',
	`BiomarkerStudyDataVar` enum('null','Study') DEFAULT 'null' COMMENT 'the BiomarkerStudyData variable for this relationship',
	`StudyVar` enum('null','Biomarkers') DEFAULT 'null' COMMENT 'the Study variable for this relationship',
	PRIMARY KEY (`BiomarkerStudyDataID`,`StudyID`,`BiomarkerStudyDataVar`,`StudyVar`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ;

CREATE TABLE xr_BiomarkerStudyData_Publication (
	`BiomarkerStudyDataID` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'the unique ID of the BiomarkerStudyData',
	`PublicationID` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'the unique ID of the Publication',
	`BiomarkerStudyDataVar` enum('null','Publications') DEFAULT 'null' COMMENT 'the BiomarkerStudyData variable for this relationship',
	`PublicationVar` enum('null','BiomarkerStudies') DEFAULT 'null' COMMENT 'the Publication variable for this relationship',
	PRIMARY KEY (`BiomarkerStudyDataID`,`PublicationID`,`BiomarkerStudyDataVar`,`PublicationVar`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ;

CREATE TABLE xr_BiomarkerStudyData_Resource (
	`BiomarkerStudyDataID` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'the unique ID of the BiomarkerStudyData',
	`ResourceID` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'the unique ID of the Resource',
	`BiomarkerStudyDataVar` enum('null','Resources') DEFAULT 'null' COMMENT 'the BiomarkerStudyData variable for this relationship',
	`ResourceVar` enum('null','BiomarkerStudies') DEFAULT 'null' COMMENT 'the Resource variable for this relationship',
	PRIMARY KEY (`BiomarkerStudyDataID`,`ResourceID`,`BiomarkerStudyDataVar`,`ResourceVar`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ;

CREATE TABLE xr_BiomarkerOrganData_Organ (
	`BiomarkerOrganDataID` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'the unique ID of the BiomarkerOrganData',
	`OrganID` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'the unique ID of the Organ',
	`BiomarkerOrganDataVar` enum('null','Organ') DEFAULT 'null' COMMENT 'the BiomarkerOrganData variable for this relationship',
	`OrganVar` enum('null','OrganDatas') DEFAULT 'null' COMMENT 'the Organ variable for this relationship',
	PRIMARY KEY (`BiomarkerOrganDataID`,`OrganID`,`BiomarkerOrganDataVar`,`OrganVar`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ;

CREATE TABLE xr_BiomarkerOrganData_Resource (
	`BiomarkerOrganDataID` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'the unique ID of the BiomarkerOrganData',
	`ResourceID` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'the unique ID of the Resource',
	`BiomarkerOrganDataVar` enum('null','Resources') DEFAULT 'null' COMMENT 'the BiomarkerOrganData variable for this relationship',
	`ResourceVar` enum('null','BiomarkerOrgans') DEFAULT 'null' COMMENT 'the Resource variable for this relationship',
	PRIMARY KEY (`BiomarkerOrganDataID`,`ResourceID`,`BiomarkerOrganDataVar`,`ResourceVar`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ;

CREATE TABLE xr_BiomarkerOrganData_Publication (
	`BiomarkerOrganDataID` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'the unique ID of the BiomarkerOrganData',
	`PublicationID` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'the unique ID of the Publication',
	`BiomarkerOrganDataVar` enum('null','Publications') DEFAULT 'null' COMMENT 'the BiomarkerOrganData variable for this relationship',
	`PublicationVar` enum('null','BiomarkerOrgans') DEFAULT 'null' COMMENT 'the Publication variable for this relationship',
	PRIMARY KEY (`BiomarkerOrganDataID`,`PublicationID`,`BiomarkerOrganDataVar`,`PublicationVar`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ;

CREATE TABLE xr_BiomarkerOrganData_BiomarkerOrganStudyData (
	`BiomarkerOrganDataID` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'the unique ID of the BiomarkerOrganData',
	`BiomarkerOrganStudyDataID` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'the unique ID of the BiomarkerOrganStudyData',
	`BiomarkerOrganDataVar` enum('null','StudyDatas') DEFAULT 'null' COMMENT 'the BiomarkerOrganData variable for this relationship',
	`BiomarkerOrganStudyDataVar` enum('null','BiomarkerOrganData') DEFAULT 'null' COMMENT 'the BiomarkerOrganStudyData variable for this relationship',
	PRIMARY KEY (`BiomarkerOrganDataID`,`BiomarkerOrganStudyDataID`,`BiomarkerOrganDataVar`,`BiomarkerOrganStudyDataVar`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ;

CREATE TABLE xr_BiomarkerOrganStudyData_Study (
	`BiomarkerOrganStudyDataID` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'the unique ID of the BiomarkerOrganStudyData',
	`StudyID` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'the unique ID of the Study',
	`BiomarkerOrganStudyDataVar` enum('null','Study') DEFAULT 'null' COMMENT 'the BiomarkerOrganStudyData variable for this relationship',
	`StudyVar` enum('null','BiomarkerOrganDatas') DEFAULT 'null' COMMENT 'the Study variable for this relationship',
	PRIMARY KEY (`BiomarkerOrganStudyDataID`,`StudyID`,`BiomarkerOrganStudyDataVar`,`StudyVar`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ;

CREATE TABLE xr_BiomarkerOrganStudyData_Publication (
	`BiomarkerOrganStudyDataID` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'the unique ID of the BiomarkerOrganStudyData',
	`PublicationID` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'the unique ID of the Publication',
	`BiomarkerOrganStudyDataVar` enum('null','Publications') DEFAULT 'null' COMMENT 'the BiomarkerOrganStudyData variable for this relationship',
	`PublicationVar` enum('null','BiomarkerOrganStudies') DEFAULT 'null' COMMENT 'the Publication variable for this relationship',
	PRIMARY KEY (`BiomarkerOrganStudyDataID`,`PublicationID`,`BiomarkerOrganStudyDataVar`,`PublicationVar`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ;

CREATE TABLE xr_BiomarkerOrganStudyData_Resource (
	`BiomarkerOrganStudyDataID` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'the unique ID of the BiomarkerOrganStudyData',
	`ResourceID` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'the unique ID of the Resource',
	`BiomarkerOrganStudyDataVar` enum('null','Resources') DEFAULT 'null' COMMENT 'the BiomarkerOrganStudyData variable for this relationship',
	`ResourceVar` enum('null','BiomarkerOrganStudies') DEFAULT 'null' COMMENT 'the Resource variable for this relationship',
	PRIMARY KEY (`BiomarkerOrganStudyDataID`,`ResourceID`,`BiomarkerOrganStudyDataVar`,`ResourceVar`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ;

CREATE TABLE xr_Study_BiomarkerOrganData (
	`StudyID` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'the unique ID of the Study',
	`BiomarkerOrganDataID` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'the unique ID of the BiomarkerOrganData',
	`StudyVar` enum('null','BiomarkerOrgans') DEFAULT 'null' COMMENT 'the Study variable for this relationship',
	`BiomarkerOrganDataVar` enum('null') DEFAULT 'null' COMMENT 'the BiomarkerOrganData variable for this relationship',
	PRIMARY KEY (`StudyID`,`BiomarkerOrganDataID`,`StudyVar`,`BiomarkerOrganDataVar`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ;

CREATE TABLE xr_Study_Publication (
	`StudyID` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'the unique ID of the Study',
	`PublicationID` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'the unique ID of the Publication',
	`StudyVar` enum('null','Publications') DEFAULT 'null' COMMENT 'the Study variable for this relationship',
	`PublicationVar` enum('null','Studies') DEFAULT 'null' COMMENT 'the Publication variable for this relationship',
	PRIMARY KEY (`StudyID`,`PublicationID`,`StudyVar`,`PublicationVar`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ;

CREATE TABLE xr_Study_Resource (
	`StudyID` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'the unique ID of the Study',
	`ResourceID` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'the unique ID of the Resource',
	`StudyVar` enum('null','Resources') DEFAULT 'null' COMMENT 'the Study variable for this relationship',
	`ResourceVar` enum('null','Studies') DEFAULT 'null' COMMENT 'the Resource variable for this relationship',
	PRIMARY KEY (`StudyID`,`ResourceID`,`StudyVar`,`ResourceVar`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ;

