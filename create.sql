CREATE TABLE `address` (
  `AddressID` int(11) NOT NULL AUTO_INCREMENT,
  `Line1` varchar(128) DEFAULT NULL,
  `Line2` varchar(128) DEFAULT NULL,
  `City` varchar(128) DEFAULT NULL,
  `State` varchar(128) DEFAULT NULL,
  `ZipCode` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`AddressID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `parish` (
  `ParishName` varchar(512) NOT NULL,
  `Diocese` varchar(128) DEFAULT NULL,
  `AddressID` int(11) DEFAULT NULL,
  PRIMARY KEY (`ParishName`),
  KEY `AddressID_idx` (`AddressID`),
  CONSTRAINT `AddressID_Parish` FOREIGN KEY (`AddressID`) REFERENCES `address` (`AddressID`) ON UPDATE CASCADE ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `individual` (
  `IndividualID` int(11) NOT NULL AUTO_INCREMENT,
  `SponsorID` int(11) DEFAULT NULL,
  `ParishName` varchar(512) DEFAULT NULL,
  `AddressID` int(11) DEFAULT NULL,
  `FirstName` varchar(128) DEFAULT NULL,
  `LastName` varchar(128) DEFAULT NULL,
  `Gender` enum('MALE','FEMALE') DEFAULT NULL,
  `SpouseFirstName` varchar(128) DEFAULT NULL,
  `SpouseLastName` varchar(128) DEFAULT NULL,
  `PastorFirstName` varchar(128) DEFAULT NULL,
  `PastorLastName` varchar(128) DEFAULT NULL,
  `Email` varchar(512) DEFAULT NULL,
  `Phone` varchar(12) DEFAULT NULL,
  `IsMarried` bit(1) DEFAULT NULL,
  `HasSpouseAttended` bit(1) DEFAULT NULL,
  `Birthday` date DEFAULT NULL,
  `NameTag` varchar(128) DEFAULT NULL,
  `Occupation` varchar(128) DEFAULT NULL,
  `IndividualType` enum('CANDIDATE','TEAM') DEFAULT NULL,
  PRIMARY KEY (`IndividualID`),
  KEY `AddressID_idx` (`AddressID`),
  KEY `ParishName_idx` (`ParishName`),
  KEY `SponsorID_Individual_idx` (`SponsorID`),
  CONSTRAINT `AddressID_Individual` FOREIGN KEY (`AddressID`) REFERENCES `address` (`AddressID`) ON UPDATE CASCADE ON DELETE SET NULL,
  CONSTRAINT `ParishName_Individual` FOREIGN KEY (`ParishName`) REFERENCES `parish` (`ParishName`) ON UPDATE CASCADE,
  CONSTRAINT `SponsorID_Individual` FOREIGN KEY (`SponsorID`) REFERENCES `individual` (`IndividualID`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



