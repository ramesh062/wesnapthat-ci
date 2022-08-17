-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 16, 2022 at 06:48 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `unusedb_doctor_booking`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(100) NOT NULL,
  `hospital_name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `currency` int(11) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `last_update` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `password`, `hospital_name`, `address`, `currency`, `phone`, `last_update`) VALUES
(1, 'admin@gmail.com', 'e6e061838856bf47e1de730719fb2609', 'MonDoc Hospital', '201, cross road, US', 1, '97258770765', '2022-05-11 08:47:30');

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `note` text NOT NULL,
  `added_date` datetime NOT NULL,
  `status` enum('upcoming','completed','cancel','not attended','pending') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `patient_id`, `doctor_id`, `date`, `time`, `note`, `added_date`, `status`) VALUES
(169, 60, 16, '2022-05-12', '10:40:00', 'hi please book my appointment and give me your schedule', '2022-05-11 11:41:59', 'cancel'),
(170, 60, 16, '2022-05-16', '10:00:00', 'hey please take in schedule', '2022-05-11 11:52:37', 'upcoming'),
(171, 60, 16, '2022-05-16', '10:20:00', 'take second appointment', '2022-05-11 11:53:02', 'upcoming'),
(172, 60, 16, '2022-05-16', '10:40:00', 'fkffk', '2022-05-11 11:53:18', 'pending'),
(173, 60, 16, '2022-05-13', '17:20:00', 'test', '2022-05-11 12:02:33', 'upcoming'),
(174, 61, 16, '2022-05-12', '16:40:00', '', '2022-05-11 13:47:24', 'pending'),
(175, 61, 16, '2022-05-20', '17:00:00', 'gdh', '2022-05-11 15:30:39', 'cancel'),
(176, 61, 16, '2022-05-11', '16:20:00', '', '2022-05-11 17:34:15', 'pending'),
(177, 62, 17, '2022-05-11', '10:00:00', 'Test', '2022-05-11 18:41:14', 'pending'),
(178, 61, 16, '2022-05-31', '15:00:00', 'test', '2022-05-12 13:39:36', 'upcoming'),
(179, 61, 16, '2022-05-14', '15:40:00', 'gsga', '2022-05-12 14:33:08', 'cancel'),
(180, 61, 16, '2022-05-12', '17:40:00', '', '2022-05-12 14:36:18', 'upcoming'),
(181, 61, 16, '2022-05-12', '15:40:00', '', '2022-05-12 14:48:37', 'upcoming');

-- --------------------------------------------------------

--
-- Table structure for table `broadcast`
--

CREATE TABLE `broadcast` (
  `id` int(11) NOT NULL,
  `topic` varchar(30) NOT NULL,
  `message` text NOT NULL,
  `reg_date` datetime NOT NULL,
  `broadcast_date` datetime NOT NULL,
  `is_sent` enum('0','1','','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `broadcast`
--

INSERT INTO `broadcast` (`id`, `topic`, `message`, `reg_date`, `broadcast_date`, `is_sent`) VALUES
(200, 'New appointment', 'suzzy test book appointment for the time 12-05-2022 10:40 AM', '2022-05-11 11:42:02', '2022-05-11 11:42:02', '1'),
(201, 'appointment schedule', 'Your appointment accepted by docotor', '2022-05-11 11:45:26', '2022-05-11 11:45:26', '1'),
(202, 'cancel appointment', 'Appointment Canceled.', '2022-05-11 11:50:04', '2022-05-11 11:50:04', '1'),
(203, 'New appointment', 'suzzy test book appointment for the time 16-05-2022 10:00 AM', '2022-05-11 11:52:39', '2022-05-11 11:52:39', '1'),
(204, 'New appointment', 'suzzy test book appointment for the time 16-05-2022 10:20 AM', '2022-05-11 11:53:03', '2022-05-11 11:53:03', '1'),
(205, 'New appointment', 'suzzy test book appointment for the time 16-05-2022 10:40 AM', '2022-05-11 11:53:20', '2022-05-11 11:53:20', '1'),
(206, 'appointment schedule', 'Your appointment accepted by docotor', '2022-05-11 11:53:30', '2022-05-11 11:53:30', '1'),
(207, 'New appointment', 'suzzy test book appointment for the time 13-05-2022 05:20 PM', '2022-05-11 12:02:34', '2022-05-11 12:02:34', '1'),
(208, 'appointment schedule', 'Your appointment accepted by docotor', '2022-05-11 12:05:19', '2022-05-11 12:05:19', '1'),
(209, 'New appointment', 'Siddhapura Mohit book appointment for the time 12-05-2022 04:40 PM', '2022-05-11 13:47:26', '2022-05-11 13:47:26', '1'),
(210, 'New appointment', 'Siddhapura Mohit book appointment for the time 20-05-2022 05:00 PM', '2022-05-11 15:30:41', '2022-05-11 15:30:41', '1'),
(211, 'appointment schedule', 'Your appointment accepted by docotor', '2022-05-11 15:32:32', '2022-05-11 15:32:32', '1'),
(212, 'New appointment', 'Siddhapura Mohit book appointment for the time 11-05-2022 04:20 PM', '2022-05-11 17:34:17', '2022-05-11 17:34:17', '1'),
(213, 'New appointment', 'Rajesh Gondaliya book appointment for the time 11-05-2022 10:00 AM', '2022-05-11 18:41:16', '2022-05-11 18:41:16', '1'),
(214, 'New appointment', 'Siddhapura Mohit book appointment for the time 31-05-2022 03:00 PM', '2022-05-12 13:39:38', '2022-05-12 13:39:38', '1'),
(215, 'appointment schedule', 'your_appointment_accepted_by_doctor', '2022-05-12 13:41:40', '2022-05-12 13:41:40', '1'),
(216, 'appointment schedule', 'your_appointment_accepted_by_doctor', '2022-05-12 14:21:17', '2022-05-12 14:21:17', '1'),
(217, 'cancel appointment', 'appointment_canceled', '2022-05-12 14:23:08', '2022-05-12 14:23:08', '1'),
(218, 'New appointment', 'Siddhapura Mohit book appointment for the time 14-05-2022 03:40 PM', '2022-05-12 14:33:10', '2022-05-12 14:33:10', '1'),
(219, 'appointment schedule', 'your_appointment_accepted_by_doctor', '2022-05-12 14:33:43', '2022-05-12 14:33:43', '1'),
(220, 'New appointment', 'Siddhapura Mohit book appointment for the time 12-05-2022 05:40 PM', '2022-05-12 14:36:19', '2022-05-12 14:36:19', '1'),
(221, 'appointment schedule', 'your_appointment_accepted_by_doctor', '2022-05-12 14:47:52', '2022-05-12 14:47:52', '1'),
(222, 'New appointment', 'Siddhapura Mohit book appointment for the time 12-05-2022 03:40 PM', '2022-05-12 14:48:38', '2022-05-12 14:48:38', '1'),
(223, 'appointment schedule', 'your_appointment_accepted_by_doctor', '2022-05-12 14:48:55', '2022-05-12 14:48:55', '1'),
(224, 'cancel appointment', 'appointment_canceled', '2022-05-12 14:49:21', '2022-05-12 14:49:21', '1');

-- --------------------------------------------------------

--
-- Table structure for table `broadcast_recipients`
--

CREATE TABLE `broadcast_recipients` (
  `id` int(11) NOT NULL,
  `broadcast` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `type` enum('doctor','patient') NOT NULL,
  `reference_id` int(11) NOT NULL,
  `appt_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `broadcast_recipients`
