-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 03, 2021 at 08:51 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `status_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_active_log`
--

CREATE TABLE `tbl_active_log` (
  `id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `date_time` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`id`, `username`, `password`, `email`, `image`) VALUES
(1, 'admin', 'admin', 'viaviwebtech@gmail.com', 'profile.png');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE `tbl_category` (
  `cid` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `category_image` varchar(255) NOT NULL,
  `start_color` varchar(30) NOT NULL DEFAULT 'FF493B',
  `end_color` varchar(30) NOT NULL DEFAULT 'FFE245',
  `show_on_home` int(1) NOT NULL DEFAULT 0,
  `status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_category`
--

INSERT INTO `tbl_category` (`cid`, `category_name`, `category_image`, `start_color`, `end_color`, `show_on_home`, `status`) VALUES
(8, 'Funny', '83030.png', 'EB8B60', 'C56185', 1, 1),
(10, 'Inspiration', '73539.png', 'EC6757', 'CB165D', 1, 1),
(11, 'Singing', '39088.png', 'D36A7E', '875F7C', 0, 1),
(12, 'Dancing', '54600.png', '3FBEA1', '1C5C9D', 1, 1),
(13, 'Romance', '65618.png', 'F9503C', 'E42C6A', 1, 1),
(14, 'Friendship', '97351.png', 'FF3E2E', 'FFA95C', 1, 1),
(20, 'Sad', '94954.png', '5E21FF', '987DFF', 0, 1),
(21, 'Love', '73774.png', 'C23156', '7F3581', 1, 1),
(26, 'Birthday', '69184.png', '32B2C2', '2A89DE', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_comments`
--

CREATE TABLE `tbl_comments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `comment_text` text NOT NULL,
  `comment_on` varchar(150) NOT NULL,
  `type` varchar(20) NOT NULL DEFAULT 'video',
  `status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_contact_list`
--

CREATE TABLE `tbl_contact_list` (
  `id` int(11) NOT NULL,
  `contact_name` varchar(255) NOT NULL,
  `contact_email` varchar(255) NOT NULL,
  `contact_subject` int(5) NOT NULL,
  `contact_msg` text NOT NULL,
  `created_at` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_contact_sub`
--

CREATE TABLE `tbl_contact_sub` (
  `id` int(5) NOT NULL,
  `title` varchar(150) CHARACTER SET utf8mb4 NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_contact_sub`
--

INSERT INTO `tbl_contact_sub` (`id`, `title`, `status`) VALUES
(2, 'Suspend', 1),
(3, 'Other', 1),
(4, 'Transaction', 1),
(5, 'Verification issue', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_deleted_users`
--

CREATE TABLE `tbl_deleted_users` (
  `id` int(10) NOT NULL,
  `user_code` varchar(150) NOT NULL,
  `user_type` varchar(30) NOT NULL,
  `device_id` text NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `total_video` int(10) NOT NULL DEFAULT 0,
  `total_image` int(10) NOT NULL DEFAULT 0,
  `total_gif` int(10) NOT NULL DEFAULT 0,
  `total_quote` int(10) NOT NULL DEFAULT 0,
  `total_point` int(10) NOT NULL DEFAULT 0,
  `pending_points` int(10) NOT NULL DEFAULT 0,
  `paid_points` int(10) NOT NULL DEFAULT 0,
  `total_followers` int(10) NOT NULL DEFAULT 0,
  `total_following` int(10) NOT NULL DEFAULT 0,
  `verify_status` int(3) NOT NULL,
  `registration_on` text NOT NULL,
  `auth_id` text NOT NULL,
  `deleted_on` text NOT NULL,
  `deleted_by` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_favourite`
--

CREATE TABLE `tbl_favourite` (
  `id` int(10) NOT NULL,
  `post_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `type` varchar(30) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_follows`
--

CREATE TABLE `tbl_follows` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `follower_id` int(11) NOT NULL,
  `created_at` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_img_status`
--

CREATE TABLE `tbl_img_status` (
  `id` int(10) NOT NULL,
  `user_id` int(10) DEFAULT 0,
  `cat_id` int(10) NOT NULL,
  `lang_ids` text NOT NULL,
  `image_title` varchar(150) NOT NULL,
  `image_tags` text NOT NULL,
  `image_layout` varchar(40) NOT NULL,
  `image_file` text NOT NULL,
  `total_download` int(10) NOT NULL DEFAULT 0,
  `total_likes` int(10) NOT NULL DEFAULT 0,
  `total_views` int(10) NOT NULL DEFAULT 0,
  `featured` int(2) NOT NULL DEFAULT 0,
  `created_at` varchar(60) NOT NULL DEFAULT '0',
  `status_type` varchar(30) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_img_status`
--

INSERT INTO `tbl_img_status` (`id`, `user_id`, `cat_id`, `lang_ids`, `image_title`, `image_tags`, `image_layout`, `image_file`, `total_download`, `total_likes`, `total_views`, `featured`, `created_at`, `status_type`, `status`) VALUES
(1, 0, 21, '6', 'Love Birds are Here !', 'Love birds, Kiss,Cute', 'Landscape', '94528_img_status.jpg', 0, 0, 0, 0, '0', 'image', 1),
(2, 0, 13, '6', 'Cute Happy Valentine Day', 'Valentine Day,Love,Valentine', 'Portrait', '47305_gif_status.gif', 0, 0, 0, 1, '0', 'gif', 1),
(3, 0, 21, '6', 'Valentine day Black Image', 'valentine day,valentine', 'Landscape', '19628_gif_status.gif', 0, 0, 0, 0, '0', 'gif', 1),
(4, 0, 21, '6', 'Valentine day Image 2', 'Valentine ,Valentine Day', 'Landscape', '99463_gif_status.gif', 0, 0, 2, 0, '0', 'gif', 1),
(5, 0, 21, '6', 'Hindi Valentine day Image', 'Hindi ,Valentine,Hindi Valentine', 'Portrait', '73971_gif_status.gif', 0, 0, 0, 1, '0', 'gif', 1),
(15, 0, 10, '3,5', 'City', 'city', 'Landscape', '57638_gif_status.gif', 0, 0, 1, 1, '0', 'gif', 1),
(16, 0, 12, '3', 'Animation', 'dancing ,barbie ', 'Portrait', '43419_gif_status.gif', 2, 0, 3, 1, '0', 'gif', 1),
(18, 0, 26, '7', 'Happy Birthday', 'birthday', 'Landscape', '95098_image_status.jpg', 0, 0, 2, 0, '0', 'image', 1),
(19, 0, 26, '7', 'Birthday wish', 'birhtday', 'Landscape', '47328_image_status.jpg', 0, 0, 2, 0, '0', 'image', 1),
(20, 0, 20, '7', 'sad', 'sad,quotes', 'Landscape', '18993_image_status.jpg', 1, 0, 1, 0, '0', 'image', 1),
(21, 0, 20, '5', 'sad quotes', 'quotes,shayri ', 'Portrait', '47150_image_status.jpg', 0, 0, 0, 0, '0', 'image', 1),
(22, 0, 20, '5', 'Quotes', 'sad', 'Portrait', '92289_image_status.jpg', 1, 0, 6, 0, '0', 'image', 1),
(23, 0, 21, '6', 'Love', 'Quotes,Love', 'Portrait', '98449_image_status.jpg', 0, 0, 1, 0, '0', 'image', 1),
(24, 0, 13, '6', 'Image Quotes', 'love,quote ,romance', 'Portrait', '37002_image_status.jpg', 0, 0, 0, 0, '0', 'image', 1),
(25, 0, 21, '6', 'Love', 'romance,love', 'Landscape', '568_image_status.jpg', 0, 1, 2, 0, '0', 'image', 1),
(26, 0, 13, '6', 'Love Quotes', 'love,Quotes,romance', 'Landscape', '40662_image_status.jpg', 0, 0, 0, 0, '0', 'image', 1),
(27, 0, 14, '4', 'Friendship Tamil', 'tamil,friendship', 'Landscape', '85731_image_status.png', 0, 1, 2, 0, '0', 'image', 1),
(28, 0, 14, '4', 'Tamil Quotes', 'Quotes,tamil,friend', 'Landscape', '13277_image_status.png', 0, 0, 0, 0, '0', 'image', 1),
(29, 0, 11, '8', 'Lyrics', 'Punjabi ,quotes', 'Landscape', '67614_image_status.jpg', 0, 0, 1, 0, '0', 'image', 1),
(30, 0, 8, '8', 'Funny images', 'Images,funny', 'Portrait', '82693_image_status.jpg', 1, 0, 14, 0, '0', 'image', 1),
(41, 0, 10, '7', 'Test image', 'Test', 'Landscape', '68293_image_status.jpg', 0, 0, 5, 0, '1620812796', 'image', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_language`
--

CREATE TABLE `tbl_language` (
  `id` int(11) NOT NULL,
  `language_name` varchar(255) NOT NULL,
  `language_image` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_language`
--

INSERT INTO `tbl_language` (`id`, `language_name`, `language_image`, `status`) VALUES
(3, 'عربى', '53477_unnamed.png', 1),
(4, 'தமிழ்', '22010_YZpHOsdtbsrfdoE-800x450-noPad.jpg', 1),
(5, 'हिंदी', '45650_hindi-is-the-3rd-most-spoken-language-of-the-world.jpg', 1),
(6, 'English', '12146_800px-English_language.svg.png', 1),
(7, 'ગુજરાતી', '86551_gujrati-icon.jpg', 1),
(8, 'ਪੰਜਾਬੀ', '98556_mind-your-language-ab3b94e5aabc57d7a45efc18fdcb001d.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_like`
--

CREATE TABLE `tbl_like` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `device_id` varchar(255) NOT NULL,
  `likes` int(11) NOT NULL DEFAULT 0,
  `unlike` int(11) NOT NULL DEFAULT 0,
  `like_type` varchar(10) NOT NULL DEFAULT 'video'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_payment_mode`
--

CREATE TABLE `tbl_payment_mode` (
  `id` int(5) NOT NULL,
  `mode_title` varchar(150) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_payment_mode`
--

INSERT INTO `tbl_payment_mode` (`id`, `mode_title`, `status`) VALUES
(1, 'Paypal', 1),
(2, 'PayTM', 1),
(3, 'Bank Detail', 1),
(5, 'Others', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_quotes`
--

CREATE TABLE `tbl_quotes` (
  `id` int(10) NOT NULL,
  `cat_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `lang_ids` text COLLATE utf8mb4_bin NOT NULL,
  `quote` longtext COLLATE utf8mb4_bin NOT NULL,
  `quote_font` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `quote_tags` text COLLATE utf8mb4_bin NOT NULL,
  `quote_bg` text COLLATE utf8mb4_bin NOT NULL,
  `quotes_html` longtext COLLATE utf8mb4_bin NOT NULL,
  `total_likes` int(10) NOT NULL DEFAULT 0,
  `total_views` int(10) NOT NULL DEFAULT 0,
  `featured` int(2) NOT NULL DEFAULT 0,
  `created_at` varchar(60) COLLATE utf8mb4_bin NOT NULL DEFAULT '0',
  `status` int(2) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `tbl_quotes`
--

INSERT INTO `tbl_quotes` (`id`, `cat_id`, `user_id`, `lang_ids`, `quote`, `quote_font`, `quote_tags`, `quote_bg`, `quotes_html`, `total_likes`, `total_views`, `featured`, `created_at`, `status`) VALUES
(1, 21, 0, '6', 'I love you. \r\nI knew it the minute I met you. \r\nI\\\'m sorry it took so long for me to catch up. \r\nI just got stuck\r\n❤️❤️❤️', 'Pacifico.ttf', 'I love you,VALENTINE\'S DAY', 'FF426D', '', 0, 0, 1, '0', 1),
(7, 8, 0, '5', 'आज पुरानी GF मिली बाज़ार में… \r\nमैं उसे “हलो कहने ही वाला था,\r\nकि \r\nउसके पति ने \r\n“चलो” \r\nकह दिया…\r\n😅😅😅', 'Lemonada.ttf', 'funny', '5b76e9', '&lt;div&gt;आज पुरानी GF मिली बाज़ार में&hellip; &lt;br&gt;&lt;/div&gt;&lt;div&gt;मैं उसे &ldquo;हलो कहने ही वाला था,&lt;/div&gt;&lt;div&gt;कि &lt;br&gt;&lt;/div&gt;&lt;div&gt;उसके पति ने &lt;br&gt;&lt;/div&gt;&lt;div&gt;&ldquo;चलो&rdquo; &lt;br&gt;&lt;/div&gt;&lt;div&gt;कह दिया&hellip;&lt;/div&gt;&lt;div&gt;&lt;img src=&quot;vendor/emoji-picker/lib/img//blank.gif&quot; class=&quot;img&quot; style=&quot;display:inline-block;width:25px;height:25px;background:url(\'vendor/emoji-picker/lib/img//emoji_spritesheet_0.png\') 0px -25px no-repeat;background-size:675px 175px;&quot; alt=&quot;:sweat_smile:&quot;&gt;&lt;img src=&quot;vendor/emoji-picker/lib/img//blank.gif&quot; class=&quot;img&quot; style=&quot;display:inline-block;width:25px;height:25px;background:url(\'vendor/emoji-picker/lib/img//emoji_spritesheet_0.png\') 0px -25px no-repeat;background-size:675px 175px;&quot; alt=&quot;:sweat_smile:&quot;&gt;&lt;img src=&quot;vendor/emoji-picker/lib/img//blank.gif&quot; class=&quot;img&quot; style=&quot;display:inline-block;width:25px;height:25px;background:url(\'vendor/emoji-picker/lib/img//emoji_spritesheet_0.png\') 0px -25px no-repeat;background-size:675px 175px;&quot; alt=&quot;:sweat_smile:&quot;&gt;&lt;/div&gt;', 2, 5, 0, '0', 1),
(8, 8, 0, '5', 'लड़का होने का एक फायदा ये भी है जब भी बेइज़्ज़ती होने लगे घर से निकल जाओ पर पापा की परियों को तो पूरी कव्वाली सुननी पड़ती है\r\n😂😅😜', 'Poppins.ttf', 'पापा की परियों', 'E91E63', '', 0, 4, 0, '0', 1),
(9, 8, 0, '5', 'लड़की पटाने के चक्कर में इतने भी caring ना बन जाना कि उसे तुममें अपना भाई नज़र आने लगे 😄😅😄😅', 'Roboto.ttf', '', '3B0819', '', 1, 7, 0, '0', 1),
(10, 21, 0, '6', 'Love is dat ocean in which even if u get drown u wont call 4 help..\r\ncoz itz d suicide which u have committed 2 begin another new beautiful life ❤️❤️❤️', 'Poppins.ttf', '', 'e97b59', '', 0, 0, 0, '0', 1),
(11, 21, 0, '6', 'if i cud gift u sumthing in lyf\r\ni wud gift u d ability 2 c urself thru my eyes..\r\nonly den wud u realiz how special u r 2 me.\r\nI love u swthrt..', 'Lemonada.ttf', '', 'E92C2C', '', 0, 0, 0, '0', 1),
(12, 13, 0, '6', 'Love has its ups and downs, its twists and turns.\r\nLove leaves you pain, teaches u until you learn\r\nand,\r\neven if love takes so long,\r\nit always takes you to where you belong.', 'Pacifico.ttf', '', 'D756E9', '', 0, 0, 0, '0', 1),
(13, 13, 0, '6', 'Day & Night only your thought,\r\nOther than you no one in my heart,\r\nYou are MY ANGEL that is a fact,\r\nYou have became beat of my heart,\r\nLove you still my soul will depart….', 'Cinzel.ttf', '', '33E9D2', '', 0, 0, 0, '0', 1),
(14, 20, 0, '5', 'तुम क़रीब हो मगर फ़िर भी तुम्हारे बदन से वो मोहब्बत की खूश्बू आती नहीं।\r\nइन हवाओं का रूख भी बदल रहा है, लगता है तुम्हें अब सोहबत मेरी भाती नहीं।\r\n😢😢😢', 'Poppins.ttf', '', 'E95B5B', '', 0, 0, 0, '0', 1),
(15, 20, 0, '5', 'किस्मत के खेल को, कौन जानता था,\r\nजो आज मेरा हैं वो कल पराया होगा,\r\nजानकर भी रोक ना पाते तकदीर की रवानी को,\r\nकिस्मत ने भी जाने कितनो को हराया होगा', 'Pacifico.ttf', 'किस्मत  ,हराया  ', 'E91E63', '', 0, 0, 0, '0', 1),
(16, 14, 0, '5', 'मुझसे एक दोस्त नहीं बदला जाता,\r\nचाहे लाख दूरी होने पर\r\nलोगों के तो भगवान तक बदल जाते हैं\r\nएक मुराद पूरी ना होने पर', 'Cinzel.ttf', '', 'E91E63', '', 0, 0, 0, '0', 1),
(17, 14, 0, '5', 'दोस्त दिल की हर बात समझ जाया करते हैं\r\nसुख दुःख के हर पल में साथ हुआ करते है\r\nदोस्त तो मिला करते है तक़दीर वालो को\r\nमिले ऐसी तक़दीर हर बार हम दुआ करते है', 'Poppins.ttf', '', 'E91E63', '', 0, 0, 0, '0', 1),
(18, 13, 0, '4', 'நான் உன் இதய வீட்டில் வசிக்க விரும்புகிறேன், அது எனக்கு மிகுந்த மகிழ்ச்சியை தருகிறது, என் வாழ்நாளிற்கும் அங்கு தங்கிட ஆசைபடுகிறேன்!', 'Cinzel.ttf', '', 'E91E63', '', 0, 2, 0, '0', 1),
(19, 13, 0, '4', 'நான் உன்னுள் என் சுவர்க்கத்தை கண்டேன், வாழ்க்கை அழகாகே தெரிகின்றது,\r\nநான் உன்னுள் என் வாழ்கையை கண்டேன், வாழ்க்கையின் அழகிய நிறம் கூடுகின்றது!', 'Anton.ttf', '', 'E91E63', '', 0, 1, 0, '0', 1),
(20, 10, 0, '7', 'જીવનના દરેક તબક્કે \r\nઆપણે અલગઅલગ વસ્તુઓ \r\nપામવાની ઘેલછામાં \r\nગાંડા \r\nથતા હોઈએ છીએ.', 'Anton.ttf', '', 'e91e63', '&lt;div&gt;જીવનના દરેક તબક્કે &lt;br&gt;&lt;/div&gt;&lt;div&gt;આપણે અલગઅલગ વસ્તુઓ &lt;br&gt;&lt;/div&gt;&lt;div&gt;પામવાની ઘેલછામાં &lt;br&gt;&lt;/div&gt;&lt;div&gt;ગાંડા &lt;br&gt;&lt;/div&gt;&lt;div&gt;થતા હોઈએ છીએ.&lt;/div&gt;', 0, 1, 0, '0', 1),
(21, 10, 0, '7', 'હોઇ શકે કે\r\nકોઇક તમારા કરતાં વધારે સુંદર\r\nકે વધારે હેન્ડસમ હશે.\r\nકોઇક વધારે સ્માર્ટ\r\nકે વધારે ઇન્ટેલિજન્ટ હશે.\r\nકોઇક વધારે પૈસાદાર\r\nકે વધારે પ્રસિદ્ધ હશે.\r\nપણ, કોઇ તમારા જેવું નહીં જ હોય!\r\nતમે કોઇના જેવા થવાની મથામણ છોડો,\r\nકેમ કે\r\nતમે જે છો,\r\nએ પરફેક્ટ જ છો.', 'Poppins.ttf', '', 'E91E63', '', 0, 8, 0, '0', 1),
(22, 21, 0, '6', 'It\'s Really good for all\r\nAnd\r\nWe Love All these things \r\n❤️❤️❤️', 'Lemonada.ttf', '', '759ae9', '&lt;div&gt;It\'s Really good for all&lt;/div&gt;&lt;div&gt;And&lt;/div&gt;&lt;div&gt;We Love All these things &lt;br&gt;&lt;/div&gt;&lt;div&gt;❤️❤️❤️&lt;/div&gt;', 0, 3, 0, '0', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_reports`
--

CREATE TABLE `tbl_reports` (
  `id` int(11) NOT NULL,
  `post_id` int(10) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `email` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `report` text NOT NULL,
  `report_type` varchar(30) NOT NULL DEFAULT 'video',
  `report_on` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_settings`
--

CREATE TABLE `tbl_settings` (
  `id` int(5) NOT NULL,
  `envato_buyer_name` varchar(255) NOT NULL,
  `envato_purchase_code` varchar(255) NOT NULL,
  `envato_buyer_email` varchar(150) NOT NULL,
  `envato_purchased_status` int(1) NOT NULL DEFAULT 0,
  `package_name` varchar(150) NOT NULL,
  `email_from` varchar(150) NOT NULL,
  `redeem_points` int(11) NOT NULL,
  `redeem_money` float(11,2) NOT NULL,
  `redeem_currency` varchar(100) NOT NULL,
  `minimum_redeem_points` int(11) NOT NULL,
  `onesignal_app_id` text NOT NULL,
  `onesignal_rest_key` text NOT NULL,
  `app_name` text NOT NULL,
  `app_logo` text NOT NULL,
  `app_email` varchar(150) NOT NULL,
  `app_version` varchar(60) NOT NULL,
  `app_author` varchar(150) NOT NULL,
  `app_contact` varchar(60) NOT NULL,
  `app_website` varchar(100) NOT NULL,
  `app_description` text NOT NULL,
  `app_developed_by` varchar(100) NOT NULL,
  `app_privacy_policy` text NOT NULL,
  `api_page_limit` int(11) NOT NULL,
  `api_all_order_by` varchar(30) NOT NULL,
  `api_latest_limit` int(3) NOT NULL,
  `api_cat_order_by` varchar(30) NOT NULL,
  `api_cat_post_order_by` varchar(30) NOT NULL,
  `publisher_id` text NOT NULL,
  `interstitial_ad` text NOT NULL,
  `registration_reward` int(50) NOT NULL,
  `app_refer_reward` int(50) NOT NULL,
  `video_views` int(5) NOT NULL,
  `video_add` int(11) NOT NULL,
  `like_video_points` int(11) NOT NULL,
  `download_video_points` int(11) NOT NULL,
  `registration_reward_status` varchar(20) NOT NULL DEFAULT 'true',
  `app_refer_reward_status` varchar(20) NOT NULL DEFAULT 'true',
  `video_views_status` varchar(20) NOT NULL DEFAULT 'true',
  `video_add_status` varchar(20) NOT NULL DEFAULT 'true',
  `like_video_points_status` varchar(20) NOT NULL DEFAULT 'false',
  `download_video_points_status` varchar(20) NOT NULL DEFAULT 'false',
  `other_user_video_status` varchar(10) NOT NULL,
  `other_user_video_point` varchar(10) NOT NULL,
  `image_add` int(5) NOT NULL DEFAULT 1,
  `image_add_status` varchar(20) NOT NULL,
  `image_views` int(5) NOT NULL DEFAULT 1,
  `image_views_status` varchar(20) NOT NULL,
  `other_user_image_point` int(5) NOT NULL DEFAULT 1,
  `other_user_image_status` varchar(20) NOT NULL,
  `like_image_points` int(5) NOT NULL DEFAULT 1,
  `like_image_points_status` varchar(20) NOT NULL,
  `download_image_points` int(5) NOT NULL DEFAULT 1,
  `download_image_points_status` varchar(20) NOT NULL,
  `gif_add` int(5) NOT NULL DEFAULT 1,
  `gif_add_status` varchar(20) NOT NULL,
  `gif_views` int(5) NOT NULL DEFAULT 1,
  `gif_views_status` varchar(20) NOT NULL,
  `other_user_gif_point` int(5) NOT NULL DEFAULT 1,
  `other_user_gif_status` varchar(20) NOT NULL,
  `like_gif_points` int(5) NOT NULL DEFAULT 1,
  `like_gif_points_status` varchar(20) NOT NULL,
  `download_gif_points` int(5) NOT NULL DEFAULT 1,
  `download_gif_points_status` varchar(20) NOT NULL,
  `quotes_add` int(5) NOT NULL DEFAULT 1,
  `quotes_add_status` varchar(20) NOT NULL DEFAULT 'false',
  `quotes_views` int(5) NOT NULL DEFAULT 1,
  `quotes_views_status` varchar(20) NOT NULL DEFAULT 'false',
  `other_user_quotes_point` int(5) NOT NULL DEFAULT 1,
  `other_user_quotes_status` varchar(20) NOT NULL DEFAULT 'false',
  `like_quotes_points` int(5) NOT NULL DEFAULT 1,
  `like_quotes_points_status` varchar(20) NOT NULL DEFAULT 'false',
  `interstitial_ad_id` text NOT NULL,
  `interstitial_ad_click` varchar(10) NOT NULL,
  `banner_ad` text NOT NULL,
  `banner_ad_type` varchar(30) NOT NULL,
  `banner_ad_id` text NOT NULL,
  `interstitial_ad_type` varchar(30) NOT NULL,
  `facebook_interstitial_ad_id` varchar(255) NOT NULL,
  `facebook_banner_ad_id` varchar(255) NOT NULL,
  `app_update_status` varchar(10) NOT NULL DEFAULT 'false',
  `app_new_version` double NOT NULL DEFAULT 1,
  `app_update_desc` text NOT NULL,
  `app_redirect_url` text NOT NULL,
  `cancel_update_status` varchar(10) NOT NULL DEFAULT 'false',
  `account_delete_intruction` longtext NOT NULL,
  `rewarded_video_ads` varchar(20) NOT NULL,
  `rewarded_video_ads_id` text NOT NULL,
  `rewarded_video_click` int(3) NOT NULL DEFAULT 5,
  `app_faq` text NOT NULL,
  `otp_status` varchar(10) DEFAULT 'true',
  `watermark_on_off` varchar(20) NOT NULL DEFAULT 'false',
  `watermark_image` text DEFAULT NULL,
  `spinner_opt` varchar(10) NOT NULL DEFAULT 'Enable',
  `ad_on_spin` varchar(10) NOT NULL DEFAULT 'false',
  `spinner_limit` int(10) NOT NULL DEFAULT 1,
  `auto_approve` varchar(10) NOT NULL,
  `auto_approve_img` varchar(10) NOT NULL DEFAULT 'off',
  `auto_approve_gif` varchar(10) NOT NULL DEFAULT 'off',
  `auto_approve_quote` varchar(10) NOT NULL DEFAULT 'off',
  `default_youtube_url` varchar(255) NOT NULL,
  `default_instagram_url` varchar(255) NOT NULL,
  `user_video_upload_limit` int(10) NOT NULL DEFAULT 5,
  `user_image_upload_limit` int(10) NOT NULL DEFAULT 5,
  `user_gif_upload_limit` int(10) NOT NULL DEFAULT 5,
  `user_quotes_upload_limit` int(10) NOT NULL DEFAULT 5,
  `video_upload_opt` varchar(10) NOT NULL DEFAULT 'true',
  `image_upload_opt` varchar(10) NOT NULL DEFAULT 'true',
  `gif_upload_opt` varchar(10) NOT NULL DEFAULT 'true',
  `quotes_upload_opt` varchar(10) NOT NULL DEFAULT 'true',
  `video_file_size` int(5) NOT NULL DEFAULT 5,
  `video_file_duration` int(10) NOT NULL DEFAULT 30,
  `image_file_size` int(5) NOT NULL DEFAULT 5,
  `gif_file_size` int(5) NOT NULL DEFAULT 5,
  `cat_show_home_limit` int(10) NOT NULL DEFAULT 6,
  `delete_note` text NOT NULL,
  `app_term_condition` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_settings`
--

INSERT INTO `tbl_settings` (`id`, `envato_buyer_name`, `envato_purchase_code`, `envato_buyer_email`, `envato_purchased_status`, `package_name`, `email_from`, `redeem_points`, `redeem_money`, `redeem_currency`, `minimum_redeem_points`, `onesignal_app_id`, `onesignal_rest_key`, `app_name`, `app_logo`, `app_email`, `app_version`, `app_author`, `app_contact`, `app_website`, `app_description`, `app_developed_by`, `app_privacy_policy`, `api_page_limit`, `api_all_order_by`, `api_latest_limit`, `api_cat_order_by`, `api_cat_post_order_by`, `publisher_id`, `interstitial_ad`, `registration_reward`, `app_refer_reward`, `video_views`, `video_add`, `like_video_points`, `download_video_points`, `registration_reward_status`, `app_refer_reward_status`, `video_views_status`, `video_add_status`, `like_video_points_status`, `download_video_points_status`, `other_user_video_status`, `other_user_video_point`, `image_add`, `image_add_status`, `image_views`, `image_views_status`, `other_user_image_point`, `other_user_image_status`, `like_image_points`, `like_image_points_status`, `download_image_points`, `download_image_points_status`, `gif_add`, `gif_add_status`, `gif_views`, `gif_views_status`, `other_user_gif_point`, `other_user_gif_status`, `like_gif_points`, `like_gif_points_status`, `download_gif_points`, `download_gif_points_status`, `quotes_add`, `quotes_add_status`, `quotes_views`, `quotes_views_status`, `other_user_quotes_point`, `other_user_quotes_status`, `like_quotes_points`, `like_quotes_points_status`, `interstitial_ad_id`, `interstitial_ad_click`, `banner_ad`, `banner_ad_type`, `banner_ad_id`, `interstitial_ad_type`, `facebook_interstitial_ad_id`, `facebook_banner_ad_id`, `app_update_status`, `app_new_version`, `app_update_desc`, `app_redirect_url`, `cancel_update_status`, `account_delete_intruction`, `rewarded_video_ads`, `rewarded_video_ads_id`, `rewarded_video_click`, `app_faq`, `otp_status`, `watermark_on_off`, `watermark_image`, `spinner_opt`, `ad_on_spin`, `spinner_limit`, `auto_approve`, `auto_approve_img`, `auto_approve_gif`, `auto_approve_quote`, `default_youtube_url`, `default_instagram_url`, `user_video_upload_limit`, `user_image_upload_limit`, `user_gif_upload_limit`, `user_quotes_upload_limit`, `video_upload_opt`, `image_upload_opt`, `gif_upload_opt`, `quotes_upload_opt`, `video_file_size`, `video_file_duration`, `image_file_size`, `gif_file_size`, `cat_show_home_limit`, `delete_note`) VALUES
(1, '', '', '-', 0, 'com.example.status', '', 100, 1.00, 'USD', 5, '', '', 'Status Reward App', 'ic_launcher.png', 'viaviwebtech@gmail.com', '1.0.0', 'Viavi Webtech', '+91 9227777522', 'www.viaviweb.com', '<p>As Viavi Webtech is finest offshore IT company which has expertise in the below mentioned all technologies and our professional, dedicated approach towards our work has always satisfied our clients as well as users. We have reached to this level because of the dedication and hard work of our 10+ years experienced team as well as new ideas of freshers, they always provide the best solutions. Here are the promising services served by Viavi Webtech.</p>\r\n\r\n<p>Contact on Skype &amp; Email for more information.</p>\r\n\r\n<p><strong>Skype ID:</strong> support.viaviweb <strong>OR</strong> viaviwebtech<br />\r\n<strong>Email:</strong> info@viaviweb.com <strong>OR</strong> viaviwebtech@gmail.com<br />\r\n<strong>Website:</strong> <a href=\"http://www.viaviweb.com\">http://www.viaviweb.com</a><br />\r\n<br />\r\nOur Products : <em><strong><a href=\"https://codecanyon.net/user/viaviwebtech/portfolio?ref=viaviwebtech\">CODECANYON</a></strong></em></p>\r\n', 'Viavi Webtech', '<p><strong>We are committed to protecting your privacy</strong></p>\r\n\r\n<p>We collect the minimum amount of information about you that is commensurate with providing you with a satisfactory service. This policy indicates the type of processes that may result in data being collected about you. Your use of this website gives us the right to collect that information.&nbsp;</p>\r\n\r\n<p><strong>Information Collected</strong></p>\r\n\r\n<p>We may collect any or all of the information that you give us depending on the type of transaction you enter into, including your name, address, telephone number, and email address, together with data about your use of the website. Other information that may be needed from time to time to process a request may also be collected as indicated on the website.</p>\r\n\r\n<p><strong>Information Use</strong></p>\r\n\r\n<p>We use the information collected primarily to process the task for which you visited the website. Data collected in the UK is held in accordance with the Data Protection Act. All reasonable precautions are taken to prevent unauthorised access to this information. This safeguard may require you to provide additional forms of identity should you wish to obtain information about your account details.</p>\r\n\r\n<p><strong>Cookies</strong></p>\r\n\r\n<p>Your Internet browser has the in-built facility for storing small files - &quot;cookies&quot; - that hold information which allows a website to recognise your account. Our website takes advantage of this facility to enhance your experience. You have the ability to prevent your computer from accepting cookies but, if you do, certain functionality on the website may be impaired.</p>\r\n\r\n<p><strong>Disclosing Information</strong></p>\r\n\r\n<p>We do not disclose any personal information obtained about you from this website to third parties unless you permit us to do so by ticking the relevant boxes in registration or competition forms. We may also use the information to keep in contact with you and inform you of developments associated with us. You will be given the opportunity to remove yourself from any mailing list or similar device. If at any time in the future we should wish to disclose information collected on this website to any third party, it would only be with your knowledge and consent.&nbsp;</p>\r\n\r\n<p>We may from time to time provide information of a general nature to third parties - for example, the number of individuals visiting our website or completing a registration form, but we will not use any information that could identify those individuals.&nbsp;</p>\r\n\r\n<p>In addition Dummy may work with third parties for the purpose of delivering targeted behavioural advertising to the Dummy website. Through the use of cookies, anonymous information about your use of our websites and other websites will be used to provide more relevant adverts about goods and services of interest to you. For more information on online behavioural advertising and about how to turn this feature off, please visit youronlinechoices.com/opt-out.</p>\r\n\r\n<p><strong>Changes to this Policy</strong></p>\r\n\r\n<p>Any changes to our Privacy Policy will be placed here and will supersede this version of our policy. We will take reasonable steps to draw your attention to any changes in our policy. However, to be on the safe side, we suggest that you read this document each time you use the website to ensure that it still meets with your approval.</p>\r\n\r\n<p><strong>Contacting Us</strong></p>\r\n\r\n<p>If you have any questions about our Privacy Policy, or if you want to know what information we have collected about you, please email us at hd@dummy.com. You can also correct any factual errors in that information or require us to remove your details form any list under our control.</p>\r\n', 5, 'DESC', 0, 'category_name', 'DESC', 'pub-3940256099942544', 'true', 5, 5, 1, 5, 2, 1, 'true', 'true', 'true', 'true', 'true', 'true', 'true', '5', 5, 'true', 1, 'false', 1, 'true', 1, 'true', 1, 'true', 5, 'true', 0, 'false', 1, 'true', 1, 'true', 1, 'true', 5, 'true', 1, 'false', 1, 'true', 1, 'true', 'ca-app-pub-3940256099942544/1033173712', '4', 'true', 'admob', 'ca-app-pub-3940256099942544/6300978111', 'admob', 'IMG_16_9_APP_INSTALL#1554573358028971_1556332951186345', 'IMG_16_9_APP_INSTALL#1554573358028971_1556313221188318', 'false', 1, 'kindly you can update new version app', 'https://play.google.com/store/apps/developer?id=Viaan+Parmar', 'false', '<h2>There is some setup for help to delete account</h2><p><strong>Setup-1:</strong> Open Application</p><p><strong>Setup-2:</strong> Go to Setting Page</p><p><strong>Setup-3:</strong> Select Delete Account Option</p><p><strong>Setup-4:</strong> Fill the details and submit</p><p>After follow this above setup. Your account will be deleted</p><p><strong>OR</strong></p><p>Send email to below email address with your name, email and reason for deletation<br /><strong>Email Address:</strong> viaviwebtech@gmail.com</p>', 'true', 'ca-app-pub-3940256099942544/5224354917', 4, '<p><strong>How to earn points in&nbsp;status app?</strong></p>\r\n\r\n<p>- When user views like download status or upload status then they will get reward points.</p>\r\n\r\n<p>- Share your reference code to others and get reward points for every user registered with your reference code.</p>\r\n\r\n<p>- When user registers in application they will get reward points</p>\r\n\r\n<p><strong>Note:-</strong> When user will upload status and when admin approves user status, after that user will get reward points.</p>\r\n\r\n<p><strong>Video Upload Guidance :-</strong></p>\r\n\r\n<p>- Please check that uploading video file name is in english and there is no space in video file name.</p>\r\n\r\n<p>- Please follow the instruction of video file size, duration and format.</p>\r\n\r\n<p><strong>How to claim reward points and earn money?</strong></p>\r\n\r\n<p>- User need to acquire minimum points to claim money from reward points.</p>\r\n\r\n<p>- To claim money from reward points user have to fill the form and if there is any mistake in form you submitted, then you have to fill Contact Us form and admin will contact user ASAP</p>\r\n\r\n<p>- When admin approves user&#39;s claim for money after that user will get money</p>\r\n\r\n<p><strong>Note :-</strong></p>\r\n\r\n<p>- When you share&nbsp;status to any social media app, the length of the video will be depended on the app you are sharing.</p>\r\n\r\n<p>- Any misbehavior or any type of sexual and unnecessary video upload will make admin block your account.</p>\r\n\r\n<p>- Allow the read and write file permission then you will be able to use download, upload and share the status feature otherwise you will not able to use.</p>\r\n\r\n<p>- Share video works only on supported social media applications.</p>\r\n\r\n<p>- User can select payment method when filling form to claim money.&nbsp;</p>\r\n\r\n<p>- User can upload video only in mp4 format</p>\r\n\r\n<p>- Spamming report video feature may lead to account ban.</p>\r\n', 'false', 'true', 'watermark_1.png', 'true', 'false', 3, 'on', 'on', 'on', 'on', 'https://www.youtube.com/user/viaviwebtech', 'https://www.instagram.com/viaviwebtech/', 5, 5, 5, 5, 'true', 'true', 'true', 'true', 10, 60, 5, 5, 6, 'If you will delete your account, all your status, earned points, pending points data will get deleted permanently.');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_slider`
--

CREATE TABLE `tbl_slider` (
  `id` int(10) NOT NULL,
  `post_id` int(10) NOT NULL DEFAULT 0,
  `slider_type` varchar(30) DEFAULT NULL,
  `slider_title` varchar(150) DEFAULT NULL,
  `external_url` text DEFAULT NULL,
  `external_image` text DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_slider`
--

INSERT INTO `tbl_slider` (`id`, `post_id`, `slider_type`, `slider_title`, `external_url`, `external_image`, `status`) VALUES
(4, 22, 'video', '', '', '', 1),
(5, 22, 'image', '', '', '', 1),
(6, 0, 'external', 'Video Streaming Portal', 'https://codecanyon.net/item/video-streaming-portal-tv-shows-movies-sports-videos-streaming/25581885?s_rank=2', '98850_slider.png', 1),
(7, 7, 'quote', '', '', '', 1),
(9, 15, 'gif', '', '', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_smtp_settings`
--

CREATE TABLE `tbl_smtp_settings` (
  `id` int(5) NOT NULL,
  `smtp_type` varchar(20) NOT NULL DEFAULT 'server',
  `smtp_host` varchar(150) NOT NULL,
  `smtp_email` varchar(150) NOT NULL,
  `smtp_password` text NOT NULL,
  `smtp_secure` varchar(20) NOT NULL,
  `port_no` varchar(10) NOT NULL,
  `smtp_ghost` varchar(150) NOT NULL,
  `smtp_gemail` varchar(150) NOT NULL,
  `smtp_gpassword` text NOT NULL,
  `smtp_gsecure` varchar(20) NOT NULL,
  `gport_no` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_smtp_settings`
--

INSERT INTO `tbl_smtp_settings` (`id`, `smtp_type`, `smtp_host`, `smtp_email`, `smtp_password`, `smtp_secure`, `port_no`, `smtp_ghost`, `smtp_gemail`, `smtp_gpassword`, `smtp_gsecure`, `gport_no`) VALUES
(1, 'server', '', '', '', 'ssl', '465', '', '', '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_spinner`
--

CREATE TABLE `tbl_spinner` (
  `block_id` int(5) NOT NULL,
  `block_points` varchar(5) NOT NULL,
  `block_bg` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_spinner`
--

INSERT INTO `tbl_spinner` (`block_id`, `block_points`, `block_bg`) VALUES
(1, '0', 'BE4EBA'),
(2, '1', '0DABE9'),
(3, '2', 'E0E92D'),
(4, '3', 'E94C1E'),
(5, '4', 'E91E06'),
(6, '5', '0B8945'),
(7, '6', '86E93B'),
(9, '7', '7300E9'),
(10, '8', '29E9E5'),
(11, '9', 'E942B9'),
(12, '10', 'E99E49');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_suspend_account`
--

CREATE TABLE `tbl_suspend_account` (
  `id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `suspended_on` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `activated_on` int(11) DEFAULT NULL,
  `suspension_reason` text CHARACTER SET utf8mb4 NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id` int(11) NOT NULL,
  `user_code` varchar(255) NOT NULL,
  `user_type` varchar(255) NOT NULL,
  `device_id` text NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `user_image` varchar(500) DEFAULT NULL,
  `total_followers` int(11) NOT NULL DEFAULT 0,
  `total_following` int(11) NOT NULL DEFAULT 0,
  `user_youtube` varchar(500) DEFAULT NULL,
  `user_instagram` varchar(500) DEFAULT NULL,
  `confirm_code` varchar(255) DEFAULT NULL,
  `total_point` int(11) NOT NULL DEFAULT 0,
  `is_verified` int(1) NOT NULL DEFAULT 0,
  `player_id` text DEFAULT NULL,
  `is_duplicate` int(1) NOT NULL DEFAULT 0,
  `registration_on` varchar(255) NOT NULL DEFAULT '0',
  `auth_id` text NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `user_code`, `user_type`, `device_id`, `name`, `email`, `password`, `phone`, `user_image`, `total_followers`, `total_following`, `user_youtube`, `user_instagram`, `confirm_code`, `total_point`, `is_verified`, `player_id`, `is_duplicate`, `registration_on`, `auth_id`, `status`) VALUES
(0, 'adminsi5', 'Admin', '', 'Admin', 'admin@gmail.com', '123456', '', 'profile.png', 0, 0, 'https://www.youtube.com/', 'https://www.instagram.com/', NULL, 5, 1, 'b7889592-0dc6-4685-8925-5e3227f9ebc1', 1, '0', '0', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users_redeem`
--

CREATE TABLE `tbl_users_redeem` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_points` int(11) NOT NULL,
  `redeem_price` float(11,2) NOT NULL,
  `payment_mode` varchar(255) DEFAULT NULL,
  `bank_details` text NOT NULL,
  `request_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `cust_message` longtext DEFAULT NULL,
  `receipt_img` text DEFAULT NULL,
  `responce_date` datetime DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users_rewards_activity`
--

CREATE TABLE `tbl_users_rewards_activity` (
  `id` int(10) NOT NULL,
  `user_id` int(255) NOT NULL,
  `post_id` int(255) NOT NULL,
  `activity_type` varchar(255) NOT NULL,
  `points` int(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `redeem_id` int(11) NOT NULL DEFAULT 0,
  `status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_users_rewards_activity`
--

INSERT INTO `tbl_users_rewards_activity` (`id`, `user_id`, `post_id`, `activity_type`, `points`, `date`, `redeem_id`, `status`) VALUES
(2, 0, 43, 'Add Video', 5, '2020-11-19 09:01:13', 6, 0),
(3, 0, 31, 'Add Video', 5, '2020-11-19 09:01:13', 6, 0),
(4, 0, 30, 'Add Video', 5, '2020-11-19 09:01:13', 6, 0),
(5, 0, 29, 'Add Video', 5, '2020-11-19 09:01:13', 6, 0),
(6, 0, 28, 'Add Video', 5, '2020-11-19 09:01:13', 6, 0),
(7, 0, 27, 'Add Video', 5, '2020-11-19 09:01:13', 6, 0),
(8, 0, 26, 'Add Video', 5, '2020-11-19 09:01:13', 6, 0),
(9, 0, 25, 'Add Video', 5, '2020-11-19 09:01:13', 6, 0),
(10, 0, 24, 'Add Video', 5, '2020-11-19 09:01:13', 6, 0),
(11, 0, 23, 'Add Video', 5, '2020-11-19 09:01:13', 6, 0),
(12, 0, 22, 'Add Video', 5, '2020-11-19 09:01:13', 6, 0),
(13, 0, 21, 'Add Video', 5, '2020-11-19 09:01:13', 6, 0),
(14, 0, 30, 'Add Image', 5, '2020-11-19 09:02:33', 6, 0),
(15, 0, 29, 'Add Image', 5, '2020-11-19 09:02:33', 6, 0),
(16, 0, 28, 'Add Image', 5, '2020-11-19 09:02:33', 6, 0),
(17, 0, 27, 'Add Image', 5, '2020-11-19 09:02:33', 6, 0),
(18, 0, 26, 'Add Image', 5, '2020-11-19 09:02:33', 6, 0),
(19, 0, 25, 'Add Image', 5, '2020-11-19 09:02:33', 6, 0),
(20, 0, 24, 'Add Image', 5, '2020-11-19 09:02:33', 6, 0),
(21, 0, 23, 'Add Image', 5, '2020-11-19 09:02:33', 6, 0),
(22, 0, 22, 'Add Image', 5, '2020-11-19 09:02:33', 6, 0),
(23, 0, 21, 'Add Image', 5, '2020-11-19 09:02:33', 6, 0),
(24, 0, 20, 'Add Image', 5, '2020-11-19 09:02:33', 6, 0),
(25, 0, 19, 'Add Image', 5, '2020-11-19 09:02:34', 6, 0),
(26, 0, 16, 'Add GIF', 5, '2020-11-19 09:03:29', 6, 0),
(27, 0, 15, 'Add GIF', 5, '2020-11-19 09:03:29', 6, 0),
(28, 0, 5, 'Add GIF', 5, '2020-11-19 09:03:29', 6, 0),
(29, 0, 4, 'Add GIF', 5, '2020-11-19 09:03:29', 6, 0),
(30, 0, 3, 'Add GIF', 5, '2020-11-19 09:03:29', 6, 0),
(31, 0, 2, 'Add GIF', 5, '2020-11-19 09:03:29', 6, 0),
(32, 0, 21, 'Add Quote', 5, '2020-11-19 09:04:30', 6, 0),
(33, 0, 20, 'Add Quote', 5, '2020-11-19 09:04:30', 6, 0),
(34, 0, 19, 'Add Quote', 5, '2020-11-19 09:04:30', 6, 0),
(35, 0, 18, 'Add Quote', 5, '2020-11-19 09:04:30', 6, 0),
(36, 0, 17, 'Add Quote', 5, '2020-11-19 09:04:30', 6, 0),
(37, 0, 16, 'Add Quote', 5, '2020-11-19 09:04:30', 6, 0),
(38, 0, 15, 'Add Quote', 5, '2020-11-19 09:04:30', 6, 0),
(39, 0, 14, 'Add Quote', 5, '2020-11-19 09:04:31', 6, 0),
(40, 0, 13, 'Add Quote', 5, '2020-11-19 09:04:31', 6, 0),
(41, 0, 12, 'Add Quote', 5, '2020-11-19 09:04:31', 6, 0),
(42, 0, 11, 'Add Quote', 5, '2020-11-19 09:04:31', 6, 0),
(43, 0, 10, 'Add Quote', 5, '2020-11-19 09:04:31', 6, 0),
(44, 0, 9, 'Add Quote', 5, '2020-11-19 09:04:38', 6, 0),
(45, 0, 8, 'Add Quote', 5, '2020-11-19 09:04:38', 6, 0),
(46, 0, 7, 'Add Quote', 5, '2020-11-19 09:04:38', 6, 0),
(47, 0, 1, 'Add Quote', 5, '2020-11-19 09:04:38', 6, 0),
(48, 0, 18, 'Add Image', 5, '2020-11-19 09:04:48', 6, 0),
(49, 0, 1, 'Add Image', 5, '2020-11-19 09:04:48', 6, 0),
(52, 0, 22, 'Add Quote', 5, '2020-11-19 11:41:43', 6, 0),
(68, 0, 0, 'Add Video', 5, '2020-11-25 07:06:12', 6, 0),
(72, 0, 0, 'Add Quote', 5, '2020-11-26 07:04:00', 6, 0),
(73, 0, 25, 'Add Quote', 5, '2020-11-26 07:04:31', 6, 0),
(74, 0, 0, 'Add Quote', 5, '2020-11-26 08:27:50', 6, 0),
(75, 0, 26, 'Add Quote', 5, '2020-11-26 08:27:55', 6, 0),
(76, 0, 0, 'Add Video', 5, '2020-11-26 08:40:45', 6, 0),
(77, 0, 0, 'Add Image', 5, '2020-11-26 08:42:13', 6, 0),
(87, 0, 46, 'Add Video', 5, '2020-11-27 12:29:21', 6, 0),
(88, 0, 35, 'Add Image', 5, '2020-11-27 12:29:36', 6, 0),
(89, 0, 0, 'Add GIF', 5, '2020-11-30 04:21:54', 6, 0),
(90, 0, 0, 'Add Quote', 5, '2020-11-30 04:25:38', 6, 0),
(133, 0, 0, 'Add Image', 5, '2021-05-12 09:46:36', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_verify_user`
--

CREATE TABLE `tbl_verify_user` (
  `id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `full_name` varchar(150) CHARACTER SET utf8mb4 NOT NULL,
  `message` text CHARACTER SET utf8mb4 NOT NULL,
  `document` text CHARACTER SET utf8mb4 NOT NULL,
  `created_at` varchar(150) CHARACTER SET utf8mb4 NOT NULL,
  `verify_at` varchar(150) CHARACTER SET utf8mb4 NOT NULL DEFAULT '0',
  `reject_reason` text CHARACTER SET utf8mb4 DEFAULT NULL,
  `is_opened` int(11) NOT NULL DEFAULT 0,
  `status` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_video`
--

CREATE TABLE `tbl_video` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `cat_id` int(11) NOT NULL,
  `lang_ids` text NOT NULL,
  `video_type` varchar(255) NOT NULL,
  `video_title` varchar(255) NOT NULL,
  `video_url` text NOT NULL,
  `video_id` varchar(255) NOT NULL,
  `video_tags` text NOT NULL,
  `video_layout` varchar(255) NOT NULL DEFAULT 'Landscape',
  `video_thumbnail` text NOT NULL,
  `video_duration` varchar(255) DEFAULT NULL,
  `total_likes` int(11) NOT NULL DEFAULT 0,
  `totel_viewer` int(11) NOT NULL DEFAULT 0,
  `total_download` int(10) NOT NULL DEFAULT 0,
  `featured` int(1) DEFAULT 0,
  `created_at` varchar(60) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_video`
--

INSERT INTO `tbl_video` (`id`, `user_id`, `cat_id`, `lang_ids`, `video_type`, `video_title`, `video_url`, `video_id`, `video_tags`, `video_layout`, `video_thumbnail`, `video_duration`, `total_likes`, `totel_viewer`, `total_download`, `featured`, `created_at`, `status`) VALUES
(21, 0, 10, '5', 'server_url', 'मेरा भोला है भण्डारी करे नंदी की सवारी, Mera भोला Hai Bhandari Jatadhari Amli', 'http://www.viaviweb.in/envato/cc/demo_video/S_landscape3.mp4', '-', 'hindi,mahadev', 'Landscape', '48363_1.png', NULL, 0, 0, 0, 0, '0', 1),
(22, 0, 21, '5', 'server_url', 'गुरु रंधावा नए गाने', 'http://www.viaviweb.in/envato/cc/demo_video/S_landscape2.mp4', '-', 'love,songs', 'Landscape', '76209_2.png', NULL, 1, 0, 0, 1, '0', 1),
(23, 0, 11, '5', 'server_url', 'सर्वश्रेष्ठ हिट हिंदी गाने 2019', 'http://www.viaviweb.in/envato/cc/demo_video/S_portrait_3.mp4', '-', 'singer,song', 'Portrait', '52428_2.png', NULL, 0, 0, 0, 0, '0', 1),
(24, 0, 20, '5', 'server_url', 'हिंदी सॉन्ग ज्यूकबॉक्स 2019', 'http://www.viaviweb.in/envato/cc/demo_video/S_portrait_01.mp4', '-', 'songs,hindi', 'Portrait', '32884_3.png', NULL, 0, 0, 1, 0, '0', 1),
(25, 0, 14, '8', 'server_url', 'ਕਾਮੇਡੀ ਵੀਡੀਓ', 'http://www.viaviweb.in/envato/cc/demo_video/S_landscape3.mp4', '-', 'songs,friendship', 'Landscape', '80438_1.png', NULL, 0, 0, 0, 1, '0', 1),
(26, 0, 13, '8', 'server_url', 'ਮੇਰੀ ਭੋਲਾ ਭੰਡਾਰੀ ਕਾਰ ਨੰਦੀ ਰਾਈਡ,', 'http://www.viaviweb.in/envato/cc/demo_video/S_landscape2.mp4', '-', 'romance,love', 'Landscape', '70436_2.png', NULL, 0, 0, 0, 0, '0', 1),
(27, 0, 13, '8', 'server_url', 'ਤਾਮਿਲ ਸੰਗੀਤ ਵੀਡੀਓ', 'http://www.viaviweb.in/envato/cc/demo_video/S_portrait_3.mp4', '-', 'love,romance', 'Portrait', '26698_1.png', NULL, 0, 0, 0, 0, '0', 1),
(28, 0, 14, '8', 'server_url', 'ਸੈਲੀ ਵਾਕਰ (ਸਰਕਾਰੀ ਸੰਗੀਤ ਵੀਡੀਓ)', 'http://www.viaviweb.in/envato/cc/demo_video/S_portrait_01.mp4', '-', 'friend,panjabi', 'Portrait', '99900_2.png', NULL, 0, 0, 0, 0, '0', 1),
(29, 0, 12, '6,7', 'server_url', 'ગુજરાતી ગીતો 2019', 'http://www.viaviweb.in/envato/cc/demo_video/S_landscape3.mp4', '-', 'dance,video', 'Landscape', '99007_1.png', NULL, 0, 1, 0, 0, '0', 1),
(30, 0, 12, '6,7', 'server_url', 'રમૂજી વિડિઓ.', 'http://www.viaviweb.in/envato/cc/demo_video/S_landscape2.mp4', '-', 'dance,video', 'Landscape', '72227_2.png', NULL, 1, 1, 2, 0, '0', 1),
(31, 0, 8, '7', 'server_url', 'ક્યૂટ એનિમેશન વિડિઓ', 'http://www.viaviweb.in/envato/cc/demo_video/S_portrait_3.mp4', '-', 'dance,cute,animation', 'Portrait', '51866_1.png', NULL, 0, 1, 2, 0, '0', 1),
(43, 0, 8, '7', 'server_url', 'કૂકી સોંગ સાથે ડુમક્લાસ ડુક્કર', 'http://www.viaviweb.in/envato/cc/demo_video/S_portrait_01.mp4', '-', 'Dansing,funny', 'Portrait', '58274_video_thumb.png', NULL, 2, 7, 2, 0, '0', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_active_log`
--
ALTER TABLE `tbl_active_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `tbl_comments`
--
ALTER TABLE `tbl_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_contact_list`
--
ALTER TABLE `tbl_contact_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_contact_sub`
--
ALTER TABLE `tbl_contact_sub`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_deleted_users`
--
ALTER TABLE `tbl_deleted_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_favourite`
--
ALTER TABLE `tbl_favourite`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_follows`
--
ALTER TABLE `tbl_follows`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_img_status`
--
ALTER TABLE `tbl_img_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_language`
--
ALTER TABLE `tbl_language`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_like`
--
ALTER TABLE `tbl_like`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_payment_mode`
--
ALTER TABLE `tbl_payment_mode`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_quotes`
--
ALTER TABLE `tbl_quotes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_reports`
--
ALTER TABLE `tbl_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_settings`
--
ALTER TABLE `tbl_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_slider`
--
ALTER TABLE `tbl_slider`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_smtp_settings`
--
ALTER TABLE `tbl_smtp_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_spinner`
--
ALTER TABLE `tbl_spinner`
  ADD PRIMARY KEY (`block_id`);

--
-- Indexes for table `tbl_suspend_account`
--
ALTER TABLE `tbl_suspend_account`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_users_redeem`
--
ALTER TABLE `tbl_users_redeem`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_users_rewards_activity`
--
ALTER TABLE `tbl_users_rewards_activity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_verify_user`
--
ALTER TABLE `tbl_verify_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_video`
--
ALTER TABLE `tbl_video`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_active_log`
--
ALTER TABLE `tbl_active_log`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tbl_comments`
--
ALTER TABLE `tbl_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_contact_list`
--
ALTER TABLE `tbl_contact_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_contact_sub`
--
ALTER TABLE `tbl_contact_sub`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_deleted_users`
--
ALTER TABLE `tbl_deleted_users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_favourite`
--
ALTER TABLE `tbl_favourite`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_follows`
--
ALTER TABLE `tbl_follows`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_img_status`
--
ALTER TABLE `tbl_img_status`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `tbl_language`
--
ALTER TABLE `tbl_language`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_like`
--
ALTER TABLE `tbl_like`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_payment_mode`
--
ALTER TABLE `tbl_payment_mode`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_quotes`
--
ALTER TABLE `tbl_quotes`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `tbl_reports`
--
ALTER TABLE `tbl_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_settings`
--
ALTER TABLE `tbl_settings`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_slider`
--
ALTER TABLE `tbl_slider`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_smtp_settings`
--
ALTER TABLE `tbl_smtp_settings`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_spinner`
--
ALTER TABLE `tbl_spinner`
  MODIFY `block_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_suspend_account`
--
ALTER TABLE `tbl_suspend_account`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_users_redeem`
--
ALTER TABLE `tbl_users_redeem`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_users_rewards_activity`
--
ALTER TABLE `tbl_users_rewards_activity`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- AUTO_INCREMENT for table `tbl_verify_user`
--
ALTER TABLE `tbl_verify_user`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_video`
--
ALTER TABLE `tbl_video`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
