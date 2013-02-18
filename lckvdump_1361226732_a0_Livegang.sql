-- MySQL dump 10.13  Distrib 5.1.38, for apple-darwin9.5.0 (i386)
--
-- Host: 127.0.0.1    Database: lckvdump
-- ------------------------------------------------------
-- Server version	5.1.38

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `area`
--

DROP TABLE IF EXISTS `area`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `area` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pagename` varchar(255) NOT NULL,
  `redirecturl` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`pagename`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `area`
--

LOCK TABLES `area` WRITE;
/*!40000 ALTER TABLE `area` DISABLE KEYS */;
INSERT INTO `area` VALUES (1,'dropbox','/login',''),(2,'uploadmedia','/login',''),(3,'dashboard/_index','login','CMS'),(4,'page/_index','login','CMS'),(5,'page/_default','login','CMS'),(6,'template/_index','login','CMS'),(7,'staticblock/_index','login','CMS'),(8,'media/_index','login','CMS'),(9,'tag/_index','login','CMS'),(10,'page/update','login','CMS'),(11,'template/edittemplate','login','CMS'),(12,'page/editpage','login','CMS'),(13,'page/folder','login','CMS'),(14,'media/editmedia','login','CMS'),(15,'staticblock/editblock','login','CMS'),(16,'tag/edit','login','CMS'),(17,'template/folder','login','CMS');
/*!40000 ALTER TABLE `area` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `area_usergroup`
--

DROP TABLE IF EXISTS `area_usergroup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `area_usergroup` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `area_id` int(10) unsigned NOT NULL,
  `usergroup_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `area_usergroup`
--

LOCK TABLES `area_usergroup` WRITE;
/*!40000 ALTER TABLE `area_usergroup` DISABLE KEYS */;
INSERT INTO `area_usergroup` VALUES (37,3,1),(38,1,1),(39,1,3),(40,8,1),(41,10,1),(42,5,1),(43,4,1),(44,7,1),(45,9,1),(46,6,1),(47,2,1),(48,2,3),(49,11,1),(50,12,1),(51,13,1),(52,14,1),(53,15,1),(54,16,1),(55,17,1);
/*!40000 ALTER TABLE `area_usergroup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `tag` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `media_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `folder`
--

DROP TABLE IF EXISTS `folder`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `folder` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `associationtype` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `folder_id` int(11) unsigned NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `visible` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `folder`
--

LOCK TABLES `folder` WRITE;
/*!40000 ALTER TABLE `folder` DISABLE KEYS */;
/*!40000 ALTER TABLE `folder` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `media`
--

DROP TABLE IF EXISTS `media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `media` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `extension` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mimetype` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `folder_id` int(11) NOT NULL,
  `location` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `media`
--

LOCK TABLES `media` WRITE;
/*!40000 ALTER TABLE `media` DISABLE KEYS */;
INSERT INTO `media` VALUES (1,'Rodondenderon','Met een stukje beschrijving... gek woord eigenlijk he!','Schermafbeelding 2010-11-22 om 12.19.38.png','png','image/png; charset=binary','2010-11-24 23:52:33',0,'/Users/robertcabri/Sites/lckvsite/www/upload',2),(2,'test','sdfsdf sdadfasdf','blogpost-cms.txt','txt','text/plain; charset=utf-8','2010-11-25 00:32:28',0,'/Users/robertcabri/Sites/lckvsite/www/upload',1),(7,'bla bla','hiermee kan je niets','pgsql_apache_pgsqlmyadmin.txt','txt','','2013-02-11 21:04:53',0,'/Users/robertcabri/Sites/lckvsite/www/upload',1),(8,'bla bla','hiermee kan je niets','pgsql_apache_pgsqlmyadmin.txt','txt','','2013-02-11 21:05:05',0,'/Users/robertcabri/Sites/lckvsite/www/upload',1),(9,'bla bla','hiermee kan je niets','pgsql_apache_pgsqlmyadmin.txt','txt','','2013-02-11 21:05:44',0,'/Users/robertcabri/Sites/lckvsite/www/upload',1),(10,'asfads','afadsf','Kennisdeling.pdf','pdf','','2013-02-11 21:07:04',0,'/Users/robertcabri/Sites/lckvsite/www/upload',1),(11,'asfsf','asfasdf','Schermafbeelding 2012-09-14 om 09.44.31.png','png','','2013-02-11 21:09:17',0,'/Users/robertcabri/Sites/lckvsite/www/upload',1),(13,'adfadsf','asfsdf','frame.png','png','','2013-02-11 21:22:52',0,'/Users/robertcabri/Sites/lckvsite/www/upload',1),(14,'adfadsf','asfsdf','frame.png','png','','2013-02-11 21:23:09',0,'/Users/robertcabri/Sites/lckvsite/www/upload',1),(15,'Doe maar raar','aldsjlaf','my-face.png','png','','2013-02-11 21:26:38',0,'/Users/robertcabri/Sites/lckvsite/www/upload',1),(16,'jgjhgj','','basenik.png','png','','2013-02-11 21:27:10',0,'/Users/robertcabri/Sites/lckvsite/www/upload',1);
/*!40000 ALTER TABLE `media` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `media_tag`
--

DROP TABLE IF EXISTS `media_tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `media_tag` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `media_id` int(10) unsigned NOT NULL,
  `tag_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=126 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `media_tag`
--

LOCK TABLES `media_tag` WRITE;
/*!40000 ALTER TABLE `media_tag` DISABLE KEYS */;
INSERT INTO `media_tag` VALUES (1,1,2),(2,1,3),(3,2,5),(4,2,6),(5,6,1),(9,6,5),(18,6,14),(21,7,1),(23,7,3),(26,7,6),(28,7,8),(30,7,10),(31,7,11),(37,8,1),(38,8,2),(41,8,5),(45,8,9),(47,8,11),(51,8,15),(53,9,1),(54,9,2),(56,9,4),(125,16,14),(61,9,9),(121,14,2),(120,13,13),(119,13,9),(118,13,6),(117,13,2),(67,9,15),(68,9,16),(72,10,4),(73,10,5),(122,14,6),(79,10,11),(82,10,14),(85,11,1),(91,11,7),(97,11,13),(101,12,1),(124,14,13),(123,14,9),(116,12,16);
/*!40000 ALTER TABLE `media_tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `module`
--