--

INSERT INTO `broadcast_recipients` (`id`, `broadcast`, `user`, `type`, `reference_id`, `appt_id`) VALUES
(199, 200, 16, 'doctor', 169, 0),
(200, 201, 60, 'patient', 16, 0),
(201, 202, 16, 'doctor', 169, 0),
(202, 203, 16, 'doctor', 170, 0),
(203, 204, 16, 'doctor', 171, 0),
(204, 205, 16, 'doctor', 172, 0),
(205, 206, 60, 'patient', 16, 0),
(206, 207, 16, 'doctor', 173, 0),
(207, 208, 60, 'patient', 16, 0),
(208, 209, 16, 'doctor', 174, 0),
(209, 210, 16, 'doctor', 175, 0),
(210, 211, 61, 'patient', 16, 0),
(211, 212, 16, 'doctor', 176, 0),
(212, 213, 17, 'doctor', 177, 0),
(213, 214, 16, 'doctor', 178, 178),
(214, 215, 61, 'patient', 16, 178),
(215, 216, 60, 'patient', 16, 170),
(216, 217, 16, 'doctor', 175, 175),
(217, 218, 16, 'doctor', 179, 179),
(218, 219, 61, 'patient', 16, 179),
(219, 220, 16, 'doctor', 180, 180),
(220, 221, 61, 'patient', 16, 180),
(221, 222, 16, 'doctor', 181, 181),
(222, 223, 61, 'patient', 16, 181),
(223, 224, 16, 'doctor', 179, 179);

