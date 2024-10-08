-- Create database `klinika`;

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `username` varchar(255) NOT NULL PRIMARY KEY,
  `password` varchar(255) DEFAULT NULL
) ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`username`, `password`) VALUES
('admin', '123');

DROP TABLE IF EXISTS `appointment`;
CREATE TABLE IF NOT EXISTS `appointment` (
  `appoid` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(10) DEFAULT NULL,
  `apponum` int(3) DEFAULT NULL,
  `appodate` date DEFAULT NULL,
  `start_time` TIME,
  `end_time` TIME,
  `servid` int(11) NOT NULL,
  `qr_code` VARCHAR(255),
  PRIMARY KEY (`appoid`),
  FOREIGN KEY (`pid`)
  REFERENCES `klinika`.`patient` (`pid`),
  KEY `pid` (`pid`)
) ;

INSERT INTO `appointment` (`pid`, `apponum`, `appodate`,`start_time`,`end_time`,`servid`,`qr_code`) VALUES
-- (1, 2, 1, '2024-09-26','8:00','9:00',1,'example-qr-code.png'),
-- (2, 1, 2, '2024-09-27','10:00','11:00',2,'example-qr-code.png');
(1, 2, '2024-09-27','10:00','11:00',2,'example-qr-code.png');


DROP TABLE IF EXISTS `patient`;
CREATE TABLE IF NOT EXISTS `patient` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `pemail` varchar(255) DEFAULT NULL,
  `pname` varchar(255) DEFAULT NULL,
  `ppassword` varchar(255) DEFAULT NULL,
  `paddress` varchar(255) DEFAULT NULL,
  `pdob` date DEFAULT NULL, -- date of birth
  `ptel` varchar(15) DEFAULT NULL, -- telephone
  PRIMARY KEY (`pid`)
);

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`pid`, `pemail`, `pname`, `ppassword`, `paddress`, `pdob`, `ptel`) VALUES
(1, 'patient@edoc.com', 'Test Patient', '123', 'Sri Lanka', '2000-01-01', '0120000000'),
(2, 'emhashenudara@gmail.com', 'Hashen Udara', '123', 'Sri Lanka', '2022-06-03', '0700000000');

DROP TABLE IF EXISTS `document`;
CREATE TABLE IF NOT EXISTS `document` (
  `docid` int(2) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `doc_file` varchar(255),
  `doc_name` varchar(255)
);

DROP TABLE IF EXISTS `transaction`;
CREATE TABLE IF NOT EXISTS `transaction` (
  `transid` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(10) NOT NULL,
	price DECIMAL(10, 2),
    status ENUM('under payment', 'paid') NOT NULL,
    `servid` varchar(255),
  PRIMARY KEY (`transid`),
  KEY `pid` (`pid`),
  KEY `servid` (`servid`)
) ;

DROP TABLE IF EXISTS `service`;
CREATE TABLE IF NOT EXISTS `service` (
  `servid` int(11) NOT NULL AUTO_INCREMENT,
 `service_name` varchar(255),
  PRIMARY KEY (`servid`),
  KEY `pid` (`service_name`)
) ;

INSERT INTO `service` (`servid`, `service_name`) VALUES
(1, 'Check-up'),
(2, 'Pasta');

--patients

DROP TABLE IF EXISTS `patientRecords`;
CREATE TABLE IF NOT EXISTS `patientRecords` (
  id INT AUTO_INCREMENT PRIMARY KEY,
    firstName VARCHAR(50) NOT NULL,
    lastName VARCHAR(50) NOT NULL,
    dob DATE NOT NULL,
    contact VARCHAR(15) NOT NULL,
    email VARCHAR(100),
    insurance VARCHAR(100),
    allergies ENUM('yes', 'no') NOT NULL,
    chronicConditions ENUM('yes', 'no') NOT NULL,
    medications ENUM('yes', 'no') NOT NULL,
    surgeries ENUM('yes', 'no') NOT NULL,
    familyHistory ENUM('yes', 'no') NOT NULL
) ;



