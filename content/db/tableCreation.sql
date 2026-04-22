--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE `events` (
  `eventID` MEDIUMINT(8) PRIMARY KEY AUTO_INCREMENT,
  `event_speaker` VARCHAR(255) NOT NULL,
  `event_title` VARCHAR(255) NOT NULL,
  `description` TEXT NOT NULL,
  `event_date` DATETIME NOT NULL,
  `price_per_person` DECIMAL(7,2) NOT NULL,
  `event_imagepath` VARCHAR(255),
  `event_imagealt` VARCHAR(255)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

DROP TABLE IF EXISTS `booking`;
CREATE TABLE `booking` (
  `bookingID` mediumint(8) PRIMARY KEY AUTO_INCREMENT,
  `eventID` mediumint(8) NOT NULL,
  `customerID` mediumint(8) NOT NULL,
  `number_people` mediumint(2) NOT NULL,
  `total_booking_cost` DECIMAL(7,2) NOT NULL,
  `booking_notes` TEXT DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE `customers` (
  `customerID` mediumint(8) PRIMARY KEY AUTO_INCREMENT,
  `password_hash` char(255) NOT NULL,
  `customer_forename` varchar(255) NOT NULL,
  `customer_surname` varchar(255) NOT NULL,
  `customer_email` varchar(64) UNIQUE NOT NULL,
  `date_of_birth` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
