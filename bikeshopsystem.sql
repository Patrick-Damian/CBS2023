-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 14, 2022 at 08:30 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bikeshopsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `add_id` int(11) NOT NULL,
  `usersId` int(11) DEFAULT NULL,
  `house_no` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `brgy` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `zip_code` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `admin_user`
--

CREATE TABLE `admin_user` (
  `adminId` int(11) NOT NULL,
  `admin_name` varchar(255) NOT NULL,
  `admin_password` varchar(100) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin_user`
--

INSERT INTO `admin_user` (`adminId`, `admin_name`, `admin_password`, `date`) VALUES
(3, 'admin', 'b59c67bf196a4758191e42f76670ceba', '2022-09-22 16:28:15'),
(11, 'sylvester1234', '81dc9bdb52d04dc20036dbd8313ed055', '2022-11-23 13:16:59'),
(12, 'canoyBikes', 'e807f1fcf82d132f9bb018ca6738a19f', '2022-11-23 13:20:22');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(255) NOT NULL,
  `usersId` int(11) NOT NULL,
  `cart_name` varchar(255) NOT NULL,
  `price` int(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `quantity` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `cat_id` int(10) NOT NULL,
  `cat_name` varchar(100) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`cat_id`, `cat_name`, `date`) VALUES
(1, 'Bikes', '2022-10-04 16:22:37'),
(2, 'Accessories', '2022-10-04 16:22:37'),
(3, 'Parts', '2022-10-04 16:23:23');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `contact_id` int(10) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `example_user`
--

CREATE TABLE `example_user` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `example_user`
--

INSERT INTO `example_user` (`id`, `name`, `username`, `email`, `contact`) VALUES
(3, 'Angeline Ballad', 'angge24', 'ballad1234@gmail.com', '09776767676'),
(4, 'Sylvester Fernandez', 'sylvester123', 'sylvesterfernandez1017@gmail.com', '09477221717'),
(9, 'example name', 'example', 'example@gmail.com', '09124567891');

-- --------------------------------------------------------

--
-- Table structure for table `inventory_prod`
--

CREATE TABLE `inventory_prod` (
  `prod_id` int(11) NOT NULL,
  `prod_name` varchar(255) NOT NULL,
  `stocks` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `inventory_prod`
--

INSERT INTO `inventory_prod` (`prod_id`, `prod_name`, `stocks`) VALUES
(1, 'SRAM NX Groupset', 20),
(2, 'Ragusa bicycle rack', 20),
(3, 'SR Suntour Radion', 20),
(4, 'Ragusa Brake Cleaner', 20),
(5, 'Speedone Torpedo Hubs', 20),
(6, 'Ragusa Folding', 20),
(7, 'Bolany XC350', 20),
(8, 'Bolany Note 27.5	', 20),
(9, 'Sagmit Cyrus Aero', 20),
(10, 'Speedone Soldier Hub', 20),
(11, 'Toseek Chester Road', 20),
(12, 'Sagmit Cyrus Aero', 20),
(13, 'Speedone Soldier Hub', 20),
(14, 'Toseek Chester Road', 20),
(15, 'Ragusa Spoiler 27 MTB', 20),
(16, 'Promax 700 Road Bike', 20),
(17, 'Tonyon Bicycle lock TY566', 20),
(18, 'Sagmit Tire Lever	', 20),
(19, 'Rapid X Bicycle tail light', 20),
(20, '2pcs Bicycle Mudguard', 20),
(21, 'Crown Bell for Bicycle', 20),
(22, 'Bicycle Patch kit', 20),
(23, 'Bicycle Lever Protector', 20),
(24, 'B-Soul Saddle Bag', 20),
(25, 'Alloy Bottle Cage', 20),
(26, 'Truvativ Handle Bar 800mm', 20),
(27, 'San Marco Mtb Saddle	', 20),
(28, 'Ragusa Nylon Pedal', 20),
(29, 'Kenda Folding Tires', 20),
(30, 'Genova Chain Oilslick', 20),
(31, 'Bicycle Handle Grips', 20),
(32, 'Sagmit Watter Bottle', 20),
(33, 'Pearl Izumi Gel Gloves	', 20),
(34, 'Ragusa Spoiler 27 MTB', 20),
(35, 'Promax 700 Road Bike', 20),
(36, 'Tonyon Bicycle lock TY566', 20),
(37, 'Sagmit Tire Lever	', 20),
(38, 'Rapid X Bicycle tail light', 20),
(39, '2pcs Bicycle Mudguard', 20),
(40, 'Crown Bell for Bicycle', 20),
(41, 'Bicycle Patch kit', 20),
(42, 'Bicycle Lever Protector', 20),
(43, 'B-Soul Saddle Bag', 20),
(44, 'Alloy Bottle Cage', 20),
(45, 'Truvativ Handle Bar 800mm', 20),
(46, 'San Marco Mtb Saddle	', 20),
(47, 'Ragusa Nylon Pedal', 20),
(48, 'Kenda Folding Tires', 20),
(49, 'Genova Chain Oilslick', 20),
(50, 'Bicycle Handle Grips', 20),
(51, 'Sagmit Watter Bottle', 20),
(52, 'Pearl Izumi Gel Gloves	', 20);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `pay_id` int(11) NOT NULL,
  `usersId` int(11) NOT NULL,
  `placeOrder` varchar(255) NOT NULL,
  `custName` varchar(255) NOT NULL,
  `amount` int(100) NOT NULL,
  `ref_num` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `product_list`
--

CREATE TABLE `product_list` (
  `prod_id` int(10) NOT NULL,
  `prod_name` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  `img1` varchar(100) NOT NULL,
  `img2` varchar(100) NOT NULL,
  `desc` longtext NOT NULL,
  `stock` int(100) NOT NULL,
  `code` varchar(10) NOT NULL,
  `price` int(11) NOT NULL,
  `category` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_list`
--

INSERT INTO `product_list` (`prod_id`, `prod_name`, `image`, `img1`, `img2`, `desc`, `stock`, `code`, `price`, `category`) VALUES
(1, 'SRAM NX Groupset', 'SRAM Group Set.jpg', 'Sram NX Groupset1.jpg', 'Sram NX Groupset2.jpg', 'The SRAM NX Eagle Dub Groupset provides all you need to make the jump to a 1x12 drivetrain. It comes with a SRAM NX Eagle rear derailleur, trigger shifter with a clamp, a SRAM NX Eagle Dub crankset with a 32t X-Sync chainring, a 126 link 12-speed chain, an XG-1230 11-50t cassette, and a chain gap gauge.', 18, 'p100', 15500, 'parts'),
(2, 'Ragusa bicycle rack', 'Ragusa Bicycle Rack.jpg', 'Ragusa Bicycle Rack1.jpeg', 'Ragusa Bicycle Rack2.jpeg', 'It offers easily adjustable support arms, bike hold-downs that separate and firmly hold the bikes, a narrow frame configuration that fits a wider array of bikes, and reflective red end caps offer increased visibility and safety', 15, 'p101', 2000, 'accessories'),
(3, 'SR Suntour Radion', 'SR SUNTOUR RADION 27.5 BOOST 130mm.jpg', 'SR Suntour Radion1.jpeg', 'SR Suntour Radion2.jpeg', 'A solid XC workhorse, the Raidon is a durable high performance driven fork ready to tackle trails for multiple seasons with minimal maintenance. Sealed cartridge design with lockout and and external rebound adjuster.', 20, 'p102', 8075, 'parts'),
(4, 'Ragusa Brake Cleaner', 'Ragusa Brake Cleaner.jpg', 'Ragusa Brake Cleaner1.jpeg', 'Ragusa Brake Cleaner2.jpg', 'Clean and decontaminate brake pad, disc, flywheel, etc.\r\nCan remove oil pollution, eliminate abnormal sound.\r\nBrake performance will not be affected after use.\r\nCan be used for transmission system(chain, flywheel) effective cleaning.', 15, 'p103', 200, 'accessories'),
(5, 'Speedone Torpedo Hubs', 'Speedone Torpedo Hubs.jpg', 'Speedone Torpedo 8pawls 32holes1.jpg', 'Speedone Torpedo 8pawls 32holes2.jpg', 'The Torpedo is an all-out high engagement hub with 8 PAWLS! It is a great upgrade for your bike because of the Speedone proven reliability. It can be used with Quick Release and Thru Axle frames with standard non-boost fork and frames which is common among MTBs.', 20, 'p104', 3300, 'parts'),
(6, 'Ragusa Folding', 'Ragusa Folding Tire (Tanwall).jpg', 'Ragusa Folding 1.jpg.jfif', 'Ragusa Folding 2.jpg.jfif', 'Mountain Bike Tires<br>\r\n50TPI Casing<br>\r\nMax Pressure: 30-50psi<br>\r\nWeight: 600g (26', 20, 'p105', 1400, 'parts'),
(7, 'Bolany XC350', 'Bolany XC350.jpg', 'BOLANY XC350 1.jpg.jfif', 'BOLANY XC350 2.jpg', 'Bolany Air Fork<br>\nNon tapered<br>\nQuick release compatible<br>\nSize: 27.5<br>\nTravel: 120mm<br>\nSteerer: Alloy Straigth Tube: 28.6*30*220mm<br>\nStachions: Aluminum 32mm<br>\nWeight: 1.7-1.8 kilo only', 20, 'p106', 3400, 'parts'),
(8, 'Bolany Note 27.5', 'Bolany Note 27.5.jpg', 'Bolany Note 27.5 (1).jpg', 'Bolany Note 27.5 (2).jpg', 'AVAILABLE SIZE: 27.5 AND 29ER <br>\r\nSTANCHION: 34MM <br>\r\nTRAVEL: 120MM<br>\r\nWEIGHT: 1.825 KG<br>\r\nSTEERER TUBE: NON TAPERED<br>', 20, 'p107', 2800, 'parts'),
(9, 'Sagmit Cyrus Aero', 'Sagmit Cyrus Aero.jpg', 'Sagmit Cyrus Aero 1.jpg', 'Sagmit Cyrus Aero 2.jpg.jfif', 'SAGMIT<br>\nROAD BIKE <br>\nDROPBAR WITH STEM <br>\nMODEL CYRUS AERO <br>\nSIZE 31.8 * 400MM * 28.6 <br>\nCOLOR SAND BLACK <br>\nMADE IN TAIWAN', 20, 'p108', 1100, 'parts'),
(10, 'Speedone Soldier Hub', 'Speedone Soldier Hub.jpg', 'Speedone Soldier Hubs 1.jpg', 'Speedone Soldier Hubs 2.jpg', 'SPEEDONE SOLDIER HUB MTB MOUNTAIN BIKE\nWITH THRU AXLE CAP CONVERSION KIT\nMaterial: Al 6061/T6 Alloy\nAxle Material: 7075/T6\nOLD/F: 9x100mm, QR/15*100mm\nOLD/R:10*135mm, QR/12*142mm\nSpoke Hole: 32H\nCassette Body: AL 7075/T4-T6\nBearings: F: 2pcs R: 4pcs\nAvailable colors: Black, Gold, Red, Blue', 20, 'p109', 2800, 'parts'),
(14, 'Toseek Chester Road', 'Toseek Chester Road.jpg', 'Toseek Chester Road1.jpg', 'Toseek Chester Road2.jpg', 'Alloy: Frame 6061 Internal cabling ( size 46 & 50 )\r\nST: Ignite STI 2x9 Speed \r\nBrake: Disc Mechanical\r\nCrank: Alloy50-34t chainring\r\nCogs: Cassette type 11-28t\r\nRD: Sensah \r\nBb: Sealed bearing \r\nHubs: Quick release alloy \r\nSaddle : Toseek\r\nStem: Alloy Drop bar\r\nRim: Double wall alloy \r\nTire: Kenda 700x25c', 20, 'p110', 10000, 'bikes'),
(15, 'Ragusa Spoiler 27 MTB', 'Ragusa Spoiler 27 MTB.png', 'Ragusa Spoiler 27 MTB1.jpg', 'Ragusa Spoiler 27 MTB2.jpg', 'Frame: Ragusa Spoiler Alloy 6061 Internal Cabling\r\nFork: Ragusa Spoiler Lockout\r\nCrank: Alloy Arm 1* 34t\r\nHub: Alloy Cassette QR\r\n\r\nQuick Release \r\n\r\nSprocket: 12speed 11-50t\r\nShifter: Ltwoo R*12speed\r\nRd: Ltwoo 12speed\r\nBrake: Hydraulic Brake\r\nTire: Tagusa Cameron Race 27.5*2.1/29*2.1\r\nRim: Alloy Double Wall cnc\r\nSaddle: Ragusa\r\nHandlebar: Ragusa Alloy\r\nStem: Ragusa Negative alloy\r\nSeatpost: Ragusa alloy\r\nPedal: Alloy 2bearings\r\n', 20, 'p111', 10000, 'bikes'),
(16, 'Promax 700 Road Bike', 'Promax 700 Road Bike.jpg', 'Promax 700 Road Bike1.png', 'Promax 700 Road Bike2.png', 'Frame: Alloy internal cabling\r\nTire: Ragusa tan wall tire size 700c x 35c (kayden)\r\nBrake: Mechanical dual disc brake\r\nShifter: 3 x 7 Speed shifter\r\nFrame: Alloy internal cabling\r\nStem: Alloy stem\r\nRim: Alloy rims\r\nSeatpost: Quick release seat post \r\nThumb shifter\r\nBracket: Sealed bearing bottom bracket', 20, 'p112', 6500, 'bikes'),
(17, 'Tonyon Bicycle lock TY566', 'Tonyon Bicycle lock TY566 (keyless).jpg', 'Tonyon Bicycle lock TY566 (keyless)1.jpg', 'Tonyon Bicycle lock TY566 (keyless)2.jpg', 'This lock is preset to operate at 0000 to set you own combination \r\n# please follow the instruction..\r\n\r\n2 keys included，password lock no have keys.\r\nWith a lock bracket to carry the lock on your unit any time.\r\nErgonomic design,easy to use.\r\nMaterial: high quality steel, copper, PVC, ABS engineering plastics\r\nSpecification: diameter 12mm, length 1200mm\r\nColor: Black White Pink Yellow Blue Green\r\nModify password:\r\n1, password lock open\r\n2, built-in rotating knob, 90 degrees clockwise\r\n3, set a new password, calibration scale (original password 00000)\r\n4, built-in knob can be reversed\r\n', 20, 'p113', 199, 'accessories'),
(18, 'Sagmit Tire Lever', 'Sagmit tire lever.jpg', 'Sagmit tire lever1.jpg', 'Sagmit tire lever3.jpg', 'Materials: Hard Plastic\r\nLength: 11cm\r\nWidth: 2.5cm\r\n1set = 3pcs tire levers\r\nHigh Quality\r\nDurable\r\nEasy to use\r\nMade in Taiwan', 20, 'p114', 47, 'accessories'),
(19, 'Rapid X Bicycle tail light', 'Rapid X Bicycle tail light.png', 'Rapid X Bicycle tail light1.jpg', 'Rapid X Bicycle tail light2.jpg', '15 lumens\r\nWaterproof seal\r\nLight wide\r\nUSB charge\r\nCharging time : about 2 hrs\r\n4 modes : long bright 4hrs/ slow flash 10 hrs/ shun flash 12 hrs/ strobe 8hrs\r\nApplicable diameter : 12-32mm\r\nHardware included : 2x O rings/ USB cable', 20, 'p115', 65, 'accessories'),
(20, '2pcs Bicycle Mudguard', '2pcs Fifty fifty bicycle mudguard.jpg', '2pcs Fifty fifty bicycle mudguard1.jpg', '2pcs Fifty fifty bicycle mudguard2.jpg', '2PCS FIFTY-FIFTY BLACK MUDGUARD FENDER FLEXIBLE PLASTIC FRONT AND REAR \r\nNOTE: for minor splashes only, not fit for heavy rains.\r\nFor heavy rains please use a longer fender\r\n2PCS-Made from 0.8mm light weight polypropylene plate.\r\nFour-point fixed to avoid sliding.\r\nFolding line design makes it easy to form the shape before installing.\r\nCut along the dash line in the backside of mudguard to modify the length.\r\nFront fork and rear seat stay compatible.', 20, 'p116', 78, 'accessories'),
(21, 'Crown Bell for Bicycle', 'Crown Bell for bicycle.jpg', 'Crown Bell for bicycle1.jpg', 'Crown Bell for bicycle2.jpg', 'Bicycle like cateye bell\r\nLoud sound\r\n\r\nFeatures:Keep your kids from danger by warning or noticing others with Loud Siren Sound Easy to be fixed on the bicycleA Loud Siren to draw peoples attention on street.\r\nColor: Red/yellow/Silver/black/Green/Pink\r\nMaterial: Plastic\r\nLargest Voice: Above 90db\r\nSize: 25*30mmPackage \r\nInclude:1x Bike Cycling Alarm Loud Bell Horn', 20, 'p117', 100, 'accessories'),
(22, 'Bicycle Patch kit', 'Bicycle Patch kit.jpg', 'Bicycle Patch kit1.jpg', 'Bicycle Patch kit2.jpg', 'Tire Repair Kit/Bicycle Patch kit\r\n1 set\r\n\r\nTire paste\r\nTire patches\r\nskimmer and tire opener', 20, 'p118', 55, 'accessories'),
(23, 'Bicycle Lever Protector', 'Bicycle Lever boots Protector1.jpg', 'Bicycle Lever boots Protector2.png', 'Bicycle Lever boots Protector.jpg', 'SILICONE BRAKE LEVER PAIR MATERIAL\r\nSILICONE WEIGHT: ABOUT 25G/PAIR FEATURES\r\nHIGH WEAR-RESISTANT HIGH RESISTANT TO TEAR MATERIAL,MOUNTED ON THE BRAKE HANDLE,SLIP WATERPROOF,ENHANCE THE FEE,THE MARKET FOR MOST OF THE BICYCLE BRAKE HANDLE. INSTALLATION\r\nCAN BE USED WARM WATER SOAK FOR A WHILE,AFTER THE FOAM EASIER TO INSTALL.', 20, 'p119', 35, 'accessories'),
(24, 'B-Soul Saddle Bag', 'B-Soul Saddle Bag.jpg', 'B-Soul Saddle Bag1.png', 'B-Soul Saddle Bag2.jpg', 'Perfect for storing small items such as keys, wallet and cell phone etc. \r\nEasy to install and remove\r\nHigh density 600D (Polyester 600D HD (high density weaving) fabric\r\nWith thick PU coating on the back side and water repellent treatment on the face side', 20, 'p120', 129, 'accessories'),
(25, 'Alloy Bottle Cage', 'Alloy Bottle Cage Bicycle and Motorcycle.jpg', 'Alloy Bottle Cage Bicycle and Motorcycle1.jpg', 'Alloy Bottle Cage Bicycle and Motorcycle2.jpg', 'Aluminum Alloy\r\nUseful for bikes which have no holder or inadequate for a frame holder\r\nConvenient to fetch drink from a bottle holder\r\nSimple and practical design\r\nSmall size and light weight\r\nSturdy structure, prevent from deformation damage\r\nStrongly-gripped hinge, fix the holder tightly\r\nSuitable for varied types of bikes, including mountain bike and folding bike* ', 20, 'p121', 39, 'accessories'),
(26, 'Truvativ Handle Bar 800mm', 'Truvativ Handle Bar 800mm.jpg', 'Truvativ Handle Bar 800mm1.jpg', 'Truvativ Handle Bar 800mm2.jpg', 'Rise 20mm and Straight bar.\r\nAlloy 800mm', 20, 'p122', 255, 'parts'),
(27, 'San Marco Mtb Saddle', 'San marco Mtb Saddle.png', 'San marco Mtb Saddle 2.jpg', 'San marco Mtb Saddle 1.jpg', 'Size: 250 mm * 144 mm\r\nPurpose: road bike\r\nWeight: about 235g±10g\r\nAvailable rails: steel\r\nRail size: 7x10mm\r\nItem type: bicycle saddle\r\nAdvantages: saddle,  wear-resistant, ultra-light\r\nColor: black, white\r\nCompatible: wide saddle for bicycle racing\r\nModel: Italia marco Shortfit Dynamic Wide tt Open Race\r\nApplicable to: MTB road mountain bike', 20, 'p123', 450, 'parts'),
(28, 'Ragusa Nylon Pedal', 'RAGUSA NYLON PEDAL SEALED BEARING.jpg', 'RAGUSA NYLON PEDAL SEALED BEARING 2.jpg', 'RAGUSA NYLON PEDAL SEALED BEARING 1.jpg', 'Ragusa Nylon Pedal\r\nBicycle Pedal\r\nSealed Bearing\r\nDimension: 11.5x10x2cm\r\nWeight: Approx 190g per Pedal', 20, 'p124', 345, 'parts'),
(29, 'Kenda Folding Tires', 'Kenda Folding Tires.jpg', 'Kenda Folding Tires 1.jpg', 'Kenda Folding Tires 2.jpg', '1 pair\r\nBrandnew Kenda folding tires \r\nLight weight and high quality\r\nColor: Black\r\nSize: 26*1.95/26*2.1/27.5*1.95\r\nInflatable pressure range: 2.5-4.5KGF/CM²\r\nCarefully designed, smooth grain and exquisite details\r\nThe size of the specifications is clear, strict production layer gateways\r\nThe parameters of the tires are clearly visible and the precision parameters are guaranteed.\r\n', 20, 'p125', 1450, 'parts'),
(30, 'Genova Chain Oilslick', 'Genova Chain Oilslick.jpg', 'Genova Chain Oilslick1.jpg', 'Genova Chain Oilslick2.jpg', 'Fit for 10-speed MTB and folding bike drivetrain\r\nOil Slick Finish\r\nSealed and Original', 20, 'p126', 395, 'parts'),
(31, 'Bicycle Handle Grips', 'Bicycle Handle Grips2.jpg', 'Bicycle Handle Grips1.jpg', 'Bicycle Handle Grips.jpg', 'Original factory top quality. \r\nPerspiration Cozy handle Health\r\nProduct Details:\r\nMaterial: New Soft Silicon + Aluminum 1 lot = 2pc\r\nFeatures:\r\nl No smell, anti-bacteria, strong wearability\r\nl Non-slip grip, easy to put & take off\r\nl Texture surface provides traction maximum control\r\nl Length:130 mm, Weight: 130 g/pair', 20, 'p127', 90, 'parts'),
(32, 'Sagmit Watter Bottle', 'Sagmit Legend Bottle1.jpg', 'Sagmit Legend Bottle2.jpg', 'Sagmit Legend Bottle.jpg', 'Capacity: 650mL\r\nDiameter: 7cm\r\nHeight: 20cm\r\nSqueezable\r\nOdor Free', 20, 'p128', 150, 'accessories'),
(33, 'Pearl Izumi Gel Gloves', 'Pearl Izumi Gel Cycle Gloves.jpg', 'Pearl Izumi Gel Cycle Gloves1.jpg', 'Pearl Izumi Gel Cycle Gloves2.jpg', 'Cycling glove feels like real leather, \r\nbut offers the ease of care and four-way stretch only possible with a synthetic.', 20, 'p129', 200, 'accessories');

-- --------------------------------------------------------

--
-- Table structure for table `prod_review`
--

CREATE TABLE `prod_review` (
  `rev_id` int(11) NOT NULL,
  `cust_name` varchar(255) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `return_refund`
--

CREATE TABLE `return_refund` (
  `rr_id` int(11) NOT NULL,
  `usersId` int(11) NOT NULL,
  `placeOrder` varchar(255) NOT NULL,
  `custName` varchar(255) NOT NULL,
  `item` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `qty` int(11) NOT NULL,
  `reason` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `supp_id` int(11) NOT NULL,
  `supp_name` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `contact_no` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`supp_id`, `supp_name`, `category`, `contact_no`, `city`) VALUES
(1, 'Supplier 1', 'Bike Parts', '09123456789', 'Quezon City'),
(3, 'Supplier 2', 'Bike Accessories', '09477867271', 'Pasig City'),
(4, 'Supplier 3', 'Bikes', '09612356893', 'Taguig City');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `usersId` int(11) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `usersName` varchar(100) NOT NULL,
  `usersEmail` varchar(100) NOT NULL,
  `contact` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user_order`
--

CREATE TABLE `user_order` (
  `id` int(255) NOT NULL,
  `usersId` int(255) NOT NULL,
  `place_order` varchar(255) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `number` varchar(12) NOT NULL,
  `email` varchar(255) NOT NULL,
  `method` varchar(50) NOT NULL,
  `status` varchar(100) NOT NULL,
  `pay_status` varchar(255) NOT NULL,
  `flat` varchar(100) NOT NULL,
  `street` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `zip_code` int(10) NOT NULL,
  `prod_name` varchar(255) NOT NULL,
  `qty` int(11) NOT NULL,
  `total_products` varchar(255) NOT NULL,
  `total_price` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `wish_id` int(10) NOT NULL,
  `usersId` int(11) NOT NULL,
  `wish_name` varchar(100) NOT NULL,
  `wish_img` varchar(100) NOT NULL,
  `wish_price` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`add_id`);

--
-- Indexes for table `admin_user`
--
ALTER TABLE `admin_user`
  ADD PRIMARY KEY (`adminId`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`contact_id`);

--
-- Indexes for table `example_user`
--
ALTER TABLE `example_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory_prod`
--
ALTER TABLE `inventory_prod`
  ADD PRIMARY KEY (`prod_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`pay_id`);

--
-- Indexes for table `product_list`
--
ALTER TABLE `product_list`
  ADD PRIMARY KEY (`prod_id`);

--
-- Indexes for table `prod_review`
--
ALTER TABLE `prod_review`
  ADD PRIMARY KEY (`rev_id`);

--
-- Indexes for table `return_refund`
--
ALTER TABLE `return_refund`
  ADD PRIMARY KEY (`rr_id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`supp_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`usersId`);

--
-- Indexes for table `user_order`
--
ALTER TABLE `user_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`wish_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `add_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `admin_user`
--
ALTER TABLE `admin_user`
  MODIFY `adminId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=314;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `cat_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `contact_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `example_user`
--
ALTER TABLE `example_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `inventory_prod`
--
ALTER TABLE `inventory_prod`
  MODIFY `prod_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `pay_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `product_list`
--
ALTER TABLE `product_list`
  MODIFY `prod_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `prod_review`
--
ALTER TABLE `prod_review`
  MODIFY `rev_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `return_refund`
--
ALTER TABLE `return_refund`
  MODIFY `rr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `supp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `usersId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `user_order`
--
ALTER TABLE `user_order`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `wish_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
