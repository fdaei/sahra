/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19-12.3.2-MariaDB, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: sahra
-- ------------------------------------------------------
-- Server version	12.3.2-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*M!100616 SET @OLD_NOTE_VERBOSITY=@@NOTE_VERBOSITY, NOTE_VERBOSITY=0 */;

--
-- Current Database: `sahra`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `sahra` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;

USE `sahra`;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
INSERT INTO `cache` VALUES
('nav.footer.ar','a:2:{i:0;a:6:{s:2:\"id\";i:7;s:5:\"label\";s:21:\"روابط سريعة\";s:3:\"url\";s:0:\"\";s:6:\"target\";s:5:\"_self\";s:5:\"isCta\";b:0;s:8:\"children\";a:6:{i:0;a:6:{s:2:\"id\";i:8;s:5:\"label\";s:16:\"الرئيسية\";s:3:\"url\";s:3:\"/ar\";s:6:\"target\";s:5:\"_self\";s:5:\"isCta\";b:0;s:8:\"children\";a:0:{}}i:1;a:6:{s:2:\"id\";i:9;s:5:\"label\";s:14:\"الخدمات\";s:3:\"url\";s:12:\"/ar/services\";s:6:\"target\";s:5:\"_self\";s:5:\"isCta\";b:0;s:8:\"children\";a:0:{}}i:2;a:6:{s:2:\"id\";i:10;s:5:\"label\";s:14:\"أعمالنا\";s:3:\"url\";s:8:\"/ar/work\";s:6:\"target\";s:5:\"_self\";s:5:\"isCta\";b:0;s:8:\"children\";a:0:{}}i:3;a:6:{s:2:\"id\";i:11;s:5:\"label\";s:6:\"رؤى\";s:3:\"url\";s:12:\"/ar/insights\";s:6:\"target\";s:5:\"_self\";s:5:\"isCta\";b:0;s:8:\"children\";a:0:{}}i:4;a:6:{s:2:\"id\";i:12;s:5:\"label\";s:11:\"من نحن\";s:3:\"url\";s:9:\"/ar/about\";s:6:\"target\";s:5:\"_self\";s:5:\"isCta\";b:0;s:8:\"children\";a:0:{}}i:5;a:6:{s:2:\"id\";i:13;s:5:\"label\";s:15:\"اتصل بنا\";s:3:\"url\";s:11:\"/ar/contact\";s:6:\"target\";s:5:\"_self\";s:5:\"isCta\";b:0;s:8:\"children\";a:0:{}}}}i:1;a:6:{s:2:\"id\";i:14;s:5:\"label\";s:25:\"وسائل التواصل\";s:3:\"url\";s:0:\"\";s:6:\"target\";s:5:\"_self\";s:5:\"isCta\";b:0;s:8:\"children\";a:5:{i:0;a:6:{s:2:\"id\";i:15;s:5:\"label\";s:9:\"Instagram\";s:3:\"url\";s:36:\"https://instagram.com/sahramarketing\";s:6:\"target\";s:6:\"_blank\";s:5:\"isCta\";b:0;s:8:\"children\";a:0:{}}i:1;a:6:{s:2:\"id\";i:16;s:5:\"label\";s:8:\"LinkedIn\";s:3:\"url\";s:43:\"https://linkedin.com/company/sahramarketing\";s:6:\"target\";s:6:\"_blank\";s:5:\"isCta\";b:0;s:8:\"children\";a:0:{}}i:2;a:6:{s:2:\"id\";i:17;s:5:\"label\";s:8:\"WhatsApp\";s:3:\"url\";s:25:\"https://wa.me/96777811213\";s:6:\"target\";s:6:\"_blank\";s:5:\"isCta\";b:0;s:8:\"children\";a:0:{}}i:3;a:6:{s:2:\"id\";i:18;s:5:\"label\";s:1:\"X\";s:3:\"url\";s:28:\"https://x.com/sahramarketing\";s:6:\"target\";s:6:\"_blank\";s:5:\"isCta\";b:0;s:8:\"children\";a:0:{}}i:4;a:6:{s:2:\"id\";i:19;s:5:\"label\";s:7:\"YouTube\";s:3:\"url\";s:35:\"https://youtube.com/@sahramarketing\";s:6:\"target\";s:6:\"_blank\";s:5:\"isCta\";b:0;s:8:\"children\";a:0:{}}}}}',1785929800),
('nav.footer.en','a:2:{i:0;a:6:{s:2:\"id\";i:7;s:5:\"label\";s:11:\"Quick Links\";s:3:\"url\";s:0:\"\";s:6:\"target\";s:5:\"_self\";s:5:\"isCta\";b:0;s:8:\"children\";a:6:{i:0;a:6:{s:2:\"id\";i:8;s:5:\"label\";s:4:\"Home\";s:3:\"url\";s:3:\"/en\";s:6:\"target\";s:5:\"_self\";s:5:\"isCta\";b:0;s:8:\"children\";a:0:{}}i:1;a:6:{s:2:\"id\";i:9;s:5:\"label\";s:8:\"Services\";s:3:\"url\";s:12:\"/en/services\";s:6:\"target\";s:5:\"_self\";s:5:\"isCta\";b:0;s:8:\"children\";a:0:{}}i:2;a:6:{s:2:\"id\";i:10;s:5:\"label\";s:4:\"Work\";s:3:\"url\";s:8:\"/en/work\";s:6:\"target\";s:5:\"_self\";s:5:\"isCta\";b:0;s:8:\"children\";a:0:{}}i:3;a:6:{s:2:\"id\";i:11;s:5:\"label\";s:7:\"Insight\";s:3:\"url\";s:12:\"/en/insights\";s:6:\"target\";s:5:\"_self\";s:5:\"isCta\";b:0;s:8:\"children\";a:0:{}}i:4;a:6:{s:2:\"id\";i:12;s:5:\"label\";s:5:\"About\";s:3:\"url\";s:9:\"/en/about\";s:6:\"target\";s:5:\"_self\";s:5:\"isCta\";b:0;s:8:\"children\";a:0:{}}i:5;a:6:{s:2:\"id\";i:13;s:5:\"label\";s:7:\"Contact\";s:3:\"url\";s:11:\"/en/contact\";s:6:\"target\";s:5:\"_self\";s:5:\"isCta\";b:0;s:8:\"children\";a:0:{}}}}i:1;a:6:{s:2:\"id\";i:14;s:5:\"label\";s:12:\"Social Links\";s:3:\"url\";s:0:\"\";s:6:\"target\";s:5:\"_self\";s:5:\"isCta\";b:0;s:8:\"children\";a:5:{i:0;a:6:{s:2:\"id\";i:15;s:5:\"label\";s:9:\"Instagram\";s:3:\"url\";s:36:\"https://instagram.com/sahramarketing\";s:6:\"target\";s:6:\"_blank\";s:5:\"isCta\";b:0;s:8:\"children\";a:0:{}}i:1;a:6:{s:2:\"id\";i:16;s:5:\"label\";s:8:\"LinkedIn\";s:3:\"url\";s:43:\"https://linkedin.com/company/sahramarketing\";s:6:\"target\";s:6:\"_blank\";s:5:\"isCta\";b:0;s:8:\"children\";a:0:{}}i:2;a:6:{s:2:\"id\";i:17;s:5:\"label\";s:8:\"WhatsApp\";s:3:\"url\";s:25:\"https://wa.me/96777811213\";s:6:\"target\";s:6:\"_blank\";s:5:\"isCta\";b:0;s:8:\"children\";a:0:{}}i:3;a:6:{s:2:\"id\";i:18;s:5:\"label\";s:1:\"X\";s:3:\"url\";s:28:\"https://x.com/sahramarketing\";s:6:\"target\";s:6:\"_blank\";s:5:\"isCta\";b:0;s:8:\"children\";a:0:{}}i:4;a:6:{s:2:\"id\";i:19;s:5:\"label\";s:7:\"YouTube\";s:3:\"url\";s:35:\"https://youtube.com/@sahramarketing\";s:6:\"target\";s:6:\"_blank\";s:5:\"isCta\";b:0;s:8:\"children\";a:0:{}}}}}',1786038597),
('nav.header.ar','a:6:{i:0;a:6:{s:2:\"id\";i:1;s:5:\"label\";s:16:\"الرئيسية\";s:3:\"url\";s:3:\"/ar\";s:6:\"target\";s:5:\"_self\";s:5:\"isCta\";b:0;s:8:\"children\";a:0:{}}i:1;a:6:{s:2:\"id\";i:2;s:5:\"label\";s:14:\"أعمالنا\";s:3:\"url\";s:8:\"/ar/work\";s:6:\"target\";s:5:\"_self\";s:5:\"isCta\";b:0;s:8:\"children\";a:0:{}}i:2;a:6:{s:2:\"id\";i:3;s:5:\"label\";s:14:\"الخدمات\";s:3:\"url\";s:12:\"/ar/services\";s:6:\"target\";s:5:\"_self\";s:5:\"isCta\";b:0;s:8:\"children\";a:0:{}}i:3;a:6:{s:2:\"id\";i:4;s:5:\"label\";s:6:\"رؤى\";s:3:\"url\";s:12:\"/ar/insights\";s:6:\"target\";s:5:\"_self\";s:5:\"isCta\";b:0;s:8:\"children\";a:0:{}}i:4;a:6:{s:2:\"id\";i:5;s:5:\"label\";s:11:\"من نحن\";s:3:\"url\";s:9:\"/ar/about\";s:6:\"target\";s:5:\"_self\";s:5:\"isCta\";b:0;s:8:\"children\";a:0:{}}i:5;a:6:{s:2:\"id\";i:6;s:5:\"label\";s:12:\"لنتحدث\";s:3:\"url\";s:11:\"/ar/contact\";s:6:\"target\";s:5:\"_self\";s:5:\"isCta\";b:1;s:8:\"children\";a:0:{}}}',1785929800),
('nav.header.en','a:6:{i:0;a:6:{s:2:\"id\";i:1;s:5:\"label\";s:4:\"Home\";s:3:\"url\";s:3:\"/en\";s:6:\"target\";s:5:\"_self\";s:5:\"isCta\";b:0;s:8:\"children\";a:0:{}}i:1;a:6:{s:2:\"id\";i:2;s:5:\"label\";s:4:\"Work\";s:3:\"url\";s:8:\"/en/work\";s:6:\"target\";s:5:\"_self\";s:5:\"isCta\";b:0;s:8:\"children\";a:0:{}}i:2;a:6:{s:2:\"id\";i:3;s:5:\"label\";s:7:\"Service\";s:3:\"url\";s:12:\"/en/services\";s:6:\"target\";s:5:\"_self\";s:5:\"isCta\";b:0;s:8:\"children\";a:0:{}}i:3;a:6:{s:2:\"id\";i:4;s:5:\"label\";s:7:\"Insight\";s:3:\"url\";s:12:\"/en/insights\";s:6:\"target\";s:5:\"_self\";s:5:\"isCta\";b:0;s:8:\"children\";a:0:{}}i:4;a:6:{s:2:\"id\";i:5;s:5:\"label\";s:5:\"About\";s:3:\"url\";s:9:\"/en/about\";s:6:\"target\";s:5:\"_self\";s:5:\"isCta\";b:0;s:8:\"children\";a:0:{}}i:5;a:6:{s:2:\"id\";i:6;s:5:\"label\";s:10:\"Let\'s Talk\";s:3:\"url\";s:11:\"/en/contact\";s:6:\"target\";s:5:\"_self\";s:5:\"isCta\";b:1;s:8:\"children\";a:0:{}}}',1786038597),
('site.settings','a:12:{s:9:\"site_name\";a:3:{s:2:\"en\";s:5:\"Sahra\";s:2:\"fa\";s:8:\"صحرا\";s:2:\"ar\";s:10:\"صحراء\";}s:7:\"tagline\";a:3:{s:2:\"en\";s:15:\"See the Horizon\";s:2:\"fa\";s:20:\"افق را ببین\";s:2:\"ar\";s:26:\"انظر إلى الأفق\";}s:18:\"footer_description\";a:3:{s:2:\"en\";s:67:\"We help brands move from scattered content to structured direction.\";s:2:\"fa\";s:125:\"ما به برندها کمک می‌کنیم از محتوای پراکنده به مسیری ساختارمند برسند.\";s:2:\"ar\";s:131:\"نساعد العلامات التجارية على الانتقال من المحتوى المبعثر إلى اتجاه منظم.\";}s:16:\"contact_whatsapp\";a:1:{s:5:\"value\";s:13:\"+96 7781 1213\";}s:13:\"contact_phone\";a:1:{s:5:\"value\";s:13:\"+96 7781 1213\";}s:13:\"contact_email\";a:1:{s:5:\"value\";s:24:\"Sahramarketing@gmail.com\";}s:16:\"contact_location\";a:3:{s:2:\"en\";s:12:\"Muscat, Oman\";s:2:\"fa\";s:19:\"مسقط، عمان\";s:2:\"ar\";s:21:\"مسقط، عُمان\";}s:20:\"contact_working_with\";a:3:{s:2:\"en\";s:25:\"Brands in Oman and Beyond\";s:2:\"fa\";s:54:\"برندهایی در عمان و فراتر از آن\";s:2:\"ar\";s:56:\"علامات تجارية في عُمان وخارجها\";}s:17:\"seo_default_title\";a:3:{s:2:\"en\";s:44:\"Sahra — Digital Marketing Agency in Muscat\";s:2:\"fa\";s:71:\"صحرا — آژانس بازاریابی دیجیتال در مسقط\";s:2:\"ar\";s:59:\"صحراء — وكالة تسويق رقمي في مسقط\";}s:23:\"seo_default_description\";a:3:{s:2:\"en\";s:128:\"Sahra helps businesses in Oman create stronger brand presence through strategy, content, branding, video, and digital marketing.\";s:2:\"fa\";s:221:\"صحرا به کسب‌وکارها در عمان کمک می‌کند تا از طریق استراتژی، محتوا، برندینگ و بازاریابی دیجیتال حضور برند قوی‌تری بسازند.\";s:2:\"ar\";s:222:\"تساعد صحراء الشركات في عُمان على بناء حضور أقوى لعلامتها التجارية من خلال الاستراتيجية والمحتوى والهوية والتسويق الرقمي.\";}s:17:\"seo_default_image\";a:1:{s:5:\"value\";N;}s:21:\"seo_organization_name\";a:3:{s:2:\"en\";s:5:\"Sahra\";s:2:\"fa\";s:8:\"صحرا\";s:2:\"ar\";s:10:\"صحراء\";}}',1786038597),
('site.social_links','a:5:{i:0;a:4:{s:8:\"platform\";s:9:\"instagram\";s:5:\"label\";s:9:\"Instagram\";s:3:\"url\";s:36:\"https://instagram.com/sahramarketing\";s:4:\"icon\";s:9:\"instagram\";}i:1;a:4:{s:8:\"platform\";s:8:\"linkedin\";s:5:\"label\";s:8:\"LinkedIn\";s:3:\"url\";s:43:\"https://linkedin.com/company/sahramarketing\";s:4:\"icon\";s:8:\"linkedin\";}i:2;a:4:{s:8:\"platform\";s:8:\"whatsapp\";s:5:\"label\";s:8:\"WhatsApp\";s:3:\"url\";s:25:\"https://wa.me/96777811213\";s:4:\"icon\";s:14:\"message-circle\";}i:3;a:4:{s:8:\"platform\";s:1:\"x\";s:5:\"label\";s:1:\"X\";s:3:\"url\";s:28:\"https://x.com/sahramarketing\";s:4:\"icon\";s:7:\"twitter\";}i:4;a:4:{s:8:\"platform\";s:7:\"youtube\";s:5:\"label\";s:7:\"YouTube\";s:3:\"url\";s:35:\"https://youtube.com/@sahramarketing\";s:4:\"icon\";s:7:\"youtube\";}}',1786038597),
('spatie.permission.cache','a:3:{s:5:\"alias\";a:4:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:136:{i:0;a:4:{s:1:\"a\";i:1;s:1:\"b\";s:13:\"view_any_page\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:1;a:4:{s:1:\"a\";i:2;s:1:\"b\";s:9:\"view_page\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:2;a:4:{s:1:\"a\";i:3;s:1:\"b\";s:11:\"create_page\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:3;a:4:{s:1:\"a\";i:4;s:1:\"b\";s:11:\"update_page\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:4;a:4:{s:1:\"a\";i:5;s:1:\"b\";s:15:\"update_any_page\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:5;a:4:{s:1:\"a\";i:6;s:1:\"b\";s:11:\"delete_page\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:6;a:4:{s:1:\"a\";i:7;s:1:\"b\";s:15:\"delete_any_page\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:7;a:4:{s:1:\"a\";i:8;s:1:\"b\";s:12:\"restore_page\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:8;a:4:{s:1:\"a\";i:9;s:1:\"b\";s:16:\"view_any_project\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:9;a:4:{s:1:\"a\";i:10;s:1:\"b\";s:12:\"view_project\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:10;a:4:{s:1:\"a\";i:11;s:1:\"b\";s:14:\"create_project\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:11;a:4:{s:1:\"a\";i:12;s:1:\"b\";s:14:\"update_project\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:12;a:4:{s:1:\"a\";i:13;s:1:\"b\";s:18:\"update_any_project\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:13;a:4:{s:1:\"a\";i:14;s:1:\"b\";s:14:\"delete_project\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:14;a:4:{s:1:\"a\";i:15;s:1:\"b\";s:18:\"delete_any_project\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:15;a:4:{s:1:\"a\";i:16;s:1:\"b\";s:15:\"restore_project\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:16;a:4:{s:1:\"a\";i:17;s:1:\"b\";s:16:\"view_any_service\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:17;a:4:{s:1:\"a\";i:18;s:1:\"b\";s:12:\"view_service\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:18;a:4:{s:1:\"a\";i:19;s:1:\"b\";s:14:\"create_service\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:19;a:4:{s:1:\"a\";i:20;s:1:\"b\";s:14:\"update_service\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:20;a:4:{s:1:\"a\";i:21;s:1:\"b\";s:18:\"update_any_service\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:21;a:4:{s:1:\"a\";i:22;s:1:\"b\";s:14:\"delete_service\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:22;a:4:{s:1:\"a\";i:23;s:1:\"b\";s:18:\"delete_any_service\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:23;a:4:{s:1:\"a\";i:24;s:1:\"b\";s:15:\"restore_service\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:24;a:4:{s:1:\"a\";i:25;s:1:\"b\";s:13:\"view_any_post\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:25;a:4:{s:1:\"a\";i:26;s:1:\"b\";s:9:\"view_post\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:26;a:4:{s:1:\"a\";i:27;s:1:\"b\";s:11:\"create_post\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:27;a:4:{s:1:\"a\";i:28;s:1:\"b\";s:11:\"update_post\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:28;a:4:{s:1:\"a\";i:29;s:1:\"b\";s:15:\"update_any_post\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:29;a:4:{s:1:\"a\";i:30;s:1:\"b\";s:11:\"delete_post\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:30;a:4:{s:1:\"a\";i:31;s:1:\"b\";s:15:\"delete_any_post\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:31;a:4:{s:1:\"a\";i:32;s:1:\"b\";s:12:\"restore_post\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:32;a:4:{s:1:\"a\";i:33;s:1:\"b\";s:22:\"view_any_post_category\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:33;a:4:{s:1:\"a\";i:34;s:1:\"b\";s:18:\"view_post_category\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:34;a:4:{s:1:\"a\";i:35;s:1:\"b\";s:20:\"create_post_category\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:35;a:4:{s:1:\"a\";i:36;s:1:\"b\";s:20:\"update_post_category\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:36;a:4:{s:1:\"a\";i:37;s:1:\"b\";s:24:\"update_any_post_category\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:37;a:4:{s:1:\"a\";i:38;s:1:\"b\";s:20:\"delete_post_category\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:38;a:4:{s:1:\"a\";i:39;s:1:\"b\";s:24:\"delete_any_post_category\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:39;a:4:{s:1:\"a\";i:40;s:1:\"b\";s:21:\"restore_post_category\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:40;a:4:{s:1:\"a\";i:41;s:1:\"b\";s:17:\"view_any_post_tag\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:41;a:4:{s:1:\"a\";i:42;s:1:\"b\";s:13:\"view_post_tag\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:42;a:4:{s:1:\"a\";i:43;s:1:\"b\";s:15:\"create_post_tag\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:43;a:4:{s:1:\"a\";i:44;s:1:\"b\";s:15:\"update_post_tag\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:44;a:4:{s:1:\"a\";i:45;s:1:\"b\";s:19:\"update_any_post_tag\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:45;a:4:{s:1:\"a\";i:46;s:1:\"b\";s:15:\"delete_post_tag\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:46;a:4:{s:1:\"a\";i:47;s:1:\"b\";s:19:\"delete_any_post_tag\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:47;a:4:{s:1:\"a\";i:48;s:1:\"b\";s:16:\"restore_post_tag\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:48;a:4:{s:1:\"a\";i:49;s:1:\"b\";s:17:\"view_any_industry\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:49;a:4:{s:1:\"a\";i:50;s:1:\"b\";s:13:\"view_industry\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:50;a:4:{s:1:\"a\";i:51;s:1:\"b\";s:15:\"create_industry\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:51;a:4:{s:1:\"a\";i:52;s:1:\"b\";s:15:\"update_industry\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:52;a:4:{s:1:\"a\";i:53;s:1:\"b\";s:19:\"update_any_industry\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:53;a:4:{s:1:\"a\";i:54;s:1:\"b\";s:15:\"delete_industry\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:54;a:4:{s:1:\"a\";i:55;s:1:\"b\";s:19:\"delete_any_industry\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:55;a:4:{s:1:\"a\";i:56;s:1:\"b\";s:16:\"restore_industry\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:56;a:4:{s:1:\"a\";i:57;s:1:\"b\";s:20:\"view_any_team_member\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:57;a:4:{s:1:\"a\";i:58;s:1:\"b\";s:16:\"view_team_member\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:58;a:4:{s:1:\"a\";i:59;s:1:\"b\";s:18:\"create_team_member\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:59;a:4:{s:1:\"a\";i:60;s:1:\"b\";s:18:\"update_team_member\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:60;a:4:{s:1:\"a\";i:61;s:1:\"b\";s:22:\"update_any_team_member\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:61;a:4:{s:1:\"a\";i:62;s:1:\"b\";s:18:\"delete_team_member\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:62;a:4:{s:1:\"a\";i:63;s:1:\"b\";s:22:\"delete_any_team_member\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:63;a:4:{s:1:\"a\";i:64;s:1:\"b\";s:19:\"restore_team_member\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:64;a:4:{s:1:\"a\";i:65;s:1:\"b\";s:20:\"view_any_testimonial\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:65;a:4:{s:1:\"a\";i:66;s:1:\"b\";s:16:\"view_testimonial\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:66;a:4:{s:1:\"a\";i:67;s:1:\"b\";s:18:\"create_testimonial\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:67;a:4:{s:1:\"a\";i:68;s:1:\"b\";s:18:\"update_testimonial\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:68;a:4:{s:1:\"a\";i:69;s:1:\"b\";s:22:\"update_any_testimonial\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:69;a:4:{s:1:\"a\";i:70;s:1:\"b\";s:18:\"delete_testimonial\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:70;a:4:{s:1:\"a\";i:71;s:1:\"b\";s:22:\"delete_any_testimonial\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:71;a:4:{s:1:\"a\";i:72;s:1:\"b\";s:19:\"restore_testimonial\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:72;a:4:{s:1:\"a\";i:73;s:1:\"b\";s:12:\"view_any_faq\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:73;a:4:{s:1:\"a\";i:74;s:1:\"b\";s:8:\"view_faq\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:74;a:4:{s:1:\"a\";i:75;s:1:\"b\";s:10:\"create_faq\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:75;a:4:{s:1:\"a\";i:76;s:1:\"b\";s:10:\"update_faq\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:76;a:4:{s:1:\"a\";i:77;s:1:\"b\";s:14:\"update_any_faq\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:77;a:4:{s:1:\"a\";i:78;s:1:\"b\";s:10:\"delete_faq\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:78;a:4:{s:1:\"a\";i:79;s:1:\"b\";s:14:\"delete_any_faq\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:79;a:4:{s:1:\"a\";i:80;s:1:\"b\";s:11:\"restore_faq\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:80;a:4:{s:1:\"a\";i:81;s:1:\"b\";s:15:\"view_any_client\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:81;a:4:{s:1:\"a\";i:82;s:1:\"b\";s:11:\"view_client\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:82;a:4:{s:1:\"a\";i:83;s:1:\"b\";s:13:\"create_client\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:83;a:4:{s:1:\"a\";i:84;s:1:\"b\";s:13:\"update_client\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:84;a:4:{s:1:\"a\";i:85;s:1:\"b\";s:17:\"update_any_client\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:85;a:4:{s:1:\"a\";i:86;s:1:\"b\";s:13:\"delete_client\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:86;a:4:{s:1:\"a\";i:87;s:1:\"b\";s:17:\"delete_any_client\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:87;a:4:{s:1:\"a\";i:88;s:1:\"b\";s:14:\"restore_client\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:88;a:4:{s:1:\"a\";i:89;s:1:\"b\";s:27:\"view_any_contact_submission\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:89;a:4:{s:1:\"a\";i:90;s:1:\"b\";s:23:\"view_contact_submission\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:90;a:4:{s:1:\"a\";i:91;s:1:\"b\";s:25:\"create_contact_submission\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:91;a:4:{s:1:\"a\";i:92;s:1:\"b\";s:25:\"update_contact_submission\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:92;a:4:{s:1:\"a\";i:93;s:1:\"b\";s:29:\"update_any_contact_submission\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:93;a:4:{s:1:\"a\";i:94;s:1:\"b\";s:25:\"delete_contact_submission\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:94;a:4:{s:1:\"a\";i:95;s:1:\"b\";s:29:\"delete_any_contact_submission\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:95;a:4:{s:1:\"a\";i:96;s:1:\"b\";s:26:\"restore_contact_submission\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:96;a:4:{s:1:\"a\";i:97;s:1:\"b\";s:13:\"view_any_user\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:97;a:4:{s:1:\"a\";i:98;s:1:\"b\";s:9:\"view_user\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:98;a:4:{s:1:\"a\";i:99;s:1:\"b\";s:11:\"create_user\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:99;a:4:{s:1:\"a\";i:100;s:1:\"b\";s:11:\"update_user\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:100;a:4:{s:1:\"a\";i:101;s:1:\"b\";s:15:\"update_any_user\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:101;a:4:{s:1:\"a\";i:102;s:1:\"b\";s:11:\"delete_user\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:102;a:4:{s:1:\"a\";i:103;s:1:\"b\";s:15:\"delete_any_user\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:103;a:4:{s:1:\"a\";i:104;s:1:\"b\";s:12:\"restore_user\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:104;a:4:{s:1:\"a\";i:105;s:1:\"b\";s:13:\"view_any_menu\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:105;a:4:{s:1:\"a\";i:106;s:1:\"b\";s:9:\"view_menu\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:106;a:4:{s:1:\"a\";i:107;s:1:\"b\";s:11:\"create_menu\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:107;a:4:{s:1:\"a\";i:108;s:1:\"b\";s:11:\"update_menu\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:108;a:4:{s:1:\"a\";i:109;s:1:\"b\";s:15:\"update_any_menu\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:109;a:4:{s:1:\"a\";i:110;s:1:\"b\";s:11:\"delete_menu\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:110;a:4:{s:1:\"a\";i:111;s:1:\"b\";s:15:\"delete_any_menu\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:111;a:4:{s:1:\"a\";i:112;s:1:\"b\";s:12:\"restore_menu\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:112;a:4:{s:1:\"a\";i:113;s:1:\"b\";s:20:\"view_any_social_link\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:113;a:4:{s:1:\"a\";i:114;s:1:\"b\";s:16:\"view_social_link\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:114;a:4:{s:1:\"a\";i:115;s:1:\"b\";s:18:\"create_social_link\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:115;a:4:{s:1:\"a\";i:116;s:1:\"b\";s:18:\"update_social_link\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:116;a:4:{s:1:\"a\";i:117;s:1:\"b\";s:22:\"update_any_social_link\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:117;a:4:{s:1:\"a\";i:118;s:1:\"b\";s:18:\"delete_social_link\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:118;a:4:{s:1:\"a\";i:119;s:1:\"b\";s:22:\"delete_any_social_link\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:119;a:4:{s:1:\"a\";i:120;s:1:\"b\";s:19:\"restore_social_link\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:120;a:4:{s:1:\"a\";i:121;s:1:\"b\";s:32:\"view_any_newsletter_subscription\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:121;a:4:{s:1:\"a\";i:122;s:1:\"b\";s:28:\"view_newsletter_subscription\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:122;a:4:{s:1:\"a\";i:123;s:1:\"b\";s:30:\"create_newsletter_subscription\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:123;a:4:{s:1:\"a\";i:124;s:1:\"b\";s:30:\"update_newsletter_subscription\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:124;a:4:{s:1:\"a\";i:125;s:1:\"b\";s:34:\"update_any_newsletter_subscription\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:125;a:4:{s:1:\"a\";i:126;s:1:\"b\";s:30:\"delete_newsletter_subscription\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:126;a:4:{s:1:\"a\";i:127;s:1:\"b\";s:34:\"delete_any_newsletter_subscription\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:127;a:4:{s:1:\"a\";i:128;s:1:\"b\";s:31:\"restore_newsletter_subscription\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:128;a:4:{s:1:\"a\";i:129;s:1:\"b\";s:17:\"view_any_redirect\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:129;a:4:{s:1:\"a\";i:130;s:1:\"b\";s:13:\"view_redirect\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:130;a:4:{s:1:\"a\";i:131;s:1:\"b\";s:15:\"create_redirect\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:131;a:4:{s:1:\"a\";i:132;s:1:\"b\";s:15:\"update_redirect\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:132;a:4:{s:1:\"a\";i:133;s:1:\"b\";s:19:\"update_any_redirect\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:133;a:4:{s:1:\"a\";i:134;s:1:\"b\";s:15:\"delete_redirect\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:134;a:4:{s:1:\"a\";i:135;s:1:\"b\";s:19:\"delete_any_redirect\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:135;a:4:{s:1:\"a\";i:136;s:1:\"b\";s:16:\"restore_redirect\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}}s:5:\"roles\";a:2:{i:0;a:3:{s:1:\"a\";i:1;s:1:\"b\";s:5:\"admin\";s:1:\"c\";s:3:\"web\";}i:1;a:3:{s:1:\"a\";i:2;s:1:\"b\";s:6:\"editor\";s:1:\"c\";s:3:\"web\";}}}',1785536077);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `client_translations`
--

DROP TABLE IF EXISTS `client_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `client_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` bigint(20) unsigned NOT NULL,
  `locale` varchar(5) NOT NULL,
  `name` varchar(150) NOT NULL,
  `logo_alt` varchar(300) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `client_translations_unique` (`client_id`,`locale`),
  CONSTRAINT `client_translations_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `client_translations`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `client_translations` WRITE;