-- --------------------------------------------------------

--
-- Table structure for table `cms_pages`
--

CREATE TABLE `cms_pages` (
  `id` int(11) NOT NULL,
  `page_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `reg_date` datetime NOT NULL,
  `status` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cms_pages`
--

INSERT INTO `cms_pages` (`id`, `page_name`, `slug`, `content`, `reg_date`, `status`, `last_updated`) VALUES
(1, 'About', 'about', '<p>About</p>', '2021-03-10 10:18:10', 'active', '0000-00-00 00:00:00'),
(2, 'Terms and Conditions', 'terms_and_conditions', '<p>Terms and conditions</p>\n', '2021-03-10 10:18:29', 'active', '0000-00-00 00:00:00'),
(3, 'Privacy Policy', 'privacy_policy', '<p><strong>Privacy Policy</strong></p>\n<p>WhiteLabelFox built the AppoBook app as open source/free/freemium app. This SERVICE is provided by WhiteLabelFox and is intended for use as is.</p>\n<p>This page is used to inform visitors regarding our policies with the collection, use, and disclosure of Personal Information if anyone decided to use [my/our] Service.</p>\n<p>If you choose to use our Service, then you agree to the collection and use of information in relation to this policy. The Personal Information that We collect is used for providing and improving the Service. We will not use or share your information with anyone except as described in this Privacy Policy.</p>\n<p>The terms used in this Privacy Policy have the same meanings as in our Terms and Conditions, which is accessible at AppoBook unless otherwise defined in this Privacy Policy.</p>\n<p><strong>Information Collection and Use</strong></p>\n<p>For a better experience, while using our Service, We may require you to provide us with certain personally identifiable information add whatever else you collect here, e.g. users name, address, location, pictures The information that We request will be retained on your device and is not collected by us in any way/[retained by us and used as described in this privacy policy.</p>\n<p>The app does use third party services that may collect information used to identify you.</p>\n<p>Link to privacy policy of third party service providers used by the app</p>\n<ul>\n<li><a href=\"https://www.google.com/policies/privacy/\">Google Play Services</a></li>\n<li><a href=\"https://firebase.google.com/policies/analytics\">Google Analytics for Firebase</a></li>\n<li><a href=\"https://firebase.google.com/support/privacy/\">Firebase Crashlytics</a></li>\n</ul>\n<p><strong>Log Data</strong></p>\n<p>We want to inform you that whenever you use our Service, in a case of an error in the app We collect data and information (through third party products) on your phone called Log Data. This Log Data may include information such as your device Internet Protocol (&ldquo;IP&rdquo;) address, device name, operating system version, the configuration of the app when utilizing [my/our] Service, the time and date of your use of the Service, and other statistics.</p>\n<p><strong>Cookies</strong></p>\n<p>Cookies are files with a small amount of data that are commonly used as anonymous unique identifiers. These are sent to your browser from the websites that you visit and are stored on your device\'s internal memory.</p>\n<p>This Service does not use these &ldquo;cookies&rdquo; explicitly. However, the app may use third party code and libraries that use &ldquo;cookies&rdquo; to collect information and improve their services. You have the option to either accept or refuse these cookies and know when a cookie is being sent to your device. If you choose to refuse our cookies, you may not be able to use some portions of this Service.</p>\n<p><strong>Service Providers</strong></p>\n<p>We may employ third-party companies and individuals due to the following reasons:</p>\n<ul>\n<li>To facilitate our Service;</li>\n<li>To provide the Service on our behalf;</li>\n<li>To perform Service-related services; or</li>\n<li>To assist us in analyzing how our Service is used.</li>\n</ul>\n<p>We want to inform users of this Service that these third parties have access to your Personal Information. The reason is to perform the tasks assigned to them on our behalf. However, they are obligated not to disclose or use the information for any other purpose.</p>\n<p><strong>Security</strong></p>\n<p>We value your trust in providing us your Personal Information, thus we are striving to use commercially acceptable means of protecting it. But remember that no method of transmission over the internet, or method of electronic storage is 100% secure and reliable, and We cannot guarantee its absolute security.</p>\n<p><strong>Links to Other Sites</strong></p>\n<p>This Service may contain links to other sites. If you click on a third-party link, you will be directed to that site. Note that these external sites are not operated by us. Therefore, We strongly advise you to review the Privacy Policy of these websites. We have no control over and assume no responsibility for the content, privacy policies, or practices of any third-party sites or services.</p>\n<p><strong>Children&rsquo;s Privacy</strong></p>\n<p>These Services do not address anyone under the age of 13. We do not knowingly collect personally identifiable information from children under 13. In the case We discover that a child under 13 has provided us with personal information, We immediately delete this from our servers. If you are a parent or guardian and you are aware that your child has provided us with personal information, please contact us so that We will be able to do necessary actions.</p>\n<p><strong>Changes to This Privacy Policy</strong></p>\n<p>We may update our Privacy Policy from time to time. Thus, you are advised to review this page periodically for any changes. We will notify you of any changes by posting the new Privacy Policy on this page.</p>\n<p><strong>Contact Us</strong></p>\n<p>If you have any questions or suggestions about our Privacy Policy, do not hesitate to contact us at Whitelabelfoxapp@gmail.com.</p>', '2021-03-10 00:00:00', 'active', '0000-00-00 00:00:00'),
(4, 'contact_us', 'contact_us', '<p><strong>contact us </strong></p>\r\n', '2022-05-12 05:32:09', 'active', '2022-05-12 05:32:09');

-- --------------------------------------------------------

--
-- Table structure for table `consultation_hours`
--

CREATE TABLE `consultation_hours` (
  `id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `from_time` time NOT NULL,
  `to_time` time NOT NULL,
  `type` enum('doctor','hospital','','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `consultation_hours`
--

INSERT INTO `consultation_hours` (`id`, `doctor_id`, `from_time`, `to_time`, `type`) VALUES
(133, 16, '15:00:00', '20:00:00', 'doctor'),
(134, 16, '10:00:00', '13:00:00', 'doctor'),
(135, 17, '07:30:00', '13:00:00', 'doctor'),
(136, 17, '15:00:00', '20:00:00', 'doctor'),
(137, 18, '07:00:00', '13:30:00', 'doctor'),
(138, 18, '15:00:00', '19:00:00', 'doctor');

-- --------------------------------------------------------

--
-- Table structure for table `currency_table`
--

CREATE TABLE `currency_table` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `sign` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `currency_table`
--

INSERT INTO `currency_table` (`id`, `name`, `sign`) VALUES
(1, 'Indian rupee', '₹'),
(2, 'Euro', ' € '),
(3, 'Australian dollar', '$');

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(100) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `qualification` varchar(100) NOT NULL,
  `speciality` varchar(255) NOT NULL,
  `experience` varchar(100) NOT NULL,
  `gender` enum('male','female','','') NOT NULL,
  `consultation_charges` varchar(100) NOT NULL,
  `appointment_time_slots` varchar(10) NOT NULL,
  `weekly_off_days` varchar(255) NOT NULL,
  `reg_date` datetime NOT NULL,
  `last_updated` datetime NOT NULL,
  `profile_photo` varchar(255) NOT NULL,
  `status` enum('active','deleted','','') NOT NULL,
  `notification` enum('0','1','','') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`id`, `email`, `password`, `fullname`, `qualification`, `speciality`, `experience`, `gender`, `consultation_charges`, `appointment_time_slots`, `weekly_off_days`, `reg_date`, `last_updated`, `profile_photo`, `status`, `notification`) VALUES
(16, 'siddhapuramohit123@gmail.com', '48418969a4071bf494272463b4e6b324', 'mohit', 'MD', 'Bone specialist', '12', 'male', '200', '20', 'Sun', '2022-05-11 06:56:46', '2022-05-11 08:31:38', '110522081119_20210623085354.jpg', 'active', '1'),
(17, 'rajeshgondaliya.ubs@gmail.com', '8d959ed6e0109c03635b45921f9b17d9', 'Rajesh sir', 'MBBS', 'Heart specialist', '12', 'male', '500', '30', 'sun', '2022-05-11 15:04:42', '0000-00-00 00:00:00', '', 'active', '1'),
(18, 'mitul.bhadeshiya@gmail.com', '433e9dc1d031dbc5673bf744deef7ee7', 'mits', 'MBBS, MD', 'Heart,  Brain', '11', 'male', '500', '20', 'sat,sun', '2022-05-12 12:15:10', '0000-00-00 00:00:00', '', 'active', '1');

-- --------------------------------------------------------

--
-- Table structure for table `onesignals`
--

CREATE TABLE `onesignals` (
  `doctor` varchar(255) NOT NULL,
  `patient` varchar(255) NOT NULL,
  `web` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `onesignals`
--

INSERT INTO `onesignals` (`doctor`, `patient`, `web`) VALUES
('5630ec08-5ea0-4a2e-a8e2-f978c0f1e5c5', '4384f500-6b4a-4db3-a370-5bdc2407e51d', '363b9368-268a-420e-802e-fa5363e2402e ');

-- --------------------------------------------------------

--
-- Table structure for table `otp`
--

CREATE TABLE `otp` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `otp` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `otp`
--

INSERT INTO `otp` (`email`, `otp`, `date`) VALUES
('abc@gmail.com', '287156', '2021-03-12 12:44:32'),
('jasminpambhar.ubs@gmail.com', '265154', '2021-05-21 12:38:47'),
('john@gmail.com', '180101', '2022-04-22 13:24:36'),
('admin@gmail.com', '3287', '2022-04-26 17:11:52'),
('mitul.bhadeshiya@gmail.com', '485701', '2022-05-10 11:37:57'),
('mits.gajjar7@gmail.com', '877197', '2022-05-10 16:21:48'),
('mohitsiddhapura.ubs@gmail.com', '160383', '2022-05-10 16:26:13'),
('siddhapuramohit123@gmail.com', '205366', '2022-05-11 12:00:01'),
('rajeshgondaliya@gmail.com', '784939', '2022-05-11 19:35:23'),
('rajeshgondaliya.ubs@gmail.com', '624536', '2022-05-11 19:36:49');

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(100) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `countrycode` varchar(4) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `otp_varified` tinyint(1) NOT NULL,
  `age` varchar(10) NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `profile_photo` varchar(255) NOT NULL,
  `notification` enum('0','1') NOT NULL DEFAULT '1',
  `reg_date` datetime NOT NULL,
  `last_updated` datetime NOT NULL,
  `type` enum('registered','guest') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `email`, `password`, `fullname`, `countrycode`, `mobile`, `otp_varified`, `age`, `gender`, `profile_photo`, `notification`, `reg_date`, `last_updated`, `type`) VALUES
(60, '', 'd6c4105ff265a61f20b338a6f5cfc487', 'suzzy test', '+91', '8320120988', 1, '23', 'female', '110522082056_Profile_Image_Z2lkOi8vc2hvcGlmeS9DdXN0b21lci81MjgyMjI5MDkyNTMw.jpg', '1', '2022-05-11 08:06:14', '2022-05-11 08:21:11', 'registered'),
(61, '', '25f9e794323b453885f5181f1b624d0b', 'Siddhapura Mohit', '+91', '9737620803', 1, '25', 'male', '', '1', '2022-05-11 08:06:21', '2022-05-11 11:36:25', 'registered'),
(62, '', '25f9e794323b453885f5181f1b624d0b', 'Rajesh Gondaliya', '+91', '8153845664', 1, '20', 'male', '', '1', '2022-05-11 08:52:49', '2022-05-11 17:24:32', 'registered'),
(63, '', '25f9e794323b453885f5181f1b624d0b', 'Jock', '+91', '815384565', 1, '20', 'male', '', '1', '2022-05-11 12:00:35', '2022-05-11 15:30:43', 'registered'),
(64, '', '433e9dc1d031dbc5673bf744deef7ee7', 'Mitul Bhadeshiya', '+91', '9725877076', 1, '22', 'male', '', '1', '2022-05-12 15:19:20', '2022-05-12 18:49:24', 'registered');

-- --------------------------------------------------------

--
-- Table structure for table `prescriptions`
--

CREATE TABLE `prescriptions` (
  `id` int(11) NOT NULL,
  `appt_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `attachment` varchar(255) NOT NULL,
  `added_date` datetime NOT NULL,
  `last_updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_devices`
--

CREATE TABLE `user_devices` (
  `user` int(11) NOT NULL,
  `udid` varchar(255) NOT NULL,
  `device_type` varchar(10) NOT NULL,
  `type` enum('doctor','patient','admin','') NOT NULL,
  `os_version` varchar(30) NOT NULL,
  `handset` varchar(50) NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  `time_zone` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_devices`
--

INSERT INTO `user_devices` (`user`, `udid`, `device_type`, `type`, `os_version`, `handset`, `ip_address`, `time_zone`) VALUES
(60, '', '', 'patient', '', '', '', ''),
(61, '18a83db4-2908-4e63-8b65-73dee497d20d', 'android', 'patient', '8.1.0', 'Redmi 5A', 'c97445161ceb7acd', 'Asia/Kolkata'),
(16, '6dab2189-7ade-4701-996b-d5e3a8f0b44f', 'android', 'doctor', '8.1.0', 'Redmi 5A', 'c97445161ceb7acd', 'Asia/Kolkata'),
(62, '', 'iOS', 'patient', '15.2', 'x86_64', '123.201.68.236', 'Asia/Kolkata'),
(63, '', 'iOS', 'patient', '15.2', 'x86_64', '123.201.68.236', 'Asia/Kolkata'),
(17, '', 'iOS', 'doctor', '15.2', 'x86_64', '123.201.68.236', 'Asia/Kolkata'),
(18, '02a83934-9c19-49fd-978e-2505f2ffe959', 'iOS', 'doctor', '15.2', 'x86_64', '123.201.67.124', 'Asia/Kolkata'),
(64, '6277857b-8590-48a3-ae90-32c00682fa23', 'iOS', 'patient', '15.2', 'x86_64', '123.201.67.124', 'Asia/Kolkata');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `broadcast`
--
ALTER TABLE `broadcast`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `broadcast_recipients`
--
ALTER TABLE `broadcast_recipients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_pages`
--
ALTER TABLE `cms_pages`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `consultation_hours`
--
ALTER TABLE `consultation_hours`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currency_table`
--
ALTER TABLE `currency_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prescriptions`
--
ALTER TABLE `prescriptions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=182;

--
-- AUTO_INCREMENT for table `broadcast`
--
ALTER TABLE `broadcast`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=225;

--
-- AUTO_INCREMENT for table `broadcast_recipients`
--
ALTER TABLE `broadcast_recipients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=224;

--
-- AUTO_INCREMENT for table `consultation_hours`
--
ALTER TABLE `consultation_hours`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

--
-- AUTO_INCREMENT for table `currency_table`
--
ALTER TABLE `currency_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `prescriptions`
--
ALTER TABLE `prescriptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