DROP TABLE IF EXISTS `module`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `template` int(1) NOT NULL,
  `active` int(1) NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `order` int(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `module`
--

LOCK TABLES `module` WRITE;
/*!40000 ALTER TABLE `module` DISABLE KEYS */;
INSERT INTO `module` VALUES (1,'page',1,1,'/page/',0),(2,'template',0,1,'/template/',0),(3,'staticblock',0,1,'/staticblock/',0),(4,'media',0,1,'/media/',0),(5,'twitter',1,1,'',0),(7,'blog',0,0,'/blog/',0),(8,'login',1,0,'',0),(9,'tag',0,1,'/tag/',0);
/*!40000 ALTER TABLE `module` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `page`
--

DROP TABLE IF EXISTS `page`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `page` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `template_id` int(11) unsigned NOT NULL,
  `publishtime` datetime NOT NULL,
  `expiretime` datetime NOT NULL,
  `created` datetime NOT NULL,
  `redirect` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `active` int(1) NOT NULL,
  `folder_id` int(11) unsigned NOT NULL,
  `keywords` text COLLATE utf8_unicode_ci,
  `description` text COLLATE utf8_unicode_ci,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `page`
--

LOCK TABLES `page` WRITE;
/*!40000 ALTER TABLE `page` DISABLE KEYS */;
INSERT INTO `page` VALUES (1,'index',15,'2010-04-27 09:46:46','0000-00-00 00:00:00','2010-04-27 09:46:46','',1,0,'LCKV, kamp, Emst, Diever, Terschelling, Chaam, Bladel, La Roche, Wiltz, Lieler, TsjechiÃ« ','LCKV kamp\r\n','LCKV - Drobbox site','basic'),(15,'contact',16,'2010-04-27 09:46:46','0000-00-00 00:00:00','2010-10-27 21:05:03','',1,0,'LCKV contact',NULL,'Contact','basic'),(16,'bedankt',15,'2010-10-27 00:00:00','0000-00-00 00:00:00','2010-10-27 21:22:46','',1,0,NULL,NULL,'Bedankt','basic'),(17,'veelgesteldevragen',15,'2010-10-27 00:00:00','0000-00-00 00:00:00','2010-10-27 21:27:33','',1,0,NULL,NULL,'FAQ','basic'),(18,'dropbox',17,'2010-10-27 01:00:00','0000-00-00 00:00:00','2010-10-27 21:39:06','',1,0,NULL,NULL,'Dropbox','basic'),(19,'login',18,'2010-10-27 01:00:00','0000-00-00 00:00:00','2010-10-27 22:02:17','',1,0,NULL,NULL,'Inloggen','page'),(20,'geschiedenis',15,'1970-01-01 01:00:00','0000-00-00 00:00:00','2010-11-24 17:42:30','',1,0,NULL,NULL,'Geschiedenis','basic'),(21,'uploadmedia',20,'2011-03-02 19:52:07','0000-00-00 00:00:00','2011-03-02 19:52:26','',1,0,NULL,NULL,'Upload','basic');
/*!40000 ALTER TABLE `page` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pageextend`
--

DROP TABLE IF EXISTS `pageextend`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pageextend` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `associationtype` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `page_id` int(10) unsigned NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pageextend`
--

LOCK TABLES `pageextend` WRITE;
/*!40000 ALTER TABLE `pageextend` DISABLE KEYS */;
INSERT INTO `pageextend` VALUES (1,'blog',4,'2010-09-22 17:56:01');
/*!40000 ALTER TABLE `pageextend` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pagemodule`
--

DROP TABLE IF EXISTS `pagemodule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pagemodule` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `page_id` int(11) unsigned NOT NULL,
  `identifier` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=254 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pagemodule`
--

LOCK TABLES `pagemodule` WRITE;
/*!40000 ALTER TABLE `pagemodule` DISABLE KEYS */;
INSERT INTO `pagemodule` VALUES (9,1,'footer','staticblock'),(203,1,'kop','textline'),(204,1,'intro','textblock'),(206,15,'kop','textline'),(209,15,'contact','contactform'),(210,15,'footer','staticblock'),(211,16,'kop','textline'),(212,16,'intro','textblock'),(213,16,'footer','staticblock'),(214,17,'kop','textline'),(215,17,'intro','textblock'),(216,17,'footer','staticblock'),(217,18,'kop','textline'),(218,18,'intro','textblock'),(219,18,'footer','staticblock'),(220,19,'kop','textline'),(221,19,'intro','textblock'),(222,19,'footer','staticblock'),(224,19,'loginformulier','login'),(225,20,'kop','textline'),(226,20,'intro','textblock'),(227,20,'footer','staticblock'),(228,1,'menu','staticblock'),(229,17,'menu','staticblock'),(230,20,'menu','staticblock'),(231,15,'menu','staticblock'),(232,16,'menu','staticblock'),(233,18,'menu','staticblock'),(234,19,'menu','staticblock'),(236,1,'head','staticblock'),(237,15,'head','staticblock'),(238,16,'head','staticblock'),(239,17,'head','staticblock'),(240,19,'head','staticblock'),(241,20,'head','staticblock'),(242,18,'head','staticblock'),(243,18,'dorpbox','mediabytag'),(244,18,'tagoverview','tags'),(245,15,'intro','htmltextblock'),(247,19,'registreerformulier','registerform'),(248,21,'head','staticblock'),(249,21,'menu','staticblock'),(250,21,'kop','textline'),(251,21,'intro','textblock'),(252,21,'dorpbox','mediaupload'),(253,21,'footer','staticblock');
/*!40000 ALTER TABLE `pagemodule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pagemodule_media`
--

DROP TABLE IF EXISTS `pagemodule_media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pagemodule_media` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pagemodule_id` int(11) unsigned NOT NULL,
  `media_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pagemodule_id` (`pagemodule_id`,`media_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pagemodule_media`
--

LOCK TABLES `pagemodule_media` WRITE;
/*!40000 ALTER TABLE `pagemodule_media` DISABLE KEYS */;
INSERT INTO `pagemodule_media` VALUES (9,90,11),(6,93,8),(8,93,10),(10,95,12),(11,96,13),(12,97,14),(13,98,15),(14,99,16),(15,100,17);
/*!40000 ALTER TABLE `pagemodule_media` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pagemodule_staticblock`
--

DROP TABLE IF EXISTS `pagemodule_staticblock`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pagemodule_staticblock` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pagemodule_id` int(11) unsigned NOT NULL,
  `staticblock_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pagemodule_id` (`pagemodule_id`,`staticblock_id`)
) ENGINE=InnoDB AUTO_INCREMENT=907 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pagemodule_staticblock`
--

LOCK TABLES `pagemodule_staticblock` WRITE;
/*!40000 ALTER TABLE `pagemodule_staticblock` DISABLE KEYS */;
INSERT INTO `pagemodule_staticblock` VALUES (1,1,1),(742,2,2),(743,7,3),(671,8,3),(826,9,4),(672,11,2),(673,12,4),(674,14,5),(538,16,3),(539,19,5),(540,21,2),(541,22,4),(570,23,3),(572,25,2),(573,26,4),(571,28,8),(641,29,3),(642,31,6),(643,33,2),(644,34,4),(737,36,3),(738,39,6),(739,41,2),(740,42,4),(745,45,7),(675,46,7),(537,47,7),(569,48,7),(645,49,7),(741,50,7),(656,51,7),(657,52,3),(658,56,6),(659,58,2),(660,59,4),(259,60,7),(260,61,3),(261,65,6),(262,67,2),(263,68,4),(340,72,7),(341,73,3),(342,77,6),(343,79,2),(344,80,4),(564,81,7),(565,82,3),(566,86,6),(567,88,2),(568,89,4),(595,111,0),(596,112,0),(597,116,0),(598,118,0),(599,119,0),(626,165,7),(627,166,3),(628,170,2),(629,172,2),(630,173,2),(721,187,7),(722,188,3),(690,190,2),(723,192,2),(724,193,4),(858,210,4),(832,213,4),(835,216,4),(900,219,4),(906,222,4),(844,227,4),(825,228,5),(834,229,5),(843,230,5),(857,231,5),(831,232,5),(899,233,5),(905,234,5),(824,236,6),(856,237,6),(830,238,6),(833,239,6),(904,240,6),(842,241,6),(898,242,6),(868,248,6),(869,249,5),(870,253,4);
/*!40000 ALTER TABLE `pagemodule_staticblock` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pagemodule_templatefile`
--

DROP TABLE IF EXISTS `pagemodule_templatefile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pagemodule_templatefile` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pagemodule_id` int(11) unsigned NOT NULL,
  `templatefile_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pagemodule_id` (`pagemodule_id`,`templatefile_id`)
) ENGINE=InnoDB AUTO_INCREMENT=129 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pagemodule_templatefile`
--

LOCK TABLES `pagemodule_templatefile` WRITE;
/*!40000 ALTER TABLE `pagemodule_templatefile` DISABLE KEYS */;
INSERT INTO `pagemodule_templatefile` VALUES (124,1,0),(1,1,2),(7,10,2),(21,20,2),(26,24,2),(31,32,2),(45,40,2),(63,57,2),(65,66,2),(84,78,2),(110,87,2),(112,117,0),(118,171,2),(122,191,0),(123,191,2),(125,224,0),(126,224,19);
/*!40000 ALTER TABLE `pagemodule_templatefile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pagetext`
--

DROP TABLE IF EXISTS `pagetext`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pagetext` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pagemodule_id` int(11) unsigned NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pagetext`
--

LOCK TABLES `pagetext` WRITE;
/*!40000 ALTER TABLE `pagetext` DISABLE KEYS */;
INSERT INTO `pagetext` VALUES (52,189,''),(53,203,'Home'),(54,204,'<p>Elk jaar gaan er 40 kampen van LCKV weg waar prachtige ideeen worden verzonnen voor (onder andere) het sport en spel programma. Elk jaar zijn er nieuwe sport en spellers en elk jaar dus ook nieuwe ideeen, spellen of dagtochten. Helaas worden deze ideeen vaak eenmalig gebruikt en dat is zonde.</p><p>Om anderen mee te laten genieten, te leren of om nieuwe inzichten te krijgen, is deze site opgericht. Een \" apart\" &nbsp;stukje binnen de LCKV waar je als sport en speller al je informatie kunt plaatsen voor andere LCKV-ers, maar ook waar je informatie kunt vergaren.</p><p>Het werkt als volgt:</p><p>Je schrijft je in via een kort inlogprogram en na het doorlopen van deze inlog kun je naar de \" drop box\" &nbsp;gaan. Hier staan verschillende categorien in vermeld, waaronder alle plaatsen waar de kampen heen gaan. Tevens kun je terecht onder de kopjes algemeen spel, nachtspel of eventueel zelfs de C.</p><p>In deze drop box kun je je bestanden uploaden (het op de site plaatsen van je bestand) en bestanden downloaden (het van de site halen van bestanden). Na verloop van tijd zal deze drop box steeds uitgebreider worden en zal er steeds meer informatie in komen te staan van verschillende sport en spellers.</p><p>Maarâ€¦. Wordt mijn spel dan 1 op 1 gekopieerd door andere sport en spellers? Om eerlijk te zijn, dat zou kunnen. Maar wat wel duidelijk is, is dat het spel van jou afkomstig is, aangezien jij het als eerste hebt geplaatst. Wordt jij dus bekend als \" de sport en speller met het meest uitgebreide spel\" ?</p><p>Enâ€¦. Waarom zou ik dan als sport en speller nog nieuwe ideeen verzinnen? Nou, omdat jij als sport en speller enthousiast, creatief en innovatief bent! Wat niet iedereen weet is dat een groot deel van de fun van een spel, vooraf aan het kamp al plaatsvindt. Het bedenken, uitwerken en voor je zien geeft je vooraf al zoveel plezier, dat wil je toch niet missen!</p><p>Tot slot de vorm van de spellen. Het handigst is om deze in een word bestand te zetten. Excell, PDF kunnen natuurlijk ook!</p><p>Wij wensen jullie een goed gebruik van deze site toe.</p>'),(55,205,'Home'),(56,206,'Contact'),(57,208,'Beste gebruiker,<br><br>Mocht je onverhoopt tegen vragen, opmerkingen of problemen aanlopen? Stuur dan via onderstaand formulier een bericht naar ons en wij komen hierop bij je terug.'),(58,209,'robert@dicabrio.com,16'),(59,211,'Bedankt'),(60,212,'Bedankt voor je reactie. Wij komen hier zo spoedig mogelijk op terug.<br><br>Met vriendelijke groet,<br>De onbekende 2\r\n'),(61,214,'FAQ'),(62,215,'<p class=\"p1\"><strong>Wie zijn de onbekende 2?</strong><br>Dat is helaas onbekend.<br><br><strong>Wat kun je met deze site?<br></strong>Op deze site kunnen sport en spellers informatie, bestanden of ideeen uitwisselen aan elkaar.<br><br><strong>Hoe moet je bestanden up- of downloaden?</strong><br>Zie pagina uitleg.<br><br><strong>Wat is het doel van deze site?</strong><br>Een makkelijk bereikbaar platform creeeren voor het vergaren, geven en uitwisselen van informatie tussen LCKV-ers die als sport en speller meegaan.<br><br><strong>Welke bestanden zijn geoorloofd om te uploaden/plaatsen?<br></strong>Het handigst zijn Word bestanden, hieraan kan de downloader namelijk wijzigingen aanbrengen. Voor de rest zijn er geen bepaalde \" eisen\"&nbsp; aan bestanden, als het maar een handzaam en veelgebruikte standaard is.<br><br><strong>Waarom moet ik een account aanmaken om te up- of downloaden?<br></strong>Om de site goed te laten lopen, is het belangrijk dat duidelijk is wie er actief op zijn. De bestanden willen we graag binnen de LCKV houden. Ook kunnen we in geval van misbruik de gegevens verwijderen en een e-mail adres weigeren zich opnieuw in te schrijven.<br><br><strong>Ik heb een fout gemaakt met uploaden, kan ik het nog wijzigen?<br></strong>Wijzigen in bestandsnaam kunnen zelf worden doorgevoerd. In geval van een fout geplaatst bestand kun je dit doorgeven zodat het door de onbekende 2 wordt verwijderd.<br><br><strong>Hoelang blijven mijn bestanden bewaard?<br></strong>De bestanden staan op een lokale van de onbekende 2 opgeslagen en blijven hierop staan. Er kan altijd worden gevraagd om verwijdering van de gegevens, waarna deze zullen worden verwijderd.<br><br><strong>Waarom is deze site alleen voor sport en spellers, is dit niet ook handig voor koks, adjudantenâ€¦.?<br></strong>Jazeker, als deze site goed loopt zal er zeker worden gekeken naar uitbreidingsmogelijkheden qua functies.<br><br><strong>Worden de bestanden gebruikt voor andere doeleinden buiten deze website/lckv om?<br></strong>Nee, de bestanden worden enkel en alleen gebruikt voor lckv doeleinden en worden niet aan derden verstrekt.<br><br><strong>Er is iets op de website dat naar mijn mening beter kan, hoe kan ik dit aan de onbekende 2 aangeven?<br></strong>Via het contactformulier kun je aangeven wat er naar jouw mening beter kan.<br><br><strong>Ik ben mijn wachtwoord vergeten, wat moet ik doen om een nieuw wachtwoord te krijgen?<br></strong>Klik in het inlogscherm op \" wachtwoord vergeten\".<br><br><strong>Worden mijn gegevens verstrekt aan derden?</strong><br>Nee, alle gegevens zullen in geen enkel geval aan derden worden verstrekt.<br><br><strong>Kan ik dit initiatief sponsoren?</strong><br>Dit kan. De grootste sponsoring vindt plaats via het plaatsen van bestanden. Sponsoren op een andere manier kan door contact op te nemen met de onbekende 2 via het contactformulier.<br><br><strong>Op welke manieren kan ik een bijdrage leveren aan deze website?</strong><br>Door middel van het uitwisselen van informatie, gedachten en feedback te geven.<br><br><strong>Staat jouw vraag er niet tussen?</strong>&nbsp;Stel dan je vraag via het <a href=\"http://contact.html\">contactformulier</a>.</p>\r\n<p class=\"p2\"></p>'),(63,217,'Dropbox'),(64,218,'<a href=\"/uploadmedia\">Uploaden</a> van bestanden'),(65,220,'Login/Registreer'),(66,221,'Als je een account hebt kun je hier inloggen. Heb je er geen kun je je hier aanmelden.'),(67,225,'Geschiedenis'),(68,226,'Lckv is al ruim 90 jaar oud. Het totaal aantal kinderen dat met LCKV is meegegaan is bijna niet meer te tellen. Begon de LCKV nog als zijnde \" christelijke\" vereniging, hedentendage is het een organisatie voor iedereen.&nbsp;<br><br>Voor degene die het niet weten:<br><br><meta charset=\"utf-8\"><span style=\"font-family: Arial; line-height: normal; \"><strong>Wat doet LCKV Jeugdvakanties?</strong><br>Lekker op vakantie, volop actief bezig zijn, leuke en gekke spelletjes doen, zingen bij een kampvuur en relaxen in de zon. Dat zijn de ingredienten van een LCKV kamp.&nbsp;<br><br>De primitieve manier van kamperen in de vrije natuur, de goede voorbereiding, de enthousiaste begeleiding van de staf en de lage kampprijzen zijn elementen die de kampen van LCKV Jeugdvakanties zo bijzonder maken.&nbsp;<br>En met succes!&nbsp;<br>Jaarlijks gaan er ruim zestienhonderd jongeren mee op kamp.&nbsp;<br>Hiermee is deze vereniging in haar soort de grootste in Nederland. We draaien deze kampen met zoâ€™n 500 vrijwilligers.En dat al sinds 1920!&nbsp;<br><br>Kampvuur, abseilen, kamperen, feesten, spannende bosspelen, spooktochten, nieuwe vrienden en zeven dagen lol en plezier; dit zijn de basisingrediÃ«nten van een week kamp met LCKV Jeugdvakanties. Wil je adventure en survival in het buitenland, of juist gezellig en vertrouwd in Nederland? Zeg het maar; we hebben het allemaal!&nbsp;<br><br><strong>Historie</strong><br>Al 90 jaar organiseert LCKV Jeugdvakanties kampen. Natuurlijk gaan we met de tijd mee en maken we gebruik van de modernste technieken. Maar gelukkig zijn er ook veel tradities die blijven. Juist die tradities maken een LCKV kamp zo bijzonder! Vaak heb je tijdens het kamperen in de natuur helemaal geen behoefte aan je tv, spelcomputer, tl-lampen, autolampen of lichtshow. Je kunt best een weekje zonder.....<br></span><br>Waar de grootste historie in schuilt binnen de LCKV, is het materiaal. Wist je dat er tenten zijn die al meer dan 30 jaar meegaan op kamp en nog steeds goed zijn? Of olielampen uit het jaar 1982? De huidige olielampen zijn nog steeds van het merk Feuerhand, model West-Germany. Sommige dingen zullen nooit veranderen en daar mogen wij met z\'n allen trots op zijn!<br><br>Hieronder 2 mannen die zeer veel voor het materiaal van de LCKV hebben betekend:<br><br><img  src=\"http://94.100.115.243/220300001-220350000/220302101-220302200/220302173_5_fH_c.jpeg\" style=\"width: 200px; \"><br>Herman de Boer, materiaalcommisaris in 1960<br><br><img  src=\"http://94.100.122.14/389100001-389150000/389128101-389128200/389128102_5_dgJL.jpeg\" style=\"width: 200px; height: 200px; \"><br>Koos Jansen, materiaalcommisaris tot 2009'),(69,237,'test'),(70,238,'test'),(71,245,'Beste gebruiker,<br>Mocht je onverhoopt tegen vragen, opmerkingen of problemen aanlopen? Stuur dan via onderstaand formulier een bericht naar ons en wij komen hierop bij je terug.<br>'),(72,250,'Uploaden'),(73,251,'Upload je shit, geef het een naam en koppel er een paar tags aan');
/*!40000 ALTER TABLE `pagetext` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pagetype`
--

DROP TABLE IF EXISTS `pagetype`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pagetype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `label` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pagetype`
--

LOCK TABLES `pagetype` WRITE;
/*!40000 ALTER TABLE `pagetype` DISABLE KEYS */;
INSERT INTO `pagetype` VALUES (1,'page','Page');
/*!40000 ALTER TABLE `pagetype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `quote`
--

DROP TABLE IF EXISTS `quote`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `quote` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quote` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `source` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quote`
--

LOCK TABLES `quote` WRITE;
/*!40000 ALTER TABLE `quote` DISABLE KEYS */;
INSERT INTO `quote` VALUES (1,'Life is 10% what happens to you and 90% how you react to it.','Charles R. Swindoll'),(2,'To affect the quality of the day, that is the highest of arts.','Henry David Thoreau');
/*!40000 ALTER TABLE `quote` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `setting`
--

DROP TABLE IF EXISTS `setting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `setting` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `setting`
--

LOCK TABLES `setting` WRITE;
/*!40000 ALTER TABLE `setting` DISABLE KEYS */;
INSERT INTO `setting` VALUES (1,'twitteraccount','dicabrio'),(2,'defaultimage','voorbeeldafbeelding.png'),(3,'pricelistxsd','http://test.robertcabri.nl/dicabrio/www/pricelistxsd.html'),(4,'blogfoldername','Blog artikelen'),(5,'blogtemplateid','6');
/*!40000 ALTER TABLE `setting` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staticblock`
--

DROP TABLE IF EXISTS `staticblock`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `staticblock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `identifier` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `path` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staticblock`
--

LOCK TABLES `staticblock` WRITE;
/*!40000 ALTER TABLE `staticblock` DISABLE KEYS */;
INSERT INTO `staticblock` VALUES (4,'Footer','Deze website is een initiatief van <a href=\"http://twitter.com/deonbekende2/\">de onbekende 2</a>.','2010-04-27 13:38:37','/Users/robertcabri/Sites/lckvsite/application/upload/templates','footer'),(5,'Hoofdmenu','<header>\r\n<a href=\"<?php echo $wwwurl; ?>/\"><img src=\"<?php echo $wwwurl; ?>/images/logo-lckv.gif\" alt=\"lckv\" /></a>\r\n<h1>LCKV Sport & Spel website</h1>\r\n<nav>\r\n<ul>\r\n<li><a href=\"<?php echo $wwwurl; ?>/\">Home</a></li>\r\n<li><a href=\"<?php echo $wwwurl; ?>/dropbox/\">Drop box</a></li>\r\n<li><a href=\"<?php echo $wwwurl; ?>/geschiedenis/\">Geschiedenis</a></li>\r\n<li><a href=\"<?php echo $wwwurl; ?>/veelgesteldevragen/\">FAQ</a></li>\r\n<li><a href=\"<?php echo $wwwurl; ?>/contact/\">Contact</a></li>\r\n</ul>\r\n</nav>\r\n</header>\r\n\r\n','2010-11-24 21:30:37','/Users/robertcabri/Sites/lckvsite/application/upload/templates','hoofdmenu'),(6,'HeadMeta','<link rel=\"stylesheet\" href=\"<?php echo $cssurl; ?>/screen.css\" media=\"screen\" type=\"text/css\" />\r\n<script src=\"<?php echo $jsurl; ?>/libs/modernizr-1.6.min.js\"></script>','2011-02-09 19:05:55','/Users/robertcabri/Sites/lckvsite/application/upload/templates','meta');
/*!40000 ALTER TABLE `staticblock` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tag`
--

DROP TABLE IF EXISTS `tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tag`
--

LOCK TABLES `tag` WRITE;
/*!40000 ALTER TABLE `tag` DISABLE KEYS */;
INSERT INTO `tag` VALUES (1,'teschelling'),(2,'diever'),(3,'emst'),(4,'heerde'),(5,'bladel'),(6,'chaam'),(7,'lieler'),(8,'wiltz'),(9,'la-roche'),(10,'tsjechie'),(11,'overig-kampterrein'),(12,'nachtspel'),(13,'dagspel'),(14,'dagtocht'),(15,'omgevingsinformatie'),(16,'overige-informatie');
/*!40000 ALTER TABLE `tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `templatefile`
--

DROP TABLE IF EXISTS `templatefile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `templatefile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `created` datetime NOT NULL,
  `folder_id` int(11) NOT NULL,
  `source` text COLLATE utf8_unicode_ci,
  `module_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `templatefile`
--

LOCK TABLES `templatefile` WRITE;
/*!40000 ALTER TABLE `templatefile` DISABLE KEYS */;
INSERT INTO `templatefile` VALUES (15,'homepageTemplate','','2010-10-27 20:50:58',0,'<!doctype html>\r\n<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ --> \r\n<!--[if lt IE 7 ]> <html lang=\"en\" class=\"no-js ie6\"> <![endif]--> \r\n<!--[if IE 7 ]>    <html lang=\"en\" class=\"no-js ie7\"> <![endif]--> \r\n<!--[if IE 8 ]>    <html lang=\"en\" class=\"no-js ie8\"> <![endif]--> \r\n<!--[if IE 9 ]>    <html lang=\"en\" class=\"no-js ie9\"> <![endif]--> \r\n<!--[if (gt IE 9)|!(IE)]><!--> <html lang=\"en\" class=\"no-js\"> <!--<![endif]--> \r\n	<head>\r\n		<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge,chrome=1\" />\r\n		<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\" /> \r\n		<meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\" />\r\n		\r\n		<title><?php echo $title; ?></title>\r\n		\r\n		<meta name=\"keywords\" content=\"<?php echo $keywords; ?>\" />\r\n		<meta name=\"description\" content=\"<?php echo $description; ?>\" />\r\n		<?php echo $staticblock_head; ?>\r\n	</head>\r\n	<body id=\"<?php echo $pagename; ?>\">\r\n		<div id=\"wrapper\">\r\n			<?php echo $staticblock_menu; ?>\r\n			<div id=\"main\">\r\n				<header>\r\n				<h2><?php echo $textline_kop; ?></h2>\r\n				</header>\r\n				<div class=\"content\">\r\n				<?php echo $textblock_intro; ?>\r\n				</div>\r\n			</div>\r\n			<footer>\r\n				<?php echo $staticblock_footer; ?>\r\n			</footer>\r\n		</div>\r\n	</body>\r\n</html>',1),(16,'contactTemplate','','2010-10-27 21:04:41',0,'<!doctype html>\r\n<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ --> \r\n<!--[if lt IE 7 ]> <html lang=\"en\" class=\"no-js ie6\"> <![endif]--> \r\n<!--[if IE 7 ]>    <html lang=\"en\" class=\"no-js ie7\"> <![endif]--> \r\n<!--[if IE 8 ]>    <html lang=\"en\" class=\"no-js ie8\"> <![endif]--> \r\n<!--[if IE 9 ]>    <html lang=\"en\" class=\"no-js ie9\"> <![endif]--> \r\n<!--[if (gt IE 9)|!(IE)]><!--> <html lang=\"en\" class=\"no-js\"> <!--<![endif]--> \r\n	<head>\r\n		<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge,chrome=1\" />\r\n		<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\" /> \r\n		<meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\" />\r\n		\r\n		<title><?php echo $title; ?></title>\r\n		\r\n		<meta name=\"keywords\" content=\"<?php echo $keywords; ?>\" />\r\n		<meta name=\"description\" content=\"<?php echo $description; ?>\" />\r\n		<?php echo $staticblock_head; ?>\r\n	</head>\r\n	<body id=\"<?php echo $pagename; ?>\">\r\n		<div id=\"wrapper\">\r\n			<?php echo $staticblock_menu; ?>\r\n			<div id=\"main\">\r\n				<header>\r\n				<h2><?php echo $textline_kop; ?></h2>\r\n				</header>\r\n				<div class=\"content\">\r\n					<?php echo $htmltextblock_intro; ?>\r\n				</div>\r\n				<section>\r\n				<?php echo $contactform_contact; ?>\r\n				</section>\r\n			</div>\r\n			<footer>\r\n				<?php echo $staticblock_footer; ?>\r\n			</footer>\r\n		</div>\r\n	</body>\r\n</html>',1),(17,'dropboxOverzichtTemplate','','2010-10-27 21:34:54',0,'<!doctype html>\r\n<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ --> \r\n<!--[if lt IE 7 ]> <html lang=\"en\" class=\"no-js ie6\"> <![endif]--> \r\n<!--[if IE 7 ]>    <html lang=\"en\" class=\"no-js ie7\"> <![endif]--> \r\n<!--[if IE 8 ]>    <html lang=\"en\" class=\"no-js ie8\"> <![endif]--> \r\n<!--[if IE 9 ]>    <html lang=\"en\" class=\"no-js ie9\"> <![endif]--> \r\n<!--[if (gt IE 9)|!(IE)]><!--> <html lang=\"en\" class=\"no-js\"> <!--<![endif]--> \r\n	<head>\r\n		<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge,chrome=1\" />\r\n		<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\" /> \r\n		<meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\" />\r\n		\r\n		<title><?php echo $title; ?></title>\r\n		\r\n		<meta name=\"keywords\" content=\"<?php echo $keywords; ?>\" />\r\n		<meta name=\"description\" content=\"<?php echo $description; ?>\" />\r\n		<?php echo $staticblock_head; ?>\r\n	</head>\r\n	<body id=\"<?php echo $pagename; ?>\">\r\n		<div id=\"wrapper\">\r\n			<?php echo $staticblock_menu; ?>\r\n			<div id=\"main\">\r\n				<header>\r\n				<h2><?php echo $textline_kop; ?></h2>\r\n				</header>\r\n				<div class=\"content\">\r\n				<?php echo $textblock_intro; ?>\r\n				</div>\r\n				<div id=\"media\">\r\n					<?php echo $mediabytag_dorpbox; ?>\r\n				</div>\r\n				<div id=\"tags\">\r\n					<?php echo $tags_tagoverview; ?>\r\n				</div>\r\n			</div>\r\n			<footer>\r\n				<?php echo $staticblock_footer; ?>\r\n			</footer>\r\n		</div>\r\n	</body>\r\n</html>',1),(18,'loginTemplate','','2010-10-28 11:21:46',0,'<!doctype html>\r\n<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ --> \r\n<!--[if lt IE 7 ]> <html lang=\"en\" class=\"no-js ie6\"> <![endif]--> \r\n<!--[if IE 7 ]>    <html lang=\"en\" class=\"no-js ie7\"> <![endif]--> \r\n<!--[if IE 8 ]>    <html lang=\"en\" class=\"no-js ie8\"> <![endif]--> \r\n<!--[if IE 9 ]>    <html lang=\"en\" class=\"no-js ie9\"> <![endif]--> \r\n<!--[if (gt IE 9)|!(IE)]><!--> <html lang=\"en\" class=\"no-js\"> <!--<![endif]--> \r\n	<head>\r\n		<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge,chrome=1\" />\r\n		<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\" /> \r\n		<meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\" />\r\n		\r\n		<title><?php echo $title; ?></title>\r\n		\r\n		<meta name=\"keywords\" content=\"<?php echo $keywords; ?>\" />\r\n		<meta name=\"description\" content=\"<?php echo $description; ?>\" />\r\n		<?php echo $staticblock_head; ?>\r\n	</head>\r\n	<body id=\"<?php echo $pagename; ?>\">\r\n		<div id=\"wrapper\">\r\n			<?php echo $staticblock_menu; ?>\r\n			<div id=\"main\">\r\n				<header>\r\n				<h2><?php echo $textline_kop; ?></h2>\r\n				</header>\r\n				<div class=\"content\">\r\n				<?php echo $textblock_intro; ?>\r\n				</div>\r\n				\r\n				<section id=\"loginsection\">\r\n					<fieldset>\r\n						<legend>Login</legend>\r\n						<?php echo $login_loginformulier; ?>\r\n					</fieldset>\r\n				</section>\r\n				<section id=\"registersection\">\r\n					<fieldset>\r\n						<legend>Registreer</legend>\r\n						<?php echo $registerform_registreerformulier; ?>\r\n					</fieldset>\r\n				</section>\r\n			</div>\r\n			<footer>\r\n				<?php echo $staticblock_footer; ?>\r\n			</footer>\r\n		</div>\r\n	</body>\r\n</html>',1),(19,'loginFormTemplate','','2010-10-28 11:43:17',0,'<?php if ($flash) : ?>\r\n<p><?php echo $flash; ?></p>\r\n<?php endif; ?>\r\n<?php if ($errors) : ?>\r\n<?php $errorsOutput = \'<ul class=\"error\">\';\r\nforeach ($errors as $error) {\r\n	$errorsOutput .= \'<li>\'.Lang::get(\'login.\'.$error).\'</li>\';\r\n}\r\n$errorsOutput .=\'</ul>\'; ?>\r\n<?php echo $errorsOutput; ?>\r\n<?php endif; ?>\r\n<?php echo $formbegin; ?>\r\n<table class=\"formtable\">\r\n<tr>\r\n<th><label>Gebruikersnaam</label></th>\r\n<td><?php echo $username; ?></td>\r\n</tr>\r\n<tr>\r\n<th><label>Wachtwoord</label></th>\r\n<td><?php echo $password; ?></td>\r\n</tr>\r\n<tr>\r\n<th>&nbsp;</th>\r\n<td><?php echo $button; ?></td>\r\n</tr>\r\n</table>\r\n<?php echo $formend; ?>',8),(20,'UploadTemplate','','2011-03-02 19:50:33',0,'<!doctype html>\r\n<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ --> \r\n<!--[if lt IE 7 ]> <html lang=\"en\" class=\"no-js ie6\"> <![endif]--> \r\n<!--[if IE 7 ]>    <html lang=\"en\" class=\"no-js ie7\"> <![endif]--> \r\n<!--[if IE 8 ]>    <html lang=\"en\" class=\"no-js ie8\"> <![endif]--> \r\n<!--[if IE 9 ]>    <html lang=\"en\" class=\"no-js ie9\"> <![endif]--> \r\n<!--[if (gt IE 9)|!(IE)]><!--> <html lang=\"en\" class=\"no-js\"> <!--<![endif]--> \r\n	<head>\r\n		<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge,chrome=1\" />\r\n		<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\" /> \r\n		<meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\" />\r\n		\r\n		<title><?php echo $title; ?></title>\r\n		\r\n		<meta name=\"keywords\" content=\"<?php echo $keywords; ?>\" />\r\n		<meta name=\"description\" content=\"<?php echo $description; ?>\" />\r\n		<?php echo $staticblock_head; ?>\r\n	</head>\r\n	<body id=\"<?php echo $pagename; ?>\">\r\n		<div id=\"wrapper\">\r\n			<?php echo $staticblock_menu; ?>\r\n			<div id=\"main\">\r\n				<header>\r\n				<h2><?php echo $textline_kop; ?></h2>\r\n				</header>\r\n				<div class=\"content\">\r\n				<?php echo $textblock_intro; ?>\r\n				</div>\r\n				<div id=\"media\">\r\n					<?php echo $mediaupload_dorpbox; ?>\r\n				</div>\r\n				<div id=\"tags\">\r\n					\r\n				</div>\r\n			</div>\r\n			<footer>\r\n				<?php echo $staticblock_footer; ?>\r\n			</footer>\r\n		</div>\r\n	</body>\r\n</html>',1);
/*!40000 ALTER TABLE `templatefile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tweet`
--

DROP TABLE IF EXISTS `tweet`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tweet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `user` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tweet_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tweet` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `datum` datetime NOT NULL,
  `update` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tweet_id` (`tweet_id`),
  UNIQUE KEY `tweet_id_2` (`tweet_id`)
) ENGINE=InnoDB AUTO_INCREMENT=210 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tweet`
--

LOCK TABLES `tweet` WRITE;
/*!40000 ALTER TABLE `tweet` DISABLE KEYS */;
INSERT INTO `tweet` VALUES (1,12906382,'dicabrio','http://a1.twimg.com/profile_images/768632884/Me-145986715_normal.png','12884503866','@photologix hij twittert zelf niet heel actief. Maar @spriteCloud is de twitternaam van zijn bedrijf','2010-04-26 16:02:13','0000-00-00 00:00:00'),(16,12906382,'dicabrio','http://a1.twimg.com/profile_images/768632884/Me-145986715_normal.png','12945546006','How to creeping people out: http://survivingtheworld.net/Lesson234.html','2010-04-27 15:38:52','2010-04-27 16:01:15'),(26,12906382,'dicabrio','http://a1.twimg.com/profile_images/768632884/Me-145986715_normal.png','12946657399','dog baby http://pogpog.com/v/wolf-dog-sings-to-a-baby-to-stop-his-cry/','2010-04-27 16:02:52','2010-04-28 15:10:36'),(37,12906382,'dicabrio','http://a1.twimg.com/profile_images/768632884/Me-145986715_normal.png','13009458526','@photologix @adrianwinter dat klinkt heel interessant #powerbreakfast 7 juni','2010-04-28 16:30:15','2010-04-28 17:21:33'),(39,12906382,'dicabrio','http://a1.twimg.com/profile_images/768632884/Me-145986715_normal.png','13027912621','Nog steeds aan het genieten van caro emerald #Paradiso. :)','2010-04-28 22:57:10','2010-04-29 10:08:36'),(41,12906382,'dicabrio','http://a1.twimg.com/profile_images/768632884/Me-145986715_normal.png','13057922978','@adrianwinter Nope not attending #TNW. Any new developments?','2010-04-29 10:25:39','2010-04-29 10:39:51'),(42,12906382,'dicabrio','http://a1.twimg.com/profile_images/768632884/Me-145986715_normal.png','13059978023','flv(flash) slaat vast als je ctrl + tab doet in chrome op mac. #fail','2010-04-29 11:38:56','2010-04-29 13:33:10'),(46,12906382,'dicabrio','http://a1.twimg.com/profile_images/768632884/Me-145986715_normal.png','13082869744','@basbakker http://learn.iis.net/page.aspx/557/translate-htaccess-content-to-iis-webconfig/ misschien dit?','2010-04-29 20:29:03','2010-04-29 20:41:58'),(47,12906382,'dicabrio','http://a1.twimg.com/profile_images/768632884/Me-145986715_normal.png','13263105447','@kruithoph Google heeft wel meerdere pagina\'s die verbeterd kunnen worden zoals Google apps','2010-05-02 21:53:56','2010-05-03 17:58:21'),(49,12906382,'dicabrio','http://a1.twimg.com/profile_images/768632884/Me-145986715_normal.png','13421025821','RT @basbakker: How great leaders inspire action - http://bit.ly/a9sZdE','2010-05-05 13:33:37','2010-05-05 14:53:02'),(50,12906382,'dicabrio','http://a1.twimg.com/profile_images/768632884/Me-145986715_normal.png','13473730349','RT @Eykman: Moet je een ouder zijn om dit leuk te vinden? http://bit.ly/9X0crq','2010-05-06 09:03:41','2010-05-06 10:30:03'),(53,12906382,'dicabrio','http://a1.twimg.com/profile_images/768632884/Me-145986715_normal.png','13477026940','RT @MwahNL: Jantje Beton vraagt faillicement aan.','2010-05-06 10:59:50','2010-05-07 13:48:03'),(61,12906382,'dicabrio','http://a1.twimg.com/profile_images/768632884/Me-145986715_normal.png','13551209082','@photologix Ja daar ben ik bekend mee','2010-05-07 16:21:58','2010-05-07 16:24:22'),(62,12906382,'dicabrio','http://a1.twimg.com/profile_images/768632884/Me-145986715_normal.png','13676827160','@Esther_Art leuke schilderijen Esther. Kleurgebruik is erg inspirerend','2010-05-09 18:42:35','2010-05-09 20:31:46'),(63,12906382,'dicabrio','http://a1.twimg.com/profile_images/768632884/Me-145986715_normal.png','13856694622','Gave fakkel http://www.gerardotandco.com/blog/recycled-bottle-torch/','2010-05-12 17:24:17','2010-05-12 18:01:13'),(64,12906382,'dicabrio','http://a1.twimg.com/profile_images/768632884/Me-145986715_normal.png','13861642671','Dit is geniaal http://bit.ly/DzavF. Rowan Atkinson is helemaal top','2010-05-12 19:09:46','2010-05-12 20:40:19'),(65,12906382,'dicabrio','http://a1.twimg.com/profile_images/768632884/Me-145986715_normal.png','13876454946','Nico @dijkshoorn is geniaal: http://bit.ly/cj0vAW','2010-05-13 00:44:12','2010-05-13 01:37:06'),(66,12906382,'dicabrio','http://a1.twimg.com/profile_images/768632884/Me-145986715_normal.png','13974562102','RT @LeonPals: Avoid having to explain your Apple love, just share it. http://bit.ly/94ixBt','2010-05-14 14:49:24','2010-05-14 14:51:31'),(67,12906382,'dicabrio','http://a1.twimg.com/profile_images/768632884/Me-145986715_normal.png','14146244569','Do You Want To Dream Different? http://su.pr/5ey660','2010-05-17 08:46:40','2010-05-17 11:31:57'),(68,12906382,'dicabrio','http://a1.twimg.com/profile_images/768632884/Me-145986715_normal.png','14183234414','lol - RT @LeonPals: How do you react on an upcoming Google streetview car? http://bit.ly/aibDIH','2010-05-17 23:03:01','2010-05-18 14:08:56'),(71,12906382,'dicabrio','http://a1.twimg.com/profile_images/768632884/Me-145986715_normal.png','14224082487','RT @adrianwinter: If only for this DJ app I\'d have an iPad... http://bit.ly/dD4eyA','2010-05-18 14:21:17','2010-05-18 16:13:26'),(72,12906382,'dicabrio','http://a1.twimg.com/profile_images/768632884/Me-145986715_normal.png','14292878402','@jpschadde http://bit.ly/9mWpmc is het bedrijf wat http://bit.ly/cxtEU7 maakt. Zo ver ik weet geen nr.systeem. Je kunt het natuurlijk vragen','2010-05-19 14:42:54','2010-05-19 15:58:41'),(73,12906382,'dicabrio','http://a1.twimg.com/profile_images/768632884/Me-145986715_normal.png','14345676398','RT @ellenpronk: Google teamed up with Typekit btw (or the other way around) http://bit.ly/czcC2P','2010-05-20 08:59:42','2010-05-20 09:40:00'),(74,12906382,'dicabrio','http://a1.twimg.com/profile_images/768632884/Me-145986715_normal.png','14373774218','Gouda != goede 3G verbinding','2010-05-20 19:02:31','2010-05-21 11:52:33'),(75,12906382,'dicabrio','http://a1.twimg.com/profile_images/768632884/Me-145986715_normal.png','14778520801','@CarolineMana Cool! ik heb ook een uitnodiging gekregen voor #TEDxRdam','2010-05-26 19:50:54','2010-05-27 11:42:21'),(76,12906382,'dicabrio','http://a1.twimg.com/profile_images/768632884/Me-145986715_normal.png','15125987690','@erwinvanlun heb je al contact gehad met die vriend van mij die een chatbot gemaakt had voor #KLM?','2010-05-31 20:55:35','2010-06-01 10:22:32'),(77,12906382,'dicabrio','http://a1.twimg.com/profile_images/768632884/Me-145986715_normal.png','15184537921','@erwinvanlun heb je al contact gehad met die vriend van mij die een chatbot gemaakt had?','2010-06-01 17:19:01','2010-06-01 23:02:34'),(78,12906382,'dicabrio','http://a1.twimg.com/profile_images/768632884/Me-145986715_normal.png','15239307704','has anybody experience with netbeans, xdebug and php 5.3 on OSX snow leopard?','2010-06-02 11:05:02','2010-06-02 11:21:42'),(79,12906382,'dicabrio','http://a1.twimg.com/profile_images/768632884/Me-145986715_normal.png','15431622644','@ESettels zo groot is die kamer niet. Daar ben je zo klaar mee. Dus gauw het zonnetje in','2010-06-04 19:37:04','2010-06-05 15:59:07'),(80,12906382,'dicabrio','http://a1.twimg.com/profile_images/768632884/Me-145986715_normal.png','16204277236','really cool: http://bit.ly/aLpMed , but the name kinect .....','2010-06-15 08:51:14','2010-06-15 12:14:41'),(81,12906382,'dicabrio','http://a1.twimg.com/profile_images/768632884/Me-145986715_normal.png','16242104357','Met dank aan @_RoodBaard voor dit meesterlijk inspirerende TED filmpje van Sir Ken Robinson http://bit.ly/aHiymw','2010-06-15 19:47:54','2010-06-16 09:40:53'),(82,12906382,'dicabrio','http://a1.twimg.com/profile_images/768632884/Me-145986715_normal.png','16372408041','RT @MwahNL: WK-koorts: Zo. Nu eerst een Malaria.','2010-06-17 09:58:25','2010-06-17 10:07:12'),(83,12906382,'dicabrio','http://a1.twimg.com/profile_images/768632884/Me-145986715_normal.png','16752179042','Misschien meer een song voor donderdag, maar ik deel hem nu al : http://youtu.be/EEF22oF4kOo','2010-06-22 08:05:38','2010-06-22 09:24:47'),(84,12906382,'dicabrio','http://a1.twimg.com/profile_images/768632884/Me-145986715_normal.png','16769240809','@TarmoGoot Ontwerp is fris ogend. Tips: Actueel hernoemen iets met evenmenten erin en misschien andere of onderscheidende icoontjes (kleur)','2010-06-22 14:47:13','2010-06-22 14:51:05'),(85,12906382,'dicabrio','http://a1.twimg.com/profile_images/768632884/Me-145986715_normal.png','16771180756','For PHP developers I recommend http://xdebug.org/ for debugging purposes! It helped me out a lot. OSX, PHP 5.3, Netbeans, Xdebug','2010-06-22 15:22:24','2010-06-22 15:37:59'),(86,12906382,'dicabrio','http://a1.twimg.com/profile_images/768632884/Me-145986715_normal.png','16773421321','RT @BruceJillis: So with the current copyright climate, should someone invent and implant a camera-like bionic eye.. would he be allowed ...','2010-06-22 15:59:05','2010-06-22 17:06:14'),(87,12906382,'dicabrio','http://a1.twimg.com/profile_images/768632884/Me-145986715_normal.png','16777055711','@Pim_D dat is niet zo #lief he','2010-06-22 16:55:23','2010-06-23 10:49:07'),(88,12906382,'dicabrio','http://a1.twimg.com/profile_images/768632884/Me-145986715_normal.png','16995020493','@BruceJillis owja.. ben eigen cmsje aan het ontwikkelen: test.robertcabri.nl/dicabrio/www/login','2010-06-25 08:42:50','2010-06-25 08:56:02'),(89,12906382,'dicabrio','http://a1.twimg.com/profile_images/768632884/Me-145986715_normal.png','18268847594','Terug van een heerlijke weekje http://lckv.nl/ #lckv','2010-07-11 14:44:29','2010-07-12 11:05:18'),(90,12906382,'dicabrio','http://a1.twimg.com/profile_images/768632884/Me-145986715_normal.png','18363068033','RT @dutchvertising: Ruim je zooi eens op: http://bit.ly/cfo1Xm','2010-07-12 17:41:22','2010-07-12 18:08:30'),(91,12906382,'dicabrio','http://a1.twimg.com/profile_images/768632884/Me-145986715_normal.png','18385013018','@NavahHochstein Thanks for the inspiration. These websites are wonderful!','2010-07-12 23:58:06','2010-07-13 11:44:25'),(92,12906382,'dicabrio','http://a1.twimg.com/profile_images/768632884/Me-145986715_normal.png','18503849790','Mensen hier kijk ik nu al naar uit: http://bit.ly/dr7hoC #harrypotter','2010-07-14 10:01:57','2010-07-15 16:22:13'),(95,12906382,'dicabrio','http://a1.twimg.com/profile_images/768632884/Me-145986715_normal.png','18607518583','RT @MwahNL: Twitteren in oorlogstijd: General, we are forced to retweet.','2010-07-15 16:48:20','2010-07-15 19:08:54'),(97,12906382,'dicabrio','http://a1.twimg.com/profile_images/768632884/Me-145986715_normal.png','18717022603','RT @dijkshoorn: Wat Smeets met vrouwen doet is ongeveer als zeggen tegen een neger: je ruikt helemaal niet vreemd hoor. Je ruikt alleen  ...','2010-07-16 23:30:51','2010-07-19 19:42:29'),(106,12906382,'dicabrio','http://a0.twimg.com/profile_images/768632884/Me-145986715_normal.png','19073952251','@basbakker cool alvast bedankt!','2010-07-21 14:53:01','2010-07-21 15:20:15'),(107,12906382,'dicabrio','http://a0.twimg.com/profile_images/768632884/Me-145986715_normal.png','19080561074','@enveloppenland in het vervolg doe ik het zeker. Bedrijven zouden het ook moeten doen die een envelop meesturen met antwoordnummer bv.','2010-07-21 16:30:43','2010-07-22 12:13:24'),(110,12906382,'dicabrio','http://a0.twimg.com/profile_images/768632884/Me-145986715_normal.png','19244725003','@DiedX Wat zijn WIM bestanden?','2010-07-22 12:30:21','2010-07-22 13:33:29'),(111,12906382,'dicabrio','http://a0.twimg.com/profile_images/768632884/Me-145986715_normal.png','19266372961','@Pim_D kosovaar is de vader van ooievaar','2010-07-22 18:17:01','2010-07-22 22:00:38'),(113,12906382,'dicabrio','http://a0.twimg.com/profile_images/768632884/Me-145986715_normal.png','19318378941','Verschrikkuluk http://youtu.be/sF9e70Nz1Yk','2010-07-23 08:29:55','2010-07-23 10:27:15'),(115,12906382,'dicabrio','http://a0.twimg.com/profile_images/768632884/Me-145986715_normal.png','19327437724','kopieÃ«n van de iPad beter of slechter? Is het de moeite waard voor die prijs? of toch voor de iPad? http://bit.ly/cvEcfW #durftevragen','2010-07-23 11:55:22','2010-07-23 12:00:57'),(116,12906382,'dicabrio','http://a0.twimg.com/profile_images/768632884/Me-145986715_normal.png','19335878491','Wanna buy a stupid piece of shit: http://bit.ly/4tswMs','2010-07-23 14:41:26','2010-07-23 22:47:09'),(117,12906382,'dicabrio','http://a0.twimg.com/profile_images/768632884/Me-145986715_normal.png','19413519758','Is er een bom ontploft ergens? Op de vlietlanden is echt niemand. Raar - http://moby.to/950m44','2010-07-24 13:00:41','2010-07-25 22:21:09'),(121,12906382,'dicabrio','http://a0.twimg.com/profile_images/768632884/Me-145986715_normal.png','19559639472','Presentatie van D/A bij #cwcleiden - http://moby.to/2ogugk','2010-07-26 11:00:03','2010-07-26 11:17:08'),(122,12906382,'dicabrio','http://a0.twimg.com/profile_images/768632884/Me-145986715_normal.png','19578825047','Weer een lekker plaatje aan het luisteren: http://youtu.be/uorKDGU7O1w. Dankzij @hannahdezoete','2010-07-26 16:46:37','2010-07-26 20:30:52'),(123,12906382,'dicabrio','http://a0.twimg.com/profile_images/768632884/Me-145986715_normal.png','20329778683','@erikspee het blijft cool om te zien, maar variatie had gemogen','2010-08-04 22:07:04','2010-08-05 10:51:26'),(124,12906382,'dicabrio','http://a0.twimg.com/profile_images/768632884/Me-145986715_normal.png','20394502206','@Coworkcompany :) succes met je bord!','2010-08-05 17:08:30','2010-08-05 19:32:08'),(125,12906382,'dicabrio','http://a0.twimg.com/profile_images/768632884/Me-145986715_normal.png','20406336882','#twstory ik heb wat leuks te vertellen en dat komt dan op een site','2010-08-05 20:06:22','2010-08-06 00:04:13'),(127,12906382,'dicabrio','http://a0.twimg.com/profile_images/768632884/Me-145986715_normal.png','20465213826','@kruithoph hoe is het met je aanmelding voor \"take me out\"? #takemeout','2010-08-06 14:41:38','2010-08-08 19:43:19'),(129,12906382,'dicabrio','http://a0.twimg.com/profile_images/768632884/Me-145986715_normal.png','20786625529','@Pim_D http://myfirsttweet.com/','2010-08-10 13:15:55','2010-08-10 13:31:04'),(130,12906382,'dicabrio','http://a0.twimg.com/profile_images/768632884/Me-145986715_normal.png','21314168948','@rogierwilmink be je nog steeds opzoek naar een goede coder? Ik wil graag met je in contact komen','2010-08-16 15:19:56','2010-08-16 20:08:59'),(131,12906382,'dicabrio','http://a0.twimg.com/profile_images/768632884/Me-145986715_normal.png','21399316262','@Pim_D Succes! je krijgt een bericht voor een afspraak waarbij ze de iPhone komen afleveren','2010-08-17 14:31:31','2010-08-18 13:23:39'),(133,12906382,'dicabrio','http://a0.twimg.com/profile_images/768632884/Me-145986715_normal.png','21561272853','nice technology http://www.seadragon.com/developer/','2010-08-19 10:28:48','2010-08-19 12:00:59'),(134,12906382,'dicabrio','http://a0.twimg.com/profile_images/768632884/Me-145986715_normal.png','22069663846','@kruithoph heb je het haar al verteld dat ze zonder leuker is?','2010-08-25 09:22:44','2010-08-25 10:51:26'),(135,12906382,'dicabrio','http://a0.twimg.com/profile_images/768632884/Me-145986715_normal.png','22159298687','RT @MinouChatte: twitter hitman?  http://bit.ly/c5aDnh','2010-08-26 09:42:17','2010-08-26 15:07:40'),(137,12906382,'dicabrio','http://a0.twimg.com/profile_images/768632884/Me-145986715_normal.png','22176710756','Even bang dat de security update weer wat had verneukt in mijn php instellingen. Gelukkig opgelost: http://bit.ly/a9VCgu','2010-08-26 15:19:15','2010-08-26 15:37:52'),(138,12906382,'dicabrio','http://a0.twimg.com/profile_images/768632884/Me-145986715_normal.png','22272965948','@DiedX #flexservers? Maar dan met goede kwaliteit?','2010-08-27 16:50:43','2010-08-27 17:01:58'),(139,12906382,'dicabrio','http://a0.twimg.com/profile_images/768632884/Me-145986715_normal.png','22433189495','http://youtu.be/gzyj3Wxhjr4 Lekker plaatje van Jamiroquai. Thnx @1espresso!','2010-08-29 14:16:51','2010-08-29 23:24:10'),(141,12906382,'dicabrio','http://a0.twimg.com/profile_images/768632884/Me-145986715_normal.png','22516286132','http://bit.ly/bzlfR7 geinig zeg','2010-08-30 13:30:58','2010-08-30 15:42:22'),(142,12906382,'dicabrio','http://a0.twimg.com/profile_images/768632884/Me-145986715_normal.png','24099049220','29 crucial PC skills http://gizmo.do/a0ukgw','2010-09-10 14:14:52','2010-09-10 17:54:04'),(143,12906382,'dicabrio','http://a0.twimg.com/profile_images/768632884/Me-145986715_normal.png','24179315824','RT @photologix: #Poehee zeg, #hotseflots - wat je noemt een hard gelach met @eolam @basbakker & @dicabrio. Nu na tabee aan @twalkwithme  ...','2010-09-11 10:29:24','2010-09-11 14:42:01'),(147,12906382,'dicabrio','http://a0.twimg.com/profile_images/768632884/Me-145986715_normal.png','24281985544','@basbakker gevonden! van Charles R Swindoll','2010-09-12 15:08:16','2010-09-12 16:48:15'),(148,12906382,'dicabrio','http://a0.twimg.com/profile_images/768632884/Me-145986715_normal.png','24573014496','@erikspee NOpe niet voor hausmagger hoezo?','2010-09-15 16:11:08','2010-09-15 23:25:21'),(149,12906382,'dicabrio','http://a0.twimg.com/profile_images/768632884/Me-145986715_normal.png','24750136469','@ElineBergema Had je het linkje naar het audioboek nog ontvangen? #GTD','2010-09-17 13:35:19','2010-09-17 20:49:04'),(150,12906382,'dicabrio','http://a0.twimg.com/profile_images/768632884/Me-145986715_normal.png','25055444575','@BruceJillis Die is mooi! ( http://bit.ly/cUOI0j )','2010-09-20 22:30:05','2010-09-21 10:16:58'),(152,12906382,'dicabrio','http://a0.twimg.com/profile_images/768632884/Me-145986715_normal.png','25114399502','@mountvienna ik ben nieuwsgierig wat voor klus het is. Ik wil je graag helpen hierbij','2010-09-21 14:41:29','2010-09-21 22:02:52'),(159,12906382,'dicabrio','http://a0.twimg.com/profile_images/768632884/Me-145986715_normal.png','25150270498','RT @LeonPals: I\'ll just take the risk.. http://t.co/FLH9ZOY via @shareables','2010-09-21 22:46:37','2010-09-23 09:18:31'),(160,12906382,'dicabrio','http://a0.twimg.com/profile_images/768632884/Me-145986715_normal.png','25413562070','#ohohcherso jokertje door Carlo http://bit.ly/cl9I3o #grappig','2010-09-24 17:23:12','2010-09-25 01:51:31'),(161,12906382,'dicabrio','http://a0.twimg.com/profile_images/768632884/Me-145986715_normal.png','25690249142','@Aartjan dutchvertising.nl is een goed vormgever!','2010-09-27 16:17:37','2010-09-28 00:16:19'),(163,12906382,'dicabrio','http://a0.twimg.com/profile_images/768632884/Me-145986715_normal.png','25772656882','@basbakker activiteiten overzetten in #ical #osx van agenda 1 naar agenda 2: Export en daarna Import (Menu -&gt; Archief). Bedankt @KeesRomkes','2010-09-28 12:32:29','2010-09-28 14:17:25'),(165,12906382,'dicabrio','http://a0.twimg.com/profile_images/768632884/Me-145986715_normal.png','25788986663','Mooi nieuw logo http://bit.ly/bPZkWg  GT1 world championship','2010-09-28 16:24:06','2010-09-29 11:52:44'),(166,12906382,'dicabrio','http://a0.twimg.com/profile_images/768632884/Me-145986715_normal.png','26006382144','24 English accents http://youtu.be/dABo_DCIdpM','2010-09-30 21:02:09','2010-09-30 22:36:47'),(168,12906382,'dicabrio','http://a0.twimg.com/profile_images/768632884/Me-145986715_normal.png','26058196605','@jpschadde #ohohcherso +1 (via internet)','2010-10-01 09:12:20','2010-10-03 23:32:01'),(172,12906382,'dicabrio','http://a0.twimg.com/profile_images/768632884/Me-145986715_normal.png','26373483656','@photologix digitaal is soms bevrijdend, maar het kan ook een tunnel visie geven','2010-10-04 17:39:22','2010-10-05 12:40:00'),(174,12906382,'dicabrio','http://a0.twimg.com/profile_images/768632884/Me-145986715_normal.png','26485334502','@kruithoph wat ben jij een koning!','2010-10-05 21:51:31','2010-10-05 23:48:56'),(175,12906382,'dicabrio','http://a0.twimg.com/profile_images/768632884/Me-145986715_normal.png','26533025127','@photologix weekend kickoff aanmelding via een andere site laten lopen is vervelend','2010-10-06 10:14:05','2010-10-06 17:10:42'),(176,12906382,'dicabrio','http://a0.twimg.com/profile_images/768632884/Me-145986715_normal.png','26629516973','RT @frankvanrest: Over de streep,  Nog niet gezien? Zeker kijken! http://ow.ly/2PPiz /cc @vincentvanharte @paulmsmit','2010-10-07 09:54:45','2010-10-08 15:42:08'),(183,12906382,'dicabrio','http://a0.twimg.com/profile_images/768632884/Me-145986715_normal.png','26976761991','@AdrianPoke kippen gluren..... dat heb ik altijd al willen doen. Ben benieuwd','2010-10-11 00:34:39','2010-10-11 12:27:04'),(185,12906382,'dicabrio','http://a0.twimg.com/profile_images/768632884/Me-145986715_normal.png','27032411305','RT @Torpia: World 3 of www.torpia.com will be restarted on Tuesday, October 12th 2010! Register for free on www.torpia.com tomorrow! #up ...','2010-10-11 15:18:13','2010-10-11 21:37:24'),(194,12906382,'dicabrio','http://a0.twimg.com/profile_images/768632884/Me-145986715_normal.png','27064246039','RT @mountvienna: RT @petrah: Wie kan een psychologische test afnemen bij een kind met downsyndroom #durftevragen','2010-10-11 21:57:25','2010-10-11 22:10:01'),(195,12906382,'dicabrio','http://a0.twimg.com/profile_images/768632884/Me-145986715_normal.png','27070336126','Vindt die reclames van windows phone eigenlijk niet zo goed http://www.youtube.com/watch?v=Dv-fbO-_xl0&feature=player_embedded','2010-10-11 23:29:31','2010-10-12 08:54:29'),(197,12906382,'dicabrio','http://a0.twimg.com/profile_images/768632884/Me-145986715_normal.png','27129660857','Ben ik het helemaal mee eens http://bit.ly/9HTXW0 #foto','2010-10-12 13:32:42','2010-10-12 18:50:39'),(198,12906382,'dicabrio','http://a0.twimg.com/profile_images/768632884/Me-145986715_normal.png','27222601775','RT @ilonkaac: Hier begrijp ik dus niets van! &gt; Dales krijgt salaris InHolland doorbetaald: http://bit.ly/9JYrfB','2010-10-13 10:20:35','2010-10-13 10:22:00'),(199,12906382,'dicabrio','http://a0.twimg.com/profile_images/768632884/Me-145986715_normal.png','27233252819','Hij is binnen. Wat een vet apparaat! - http://moby.to/hooce1','2010-10-13 13:46:56','2010-10-13 15:21:32'),(200,12906382,'dicabrio','http://a0.twimg.com/profile_images/768632884/Me-145986715_normal.png','27328284871','Wie wil er HTML en CSS leren? Zo ja, waarvoor wil je het gaan gebruiken? #durftevragen','2010-10-14 12:30:12','2010-10-18 14:19:19'),(201,12906382,'dicabrio','http://a0.twimg.com/profile_images/768632884/Me-145986715_normal.png','27656428221','RT @basbakker: Wasknijper art - #tof - http://bit.ly/90QtRJ','2010-10-17 19:27:07','2010-10-18 22:35:53'),(204,12906382,'dicabrio','http://a0.twimg.com/profile_images/768632884/Me-145986715_normal.png','28059471203','interesting artist http://www.youtube.com/watch?v=PvjGl6HhxgU&feature=related','2010-10-21 22:52:18','2010-10-26 19:26:02'),(208,12906382,'dicabrio','http://a0.twimg.com/profile_images/768632884/Me-145986715_normal.png','28864558181','Bye Bye flash.. Welcome HTML 5 http://tv.adobe.com/watch/adc-presents/preview-of-the-edge-prototype-tool-for-html5-/','2010-10-27 07:57:52','2010-10-27 09:15:45'),(209,12906382,'dicabrio','http://a0.twimg.com/profile_images/768632884/Me-145986715_normal.png','28971999669','RT @ZonderGrenzen: Wel eens nagedacht over ondernemen in Afrika, Azie of Latijns-Amerika? Laat je inspireren op 11 november: http://bit. ...','2010-10-28 11:12:16','2010-10-28 11:30:15');
/*!40000 ALTER TABLE `tweet` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `password` char(32) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `active` int(4) NOT NULL DEFAULT '0',
  `activationkey` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'dicabrio','96e79218965eb72c92a549dd5a330112','',1,'','Robert Cabri'),(2,'bjorn','96e79218965eb72c92a549dd5a330112','',1,'','Bjorn Smit'),(15,'robert@dicabrio.com','96e79218965eb72c92a549dd5a330112','robert@dicabrio.com',1,'8bf9ff049e28fc430a1e8e260b71cb6481351cb3','Robert Cabri'),(20,'smitbv@hotmail.com','24dd7aff1f1dc836c66be8f8fa6c5022','smitbv@hotmail.com',1,'eccc97cb9a7f98b6ffc0b07d1c253c4ce7a87267','Onbekende 1'),(21,'communicatie@lckv.nl','288116504f5e303e4be4ff1765b81f5d','communicatie@lckv.nl',1,'4bb3042d798769b9a63409d2be09a07d40cc58ba','Communicatie'),(25,'linked@dicabrio.com','e10adc3949ba59abbe56e057f20f883e','linked@dicabrio.com',1,'256bb53038b950b14f852f5a215f36968162c27b','Robert Cabri'),(26,'robert.cabri@gmail.com','96e79218965eb72c92a549dd5a330112','robert.cabri@gmail.com',1,'2ae25d340b65fe5e7accc8c0b6f2c59153fe6749','<script>alert(\'hoi\')</script>');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_usergroup`
--

DROP TABLE IF EXISTS `user_usergroup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_usergroup` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `usergroup_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_usergroup`
--

LOCK TABLES `user_usergroup` WRITE;
/*!40000 ALTER TABLE `user_usergroup` DISABLE KEYS */;
INSERT INTO `user_usergroup` VALUES (1,1,1),(2,2,1),(5,15,3),(13,20,3),(15,21,3),(17,25,3),(19,26,3);
/*!40000 ALTER TABLE `user_usergroup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usergroup`
--

DROP TABLE IF EXISTS `usergroup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usergroup` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usergroup`
--

LOCK TABLES `usergroup` WRITE;
/*!40000 ALTER TABLE `usergroup` DISABLE KEYS */;
INSERT INTO `usergroup` VALUES (1,'Admin','Administrator'),(2,'Guest',''),(3,'User','plain user');
/*!40000 ALTER TABLE `usergroup` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-02-18 23:32:12