/*!40000 ALTER TABLE `client_translations` DISABLE KEYS */;
INSERT INTO `client_translations` VALUES
(1,1,'en','Pars Clinic','Pars Clinic logo','2026-07-29 05:42:03','2026-07-29 05:42:03'),
(2,1,'fa','کلینیک پارس','لوگوی کلینیک پارس','2026-07-29 05:42:03','2026-07-29 05:42:03'),
(3,1,'ar','عيادة بارس','شعار عيادة بارس','2026-07-29 05:42:03','2026-07-29 05:42:03'),
(4,2,'en','allDigitall.ir','allDigitall.ir logo','2026-07-29 05:42:03','2026-07-29 05:42:03'),
(5,2,'fa','allDigitall.ir','لوگوی allDigitall.ir','2026-07-29 05:42:03','2026-07-29 05:42:03'),
(6,2,'ar','allDigitall.ir','شعار allDigitall.ir','2026-07-29 05:42:03','2026-07-29 05:42:03'),
(7,3,'en','Baghche','Baghche logo','2026-07-29 05:42:03','2026-07-29 05:42:03'),
(8,3,'fa','باغچه','لوگوی باغچه','2026-07-29 05:42:03','2026-07-29 05:42:03'),
(9,3,'ar','باغتشه','شعار باغتشه','2026-07-29 05:42:03','2026-07-29 05:42:03'),
(10,4,'en','Noora','Noora logo','2026-07-29 05:42:03','2026-07-29 05:42:03'),
(11,4,'fa','نورا','لوگوی نورا','2026-07-29 05:42:03','2026-07-29 05:42:03'),
(12,4,'ar','نورا','شعار نورا','2026-07-29 05:42:03','2026-07-29 05:42:03'),
(13,5,'en','Vanak','Vanak logo','2026-07-29 05:42:03','2026-07-29 05:42:03'),
(14,5,'fa','ونک','لوگوی ونک','2026-07-29 05:42:03','2026-07-29 05:42:03'),
(15,5,'ar','ونك','شعار ونك','2026-07-29 05:42:03','2026-07-29 05:42:03'),
(16,6,'en','Tavakoli','Tavakoli logo','2026-07-29 05:42:03','2026-07-29 05:42:03'),
(17,6,'fa','توکلی','لوگوی توکلی','2026-07-29 05:42:03','2026-07-29 05:42:03'),
(18,6,'ar','توكلي','شعار توكلي','2026-07-29 05:42:03','2026-07-29 05:42:03');
/*!40000 ALTER TABLE `client_translations` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `clients`
--

DROP TABLE IF EXISTS `clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `clients` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `logo_path` varchar(500) NOT NULL,
  `website_url` varchar(500) DEFAULT NULL,
  `sort_order` smallint(5) unsigned NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `clients_is_active_sort_order_index` (`is_active`,`sort_order`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clients`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `clients` WRITE;
/*!40000 ALTER TABLE `clients` DISABLE KEYS */;
INSERT INTO `clients` VALUES
(1,'clients/pars.svg',NULL,0,1,'2026-07-29 05:42:03','2026-07-29 05:42:03'),
(2,'clients/all-digitall.svg',NULL,1,1,'2026-07-29 05:42:03','2026-07-29 05:42:03'),
(3,'clients/baghche.svg',NULL,2,1,'2026-07-29 05:42:03','2026-07-29 05:42:03'),
(4,'clients/noora.svg',NULL,3,1,'2026-07-29 05:42:03','2026-07-29 05:42:03'),
(5,'clients/vanak.svg',NULL,4,1,'2026-07-29 05:42:03','2026-07-29 05:42:03'),
(6,'clients/tavakoli.svg',NULL,5,1,'2026-07-29 05:42:03','2026-07-29 05:42:03');
/*!40000 ALTER TABLE `clients` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `contact_submissions`
--

DROP TABLE IF EXISTS `contact_submissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `contact_submissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `brand_name` varchar(150) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `service_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'array<int>' CHECK (json_valid(`service_ids`)),
  `service_titles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'array<string> snapshot' CHECK (json_valid(`service_titles`)),
  `status` varchar(20) NOT NULL DEFAULT 'new',
  `admin_notes` text DEFAULT NULL,
  `locale` varchar(5) NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(500) DEFAULT NULL,
  `referrer` varchar(500) DEFAULT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `contact_submissions_triage_index` (`status`,`created_at`),
  KEY `contact_submissions_created_at_index` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact_submissions`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `contact_submissions` WRITE;
/*!40000 ALTER TABLE `contact_submissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `contact_submissions` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `faq_translations`
--

DROP TABLE IF EXISTS `faq_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `faq_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `faq_id` bigint(20) unsigned NOT NULL,
  `locale` varchar(5) NOT NULL,
  `question` varchar(300) NOT NULL,
  `answer` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `faq_translations_unique` (`faq_id`,`locale`),
  KEY `faq_translations_locale_index` (`locale`),
  CONSTRAINT `faq_translations_faq_id_foreign` FOREIGN KEY (`faq_id`) REFERENCES `faqs` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faq_translations`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `faq_translations` WRITE;
/*!40000 ALTER TABLE `faq_translations` DISABLE KEYS */;
INSERT INTO `faq_translations` VALUES
(1,1,'en','How long does a branding project take?','Most branding projects run six to eight weeks from discovery to final handover, depending on scope and how quickly feedback comes back.','2026-07-29 05:42:03','2026-07-29 05:42:03'),
(2,1,'fa','یک پروژه برندینگ چقدر طول می‌کشد؟','بیشتر پروژه‌های برندینگ از مرحله کشف تا تحویل نهایی شش تا هشت هفته زمان می‌برد؛ بسته به دامنه کار و سرعت دریافت بازخورد.','2026-07-29 05:42:03','2026-07-29 05:42:03'),
(3,1,'ar','كم يستغرق مشروع الهوية التجارية؟','تستغرق معظم مشاريع الهوية من ستة إلى ثمانية أسابيع من الاكتشاف حتى التسليم النهائي، حسب النطاق وسرعة وصول الملاحظات.','2026-07-29 05:42:03','2026-07-29 05:42:03'),
(4,2,'en','Do you work with brands outside Oman?','Yes. We are based in Muscat and work with brands across the region and further afield, running projects remotely with scheduled check-ins.','2026-07-29 05:42:03','2026-07-29 05:42:03'),
(5,2,'fa','با برندهای خارج از عمان هم کار می‌کنید؟','بله. ما در مسقط مستقر هستیم و با برندهایی در سراسر منطقه و فراتر از آن کار می‌کنیم؛ پروژه‌ها از راه دور با جلسات منظم پیش می‌روند.','2026-07-29 05:42:03','2026-07-29 05:42:03'),
(6,2,'ar','هل تعملون مع علامات خارج عُمان؟','نعم. مقرنا مسقط ونعمل مع علامات في المنطقة وخارجها، وندير المشاريع عن بُعد بجلسات متابعة مجدولة.','2026-07-29 05:42:03','2026-07-29 05:42:03'),
(7,3,'en','Can you work with our existing brand guidelines?','Absolutely. If you already have a brand book we build within it, and flag anything that is holding the brand back rather than replacing it wholesale.','2026-07-29 05:42:03','2026-07-29 05:42:03'),
(8,3,'fa','می‌توانید با دستورالعمل برند فعلی ما کار کنید؟','قطعاً. اگر کتاب برند دارید، درون همان چارچوب کار می‌کنیم و به‌جای جایگزینی کامل، مواردی را که مانع رشد برند است مطرح می‌کنیم.','2026-07-29 05:42:03','2026-07-29 05:42:03'),
(9,3,'ar','هل يمكنكم العمل ضمن دليل علامتنا الحالي؟','بالتأكيد. إن كان لديكم دليل علامة نعمل ضمنه، ونشير إلى ما يعيق العلامة بدل استبداله بالكامل.','2026-07-29 05:42:03','2026-07-29 05:42:03'),
(10,4,'en','What do you need from us to start?','A short conversation about your goals, your audience, and what has and has not worked so far. We handle the rest of the discovery.','2026-07-29 05:42:03','2026-07-29 05:42:03'),
(11,4,'fa','برای شروع به چه چیزی از ما نیاز دارید؟','یک گفتگوی کوتاه درباره اهداف، مخاطب و اینکه تا امروز چه چیزی جواب داده و چه چیزی نه. بقیه مرحله کشف با ماست.','2026-07-29 05:42:03','2026-07-29 05:42:03'),
(12,4,'ar','ماذا تحتاجون منا للبدء؟','محادثة قصيرة عن أهدافكم وجمهوركم وما نجح وما لم ينجح حتى الآن. ونتولى نحن بقية مرحلة الاكتشاف.','2026-07-29 05:42:03','2026-07-29 05:42:03');
/*!40000 ALTER TABLE `faq_translations` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `faqs`
--

DROP TABLE IF EXISTS `faqs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `faqs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `sort_order` smallint(5) unsigned NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `faqs_is_active_sort_order_index` (`is_active`,`sort_order`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faqs`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `faqs` WRITE;
/*!40000 ALTER TABLE `faqs` DISABLE KEYS */;
INSERT INTO `faqs` VALUES
(1,0,1,'2026-07-29 05:42:03','2026-07-29 05:42:03'),
(2,1,1,'2026-07-29 05:42:03','2026-07-29 05:42:03'),
(3,2,1,'2026-07-29 05:42:03','2026-07-29 05:42:03'),
(4,3,1,'2026-07-29 05:42:03','2026-07-29 05:42:03');
/*!40000 ALTER TABLE `faqs` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `industries`
--

DROP TABLE IF EXISTS `industries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `industries` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `sort_order` smallint(5) unsigned NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `industries`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `industries` WRITE;
/*!40000 ALTER TABLE `industries` DISABLE KEYS */;
INSERT INTO `industries` VALUES
(1,0,'2026-07-29 05:42:01','2026-07-29 05:42:01'),
(2,1,'2026-07-29 05:42:01','2026-07-29 05:42:01'),
(3,2,'2026-07-29 05:42:01','2026-07-29 05:42:01'),
(4,3,'2026-07-29 05:42:01','2026-07-29 05:42:01'),
(5,4,'2026-07-29 05:42:01','2026-07-29 05:42:01');
/*!40000 ALTER TABLE `industries` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `industry_translations`
--

DROP TABLE IF EXISTS `industry_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `industry_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `industry_id` bigint(20) unsigned NOT NULL,
  `locale` varchar(5) NOT NULL,
  `name` varchar(150) NOT NULL,
  `slug` varchar(150) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `industry_translations_unique` (`industry_id`,`locale`),
  UNIQUE KEY `industry_translations_slug_unique` (`locale`,`slug`),
  KEY `industry_translations_locale_index` (`locale`),
  CONSTRAINT `industry_translations_industry_id_foreign` FOREIGN KEY (`industry_id`) REFERENCES `industries` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `industry_translations`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `industry_translations` WRITE;
/*!40000 ALTER TABLE `industry_translations` DISABLE KEYS */;
INSERT INTO `industry_translations` VALUES
(1,1,'en','Food & Beverage','food-beverage','2026-07-29 05:42:01','2026-07-29 05:42:01'),
(2,1,'fa','غذا و نوشیدنی','غذا-و-نوشیدنی','2026-07-29 05:42:01','2026-07-29 05:42:01'),
(3,1,'ar','الأغذية والمشروبات','الأغذية-والمشروبات','2026-07-29 05:42:01','2026-07-29 05:42:01'),
(4,2,'en','Automotive','automotive','2026-07-29 05:42:01','2026-07-29 05:42:01'),
(5,2,'fa','خودرو','خودرو','2026-07-29 05:42:01','2026-07-29 05:42:01'),
(6,2,'ar','السيارات','السيارات','2026-07-29 05:42:01','2026-07-29 05:42:01'),
(7,3,'en','Healthcare','healthcare','2026-07-29 05:42:01','2026-07-29 05:42:01'),
(8,3,'fa','سلامت','سلامت','2026-07-29 05:42:01','2026-07-29 05:42:01'),
(9,3,'ar','الرعاية الصحية','الرعاية-الصحية','2026-07-29 05:42:01','2026-07-29 05:42:01'),
(10,4,'en','Travel','travel','2026-07-29 05:42:01','2026-07-29 05:42:01'),
(11,4,'fa','گردشگری','گردشگری','2026-07-29 05:42:01','2026-07-29 05:42:01'),
(12,4,'ar','السفر','السفر','2026-07-29 05:42:01','2026-07-29 05:42:01'),
(13,5,'en','Beauty & Wellness','beauty-wellness','2026-07-29 05:42:01','2026-07-29 05:42:01'),
(14,5,'fa','زیبایی و سلامت','زیبایی-و-سلامت','2026-07-29 05:42:01','2026-07-29 05:42:01'),
(15,5,'ar','الجمال والعافية','الجمال-والعافية','2026-07-29 05:42:01','2026-07-29 05:42:01');
/*!40000 ALTER TABLE `industry_translations` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `menu_item_translations`
--

DROP TABLE IF EXISTS `menu_item_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `menu_item_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `menu_item_id` bigint(20) unsigned NOT NULL,
  `locale` varchar(5) NOT NULL,
  `label` varchar(150) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `menu_item_translations_unique` (`menu_item_id`,`locale`),
  KEY `menu_item_translations_locale_index` (`locale`),
  CONSTRAINT `menu_item_translations_menu_item_id_foreign` FOREIGN KEY (`menu_item_id`) REFERENCES `menu_items` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu_item_translations`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `menu_item_translations` WRITE;
/*!40000 ALTER TABLE `menu_item_translations` DISABLE KEYS */;
INSERT INTO `menu_item_translations` VALUES
(1,1,'en','Home','2026-07-29 05:42:02','2026-07-29 05:42:02'),
(2,1,'fa','خانه','2026-07-29 05:42:02','2026-07-29 05:42:02'),
(3,1,'ar','الرئيسية','2026-07-29 05:42:02','2026-07-29 05:42:02'),
(4,2,'en','Work','2026-07-29 05:42:02','2026-07-29 05:42:02'),
(5,2,'fa','نمونه‌کارها','2026-07-29 05:42:02','2026-07-29 05:42:02'),
(6,2,'ar','أعمالنا','2026-07-29 05:42:02','2026-07-29 05:42:02'),
(7,3,'en','Service','2026-07-29 05:42:02','2026-07-29 05:42:02'),
(8,3,'fa','خدمات','2026-07-29 05:42:02','2026-07-29 05:42:02'),
(9,3,'ar','الخدمات','2026-07-29 05:42:02','2026-07-29 05:42:02'),
(10,4,'en','Insight','2026-07-29 05:42:02','2026-07-29 05:42:02'),
(11,4,'fa','بینش','2026-07-29 05:42:02','2026-07-29 05:42:02'),
(12,4,'ar','رؤى','2026-07-29 05:42:02','2026-07-29 05:42:02'),
(13,5,'en','About','2026-07-29 05:42:02','2026-07-29 05:42:02'),
(14,5,'fa','درباره ما','2026-07-29 05:42:02','2026-07-29 05:42:02'),
(15,5,'ar','من نحن','2026-07-29 05:42:02','2026-07-29 05:42:02'),
(16,6,'en','Let\'s Talk','2026-07-29 05:42:02','2026-07-29 05:42:02'),
(17,6,'fa','گفتگو کنیم','2026-07-29 05:42:02','2026-07-29 05:42:02'),
(18,6,'ar','لنتحدث','2026-07-29 05:42:02','2026-07-29 05:42:02'),
(19,7,'en','Quick Links','2026-07-29 05:42:02','2026-07-29 05:42:02'),
(20,7,'fa','دسترسی سریع','2026-07-29 05:42:02','2026-07-29 05:42:02'),
(21,7,'ar','روابط سريعة','2026-07-29 05:42:02','2026-07-29 05:42:02'),
(22,8,'en','Home','2026-07-29 05:42:02','2026-07-29 05:42:02'),
(23,8,'fa','خانه','2026-07-29 05:42:02','2026-07-29 05:42:02'),
(24,8,'ar','الرئيسية','2026-07-29 05:42:02','2026-07-29 05:42:02'),
(25,9,'en','Services','2026-07-29 05:42:02','2026-07-29 05:42:02'),
(26,9,'fa','خدمات','2026-07-29 05:42:02','2026-07-29 05:42:02'),
(27,9,'ar','الخدمات','2026-07-29 05:42:02','2026-07-29 05:42:02'),
(28,10,'en','Work','2026-07-29 05:42:02','2026-07-29 05:42:02'),
(29,10,'fa','نمونه‌کارها','2026-07-29 05:42:02','2026-07-29 05:42:02'),
(30,10,'ar','أعمالنا','2026-07-29 05:42:02','2026-07-29 05:42:02'),
(31,11,'en','Insight','2026-07-29 05:42:02','2026-07-29 05:42:02'),
(32,11,'fa','بینش','2026-07-29 05:42:02','2026-07-29 05:42:02'),
(33,11,'ar','رؤى','2026-07-29 05:42:02','2026-07-29 05:42:02'),
(34,12,'en','About','2026-07-29 05:42:02','2026-07-29 05:42:02'),
(35,12,'fa','درباره ما','2026-07-29 05:42:02','2026-07-29 05:42:02'),
(36,12,'ar','من نحن','2026-07-29 05:42:02','2026-07-29 05:42:02'),
(37,13,'en','Contact','2026-07-29 05:42:02','2026-07-29 05:42:02'),
(38,13,'fa','تماس','2026-07-29 05:42:02','2026-07-29 05:42:02'),
(39,13,'ar','اتصل بنا','2026-07-29 05:42:02','2026-07-29 05:42:02'),
(40,14,'en','Social Links','2026-07-29 05:42:02','2026-07-29 05:42:02'),
(41,14,'fa','شبکه‌های اجتماعی','2026-07-29 05:42:02','2026-07-29 05:42:02'),
(42,14,'ar','وسائل التواصل','2026-07-29 05:42:02','2026-07-29 05:42:02'),
(43,15,'en','Instagram','2026-07-29 05:42:02','2026-07-29 05:42:02'),
(44,15,'fa','Instagram','2026-07-29 05:42:02','2026-07-29 05:42:02'),
(45,15,'ar','Instagram','2026-07-29 05:42:02','2026-07-29 05:42:02'),
(46,16,'en','LinkedIn','2026-07-29 05:42:02','2026-07-29 05:42:02'),
(47,16,'fa','LinkedIn','2026-07-29 05:42:02','2026-07-29 05:42:02'),
(48,16,'ar','LinkedIn','2026-07-29 05:42:02','2026-07-29 05:42:02'),
(49,17,'en','WhatsApp','2026-07-29 05:42:02','2026-07-29 05:42:02'),
(50,17,'fa','WhatsApp','2026-07-29 05:42:02','2026-07-29 05:42:02'),
(51,17,'ar','WhatsApp','2026-07-29 05:42:02','2026-07-29 05:42:02'),
(52,18,'en','X','2026-07-29 05:42:02','2026-07-29 05:42:02'),
(53,18,'fa','X','2026-07-29 05:42:02','2026-07-29 05:42:02'),
(54,18,'ar','X','2026-07-29 05:42:02','2026-07-29 05:42:02'),
(55,19,'en','YouTube','2026-07-29 05:42:02','2026-07-29 05:42:02'),
(56,19,'fa','YouTube','2026-07-29 05:42:02','2026-07-29 05:42:02'),
(57,19,'ar','YouTube','2026-07-29 05:42:02','2026-07-29 05:42:02');
/*!40000 ALTER TABLE `menu_item_translations` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `menu_items`
--

DROP TABLE IF EXISTS `menu_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `menu_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `menu_id` bigint(20) unsigned NOT NULL,
  `parent_id` bigint(20) unsigned DEFAULT NULL,
  `route_name` varchar(100) DEFAULT NULL,
  `route_params` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`route_params`)),
  `url` varchar(500) DEFAULT NULL,
  `target` varchar(10) NOT NULL DEFAULT '_self',
  `is_cta` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Renders as the header''s Let''s Talk button',
  `sort_order` smallint(5) unsigned NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `menu_items_parent_id_foreign` (`parent_id`),
  KEY `menu_items_tree_index` (`menu_id`,`parent_id`,`sort_order`),
  KEY `menu_items_is_active_index` (`is_active`),
  CONSTRAINT `menu_items_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE,
  CONSTRAINT `menu_items_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `menu_items` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu_items`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `menu_items` WRITE;
/*!40000 ALTER TABLE `menu_items` DISABLE KEYS */;
INSERT INTO `menu_items` VALUES
(1,1,NULL,'home',NULL,NULL,'_self',0,0,1,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(2,1,NULL,'work.index',NULL,NULL,'_self',0,1,1,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(3,1,NULL,'services',NULL,NULL,'_self',0,2,1,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(4,1,NULL,'insights.index',NULL,NULL,'_self',0,3,1,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(5,1,NULL,'about',NULL,NULL,'_self',0,4,1,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(6,1,NULL,'contact',NULL,NULL,'_self',1,5,1,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(7,2,NULL,NULL,NULL,NULL,'_self',0,0,1,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(8,2,7,'home',NULL,NULL,'_self',0,0,1,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(9,2,7,'services',NULL,NULL,'_self',0,1,1,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(10,2,7,'work.index',NULL,NULL,'_self',0,2,1,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(11,2,7,'insights.index',NULL,NULL,'_self',0,3,1,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(12,2,7,'about',NULL,NULL,'_self',0,4,1,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(13,2,7,'contact',NULL,NULL,'_self',0,5,1,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(14,2,NULL,NULL,NULL,NULL,'_self',0,1,1,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(15,2,14,NULL,NULL,'https://instagram.com/sahramarketing','_blank',0,0,1,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(16,2,14,NULL,NULL,'https://linkedin.com/company/sahramarketing','_blank',0,1,1,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(17,2,14,NULL,NULL,'https://wa.me/96777811213','_blank',0,2,1,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(18,2,14,NULL,NULL,'https://x.com/sahramarketing','_blank',0,3,1,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(19,2,14,NULL,NULL,'https://youtube.com/@sahramarketing','_blank',0,4,1,'2026-07-29 05:42:02','2026-07-29 05:42:02');
/*!40000 ALTER TABLE `menu_items` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `menus`
--

DROP TABLE IF EXISTS `menus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `menus` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `location` varchar(20) NOT NULL COMMENT 'App\\Enums\\MenuLocation',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `menus_location_unique` (`location`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menus`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `menus` WRITE;
/*!40000 ALTER TABLE `menus` DISABLE KEYS */;
INSERT INTO `menus` VALUES
(1,'Header navigation','header','2026-07-29 05:42:02','2026-07-29 05:42:02'),
(2,'Footer navigation','footer','2026-07-29 05:42:02','2026-07-29 05:42:02');
/*!40000 ALTER TABLE `menus` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES
(1,'0001_01_01_000000_create_users_table',1),
(2,'0001_01_01_000001_create_cache_table',1),
(3,'0001_01_01_000002_create_jobs_table',1),
(4,'2026_01_01_000100_create_settings_table',1),
(5,'2026_01_01_000110_create_social_links_table',1),
(6,'2026_01_01_000120_create_menus_table',1),
(7,'2026_01_01_000200_create_pages_table',1),
(8,'2026_01_01_000210_create_page_sections_table',1),
(9,'2026_01_01_000220_create_section_items_table',1),
(10,'2026_01_01_000300_create_services_table',1),
(11,'2026_01_01_000310_create_industries_table',1),
(12,'2026_01_01_000320_create_projects_table',1),
(13,'2026_01_01_000400_create_posts_table',1),
(14,'2026_01_01_000500_create_team_members_table',1),
(15,'2026_01_01_000510_create_testimonials_table',1),
(16,'2026_01_01_000520_create_faqs_table',1),
(17,'2026_01_01_000530_create_clients_table',1),
(18,'2026_01_01_000600_create_contact_submissions_table',1),
(19,'2026_01_01_000610_create_newsletter_subscriptions_table',1),
(20,'2026_01_01_000620_create_redirects_table',1),
(21,'2026_07_26_000001_add_text_colors_to_page_sections_table',1),
(22,'2026_07_27_000001_add_package_fields_to_section_item_translations',1),
(23,'2026_07_27_000002_publish_home_packages',1),
(24,'2026_07_27_000003_sync_home_why_us_copy',1),
(25,'2026_07_27_000004_sync_home_projects_showcase_copy',1),
(26,'2026_07_27_000005_match_projects_showcase_figma_copy',1),
(27,'2026_07_28_000001_repoint_media_to_figma_exports',1),
(28,'2026_07_28_000002_add_cheshmeh_case_study_media',1),
(29,'2026_07_29_091142_create_permission_tables',1),
(30,'2026_07_31_000001_create_notifications_table',2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_permissions`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `model_has_permissions` WRITE;
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_roles`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `model_has_roles` WRITE;
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
INSERT INTO `model_has_roles` VALUES
(1,'App\\Models\\User',1);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `newsletter_subscriptions`
--

DROP TABLE IF EXISTS `newsletter_subscriptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `newsletter_subscriptions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(200) NOT NULL,
  `locale` varchar(5) NOT NULL,
  `source` varchar(50) DEFAULT NULL COMMENT 'home|article|contact',
  `confirmed_at` timestamp NULL DEFAULT NULL,
  `unsubscribed_at` timestamp NULL DEFAULT NULL,
  `unsubscribe_token` varchar(64) NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `newsletter_subscriptions_email_unique` (`email`),
  UNIQUE KEY `newsletter_subscriptions_unsubscribe_token_unique` (`unsubscribe_token`),
  KEY `newsletter_subscriptions_unsubscribed_at_created_at_index` (`unsubscribed_at`,`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `newsletter_subscriptions`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `newsletter_subscriptions` WRITE;
/*!40000 ALTER TABLE `newsletter_subscriptions` DISABLE KEYS */;
/*!40000 ALTER TABLE `newsletter_subscriptions` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) unsigned NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `page_section_translations`
--

DROP TABLE IF EXISTS `page_section_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `page_section_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `page_section_id` bigint(20) unsigned NOT NULL,
  `locale` varchar(5) NOT NULL,
  `eyebrow` varchar(150) DEFAULT NULL COMMENT 'Figma "small title" 1419:9231',
  `title` varchar(300) DEFAULT NULL,
  `subtitle` varchar(300) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `primary_cta_label` varchar(100) DEFAULT NULL,
  `primary_cta_url` varchar(500) DEFAULT NULL,
  `secondary_cta_label` varchar(100) DEFAULT NULL,
  `secondary_cta_url` varchar(500) DEFAULT NULL,
  `image_alt` varchar(300) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `page_section_translations_unique` (`page_section_id`,`locale`),
  KEY `page_section_translations_locale_index` (`locale`),
  CONSTRAINT `page_section_translations_page_section_id_foreign` FOREIGN KEY (`page_section_id`) REFERENCES `page_sections` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=190 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `page_section_translations`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `page_section_translations` WRITE;
/*!40000 ALTER TABLE `page_section_translations` DISABLE KEYS */;
INSERT INTO `page_section_translations` VALUES
(127,51,'en','Digital Marketing Agency in Muscat','We build','Sahra connects strategy, identity, content, and campaigns into one clear direction for business growth','for brands ready to grow','marketing systems','Explore Projects','/work','Start a Conversation','/contact','Golden desert dunes meeting the horizon at sunrise','2026-07-30 15:49:33','2026-07-30 15:49:33'),
(128,51,'fa','آژانس بازاریابی دیجیتال در مسقط','ما می‌سازیم','صحرا استراتژی، هویت، محتوا و کمپین را در یک مسیر شفاف برای رشد کسب‌وکار به‌هم متصل می‌کند.','برای برندهای آماده رشد','سیستم‌های بازاریابی','مشاهده پروژه‌ها','/work','شروع گفتگو','/contact','تپه‌های طلایی کویر در افق هنگام طلوع','2026-07-30 15:49:33','2026-07-30 15:49:33'),
(129,51,'ar','وكالة تسويق رقمي في مسقط','نبني','تربط صحراء الاستراتيجية والهوية والمحتوى والحملات في اتجاه واحد واضح لنمو الأعمال.','للعلامات المستعدة للنمو','أنظمة التسويق','شاهد المشاريع','/work','ابدأ محادثة','/contact','كثبان رملية ذهبية عند الأفق وقت الشروق','2026-07-30 15:49:33','2026-07-30 15:49:33'),
(130,52,'en',NULL,'Results that compound',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(131,52,'fa',NULL,'نتایجی که انباشته می‌شوند',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(132,52,'ar',NULL,'نتائج تتراكم',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(133,53,'en',NULL,'Trusted by','brands',NULL,'+50',NULL,NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(134,53,'fa',NULL,'مورد اعتماد','برند',NULL,'+۵۰',NULL,NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(135,53,'ar',NULL,'موضع ثقة','علامة تجارية',NULL,'+٥٠',NULL,NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(136,54,'en','Our Services','A Connected System for Brand Growth',NULL,'From strategy and identity to content and campaigns, Sahra brings every part of your marketing into one clear direction',NULL,NULL,NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(137,54,'fa','خدمات ما','چهار سیستم، یک مسیر',NULL,'هر آنچه انجام می‌دهیم برای ایجاد شفافیت، ساختار و مسیر بلندمدت برند شماست.',NULL,NULL,NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(138,54,'ar','خدماتنا','أربعة أنظمة، اتجاه واحد',NULL,'كل ما نقوم به مصمم لمنح علامتك التجارية وضوحاً وبنية واتجاهاً طويل الأمد.',NULL,NULL,NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(139,55,'en',NULL,'Is your content really directed or just consistent?',NULL,'Get the Content Direction Checklist and evaluate your brand system.',NULL,'Get checklist','/contact',NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(140,55,'fa',NULL,'آیا محتوای شما واقعاً جهت‌مند است یا فقط منظم؟',NULL,'چک‌لیست جهت‌گیری محتوا را دریافت و سیستم برند خود را ارزیابی کنید.',NULL,'دریافت چک‌لیست','/contact',NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(141,55,'ar',NULL,'هل محتواك موجّه فعلاً أم أنه منتظم فقط؟',NULL,'احصل على قائمة توجيه المحتوى وقيّم نظام علامتك التجارية.',NULL,'احصل على القائمة','/contact',NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(142,56,'en','Our Projects','Where Strategy Becomes Visible','A collection of brand, content, and marketing design projects created to help businesses communicate with clarity and grow with direction',NULL,NULL,'View all work','/work',NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(143,56,'fa','پروژه‌های ما','جایی که استراتژی دیده می‌شود','مجموعه‌ای از پروژه‌های برند، محتوا و طراحی بازاریابی برای کمک به کسب‌وکارها تا شفاف‌تر ارتباط برقرار کنند و هدفمند رشد کنند.',NULL,NULL,'مشاهده همه نمونه‌کارها','/work',NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(144,56,'ar','مشاريعنا','حيث تصبح الاستراتيجية مرئية','مجموعة من مشاريع العلامة والمحتوى والتصميم التسويقي لمساعدة الشركات على التواصل بوضوح والنمو باتجاه هادف.',NULL,NULL,'شاهد كل الأعمال','/work',NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(145,57,'en','Our Process','A Clear Path to Brand Growth','Our process keeps every project clear, structured, and aligned with your brand’s real needs.',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(146,57,'fa','فرایند ما','مسیری روشن برای رشد برند','فرایند ما هر پروژه را شفاف، ساختاریافته و هم‌راستا با نیازهای واقعی برند شما نگه می‌دارد.',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(147,57,'ar','عمليتنا','مسار واضح لنمو العلامة','تحافظ عمليتنا على وضوح كل مشروع وتنظيمه وتوافقه مع الاحتياجات الحقيقية لعلامتك.',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(148,58,'en','Our Packages','Packages Built for Brand Growth','Three focused packages designed for different business needs, growth stages, and levels of support.','Let’s talk about your goals and find the best solution for your brand.','Need help choosing the right package?','Contact Us','/contact',NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(149,58,'fa','پکیج‌های ما','پکیج‌هایی برای رشد برند','سه پکیج هدفمند برای نیازها، مراحل رشد و سطوح پشتیبانی متفاوت.','درباره اهدافتان صحبت کنیم و بهترین راهکار را برای برند شما پیدا کنیم.','برای انتخاب پکیج مناسب کمک می‌خواهید؟','تماس با ما','/contact',NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(150,58,'ar','باقاتنا','باقات مصممة لنمو العلامة','ثلاث باقات مركزة لاحتياجات ومراحل نمو ومستويات دعم مختلفة.','لنتحدث عن أهدافك ونجد أفضل حل لعلامتك.','هل تحتاج مساعدة في اختيار الباقة المناسبة؟','تواصل معنا','/contact',NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(151,59,'en','Why us','Why brands choose Sahra','Because every creative decision is built around brand clarity, consistency, and growth.',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(152,59,'fa','چرا ما','چرا برندها صحرا را انتخاب می‌کنند','زیرا هر تصمیم خلاقانه بر پایه شفافیت برند، انسجام و رشد شکل می‌گیرد.',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(153,59,'ar','لماذا نحن','لماذا تختار العلامات التجارية صحراء','لأن كل قرار إبداعي يُبنى حول وضوح العلامة واتساقها ونموها.',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(154,60,'en','Testimonials','What our customers tell about us',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(155,60,'fa','نظرات مشتریان','مشتریان درباره ما چه می‌گویند',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(156,60,'ar','آراء العملاء','ماذا يقول عملاؤنا عنا',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(157,61,'en','Insights','Insights for Brands Ready to Grow',NULL,NULL,NULL,'Read all articles','/insights',NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(158,61,'fa','بینش','بینش برای برندهایی که آماده رشدند',NULL,NULL,NULL,'خواندن همه مقالات','/insights',NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(159,61,'ar','رؤى','رؤى للعلامات التجارية المستعدة للنمو',NULL,NULL,NULL,'اقرأ كل المقالات','/insights',NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(160,62,'en','FAQ','Questions we hear often',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(161,62,'fa','پرسش‌های متداول','پرسش‌هایی که زیاد می‌شنویم',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(162,62,'ar','الأسئلة الشائعة','أسئلة نسمعها كثيراً',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(163,63,'en','Start with clarity','Ready to build your brand with direction?','Branding · Content Production · Social Media Support · Marketing Design','Share your goals with Sahra, and let\'s define the right next step for your brand.',NULL,'Start a Conversation','/contact',NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(164,63,'fa','با شفافیت آغاز کنید','آماده‌اید برندتان را با جهت بسازید؟','برندینگ · تولید محتوا · پشتیبانی شبکه‌های اجتماعی · طراحی بازاریابی','اهدافتان را با صحرا در میان بگذارید تا گام درست بعدی را مشخص کنیم.',NULL,'شروع گفتگو','/contact',NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(165,63,'ar','ابدأ بالوضوح','هل أنت مستعد لبناء علامتك باتجاه واضح؟','الهوية · إنتاج المحتوى · دعم وسائل التواصل · تصميم التسويق','شارك أهدافك مع صحراء، ولنحدد الخطوة التالية الصحيحة لعلامتك.',NULL,'ابدأ محادثة','/contact',NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(166,64,'en','About us','We are Sahra',NULL,'We help brands build stronger digital presence through content, branding, social media, and creative direction.','A digital marketing agency rooted in Oman',NULL,NULL,NULL,NULL,'Glass arch sculpture holding golden sand dunes and a sun disc','2026-07-30 15:49:33','2026-07-30 15:49:33'),
(167,64,'fa','درباره ما','ما صحرا هستیم',NULL,'ما به برندها کمک می‌کنیم از طریق محتوا، برندینگ، شبکه‌های اجتماعی و جهت‌گیری خلاق حضور دیجیتال قوی‌تری بسازند.','آژانس بازاریابی دیجیتال با ریشه در عمان',NULL,NULL,NULL,NULL,'مجسمه شیشه‌ای قوسی با تپه‌های شنی طلایی و قرص خورشید','2026-07-30 15:49:33','2026-07-30 15:49:33'),
(168,64,'ar','من نحن','نحن صحراء',NULL,'نساعد العلامات التجارية على بناء حضور رقمي أقوى عبر المحتوى والهوية ووسائل التواصل والتوجيه الإبداعي.','وكالة تسويق رقمي متجذّرة في عُمان',NULL,NULL,NULL,NULL,'منحوتة زجاجية مقوسة تحتضن كثباناً رملية ذهبية وقرص شمس','2026-07-30 15:49:33','2026-07-30 15:49:33'),
(169,65,'en',NULL,'The Story Behind Sahra',NULL,'Sahra began with a simple belief: brands deserve more than scattered content and short-term visuals.','We help businesses present themselves with more quality, clarity, and consistency — bringing content production, visual direction, branding, and social media management together to build a stronger digital presence.',NULL,NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(170,65,'fa',NULL,'داستان صحرا',NULL,'صحرا با باوری ساده آغاز شد: برندها شایسته چیزی بیش از محتوای پراکنده و تصاویر کوتاه‌مدت هستند.','ما به کسب‌وکارها کمک می‌کنیم خود را با کیفیت، شفافیت و ثبات بیشتری معرفی کنند — با گردآوردن تولید محتوا، جهت‌گیری بصری، برندینگ و مدیریت شبکه‌های اجتماعی.',NULL,NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(171,65,'ar',NULL,'قصة صحراء',NULL,'بدأت صحراء بقناعة بسيطة: العلامات التجارية تستحق أكثر من محتوى مبعثر ومرئيات قصيرة الأمد.','نساعد الشركات على تقديم نفسها بجودة ووضوح واتساق أكبر — بجمع إنتاج المحتوى والتوجيه البصري والهوية وإدارة وسائل التواصل.',NULL,NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(172,66,'en',NULL,'How We Think',NULL,'We believe strong digital presence starts with clarity, consistency, and brand-aligned execution — not random content or short-term visuals.',NULL,NULL,NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(173,66,'fa',NULL,'چگونه فکر می‌کنیم',NULL,'باور داریم حضور دیجیتال قوی با شفافیت، ثبات و اجرای هم‌راستا با برند آغاز می‌شود — نه محتوای تصادفی.',NULL,NULL,NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(174,66,'ar',NULL,'كيف نفكر',NULL,'نؤمن أن الحضور الرقمي القوي يبدأ بالوضوح والاتساق والتنفيذ المتوائم مع العلامة — لا بمحتوى عشوائي.',NULL,NULL,NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(175,67,'en',NULL,'Small Team, Big Standards',NULL,'A focused team building stronger digital presence through strategy, design, content, and execution.',NULL,NULL,NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(176,67,'fa',NULL,'تیمی کوچک، استانداردهایی بزرگ',NULL,'تیمی متمرکز که با استراتژی، طراحی، محتوا و اجرا حضور دیجیتال قوی‌تری می‌سازد.',NULL,NULL,NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(177,67,'ar',NULL,'فريق صغير، معايير كبيرة',NULL,'فريق مركّز يبني حضوراً رقمياً أقوى عبر الاستراتيجية والتصميم والمحتوى والتنفيذ.',NULL,NULL,NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(178,68,'en','Start with clarity','Ready to build your brand with direction?','Branding · Content Production · Social Media Support · Marketing Design','Share your goals with Sahra, and let\'s define the right next step for your brand.',NULL,'Start a Conversation','/contact',NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(179,68,'fa','با شفافیت آغاز کنید','آماده‌اید برندتان را با جهت بسازید؟','برندینگ · تولید محتوا · پشتیبانی شبکه‌های اجتماعی · طراحی بازاریابی','اهدافتان را با صحرا در میان بگذارید تا گام درست بعدی را مشخص کنیم.',NULL,'شروع گفتگو','/contact',NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(180,68,'ar','ابدأ بالوضوح','هل أنت مستعد لبناء علامتك باتجاه واضح؟','الهوية · إنتاج المحتوى · دعم وسائل التواصل · تصميم التسويق','شارك أهدافك مع صحراء، ولنحدد الخطوة التالية الصحيحة لعلامتك.',NULL,'ابدأ محادثة','/contact',NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(181,69,'en','Start with clarity','Ready to build your brand with direction?','Branding · Content Production · Social Media Support · Marketing Design','Share your goals with Sahra, and let\'s define the right next step for your brand.',NULL,'Start a Conversation','/contact',NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(182,69,'fa','با شفافیت آغاز کنید','آماده‌اید برندتان را با جهت بسازید؟','برندینگ · تولید محتوا · پشتیبانی شبکه‌های اجتماعی · طراحی بازاریابی','اهدافتان را با صحرا در میان بگذارید تا گام درست بعدی را مشخص کنیم.',NULL,'شروع گفتگو','/contact',NULL,NULL,NULL,'2026-07-30 15:49:34','2026-07-30 15:49:34'),
(183,69,'ar','ابدأ بالوضوح','هل أنت مستعد لبناء علامتك باتجاه واضح؟','الهوية · إنتاج المحتوى · دعم وسائل التواصل · تصميم التسويق','شارك أهدافك مع صحراء، ولنحدد الخطوة التالية الصحيحة لعلامتك.',NULL,'ابدأ محادثة','/contact',NULL,NULL,NULL,'2026-07-30 15:49:34','2026-07-30 15:49:34'),
(184,70,'en','Start with clarity','Ready to build your brand with direction?','Branding · Content Production · Social Media Support · Marketing Design','Share your goals with Sahra, and let\'s define the right next step for your brand.',NULL,'Start a Conversation','/contact',NULL,NULL,NULL,'2026-07-30 15:49:34','2026-07-30 15:49:34'),
(185,70,'fa','با شفافیت آغاز کنید','آماده‌اید برندتان را با جهت بسازید؟','برندینگ · تولید محتوا · پشتیبانی شبکه‌های اجتماعی · طراحی بازاریابی','اهدافتان را با صحرا در میان بگذارید تا گام درست بعدی را مشخص کنیم.',NULL,'شروع گفتگو','/contact',NULL,NULL,NULL,'2026-07-30 15:49:34','2026-07-30 15:49:34'),
(186,70,'ar','ابدأ بالوضوح','هل أنت مستعد لبناء علامتك باتجاه واضح؟','الهوية · إنتاج المحتوى · دعم وسائل التواصل · تصميم التسويق','شارك أهدافك مع صحراء، ولنحدد الخطوة التالية الصحيحة لعلامتك.',NULL,'ابدأ محادثة','/contact',NULL,NULL,NULL,'2026-07-30 15:49:34','2026-07-30 15:49:34'),
(187,71,'en','Start with clarity','Ready to build your brand with direction?','Branding · Content Production · Social Media Support · Marketing Design','Share your goals with Sahra, and let\'s define the right next step for your brand.',NULL,'Start a Conversation','/contact',NULL,NULL,NULL,'2026-07-30 15:49:34','2026-07-30 15:49:34'),
(188,71,'fa','با شفافیت آغاز کنید','آماده‌اید برندتان را با جهت بسازید؟','برندینگ · تولید محتوا · پشتیبانی شبکه‌های اجتماعی · طراحی بازاریابی','اهدافتان را با صحرا در میان بگذارید تا گام درست بعدی را مشخص کنیم.',NULL,'شروع گفتگو','/contact',NULL,NULL,NULL,'2026-07-30 15:49:34','2026-07-30 15:49:34'),
(189,71,'ar','ابدأ بالوضوح','هل أنت مستعد لبناء علامتك باتجاه واضح؟','الهوية · إنتاج المحتوى · دعم وسائل التواصل · تصميم التسويق','شارك أهدافك مع صحراء، ولنحدد الخطوة التالية الصحيحة لعلامتك.',NULL,'ابدأ محادثة','/contact',NULL,NULL,NULL,'2026-07-30 15:49:34','2026-07-30 15:49:34');
/*!40000 ALTER TABLE `page_section_translations` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `page_sections`
--

DROP TABLE IF EXISTS `page_sections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `page_sections` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `sectionable_type` varchar(255) NOT NULL,
  `sectionable_id` bigint(20) unsigned NOT NULL,
  `type` varchar(40) NOT NULL COMMENT 'App\\Enums\\SectionType',
  `sort_order` smallint(5) unsigned NOT NULL DEFAULT 0,
  `is_visible` tinyint(1) NOT NULL DEFAULT 1,
  `image_path` varchar(500) DEFAULT NULL,
  `eyebrow_color` varchar(9) DEFAULT NULL,
  `title_color` varchar(9) DEFAULT NULL,
  `subtitle_color` varchar(9) DEFAULT NULL,
  `description_color` varchar(9) DEFAULT NULL,
  `content_color` varchar(9) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `page_sections_sectionable_type_sectionable_id_index` (`sectionable_type`,`sectionable_id`),
  KEY `page_sections_render_index` (`sectionable_type`,`sectionable_id`,`is_visible`,`sort_order`),
  KEY `page_sections_type_index` (`type`)
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `page_sections`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `page_sections` WRITE;
/*!40000 ALTER TABLE `page_sections` DISABLE KEYS */;
INSERT INTO `page_sections` VALUES
(51,'App\\Models\\Page',1,'hero',0,1,NULL,NULL,NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(52,'App\\Models\\Page',1,'kpi',1,1,NULL,NULL,NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(53,'App\\Models\\Page',1,'trust_proof',2,1,NULL,NULL,NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(54,'App\\Models\\Page',1,'services_cloud',3,1,NULL,NULL,NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(55,'App\\Models\\Page',1,'lead_magnet',4,1,NULL,NULL,NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(56,'App\\Models\\Page',1,'projects_showcase',5,1,NULL,NULL,NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(57,'App\\Models\\Page',1,'process',6,1,NULL,NULL,NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(58,'App\\Models\\Page',1,'packages',7,1,NULL,NULL,NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(59,'App\\Models\\Page',1,'why_us',8,1,NULL,NULL,NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(60,'App\\Models\\Page',1,'reviews',9,1,NULL,NULL,NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(61,'App\\Models\\Page',1,'insights',10,1,NULL,NULL,NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(62,'App\\Models\\Page',1,'faq',11,1,NULL,NULL,NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(63,'App\\Models\\Page',1,'final_cta',12,1,NULL,NULL,NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(64,'App\\Models\\Page',2,'about_hero',0,1,NULL,NULL,NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(65,'App\\Models\\Page',2,'story',1,1,NULL,NULL,NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(66,'App\\Models\\Page',2,'how_we_think',2,1,NULL,NULL,NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(67,'App\\Models\\Page',2,'team',3,1,NULL,NULL,NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(68,'App\\Models\\Page',2,'final_cta',4,1,NULL,NULL,NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(69,'App\\Models\\Page',3,'final_cta',0,1,NULL,NULL,NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(70,'App\\Models\\Page',4,'final_cta',0,1,NULL,NULL,NULL,NULL,NULL,NULL,'2026-07-30 15:49:34','2026-07-30 15:49:34'),
(71,'App\\Models\\Page',5,'final_cta',0,1,NULL,NULL,NULL,NULL,NULL,NULL,'2026-07-30 15:49:34','2026-07-30 15:49:34'),
(72,'App\\Models\\Project',6,'goals',0,1,NULL,NULL,NULL,NULL,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(73,'App\\Models\\Project',6,'strategy',1,1,NULL,NULL,NULL,NULL,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(74,'App\\Models\\Project',6,'deliverables',2,1,NULL,NULL,NULL,NULL,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(75,'App\\Models\\Project',6,'results',3,1,NULL,NULL,NULL,NULL,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00');
/*!40000 ALTER TABLE `page_sections` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `page_translations`
--

DROP TABLE IF EXISTS `page_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `page_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `page_id` bigint(20) unsigned NOT NULL,
  `locale` varchar(5) NOT NULL,
  `title` varchar(200) NOT NULL,
  `subtitle` varchar(300) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `content` longtext DEFAULT NULL COMMENT 'Rich text — legal pages',
  `seo_title` varchar(200) DEFAULT NULL,
  `seo_description` varchar(300) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `page_translations_unique` (`page_id`,`locale`),
  KEY `page_translations_locale_index` (`locale`),
  CONSTRAINT `page_translations_page_id_foreign` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `page_translations`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `page_translations` WRITE;
/*!40000 ALTER TABLE `page_translations` DISABLE KEYS */;
INSERT INTO `page_translations` VALUES
(1,1,'en','We build content systems for brands ready to grow',NULL,NULL,NULL,'Sahra — Digital Marketing Agency in Muscat','Sahra helps businesses in Oman create stronger brand presence through strategy, content, branding, video, and digital marketing.','2026-07-29 05:42:01','2026-07-29 05:42:01'),
(2,1,'fa','ما سیستم‌های محتوایی می‌سازیم برای برندهایی که آماده رشدند',NULL,NULL,NULL,'صحرا — آژانس بازاریابی دیجیتال در مسقط','صحرا به کسب‌وکارها در عمان کمک می‌کند حضور برند قوی‌تری بسازند.','2026-07-29 05:42:01','2026-07-29 05:42:01'),
(3,1,'ar','نبني أنظمة محتوى للعلامات التجارية المستعدة للنمو',NULL,NULL,NULL,'صحراء — وكالة تسويق رقمي في مسقط','تساعد صحراء الشركات في عُمان على بناء حضور أقوى لعلامتها التجارية.','2026-07-29 05:42:01','2026-07-29 05:42:01'),
(4,2,'en','We are Sahra','About us',NULL,NULL,'About Sahra — A strategy-led agency in Oman',NULL,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(5,2,'fa','ما صحرا هستیم','درباره ما',NULL,NULL,'درباره صحرا — آژانسی استراتژی‌محور در عمان',NULL,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(6,2,'ar','نحن صحراء','من نحن',NULL,NULL,'عن صحراء — وكالة قائمة على الاستراتيجية في عُمان',NULL,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(7,3,'en','Where Strategy Becomes Visible','Our Projects','A collection of brand, content, and marketing design projects created to help businesses communicate with clarity and grow with direction.',NULL,NULL,NULL,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(8,3,'fa','جایی که استراتژی دیده می‌شود','پروژه‌های ما','مجموعه‌ای از پروژه‌های برند، محتوا و طراحی بازاریابی که به کسب‌وکارها کمک می‌کند شفاف ارتباط بگیرند و هدفمند رشد کنند.',NULL,NULL,NULL,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(9,3,'ar','حيث تصبح الاستراتيجية مرئية','مشاريعنا','مجموعة من مشاريع الهوية والمحتوى وتصميم التسويق التي تساعد الشركات على التواصل بوضوح والنمو باتجاه.',NULL,NULL,NULL,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(10,4,'en','We build systems, not just services','Services','Four core services designed to bring clarity, structure, and long-term direction to your brand.',NULL,NULL,NULL,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(11,4,'fa','ما سیستم می‌سازیم، نه صرفاً خدمات','خدمات','چهار خدمت اصلی برای ایجاد شفافیت، ساختار و مسیر بلندمدت برای برند شما.',NULL,NULL,NULL,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(12,4,'ar','نبني أنظمة لا مجرد خدمات','الخدمات','أربع خدمات أساسية مصممة لمنح علامتك وضوحاً وبنية واتجاهاً طويل الأمد.',NULL,NULL,NULL,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(13,5,'en','Insights for Brands Ready to Grow','Insights','Explore practical ideas on branding, content, social media, and marketing direction created to help businesses think clearer and grow stronger.',NULL,NULL,NULL,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(14,5,'fa','بینش برای برندهایی که آماده رشدند','بینش','ایده‌های کاربردی درباره برندینگ، محتوا، شبکه‌های اجتماعی و جهت‌گیری بازاریابی برای شفاف‌تر اندیشیدن و قوی‌تر رشد کردن.',NULL,NULL,NULL,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(15,5,'ar','رؤى للعلامات التجارية المستعدة للنمو','رؤى','أفكار عملية حول الهوية والمحتوى ووسائل التواصل واتجاه التسويق تساعد الشركات على التفكير بوضوح والنمو بقوة.',NULL,NULL,NULL,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(16,6,'en','Let\'s Understand Your Brand First','Contact us','Tell us what you need, and we\'ll help you find the right direction for your brand.',NULL,NULL,NULL,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(17,6,'fa','ابتدا برند شما را بشناسیم','تماس با ما','به ما بگویید به چه نیاز دارید تا مسیر درست برند شما را پیدا کنیم.',NULL,NULL,NULL,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(18,6,'ar','لنفهم علامتك التجارية أولاً','اتصل بنا','أخبرنا بما تحتاجه وسنساعدك في إيجاد الاتجاه الصحيح لعلامتك.',NULL,NULL,NULL,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(19,7,'en','Privacy Policy','At Sahra Marketing, we respect your privacy and are committed to protecting the personal information you share with us through our website',NULL,'<h2>Information We Collect</h2><p>When you contact us, submit a form, download a file, or request information about our services, we may collect basic information such as your name, email address, phone number, company name, and any message or project details you choose to share with us.</p><p>We may also collect limited technical information, such as website usage data, browser type, device information, and general analytics data to help us improve our website experience.</p><h2>How We Use Your Information</h2><p>We use the information you provide to:</p><ul><li>Respond to your inquiries</li><li>Understand your business needs</li><li>Share information about our services</li><li>Prepare proposals or follow-up communications</li><li>Improve our website and user experience</li><li>Measure the performance of our marketing activities</li></ul><p>We do not sell your personal information.</p><h2>Cookies &amp; Analytics</h2><p>Our website may use cookies and analytics tools to understand how visitors use the site and to improve performance, content, and marketing efforts. You can control or disable cookies through your browser settings.</p><h2>Sharing Your Information</h2><p>We may share your information only when necessary with trusted service providers who help us operate our website, manage communications, analyze website performance, or deliver our services.</p><p>We may also disclose information if required by law or to protect our legal rights.</p><h2>Data Security</h2><p>We take reasonable steps to protect your personal information from unauthorized access, loss, misuse, or disclosure. However, no online platform can guarantee complete security.</p><h2>Data Retention</h2><p>We keep your information only for as long as necessary to respond to your request, manage our business relationship, provide services, or meet legal and operational requirements.</p><h2>Your Rights</h2><p>You may contact us to request access to your personal information, ask for corrections, or request that your information be deleted from our records, where applicable.</p><h2>Contact Us</h2><p>If you have any questions about this Privacy Policy or how we handle your information, please contact us at:</p><p>Sahra Marketing<br>Muscat, Oman<br>Email: Sahramarketing@gmail.com</p>',NULL,NULL,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(20,7,'fa','حریم خصوصی','در صحرا مارکتینگ به حریم خصوصی شما احترام می‌گذاریم و متعهد به حفاظت از اطلاعات شخصی‌ای هستیم که از طریق وب‌سایت با ما به اشتراک می‌گذارید.',NULL,'<h2>اطلاعاتی که جمع‌آوری می‌کنیم</h2><p>وقتی با ما تماس می‌گیرید، فرمی ارسال می‌کنید، فایلی دانلود می‌کنید یا درباره خدمات ما اطلاعات می‌خواهید، ممکن است اطلاعات پایه‌ای مانند نام، نشانی ایمیل، شماره تماس، نام شرکت و هر پیام یا جزئیات پروژه‌ای که انتخاب می‌کنید با ما به اشتراک بگذارید را جمع‌آوری کنیم.</p><p>همچنین ممکن است اطلاعات فنی محدودی مانند داده‌های استفاده از وب‌سایت، نوع مرورگر، اطلاعات دستگاه و داده‌های تحلیلی عمومی را برای بهبود تجربه وب‌سایت جمع‌آوری کنیم.</p><h2>چگونه از اطلاعات شما استفاده می‌کنیم</h2><p>از اطلاعاتی که ارائه می‌دهید برای این موارد استفاده می‌کنیم:</p><ul><li>پاسخ به پرسش‌های شما</li><li>درک نیازهای کسب‌وکارتان</li><li>ارائه اطلاعات درباره خدمات ما</li><li>تهیه پیشنهاد یا پیگیری‌های بعدی</li><li>بهبود وب‌سایت و تجربه کاربری</li><li>سنجش عملکرد فعالیت‌های بازاریابی ما</li></ul><p>ما اطلاعات شخصی شما را نمی‌فروشیم.</p><h2>کوکی‌ها و تحلیل‌ها</h2><p>وب‌سایت ما ممکن است از کوکی‌ها و ابزارهای تحلیلی برای درک نحوه استفاده بازدیدکنندگان از سایت و بهبود عملکرد، محتوا و تلاش‌های بازاریابی استفاده کند. می‌توانید کوکی‌ها را از تنظیمات مرورگر خود کنترل یا غیرفعال کنید.</p><h2>اشتراک‌گذاری اطلاعات شما</h2><p>اطلاعات شما را تنها در صورت لزوم با ارائه‌دهندگان خدمات مورد اعتمادی که در راه‌اندازی وب‌سایت، مدیریت ارتباطات، تحلیل عملکرد یا ارائه خدمات به ما کمک می‌کنند به اشتراک می‌گذاریم.</p><p>همچنین ممکن است در صورت الزام قانونی یا برای حفاظت از حقوق قانونی خود اطلاعات را افشا کنیم.</p><h2>امنیت داده‌ها</h2><p>ما اقدامات معقولی برای محافظت از اطلاعات شخصی شما در برابر دسترسی غیرمجاز، از دست رفتن، سوءاستفاده یا افشا انجام می‌دهیم. با این حال هیچ پلتفرم آنلاینی نمی‌تواند امنیت کامل را تضمین کند.</p><h2>نگهداری داده‌ها</h2><p>اطلاعات شما را تنها تا زمانی که برای پاسخ به درخواستتان، مدیریت رابطه کاری، ارائه خدمات یا رعایت الزامات قانونی و عملیاتی لازم است نگهداری می‌کنیم.</p><h2>حقوق شما</h2><p>می‌توانید برای درخواست دسترسی به اطلاعات شخصی، اصلاح آن یا حذف اطلاعاتتان از سوابق ما — در مواردی که قابل اعمال باشد — با ما تماس بگیرید.</p><h2>تماس با ما</h2><p>اگر درباره این سیاست حریم خصوصی یا نحوه مدیریت اطلاعاتتان پرسشی دارید، با ما تماس بگیرید:</p><p>صحرا مارکتینگ<br>مسقط، عمان<br>ایمیل: Sahramarketing@gmail.com</p>',NULL,NULL,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(21,7,'ar','سياسة الخصوصية','في صحراء ماركتينغ نحترم خصوصيتك ونلتزم بحماية المعلومات الشخصية التي تشاركها معنا عبر موقعنا.',NULL,'<h2>المعلومات التي نجمعها</h2><p>عند التواصل معنا أو إرسال نموذج أو تنزيل ملف أو طلب معلومات عن خدماتنا، قد نجمع معلومات أساسية مثل اسمك وبريدك الإلكتروني ورقم هاتفك واسم شركتك وأي رسالة أو تفاصيل مشروع تختار مشاركتها معنا.</p><p>وقد نجمع أيضاً معلومات تقنية محدودة، مثل بيانات استخدام الموقع ونوع المتصفح ومعلومات الجهاز وبيانات التحليلات العامة لمساعدتنا في تحسين تجربة الموقع.</p><h2>كيف نستخدم معلوماتك</h2><p>نستخدم المعلومات التي تقدمها من أجل:</p><ul><li>الرد على استفساراتك</li><li>فهم احتياجات عملك</li><li>مشاركة معلومات عن خدماتنا</li><li>إعداد العروض أو المتابعات</li><li>تحسين موقعنا وتجربة المستخدم</li><li>قياس أداء أنشطتنا التسويقية</li></ul><p>نحن لا نبيع معلوماتك الشخصية.</p><h2>ملفات الارتباط والتحليلات</h2><p>قد يستخدم موقعنا ملفات الارتباط وأدوات التحليل لفهم كيفية استخدام الزوار للموقع ولتحسين الأداء والمحتوى وجهود التسويق. يمكنك التحكم في ملفات الارتباط أو تعطيلها من إعدادات متصفحك.</p><h2>مشاركة معلوماتك</h2><p>قد نشارك معلوماتك عند الضرورة فقط مع مزودي خدمات موثوقين يساعدوننا في تشغيل موقعنا أو إدارة الاتصالات أو تحليل أداء الموقع أو تقديم خدماتنا.</p><p>وقد نفصح عن المعلومات إذا اقتضى القانون ذلك أو لحماية حقوقنا القانونية.</p><h2>أمن البيانات</h2><p>نتخذ خطوات معقولة لحماية معلوماتك الشخصية من الوصول غير المصرح به أو الفقدان أو سوء الاستخدام أو الإفصاح. ومع ذلك، لا يمكن لأي منصة إلكترونية ضمان الأمان الكامل.</p><h2>الاحتفاظ بالبيانات</h2><p>نحتفظ بمعلوماتك فقط للمدة اللازمة للرد على طلبك وإدارة علاقتنا التجارية وتقديم الخدمات أو تلبية المتطلبات القانونية والتشغيلية.</p><h2>حقوقك</h2><p>يمكنك التواصل معنا لطلب الوصول إلى معلوماتك الشخصية أو طلب تصحيحها أو حذفها من سجلاتنا، حيثما ينطبق ذلك.</p><h2>اتصل بنا</h2><p>إذا كان لديك أي أسئلة حول سياسة الخصوصية هذه أو كيفية تعاملنا مع معلوماتك، يرجى التواصل معنا على:</p><p>صحراء ماركتينغ<br>مسقط، عُمان<br>البريد الإلكتروني: Sahramarketing@gmail.com</p>',NULL,NULL,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(22,8,'en','Terms & Conditions','At Sahra Marketing, we provide clear guidelines for using our website and services to ensure a reliable and respectful experience for all users.',NULL,'<h2>Use of Website</h2><p>By accessing this website, you agree to use it only for lawful purposes and in a way that does not harm the experience, content, or functionality of the platform.</p><h2>Services</h2><p>Sahra provides branding, marketing design, content production, and social media support services. All services are delivered based on agreed project scope and timelines defined during collaboration.</p><h2>Intellectual Property</h2><p>All content, designs, visuals, and materials created by Sahra remain the intellectual property of Sahra unless otherwise agreed in writing. Unauthorized use or reproduction is not allowed.</p><h2>Client Responsibilities</h2><p>Clients are responsible for providing accurate information, timely feedback, and required materials needed for project execution. Delays in communication may affect delivery timelines.</p><h2>Payments</h2><p>All project costs, pricing structures, and payment terms are agreed upon before starting any work. Work may be paused in case of delayed payments.</p><h2>Limitation of Liability</h2><p>Sahra is not responsible for any indirect, incidental, or consequential damages arising from the use of this website or services.</p><h2>Changes to Terms</h2><p>Sahra reserves the right to update these Terms &amp; Conditions at any time. Continued use of the website means acceptance of any updated terms.</p><h2>Contact Us</h2><p>For any questions regarding these terms, you can contact us at:</p><p>Sahra Marketing<br>Muscat, Oman<br>Email: Sahramarketing@gmail.com</p>',NULL,NULL,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(23,8,'fa','شرایط و قوانین','در صحرا مارکتینگ دستورالعمل‌های شفافی برای استفاده از وب‌سایت و خدمات ارائه می‌کنیم تا تجربه‌ای قابل‌اعتماد و محترمانه برای همه کاربران فراهم شود.',NULL,'<h2>استفاده از وب‌سایت</h2><p>با دسترسی به این وب‌سایت می‌پذیرید که تنها برای مقاصد قانونی و به‌گونه‌ای از آن استفاده کنید که به تجربه، محتوا یا عملکرد پلتفرم آسیب نرساند.</p><h2>خدمات</h2><p>صحرا خدمات برندینگ، طراحی بازاریابی، تولید محتوا و پشتیبانی شبکه‌های اجتماعی ارائه می‌کند. همه خدمات بر اساس دامنه و زمان‌بندی توافق‌شده در جریان همکاری تحویل می‌شوند.</p><h2>مالکیت فکری</h2><p>تمام محتوا، طرح‌ها، تصاویر و موادی که صحرا خلق می‌کند، مگر در صورت توافق کتبی دیگر، متعلق به صحرا باقی می‌ماند. استفاده یا بازتولید غیرمجاز مجاز نیست.</p><h2>مسئولیت‌های مشتری</h2><p>مشتریان مسئول ارائه اطلاعات دقیق، بازخورد به‌موقع و موادی هستند که برای اجرای پروژه لازم است. تأخیر در ارتباط ممکن است بر زمان‌بندی تحویل اثر بگذارد.</p><h2>پرداخت‌ها</h2><p>تمام هزینه‌های پروژه، ساختار قیمت‌گذاری و شرایط پرداخت پیش از آغاز کار توافق می‌شود. در صورت تأخیر در پرداخت، کار ممکن است متوقف شود.</p><h2>محدودیت مسئولیت</h2><p>صحرا مسئول هیچ خسارت غیرمستقیم، تبعی یا اتفاقی ناشی از استفاده از این وب‌سایت یا خدمات نیست.</p><h2>تغییر شرایط</h2><p>صحرا حق به‌روزرسانی این شرایط و قوانین را در هر زمان محفوظ می‌دارد. ادامه استفاده از وب‌سایت به معنای پذیرش شرایط به‌روزشده است.</p><h2>تماس با ما</h2><p>برای هر پرسشی درباره این شرایط می‌توانید با ما تماس بگیرید:</p><p>صحرا مارکتینگ<br>مسقط، عمان<br>ایمیل: Sahramarketing@gmail.com</p>',NULL,NULL,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(24,8,'ar','الشروط والأحكام','في صحراء ماركتينغ نقدم إرشادات واضحة لاستخدام موقعنا وخدماتنا لضمان تجربة موثوقة ومحترمة لجميع المستخدمين.',NULL,'<h2>استخدام الموقع</h2><p>بدخولك هذا الموقع، فإنك توافق على استخدامه للأغراض المشروعة فقط وبطريقة لا تضر بتجربة المنصة أو محتواها أو أدائها.</p><h2>الخدمات</h2><p>تقدم صحراء خدمات الهوية التجارية وتصميم التسويق وإنتاج المحتوى ودعم وسائل التواصل. تُقدَّم جميع الخدمات وفق نطاق المشروع والجداول الزمنية المتفق عليها أثناء التعاون.</p><h2>الملكية الفكرية</h2><p>يبقى كل محتوى وتصميم ومواد تنشئها صحراء ملكية فكرية لصحراء ما لم يُتفق على خلاف ذلك كتابةً. الاستخدام أو النسخ غير المصرح به غير مسموح.</p><h2>مسؤوليات العميل</h2><p>العملاء مسؤولون عن تقديم معلومات دقيقة وملاحظات في وقتها والمواد المطلوبة لتنفيذ المشروع. قد تؤثر التأخيرات في التواصل على مواعيد التسليم.</p><h2>المدفوعات</h2><p>يُتفق على جميع تكاليف المشروع وهياكل التسعير وشروط الدفع قبل بدء أي عمل. وقد يتوقف العمل في حال تأخر المدفوعات.</p><h2>حدود المسؤولية</h2><p>صحراء غير مسؤولة عن أي أضرار غير مباشرة أو عرضية أو تبعية تنشأ عن استخدام هذا الموقع أو الخدمات.</p><h2>تغييرات الشروط</h2><p>تحتفظ صحراء بحق تحديث هذه الشروط والأحكام في أي وقت. استمرار استخدام الموقع يعني قبول أي شروط محدثة.</p><h2>اتصل بنا</h2><p>لأي أسئلة بخصوص هذه الشروط، يمكنك التواصل معنا على:</p><p>صحراء ماركتينغ<br>مسقط، عُمان<br>البريد الإلكتروني: Sahramarketing@gmail.com</p>',NULL,NULL,'2026-07-29 05:42:02','2026-07-29 05:42:02');
/*!40000 ALTER TABLE `page_translations` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `pages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(50) NOT NULL COMMENT 'home|about|contact|work|insights|services|privacy-policy|terms',
  `status` varchar(20) NOT NULL DEFAULT 'published',
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pages_key_unique` (`key`),
  KEY `pages_status_published_at_index` (`status`,`published_at`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pages`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `pages` WRITE;
/*!40000 ALTER TABLE `pages` DISABLE KEYS */;
INSERT INTO `pages` VALUES
(1,'home','published','2026-07-30 15:49:33','2026-07-29 05:42:01','2026-07-30 15:49:33'),
(2,'about','published','2026-07-30 15:49:33','2026-07-29 05:42:02','2026-07-30 15:49:33'),
(3,'work','published','2026-07-30 15:49:33','2026-07-29 05:42:02','2026-07-30 15:49:33'),
(4,'services','published','2026-07-30 15:49:34','2026-07-29 05:42:02','2026-07-30 15:49:34'),
(5,'insights','published','2026-07-30 15:49:34','2026-07-29 05:42:02','2026-07-30 15:49:34'),
(6,'contact','published','2026-07-30 15:49:34','2026-07-29 05:42:02','2026-07-30 15:49:34'),
(7,'privacy-policy','published','2026-07-30 15:49:34','2026-07-29 05:42:02','2026-07-30 15:49:34'),
(8,'terms','published','2026-07-30 15:49:34','2026-07-29 05:42:02','2026-07-30 15:49:34');
/*!40000 ALTER TABLE `pages` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=137 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES
(1,'view_any_page','web','2026-07-29 05:41:58','2026-07-29 05:41:58'),
(2,'view_page','web','2026-07-29 05:41:58','2026-07-29 05:41:58'),
(3,'create_page','web','2026-07-29 05:41:59','2026-07-29 05:41:59'),
(4,'update_page','web','2026-07-29 05:41:59','2026-07-29 05:41:59'),
(5,'update_any_page','web','2026-07-29 05:41:59','2026-07-29 05:41:59'),
(6,'delete_page','web','2026-07-29 05:41:59','2026-07-29 05:41:59'),
(7,'delete_any_page','web','2026-07-29 05:41:59','2026-07-29 05:41:59'),
(8,'restore_page','web','2026-07-29 05:41:59','2026-07-29 05:41:59'),
(9,'view_any_project','web','2026-07-29 05:41:59','2026-07-29 05:41:59'),
(10,'view_project','web','2026-07-29 05:41:59','2026-07-29 05:41:59'),
(11,'create_project','web','2026-07-29 05:41:59','2026-07-29 05:41:59'),
(12,'update_project','web','2026-07-29 05:41:59','2026-07-29 05:41:59'),
(13,'update_any_project','web','2026-07-29 05:41:59','2026-07-29 05:41:59'),
(14,'delete_project','web','2026-07-29 05:41:59','2026-07-29 05:41:59'),
(15,'delete_any_project','web','2026-07-29 05:41:59','2026-07-29 05:41:59'),
(16,'restore_project','web','2026-07-29 05:41:59','2026-07-29 05:41:59'),
(17,'view_any_service','web','2026-07-29 05:41:59','2026-07-29 05:41:59'),
(18,'view_service','web','2026-07-29 05:41:59','2026-07-29 05:41:59'),
(19,'create_service','web','2026-07-29 05:41:59','2026-07-29 05:41:59'),
(20,'update_service','web','2026-07-29 05:41:59','2026-07-29 05:41:59'),
(21,'update_any_service','web','2026-07-29 05:41:59','2026-07-29 05:41:59'),
(22,'delete_service','web','2026-07-29 05:41:59','2026-07-29 05:41:59'),
(23,'delete_any_service','web','2026-07-29 05:41:59','2026-07-29 05:41:59'),
(24,'restore_service','web','2026-07-29 05:41:59','2026-07-29 05:41:59'),
(25,'view_any_post','web','2026-07-29 05:41:59','2026-07-29 05:41:59'),
(26,'view_post','web','2026-07-29 05:41:59','2026-07-29 05:41:59'),
(27,'create_post','web','2026-07-29 05:41:59','2026-07-29 05:41:59'),
(28,'update_post','web','2026-07-29 05:41:59','2026-07-29 05:41:59'),
(29,'update_any_post','web','2026-07-29 05:41:59','2026-07-29 05:41:59'),
(30,'delete_post','web','2026-07-29 05:41:59','2026-07-29 05:41:59'),
(31,'delete_any_post','web','2026-07-29 05:41:59','2026-07-29 05:41:59'),
(32,'restore_post','web','2026-07-29 05:41:59','2026-07-29 05:41:59'),
(33,'view_any_post_category','web','2026-07-29 05:41:59','2026-07-29 05:41:59'),
(34,'view_post_category','web','2026-07-29 05:41:59','2026-07-29 05:41:59'),
(35,'create_post_category','web','2026-07-29 05:41:59','2026-07-29 05:41:59'),
(36,'update_post_category','web','2026-07-29 05:41:59','2026-07-29 05:41:59'),
(37,'update_any_post_category','web','2026-07-29 05:41:59','2026-07-29 05:41:59'),
(38,'delete_post_category','web','2026-07-29 05:41:59','2026-07-29 05:41:59'),
(39,'delete_any_post_category','web','2026-07-29 05:41:59','2026-07-29 05:41:59'),
(40,'restore_post_category','web','2026-07-29 05:41:59','2026-07-29 05:41:59'),
(41,'view_any_post_tag','web','2026-07-29 05:41:59','2026-07-29 05:41:59'),
(42,'view_post_tag','web','2026-07-29 05:41:59','2026-07-29 05:41:59'),
(43,'create_post_tag','web','2026-07-29 05:41:59','2026-07-29 05:41:59'),
(44,'update_post_tag','web','2026-07-29 05:41:59','2026-07-29 05:41:59'),
(45,'update_any_post_tag','web','2026-07-29 05:41:59','2026-07-29 05:41:59'),
(46,'delete_post_tag','web','2026-07-29 05:41:59','2026-07-29 05:41:59'),
(47,'delete_any_post_tag','web','2026-07-29 05:41:59','2026-07-29 05:41:59'),
(48,'restore_post_tag','web','2026-07-29 05:41:59','2026-07-29 05:41:59'),
(49,'view_any_industry','web','2026-07-29 05:41:59','2026-07-29 05:41:59'),
(50,'view_industry','web','2026-07-29 05:41:59','2026-07-29 05:41:59'),
(51,'create_industry','web','2026-07-29 05:41:59','2026-07-29 05:41:59'),
(52,'update_industry','web','2026-07-29 05:41:59','2026-07-29 05:41:59'),
(53,'update_any_industry','web','2026-07-29 05:41:59','2026-07-29 05:41:59'),
(54,'delete_industry','web','2026-07-29 05:41:59','2026-07-29 05:41:59'),
(55,'delete_any_industry','web','2026-07-29 05:41:59','2026-07-29 05:41:59'),
(56,'restore_industry','web','2026-07-29 05:41:59','2026-07-29 05:41:59'),
(57,'view_any_team_member','web','2026-07-29 05:41:59','2026-07-29 05:41:59'),
(58,'view_team_member','web','2026-07-29 05:41:59','2026-07-29 05:41:59'),
(59,'create_team_member','web','2026-07-29 05:41:59','2026-07-29 05:41:59'),
(60,'update_team_member','web','2026-07-29 05:41:59','2026-07-29 05:41:59'),
(61,'update_any_team_member','web','2026-07-29 05:41:59','2026-07-29 05:41:59'),
(62,'delete_team_member','web','2026-07-29 05:41:59','2026-07-29 05:41:59'),
(63,'delete_any_team_member','web','2026-07-29 05:41:59','2026-07-29 05:41:59'),
(64,'restore_team_member','web','2026-07-29 05:41:59','2026-07-29 05:41:59'),
(65,'view_any_testimonial','web','2026-07-29 05:41:59','2026-07-29 05:41:59'),
(66,'view_testimonial','web','2026-07-29 05:41:59','2026-07-29 05:41:59'),
(67,'create_testimonial','web','2026-07-29 05:41:59','2026-07-29 05:41:59'),
(68,'update_testimonial','web','2026-07-29 05:41:59','2026-07-29 05:41:59'),
(69,'update_any_testimonial','web','2026-07-29 05:41:59','2026-07-29 05:41:59'),
(70,'delete_testimonial','web','2026-07-29 05:41:59','2026-07-29 05:41:59'),
(71,'delete_any_testimonial','web','2026-07-29 05:41:59','2026-07-29 05:41:59'),
(72,'restore_testimonial','web','2026-07-29 05:42:00','2026-07-29 05:42:00'),
(73,'view_any_faq','web','2026-07-29 05:42:00','2026-07-29 05:42:00'),
(74,'view_faq','web','2026-07-29 05:42:00','2026-07-29 05:42:00'),
(75,'create_faq','web','2026-07-29 05:42:00','2026-07-29 05:42:00'),
(76,'update_faq','web','2026-07-29 05:42:00','2026-07-29 05:42:00'),
(77,'update_any_faq','web','2026-07-29 05:42:00','2026-07-29 05:42:00'),
(78,'delete_faq','web','2026-07-29 05:42:00','2026-07-29 05:42:00'),
(79,'delete_any_faq','web','2026-07-29 05:42:00','2026-07-29 05:42:00'),
(80,'restore_faq','web','2026-07-29 05:42:00','2026-07-29 05:42:00'),
(81,'view_any_client','web','2026-07-29 05:42:00','2026-07-29 05:42:00'),
(82,'view_client','web','2026-07-29 05:42:00','2026-07-29 05:42:00'),
(83,'create_client','web','2026-07-29 05:42:00','2026-07-29 05:42:00'),
(84,'update_client','web','2026-07-29 05:42:00','2026-07-29 05:42:00'),
(85,'update_any_client','web','2026-07-29 05:42:00','2026-07-29 05:42:00'),
(86,'delete_client','web','2026-07-29 05:42:00','2026-07-29 05:42:00'),
(87,'delete_any_client','web','2026-07-29 05:42:00','2026-07-29 05:42:00'),
(88,'restore_client','web','2026-07-29 05:42:00','2026-07-29 05:42:00'),
(89,'view_any_contact_submission','web','2026-07-29 05:42:00','2026-07-29 05:42:00'),
(90,'view_contact_submission','web','2026-07-29 05:42:00','2026-07-29 05:42:00'),
(91,'create_contact_submission','web','2026-07-29 05:42:00','2026-07-29 05:42:00'),
(92,'update_contact_submission','web','2026-07-29 05:42:00','2026-07-29 05:42:00'),
(93,'update_any_contact_submission','web','2026-07-29 05:42:00','2026-07-29 05:42:00'),
(94,'delete_contact_submission','web','2026-07-29 05:42:00','2026-07-29 05:42:00'),
(95,'delete_any_contact_submission','web','2026-07-29 05:42:00','2026-07-29 05:42:00'),
(96,'restore_contact_submission','web','2026-07-29 05:42:00','2026-07-29 05:42:00'),
(97,'view_any_user','web','2026-07-29 05:42:00','2026-07-29 05:42:00'),
(98,'view_user','web','2026-07-29 05:42:00','2026-07-29 05:42:00'),
(99,'create_user','web','2026-07-29 05:42:00','2026-07-29 05:42:00'),
(100,'update_user','web','2026-07-29 05:42:00','2026-07-29 05:42:00'),
(101,'update_any_user','web','2026-07-29 05:42:00','2026-07-29 05:42:00'),
(102,'delete_user','web','2026-07-29 05:42:00','2026-07-29 05:42:00'),
(103,'delete_any_user','web','2026-07-29 05:42:00','2026-07-29 05:42:00'),
(104,'restore_user','web','2026-07-29 05:42:00','2026-07-29 05:42:00'),
(105,'view_any_menu','web','2026-07-29 05:42:00','2026-07-29 05:42:00'),
(106,'view_menu','web','2026-07-29 05:42:00','2026-07-29 05:42:00'),
(107,'create_menu','web','2026-07-29 05:42:00','2026-07-29 05:42:00'),
(108,'update_menu','web','2026-07-29 05:42:00','2026-07-29 05:42:00'),
(109,'update_any_menu','web','2026-07-29 05:42:00','2026-07-29 05:42:00'),
(110,'delete_menu','web','2026-07-29 05:42:00','2026-07-29 05:42:00'),
(111,'delete_any_menu','web','2026-07-29 05:42:00','2026-07-29 05:42:00'),
(112,'restore_menu','web','2026-07-29 05:42:00','2026-07-29 05:42:00'),
(113,'view_any_social_link','web','2026-07-29 05:42:00','2026-07-29 05:42:00'),
(114,'view_social_link','web','2026-07-29 05:42:00','2026-07-29 05:42:00'),
(115,'create_social_link','web','2026-07-29 05:42:00','2026-07-29 05:42:00'),
(116,'update_social_link','web','2026-07-29 05:42:00','2026-07-29 05:42:00'),
(117,'update_any_social_link','web','2026-07-29 05:42:00','2026-07-29 05:42:00'),
(118,'delete_social_link','web','2026-07-29 05:42:00','2026-07-29 05:42:00'),
(119,'delete_any_social_link','web','2026-07-29 05:42:00','2026-07-29 05:42:00'),
(120,'restore_social_link','web','2026-07-29 05:42:00','2026-07-29 05:42:00'),
(121,'view_any_newsletter_subscription','web','2026-07-29 05:42:00','2026-07-29 05:42:00'),
(122,'view_newsletter_subscription','web','2026-07-29 05:42:00','2026-07-29 05:42:00'),
(123,'create_newsletter_subscription','web','2026-07-29 05:42:01','2026-07-29 05:42:01'),
(124,'update_newsletter_subscription','web','2026-07-29 05:42:01','2026-07-29 05:42:01'),
(125,'update_any_newsletter_subscription','web','2026-07-29 05:42:01','2026-07-29 05:42:01'),
(126,'delete_newsletter_subscription','web','2026-07-29 05:42:01','2026-07-29 05:42:01'),
(127,'delete_any_newsletter_subscription','web','2026-07-29 05:42:01','2026-07-29 05:42:01'),
(128,'restore_newsletter_subscription','web','2026-07-29 05:42:01','2026-07-29 05:42:01'),
(129,'view_any_redirect','web','2026-07-29 05:42:01','2026-07-29 05:42:01'),
(130,'view_redirect','web','2026-07-29 05:42:01','2026-07-29 05:42:01'),
(131,'create_redirect','web','2026-07-29 05:42:01','2026-07-29 05:42:01'),
(132,'update_redirect','web','2026-07-29 05:42:01','2026-07-29 05:42:01'),
(133,'update_any_redirect','web','2026-07-29 05:42:01','2026-07-29 05:42:01'),
(134,'delete_redirect','web','2026-07-29 05:42:01','2026-07-29 05:42:01'),
(135,'delete_any_redirect','web','2026-07-29 05:42:01','2026-07-29 05:42:01'),
(136,'restore_redirect','web','2026-07-29 05:42:01','2026-07-29 05:42:01');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `post_categories`
--

DROP TABLE IF EXISTS `post_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `post_categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `sort_order` smallint(5) unsigned NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post_categories`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `post_categories` WRITE;
/*!40000 ALTER TABLE `post_categories` DISABLE KEYS */;
INSERT INTO `post_categories` VALUES
(1,0,'2026-07-29 05:42:01','2026-07-29 05:42:01'),
(2,1,'2026-07-29 05:42:01','2026-07-29 05:42:01'),
(3,2,'2026-07-29 05:42:01','2026-07-29 05:42:01'),
(4,3,'2026-07-29 05:42:01','2026-07-29 05:42:01');
/*!40000 ALTER TABLE `post_categories` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `post_category_translations`
--

DROP TABLE IF EXISTS `post_category_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `post_category_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_category_id` bigint(20) unsigned NOT NULL,
  `locale` varchar(5) NOT NULL,
  `name` varchar(150) NOT NULL,
  `slug` varchar(150) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `post_category_translations_unique` (`post_category_id`,`locale`),
  UNIQUE KEY `post_category_translations_slug_unique` (`locale`,`slug`),
  KEY `post_category_translations_locale_index` (`locale`),
  CONSTRAINT `post_category_translations_post_category_id_foreign` FOREIGN KEY (`post_category_id`) REFERENCES `post_categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post_category_translations`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `post_category_translations` WRITE;
/*!40000 ALTER TABLE `post_category_translations` DISABLE KEYS */;
INSERT INTO `post_category_translations` VALUES
(1,1,'en','Branding','branding','2026-07-29 05:42:01','2026-07-29 05:42:01'),
(2,1,'fa','برندینگ','برندینگ','2026-07-29 05:42:01','2026-07-29 05:42:01'),
(3,1,'ar','الهوية','الهوية','2026-07-29 05:42:01','2026-07-29 05:42:01'),
(4,2,'en','Marketing Design','marketing-design','2026-07-29 05:42:01','2026-07-29 05:42:01'),
(5,2,'fa','طراحی بازاریابی','طراحی-بازاریابی','2026-07-29 05:42:01','2026-07-29 05:42:01'),
(6,2,'ar','تصميم التسويق','تصميم-التسويق','2026-07-29 05:42:01','2026-07-29 05:42:01'),
(7,3,'en','Content Production','content-production','2026-07-29 05:42:01','2026-07-29 05:42:01'),
(8,3,'fa','تولید محتوا','تولید-محتوا','2026-07-29 05:42:01','2026-07-29 05:42:01'),
(9,3,'ar','إنتاج المحتوى','إنتاج-المحتوى','2026-07-29 05:42:01','2026-07-29 05:42:01'),
(10,4,'en','Social Media Support','social-media-support','2026-07-29 05:42:01','2026-07-29 05:42:01'),
(11,4,'fa','پشتیبانی شبکه‌های اجتماعی','پشتیبانی-شبکه‌های-اجتماعی','2026-07-29 05:42:01','2026-07-29 05:42:01'),
(12,4,'ar','دعم وسائل التواصل','دعم-وسائل-التواصل','2026-07-29 05:42:01','2026-07-29 05:42:01');
/*!40000 ALTER TABLE `post_category_translations` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `post_post_tag`
--

DROP TABLE IF EXISTS `post_post_tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `post_post_tag` (
  `post_id` bigint(20) unsigned NOT NULL,
  `post_tag_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`post_id`,`post_tag_id`),
  KEY `post_post_tag_post_tag_id_index` (`post_tag_id`),
  CONSTRAINT `post_post_tag_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `post_post_tag_post_tag_id_foreign` FOREIGN KEY (`post_tag_id`) REFERENCES `post_tags` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post_post_tag`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `post_post_tag` WRITE;
/*!40000 ALTER TABLE `post_post_tag` DISABLE KEYS */;
/*!40000 ALTER TABLE `post_post_tag` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `post_tag_translations`
--

DROP TABLE IF EXISTS `post_tag_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `post_tag_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_tag_id` bigint(20) unsigned NOT NULL,
  `locale` varchar(5) NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `post_tag_translations_unique` (`post_tag_id`,`locale`),
  UNIQUE KEY `post_tag_translations_slug_unique` (`locale`,`slug`),
  CONSTRAINT `post_tag_translations_post_tag_id_foreign` FOREIGN KEY (`post_tag_id`) REFERENCES `post_tags` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post_tag_translations`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `post_tag_translations` WRITE;
/*!40000 ALTER TABLE `post_tag_translations` DISABLE KEYS */;
/*!40000 ALTER TABLE `post_tag_translations` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `post_tags`
--

DROP TABLE IF EXISTS `post_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `post_tags` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post_tags`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `post_tags` WRITE;
/*!40000 ALTER TABLE `post_tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `post_tags` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `post_translations`
--

DROP TABLE IF EXISTS `post_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `post_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` bigint(20) unsigned NOT NULL,
  `locale` varchar(5) NOT NULL,
  `title` varchar(250) NOT NULL,
  `slug` varchar(250) NOT NULL,
  `subtitle` varchar(300) DEFAULT NULL,
  `excerpt` text DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `seo_title` varchar(200) DEFAULT NULL,
  `seo_description` varchar(300) DEFAULT NULL,
  `cover_alt` varchar(300) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `post_translations_unique` (`post_id`,`locale`),
  UNIQUE KEY `post_translations_slug_unique` (`locale`,`slug`),
  KEY `post_translations_locale_index` (`locale`),
  CONSTRAINT `post_translations_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post_translations`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `post_translations` WRITE;
/*!40000 ALTER TABLE `post_translations` DISABLE KEYS */;
INSERT INTO `post_translations` VALUES
(1,1,'en','What Happens When You Create Content Without Direction?','content-without-direction','Without direction, your content loses focus and fails to drive real growth','Without direction, your content loses focus and fails to drive real growth.','<h3>Most brands don\'t struggle with creating content, They struggle with creating direction</h3>\n<p>At first, everything feels like progress; content is being produced, pages are active, and the brand appears present across platforms, but after a while, something subtle starts to shift, and despite all the activity, the brand itself doesn\'t feel like it is actually moving forward in a meaningful way.</p>\n<h3>Content without direction becomes noise</h3>\n<p>When content is created without a defined strategic direction, every individual piece starts to exist in isolation, where posts, campaigns, and ideas may look visually acceptable on their own but fail to connect into a larger and recognizable narrative.</p>\n<p>Over time, this creates a situation where the audience is exposed to content that feels scattered and disconnected, and although the brand is visible, it is no longer memorable or structured in a way that builds long-term perception.</p>\n<h3>You stay busy, but your brand stays still</h3>\n<p>One of the most common misunderstandings in marketing is assuming that constant activity automatically leads to growth, while in reality, publishing frequently without a guiding framework only creates the illusion of progress rather than actual strategic movement.</p>\n<p>You end up investing more time, more energy, and more resources into content production, but because there is no unified direction shaping these efforts, the brand identity remains unclear and fragmented in the mind of the audience.</p>\n<h3>Without direction, your message changes every time you speak</h3>\n<p>When there is no clear strategic foundation, every new piece of content tries to independently define its own purpose, which results in shifting tones, inconsistent messaging, and visuals that may not align with each other in any meaningful way.</p>\n<p>As this continues over time, the audience is exposed to multiple versions of the brand that do not fully connect, and instead of building clarity and trust, this inconsistency gradually creates confusion and weakens the overall perception of the brand.</p>\n<h3>Final Thoughts</h3>\n<p>Content without direction doesn\'t fail because it\'s bad, it fails because it\'s incomplete. Real growth starts when content becomes part of a clear system.</p>',NULL,NULL,NULL,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(2,1,'fa','وقتی بدون جهت محتوا می‌سازید چه اتفاقی می‌افتد؟','محتوا-بدون-جهت','بدون جهت، محتوای شما تمرکز خود را از دست می‌دهد','بدون جهت، محتوای شما تمرکز خود را از دست می‌دهد و رشد واقعی ایجاد نمی‌کند.','<h3>بیشتر برندها در تولید محتوا مشکل ندارند، در ساخت جهت مشکل دارند</h3>\n<p>در نگاه اول همه‌چیز شبیه پیشرفت است؛ محتوا تولید می‌شود، صفحات فعال‌اند و برند در پلتفرم‌ها حاضر است، اما پس از مدتی چیزی ظریف تغییر می‌کند و با وجود همه فعالیت، برند احساس نمی‌کند واقعاً در مسیر معناداری پیش می‌رود.</p>\n<h3>محتوا بدون جهت، به نویز تبدیل می‌شود</h3>\n<p>وقتی محتوا بدون جهت استراتژیک مشخصی ساخته می‌شود، هر قطعه به‌تنهایی وجود دارد؛ پست‌ها و کمپین‌ها ممکن است به‌تنهایی قابل قبول باشند اما به روایتی بزرگ‌تر و قابل تشخیص متصل نمی‌شوند.</p>\n<p>با گذر زمان، مخاطب با محتوایی پراکنده و ناهماهنگ روبه‌رو می‌شود و اگرچه برند دیده می‌شود، دیگر به‌یادماندنی یا ساختارمند نیست.</p>\n<h3>شما مشغولید، اما برندتان ثابت می‌ماند</h3>\n<p>یکی از رایج‌ترین سوءتفاهم‌ها در بازاریابی این باور است که فعالیت مداوم به‌خودی‌خود به رشد منجر می‌شود، در حالی‌که انتشار مکرر بدون چارچوب راهنما تنها توهم پیشرفت می‌سازد، نه حرکت استراتژیک واقعی.</p>\n<p>شما زمان و انرژی بیشتری صرف تولید محتوا می‌کنید، اما چون جهت یکپارچه‌ای این تلاش‌ها را شکل نمی‌دهد، هویت برند در ذهن مخاطب مبهم و پراکنده باقی می‌ماند.</p>\n<h3>بدون جهت، پیام شما هر بار تغییر می‌کند</h3>\n<p>وقتی بنیان استراتژیک شفافی وجود ندارد، هر قطعه محتوای تازه سعی می‌کند هدف خود را مستقل تعریف کند که به لحن‌های متغیر و پیام‌رسانی ناهماهنگ می‌انجامد.</p>\n<p>با ادامه این روند، مخاطب با نسخه‌های متعددی از برند روبه‌رو می‌شود که کاملاً به هم متصل نیستند و به‌جای شفافیت و اعتماد، این ناهماهنگی به‌تدریج ادراک کلی برند را تضعیف می‌کند.</p>\n<h3>سخن پایانی</h3>\n<p>محتوای بدون جهت شکست نمی‌خورد چون بد است، شکست می‌خورد چون ناقص است. رشد واقعی زمانی آغاز می‌شود که محتوا بخشی از یک سیستم شفاف شود.</p>',NULL,NULL,NULL,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(3,1,'ar','ماذا يحدث عندما تنشئ محتوى بلا اتجاه؟','محتوى-بلا-اتجاه','بلا اتجاه، يفقد محتواك تركيزه','بلا اتجاه، يفقد محتواك تركيزه ويفشل في دفع نمو حقيقي.','<h3>معظم العلامات لا تواجه صعوبة في إنتاج المحتوى، بل في صنع الاتجاه</h3>\n<p>في البداية يبدو كل شيء وكأنه تقدم؛ يُنتج المحتوى وتكون الصفحات نشطة وتظهر العلامة حاضرة عبر المنصات، لكن بعد فترة يبدأ شيء خفي بالتغير، وعلى الرغم من كل النشاط لا تشعر العلامة بأنها تتقدم فعلياً بشكل ذي معنى.</p>\n<h3>المحتوى بلا اتجاه يصبح ضجيجاً</h3>\n<p>عندما يُنشأ المحتوى دون اتجاه استراتيجي محدد، تبدأ كل قطعة بالوجود بمعزل عن غيرها، حيث قد تبدو المنشورات والحملات مقبولة بصرياً بمفردها لكنها تفشل في التواصل ضمن سردية أكبر يمكن التعرف عليها.</p>\n<p>مع مرور الوقت، يتعرض الجمهور لمحتوى يبدو مبعثراً ومنفصلاً، ورغم أن العلامة مرئية إلا أنها لم تعد لا تُنسى أو منظمة بطريقة تبني إدراكاً طويل الأمد.</p>\n<h3>تبقى مشغولاً، لكن علامتك تبقى ثابتة</h3>\n<p>من أكثر سوء الفهم شيوعاً في التسويق افتراض أن النشاط المستمر يؤدي تلقائياً إلى النمو، بينما في الواقع النشر المتكرر دون إطار موجه يخلق وهم التقدم فقط لا حركة استراتيجية فعلية.</p>\n<p>تنتهي باستثمار وقت وطاقة وموارد أكثر في إنتاج المحتوى، لكن نظراً لعدم وجود اتجاه موحد يشكّل هذه الجهود، تبقى هوية العلامة غامضة ومجزأة في ذهن الجمهور.</p>\n<h3>بلا اتجاه، تتغير رسالتك في كل مرة تتحدث فيها</h3>\n<p>عندما لا يوجد أساس استراتيجي واضح، تحاول كل قطعة محتوى جديدة تعريف غرضها الخاص بشكل مستقل، مما يؤدي إلى نبرات متغيرة ورسائل غير متسقة ومرئيات قد لا تتوافق مع بعضها بأي شكل ذي معنى.</p>\n<p>مع استمرار هذا، يتعرض الجمهور لنسخ متعددة من العلامة لا تتصل ببعضها بالكامل، وبدلاً من بناء الوضوح والثقة، يخلق هذا التضارب ارتباكاً تدريجياً يضعف الإدراك العام للعلامة.</p>\n<h3>خواطر ختامية</h3>\n<p>المحتوى بلا اتجاه لا يفشل لأنه سيئ، بل لأنه غير مكتمل. يبدأ النمو الحقيقي عندما يصبح المحتوى جزءاً من نظام واضح.</p>',NULL,NULL,NULL,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(4,2,'en','How to Turn Social Media Into a Growth System','social-media-growth-system','From scattered posts to a predictable engine','From scattered posts and inconsistent messaging to a structured growth system that turns your social media into a predictable engine for attracting the right audience.','<h3>Most brands don\'t struggle with creating content, They struggle with creating direction</h3><p>At first, everything feels like progress; content is being produced, pages are active, and the brand appears present across platforms, but after a while, something subtle starts to shift, and despite all the activity, the brand itself doesn\'t feel like it is actually moving forward in a meaningful way.</p><h3>Content without direction becomes noise</h3><p>When content is created without a defined strategic direction, every individual piece starts to exist in isolation, where posts, campaigns, and ideas may look visually acceptable on their own but fail to connect into a larger and recognizable narrative.</p><p>Over time, this creates a situation where the audience is exposed to content that feels scattered and disconnected, and although the brand is visible, it is no longer memorable or structured in a way that builds long-term perception.<br><br><br>[[lead_magnet]]</p><h3>You stay busy, but your brand stays still</h3><p>One of the most common misunderstandings in marketing is assuming that constant activity automatically leads to growth, while in reality, publishing frequently without a guiding framework only creates the illusion of progress rather than actual strategic movement.</p><p>You end up investing more time, more energy, and more resources into content production, but because there is no unified direction shaping these efforts, the brand identity remains unclear and fragmented in the mind of the audience.</p><h3>Without direction, your message changes every time you speak</h3><p>When there is no clear strategic foundation, every new piece of content tries to independently define its own purpose, which results in shifting tones, inconsistent messaging, and visuals that may not align with each other in any meaningful way.</p><p>As this continues over time, the audience is exposed to multiple versions of the brand that do not fully connect, and instead of building clarity and trust, this inconsistency gradually creates confusion and weakens the overall perception of the brand.</p><p><br></p><p>[[lead_magnet]]</p><h3>Final Thoughts</h3><p>Content without direction doesn\'t fail because it\'s bad, it fails because it\'s incomplete. Real growth starts when content becomes part of a clear system.</p>',NULL,NULL,NULL,'2026-07-29 05:42:02','2026-07-30 18:12:01'),
(5,2,'fa','چگونه شبکه‌های اجتماعی را به یک سیستم رشد تبدیل کنیم','سیستم-رشد-شبکه-اجتماعی','از پست‌های پراکنده تا موتوری قابل پیش‌بینی','از پست‌های پراکنده و پیام‌رسانی ناهماهنگ تا سیستمی ساختارمند که شبکه‌های اجتماعی شما را به موتوری قابل پیش‌بینی تبدیل می‌کند.','<h3>بیشتر برندها در تولید محتوا مشکل ندارند، در ساخت جهت مشکل دارند</h3>\n<p>در نگاه اول همه‌چیز شبیه پیشرفت است؛ محتوا تولید می‌شود، صفحات فعال‌اند و برند در پلتفرم‌ها حاضر است، اما پس از مدتی چیزی ظریف تغییر می‌کند و با وجود همه فعالیت، برند احساس نمی‌کند واقعاً در مسیر معناداری پیش می‌رود.</p>\n<h3>محتوا بدون جهت، به نویز تبدیل می‌شود</h3>\n<p>وقتی محتوا بدون جهت استراتژیک مشخصی ساخته می‌شود، هر قطعه به‌تنهایی وجود دارد؛ پست‌ها و کمپین‌ها ممکن است به‌تنهایی قابل قبول باشند اما به روایتی بزرگ‌تر و قابل تشخیص متصل نمی‌شوند.</p>\n<p>با گذر زمان، مخاطب با محتوایی پراکنده و ناهماهنگ روبه‌رو می‌شود و اگرچه برند دیده می‌شود، دیگر به‌یادماندنی یا ساختارمند نیست.</p>\n<h3>شما مشغولید، اما برندتان ثابت می‌ماند</h3>\n<p>یکی از رایج‌ترین سوءتفاهم‌ها در بازاریابی این باور است که فعالیت مداوم به‌خودی‌خود به رشد منجر می‌شود، در حالی‌که انتشار مکرر بدون چارچوب راهنما تنها توهم پیشرفت می‌سازد، نه حرکت استراتژیک واقعی.</p>\n<p>شما زمان و انرژی بیشتری صرف تولید محتوا می‌کنید، اما چون جهت یکپارچه‌ای این تلاش‌ها را شکل نمی‌دهد، هویت برند در ذهن مخاطب مبهم و پراکنده باقی می‌ماند.</p>\n<h3>بدون جهت، پیام شما هر بار تغییر می‌کند</h3>\n<p>وقتی بنیان استراتژیک شفافی وجود ندارد، هر قطعه محتوای تازه سعی می‌کند هدف خود را مستقل تعریف کند که به لحن‌های متغیر و پیام‌رسانی ناهماهنگ می‌انجامد.</p>\n<p>با ادامه این روند، مخاطب با نسخه‌های متعددی از برند روبه‌رو می‌شود که کاملاً به هم متصل نیستند و به‌جای شفافیت و اعتماد، این ناهماهنگی به‌تدریج ادراک کلی برند را تضعیف می‌کند.</p>\n<h3>سخن پایانی</h3>\n<p>محتوای بدون جهت شکست نمی‌خورد چون بد است، شکست می‌خورد چون ناقص است. رشد واقعی زمانی آغاز می‌شود که محتوا بخشی از یک سیستم شفاف شود.</p>',NULL,NULL,NULL,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(6,2,'ar','كيف تحوّل وسائل التواصل إلى نظام نمو','نظام-نمو-وسائل-التواصل','من منشورات مبعثرة إلى محرك يمكن التنبؤ به','من منشورات مبعثرة ورسائل غير متسقة إلى نظام نمو منظم يحول وسائل التواصل لديك إلى محرك يمكن التنبؤ به.','<h3>معظم العلامات لا تواجه صعوبة في إنتاج المحتوى، بل في صنع الاتجاه</h3>\n<p>في البداية يبدو كل شيء وكأنه تقدم؛ يُنتج المحتوى وتكون الصفحات نشطة وتظهر العلامة حاضرة عبر المنصات، لكن بعد فترة يبدأ شيء خفي بالتغير، وعلى الرغم من كل النشاط لا تشعر العلامة بأنها تتقدم فعلياً بشكل ذي معنى.</p>\n<h3>المحتوى بلا اتجاه يصبح ضجيجاً</h3>\n<p>عندما يُنشأ المحتوى دون اتجاه استراتيجي محدد، تبدأ كل قطعة بالوجود بمعزل عن غيرها، حيث قد تبدو المنشورات والحملات مقبولة بصرياً بمفردها لكنها تفشل في التواصل ضمن سردية أكبر يمكن التعرف عليها.</p>\n<p>مع مرور الوقت، يتعرض الجمهور لمحتوى يبدو مبعثراً ومنفصلاً، ورغم أن العلامة مرئية إلا أنها لم تعد لا تُنسى أو منظمة بطريقة تبني إدراكاً طويل الأمد.</p>\n<h3>تبقى مشغولاً، لكن علامتك تبقى ثابتة</h3>\n<p>من أكثر سوء الفهم شيوعاً في التسويق افتراض أن النشاط المستمر يؤدي تلقائياً إلى النمو، بينما في الواقع النشر المتكرر دون إطار موجه يخلق وهم التقدم فقط لا حركة استراتيجية فعلية.</p>\n<p>تنتهي باستثمار وقت وطاقة وموارد أكثر في إنتاج المحتوى، لكن نظراً لعدم وجود اتجاه موحد يشكّل هذه الجهود، تبقى هوية العلامة غامضة ومجزأة في ذهن الجمهور.</p>\n<h3>بلا اتجاه، تتغير رسالتك في كل مرة تتحدث فيها</h3>\n<p>عندما لا يوجد أساس استراتيجي واضح، تحاول كل قطعة محتوى جديدة تعريف غرضها الخاص بشكل مستقل، مما يؤدي إلى نبرات متغيرة ورسائل غير متسقة ومرئيات قد لا تتوافق مع بعضها بأي شكل ذي معنى.</p>\n<p>مع استمرار هذا، يتعرض الجمهور لنسخ متعددة من العلامة لا تتصل ببعضها بالكامل، وبدلاً من بناء الوضوح والثقة، يخلق هذا التضارب ارتباكاً تدريجياً يضعف الإدراك العام للعلامة.</p>\n<h3>خواطر ختامية</h3>\n<p>المحتوى بلا اتجاه لا يفشل لأنه سيئ، بل لأنه غير مكتمل. يبدأ النمو الحقيقي عندما يصبح المحتوى جزءاً من نظام واضح.</p>',NULL,NULL,NULL,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(7,3,'en','What Happens When You Create Content Without Direction?','brand-direction-3','Clear direction turns activity into meaningful growth','A practical look at how strategy creates consistency, clarity, and stronger brand growth.','<h3>Most brands don\'t struggle with creating content, They struggle with creating direction</h3>\n<p>At first, everything feels like progress; content is being produced, pages are active, and the brand appears present across platforms, but after a while, something subtle starts to shift, and despite all the activity, the brand itself doesn\'t feel like it is actually moving forward in a meaningful way.</p>\n<h3>Content without direction becomes noise</h3>\n<p>When content is created without a defined strategic direction, every individual piece starts to exist in isolation, where posts, campaigns, and ideas may look visually acceptable on their own but fail to connect into a larger and recognizable narrative.</p>\n<p>Over time, this creates a situation where the audience is exposed to content that feels scattered and disconnected, and although the brand is visible, it is no longer memorable or structured in a way that builds long-term perception.</p>\n<h3>You stay busy, but your brand stays still</h3>\n<p>One of the most common misunderstandings in marketing is assuming that constant activity automatically leads to growth, while in reality, publishing frequently without a guiding framework only creates the illusion of progress rather than actual strategic movement.</p>\n<p>You end up investing more time, more energy, and more resources into content production, but because there is no unified direction shaping these efforts, the brand identity remains unclear and fragmented in the mind of the audience.</p>\n<h3>Without direction, your message changes every time you speak</h3>\n<p>When there is no clear strategic foundation, every new piece of content tries to independently define its own purpose, which results in shifting tones, inconsistent messaging, and visuals that may not align with each other in any meaningful way.</p>\n<p>As this continues over time, the audience is exposed to multiple versions of the brand that do not fully connect, and instead of building clarity and trust, this inconsistency gradually creates confusion and weakens the overall perception of the brand.</p>\n<h3>Final Thoughts</h3>\n<p>Content without direction doesn\'t fail because it\'s bad, it fails because it\'s incomplete. Real growth starts when content becomes part of a clear system.</p>',NULL,NULL,NULL,'2026-07-30 17:26:01','2026-07-30 17:26:01'),
(8,3,'fa','وقتی بدون جهت محتوا می‌سازید چه اتفاقی می‌افتد؟','brand-direction-3','جهت شفاف، فعالیت را به رشد معنادار تبدیل می‌کند','نگاهی کاربردی به نقش استراتژی در انسجام، شفافیت و رشد قوی‌تر برند.','<h3>بیشتر برندها در تولید محتوا مشکل ندارند، در ساخت جهت مشکل دارند</h3>\n<p>در نگاه اول همه‌چیز شبیه پیشرفت است؛ محتوا تولید می‌شود، صفحات فعال‌اند و برند در پلتفرم‌ها حاضر است، اما پس از مدتی چیزی ظریف تغییر می‌کند و با وجود همه فعالیت، برند احساس نمی‌کند واقعاً در مسیر معناداری پیش می‌رود.</p>\n<h3>محتوا بدون جهت، به نویز تبدیل می‌شود</h3>\n<p>وقتی محتوا بدون جهت استراتژیک مشخصی ساخته می‌شود، هر قطعه به‌تنهایی وجود دارد؛ پست‌ها و کمپین‌ها ممکن است به‌تنهایی قابل قبول باشند اما به روایتی بزرگ‌تر و قابل تشخیص متصل نمی‌شوند.</p>\n<p>با گذر زمان، مخاطب با محتوایی پراکنده و ناهماهنگ روبه‌رو می‌شود و اگرچه برند دیده می‌شود، دیگر به‌یادماندنی یا ساختارمند نیست.</p>\n<h3>شما مشغولید، اما برندتان ثابت می‌ماند</h3>\n<p>یکی از رایج‌ترین سوءتفاهم‌ها در بازاریابی این باور است که فعالیت مداوم به‌خودی‌خود به رشد منجر می‌شود، در حالی‌که انتشار مکرر بدون چارچوب راهنما تنها توهم پیشرفت می‌سازد، نه حرکت استراتژیک واقعی.</p>\n<p>شما زمان و انرژی بیشتری صرف تولید محتوا می‌کنید، اما چون جهت یکپارچه‌ای این تلاش‌ها را شکل نمی‌دهد، هویت برند در ذهن مخاطب مبهم و پراکنده باقی می‌ماند.</p>\n<h3>بدون جهت، پیام شما هر بار تغییر می‌کند</h3>\n<p>وقتی بنیان استراتژیک شفافی وجود ندارد، هر قطعه محتوای تازه سعی می‌کند هدف خود را مستقل تعریف کند که به لحن‌های متغیر و پیام‌رسانی ناهماهنگ می‌انجامد.</p>\n<p>با ادامه این روند، مخاطب با نسخه‌های متعددی از برند روبه‌رو می‌شود که کاملاً به هم متصل نیستند و به‌جای شفافیت و اعتماد، این ناهماهنگی به‌تدریج ادراک کلی برند را تضعیف می‌کند.</p>\n<h3>سخن پایانی</h3>\n<p>محتوای بدون جهت شکست نمی‌خورد چون بد است، شکست می‌خورد چون ناقص است. رشد واقعی زمانی آغاز می‌شود که محتوا بخشی از یک سیستم شفاف شود.</p>',NULL,NULL,NULL,'2026-07-30 17:26:01','2026-07-30 17:26:01'),
(9,3,'ar','ماذا يحدث عندما تنشئ محتوى بلا اتجاه؟','brand-direction-3','الاتجاه الواضح يحوّل النشاط إلى نمو هادف','نظرة عملية على دور الاستراتيجية في الاتساق والوضوح ونمو العلامة.','<h3>معظم العلامات لا تواجه صعوبة في إنتاج المحتوى، بل في صنع الاتجاه</h3>\n<p>في البداية يبدو كل شيء وكأنه تقدم؛ يُنتج المحتوى وتكون الصفحات نشطة وتظهر العلامة حاضرة عبر المنصات، لكن بعد فترة يبدأ شيء خفي بالتغير، وعلى الرغم من كل النشاط لا تشعر العلامة بأنها تتقدم فعلياً بشكل ذي معنى.</p>\n<h3>المحتوى بلا اتجاه يصبح ضجيجاً</h3>\n<p>عندما يُنشأ المحتوى دون اتجاه استراتيجي محدد، تبدأ كل قطعة بالوجود بمعزل عن غيرها، حيث قد تبدو المنشورات والحملات مقبولة بصرياً بمفردها لكنها تفشل في التواصل ضمن سردية أكبر يمكن التعرف عليها.</p>\n<p>مع مرور الوقت، يتعرض الجمهور لمحتوى يبدو مبعثراً ومنفصلاً، ورغم أن العلامة مرئية إلا أنها لم تعد لا تُنسى أو منظمة بطريقة تبني إدراكاً طويل الأمد.</p>\n<h3>تبقى مشغولاً، لكن علامتك تبقى ثابتة</h3>\n<p>من أكثر سوء الفهم شيوعاً في التسويق افتراض أن النشاط المستمر يؤدي تلقائياً إلى النمو، بينما في الواقع النشر المتكرر دون إطار موجه يخلق وهم التقدم فقط لا حركة استراتيجية فعلية.</p>\n<p>تنتهي باستثمار وقت وطاقة وموارد أكثر في إنتاج المحتوى، لكن نظراً لعدم وجود اتجاه موحد يشكّل هذه الجهود، تبقى هوية العلامة غامضة ومجزأة في ذهن الجمهور.</p>\n<h3>بلا اتجاه، تتغير رسالتك في كل مرة تتحدث فيها</h3>\n<p>عندما لا يوجد أساس استراتيجي واضح، تحاول كل قطعة محتوى جديدة تعريف غرضها الخاص بشكل مستقل، مما يؤدي إلى نبرات متغيرة ورسائل غير متسقة ومرئيات قد لا تتوافق مع بعضها بأي شكل ذي معنى.</p>\n<p>مع استمرار هذا، يتعرض الجمهور لنسخ متعددة من العلامة لا تتصل ببعضها بالكامل، وبدلاً من بناء الوضوح والثقة، يخلق هذا التضارب ارتباكاً تدريجياً يضعف الإدراك العام للعلامة.</p>\n<h3>خواطر ختامية</h3>\n<p>المحتوى بلا اتجاه لا يفشل لأنه سيئ، بل لأنه غير مكتمل. يبدأ النمو الحقيقي عندما يصبح المحتوى جزءاً من نظام واضح.</p>',NULL,NULL,NULL,'2026-07-30 17:26:01','2026-07-30 17:26:01'),
(10,4,'en','What Happens When You Create Content Without Direction?','brand-direction-4','Clear direction turns activity into meaningful growth','A practical look at how strategy creates consistency, clarity, and stronger brand growth.','<h3>Most brands don\'t struggle with creating content, They struggle with creating direction</h3>\n<p>At first, everything feels like progress; content is being produced, pages are active, and the brand appears present across platforms, but after a while, something subtle starts to shift, and despite all the activity, the brand itself doesn\'t feel like it is actually moving forward in a meaningful way.</p>\n<h3>Content without direction becomes noise</h3>\n<p>When content is created without a defined strategic direction, every individual piece starts to exist in isolation, where posts, campaigns, and ideas may look visually acceptable on their own but fail to connect into a larger and recognizable narrative.</p>\n<p>Over time, this creates a situation where the audience is exposed to content that feels scattered and disconnected, and although the brand is visible, it is no longer memorable or structured in a way that builds long-term perception.</p>\n<h3>You stay busy, but your brand stays still</h3>\n<p>One of the most common misunderstandings in marketing is assuming that constant activity automatically leads to growth, while in reality, publishing frequently without a guiding framework only creates the illusion of progress rather than actual strategic movement.</p>\n<p>You end up investing more time, more energy, and more resources into content production, but because there is no unified direction shaping these efforts, the brand identity remains unclear and fragmented in the mind of the audience.</p>\n<h3>Without direction, your message changes every time you speak</h3>\n<p>When there is no clear strategic foundation, every new piece of content tries to independently define its own purpose, which results in shifting tones, inconsistent messaging, and visuals that may not align with each other in any meaningful way.</p>\n<p>As this continues over time, the audience is exposed to multiple versions of the brand that do not fully connect, and instead of building clarity and trust, this inconsistency gradually creates confusion and weakens the overall perception of the brand.</p>\n<h3>Final Thoughts</h3>\n<p>Content without direction doesn\'t fail because it\'s bad, it fails because it\'s incomplete. Real growth starts when content becomes part of a clear system.</p>',NULL,NULL,NULL,'2026-07-30 17:26:01','2026-07-30 17:26:01'),
(11,4,'fa','وقتی بدون جهت محتوا می‌سازید چه اتفاقی می‌افتد؟','brand-direction-4','جهت شفاف، فعالیت را به رشد معنادار تبدیل می‌کند','نگاهی کاربردی به نقش استراتژی در انسجام، شفافیت و رشد قوی‌تر برند.','<h3>بیشتر برندها در تولید محتوا مشکل ندارند، در ساخت جهت مشکل دارند</h3>\n<p>در نگاه اول همه‌چیز شبیه پیشرفت است؛ محتوا تولید می‌شود، صفحات فعال‌اند و برند در پلتفرم‌ها حاضر است، اما پس از مدتی چیزی ظریف تغییر می‌کند و با وجود همه فعالیت، برند احساس نمی‌کند واقعاً در مسیر معناداری پیش می‌رود.</p>\n<h3>محتوا بدون جهت، به نویز تبدیل می‌شود</h3>\n<p>وقتی محتوا بدون جهت استراتژیک مشخصی ساخته می‌شود، هر قطعه به‌تنهایی وجود دارد؛ پست‌ها و کمپین‌ها ممکن است به‌تنهایی قابل قبول باشند اما به روایتی بزرگ‌تر و قابل تشخیص متصل نمی‌شوند.</p>\n<p>با گذر زمان، مخاطب با محتوایی پراکنده و ناهماهنگ روبه‌رو می‌شود و اگرچه برند دیده می‌شود، دیگر به‌یادماندنی یا ساختارمند نیست.</p>\n<h3>شما مشغولید، اما برندتان ثابت می‌ماند</h3>\n<p>یکی از رایج‌ترین سوءتفاهم‌ها در بازاریابی این باور است که فعالیت مداوم به‌خودی‌خود به رشد منجر می‌شود، در حالی‌که انتشار مکرر بدون چارچوب راهنما تنها توهم پیشرفت می‌سازد، نه حرکت استراتژیک واقعی.</p>\n<p>شما زمان و انرژی بیشتری صرف تولید محتوا می‌کنید، اما چون جهت یکپارچه‌ای این تلاش‌ها را شکل نمی‌دهد، هویت برند در ذهن مخاطب مبهم و پراکنده باقی می‌ماند.</p>\n<h3>بدون جهت، پیام شما هر بار تغییر می‌کند</h3>\n<p>وقتی بنیان استراتژیک شفافی وجود ندارد، هر قطعه محتوای تازه سعی می‌کند هدف خود را مستقل تعریف کند که به لحن‌های متغیر و پیام‌رسانی ناهماهنگ می‌انجامد.</p>\n<p>با ادامه این روند، مخاطب با نسخه‌های متعددی از برند روبه‌رو می‌شود که کاملاً به هم متصل نیستند و به‌جای شفافیت و اعتماد، این ناهماهنگی به‌تدریج ادراک کلی برند را تضعیف می‌کند.</p>\n<h3>سخن پایانی</h3>\n<p>محتوای بدون جهت شکست نمی‌خورد چون بد است، شکست می‌خورد چون ناقص است. رشد واقعی زمانی آغاز می‌شود که محتوا بخشی از یک سیستم شفاف شود.</p>',NULL,NULL,NULL,'2026-07-30 17:26:01','2026-07-30 17:26:01'),
(12,4,'ar','ماذا يحدث عندما تنشئ محتوى بلا اتجاه؟','brand-direction-4','الاتجاه الواضح يحوّل النشاط إلى نمو هادف','نظرة عملية على دور الاستراتيجية في الاتساق والوضوح ونمو العلامة.','<h3>معظم العلامات لا تواجه صعوبة في إنتاج المحتوى، بل في صنع الاتجاه</h3>\n<p>في البداية يبدو كل شيء وكأنه تقدم؛ يُنتج المحتوى وتكون الصفحات نشطة وتظهر العلامة حاضرة عبر المنصات، لكن بعد فترة يبدأ شيء خفي بالتغير، وعلى الرغم من كل النشاط لا تشعر العلامة بأنها تتقدم فعلياً بشكل ذي معنى.</p>\n<h3>المحتوى بلا اتجاه يصبح ضجيجاً</h3>\n<p>عندما يُنشأ المحتوى دون اتجاه استراتيجي محدد، تبدأ كل قطعة بالوجود بمعزل عن غيرها، حيث قد تبدو المنشورات والحملات مقبولة بصرياً بمفردها لكنها تفشل في التواصل ضمن سردية أكبر يمكن التعرف عليها.</p>\n<p>مع مرور الوقت، يتعرض الجمهور لمحتوى يبدو مبعثراً ومنفصلاً، ورغم أن العلامة مرئية إلا أنها لم تعد لا تُنسى أو منظمة بطريقة تبني إدراكاً طويل الأمد.</p>\n<h3>تبقى مشغولاً، لكن علامتك تبقى ثابتة</h3>\n<p>من أكثر سوء الفهم شيوعاً في التسويق افتراض أن النشاط المستمر يؤدي تلقائياً إلى النمو، بينما في الواقع النشر المتكرر دون إطار موجه يخلق وهم التقدم فقط لا حركة استراتيجية فعلية.</p>\n<p>تنتهي باستثمار وقت وطاقة وموارد أكثر في إنتاج المحتوى، لكن نظراً لعدم وجود اتجاه موحد يشكّل هذه الجهود، تبقى هوية العلامة غامضة ومجزأة في ذهن الجمهور.</p>\n<h3>بلا اتجاه، تتغير رسالتك في كل مرة تتحدث فيها</h3>\n<p>عندما لا يوجد أساس استراتيجي واضح، تحاول كل قطعة محتوى جديدة تعريف غرضها الخاص بشكل مستقل، مما يؤدي إلى نبرات متغيرة ورسائل غير متسقة ومرئيات قد لا تتوافق مع بعضها بأي شكل ذي معنى.</p>\n<p>مع استمرار هذا، يتعرض الجمهور لنسخ متعددة من العلامة لا تتصل ببعضها بالكامل، وبدلاً من بناء الوضوح والثقة، يخلق هذا التضارب ارتباكاً تدريجياً يضعف الإدراك العام للعلامة.</p>\n<h3>خواطر ختامية</h3>\n<p>المحتوى بلا اتجاه لا يفشل لأنه سيئ، بل لأنه غير مكتمل. يبدأ النمو الحقيقي عندما يصبح المحتوى جزءاً من نظام واضح.</p>',NULL,NULL,NULL,'2026-07-30 17:26:01','2026-07-30 17:26:01'),
(13,5,'en','What Happens When You Create Content Without Direction?','brand-direction-5','Clear direction turns activity into meaningful growth','A practical look at how strategy creates consistency, clarity, and stronger brand growth.','<h3>Most brands don\'t struggle with creating content, They struggle with creating direction</h3>\n<p>At first, everything feels like progress; content is being produced, pages are active, and the brand appears present across platforms, but after a while, something subtle starts to shift, and despite all the activity, the brand itself doesn\'t feel like it is actually moving forward in a meaningful way.</p>\n<h3>Content without direction becomes noise</h3>\n<p>When content is created without a defined strategic direction, every individual piece starts to exist in isolation, where posts, campaigns, and ideas may look visually acceptable on their own but fail to connect into a larger and recognizable narrative.</p>\n<p>Over time, this creates a situation where the audience is exposed to content that feels scattered and disconnected, and although the brand is visible, it is no longer memorable or structured in a way that builds long-term perception.</p>\n<h3>You stay busy, but your brand stays still</h3>\n<p>One of the most common misunderstandings in marketing is assuming that constant activity automatically leads to growth, while in reality, publishing frequently without a guiding framework only creates the illusion of progress rather than actual strategic movement.</p>\n<p>You end up investing more time, more energy, and more resources into content production, but because there is no unified direction shaping these efforts, the brand identity remains unclear and fragmented in the mind of the audience.</p>\n<h3>Without direction, your message changes every time you speak</h3>\n<p>When there is no clear strategic foundation, every new piece of content tries to independently define its own purpose, which results in shifting tones, inconsistent messaging, and visuals that may not align with each other in any meaningful way.</p>\n<p>As this continues over time, the audience is exposed to multiple versions of the brand that do not fully connect, and instead of building clarity and trust, this inconsistency gradually creates confusion and weakens the overall perception of the brand.</p>\n<h3>Final Thoughts</h3>\n<p>Content without direction doesn\'t fail because it\'s bad, it fails because it\'s incomplete. Real growth starts when content becomes part of a clear system.</p>',NULL,NULL,NULL,'2026-07-30 17:26:01','2026-07-30 17:26:01'),
(14,5,'fa','وقتی بدون جهت محتوا می‌سازید چه اتفاقی می‌افتد؟','brand-direction-5','جهت شفاف، فعالیت را به رشد معنادار تبدیل می‌کند','نگاهی کاربردی به نقش استراتژی در انسجام، شفافیت و رشد قوی‌تر برند.','<h3>بیشتر برندها در تولید محتوا مشکل ندارند، در ساخت جهت مشکل دارند</h3>\n<p>در نگاه اول همه‌چیز شبیه پیشرفت است؛ محتوا تولید می‌شود، صفحات فعال‌اند و برند در پلتفرم‌ها حاضر است، اما پس از مدتی چیزی ظریف تغییر می‌کند و با وجود همه فعالیت، برند احساس نمی‌کند واقعاً در مسیر معناداری پیش می‌رود.</p>\n<h3>محتوا بدون جهت، به نویز تبدیل می‌شود</h3>\n<p>وقتی محتوا بدون جهت استراتژیک مشخصی ساخته می‌شود، هر قطعه به‌تنهایی وجود دارد؛ پست‌ها و کمپین‌ها ممکن است به‌تنهایی قابل قبول باشند اما به روایتی بزرگ‌تر و قابل تشخیص متصل نمی‌شوند.</p>\n<p>با گذر زمان، مخاطب با محتوایی پراکنده و ناهماهنگ روبه‌رو می‌شود و اگرچه برند دیده می‌شود، دیگر به‌یادماندنی یا ساختارمند نیست.</p>\n<h3>شما مشغولید، اما برندتان ثابت می‌ماند</h3>\n<p>یکی از رایج‌ترین سوءتفاهم‌ها در بازاریابی این باور است که فعالیت مداوم به‌خودی‌خود به رشد منجر می‌شود، در حالی‌که انتشار مکرر بدون چارچوب راهنما تنها توهم پیشرفت می‌سازد، نه حرکت استراتژیک واقعی.</p>\n<p>شما زمان و انرژی بیشتری صرف تولید محتوا می‌کنید، اما چون جهت یکپارچه‌ای این تلاش‌ها را شکل نمی‌دهد، هویت برند در ذهن مخاطب مبهم و پراکنده باقی می‌ماند.</p>\n<h3>بدون جهت، پیام شما هر بار تغییر می‌کند</h3>\n<p>وقتی بنیان استراتژیک شفافی وجود ندارد، هر قطعه محتوای تازه سعی می‌کند هدف خود را مستقل تعریف کند که به لحن‌های متغیر و پیام‌رسانی ناهماهنگ می‌انجامد.</p>\n<p>با ادامه این روند، مخاطب با نسخه‌های متعددی از برند روبه‌رو می‌شود که کاملاً به هم متصل نیستند و به‌جای شفافیت و اعتماد، این ناهماهنگی به‌تدریج ادراک کلی برند را تضعیف می‌کند.</p>\n<h3>سخن پایانی</h3>\n<p>محتوای بدون جهت شکست نمی‌خورد چون بد است، شکست می‌خورد چون ناقص است. رشد واقعی زمانی آغاز می‌شود که محتوا بخشی از یک سیستم شفاف شود.</p>',NULL,NULL,NULL,'2026-07-30 17:26:01','2026-07-30 17:26:01'),
(15,5,'ar','ماذا يحدث عندما تنشئ محتوى بلا اتجاه؟','brand-direction-5','الاتجاه الواضح يحوّل النشاط إلى نمو هادف','نظرة عملية على دور الاستراتيجية في الاتساق والوضوح ونمو العلامة.','<h3>معظم العلامات لا تواجه صعوبة في إنتاج المحتوى، بل في صنع الاتجاه</h3>\n<p>في البداية يبدو كل شيء وكأنه تقدم؛ يُنتج المحتوى وتكون الصفحات نشطة وتظهر العلامة حاضرة عبر المنصات، لكن بعد فترة يبدأ شيء خفي بالتغير، وعلى الرغم من كل النشاط لا تشعر العلامة بأنها تتقدم فعلياً بشكل ذي معنى.</p>\n<h3>المحتوى بلا اتجاه يصبح ضجيجاً</h3>\n<p>عندما يُنشأ المحتوى دون اتجاه استراتيجي محدد، تبدأ كل قطعة بالوجود بمعزل عن غيرها، حيث قد تبدو المنشورات والحملات مقبولة بصرياً بمفردها لكنها تفشل في التواصل ضمن سردية أكبر يمكن التعرف عليها.</p>\n<p>مع مرور الوقت، يتعرض الجمهور لمحتوى يبدو مبعثراً ومنفصلاً، ورغم أن العلامة مرئية إلا أنها لم تعد لا تُنسى أو منظمة بطريقة تبني إدراكاً طويل الأمد.</p>\n<h3>تبقى مشغولاً، لكن علامتك تبقى ثابتة</h3>\n<p>من أكثر سوء الفهم شيوعاً في التسويق افتراض أن النشاط المستمر يؤدي تلقائياً إلى النمو، بينما في الواقع النشر المتكرر دون إطار موجه يخلق وهم التقدم فقط لا حركة استراتيجية فعلية.</p>\n<p>تنتهي باستثمار وقت وطاقة وموارد أكثر في إنتاج المحتوى، لكن نظراً لعدم وجود اتجاه موحد يشكّل هذه الجهود، تبقى هوية العلامة غامضة ومجزأة في ذهن الجمهور.</p>\n<h3>بلا اتجاه، تتغير رسالتك في كل مرة تتحدث فيها</h3>\n<p>عندما لا يوجد أساس استراتيجي واضح، تحاول كل قطعة محتوى جديدة تعريف غرضها الخاص بشكل مستقل، مما يؤدي إلى نبرات متغيرة ورسائل غير متسقة ومرئيات قد لا تتوافق مع بعضها بأي شكل ذي معنى.</p>\n<p>مع استمرار هذا، يتعرض الجمهور لنسخ متعددة من العلامة لا تتصل ببعضها بالكامل، وبدلاً من بناء الوضوح والثقة، يخلق هذا التضارب ارتباكاً تدريجياً يضعف الإدراك العام للعلامة.</p>\n<h3>خواطر ختامية</h3>\n<p>المحتوى بلا اتجاه لا يفشل لأنه سيئ، بل لأنه غير مكتمل. يبدأ النمو الحقيقي عندما يصبح المحتوى جزءاً من نظام واضح.</p>',NULL,NULL,NULL,'2026-07-30 17:26:01','2026-07-30 17:26:01'),
(16,6,'en','What Happens When You Create Content Without Direction?','brand-direction-6','Clear direction turns activity into meaningful growth','A practical look at how strategy creates consistency, clarity, and stronger brand growth.','<h3>Most brands don\'t struggle with creating content, They struggle with creating direction</h3>\n<p>At first, everything feels like progress; content is being produced, pages are active, and the brand appears present across platforms, but after a while, something subtle starts to shift, and despite all the activity, the brand itself doesn\'t feel like it is actually moving forward in a meaningful way.</p>\n<h3>Content without direction becomes noise</h3>\n<p>When content is created without a defined strategic direction, every individual piece starts to exist in isolation, where posts, campaigns, and ideas may look visually acceptable on their own but fail to connect into a larger and recognizable narrative.</p>\n<p>Over time, this creates a situation where the audience is exposed to content that feels scattered and disconnected, and although the brand is visible, it is no longer memorable or structured in a way that builds long-term perception.</p>\n<h3>You stay busy, but your brand stays still</h3>\n<p>One of the most common misunderstandings in marketing is assuming that constant activity automatically leads to growth, while in reality, publishing frequently without a guiding framework only creates the illusion of progress rather than actual strategic movement.</p>\n<p>You end up investing more time, more energy, and more resources into content production, but because there is no unified direction shaping these efforts, the brand identity remains unclear and fragmented in the mind of the audience.</p>\n<h3>Without direction, your message changes every time you speak</h3>\n<p>When there is no clear strategic foundation, every new piece of content tries to independently define its own purpose, which results in shifting tones, inconsistent messaging, and visuals that may not align with each other in any meaningful way.</p>\n<p>As this continues over time, the audience is exposed to multiple versions of the brand that do not fully connect, and instead of building clarity and trust, this inconsistency gradually creates confusion and weakens the overall perception of the brand.</p>\n<h3>Final Thoughts</h3>\n<p>Content without direction doesn\'t fail because it\'s bad, it fails because it\'s incomplete. Real growth starts when content becomes part of a clear system.</p>',NULL,NULL,NULL,'2026-07-30 17:26:01','2026-07-30 17:26:01'),
(17,6,'fa','وقتی بدون جهت محتوا می‌سازید چه اتفاقی می‌افتد؟','brand-direction-6','جهت شفاف، فعالیت را به رشد معنادار تبدیل می‌کند','نگاهی کاربردی به نقش استراتژی در انسجام، شفافیت و رشد قوی‌تر برند.','<h3>بیشتر برندها در تولید محتوا مشکل ندارند، در ساخت جهت مشکل دارند</h3>\n<p>در نگاه اول همه‌چیز شبیه پیشرفت است؛ محتوا تولید می‌شود، صفحات فعال‌اند و برند در پلتفرم‌ها حاضر است، اما پس از مدتی چیزی ظریف تغییر می‌کند و با وجود همه فعالیت، برند احساس نمی‌کند واقعاً در مسیر معناداری پیش می‌رود.</p>\n<h3>محتوا بدون جهت، به نویز تبدیل می‌شود</h3>\n<p>وقتی محتوا بدون جهت استراتژیک مشخصی ساخته می‌شود، هر قطعه به‌تنهایی وجود دارد؛ پست‌ها و کمپین‌ها ممکن است به‌تنهایی قابل قبول باشند اما به روایتی بزرگ‌تر و قابل تشخیص متصل نمی‌شوند.</p>\n<p>با گذر زمان، مخاطب با محتوایی پراکنده و ناهماهنگ روبه‌رو می‌شود و اگرچه برند دیده می‌شود، دیگر به‌یادماندنی یا ساختارمند نیست.</p>\n<h3>شما مشغولید، اما برندتان ثابت می‌ماند</h3>\n<p>یکی از رایج‌ترین سوءتفاهم‌ها در بازاریابی این باور است که فعالیت مداوم به‌خودی‌خود به رشد منجر می‌شود، در حالی‌که انتشار مکرر بدون چارچوب راهنما تنها توهم پیشرفت می‌سازد، نه حرکت استراتژیک واقعی.</p>\n<p>شما زمان و انرژی بیشتری صرف تولید محتوا می‌کنید، اما چون جهت یکپارچه‌ای این تلاش‌ها را شکل نمی‌دهد، هویت برند در ذهن مخاطب مبهم و پراکنده باقی می‌ماند.</p>\n<h3>بدون جهت، پیام شما هر بار تغییر می‌کند</h3>\n<p>وقتی بنیان استراتژیک شفافی وجود ندارد، هر قطعه محتوای تازه سعی می‌کند هدف خود را مستقل تعریف کند که به لحن‌های متغیر و پیام‌رسانی ناهماهنگ می‌انجامد.</p>\n<p>با ادامه این روند، مخاطب با نسخه‌های متعددی از برند روبه‌رو می‌شود که کاملاً به هم متصل نیستند و به‌جای شفافیت و اعتماد، این ناهماهنگی به‌تدریج ادراک کلی برند را تضعیف می‌کند.</p>\n<h3>سخن پایانی</h3>\n<p>محتوای بدون جهت شکست نمی‌خورد چون بد است، شکست می‌خورد چون ناقص است. رشد واقعی زمانی آغاز می‌شود که محتوا بخشی از یک سیستم شفاف شود.</p>',NULL,NULL,NULL,'2026-07-30 17:26:01','2026-07-30 17:26:01'),
(18,6,'ar','ماذا يحدث عندما تنشئ محتوى بلا اتجاه؟','brand-direction-6','الاتجاه الواضح يحوّل النشاط إلى نمو هادف','نظرة عملية على دور الاستراتيجية في الاتساق والوضوح ونمو العلامة.','<h3>معظم العلامات لا تواجه صعوبة في إنتاج المحتوى، بل في صنع الاتجاه</h3>\n<p>في البداية يبدو كل شيء وكأنه تقدم؛ يُنتج المحتوى وتكون الصفحات نشطة وتظهر العلامة حاضرة عبر المنصات، لكن بعد فترة يبدأ شيء خفي بالتغير، وعلى الرغم من كل النشاط لا تشعر العلامة بأنها تتقدم فعلياً بشكل ذي معنى.</p>\n<h3>المحتوى بلا اتجاه يصبح ضجيجاً</h3>\n<p>عندما يُنشأ المحتوى دون اتجاه استراتيجي محدد، تبدأ كل قطعة بالوجود بمعزل عن غيرها، حيث قد تبدو المنشورات والحملات مقبولة بصرياً بمفردها لكنها تفشل في التواصل ضمن سردية أكبر يمكن التعرف عليها.</p>\n<p>مع مرور الوقت، يتعرض الجمهور لمحتوى يبدو مبعثراً ومنفصلاً، ورغم أن العلامة مرئية إلا أنها لم تعد لا تُنسى أو منظمة بطريقة تبني إدراكاً طويل الأمد.</p>\n<h3>تبقى مشغولاً، لكن علامتك تبقى ثابتة</h3>\n<p>من أكثر سوء الفهم شيوعاً في التسويق افتراض أن النشاط المستمر يؤدي تلقائياً إلى النمو، بينما في الواقع النشر المتكرر دون إطار موجه يخلق وهم التقدم فقط لا حركة استراتيجية فعلية.</p>\n<p>تنتهي باستثمار وقت وطاقة وموارد أكثر في إنتاج المحتوى، لكن نظراً لعدم وجود اتجاه موحد يشكّل هذه الجهود، تبقى هوية العلامة غامضة ومجزأة في ذهن الجمهور.</p>\n<h3>بلا اتجاه، تتغير رسالتك في كل مرة تتحدث فيها</h3>\n<p>عندما لا يوجد أساس استراتيجي واضح، تحاول كل قطعة محتوى جديدة تعريف غرضها الخاص بشكل مستقل، مما يؤدي إلى نبرات متغيرة ورسائل غير متسقة ومرئيات قد لا تتوافق مع بعضها بأي شكل ذي معنى.</p>\n<p>مع استمرار هذا، يتعرض الجمهور لنسخ متعددة من العلامة لا تتصل ببعضها بالكامل، وبدلاً من بناء الوضوح والثقة، يخلق هذا التضارب ارتباكاً تدريجياً يضعف الإدراك العام للعلامة.</p>\n<h3>خواطر ختامية</h3>\n<p>المحتوى بلا اتجاه لا يفشل لأنه سيئ، بل لأنه غير مكتمل. يبدأ النمو الحقيقي عندما يصبح المحتوى جزءاً من نظام واضح.</p>',NULL,NULL,NULL,'2026-07-30 17:26:01','2026-07-30 17:26:01'),
(19,7,'en','What Happens When You Create Content Without Direction?','brand-direction-7','Clear direction turns activity into meaningful growth','A practical look at how strategy creates consistency, clarity, and stronger brand growth.','<h3>Most brands don\'t struggle with creating content, They struggle with creating direction</h3>\n<p>At first, everything feels like progress; content is being produced, pages are active, and the brand appears present across platforms, but after a while, something subtle starts to shift, and despite all the activity, the brand itself doesn\'t feel like it is actually moving forward in a meaningful way.</p>\n<h3>Content without direction becomes noise</h3>\n<p>When content is created without a defined strategic direction, every individual piece starts to exist in isolation, where posts, campaigns, and ideas may look visually acceptable on their own but fail to connect into a larger and recognizable narrative.</p>\n<p>Over time, this creates a situation where the audience is exposed to content that feels scattered and disconnected, and although the brand is visible, it is no longer memorable or structured in a way that builds long-term perception.</p>\n<h3>You stay busy, but your brand stays still</h3>\n<p>One of the most common misunderstandings in marketing is assuming that constant activity automatically leads to growth, while in reality, publishing frequently without a guiding framework only creates the illusion of progress rather than actual strategic movement.</p>\n<p>You end up investing more time, more energy, and more resources into content production, but because there is no unified direction shaping these efforts, the brand identity remains unclear and fragmented in the mind of the audience.</p>\n<h3>Without direction, your message changes every time you speak</h3>\n<p>When there is no clear strategic foundation, every new piece of content tries to independently define its own purpose, which results in shifting tones, inconsistent messaging, and visuals that may not align with each other in any meaningful way.</p>\n<p>As this continues over time, the audience is exposed to multiple versions of the brand that do not fully connect, and instead of building clarity and trust, this inconsistency gradually creates confusion and weakens the overall perception of the brand.</p>\n<h3>Final Thoughts</h3>\n<p>Content without direction doesn\'t fail because it\'s bad, it fails because it\'s incomplete. Real growth starts when content becomes part of a clear system.</p>',NULL,NULL,NULL,'2026-07-30 17:26:01','2026-07-30 17:26:01'),
(20,7,'fa','وقتی بدون جهت محتوا می‌سازید چه اتفاقی می‌افتد؟','brand-direction-7','جهت شفاف، فعالیت را به رشد معنادار تبدیل می‌کند','نگاهی کاربردی به نقش استراتژی در انسجام، شفافیت و رشد قوی‌تر برند.','<h3>بیشتر برندها در تولید محتوا مشکل ندارند، در ساخت جهت مشکل دارند</h3>\n<p>در نگاه اول همه‌چیز شبیه پیشرفت است؛ محتوا تولید می‌شود، صفحات فعال‌اند و برند در پلتفرم‌ها حاضر است، اما پس از مدتی چیزی ظریف تغییر می‌کند و با وجود همه فعالیت، برند احساس نمی‌کند واقعاً در مسیر معناداری پیش می‌رود.</p>\n<h3>محتوا بدون جهت، به نویز تبدیل می‌شود</h3>\n<p>وقتی محتوا بدون جهت استراتژیک مشخصی ساخته می‌شود، هر قطعه به‌تنهایی وجود دارد؛ پست‌ها و کمپین‌ها ممکن است به‌تنهایی قابل قبول باشند اما به روایتی بزرگ‌تر و قابل تشخیص متصل نمی‌شوند.</p>\n<p>با گذر زمان، مخاطب با محتوایی پراکنده و ناهماهنگ روبه‌رو می‌شود و اگرچه برند دیده می‌شود، دیگر به‌یادماندنی یا ساختارمند نیست.</p>\n<h3>شما مشغولید، اما برندتان ثابت می‌ماند</h3>\n<p>یکی از رایج‌ترین سوءتفاهم‌ها در بازاریابی این باور است که فعالیت مداوم به‌خودی‌خود به رشد منجر می‌شود، در حالی‌که انتشار مکرر بدون چارچوب راهنما تنها توهم پیشرفت می‌سازد، نه حرکت استراتژیک واقعی.</p>\n<p>شما زمان و انرژی بیشتری صرف تولید محتوا می‌کنید، اما چون جهت یکپارچه‌ای این تلاش‌ها را شکل نمی‌دهد، هویت برند در ذهن مخاطب مبهم و پراکنده باقی می‌ماند.</p>\n<h3>بدون جهت، پیام شما هر بار تغییر می‌کند</h3>\n<p>وقتی بنیان استراتژیک شفافی وجود ندارد، هر قطعه محتوای تازه سعی می‌کند هدف خود را مستقل تعریف کند که به لحن‌های متغیر و پیام‌رسانی ناهماهنگ می‌انجامد.</p>\n<p>با ادامه این روند، مخاطب با نسخه‌های متعددی از برند روبه‌رو می‌شود که کاملاً به هم متصل نیستند و به‌جای شفافیت و اعتماد، این ناهماهنگی به‌تدریج ادراک کلی برند را تضعیف می‌کند.</p>\n<h3>سخن پایانی</h3>\n<p>محتوای بدون جهت شکست نمی‌خورد چون بد است، شکست می‌خورد چون ناقص است. رشد واقعی زمانی آغاز می‌شود که محتوا بخشی از یک سیستم شفاف شود.</p>',NULL,NULL,NULL,'2026-07-30 17:26:01','2026-07-30 17:26:01'),
(21,7,'ar','ماذا يحدث عندما تنشئ محتوى بلا اتجاه؟','brand-direction-7','الاتجاه الواضح يحوّل النشاط إلى نمو هادف','نظرة عملية على دور الاستراتيجية في الاتساق والوضوح ونمو العلامة.','<h3>معظم العلامات لا تواجه صعوبة في إنتاج المحتوى، بل في صنع الاتجاه</h3>\n<p>في البداية يبدو كل شيء وكأنه تقدم؛ يُنتج المحتوى وتكون الصفحات نشطة وتظهر العلامة حاضرة عبر المنصات، لكن بعد فترة يبدأ شيء خفي بالتغير، وعلى الرغم من كل النشاط لا تشعر العلامة بأنها تتقدم فعلياً بشكل ذي معنى.</p>\n<h3>المحتوى بلا اتجاه يصبح ضجيجاً</h3>\n<p>عندما يُنشأ المحتوى دون اتجاه استراتيجي محدد، تبدأ كل قطعة بالوجود بمعزل عن غيرها، حيث قد تبدو المنشورات والحملات مقبولة بصرياً بمفردها لكنها تفشل في التواصل ضمن سردية أكبر يمكن التعرف عليها.</p>\n<p>مع مرور الوقت، يتعرض الجمهور لمحتوى يبدو مبعثراً ومنفصلاً، ورغم أن العلامة مرئية إلا أنها لم تعد لا تُنسى أو منظمة بطريقة تبني إدراكاً طويل الأمد.</p>\n<h3>تبقى مشغولاً، لكن علامتك تبقى ثابتة</h3>\n<p>من أكثر سوء الفهم شيوعاً في التسويق افتراض أن النشاط المستمر يؤدي تلقائياً إلى النمو، بينما في الواقع النشر المتكرر دون إطار موجه يخلق وهم التقدم فقط لا حركة استراتيجية فعلية.</p>\n<p>تنتهي باستثمار وقت وطاقة وموارد أكثر في إنتاج المحتوى، لكن نظراً لعدم وجود اتجاه موحد يشكّل هذه الجهود، تبقى هوية العلامة غامضة ومجزأة في ذهن الجمهور.</p>\n<h3>بلا اتجاه، تتغير رسالتك في كل مرة تتحدث فيها</h3>\n<p>عندما لا يوجد أساس استراتيجي واضح، تحاول كل قطعة محتوى جديدة تعريف غرضها الخاص بشكل مستقل، مما يؤدي إلى نبرات متغيرة ورسائل غير متسقة ومرئيات قد لا تتوافق مع بعضها بأي شكل ذي معنى.</p>\n<p>مع استمرار هذا، يتعرض الجمهور لنسخ متعددة من العلامة لا تتصل ببعضها بالكامل، وبدلاً من بناء الوضوح والثقة، يخلق هذا التضارب ارتباكاً تدريجياً يضعف الإدراك العام للعلامة.</p>\n<h3>خواطر ختامية</h3>\n<p>المحتوى بلا اتجاه لا يفشل لأنه سيئ، بل لأنه غير مكتمل. يبدأ النمو الحقيقي عندما يصبح المحتوى جزءاً من نظام واضح.</p>',NULL,NULL,NULL,'2026-07-30 17:26:01','2026-07-30 17:26:01'),
(22,8,'en','What Happens When You Create Content Without Direction?','brand-direction-8','Clear direction turns activity into meaningful growth','A practical look at how strategy creates consistency, clarity, and stronger brand growth.','<h3>Most brands don\'t struggle with creating content, They struggle with creating direction</h3>\n<p>At first, everything feels like progress; content is being produced, pages are active, and the brand appears present across platforms, but after a while, something subtle starts to shift, and despite all the activity, the brand itself doesn\'t feel like it is actually moving forward in a meaningful way.</p>\n<h3>Content without direction becomes noise</h3>\n<p>When content is created without a defined strategic direction, every individual piece starts to exist in isolation, where posts, campaigns, and ideas may look visually acceptable on their own but fail to connect into a larger and recognizable narrative.</p>\n<p>Over time, this creates a situation where the audience is exposed to content that feels scattered and disconnected, and although the brand is visible, it is no longer memorable or structured in a way that builds long-term perception.</p>\n<h3>You stay busy, but your brand stays still</h3>\n<p>One of the most common misunderstandings in marketing is assuming that constant activity automatically leads to growth, while in reality, publishing frequently without a guiding framework only creates the illusion of progress rather than actual strategic movement.</p>\n<p>You end up investing more time, more energy, and more resources into content production, but because there is no unified direction shaping these efforts, the brand identity remains unclear and fragmented in the mind of the audience.</p>\n<h3>Without direction, your message changes every time you speak</h3>\n<p>When there is no clear strategic foundation, every new piece of content tries to independently define its own purpose, which results in shifting tones, inconsistent messaging, and visuals that may not align with each other in any meaningful way.</p>\n<p>As this continues over time, the audience is exposed to multiple versions of the brand that do not fully connect, and instead of building clarity and trust, this inconsistency gradually creates confusion and weakens the overall perception of the brand.</p>\n<h3>Final Thoughts</h3>\n<p>Content without direction doesn\'t fail because it\'s bad, it fails because it\'s incomplete. Real growth starts when content becomes part of a clear system.</p>',NULL,NULL,NULL,'2026-07-30 17:26:01','2026-07-30 17:26:01'),
(23,8,'fa','وقتی بدون جهت محتوا می‌سازید چه اتفاقی می‌افتد؟','brand-direction-8','جهت شفاف، فعالیت را به رشد معنادار تبدیل می‌کند','نگاهی کاربردی به نقش استراتژی در انسجام، شفافیت و رشد قوی‌تر برند.','<h3>بیشتر برندها در تولید محتوا مشکل ندارند، در ساخت جهت مشکل دارند</h3>\n<p>در نگاه اول همه‌چیز شبیه پیشرفت است؛ محتوا تولید می‌شود، صفحات فعال‌اند و برند در پلتفرم‌ها حاضر است، اما پس از مدتی چیزی ظریف تغییر می‌کند و با وجود همه فعالیت، برند احساس نمی‌کند واقعاً در مسیر معناداری پیش می‌رود.</p>\n<h3>محتوا بدون جهت، به نویز تبدیل می‌شود</h3>\n<p>وقتی محتوا بدون جهت استراتژیک مشخصی ساخته می‌شود، هر قطعه به‌تنهایی وجود دارد؛ پست‌ها و کمپین‌ها ممکن است به‌تنهایی قابل قبول باشند اما به روایتی بزرگ‌تر و قابل تشخیص متصل نمی‌شوند.</p>\n<p>با گذر زمان، مخاطب با محتوایی پراکنده و ناهماهنگ روبه‌رو می‌شود و اگرچه برند دیده می‌شود، دیگر به‌یادماندنی یا ساختارمند نیست.</p>\n<h3>شما مشغولید، اما برندتان ثابت می‌ماند</h3>\n<p>یکی از رایج‌ترین سوءتفاهم‌ها در بازاریابی این باور است که فعالیت مداوم به‌خودی‌خود به رشد منجر می‌شود، در حالی‌که انتشار مکرر بدون چارچوب راهنما تنها توهم پیشرفت می‌سازد، نه حرکت استراتژیک واقعی.</p>\n<p>شما زمان و انرژی بیشتری صرف تولید محتوا می‌کنید، اما چون جهت یکپارچه‌ای این تلاش‌ها را شکل نمی‌دهد، هویت برند در ذهن مخاطب مبهم و پراکنده باقی می‌ماند.</p>\n<h3>بدون جهت، پیام شما هر بار تغییر می‌کند</h3>\n<p>وقتی بنیان استراتژیک شفافی وجود ندارد، هر قطعه محتوای تازه سعی می‌کند هدف خود را مستقل تعریف کند که به لحن‌های متغیر و پیام‌رسانی ناهماهنگ می‌انجامد.</p>\n<p>با ادامه این روند، مخاطب با نسخه‌های متعددی از برند روبه‌رو می‌شود که کاملاً به هم متصل نیستند و به‌جای شفافیت و اعتماد، این ناهماهنگی به‌تدریج ادراک کلی برند را تضعیف می‌کند.</p>\n<h3>سخن پایانی</h3>\n<p>محتوای بدون جهت شکست نمی‌خورد چون بد است، شکست می‌خورد چون ناقص است. رشد واقعی زمانی آغاز می‌شود که محتوا بخشی از یک سیستم شفاف شود.</p>',NULL,NULL,NULL,'2026-07-30 17:26:01','2026-07-30 17:26:01'),
(24,8,'ar','ماذا يحدث عندما تنشئ محتوى بلا اتجاه؟','brand-direction-8','الاتجاه الواضح يحوّل النشاط إلى نمو هادف','نظرة عملية على دور الاستراتيجية في الاتساق والوضوح ونمو العلامة.','<h3>معظم العلامات لا تواجه صعوبة في إنتاج المحتوى، بل في صنع الاتجاه</h3>\n<p>في البداية يبدو كل شيء وكأنه تقدم؛ يُنتج المحتوى وتكون الصفحات نشطة وتظهر العلامة حاضرة عبر المنصات، لكن بعد فترة يبدأ شيء خفي بالتغير، وعلى الرغم من كل النشاط لا تشعر العلامة بأنها تتقدم فعلياً بشكل ذي معنى.</p>\n<h3>المحتوى بلا اتجاه يصبح ضجيجاً</h3>\n<p>عندما يُنشأ المحتوى دون اتجاه استراتيجي محدد، تبدأ كل قطعة بالوجود بمعزل عن غيرها، حيث قد تبدو المنشورات والحملات مقبولة بصرياً بمفردها لكنها تفشل في التواصل ضمن سردية أكبر يمكن التعرف عليها.</p>\n<p>مع مرور الوقت، يتعرض الجمهور لمحتوى يبدو مبعثراً ومنفصلاً، ورغم أن العلامة مرئية إلا أنها لم تعد لا تُنسى أو منظمة بطريقة تبني إدراكاً طويل الأمد.</p>\n<h3>تبقى مشغولاً، لكن علامتك تبقى ثابتة</h3>\n<p>من أكثر سوء الفهم شيوعاً في التسويق افتراض أن النشاط المستمر يؤدي تلقائياً إلى النمو، بينما في الواقع النشر المتكرر دون إطار موجه يخلق وهم التقدم فقط لا حركة استراتيجية فعلية.</p>\n<p>تنتهي باستثمار وقت وطاقة وموارد أكثر في إنتاج المحتوى، لكن نظراً لعدم وجود اتجاه موحد يشكّل هذه الجهود، تبقى هوية العلامة غامضة ومجزأة في ذهن الجمهور.</p>\n<h3>بلا اتجاه، تتغير رسالتك في كل مرة تتحدث فيها</h3>\n<p>عندما لا يوجد أساس استراتيجي واضح، تحاول كل قطعة محتوى جديدة تعريف غرضها الخاص بشكل مستقل، مما يؤدي إلى نبرات متغيرة ورسائل غير متسقة ومرئيات قد لا تتوافق مع بعضها بأي شكل ذي معنى.</p>\n<p>مع استمرار هذا، يتعرض الجمهور لنسخ متعددة من العلامة لا تتصل ببعضها بالكامل، وبدلاً من بناء الوضوح والثقة، يخلق هذا التضارب ارتباكاً تدريجياً يضعف الإدراك العام للعلامة.</p>\n<h3>خواطر ختامية</h3>\n<p>المحتوى بلا اتجاه لا يفشل لأنه سيئ، بل لأنه غير مكتمل. يبدأ النمو الحقيقي عندما يصبح المحتوى جزءاً من نظام واضح.</p>',NULL,NULL,NULL,'2026-07-30 17:26:01','2026-07-30 17:26:01'),
(25,9,'en','What Happens When You Create Content Without Direction?','brand-direction-9','Clear direction turns activity into meaningful growth','A practical look at how strategy creates consistency, clarity, and stronger brand growth.','<h3>Most brands don\'t struggle with creating content, They struggle with creating direction</h3>\n<p>At first, everything feels like progress; content is being produced, pages are active, and the brand appears present across platforms, but after a while, something subtle starts to shift, and despite all the activity, the brand itself doesn\'t feel like it is actually moving forward in a meaningful way.</p>\n<h3>Content without direction becomes noise</h3>\n<p>When content is created without a defined strategic direction, every individual piece starts to exist in isolation, where posts, campaigns, and ideas may look visually acceptable on their own but fail to connect into a larger and recognizable narrative.</p>\n<p>Over time, this creates a situation where the audience is exposed to content that feels scattered and disconnected, and although the brand is visible, it is no longer memorable or structured in a way that builds long-term perception.</p>\n<h3>You stay busy, but your brand stays still</h3>\n<p>One of the most common misunderstandings in marketing is assuming that constant activity automatically leads to growth, while in reality, publishing frequently without a guiding framework only creates the illusion of progress rather than actual strategic movement.</p>\n<p>You end up investing more time, more energy, and more resources into content production, but because there is no unified direction shaping these efforts, the brand identity remains unclear and fragmented in the mind of the audience.</p>\n<h3>Without direction, your message changes every time you speak</h3>\n<p>When there is no clear strategic foundation, every new piece of content tries to independently define its own purpose, which results in shifting tones, inconsistent messaging, and visuals that may not align with each other in any meaningful way.</p>\n<p>As this continues over time, the audience is exposed to multiple versions of the brand that do not fully connect, and instead of building clarity and trust, this inconsistency gradually creates confusion and weakens the overall perception of the brand.</p>\n<h3>Final Thoughts</h3>\n<p>Content without direction doesn\'t fail because it\'s bad, it fails because it\'s incomplete. Real growth starts when content becomes part of a clear system.</p>',NULL,NULL,NULL,'2026-07-30 17:26:01','2026-07-30 17:26:01'),
(26,9,'fa','وقتی بدون جهت محتوا می‌سازید چه اتفاقی می‌افتد؟','brand-direction-9','جهت شفاف، فعالیت را به رشد معنادار تبدیل می‌کند','نگاهی کاربردی به نقش استراتژی در انسجام، شفافیت و رشد قوی‌تر برند.','<h3>بیشتر برندها در تولید محتوا مشکل ندارند، در ساخت جهت مشکل دارند</h3>\n<p>در نگاه اول همه‌چیز شبیه پیشرفت است؛ محتوا تولید می‌شود، صفحات فعال‌اند و برند در پلتفرم‌ها حاضر است، اما پس از مدتی چیزی ظریف تغییر می‌کند و با وجود همه فعالیت، برند احساس نمی‌کند واقعاً در مسیر معناداری پیش می‌رود.</p>\n<h3>محتوا بدون جهت، به نویز تبدیل می‌شود</h3>\n<p>وقتی محتوا بدون جهت استراتژیک مشخصی ساخته می‌شود، هر قطعه به‌تنهایی وجود دارد؛ پست‌ها و کمپین‌ها ممکن است به‌تنهایی قابل قبول باشند اما به روایتی بزرگ‌تر و قابل تشخیص متصل نمی‌شوند.</p>\n<p>با گذر زمان، مخاطب با محتوایی پراکنده و ناهماهنگ روبه‌رو می‌شود و اگرچه برند دیده می‌شود، دیگر به‌یادماندنی یا ساختارمند نیست.</p>\n<h3>شما مشغولید، اما برندتان ثابت می‌ماند</h3>\n<p>یکی از رایج‌ترین سوءتفاهم‌ها در بازاریابی این باور است که فعالیت مداوم به‌خودی‌خود به رشد منجر می‌شود، در حالی‌که انتشار مکرر بدون چارچوب راهنما تنها توهم پیشرفت می‌سازد، نه حرکت استراتژیک واقعی.</p>\n<p>شما زمان و انرژی بیشتری صرف تولید محتوا می‌کنید، اما چون جهت یکپارچه‌ای این تلاش‌ها را شکل نمی‌دهد، هویت برند در ذهن مخاطب مبهم و پراکنده باقی می‌ماند.</p>\n<h3>بدون جهت، پیام شما هر بار تغییر می‌کند</h3>\n<p>وقتی بنیان استراتژیک شفافی وجود ندارد، هر قطعه محتوای تازه سعی می‌کند هدف خود را مستقل تعریف کند که به لحن‌های متغیر و پیام‌رسانی ناهماهنگ می‌انجامد.</p>\n<p>با ادامه این روند، مخاطب با نسخه‌های متعددی از برند روبه‌رو می‌شود که کاملاً به هم متصل نیستند و به‌جای شفافیت و اعتماد، این ناهماهنگی به‌تدریج ادراک کلی برند را تضعیف می‌کند.</p>\n<h3>سخن پایانی</h3>\n<p>محتوای بدون جهت شکست نمی‌خورد چون بد است، شکست می‌خورد چون ناقص است. رشد واقعی زمانی آغاز می‌شود که محتوا بخشی از یک سیستم شفاف شود.</p>',NULL,NULL,NULL,'2026-07-30 17:26:01','2026-07-30 17:26:01'),
(27,9,'ar','ماذا يحدث عندما تنشئ محتوى بلا اتجاه؟','brand-direction-9','الاتجاه الواضح يحوّل النشاط إلى نمو هادف','نظرة عملية على دور الاستراتيجية في الاتساق والوضوح ونمو العلامة.','<h3>معظم العلامات لا تواجه صعوبة في إنتاج المحتوى، بل في صنع الاتجاه</h3>\n<p>في البداية يبدو كل شيء وكأنه تقدم؛ يُنتج المحتوى وتكون الصفحات نشطة وتظهر العلامة حاضرة عبر المنصات، لكن بعد فترة يبدأ شيء خفي بالتغير، وعلى الرغم من كل النشاط لا تشعر العلامة بأنها تتقدم فعلياً بشكل ذي معنى.</p>\n<h3>المحتوى بلا اتجاه يصبح ضجيجاً</h3>\n<p>عندما يُنشأ المحتوى دون اتجاه استراتيجي محدد، تبدأ كل قطعة بالوجود بمعزل عن غيرها، حيث قد تبدو المنشورات والحملات مقبولة بصرياً بمفردها لكنها تفشل في التواصل ضمن سردية أكبر يمكن التعرف عليها.</p>\n<p>مع مرور الوقت، يتعرض الجمهور لمحتوى يبدو مبعثراً ومنفصلاً، ورغم أن العلامة مرئية إلا أنها لم تعد لا تُنسى أو منظمة بطريقة تبني إدراكاً طويل الأمد.</p>\n<h3>تبقى مشغولاً، لكن علامتك تبقى ثابتة</h3>\n<p>من أكثر سوء الفهم شيوعاً في التسويق افتراض أن النشاط المستمر يؤدي تلقائياً إلى النمو، بينما في الواقع النشر المتكرر دون إطار موجه يخلق وهم التقدم فقط لا حركة استراتيجية فعلية.</p>\n<p>تنتهي باستثمار وقت وطاقة وموارد أكثر في إنتاج المحتوى، لكن نظراً لعدم وجود اتجاه موحد يشكّل هذه الجهود، تبقى هوية العلامة غامضة ومجزأة في ذهن الجمهور.</p>\n<h3>بلا اتجاه، تتغير رسالتك في كل مرة تتحدث فيها</h3>\n<p>عندما لا يوجد أساس استراتيجي واضح، تحاول كل قطعة محتوى جديدة تعريف غرضها الخاص بشكل مستقل، مما يؤدي إلى نبرات متغيرة ورسائل غير متسقة ومرئيات قد لا تتوافق مع بعضها بأي شكل ذي معنى.</p>\n<p>مع استمرار هذا، يتعرض الجمهور لنسخ متعددة من العلامة لا تتصل ببعضها بالكامل، وبدلاً من بناء الوضوح والثقة، يخلق هذا التضارب ارتباكاً تدريجياً يضعف الإدراك العام للعلامة.</p>\n<h3>خواطر ختامية</h3>\n<p>المحتوى بلا اتجاه لا يفشل لأنه سيئ، بل لأنه غير مكتمل. يبدأ النمو الحقيقي عندما يصبح المحتوى جزءاً من نظام واضح.</p>',NULL,NULL,NULL,'2026-07-30 17:26:01','2026-07-30 17:26:01');
/*!40000 ALTER TABLE `post_translations` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `posts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_category_id` bigint(20) unsigned DEFAULT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'draft',
  `published_at` timestamp NULL DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Large card, Figma 1419:9265',
  `cover_path` varchar(500) DEFAULT NULL,
  `reading_minutes` smallint(5) unsigned NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `posts_user_id_foreign` (`user_id`),
  KEY `posts_public_index` (`status`,`published_at`),
  KEY `posts_is_featured_status_published_at_index` (`is_featured`,`status`,`published_at`),
  KEY `posts_post_category_id_index` (`post_category_id`),
  CONSTRAINT `posts_post_category_id_foreign` FOREIGN KEY (`post_category_id`) REFERENCES `post_categories` (`id`) ON DELETE SET NULL,
  CONSTRAINT `posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES
(1,4,1,'published','2024-05-09 05:30:00',1,'posts/brand-direction.webp',5,'2026-07-29 05:42:02','2026-07-29 05:42:02',NULL),
(2,2,1,'published','2024-05-08 05:30:00',0,'posts/social-growth.webp',2,'2026-07-29 05:42:02','2026-07-30 18:12:01',NULL),
(3,4,1,'published','2024-05-07 05:30:00',0,'posts/direction-first.webp',5,'2026-07-30 17:26:01','2026-07-30 17:26:01',NULL),
(4,2,1,'published','2024-05-06 05:30:00',0,'posts/brand-direction.webp',5,'2026-07-30 17:26:01','2026-07-30 17:26:01',NULL),
(5,4,1,'published','2024-05-05 05:30:00',0,'posts/social-growth.webp',5,'2026-07-30 17:26:01','2026-07-30 17:26:01',NULL),
(6,2,1,'published','2024-05-04 05:30:00',0,'posts/direction-first.webp',5,'2026-07-30 17:26:01','2026-07-30 17:26:01',NULL),
(7,4,1,'published','2024-05-03 05:30:00',0,'posts/social-growth.webp',5,'2026-07-30 17:26:01','2026-07-30 17:26:01',NULL),
(8,2,1,'published','2024-05-02 05:30:00',0,'posts/brand-direction.webp',5,'2026-07-30 17:26:01','2026-07-30 17:26:01',NULL),
(9,4,1,'published','2024-05-01 05:30:00',0,'posts/direction-first.webp',5,'2026-07-30 17:26:01','2026-07-30 17:26:01',NULL);
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `project_image_translations`
--

DROP TABLE IF EXISTS `project_image_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `project_image_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `project_image_id` bigint(20) unsigned NOT NULL,
  `locale` varchar(5) NOT NULL,
  `alt` varchar(300) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `project_image_translations_unique` (`project_image_id`,`locale`),
  CONSTRAINT `project_image_translations_project_image_id_foreign` FOREIGN KEY (`project_image_id`) REFERENCES `project_images` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_image_translations`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `project_image_translations` WRITE;
/*!40000 ALTER TABLE `project_image_translations` DISABLE KEYS */;
/*!40000 ALTER TABLE `project_image_translations` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `project_images`
--

DROP TABLE IF EXISTS `project_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `project_images` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` bigint(20) unsigned NOT NULL,
  `path` varchar(500) NOT NULL,
  `sort_order` smallint(5) unsigned NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `project_images_project_id_sort_order_index` (`project_id`,`sort_order`),
  CONSTRAINT `project_images_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_images`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `project_images` WRITE;
/*!40000 ALTER TABLE `project_images` DISABLE KEYS */;
INSERT INTO `project_images` VALUES
(1,6,'projects/cheshmeh-showcase-1.webp',0,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(2,6,'projects/cheshmeh-showcase-2.webp',1,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(3,6,'projects/cheshmeh-showcase-3.webp',2,'2026-07-30 17:26:00','2026-07-30 17:26:00');
/*!40000 ALTER TABLE `project_images` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `project_service`
--

DROP TABLE IF EXISTS `project_service`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `project_service` (
  `project_id` bigint(20) unsigned NOT NULL,
  `service_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`project_id`,`service_id`),
  KEY `project_service_service_id_index` (`service_id`),
  CONSTRAINT `project_service_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  CONSTRAINT `project_service_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_service`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `project_service` WRITE;
/*!40000 ALTER TABLE `project_service` DISABLE KEYS */;
INSERT INTO `project_service` VALUES
(1,1),
(2,1),
(3,1),
(4,1),
(3,2),
(4,2),
(6,2),
(1,3),
(2,3),
(5,3),
(6,3),
(5,4);
/*!40000 ALTER TABLE `project_service` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `project_translations`
--

DROP TABLE IF EXISTS `project_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `project_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` bigint(20) unsigned NOT NULL,
  `locale` varchar(5) NOT NULL,
  `title` varchar(200) NOT NULL,
  `slug` varchar(200) NOT NULL,
  `subtitle` varchar(300) DEFAULT NULL,
  `excerpt` text DEFAULT NULL COMMENT 'Card description on the listing',
  `challenge` text DEFAULT NULL,
  `challenge_points` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'array<string>' CHECK (json_valid(`challenge_points`)),
  `results_summary` text DEFAULT NULL,
  `seo_title` varchar(200) DEFAULT NULL,
  `seo_description` varchar(300) DEFAULT NULL,
  `cover_alt` varchar(300) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `project_translations_unique` (`project_id`,`locale`),
  UNIQUE KEY `project_translations_slug_unique` (`locale`,`slug`),
  KEY `project_translations_locale_index` (`locale`),
  CONSTRAINT `project_translations_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_translations`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `project_translations` WRITE;
/*!40000 ALTER TABLE `project_translations` DISABLE KEYS */;
INSERT INTO `project_translations` VALUES
(1,1,'en','Baghche','baghche-branding','Healthy food, honestly presented','Branding and content support for a healthy food brand focused on freshness, trust, and everyday convenience.',NULL,NULL,NULL,NULL,NULL,NULL,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(2,1,'fa','باغچه','باغچه','غذای سالم، صادقانه ارائه‌شده','پشتیبانی برندینگ و محتوا برای برند غذای سالم با تمرکز بر تازگی، اعتماد و راحتی روزمره.',NULL,NULL,NULL,NULL,NULL,NULL,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(3,1,'ar','باغتشه','باغتشه','طعام صحي بعرض صادق','دعم الهوية والمحتوى لعلامة أطعمة صحية تركز على النضارة والثقة والراحة اليومية.',NULL,NULL,NULL,NULL,NULL,NULL,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(4,2,'en','Kerman Motors','kerman-motors','Factory-price sale campaign','Campaign visuals and promotional creative for a factory-price sales launch.',NULL,NULL,NULL,NULL,NULL,NULL,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(5,2,'fa','کرمان موتورز','کرمان-موتورز','کمپین فروش با قیمت کارخانه','بصری‌های کمپین و خلاقیت تبلیغاتی برای راه‌اندازی فروش با قیمت کارخانه.',NULL,NULL,NULL,NULL,NULL,NULL,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(6,2,'ar','كرمان موتورز','كرمان-موتورز','حملة بيع بسعر المصنع','مرئيات حملة وإبداع ترويجي لإطلاق بيع بسعر المصنع.',NULL,NULL,NULL,NULL,NULL,NULL,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(7,3,'en','Fakhar Medical & Dental Clinic','fakhar-clinic','Comprehensive care, one clear voice','Brand direction and content for a comprehensive medical services provider.',NULL,NULL,NULL,NULL,NULL,NULL,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(8,3,'fa','کلینیک پزشکی و دندانپزشکی فخر','کلینیک-فخر','مراقبت جامع، یک صدای شفاف','جهت‌گیری برند و محتوا برای ارائه‌دهنده خدمات پزشکی جامع.',NULL,NULL,NULL,NULL,NULL,NULL,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(9,3,'ar','عيادة فخر الطبية وطب الأسنان','عيادة-فخر','رعاية شاملة بصوت واحد واضح','توجيه العلامة والمحتوى لمزود خدمات طبية شاملة.',NULL,NULL,NULL,NULL,NULL,NULL,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(10,4,'en','Plus Protein','plus-protein','A mark built for the gym bag','Logo and packaging-facing brand identity for a protein products company.',NULL,NULL,NULL,NULL,NULL,NULL,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(11,4,'fa','پلاس پروتئین','پلاس-پروتئین','نشانی ساخته‌شده برای کیف ورزشی','هویت برند برای لوگو و بسته‌بندی یک شرکت محصولات پروتئینی.',NULL,NULL,NULL,NULL,NULL,NULL,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(12,4,'ar','بلس بروتين','بلس-بروتين','شعار صُمم لحقيبة الرياضة','هوية العلامة للشعار والتغليف لشركة منتجات بروتين.',NULL,NULL,NULL,NULL,NULL,NULL,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(13,5,'en','Karsa Tourism Services','karsa-tourism','Booking made to feel personal','Branding and campaign visuals for a travel and tourism services company.',NULL,NULL,NULL,NULL,NULL,NULL,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(14,5,'fa','خدمات گردشگری کرسا','کرسا-توریسم','رزروی با حس شخصی','برندینگ و بصری‌های کمپین برای شرکت خدمات گردشگری.',NULL,NULL,NULL,NULL,NULL,NULL,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(15,5,'ar','خدمات كارسا السياحية','كارسا-تورزم','حجز يبدو شخصياً','الهوية ومرئيات الحملة لشركة خدمات سياحية وسفر.',NULL,NULL,NULL,NULL,NULL,NULL,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(16,6,'en','Cheshmeh','cheshmeh-beauty','A calmer, more trusted identity','Cheshmeh needed a stronger digital identity. one that could communicate trust, simplicity, and brand value across every touchpoint.','Cheshmeh had strong services, but its digital presence did not clearly reflect the trust, calmness, and clarity people expect from a beauty clinic.','[\"No clear content direction\",\"Inconsistent visual identity\",\"Unclear brand presence\"]','The project helped Cheshmeh build a clearer and more consistent digital presence. Through a refined visual direction and strategic content approach, the brand created stronger audience trust and engagement.',NULL,NULL,NULL,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(17,6,'fa','کلینیک زیبایی چشمه','چشمه-بیوتی','هویتی آرام‌تر و قابل‌اعتمادتر','بازطراحی کامل هویت دیجیتال برای یک کلینیک زیبایی و دندانپزشکی.','چشمه خدمات قوی داشت، اما حضور دیجیتالش اعتماد، آرامش و شفافیتی را که از یک کلینیک زیبایی انتظار می‌رود، منعکس نمی‌کرد.','[\"\\u0646\\u0628\\u0648\\u062f \\u062c\\u0647\\u062a\\u200c\\u06af\\u06cc\\u0631\\u06cc \\u0634\\u0641\\u0627\\u0641 \\u0645\\u062d\\u062a\\u0648\\u0627\\u06cc\\u06cc\",\"\\u0647\\u0648\\u06cc\\u062a \\u0628\\u0635\\u0631\\u06cc \\u0646\\u0627\\u0647\\u0645\\u0627\\u0647\\u0646\\u06af\",\"\\u062d\\u0636\\u0648\\u0631 \\u0628\\u0631\\u0646\\u062f \\u0646\\u0627\\u0645\\u0634\\u062e\\u0635\"]','این پروژه به چشمه کمک کرد حضور دیجیتالی شفاف‌تر و یکدست‌تری بسازد. با جهت‌گیری بصری بازتعریف‌شده و رویکرد محتوایی استراتژیک، برند اعتماد و تعامل قوی‌تری از مخاطبان به دست آورد.',NULL,NULL,NULL,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(18,6,'ar','عيادة تجميل تشيشمه','تشيشمه-بيوتي','هوية أكثر هدوءاً وثقة','تجديد كامل للهوية الرقمية لعيادة تجميل وأسنان.','كانت لدى تشيشمه خدمات قوية، لكن حضورها الرقمي لم يعكس بوضوح الثقة والهدوء والوضوح التي يتوقعها الناس من عيادة تجميل.','[\"\\u0644\\u0627 \\u0627\\u062a\\u062c\\u0627\\u0647 \\u0648\\u0627\\u0636\\u062d \\u0644\\u0644\\u0645\\u062d\\u062a\\u0648\\u0649\",\"\\u0647\\u0648\\u064a\\u0629 \\u0628\\u0635\\u0631\\u064a\\u0629 \\u063a\\u064a\\u0631 \\u0645\\u062a\\u0633\\u0642\\u0629\",\"\\u062d\\u0636\\u0648\\u0631 \\u063a\\u064a\\u0631 \\u0648\\u0627\\u0636\\u062d \\u0644\\u0644\\u0639\\u0644\\u0627\\u0645\\u0629\"]','ساعد المشروع تشيشمه على بناء حضور رقمي أوضح وأكثر اتساقاً. من خلال توجيه بصري مُحسّن ونهج محتوى استراتيجي، بنت العلامة ثقة وتفاعلاً أقوى مع الجمهور.',NULL,NULL,NULL,'2026-07-29 05:42:02','2026-07-29 05:42:02');
/*!40000 ALTER TABLE `project_translations` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `projects` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `industry_id` bigint(20) unsigned DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'draft',
  `published_at` timestamp NULL DEFAULT NULL,
  `sort_order` smallint(5) unsigned NOT NULL DEFAULT 0,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Home projects showcase 1419:9216',
  `year` varchar(10) DEFAULT NULL,
  `instagram_handle` varchar(100) DEFAULT NULL,
  `cover_path` varchar(500) DEFAULT NULL,
  `banner_path` varchar(500) DEFAULT NULL,
  `before_image_path` varchar(500) DEFAULT NULL,
  `after_image_path` varchar(500) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `projects_public_index` (`status`,`published_at`,`sort_order`),
  KEY `projects_is_featured_status_index` (`is_featured`,`status`),
  KEY `projects_industry_id_index` (`industry_id`),
  CONSTRAINT `projects_industry_id_foreign` FOREIGN KEY (`industry_id`) REFERENCES `industries` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projects`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `projects` WRITE;
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
INSERT INTO `projects` VALUES
(1,1,'published','2026-07-24 17:26:00',0,0,'2024','baghche','projects/baghche.webp','projects/baghche.webp',NULL,NULL,'2026-07-29 05:42:02','2026-07-30 17:26:00',NULL),
(2,2,'published','2026-07-25 17:26:00',1,0,'2024',NULL,'projects/kerman-motors.webp','projects/kerman-motors.webp',NULL,NULL,'2026-07-29 05:42:02','2026-07-30 17:26:00',NULL),
(3,3,'published','2026-07-26 17:26:00',2,0,'2024','fakharclinic','projects/fakhar-clinic.webp','projects/fakhar-clinic.webp',NULL,NULL,'2026-07-29 05:42:02','2026-07-30 17:26:00',NULL),
(4,1,'published','2026-07-27 17:26:00',3,0,'2023','plusprotein','projects/plus-protein.webp','projects/plus-protein.webp',NULL,NULL,'2026-07-29 05:42:02','2026-07-30 17:26:00',NULL),
(5,4,'published','2026-07-28 17:26:00',4,0,'2023','karsatravel','projects/karsa-tourism.webp','projects/karsa-tourism.webp',NULL,NULL,'2026-07-29 05:42:02','2026-07-30 17:26:00',NULL),
(6,5,'published','2026-07-29 17:26:00',5,1,'2024','cheshmeh.beauty','projects/cheshmeh.webp','projects/cheshmeh-banner.webp','projects/cheshmeh-before.webp','projects/cheshmeh-after.webp','2026-07-29 05:42:02','2026-07-30 17:26:00',NULL);
/*!40000 ALTER TABLE `projects` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `redirects`
--

DROP TABLE IF EXISTS `redirects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `redirects` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `source_path` varchar(500) NOT NULL,
  `destination_path` varchar(500) NOT NULL,
  `status_code` smallint(5) unsigned NOT NULL DEFAULT 301,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `hits` int(10) unsigned NOT NULL DEFAULT 0,
  `last_hit_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `redirects_source_path_unique` (`source_path`),
  KEY `redirects_is_active_index` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `redirects`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `redirects` WRITE;
/*!40000 ALTER TABLE `redirects` DISABLE KEYS */;
/*!40000 ALTER TABLE `redirects` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_has_permissions`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `role_has_permissions` WRITE;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
INSERT INTO `role_has_permissions` VALUES
(1,1),
(2,1),
(3,1),
(4,1),
(5,1),
(6,1),
(7,1),
(8,1),
(9,1),
(10,1),
(11,1),
(12,1),
(13,1),
(14,1),
(15,1),
(16,1),
(17,1),
(18,1),
(19,1),
(20,1),
(21,1),
(22,1),
(23,1),
(24,1),
(25,1),
(26,1),
(27,1),
(28,1),
(29,1),
(30,1),
(31,1),
(32,1),
(33,1),
(34,1),
(35,1),
(36,1),
(37,1),
(38,1),
(39,1),
(40,1),
(41,1),
(42,1),
(43,1),
(44,1),
(45,1),
(46,1),
(47,1),
(48,1),
(49,1),
(50,1),
(51,1),
(52,1),
(53,1),
(54,1),
(55,1),
(56,1),
(57,1),
(58,1),
(59,1),
(60,1),
(61,1),
(62,1),
(63,1),
(64,1),
(65,1),
(66,1),
(67,1),
(68,1),
(69,1),
(70,1),
(71,1),
(72,1),
(73,1),
(74,1),
(75,1),
(76,1),
(77,1),
(78,1),
(79,1),
(80,1),
(81,1),
(82,1),
(83,1),
(84,1),
(85,1),
(86,1),
(87,1),
(88,1),
(89,1),
(90,1),
(91,1),
(92,1),
(93,1),
(94,1),
(95,1),
(96,1),
(97,1),
(98,1),
(99,1),
(100,1),
(101,1),
(102,1),
(103,1),
(104,1),
(105,1),
(106,1),
(107,1),
(108,1),
(109,1),
(110,1),
(111,1),
(112,1),
(113,1),
(114,1),
(115,1),
(116,1),
(117,1),
(118,1),
(119,1),
(120,1),
(121,1),
(122,1),
(123,1),
(124,1),
(125,1),
(126,1),
(127,1),
(128,1),
(129,1),
(130,1),
(131,1),
(132,1),
(133,1),
(134,1),
(135,1),
(136,1),
(1,2),
(2,2),
(3,2),
(4,2),
(5,2),
(6,2),
(8,2),
(9,2),
(10,2),
(11,2),
(12,2),
(13,2),
(14,2),
(16,2),
(17,2),
(18,2),
(19,2),
(20,2),
(21,2),
(22,2),
(24,2),
(25,2),
(26,2),
(27,2),
(28,2),
(29,2),
(30,2),
(32,2),
(33,2),
(34,2),
(35,2),
(36,2),
(37,2),
(38,2),
(40,2),
(41,2),
(42,2),
(43,2),
(44,2),
(45,2),
(46,2),
(48,2),
(49,2),
(50,2),
(51,2),
(52,2),
(53,2),
(54,2),
(56,2),
(57,2),
(58,2),
(59,2),
(60,2),
(61,2),
(62,2),
(64,2),
(65,2),
(66,2),
(67,2),
(68,2),
(69,2),
(70,2),
(72,2),
(73,2),
(74,2),
(75,2),
(76,2),
(77,2),
(78,2),
(80,2),
(81,2),
(82,2),
(83,2),
(84,2),
(85,2),
(86,2),
(88,2),
(89,2),
(90,2),
(91,2),
(92,2),
(93,2),
(94,2),
(96,2);
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES
(1,'admin','web','2026-07-29 05:42:01','2026-07-29 05:42:01'),
(2,'editor','web','2026-07-29 05:42:01','2026-07-29 05:42:01');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `section_item_translations`
--

DROP TABLE IF EXISTS `section_item_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `section_item_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `section_item_id` bigint(20) unsigned NOT NULL,
  `locale` varchar(5) NOT NULL,
  `value` varchar(50) DEFAULT NULL,
  `label` varchar(100) DEFAULT NULL,
  `suffix` varchar(100) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `badge` varchar(100) DEFAULT NULL,
  `features` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`features`)),
  `footer` varchar(200) DEFAULT NULL,
  `image_alt` varchar(300) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `section_item_translations_unique` (`section_item_id`,`locale`),
  KEY `section_item_translations_locale_index` (`locale`),
  CONSTRAINT `section_item_translations_section_item_id_foreign` FOREIGN KEY (`section_item_id`) REFERENCES `section_items` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=352 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `section_item_translations`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `section_item_translations` WRITE;
/*!40000 ALTER TABLE `section_item_translations` DISABLE KEYS */;
INSERT INTO `section_item_translations` VALUES
(235,79,'en','+70K',NULL,NULL,'Audience Growth','Followers gained from one reel',NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(236,79,'fa','+۷۰ هزار',NULL,NULL,'رشد مخاطب','دنبال‌کننده به‌دست‌آمده از یک ریلز',NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(237,79,'ar','+٧٠ ألف',NULL,NULL,'نمو الجمهور','متابعون من مقطع واحد',NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(238,80,'en','+40%',NULL,NULL,'Engagement Lift','Average growth after strategy refresh',NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(239,80,'fa','+۴۰٪',NULL,NULL,'افزایش تعامل','میانگین رشد پس از بازنگری استراتژی',NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(240,80,'ar','+٤٠٪',NULL,NULL,'ارتفاع التفاعل','متوسط النمو بعد تحديث الاستراتيجية',NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(241,81,'en','+90%',NULL,NULL,'Client Retention','Across monthly marketing plans',NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(242,81,'fa','+۹۰٪',NULL,NULL,'حفظ مشتری','در طرح‌های ماهانه بازاریابی',NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(243,81,'ar','+٩٠٪',NULL,NULL,'الاحتفاظ بالعملاء','ضمن خطط التسويق الشهرية',NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(244,82,'en','01',NULL,NULL,'Discovery & Brand Review','Deep analysis of your brand, audience, and market position',NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(245,82,'fa','۰۱',NULL,NULL,'کشف و بررسی برند','تحلیل عمیق برند، مخاطب و جایگاه شما در بازار',NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(246,82,'ar','٠١',NULL,NULL,'اكتشاف ومراجعة العلامة','تحليل عميق لعلامتك وجمهورك وموقعك في السوق',NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(247,83,'en','02',NULL,NULL,'Strategy & Content Plan','Custom content plans focused on consistency and growth',NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(248,83,'fa','۰۲',NULL,NULL,'استراتژی و برنامه محتوا','برنامه‌های محتوایی اختصاصی با تمرکز بر ثبات و رشد',NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(249,83,'ar','٠٢',NULL,NULL,'الاستراتيجية وخطة المحتوى','خطط محتوى مخصصة تركز على الاتساق والنمو',NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(250,84,'en','03',NULL,NULL,'Design & Production','High-quality visuals aligned with your brand',NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(251,84,'fa','۰۳',NULL,NULL,'طراحی و تولید','تصاویر باکیفیت و هم‌راستا با برند شما',NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(252,84,'ar','٠٣',NULL,NULL,'التصميم والإنتاج','مرئيات عالية الجودة ومتوافقة مع علامتك',NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(253,85,'en','04',NULL,NULL,'Review & Approval','Review and refine all content before it goes live',NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(254,85,'fa','۰۴',NULL,NULL,'بازبینی و تأیید','بازبینی و اصلاح تمام محتوا پیش از انتشار',NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(255,85,'ar','٠٤',NULL,NULL,'المراجعة والموافقة','مراجعة وتحسين كل المحتوى قبل نشره',NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(256,86,'en','05',NULL,NULL,'Publishing & Management','Professional scheduling and active platform management',NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(257,86,'fa','۰۵',NULL,NULL,'انتشار و مدیریت','زمان‌بندی حرفه‌ای و مدیریت فعال پلتفرم‌ها',NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(258,86,'ar','٠٥',NULL,NULL,'النشر والإدارة','جدولة احترافية وإدارة فعالة للمنصات',NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(259,87,'en','06',NULL,NULL,'Reporting & Optimization','Performance tracking and data-driven optimization',NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(260,87,'fa','۰۶',NULL,NULL,'گزارش‌دهی و بهینه‌سازی','پایش عملکرد و بهینه‌سازی داده‌محور',NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(261,87,'ar','٠٦',NULL,NULL,'التقارير والتحسين','تتبع الأداء والتحسين القائم على البيانات',NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(262,88,'en','199','Starts From','OMR / 1 Month','Sahra Essential','A clear foundation for your brand presence',NULL,'[\"Content Planning\",\"Visual Direction\",\"Social Media Support\",\"Monthly Execution\"]','Best for small businesses',NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(263,88,'fa','۱۹۹','شروع از','ریال عمان / ۱ ماه','صحرا اسنشال','پایه‌ای شفاف برای حضور برند شما',NULL,'[\"\\u0628\\u0631\\u0646\\u0627\\u0645\\u0647\\u200c\\u0631\\u06cc\\u0632\\u06cc \\u0645\\u062d\\u062a\\u0648\\u0627\",\"\\u062c\\u0647\\u062a\\u200c\\u06af\\u06cc\\u0631\\u06cc \\u0628\\u0635\\u0631\\u06cc\",\"\\u067e\\u0634\\u062a\\u06cc\\u0628\\u0627\\u0646\\u06cc \\u0634\\u0628\\u06a9\\u0647\\u200c\\u0647\\u0627\\u06cc \\u0627\\u062c\\u062a\\u0645\\u0627\\u0639\\u06cc\",\"\\u0627\\u062c\\u0631\\u0627\\u06cc \\u0645\\u0627\\u0647\\u0627\\u0646\\u0647\"]','مناسب کسب‌وکارهای کوچک',NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(264,88,'ar','١٩٩','تبدأ من','ر.ع / شهر واحد','صحراء الأساسية','أساس واضح لحضور علامتك',NULL,'[\"\\u062a\\u062e\\u0637\\u064a\\u0637 \\u0627\\u0644\\u0645\\u062d\\u062a\\u0648\\u0649\",\"\\u0627\\u0644\\u062a\\u0648\\u062c\\u064a\\u0647 \\u0627\\u0644\\u0628\\u0635\\u0631\\u064a\",\"\\u062f\\u0639\\u0645 \\u0648\\u0633\\u0627\\u0626\\u0644 \\u0627\\u0644\\u062a\\u0648\\u0627\\u0635\\u0644\",\"\\u0627\\u0644\\u062a\\u0646\\u0641\\u064a\\u0630 \\u0627\\u0644\\u0634\\u0647\\u0631\\u064a\"]','الأفضل للشركات الصغيرة',NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(265,89,'en','499','Starts From','OMR / 1 Month','Sahra Growth','A structured approach to build and grow your presence','Most Popular','[\"Content Strategy\",\"Brand-Aligned Content\",\"Campaign Support\",\"Performance Optimization\"]','Best for growing brands',NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(266,89,'fa','۴۹۹','شروع از','ریال عمان / ۱ ماه','صحرا گروث','رویکردی ساختاریافته برای ساخت و رشد حضور برند','محبوب‌ترین','[\"\\u0627\\u0633\\u062a\\u0631\\u0627\\u062a\\u0698\\u06cc \\u0645\\u062d\\u062a\\u0648\\u0627\",\"\\u0645\\u062d\\u062a\\u0648\\u0627\\u06cc \\u0647\\u0645\\u200c\\u0631\\u0627\\u0633\\u062a\\u0627 \\u0628\\u0627 \\u0628\\u0631\\u0646\\u062f\",\"\\u067e\\u0634\\u062a\\u06cc\\u0628\\u0627\\u0646\\u06cc \\u06a9\\u0645\\u067e\\u06cc\\u0646\",\"\\u0628\\u0647\\u06cc\\u0646\\u0647\\u200c\\u0633\\u0627\\u0632\\u06cc \\u0639\\u0645\\u0644\\u06a9\\u0631\\u062f\"]','مناسب برندهای در حال رشد',NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(267,89,'ar','٤٩٩','تبدأ من','ر.ع / شهر واحد','صحراء للنمو','نهج منظم لبناء حضورك وتنميته','الأكثر شعبية','[\"\\u0627\\u0633\\u062a\\u0631\\u0627\\u062a\\u064a\\u062c\\u064a\\u0629 \\u0627\\u0644\\u0645\\u062d\\u062a\\u0648\\u0649\",\"\\u0645\\u062d\\u062a\\u0648\\u0649 \\u0645\\u062a\\u0648\\u0627\\u0641\\u0642 \\u0645\\u0639 \\u0627\\u0644\\u0639\\u0644\\u0627\\u0645\\u0629\",\"\\u062f\\u0639\\u0645 \\u0627\\u0644\\u062d\\u0645\\u0644\\u0627\\u062a\",\"\\u062a\\u062d\\u0633\\u064a\\u0646 \\u0627\\u0644\\u0623\\u062f\\u0627\\u0621\"]','الأفضل للعلامات النامية',NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(268,90,'en','749','Starts From','OMR / 1 Month','Sahra Horizon','A complete partnership for brand growth',NULL,'[\"Full Marketing Strategy\",\"Brand Development\",\"Campaign Planning\",\"Continuous Optimization\"]','Best for scaling brands',NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(269,90,'fa','۷۴۹','شروع از','ریال عمان / ۱ ماه','صحرا هورایزن','همکاری کامل برای رشد برند',NULL,'[\"\\u0627\\u0633\\u062a\\u0631\\u0627\\u062a\\u0698\\u06cc \\u06a9\\u0627\\u0645\\u0644 \\u0628\\u0627\\u0632\\u0627\\u0631\\u06cc\\u0627\\u0628\\u06cc\",\"\\u062a\\u0648\\u0633\\u0639\\u0647 \\u0628\\u0631\\u0646\\u062f\",\"\\u0628\\u0631\\u0646\\u0627\\u0645\\u0647\\u200c\\u0631\\u06cc\\u0632\\u06cc \\u06a9\\u0645\\u067e\\u06cc\\u0646\",\"\\u0628\\u0647\\u06cc\\u0646\\u0647\\u200c\\u0633\\u0627\\u0632\\u06cc \\u0645\\u0633\\u062a\\u0645\\u0631\"]','مناسب برندهای مقیاس‌پذیر',NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(270,90,'ar','٧٤٩','تبدأ من','ر.ع / شهر واحد','صحراء الأفق','شراكة متكاملة لنمو العلامة',NULL,'[\"\\u0627\\u0633\\u062a\\u0631\\u0627\\u062a\\u064a\\u062c\\u064a\\u0629 \\u062a\\u0633\\u0648\\u064a\\u0642 \\u0643\\u0627\\u0645\\u0644\\u0629\",\"\\u062a\\u0637\\u0648\\u064a\\u0631 \\u0627\\u0644\\u0639\\u0644\\u0627\\u0645\\u0629\",\"\\u062a\\u062e\\u0637\\u064a\\u0637 \\u0627\\u0644\\u062d\\u0645\\u0644\\u0627\\u062a\",\"\\u062a\\u062d\\u0633\\u064a\\u0646 \\u0645\\u0633\\u062a\\u0645\\u0631\"]','الأفضل للعلامات المتوسعة',NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(271,91,'en',NULL,NULL,NULL,'Creativity','Ideas grounded in strategy, not decoration.',NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(272,91,'fa',NULL,NULL,NULL,'خلاقیت','ایده‌هایی مبتنی بر استراتژی، نه تزئین.',NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(273,91,'ar',NULL,NULL,NULL,'الإبداع','أفكار مبنية على الاستراتيجية لا الزخرفة.',NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(274,92,'en',NULL,NULL,NULL,'Reliability','Consistent delivery on an agreed rhythm.',NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(275,92,'fa',NULL,NULL,NULL,'اتکاپذیری','تحویل منظم بر اساس ریتم توافق‌شده.',NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(276,92,'ar',NULL,NULL,NULL,'الموثوقية','تسليم منتظم وفق إيقاع متفق عليه.',NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(277,93,'en',NULL,NULL,NULL,'Innovation','New formats tested against real business goals.',NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(278,93,'fa',NULL,NULL,NULL,'نوآوری','قالب‌های تازه، سنجیده با اهداف واقعی کسب‌وکار.',NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(279,93,'ar',NULL,NULL,NULL,'الابتكار','صيغ جديدة تُختبر مقابل أهداف عمل حقيقية.',NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(280,94,'en',NULL,NULL,NULL,'Clarity','One connected story instead of scattered posts.',NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(281,94,'fa',NULL,NULL,NULL,'شفافیت','یک روایت پیوسته به‌جای پست‌های پراکنده.',NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(282,94,'ar',NULL,NULL,NULL,'الوضوح','قصة واحدة مترابطة بدل منشورات مبعثرة.',NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(283,95,'en',NULL,NULL,NULL,'Quality Before Quantity','Intentional work over endless output',NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(284,95,'fa',NULL,NULL,NULL,'کیفیت پیش از کمیت','کار هدفمند به‌جای خروجی بی‌پایان',NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(285,95,'ar',NULL,NULL,NULL,'الجودة قبل الكمية','عمل مقصود بدل إنتاج لا ينتهي',NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(286,96,'en',NULL,NULL,NULL,'Brand Alignment Before Decoration','Every visual should serve the brand',NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(287,96,'fa',NULL,NULL,NULL,'هم‌راستایی با برند پیش از تزئین','هر عنصر بصری باید در خدمت برند باشد',NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(288,96,'ar',NULL,NULL,NULL,'التوافق مع العلامة قبل الزخرفة','كل عنصر بصري يجب أن يخدم العلامة',NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(289,97,'en',NULL,NULL,NULL,'Consistency Before Noise','Structure creates stronger presence',NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(290,97,'fa',NULL,NULL,NULL,'ثبات پیش از هیاهو','ساختار، حضور قوی‌تری می‌سازد',NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(291,97,'ar',NULL,NULL,NULL,'الاتساق قبل الضجيج','البنية تصنع حضوراً أقوى',NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(292,98,'en',NULL,NULL,NULL,'Growth Before Trends','Long-term value over short-term attention',NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(293,98,'fa',NULL,NULL,NULL,'رشد پیش از ترندها','ارزش بلندمدت به‌جای توجه کوتاه‌مدت',NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(294,98,'ar',NULL,NULL,NULL,'النمو قبل الرائج','قيمة طويلة الأمد بدل انتباه عابر',NULL,NULL,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(295,99,'en',NULL,NULL,NULL,'Calm Identity','Softer brand perception',NULL,NULL,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(296,99,'fa',NULL,NULL,NULL,'هویت آرام','برداشتی نرم‌تر از برند',NULL,NULL,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(297,99,'ar',NULL,NULL,NULL,'هوية هادئة','إدراك أنعم للعلامة',NULL,NULL,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(298,100,'en',NULL,NULL,NULL,'Clear Direction','A consistent visual system',NULL,NULL,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(299,100,'fa',NULL,NULL,NULL,'جهت شفاف','سیستم بصری یکدست',NULL,NULL,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(300,100,'ar',NULL,NULL,NULL,'اتجاه واضح','نظام بصري متسق',NULL,NULL,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(301,101,'en',NULL,NULL,NULL,'Trusted Presence','Building audience trust',NULL,NULL,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(302,101,'fa',NULL,NULL,NULL,'حضور قابل‌اعتماد','ساخت اعتماد مخاطب',NULL,NULL,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(303,101,'ar',NULL,NULL,NULL,'حضور موثوق','بناء ثقة الجمهور',NULL,NULL,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(304,102,'en',NULL,NULL,NULL,'Meaningful Content','Better audience connection',NULL,NULL,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(305,102,'fa',NULL,NULL,NULL,'محتوای معنادار','ارتباط بهتر با مخاطب',NULL,NULL,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(306,102,'ar',NULL,NULL,NULL,'محتوى هادف','تواصل أفضل مع الجمهور',NULL,NULL,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(307,103,'en',NULL,NULL,NULL,'Visual System','We developed a cleaner and more consistent visual language, focused on color, composition, soft hierarchy, and a more recognizable brand presence.',NULL,NULL,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(308,103,'fa',NULL,NULL,NULL,'سیستم بصری','زبان بصری‌ای شفاف‌تر و یکدست‌تر با تمرکز بر رنگ، ترکیب‌بندی و سلسله‌مراتب نرم توسعه دادیم.',NULL,NULL,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(309,103,'ar',NULL,NULL,NULL,'النظام البصري','طورنا لغة بصرية أنظف وأكثر اتساقاً، تركز على اللون والتكوين والتراتب الناعم.',NULL,NULL,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(310,104,'en',NULL,NULL,NULL,'Content Direction','The content was organized around clear pillars: brand story, product value, lifestyle moments, audience education, and trust-building messages.',NULL,NULL,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(311,104,'fa',NULL,NULL,NULL,'جهت‌گیری محتوا','محتوا حول ستون‌های شفافی سازمان یافت: داستان برند، ارزش محصول، لحظات سبک زندگی و پیام‌های اعتمادساز.',NULL,NULL,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(312,104,'ar',NULL,NULL,NULL,'توجيه المحتوى','نُظّم المحتوى حول ركائز واضحة: قصة العلامة وقيمة المنتج ولحظات نمط الحياة ورسائل بناء الثقة.',NULL,NULL,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(313,105,'en',NULL,NULL,NULL,'Publishing Flow','A structured publishing rhythm was created to help the brand stay active, consistent, and aligned across posts, stories, and campaign content.',NULL,NULL,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(314,105,'fa',NULL,NULL,NULL,'جریان انتشار','ریتم انتشار ساختارمندی ایجاد شد تا برند در پست‌ها، استوری‌ها و محتوای کمپین فعال و یکدست بماند.',NULL,NULL,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(315,105,'ar',NULL,NULL,NULL,'تدفق النشر','أُنشئ إيقاع نشر منظم ليبقى العلامة نشطة ومتسقة عبر المنشورات والقصص ومحتوى الحملات.',NULL,NULL,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(316,106,'en',NULL,NULL,NULL,'Audience Focus','The messaging was shaped around people looking for quality, trust, simplicity, and a brand they could connect with beyond the product itself.',NULL,NULL,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(317,106,'fa',NULL,NULL,NULL,'تمرکز بر مخاطب','پیام‌رسانی حول افرادی شکل گرفت که به دنبال کیفیت، اعتماد، سادگی و ارتباطی فراتر از محصول بودند.',NULL,NULL,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(318,106,'ar',NULL,NULL,NULL,'التركيز على الجمهور','صيغت الرسائل حول أشخاص يبحثون عن الجودة والثقة والبساطة وعلامة يتواصلون معها بما يتجاوز المنتج.',NULL,NULL,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(319,107,'en',NULL,NULL,NULL,'Brand Direction','A clearer direction for how Cheshmeh should communicate visually and verbally.',NULL,NULL,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(320,107,'fa',NULL,NULL,NULL,'جهت‌گیری برند','جهتی شفاف‌تر برای نحوه ارتباط بصری و کلامی چشمه.',NULL,NULL,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(321,107,'ar',NULL,NULL,NULL,'توجيه العلامة','اتجاه أوضح لكيفية تواصل تشيشمه بصرياً ولفظياً.',NULL,NULL,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(322,108,'en',NULL,NULL,NULL,'Content Strategy','Content pillars and messaging themes designed around the brand\'s audience and business goals.',NULL,NULL,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(323,108,'fa',NULL,NULL,NULL,'استراتژی محتوا','ستون‌های محتوا و مضامین پیام طراحی‌شده حول مخاطب و اهداف کسب‌وکار.',NULL,NULL,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(324,108,'ar',NULL,NULL,NULL,'استراتيجية المحتوى','ركائز محتوى وموضوعات رسائل مصممة حول جمهور العلامة وأهداف العمل.',NULL,NULL,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(325,109,'en',NULL,NULL,NULL,'Visual System','Reusable layouts, visual rules, and design patterns for social media.',NULL,NULL,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(326,109,'fa',NULL,NULL,NULL,'سیستم بصری','قالب‌ها، قواعد بصری و الگوهای طراحی قابل‌استفاده مجدد برای شبکه‌های اجتماعی.',NULL,NULL,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(327,109,'ar',NULL,NULL,NULL,'النظام البصري','تخطيطات وقواعد بصرية وأنماط تصميم قابلة لإعادة الاستخدام لوسائل التواصل.',NULL,NULL,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(328,110,'en',NULL,NULL,NULL,'Content Calendar','A structured monthly content plan for posts, stories, and campaigns.',NULL,NULL,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(329,110,'fa',NULL,NULL,NULL,'تقویم محتوا','برنامه ماهانه ساختارمند محتوا برای پست‌ها، استوری‌ها و کمپین‌ها.',NULL,NULL,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(330,110,'ar',NULL,NULL,NULL,'تقويم المحتوى','خطة محتوى شهرية منظمة للمنشورات والقصص والحملات.',NULL,NULL,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(331,111,'en',NULL,NULL,NULL,'Story Templates','Flexible story formats for product highlights, brand moments, FAQs, and engagement.',NULL,NULL,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(332,111,'fa',NULL,NULL,NULL,'قالب‌های استوری','فرمت‌های انعطاف‌پذیر استوری برای معرفی محصول، لحظات برند و تعامل.',NULL,NULL,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(333,111,'ar',NULL,NULL,NULL,'قوالب القصص','صيغ قصص مرنة لإبراز المنتج ولحظات العلامة والأسئلة الشائعة والتفاعل.',NULL,NULL,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(334,112,'en',NULL,NULL,NULL,'Campaign Ideas','Creative concepts to support seasonal promotions, awareness, and audience interaction.',NULL,NULL,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(335,112,'fa',NULL,NULL,NULL,'ایده‌های کمپین','مفاهیم خلاقانه برای پشتیبانی از پروموشن‌های فصلی و تعامل مخاطب.',NULL,NULL,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(336,112,'ar',NULL,NULL,NULL,'أفكار الحملات','مفاهيم إبداعية لدعم العروض الموسمية والتوعية وتفاعل الجمهور.',NULL,NULL,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(337,113,'en','+189%',NULL,NULL,'ROI',NULL,NULL,NULL,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(338,113,'fa','+۱۸۹٪',NULL,NULL,'بازگشت سرمایه',NULL,NULL,NULL,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(339,113,'ar','+١٨٩٪',NULL,NULL,'عائد الاستثمار',NULL,NULL,NULL,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(340,114,'en','+154%',NULL,NULL,'Reach',NULL,NULL,NULL,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(341,114,'fa','+۱۵۴٪',NULL,NULL,'دسترسی',NULL,NULL,NULL,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(342,114,'ar','+١٥٤٪',NULL,NULL,'الوصول',NULL,NULL,NULL,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(343,115,'en','+189%',NULL,NULL,'Interaction',NULL,NULL,NULL,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(344,115,'fa','+۱۸۹٪',NULL,NULL,'تعامل',NULL,NULL,NULL,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(345,115,'ar','+١٨٩٪',NULL,NULL,'التفاعل',NULL,NULL,NULL,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(346,116,'en','+256%',NULL,NULL,'Follower',NULL,NULL,NULL,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(347,116,'fa','+۲۵۶٪',NULL,NULL,'دنبال‌کننده',NULL,NULL,NULL,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(348,116,'ar','+٢٥٦٪',NULL,NULL,'المتابعون',NULL,NULL,NULL,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(349,117,'en','+72%',NULL,NULL,'View',NULL,NULL,NULL,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(350,117,'fa','+۷۲٪',NULL,NULL,'بازدید',NULL,NULL,NULL,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(351,117,'ar','+٧٢٪',NULL,NULL,'المشاهدات',NULL,NULL,NULL,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00');
/*!40000 ALTER TABLE `section_item_translations` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `section_items`
--

DROP TABLE IF EXISTS `section_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `section_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `page_section_id` bigint(20) unsigned NOT NULL,
  `sort_order` smallint(5) unsigned NOT NULL DEFAULT 0,
  `is_visible` tinyint(1) NOT NULL DEFAULT 1,
  `icon` varchar(50) DEFAULT NULL COMMENT 'lucide-vue-next icon name',
  `image_path` varchar(500) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `section_items_render_index` (`page_section_id`,`is_visible`,`sort_order`),
  CONSTRAINT `section_items_page_section_id_foreign` FOREIGN KEY (`page_section_id`) REFERENCES `page_sections` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=118 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `section_items`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `section_items` WRITE;
/*!40000 ALTER TABLE `section_items` DISABLE KEYS */;
INSERT INTO `section_items` VALUES
(79,52,0,1,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(80,52,1,1,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(81,52,2,1,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(82,57,0,1,'discovery',NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(83,57,1,1,'strategy',NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(84,57,2,1,'production',NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(85,57,3,1,'approval',NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(86,57,4,1,'publishing',NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(87,57,5,1,'optimization',NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(88,58,0,1,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(89,58,1,1,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(90,58,2,1,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(91,59,0,1,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(92,59,1,1,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(93,59,2,1,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(94,59,3,1,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(95,66,0,1,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(96,66,1,1,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(97,66,2,1,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(98,66,3,1,NULL,NULL,'2026-07-30 15:49:33','2026-07-30 15:49:33'),
(99,72,0,1,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(100,72,1,1,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(101,72,2,1,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(102,72,3,1,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(103,73,0,1,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(104,73,1,1,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(105,73,2,1,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(106,73,3,1,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(107,74,0,1,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(108,74,1,1,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(109,74,2,1,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(110,74,3,1,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(111,74,4,1,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(112,74,5,1,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(113,75,0,1,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(114,75,1,1,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(115,75,2,1,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(116,75,3,1,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00'),
(117,75,4,1,NULL,NULL,'2026-07-30 17:26:00','2026-07-30 17:26:00');
/*!40000 ALTER TABLE `section_items` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `service_translations`
--

DROP TABLE IF EXISTS `service_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `service_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `service_id` bigint(20) unsigned NOT NULL,
  `locale` varchar(5) NOT NULL,
  `title` varchar(200) NOT NULL,
  `slug` varchar(200) NOT NULL COMMENT 'Anchor + filter key, not a route',
  `description` text DEFAULT NULL,
  `features` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'array<string>' CHECK (json_valid(`features`)),
  `image_alt` varchar(300) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `service_translations_unique` (`service_id`,`locale`),
  UNIQUE KEY `service_translations_slug_unique` (`locale`,`slug`),
  KEY `service_translations_locale_index` (`locale`),
  CONSTRAINT `service_translations_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service_translations`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `service_translations` WRITE;
/*!40000 ALTER TABLE `service_translations` DISABLE KEYS */;
INSERT INTO `service_translations` VALUES
(1,1,'en','Branding','branding','Building a clear identity that helps your brand become recognizable, consistent, and memorable across every touchpoint.','[\"Logo design\",\"Visual Identity Development\",\"Brand book creation\",\"Brand consistency systems\",\"Posters\"]','Framed poster reading \"Where identity becomes direction\"','2026-07-29 05:42:01','2026-07-29 05:42:01'),
(2,1,'fa','برندینگ','برندینگ','ساخت هویتی شفاف که برند شما را در هر نقطه تماس قابل تشخیص، یکدست و ماندگار می‌کند.','[\"\\u0637\\u0631\\u0627\\u062d\\u06cc \\u0644\\u0648\\u06af\\u0648\",\"\\u062a\\u0648\\u0633\\u0639\\u0647 \\u0647\\u0648\\u06cc\\u062a \\u0628\\u0635\\u0631\\u06cc\",\"\\u062a\\u062f\\u0648\\u06cc\\u0646 \\u06a9\\u062a\\u0627\\u0628 \\u0628\\u0631\\u0646\\u062f\",\"\\u0633\\u06cc\\u0633\\u062a\\u0645\\u200c\\u0647\\u0627\\u06cc \\u06cc\\u06a9\\u067e\\u0627\\u0631\\u0686\\u06af\\u06cc \\u0628\\u0631\\u0646\\u062f\",\"\\u067e\\u0648\\u0633\\u062a\\u0631\"]','پوستر قاب‌شده با عبارت «جایی که هویت به جهت تبدیل می‌شود»','2026-07-29 05:42:01','2026-07-29 05:42:01'),
(3,1,'ar','الهوية التجارية','الهوية-التجارية','بناء هوية واضحة تجعل علامتك مميزة ومتسقة ولا تُنسى في كل نقطة تواصل.','[\"\\u062a\\u0635\\u0645\\u064a\\u0645 \\u0627\\u0644\\u0634\\u0639\\u0627\\u0631\",\"\\u062a\\u0637\\u0648\\u064a\\u0631 \\u0627\\u0644\\u0647\\u0648\\u064a\\u0629 \\u0627\\u0644\\u0628\\u0635\\u0631\\u064a\\u0629\",\"\\u0625\\u0639\\u062f\\u0627\\u062f \\u062f\\u0644\\u064a\\u0644 \\u0627\\u0644\\u0639\\u0644\\u0627\\u0645\\u0629\",\"\\u0623\\u0646\\u0638\\u0645\\u0629 \\u0627\\u062a\\u0633\\u0627\\u0642 \\u0627\\u0644\\u0639\\u0644\\u0627\\u0645\\u0629\",\"\\u0627\\u0644\\u0645\\u0644\\u0635\\u0642\\u0627\\u062a\"]','ملصق مؤطر يحمل عبارة «حيث تصبح الهوية اتجاهاً»','2026-07-29 05:42:01','2026-07-29 05:42:01'),
(4,2,'en','Content Production','content-production','Creating meaningful content that connects your brand with the right audience.','[\"Social media content creation\",\"Post and story design\",\"Reels and short-form content support\",\"Campaign visuals\",\"Content direction and creative planning\"]','Warm desk setup with laptop, notebook and coffee','2026-07-29 05:42:01','2026-07-29 05:42:01'),
(5,2,'fa','تولید محتوا','تولید-محتوا','ساخت محتوای معنادار که برند شما را به مخاطب درست وصل می‌کند.','[\"\\u062a\\u0648\\u0644\\u06cc\\u062f \\u0645\\u062d\\u062a\\u0648\\u0627\\u06cc \\u0634\\u0628\\u06a9\\u0647\\u200c\\u0647\\u0627\\u06cc \\u0627\\u062c\\u062a\\u0645\\u0627\\u0639\\u06cc\",\"\\u0637\\u0631\\u0627\\u062d\\u06cc \\u067e\\u0633\\u062a \\u0648 \\u0627\\u0633\\u062a\\u0648\\u0631\\u06cc\",\"\\u067e\\u0634\\u062a\\u06cc\\u0628\\u0627\\u0646\\u06cc \\u0631\\u06cc\\u0644\\u0632 \\u0648 \\u0645\\u062d\\u062a\\u0648\\u0627\\u06cc \\u06a9\\u0648\\u062a\\u0627\\u0647\",\"\\u0628\\u0635\\u0631\\u06cc\\u200c\\u0647\\u0627\\u06cc \\u06a9\\u0645\\u067e\\u06cc\\u0646\",\"\\u062c\\u0647\\u062a\\u200c\\u06af\\u06cc\\u0631\\u06cc \\u0645\\u062d\\u062a\\u0648\\u0627 \\u0648 \\u0628\\u0631\\u0646\\u0627\\u0645\\u0647\\u200c\\u0631\\u06cc\\u0632\\u06cc \\u062e\\u0644\\u0627\\u0642\"]','میز کار گرم با لپ‌تاپ، دفترچه و قهوه','2026-07-29 05:42:01','2026-07-29 05:42:01'),
(6,2,'ar','إنتاج المحتوى','إنتاج-المحتوى','إنشاء محتوى هادف يربط علامتك بالجمهور المناسب.','[\"\\u0625\\u0646\\u0634\\u0627\\u0621 \\u0645\\u062d\\u062a\\u0648\\u0649 \\u0648\\u0633\\u0627\\u0626\\u0644 \\u0627\\u0644\\u062a\\u0648\\u0627\\u0635\\u0644\",\"\\u062a\\u0635\\u0645\\u064a\\u0645 \\u0627\\u0644\\u0645\\u0646\\u0634\\u0648\\u0631\\u0627\\u062a \\u0648\\u0627\\u0644\\u0642\\u0635\\u0635\",\"\\u062f\\u0639\\u0645 \\u0627\\u0644\\u0631\\u064a\\u0644\\u0632 \\u0648\\u0627\\u0644\\u0645\\u062d\\u062a\\u0648\\u0649 \\u0627\\u0644\\u0642\\u0635\\u064a\\u0631\",\"\\u0645\\u0631\\u0626\\u064a\\u0627\\u062a \\u0627\\u0644\\u062d\\u0645\\u0644\\u0627\\u062a\",\"\\u062a\\u0648\\u062c\\u064a\\u0647 \\u0627\\u0644\\u0645\\u062d\\u062a\\u0648\\u0649 \\u0648\\u0627\\u0644\\u062a\\u062e\\u0637\\u064a\\u0637 \\u0627\\u0644\\u0625\\u0628\\u062f\\u0627\\u0639\\u064a\"]','مكتب دافئ مع حاسوب محمول ودفتر وقهوة','2026-07-29 05:42:01','2026-07-29 05:42:01'),
(7,3,'en','Marketing Design','marketing-design','Creating visual assets that communicate your message with clarity and impact.','[\"Promotional creative\",\"Campaign assets\",\"Advertising visuals\",\"Presentation and communication materials\"]','Large \"MARKETING\" wall type behind a seated person','2026-07-29 05:42:01','2026-07-29 05:42:01'),
(8,3,'fa','طراحی بازاریابی','طراحی-بازاریابی','ساخت دارایی‌های بصری که پیام شما را شفاف و اثرگذار منتقل می‌کند.','[\"\\u062e\\u0644\\u0627\\u0642\\u06cc\\u062a \\u062a\\u0628\\u0644\\u06cc\\u063a\\u0627\\u062a\\u06cc\",\"\\u062f\\u0627\\u0631\\u0627\\u06cc\\u06cc\\u200c\\u0647\\u0627\\u06cc \\u06a9\\u0645\\u067e\\u06cc\\u0646\",\"\\u0628\\u0635\\u0631\\u06cc\\u200c\\u0647\\u0627\\u06cc \\u062a\\u0628\\u0644\\u06cc\\u063a\\u0627\\u062a\\u06cc\",\"\\u0645\\u0648\\u0627\\u062f \\u0627\\u0631\\u0627\\u0626\\u0647 \\u0648 \\u0627\\u0631\\u062a\\u0628\\u0627\\u0637\\u0627\\u062a\"]','تایپوگرافی بزرگ «MARKETING» روی دیوار پشت فردی نشسته','2026-07-29 05:42:01','2026-07-29 05:42:01'),
(9,3,'ar','تصميم التسويق','تصميم-التسويق','إنشاء أصول بصرية توصل رسالتك بوضوح وتأثير.','[\"\\u0627\\u0644\\u0625\\u0628\\u062f\\u0627\\u0639 \\u0627\\u0644\\u062a\\u0631\\u0648\\u064a\\u062c\\u064a\",\"\\u0623\\u0635\\u0648\\u0644 \\u0627\\u0644\\u062d\\u0645\\u0644\\u0627\\u062a\",\"\\u0627\\u0644\\u0645\\u0631\\u0626\\u064a\\u0627\\u062a \\u0627\\u0644\\u0625\\u0639\\u0644\\u0627\\u0646\\u064a\\u0629\",\"\\u0645\\u0648\\u0627\\u062f \\u0627\\u0644\\u0639\\u0631\\u0636 \\u0648\\u0627\\u0644\\u062a\\u0648\\u0627\\u0635\\u0644\"]','كلمة «MARKETING» كبيرة على الجدار خلف شخص جالس','2026-07-29 05:42:01','2026-07-29 05:42:01'),
(10,4,'en','Social Media Support','social-media-support','Building a consistent social presence through structured content and ongoing support.','[\"Page management\",\"Content structuring\",\"Visual consistency across platforms\",\"Ongoing creative support for digital presence\"]','Hand holding a phone showing analytics','2026-07-29 05:42:01','2026-07-29 05:42:01'),
(11,4,'fa','پشتیبانی شبکه‌های اجتماعی','پشتیبانی-شبکه‌های-اجتماعی','ساخت حضور اجتماعی یکدست از طریق محتوای ساختارمند و پشتیبانی مستمر.','[\"\\u0645\\u062f\\u06cc\\u0631\\u06cc\\u062a \\u0635\\u0641\\u062d\\u0647\",\"\\u0633\\u0627\\u062e\\u062a\\u0627\\u0631\\u062f\\u0647\\u06cc \\u0645\\u062d\\u062a\\u0648\\u0627\",\"\\u06cc\\u06a9\\u067e\\u0627\\u0631\\u0686\\u06af\\u06cc \\u0628\\u0635\\u0631\\u06cc \\u062f\\u0631 \\u067e\\u0644\\u062a\\u0641\\u0631\\u0645\\u200c\\u0647\\u0627\",\"\\u067e\\u0634\\u062a\\u06cc\\u0628\\u0627\\u0646\\u06cc \\u062e\\u0644\\u0627\\u0642 \\u0645\\u0633\\u062a\\u0645\\u0631 \\u0628\\u0631\\u0627\\u06cc \\u062d\\u0636\\u0648\\u0631 \\u062f\\u06cc\\u062c\\u06cc\\u062a\\u0627\\u0644\"]','دستی که گوشی با نمودار تحلیل را نگه داشته','2026-07-29 05:42:01','2026-07-29 05:42:01'),
(12,4,'ar','دعم وسائل التواصل','دعم-وسائل-التواصل','بناء حضور اجتماعي متسق عبر محتوى منظم ودعم مستمر.','[\"\\u0625\\u062f\\u0627\\u0631\\u0629 \\u0627\\u0644\\u0635\\u0641\\u062d\\u0627\\u062a\",\"\\u0647\\u064a\\u0643\\u0644\\u0629 \\u0627\\u0644\\u0645\\u062d\\u062a\\u0648\\u0649\",\"\\u0627\\u0644\\u0627\\u062a\\u0633\\u0627\\u0642 \\u0627\\u0644\\u0628\\u0635\\u0631\\u064a \\u0639\\u0628\\u0631 \\u0627\\u0644\\u0645\\u0646\\u0635\\u0627\\u062a\",\"\\u062f\\u0639\\u0645 \\u0625\\u0628\\u062f\\u0627\\u0639\\u064a \\u0645\\u0633\\u062a\\u0645\\u0631 \\u0644\\u0644\\u062d\\u0636\\u0648\\u0631 \\u0627\\u0644\\u0631\\u0642\\u0645\\u064a\"]','يد تحمل هاتفاً يعرض التحليلات','2026-07-29 05:42:01','2026-07-29 05:42:01');
/*!40000 ALTER TABLE `service_translations` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `services` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `status` varchar(20) NOT NULL DEFAULT 'published',
  `published_at` timestamp NULL DEFAULT NULL,
  `sort_order` smallint(5) unsigned NOT NULL DEFAULT 0,
  `show_on_home` tinyint(1) NOT NULL DEFAULT 1,
  `icon` varchar(50) DEFAULT NULL,
  `image_path` varchar(500) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `services_public_index` (`status`,`published_at`,`sort_order`),
  KEY `services_show_on_home_index` (`show_on_home`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `services`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `services` WRITE;
/*!40000 ALTER TABLE `services` DISABLE KEYS */;
INSERT INTO `services` VALUES
(1,'published','2026-07-29 05:42:01',0,1,'palette','services/branding.webp','2026-07-29 05:42:01','2026-07-29 05:42:01',NULL),
(2,'published','2026-07-29 05:42:01',1,1,'video','services/content-production.webp','2026-07-29 05:42:01','2026-07-29 05:42:01',NULL),
(3,'published','2026-07-29 05:42:01',2,1,'megaphone','services/marketing-design.webp','2026-07-29 05:42:01','2026-07-29 05:42:01',NULL),
(4,'published','2026-07-29 05:42:01',3,1,'share-2','services/social-media-support.webp','2026-07-29 05:42:01','2026-07-29 05:42:01',NULL);
/*!40000 ALTER TABLE `services` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES
('03TcXZkM1PkPvwbBuqCDxbQ55dZ7pMR6mVKgKfW7',NULL,'127.0.0.1','curl/8.20.0','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTDR6MkFWMWVXUURTVEJibGlLZGZOTG05QWZMa0h2Y2x6Sm9SYVUwRCI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMyOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvZW4vY29udGFjdCI7czo1OiJyb3V0ZSI7czo3OiJjb250YWN0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1785447842),
('0MQIbSQkMjSu8SzRomDb9eGAcUSRytxRvzLW8YMg',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.120.0 Chrome/142.0.7444.265 Electron/39.8.8 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiU2hhVW1ldG02aWFGZ1ExTlIwOTBSdHE1QU5zWWNxekRHdXB5bkVBMCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjQ6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9lbiI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo2OiJsb2NhbGUiO3M6MjoiZW4iO30=',1785952893),
('1FEqV4PgMdZhFoweQXt7J6knSA8ocdPb2RhIin2A',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/145.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUTBMMHJBQkxwRE54ZnBObDlrcVlGTnhSN3FJdUVIT3lPb0ZBNm94MiI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMwOiJodHRwOi8vMTI3LjAuMC4xOjgwMDEvZW4vYWJvdXQiO3M6NToicm91dGUiO3M6NToiYWJvdXQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1785443964),
('1O3nkH9Omfg2CieHUTvam8XcLkYXeP8aVGNfe1U4',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.120.0 Chrome/142.0.7444.265 Electron/39.8.8 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVk1pT3VHU0diYXBJV21mYll1NlpiaWRrS3RRN3VFSkl0emZDaWhyaCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9lbiI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo2OiJsb2NhbGUiO3M6MjoiZW4iO30=',1785952197),
('1yp7JqoVeDlKSsrYsDF1zBzcLxF1zA3i1EUJ7TWM',1,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36','YTo5OntzOjY6Il90b2tlbiI7czo0MDoiTXJkb21WVmtOdlI3NG9iSDd3alZtdmx1RE5XcWNWSFdvTG5NM085NyI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjM3OiJodHRwOi8vbG9jYWxob3N0OjgwMDAvYWRtaW4vcmVkaXJlY3RzIjtzOjU6InJvdXRlIjtzOjQwOiJmaWxhbWVudC5hZG1pbi5yZXNvdXJjZXMucmVkaXJlY3RzLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MDp7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czoxNzoicGFzc3dvcmRfaGFzaF93ZWIiO3M6NjQ6ImEzMjg2ZmRmYTY5MWU3ZjgzNTlhODk3OGQwYjJjMzBhMzgwZjFhZTZmNjFkOWMwNWQwNzcyODgxMDAzODRmZjMiO3M6ODoiZmlsYW1lbnQiO2E6MDp7fXM6MTI6ImFkbWluX2xvY2FsZSI7czoyOiJmYSI7fQ==',1785449754),
('2rVX248SvtFlgV4qQp95Hqckblz6OkNM86vFXdHs',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/150.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiN2YweWt6d2pFVDhQcjNNOTNhd0ZCMnNQQUdDWWxUa0dvNHBDRUM3TiI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMyOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvZW4vY29udGFjdCI7czo1OiJyb3V0ZSI7czo3OiJjb250YWN0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1785448310),
('4SYHijqLKWtUV0RhUzicT2trqylWF0Kd752SG10t',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/145.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoidkM4eWJzTTFQNHZla2J1S0h0SFZEZnBGYmpCRWFsYjRlWDdTWTUyUiI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjU5OiJodHRwOi8vMTI3LjAuMC4xOjgwMDEvZW4vaW5zaWdodHMvY29udGVudC13aXRob3V0LWRpcmVjdGlvbiI7czo1OiJyb3V0ZSI7czoxMzoiaW5zaWdodHMuc2hvdyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1785444553),
('52V2oanzRcV29zeOO22hjHm20oNafrGCKj2vwHCw',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/150.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoib1NLcmdVSjNmWUpFbjNvZlFXVGNtc3ZpeVVNQmUxN3YyWm5uNGlrZCI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMyOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvZW4vY29udGFjdCI7czo1OiJyb3V0ZSI7czo3OiJjb250YWN0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1785448087),
('62FAKkfS0vRFuPrySN0UWkRxmyYwTFFzPNrodUFi',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/145.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUmJOS1RHZjg5U1lTcHh0amVwSjN6UVdIZGhMUGVSbkphUFJOcHBkYiI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjM5OiJodHRwOi8vMTI3LjAuMC4xOjgwMDEvZW4vcHJpdmFjeS1wb2xpY3kiO3M6NToicm91dGUiO3M6MTM6ImxlZ2FsLnByaXZhY3kiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1785445204),
('7y6hx2GJbtSl4XuuY6GmEDMDXcwIawlyWhYJ6PPX',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/145.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoieFVFYUpTYmQwOVNJSmNRaXl1ZXJic3cxYW9ZRkpkVHoyZ0tmWmlUeiI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMyOiJodHRwOi8vMTI3LjAuMC4xOjgwMDEvZW4vY29udGFjdCI7czo1OiJyb3V0ZSI7czo3OiJjb250YWN0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1785445203),
('9evhKO6VV4rQv5Auhg4ZRR9PYxwA9QnXQUQYhJXW',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/145.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMGx5MzNVeERsZkEzRjEzM1lDam5sWFhkRWlkVzdOSUpjTjRHcElHYyI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMyOiJodHRwOi8vMTI3LjAuMC4xOjgwMDEvZW4vY29udGFjdCI7czo1OiJyb3V0ZSI7czo3OiJjb250YWN0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1785444978),
('AxEUBwOLEi8060MbQmPcId6HaTJvJOK5kPrbGkmy',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/145.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMGhVU2lmaVF0N1dRZXc5dWVZOGlSeHl3NkU1T0lrcmdjR05NcHpmVyI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMwOiJodHRwOi8vMTI3LjAuMC4xOjgwMDEvZW4vYWJvdXQiO3M6NToicm91dGUiO3M6NToiYWJvdXQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1785445756),
('aY4ztk2Gxc8TxyAYwOr5bVnesI6DbuBw2Yq1UBWA',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/145.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoic1NXN3hQemdndVpORnNxTDBOYWQ0R0Z3cjNQR3hKM0FmRHRISVc1MCI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjM5OiJodHRwOi8vMTI3LjAuMC4xOjgwMDEvZW4vcHJpdmFjeS1wb2xpY3kiO3M6NToicm91dGUiO3M6MTM6ImxlZ2FsLnByaXZhY3kiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1785445433),
('bBK9ux6zlCgyrYdKmeFYkyzm42ltz3eLpPyEjXIz',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/145.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVVl1OUpBTHQzWEhzZzAza09pWmRQU0xOV1BTY2ppQW9QdVhNeWNsNSI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMwOiJodHRwOi8vMTI3LjAuMC4xOjgwMDEvZW4vYWJvdXQiO3M6NToicm91dGUiO3M6NToiYWJvdXQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1785443919),
('cJa7oA5xoRttaOVCv09pfpdfBGzYP0gdnm2IQTqv',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoick9HdlM4bllURE1CMnZWOG5qRHJCRUViQzMzRW1rck1PSUp1emxuYSI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjczOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvZW4vLndlbGwta25vd24vYXBwc3BlY2lmaWMvY29tLmNocm9tZS5kZXZ0b29scy5qc29uIjtzOjU6InJvdXRlIjtOO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1785843748),
('csN3gn1qPIUj9pab5t1IlqGBC8WLrtxYhXpoSxXc',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/150.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiYk9kWGpIOE5RcnhIS3RrTElPU3ljcFo0cUhGT1dYaTRZeXd5YVVFaCI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMyOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvZW4vY29udGFjdCI7czo1OiJyb3V0ZSI7czo3OiJjb250YWN0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1785448228),
('cyFT01Pg1q8bqYSegnzUi2jTIaG538afgFTY9Nve',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/145.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiYlRlSkloWERaaGFJbTFSSHFQUGs0MzN0NHc3VVlSZnBPVEZqbkY2NCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMS9lbi9kZWZpbml0ZWx5LW1pc3NpbmciO3M6NToicm91dGUiO047fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1785445435),
('E8XCvtzPYh2z14Q1GdTac70GaZnutGSFJ10YYotg',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/145.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQjZzQ0NzTENHN1dxSWIzc084TlFOTXh1djBPRFIzRnlkRmhzMmJGVSI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMzOiJodHRwOi8vMTI3LjAuMC4xOjgwMDEvZW4vaW5zaWdodHMiO3M6NToicm91dGUiO3M6MTQ6Imluc2lnaHRzLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1785445430),
('EGbceGzzNTbA4ckL6wXAfFY2MkE6Msp1UANYh4hA',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/145.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiaGRJTnlpTWZrYU9meUxOTnhDeHZlRVRyRWlnbWZSZnVPaUZJRldKcCI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMwOiJodHRwOi8vMTI3LjAuMC4xOjgwMDEvZW4vdGVybXMiO3M6NToicm91dGUiO3M6MTE6ImxlZ2FsLnRlcm1zIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1785445205),
('EhVniy7Y6A41gVnOEuhjIhcv4LeehpqM5TdAlXWd',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/145.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTW1jZUVCbFdTTXZpNzRxekF0M2tXa050a2FLQktMY3NVM3hybk5POCI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMzOiJodHRwOi8vMTI3LjAuMC4xOjgwMDEvZW4vc2VydmljZXMiO3M6NToicm91dGUiO3M6ODoic2VydmljZXMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1785445198),
('fJjw9HeT6rEdI0Emgjh7radhkDUue1aYZdXzhjb9',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMmxrVkVBdXJUTVpLNElwd0pGOFZRaEFEVmMydG5WYzg1YXFyaXdLeCI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjI0OiJodHRwOi8vbG9jYWxob3N0OjgwMDAvZW4iO3M6NToicm91dGUiO3M6NDoiaG9tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1785952903),
('fTtbZ8tthprpftGuKVIIBlXGd8IdIzUXUDeB60tG',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/145.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiakdyTlN1OERrNG1QaEFEN2hUVEJpNE9kSWZMMlNMQ0ZDeGdJMGZNTyI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjQ1OiJodHRwOi8vMTI3LjAuMC4xOjgwMDEvZW4vd29yay9jaGVzaG1laC1iZWF1dHkiO3M6NToicm91dGUiO3M6OToid29yay5zaG93Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1785444814),
('gekdqIMsC3onfuCJ2k6Co84aCnUR6KtfY3L8losh',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/145.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiYkV5bFVkb3h0dld0MXM0Qk83U0dtWUdsTUg2QTF1SmRjRHY2OGRzMCI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjQ1OiJodHRwOi8vMTI3LjAuMC4xOjgwMDEvZW4vd29yay9jaGVzaG1laC1iZWF1dHkiO3M6NToicm91dGUiO3M6OToid29yay5zaG93Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1785445425),
('giMV7hZJHyHKKz3GIBy23v4mcj56gnp3lemQb46E',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/145.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSXNKVXlDQ0VrR0I3aVFvU1JxREg5b1pucTllZlkybUZwZlVudjFyRyI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjI0OiJodHRwOi8vMTI3LjAuMC4xOjgwMDEvZW4iO3M6NToicm91dGUiO3M6NDoiaG9tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1785444545),
('gNJRz1OdFCw40YluZpDimAaTkkI1fFojuywVMNGM',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/145.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoibndpVmxpWG9sVm1GNWc1OUFnY3NoRmVjZGQ1Vm9UUnlNbVk3aUNRNSI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjI5OiJodHRwOi8vMTI3LjAuMC4xOjgwMDEvZW4vd29yayI7czo1OiJyb3V0ZSI7czoxMDoid29yay5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1785445195),
('HcUC7enpMgVbRDAT8tyn7gkV0ucEdP5WiFgGqXpE',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/145.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSnBOU3RXQlJLQVNkTTlnc21Sdk1vWEpxRFI1aHNTZXRxSUlLZEM5YiI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMzOiJodHRwOi8vMTI3LjAuMC4xOjgwMDEvZW4vaW5zaWdodHMiO3M6NToicm91dGUiO3M6MTQ6Imluc2lnaHRzLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1785444975),
('HvzHY5K68TqkLR6b2ygwMSRnK3MDY3mtAhgXhihf',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/145.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoia3ZLSUZPc2liTUJzdnpBejJ2WHB1c2pyS2MzZHhnYmlzaVVTYU0xciI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMyOiJodHRwOi8vMTI3LjAuMC4xOjgwMDEvZW4vY29udGFjdCI7czo1OiJyb3V0ZSI7czo3OiJjb250YWN0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1785444554),
('ibkeqx2EVMNgkUAE503LJtqJEw6rMOw0wlGAXrwJ',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/145.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWERqNlhQUUxFbkQxdFY0M1dPMmxWb0VSWktVSEtwcnExYmQwcmxUWCI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMyOiJodHRwOi8vMTI3LjAuMC4xOjgwMDEvZW4vY29udGFjdCI7czo1OiJyb3V0ZSI7czo3OiJjb250YWN0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1785444027),
('iSIeOFqlVGtip9XAJ15gipVljwU0h3ONgqijW3rL',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/145.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiaHVuNHdnTE5oTHk1V2xuWUJkcUM3REdyZFhQWms1TUZkYnhNSkxROSI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMzOiJodHRwOi8vMTI3LjAuMC4xOjgwMDEvZW4vaW5zaWdodHMiO3M6NToicm91dGUiO3M6MTQ6Imluc2lnaHRzLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1785445516),
('IyIOCm7ytlY8qaljm6eEkUBiAecoXFSZIM0ovqkb',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/145.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiV21ROE13TVhVYTFhUVFrbDZJVkdtWXk1c1hmSHBPMVlJY2NTZDNvSyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMS9lbi9kZWZpbml0ZWx5LW1pc3NpbmciO3M6NToicm91dGUiO047fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1785445206),
('IZJ3naS6nj2lAHLUVZItO6Vsf9vLFX3hcKjHMy9O',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/145.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoidVZUYnlsVkx2Mk01R0dzMGJVTHhEOTlCRXZEMXJpemF2WFVXcHRkeiI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMwOiJodHRwOi8vMTI3LjAuMC4xOjgwMDEvZW4vYWJvdXQiO3M6NToicm91dGUiO3M6NToiYWJvdXQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1785445023),
('JRAsmNp0Qx2Zu8LtNHYeETFMedite7XgBKPIBK6I',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQ0NKa0lSRnRKZHVyTnJCM1NlbG1kenh4Y09WRElJSXhxYmxSYnFxNSI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjI0OiJodHRwOi8vbG9jYWxob3N0OjgwMDAvZW4iO3M6NToicm91dGUiO3M6NDoiaG9tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1785610578),
('K5pWDhHgVvRY6zmxwrCBxIFtlN8Xrc7oOEOz3NIf',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/150.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiaTlESUVEcXdwT0pLT0lVa2ZrUGxQRTl2THl3NkdCWnlYYm40NmQwQiI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMyOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvZW4vY29udGFjdCI7czo1OiJyb3V0ZSI7czo3OiJjb250YWN0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1785448230),
('KvGQyz29WNR67kVlCSOp4D9OZkVl0TPOyb12w1Uo',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/145.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRHhnZUJCT04xcUhKcjZ4T2dqMW1heERNb2V0UWRDWkU4Y3QzT2FidyI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMwOiJodHRwOi8vMTI3LjAuMC4xOjgwMDEvZW4vdGVybXMiO3M6NToicm91dGUiO3M6MTE6ImxlZ2FsLnRlcm1zIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1785445434),
('kWuKykZ6WYkPXqJt3R0Qs17wbaUSl8bWNagQIsOz',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/150.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRnVYWVRhYU1HZ1Nia0NPOW53eHhTQ2E5WXlaR1dmR0NVQWV5Wko4RSI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMyOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvZW4vY29udGFjdCI7czo1OiJyb3V0ZSI7czo3OiJjb250YWN0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1785448026),
('Lf2Ot40FIGHuV5v5BoieXm7F32FVjYOIGv7KdvRa',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.120.0 Chrome/142.0.7444.265 Electron/39.8.8 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiYXBpNFRmdHZsS2V6ZHNITkVVTE4xZ1VXbWtXVjVCRjRISVBlQTloVyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjQ6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9lbiI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo2OiJsb2NhbGUiO3M6MjoiZW4iO30=',1785443183),
('LfTXdWxEDjLhjTdlAXeCuVcE5xMLbOo0Gmri4Pll',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/145.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoialllRktrQURsUnY4dVd4eWhXNndmdHl3bjJMaTZ4bHdLb2FBb3NheCI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMwOiJodHRwOi8vMTI3LjAuMC4xOjgwMDEvZW4vYWJvdXQiO3M6NToicm91dGUiO3M6NToiYWJvdXQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1785444550),
('lHV1gQdQAPsxx1Y9KOYrxlwfIIZuTytLT9rz9iBC',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiYjc5dGlzdk9jd29NdWJsTTdwWWJ1SGJxV2p5aG1VbERkRVRiaTRUbCI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjI0OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvZW4iO3M6NToicm91dGUiO3M6NDoiaG9tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1785952217),
('lnksLRRHTyrV1E0aXZ90DKQ3blN4fPcvmeBh202D',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/145.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiOEVNWnR2U3d3SDdCelBWZlBTT0U4WDVaRnlIOGh2SU42NzNzRDdPOSI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjQ1OiJodHRwOi8vMTI3LjAuMC4xOjgwMDEvZW4vd29yay9jaGVzaG1laC1iZWF1dHkiO3M6NToicm91dGUiO3M6OToid29yay5zaG93Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1785445196),
('lVq5Fk33zTaHH0UFLuXkek4YYBlJIVdzV9HS5Jen',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/145.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiOVpPcFMwS1VqblBjMmU3UDJNR1BCNm1IZXFSUWlwaWlyQ01NcmRNUyI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjI0OiJodHRwOi8vMTI3LjAuMC4xOjgwMDEvZW4iO3M6NToicm91dGUiO3M6NDoiaG9tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1785445422),
('LycIT7tqge6BauVhh5pHcay3YRj1NBco5glqUGBS',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/145.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTGZCczJFWW5UY2JBWjByRnZHek5MajJpN3RhclY1dHZNbnZYdldYQSI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjI5OiJodHRwOi8vMTI3LjAuMC4xOjgwMDEvZW4vd29yayI7czo1OiJyb3V0ZSI7czoxMDoid29yay5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1785445424),
('nHhRRw9fhvMfEGc1NPfDFYpxLokJSatln3WuHnwf',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/145.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiV0VEeXNCWDZKRzZxWUFtRWRnY05RS2ZzTEN1MXBsS3NnVzh3clZzcyI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjI5OiJodHRwOi8vMTI3LjAuMC4xOjgwMDEvZW4vd29yayI7czo1OiJyb3V0ZSI7czoxMDoid29yay5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1785444547),
('nT3cleOs8IlEkEMLTSW2gex1S179YylbOFtVjxjr',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/145.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRVZKcXo1UDMzb1o5YVQ5Z1ZxTllTUTdnd1k0anNPNnpSa3VwN2xmeCI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMzOiJodHRwOi8vMTI3LjAuMC4xOjgwMDEvZW4vc2VydmljZXMiO3M6NToicm91dGUiO3M6ODoic2VydmljZXMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1785445427),
('Nx9zE4cgTdJfb5VnFJtxyXzCuTDqJarSACct2s5d',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/150.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZDRSM0Z2eUNIaXBWR2RyNHFQMm1wb1NSeEZjdEFqRmFadTZVSGl6TCI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMyOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvZW4vY29udGFjdCI7czo1OiJyb3V0ZSI7czo3OiJjb250YWN0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1785447853),
('OAk7EoKqa0fiMiGmkUxnbRKgna3U3FiwAlTNILGd',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/145.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQm1tbTlOYlF0OElVQzc3R1NSRnpSVnlRcFlxZGt6d0pidXNKSlNCZCI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMwOiJodHRwOi8vMTI3LjAuMC4xOjgwMDEvZW4vYWJvdXQiO3M6NToicm91dGUiO3M6NToiYWJvdXQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1785445428),
('OF6G5llrkuCUIFHchSHjqVk8sfug8KgQ8YKxPlO3',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/145.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQjUwOUZyTllqZ3plZ0prQWE2T2RUNFoxb3VJOTdhVFhXeHhsMnVwZCI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjQ2OiJodHRwOi8vMTI3LjAuMC4xOjgwMDEvZW4vd29yay9iYWdoY2hlLWJyYW5kaW5nIjtzOjU6InJvdXRlIjtzOjk6Indvcmsuc2hvdyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1785444548),
('p4hqQvu24lcorVO9u8QLSPnnprGZAHBGOHtx3rMt',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/145.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSGdHUGpSYkhwUmtMVGxyRlFRUE1Ta2NmVXdVTGljRzZGTUR5cGh0UCI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjQ1OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvZW4vd29yay9jaGVzaG1laC1iZWF1dHkiO3M6NToicm91dGUiO3M6OToid29yay5zaG93Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1785446997),
('PbZ5r7lb67i90uf9yFDP9pzi0vW76DeUEuGOum70',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/145.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoib3QzQ2VmQjl6bTZYc0czbEdnejl2QURjRWU1cldiRUFPSldPeFJlZiI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjQ1OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvZW4vd29yay9jaGVzaG1laC1iZWF1dHkiO3M6NToicm91dGUiO3M6OToid29yay5zaG93Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1785447460),
('PM1bqaSaJmvCZyE0bRcaiDH4UDqZnXJGjNOH3fEY',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/145.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiczFteVFYaWpveEk3S1VoQTh3NUZPdE1YSXBsNjB1QWpqSlhiaEhyZyI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjI0OiJodHRwOi8vMTI3LjAuMC4xOjgwMDEvZW4iO3M6NToicm91dGUiO3M6NDoiaG9tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1785445193),
('PUQ7Qwm6K1ytKbbnkqLoaMoW9Vk1L3IrDN3T4p3y',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/145.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUjRldDlxNWZzRG0wajRzM2NLOEJOUXJSTnQzdFptMUk2SW9pR3FTWSI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMyOiJodHRwOi8vMTI3LjAuMC4xOjgwMDEvZW4vY29udGFjdCI7czo1OiJyb3V0ZSI7czo3OiJjb250YWN0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1785445432),
('PwwvLR9tOFoU19DGsTzDVnNC6ceOAozsp7R0J6bs',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.120.0 Chrome/142.0.7444.265 Electron/39.8.8 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMnpTY2hNTFRHNHQ0QzhDOVBOV0ZVWDkzeFVvSVc3UmZUZ0xOSUlsNCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjQ6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9lbiI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo2OiJsb2NhbGUiO3M6MjoiZW4iO30=',1785842178),
('QLOWK2diiEHtxTjBzxs6DsqAlEoDcT3i94NiWqIr',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/150.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZnRWTDBYZWs1SU9tMUdyQm5wdkxEYjlKZkFlb2l6UDBhUUVIQ1pubyI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMyOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvZW4vY29udGFjdCI7czo1OiJyb3V0ZSI7czo3OiJjb250YWN0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1785448309),
('rTJk9U3q9elDSmSnN4bhEfCpwxEo5dXttCOcW04P',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/145.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoid1VzRXc4ZEV6UU5uYnJGQjZDelJGeFo4ZjFOTFlUVTdnVDlPOWdRUyI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMwOiJodHRwOi8vMTI3LjAuMC4xOjgwMDEvZW4vYWJvdXQiO3M6NToicm91dGUiO3M6NToiYWJvdXQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1785445041),
('RxFztkLJrvr5v1FTy4uu0SMED5I68p4TJQL4JrxM',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/145.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoicjNuUXBwbEJkN1l0MGg5cU1LQ01vZndwZ0xpQkNDMk91dHJuNjMyMyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMS9lbi9kZWZpbml0ZWx5LW1pc3NpbmciO3M6NToicm91dGUiO047fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1785444557),
('s1Ne7SZZY8OyCoDdZjmTXlhc9Eb081KiOv4GQQ5K',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/145.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiY3RVTjFGVzg2cm1jQjZtM1pMVzZDSGNEQWRPVExLdDdtUUhWaFVjciI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMwOiJodHRwOi8vMTI3LjAuMC4xOjgwMDEvZW4vdGVybXMiO3M6NToicm91dGUiO3M6MTE6ImxlZ2FsLnRlcm1zIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1785444556),
('tMM10fJWTxiWzxUIcPYVfus2nRojvXFoYmKdJqMP',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/145.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiM3p6SXVLYU1yTFJNUzk0REpQakxQbTh3MXJOQmFBVXpwT0dWb2hkViI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjI0OiJodHRwOi8vMTI3LjAuMC4xOjgwMDEvZW4iO3M6NToicm91dGUiO3M6NDoiaG9tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1785444025),
('u2ojmEpObLGCRQkWAl80cTJBgLXeCqmAE67QKKTX',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/145.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRTNPeEZGdVFCMERDVTVJOGJGQmZocmtYSHMySWltZm90Q3NoWUtQcCI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMzOiJodHRwOi8vMTI3LjAuMC4xOjgwMDEvZW4vaW5zaWdodHMiO3M6NToicm91dGUiO3M6MTQ6Imluc2lnaHRzLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1785444028),
('U9WPhAB5pkdLaU8Sh1Whe2vI5l81I1908WHa6MBr',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/145.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoicjIxbGlENVkzbFd1VlVzSWNNWXV0eGNWTldsRUs3VmpRQmt3Qld1diI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMwOiJodHRwOi8vMTI3LjAuMC4xOjgwMDEvZW4vYWJvdXQiO3M6NToicm91dGUiO3M6NToiYWJvdXQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1785444974),
('udZIfc3e8p5L2nf2K4nnBQRohjOIfEPNc4KNNlT8',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/145.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSHl5dnVSTmRMMlVaUGk0eE90SkxWUERkbnZPdXJLMnAxbEhtOGF3MyI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjI0OiJodHRwOi8vMTI3LjAuMC4xOjgwMDEvZW4iO3M6NToicm91dGUiO3M6NDoiaG9tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1785444008),
('UplkWnX4KSuOrnOdvSebRIZZYAvJaog7ueY4DEt7',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/145.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiS3R4ZkpZY3BlZnVXcEhkN2ZCS3E4Z2o4WnZZaTNTY2xSMFpjZUNZdCI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMzOiJodHRwOi8vMTI3LjAuMC4xOjgwMDEvZW4vc2VydmljZXMiO3M6NToicm91dGUiO3M6ODoic2VydmljZXMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1785444549),
('uYeNanwBdSODlj7JwQ2IXkZUOcu36oTJxkUvIc0J',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/145.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVnlHN2Z3VHd5aWk4d1VTY3ludDZKdW9hTFd0V2VTdUtLTEc4b2s3ZiI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMzOiJodHRwOi8vMTI3LjAuMC4xOjgwMDEvZW4vaW5zaWdodHMiO3M6NToicm91dGUiO3M6MTQ6Imluc2lnaHRzLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1785444551),
('VCEX9kbavoXMq2lWepBRbJAIQbq2XGBKsxieyIXB',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/150.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoidFJPQ2RIcGQxeFlRdkFXUE5meWxRcHJNRWp5SEEwaVpuRENNdHliTiI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMyOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvZW4vY29udGFjdCI7czo1OiJyb3V0ZSI7czo3OiJjb250YWN0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1785447975),
('VCZT2zEIXgFmeBLrI17xhiTogY1AXexIxJUH9apM',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/150.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRHoycHU0aUZJbUI4ejA3VHJMdW9JSWNKaTFGS0c3bTBYYm1WVE5JTyI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMyOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvZW4vY29udGFjdCI7czo1OiJyb3V0ZSI7czo3OiJjb250YWN0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1785448143),
('vkCPDV3zSmdw7jW54LgKIcJxOI6ECV1RJZ3vvK16',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/145.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVFhTYnBjQmlvWUd1TjN2TVBkcUFERjdpeGdhRjVYcHV1ZkNUSFZZdCI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMwOiJodHRwOi8vMTI3LjAuMC4xOjgwMDEvZW4vYWJvdXQiO3M6NToicm91dGUiO3M6NToiYWJvdXQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1785445199),
('vPJTZsPmTMmSm51uTmBlz83g0AI8EPhG3ctIpkKM',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/145.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSENjMEdaMGpuMVBkV3NVNkVVc0xBUFdtV3Z3d2VyRHNZaVVJR3NuViI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMzOiJodHRwOi8vMTI3LjAuMC4xOjgwMDEvZW4vaW5zaWdodHMiO3M6NToicm91dGUiO3M6MTQ6Imluc2lnaHRzLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1785445200),
('vTkbvMzvKRFxPwNwJdid0qQAZQnv8iWcjn1OE3zg',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.120.0 Chrome/142.0.7444.265 Electron/39.8.8 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMmU4Y1lzbEZQWlNHNXVKS3hGSFJTc3RxUk1Rd2I1WHJHUk04Q0VEbiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjQ6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9lbiI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo2OiJsb2NhbGUiO3M6MjoiZW4iO30=',1785610535),
('WhYDeMtL4MxH4IzCHcrPs9bJX2CaDk1l3gDzRXPV',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/145.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiT0Vrd3l5RWhhejFYTnVBdEJSelJ5akZpYUM3QUtjQ3JpWXVEa3ZCaSI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjU5OiJodHRwOi8vMTI3LjAuMC4xOjgwMDEvZW4vaW5zaWdodHMvY29udGVudC13aXRob3V0LWRpcmVjdGlvbiI7czo1OiJyb3V0ZSI7czoxMzoiaW5zaWdodHMuc2hvdyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1785445202),
('wmCqReWJhl0B24POXWP44rvvjrwIXWGoBnKi8j14',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/145.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRVd2YVhXU1oxM0VKYjZhTmFjYlg1VlBuN2pjajZTakk2T3JMTlIzNiI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjU5OiJodHRwOi8vMTI3LjAuMC4xOjgwMDEvZW4vaW5zaWdodHMvY29udGVudC13aXRob3V0LWRpcmVjdGlvbiI7czo1OiJyb3V0ZSI7czoxMzoiaW5zaWdodHMuc2hvdyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1785445518),
('Y7fif0ChbfSENayj60hjFXwoPeUeg0vywgXxI7n2',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/145.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZzlnNDk1allsU0VwODNQaXNhaEtmeUppblZqaG9JRE5JcVJaNFBIQiI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjM5OiJodHRwOi8vMTI3LjAuMC4xOjgwMDEvZW4vcHJpdmFjeS1wb2xpY3kiO3M6NToicm91dGUiO3M6MTM6ImxlZ2FsLnByaXZhY3kiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1785444555),
('ZCQVOkCnqzTTUhS76kpaMnH6t19KbtnG6sP7BHWg',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/145.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQlJleWJXNTdrd2ZNNEN1T0dGcFZiVzgwSkluOXdQUmVTVnJKRGFobCI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjQ1OiJodHRwOi8vMTI3LjAuMC4xOjgwMDEvZW4vd29yay9jaGVzaG1laC1iZWF1dHkiO3M6NToicm91dGUiO3M6OToid29yay5zaG93Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1785444977),
('zdQUSzGEgEDLF0siu7f2faakMnqpqkFE2lbbQsis',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/145.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVWZFN1VGZjVIVGJndmxINHdoaUxSbFVENzl5QXVrRHdqMjF5QUVnZSI7czo2OiJsb2NhbGUiO3M6MjoiZW4iO3M6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjU5OiJodHRwOi8vMTI3LjAuMC4xOjgwMDEvZW4vaW5zaWdodHMvY29udGVudC13aXRob3V0LWRpcmVjdGlvbiI7czo1OiJyb3V0ZSI7czoxMzoiaW5zaWdodHMuc2hvdyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1785445431),
('zEFcH1kNAlBKdtX8cOxvDXKFQmC4IA4Vjn9AL9ue',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/145.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiejFHS1lvb0RzbUM1MWtSbmZiV3BJRWMwNDR3c0RoWDd3OVVGZU1wTCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMS9lbi9kZWZpbml0ZWx5LW1pc3NpbmciO3M6NToicm91dGUiO047fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1785445519);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL DEFAULT 'general',
  `value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`value`)),
  `is_translatable` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_key_unique` (`key`),
  KEY `settings_group_index` (`group`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES
(1,'site_name','general','{\"en\":\"Sahra\",\"fa\":\"\\u0635\\u062d\\u0631\\u0627\",\"ar\":\"\\u0635\\u062d\\u0631\\u0627\\u0621\"}',1,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(2,'tagline','general','{\"en\":\"See the Horizon\",\"fa\":\"\\u0627\\u0641\\u0642 \\u0631\\u0627 \\u0628\\u0628\\u06cc\\u0646\",\"ar\":\"\\u0627\\u0646\\u0638\\u0631 \\u0625\\u0644\\u0649 \\u0627\\u0644\\u0623\\u0641\\u0642\"}',1,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(3,'footer_description','general','{\"en\":\"We help brands move from scattered content to structured direction.\",\"fa\":\"\\u0645\\u0627 \\u0628\\u0647 \\u0628\\u0631\\u0646\\u062f\\u0647\\u0627 \\u06a9\\u0645\\u06a9 \\u0645\\u06cc\\u200c\\u06a9\\u0646\\u06cc\\u0645 \\u0627\\u0632 \\u0645\\u062d\\u062a\\u0648\\u0627\\u06cc \\u067e\\u0631\\u0627\\u06a9\\u0646\\u062f\\u0647 \\u0628\\u0647 \\u0645\\u0633\\u06cc\\u0631\\u06cc \\u0633\\u0627\\u062e\\u062a\\u0627\\u0631\\u0645\\u0646\\u062f \\u0628\\u0631\\u0633\\u0646\\u062f.\",\"ar\":\"\\u0646\\u0633\\u0627\\u0639\\u062f \\u0627\\u0644\\u0639\\u0644\\u0627\\u0645\\u0627\\u062a \\u0627\\u0644\\u062a\\u062c\\u0627\\u0631\\u064a\\u0629 \\u0639\\u0644\\u0649 \\u0627\\u0644\\u0627\\u0646\\u062a\\u0642\\u0627\\u0644 \\u0645\\u0646 \\u0627\\u0644\\u0645\\u062d\\u062a\\u0648\\u0649 \\u0627\\u0644\\u0645\\u0628\\u0639\\u062b\\u0631 \\u0625\\u0644\\u0649 \\u0627\\u062a\\u062c\\u0627\\u0647 \\u0645\\u0646\\u0638\\u0645.\"}',1,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(4,'contact_whatsapp','general','{\"value\":\"+96 7781 1213\"}',0,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(5,'contact_phone','general','{\"value\":\"+96 7781 1213\"}',0,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(6,'contact_email','general','{\"value\":\"Sahramarketing@gmail.com\"}',0,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(7,'contact_location','general','{\"en\":\"Muscat, Oman\",\"fa\":\"\\u0645\\u0633\\u0642\\u0637\\u060c \\u0639\\u0645\\u0627\\u0646\",\"ar\":\"\\u0645\\u0633\\u0642\\u0637\\u060c \\u0639\\u064f\\u0645\\u0627\\u0646\"}',1,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(8,'contact_working_with','general','{\"en\":\"Brands in Oman and Beyond\",\"fa\":\"\\u0628\\u0631\\u0646\\u062f\\u0647\\u0627\\u06cc\\u06cc \\u062f\\u0631 \\u0639\\u0645\\u0627\\u0646 \\u0648 \\u0641\\u0631\\u0627\\u062a\\u0631 \\u0627\\u0632 \\u0622\\u0646\",\"ar\":\"\\u0639\\u0644\\u0627\\u0645\\u0627\\u062a \\u062a\\u062c\\u0627\\u0631\\u064a\\u0629 \\u0641\\u064a \\u0639\\u064f\\u0645\\u0627\\u0646 \\u0648\\u062e\\u0627\\u0631\\u062c\\u0647\\u0627\"}',1,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(9,'seo_default_title','seo','{\"en\":\"Sahra \\u2014 Digital Marketing Agency in Muscat\",\"fa\":\"\\u0635\\u062d\\u0631\\u0627 \\u2014 \\u0622\\u0698\\u0627\\u0646\\u0633 \\u0628\\u0627\\u0632\\u0627\\u0631\\u06cc\\u0627\\u0628\\u06cc \\u062f\\u06cc\\u062c\\u06cc\\u062a\\u0627\\u0644 \\u062f\\u0631 \\u0645\\u0633\\u0642\\u0637\",\"ar\":\"\\u0635\\u062d\\u0631\\u0627\\u0621 \\u2014 \\u0648\\u0643\\u0627\\u0644\\u0629 \\u062a\\u0633\\u0648\\u064a\\u0642 \\u0631\\u0642\\u0645\\u064a \\u0641\\u064a \\u0645\\u0633\\u0642\\u0637\"}',1,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(10,'seo_default_description','seo','{\"en\":\"Sahra helps businesses in Oman create stronger brand presence through strategy, content, branding, video, and digital marketing.\",\"fa\":\"\\u0635\\u062d\\u0631\\u0627 \\u0628\\u0647 \\u06a9\\u0633\\u0628\\u200c\\u0648\\u06a9\\u0627\\u0631\\u0647\\u0627 \\u062f\\u0631 \\u0639\\u0645\\u0627\\u0646 \\u06a9\\u0645\\u06a9 \\u0645\\u06cc\\u200c\\u06a9\\u0646\\u062f \\u062a\\u0627 \\u0627\\u0632 \\u0637\\u0631\\u06cc\\u0642 \\u0627\\u0633\\u062a\\u0631\\u0627\\u062a\\u0698\\u06cc\\u060c \\u0645\\u062d\\u062a\\u0648\\u0627\\u060c \\u0628\\u0631\\u0646\\u062f\\u06cc\\u0646\\u06af \\u0648 \\u0628\\u0627\\u0632\\u0627\\u0631\\u06cc\\u0627\\u0628\\u06cc \\u062f\\u06cc\\u062c\\u06cc\\u062a\\u0627\\u0644 \\u062d\\u0636\\u0648\\u0631 \\u0628\\u0631\\u0646\\u062f \\u0642\\u0648\\u06cc\\u200c\\u062a\\u0631\\u06cc \\u0628\\u0633\\u0627\\u0632\\u0646\\u062f.\",\"ar\":\"\\u062a\\u0633\\u0627\\u0639\\u062f \\u0635\\u062d\\u0631\\u0627\\u0621 \\u0627\\u0644\\u0634\\u0631\\u0643\\u0627\\u062a \\u0641\\u064a \\u0639\\u064f\\u0645\\u0627\\u0646 \\u0639\\u0644\\u0649 \\u0628\\u0646\\u0627\\u0621 \\u062d\\u0636\\u0648\\u0631 \\u0623\\u0642\\u0648\\u0649 \\u0644\\u0639\\u0644\\u0627\\u0645\\u062a\\u0647\\u0627 \\u0627\\u0644\\u062a\\u062c\\u0627\\u0631\\u064a\\u0629 \\u0645\\u0646 \\u062e\\u0644\\u0627\\u0644 \\u0627\\u0644\\u0627\\u0633\\u062a\\u0631\\u0627\\u062a\\u064a\\u062c\\u064a\\u0629 \\u0648\\u0627\\u0644\\u0645\\u062d\\u062a\\u0648\\u0649 \\u0648\\u0627\\u0644\\u0647\\u0648\\u064a\\u0629 \\u0648\\u0627\\u0644\\u062a\\u0633\\u0648\\u064a\\u0642 \\u0627\\u0644\\u0631\\u0642\\u0645\\u064a.\"}',1,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(11,'seo_default_image','seo','{\"value\":null}',0,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(12,'seo_organization_name','seo','{\"en\":\"Sahra\",\"fa\":\"\\u0635\\u062d\\u0631\\u0627\",\"ar\":\"\\u0635\\u062d\\u0631\\u0627\\u0621\"}',1,'2026-07-29 05:42:02','2026-07-29 05:42:02');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `social_links`
--

DROP TABLE IF EXISTS `social_links`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `social_links` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `platform` varchar(50) NOT NULL,
  `label` varchar(100) NOT NULL,
  `url` varchar(500) NOT NULL,
  `icon` varchar(50) NOT NULL COMMENT 'lucide-vue-next icon name',
  `sort_order` smallint(5) unsigned NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `social_links_platform_unique` (`platform`),
  KEY `social_links_is_active_sort_order_index` (`is_active`,`sort_order`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `social_links`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `social_links` WRITE;
/*!40000 ALTER TABLE `social_links` DISABLE KEYS */;
INSERT INTO `social_links` VALUES
(1,'instagram','Instagram','https://instagram.com/sahramarketing','instagram',1,1,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(2,'linkedin','LinkedIn','https://linkedin.com/company/sahramarketing','linkedin',2,1,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(3,'whatsapp','WhatsApp','https://wa.me/96777811213','message-circle',3,1,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(4,'x','X','https://x.com/sahramarketing','twitter',4,1,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(5,'youtube','YouTube','https://youtube.com/@sahramarketing','youtube',5,1,'2026-07-29 05:42:02','2026-07-29 05:42:02');
/*!40000 ALTER TABLE `social_links` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `team_member_translations`
--

DROP TABLE IF EXISTS `team_member_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `team_member_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `team_member_id` bigint(20) unsigned NOT NULL,
  `locale` varchar(5) NOT NULL,
  `name` varchar(150) NOT NULL,
  `role` varchar(150) NOT NULL,
  `photo_alt` varchar(300) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `team_member_translations_unique` (`team_member_id`,`locale`),
  KEY `team_member_translations_locale_index` (`locale`),
  CONSTRAINT `team_member_translations_team_member_id_foreign` FOREIGN KEY (`team_member_id`) REFERENCES `team_members` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `team_member_translations`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `team_member_translations` WRITE;
/*!40000 ALTER TABLE `team_member_translations` DISABLE KEYS */;
INSERT INTO `team_member_translations` VALUES
(1,1,'en','Amin','CEO','Amin, CEO at Sahra','2026-07-29 05:42:02','2026-07-29 05:42:02'),
(2,1,'fa','امین','مدیرعامل','امین، مدیرعامل در صحرا','2026-07-29 05:42:02','2026-07-29 05:42:02'),
(3,1,'ar','أمين','الرئيس التنفيذي','أمين، الرئيس التنفيذي في صحراء','2026-07-29 05:42:02','2026-07-29 05:42:02'),
(4,2,'en','Melika','Brand Strategist','Melika, Brand Strategist at Sahra','2026-07-29 05:42:02','2026-07-29 05:42:02'),
(5,2,'fa','ملیکا','استراتژیست برند','ملیکا، استراتژیست برند در صحرا','2026-07-29 05:42:02','2026-07-29 05:42:02'),
(6,2,'ar','مليكا','استراتيجية العلامة','مليكا، استراتيجية العلامة في صحراء','2026-07-29 05:42:02','2026-07-29 05:42:02'),
(7,3,'en','Banin','Graphic Designer','Banin, Graphic Designer at Sahra','2026-07-29 05:42:02','2026-07-29 05:42:02'),
(8,3,'fa','بنین','طراح گرافیک','بنین، طراح گرافیک در صحرا','2026-07-29 05:42:02','2026-07-29 05:42:02'),
(9,3,'ar','بنين','مصممة جرافيك','بنين، مصممة جرافيك في صحراء','2026-07-29 05:42:02','2026-07-29 05:42:02'),
(10,4,'en','Banin','Graphic Designer','Banin, Graphic Designer at Sahra','2026-07-29 05:42:02','2026-07-29 05:42:02'),
(11,4,'fa','بنین','طراح گرافیک','بنین، طراح گرافیک در صحرا','2026-07-29 05:42:02','2026-07-29 05:42:02'),
(12,4,'ar','بنين','مصممة جرافيك','بنين، مصممة جرافيك في صحراء','2026-07-29 05:42:02','2026-07-29 05:42:02'),
(13,5,'en','Mohammad','Graphic Designer','Mohammad, Graphic Designer at Sahra','2026-07-29 05:42:03','2026-07-29 05:42:03'),
(14,5,'fa','محمد','طراح گرافیک','محمد، طراح گرافیک در صحرا','2026-07-29 05:42:03','2026-07-29 05:42:03'),
(15,5,'ar','محمد','مصمم جرافيك','محمد، مصمم جرافيك في صحراء','2026-07-29 05:42:03','2026-07-29 05:42:03'),
(16,6,'en','Iman','Videographer','Iman, Videographer at Sahra','2026-07-29 05:42:03','2026-07-29 05:42:03'),
(17,6,'fa','ایمان','فیلم‌بردار','ایمان، فیلم‌بردار در صحرا','2026-07-29 05:42:03','2026-07-29 05:42:03'),
(18,6,'ar','إيمان','مصور فيديو','إيمان، مصور فيديو في صحراء','2026-07-29 05:42:03','2026-07-29 05:42:03'),
(19,7,'en','Razieh','Brand Strategist','Razieh, Brand Strategist at Sahra','2026-07-29 05:42:03','2026-07-29 05:42:03'),
(20,7,'fa','راضیه','استراتژیست برند','راضیه، استراتژیست برند در صحرا','2026-07-29 05:42:03','2026-07-29 05:42:03'),
(21,7,'ar','راضية','استراتيجية العلامة','راضية، استراتيجية العلامة في صحراء','2026-07-29 05:42:03','2026-07-29 05:42:03'),
(22,8,'en','Amir','Video Creator','Amir, Video Creator at Sahra','2026-07-29 05:42:03','2026-07-29 05:42:03'),
(23,8,'fa','امیر','سازنده ویدیو','امیر، سازنده ویدیو در صحرا','2026-07-29 05:42:03','2026-07-29 05:42:03'),
(24,8,'ar','أمير','صانع فيديو','أمير، صانع فيديو في صحراء','2026-07-29 05:42:03','2026-07-29 05:42:03'),
(25,9,'en','Afshin','Brand Strategist','Afshin, Brand Strategist at Sahra','2026-07-29 05:42:03','2026-07-29 05:42:03'),
(26,9,'fa','افشین','استراتژیست برند','افشین، استراتژیست برند در صحرا','2026-07-29 05:42:03','2026-07-29 05:42:03'),
(27,9,'ar','أفشين','استراتيجي العلامة','أفشين، استراتيجي العلامة في صحراء','2026-07-29 05:42:03','2026-07-29 05:42:03'),
(28,10,'en','Afshin','Brand Strategist','Afshin, Brand Strategist at Sahra','2026-07-29 05:42:03','2026-07-29 05:42:03'),
(29,10,'fa','افشین','استراتژیست برند','افشین، استراتژیست برند در صحرا','2026-07-29 05:42:03','2026-07-29 05:42:03'),
(30,10,'ar','أفشين','استراتيجي العلامة','أفشين، استراتيجي العلامة في صحراء','2026-07-29 05:42:03','2026-07-29 05:42:03');
/*!40000 ALTER TABLE `team_member_translations` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `team_members`
--

DROP TABLE IF EXISTS `team_members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `team_members` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `photo_path` varchar(500) DEFAULT NULL,
  `sort_order` smallint(5) unsigned NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `team_members_is_active_sort_order_index` (`is_active`,`sort_order`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `team_members`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `team_members` WRITE;
/*!40000 ALTER TABLE `team_members` DISABLE KEYS */;
INSERT INTO `team_members` VALUES
(1,'team/amin.webp',0,1,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(2,'team/melika.webp',1,1,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(3,'team/banin-1.webp',2,1,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(4,'team/banin-2.webp',3,1,'2026-07-29 05:42:02','2026-07-29 05:42:02'),
(5,'team/mohammad.webp',4,1,'2026-07-29 05:42:03','2026-07-29 05:42:03'),
(6,'team/iman.webp',5,1,'2026-07-29 05:42:03','2026-07-29 05:42:03'),
(7,'team/razieh.webp',6,1,'2026-07-29 05:42:03','2026-07-29 05:42:03'),
(8,'team/amir.webp',7,1,'2026-07-29 05:42:03','2026-07-29 05:42:03'),
(9,'team/afshin-1.webp',8,1,'2026-07-29 05:42:03','2026-07-29 05:42:03'),
(10,'team/afshin-2.webp',9,1,'2026-07-29 05:42:03','2026-07-29 05:42:03');
/*!40000 ALTER TABLE `team_members` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `testimonial_translations`
--

DROP TABLE IF EXISTS `testimonial_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `testimonial_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `testimonial_id` bigint(20) unsigned NOT NULL,
  `locale` varchar(5) NOT NULL,
  `author_name` varchar(150) NOT NULL,
  `author_role` varchar(200) DEFAULT NULL,
  `quote` text NOT NULL,
  `avatar_alt` varchar(300) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `testimonial_translations_unique` (`testimonial_id`,`locale`),
  KEY `testimonial_translations_locale_index` (`locale`),
  CONSTRAINT `testimonial_translations_testimonial_id_foreign` FOREIGN KEY (`testimonial_id`) REFERENCES `testimonials` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `testimonial_translations`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `testimonial_translations` WRITE;
/*!40000 ALTER TABLE `testimonial_translations` DISABLE KEYS */;
INSERT INTO `testimonial_translations` VALUES
(1,1,'en','Sara Amiri','All Digital manager','Sahra helped us turn our scattered marketing into a clear and structured system. For the first time, our content, campaigns, and brand messaging all feel aligned both online and in-store.','Portrait of Sara Amiri','2026-07-29 05:42:03','2026-07-29 05:42:03'),
(2,1,'fa','سارا امیری','مدیر All Digital','صحرا به ما کمک کرد بازاریابی پراکنده‌مان را به سیستمی شفاف و ساختارمند تبدیل کنیم. برای نخستین بار محتوا، کمپین‌ها و پیام برند ما هم آنلاین و هم در فروشگاه هم‌راستا شده‌اند.','تصویر سارا امیری','2026-07-29 05:42:03','2026-07-29 05:42:03'),
(3,1,'ar','سارة أميري','مديرة All Digital','ساعدتنا صحراء في تحويل تسويقنا المبعثر إلى نظام واضح ومنظم. لأول مرة يبدو المحتوى والحملات ورسائل العلامة متوائمة عبر الإنترنت وفي المتجر.','صورة سارة أميري','2026-07-29 05:42:03','2026-07-29 05:42:03');
/*!40000 ALTER TABLE `testimonial_translations` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `testimonials`
--

DROP TABLE IF EXISTS `testimonials`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `testimonials` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `avatar_path` varchar(500) DEFAULT NULL,
  `sort_order` smallint(5) unsigned NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `testimonials_is_active_sort_order_index` (`is_active`,`sort_order`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `testimonials`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `testimonials` WRITE;
/*!40000 ALTER TABLE `testimonials` DISABLE KEYS */;
INSERT INTO `testimonials` VALUES
(1,'testimonials/sara-amiri.webp',0,1,'2026-07-29 05:42:03','2026-07-29 05:42:03');
/*!40000 ALTER TABLE `testimonials` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES
(1,'Sahra Admin','admin@sahra.example','2026-07-29 05:42:01','$2y$12$qiTlrQH67HLstHTD0RYxEuuiuwCUlFt6MPVeNMEBump8raF8YR0Im',NULL,'2026-07-29 05:42:01','2026-07-29 05:42:01',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Dumping events for database 'sahra'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

-- Dump completed on 2026-08-05 21:40:58
