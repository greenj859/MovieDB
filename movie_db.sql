-- MySQL dump 10.13  Distrib 5.5.54, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: movies
-- ------------------------------------------------------
-- Server version	5.5.54-0ubuntu0.14.04.1

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
-- Current Database: `movies`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `movies` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `movies`;

--
-- Table structure for table `crew`
--

DROP TABLE IF EXISTS `crew`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `crew` (
  `movie_id` int(11) NOT NULL DEFAULT '0',
  `role` varchar(25) NOT NULL DEFAULT '',
  `fname` varchar(20) DEFAULT NULL,
  `lname` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`movie_id`,`role`),
  KEY `movie_id` (`movie_id`),
  CONSTRAINT `crew_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`movie_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `crew`
--

LOCK TABLES `crew` WRITE;
/*!40000 ALTER TABLE `crew` DISABLE KEYS */;
INSERT INTO `crew` VALUES (1,'Chazz Michael Michaels','Will','Ferrell'),(2,'Ricky Bobby','Will','Ferrell'),(3,'James King','Will','Ferrell'),(4,'Ron Burgundy','Will','Ferrell'),(5,'Ron Burgundy','Will','Ferrell'),(6,'Allen Gamble','Will','Ferrell'),(7,'Cam Brady','Will','Ferrell'),(8,'Buddy','Will','Ferrell'),(9,'Frank the Tank','Will','Ferrell'),(10,'Mugatu','Will','Ferrell'),(11,'Happy Gilmore','Adam','Sandler'),(12,'Robert Bouchet Jr.','Adam','Sandler'),(13,'Lenny Feder','Adam','Sandler'),(14,'Billy Madison','Adam','Sandler'),(15,'Sonny Koufax','Adam','Sandler'),(16,'Nicky','Adam','Sandler'),(17,'Henry Roth','Adam','Sandler'),(18,'Longfellow Deeds','Adam','Sandler'),(19,'Madea Simmons','Tyler','Perry'),(20,'Madea Simmons','Tyler','Perry'),(21,'Madea Simmons','Tyler','Perry'),(22,'Madea Simmons','Tyler','Perry'),(23,'Madea Simmons','Tyler','Perry'),(24,'Madea Simmons','Tyler','Perry'),(25,'John McClane','Bruce','Willis'),(26,'John McClane','Bruce','Willis'),(27,'John McClane','Bruce','Willis'),(28,'John McClane','Bruce','Willis'),(29,'John McClane','Bruce','Willis'),(30,'Gary','Jason','Segel');
/*!40000 ALTER TABLE `crew` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `movie_genres`
--

DROP TABLE IF EXISTS `movie_genres`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `movie_genres` (
  `movie_id` int(11) DEFAULT NULL,
  `genre` varchar(25) DEFAULT NULL,
  KEY `movie_id` (`movie_id`),
  CONSTRAINT `movie_genres_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`movie_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `movie_genres`
--

LOCK TABLES `movie_genres` WRITE;
/*!40000 ALTER TABLE `movie_genres` DISABLE KEYS */;
INSERT INTO `movie_genres` VALUES (1,'Comedy'),(2,'Comedy'),(3,'Comedy'),(4,'Comedy'),(5,'Comedy'),(6,'Comedy'),(7,'Comedy'),(8,'Comedy'),(9,'Comedy'),(10,'Comedy'),(11,'Comedy'),(12,'Comedy'),(13,'Idiocy'),(14,'Lunacy'),(15,'Irresponsibility'),(16,'Horror'),(17,'Action'),(18,'Drama'),(19,'Romance'),(20,'Documentary'),(21,'Science Fiction'),(22,'Fantasy'),(23,'Holiday'),(24,'Comedy'),(25,'Action'),(26,'Action'),(27,'Action'),(28,'Action'),(29,'Action'),(30,'Drama');
/*!40000 ALTER TABLE `movie_genres` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `movies`
--

DROP TABLE IF EXISTS `movies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `movies` (
  `movie_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(25) DEFAULT NULL,
  `summary` varchar(255) DEFAULT NULL,
  `release_date` date DEFAULT NULL,
  `language` varchar(25) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  PRIMARY KEY (`movie_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `movies`
--

LOCK TABLES `movies` WRITE;
/*!40000 ALTER TABLE `movies` DISABLE KEYS */;
INSERT INTO `movies` VALUES (1,'Blades of Glory','Two dudes figure skating','2007-03-30','English',93),(2,'Talladega Nights','Redneck likes to go fast','2006-08-04','English',108),(3,'Get Hard','Idiot goes to jail','2015-03-27','English',100),(4,'Anchorman 2: The Legend C','Four friends are still idiots','2013-12-18','English',119),(5,'Anchorman: The Legend of ','Four friends are idiots','2004-07-09','English',94),(6,'The Other Guys','Two idiots become heroes','2010-08-06','English',107),(7,'The Campaign','Two idiots try to become Americas idiots','2012-08-10','English',85),(8,'Elf','An idiot tries to be human','2003-11-07','English',97),(9,'Old School','Some idiots start a frat','2003-02-21','English',88),(10,'Zoolander','Two idiots try to look good','2001-09-28','English',90),(11,'Happy Gilmore','An idiot tries to play golf','1996-02-16','English',92),(12,'The Waterboy','An idiot tries to play football','1998-11-06','English',90),(13,'Grown Ups','A group of idiots try to have fun','2010-06-25','English',102),(14,'Billy Madison','An idiot tries to go to school','1995-02-10','English',89),(15,'Big Daddy','An idiot tries to raise a kid','1999-06-25','English',93),(16,'Little Nicky','An idiot tries to save the world','2000-11-10','English',90),(17,'50 First Dates','An idiot cannot remember yesterday','2004-02-13','English',99),(18,'Mr. Deeds','An idiot gets a lot of money','2002-06-28','English',96),(19,'Madeas Family Reunion','Dude is a lady','2002-01-01','English',134),(20,'Madeas Class Reunion','Dude who is a lady goes back to school','2003-01-01','English',120),(21,'Madea Goes to Jail','Dude goes to a lady prison','2006-06-27','English',134),(22,'Madeas Big Happy Family','Dude tries to get her family togerh','2011-04-22','English',106),(23,'A Madea Christmas','Dude tries to be lady tries to be Santa','2011-11-22','English',152),(24,'Madeas Witness Protection','In trouble again','2012-06-29','English',114),(25,'Die Hard','Dude saves the day','1988-07-20','English',131),(26,'Die Hard 2','He still does not die','1990-07-04','English',124),(27,'Die Hard with a Vengeance','A lot of people die, but him','1995-05-04','English',128),(28,'Live Free or Die Hard','More people die by him','2007-06-27','English',128),(29,'A Good Day to Die Hard','No death in this one. Psyche','2013-02-14','English',98),(30,'The Muppets','Gary is trippin on something hard and sees puppets','2011-11-23','English',103);
/*!40000 ALTER TABLE `movies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ratings`
--

DROP TABLE IF EXISTS `ratings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ratings` (
  `usr_id` int(11) NOT NULL DEFAULT '0',
  `movie_id` int(11) NOT NULL DEFAULT '0',
  `score` int(1) DEFAULT NULL,
  `comments` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`usr_id`,`movie_id`),
  KEY `usr_id` (`usr_id`),
  KEY `movie_id` (`movie_id`),
  CONSTRAINT `ratings_ibfk_1` FOREIGN KEY (`usr_id`) REFERENCES `users` (`usr_id`),
  CONSTRAINT `ratings_ibfk_2` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`movie_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ratings`
--

LOCK TABLES `ratings` WRITE;
/*!40000 ALTER TABLE `ratings` DISABLE KEYS */;
INSERT INTO `ratings` VALUES (1,1,5,'Hilarious'),(2,2,5,'Compelling'),(3,3,5,'Knee jerking hysterical'),(4,4,5,'Throw up good'),(5,5,5,'I cannot see anymore'),(6,6,5,'Am I done?'),(7,7,5,'God bless America'),(8,8,5,'I hate the holidays'),(9,9,5,'I hate college'),(10,10,5,'I want a pretty girlfriend'),(11,11,5,'Why do I watch this everyday and cry?'),(12,12,5,'I want muscles'),(13,13,5,'I wish i had friend'),(14,14,5,'I wish I had a brain'),(15,15,5,'I want a vasectomy'),(16,16,5,'I want to be a son of Saton'),(17,17,5,'Penguins are pretty cool'),(18,18,5,'I pity the fool'),(19,19,5,'I like drag queens'),(20,20,4,'Straight to DVD is not a good sign.'),(21,21,3,'Not the best in the series'),(22,22,5,'I love family dramas'),(23,23,5,'Holidays are the best'),(24,24,2,'could have been better'),(25,25,5,'John McClane is a boss'),(26,26,5,'John McClane is still a boss'),(27,27,5,'John McClane is becoming an old boss'),(28,28,5,'Why is John McClane not retired?'),(29,29,2,'This one could have been much better.'),(30,30,5,'I love me some puppets');
/*!40000 ALTER TABLE `ratings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tags` (
  `movie_id` int(11) DEFAULT NULL,
  `tag` varchar(255) DEFAULT NULL,
  KEY `movie_id` (`movie_id`),
  CONSTRAINT `tags_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`movie_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tags`
--

LOCK TABLES `tags` WRITE;
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
INSERT INTO `tags` VALUES (1,'figure skating, bromance'),(2,'NASCAR, bromance'),(3,'bromance, crime, fraud'),(4,'news, vintage'),(5,'San Diego, news, bromance'),(6,'crime, corruption, action'),(7,'bromance, politics, satire'),(8,'Christmas, holidays, romance'),(9,'college humor, frat house'),(10,'fashion, intrigue, Magnum'),(11,'golf, golden jacket, The Sizzler'),(12,'Colonel Sanders, water, Gatorade'),(13,'Idiots, idiots, idiots'),(14,'Questions, swan'),(15,'childcare, public urination'),(16,'occult, feelings'),(17,'Brain trauma, feelings'),(18,'Inheritance, money, deeds'),(19,'Comedy, gender bending'),(20,'Education, culture'),(21,'Family fun'),(22,'Inspiring'),(23,'Christmas, Santa Claus'),(24,'Self-reflection, series'),(25,'Christmas, bad guys'),(26,'Super hero, funny'),(27,'Hallibut, tuna'),(28,'Guns and death'),(29,'helicopters and stuff'),(30,'muppets, action, songs');
/*!40000 ALTER TABLE `tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `usr_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(25) NOT NULL,
  `password` varchar(20) NOT NULL,
  `fname` varchar(20) DEFAULT NULL,
  `mname` varchar(20) DEFAULT NULL,
  `lname` varchar(20) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` char(1) DEFAULT NULL,
  `is_manager` char(1) DEFAULT NULL,
  PRIMARY KEY (`usr_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Steve','password','Steve',NULL,'Chang','2000-01-01','M','Y'),(2,'Jared','password','Jared',NULL,'Green','2000-02-02','M','Y'),(3,'Chazz','password','Chazz',NULL,'Michaels','2000-03-03','M','N'),(4,'Kenneth','password','Kenneth',NULL,'Baldwin','1800-01-01','M','N'),(5,'Richard','password','Richard',NULL,'Pryor','1950-01-01','M','N'),(6,'Barry','password','Barry',NULL,'Obama','1965-01-01','M','N'),(7,'Hillary','password','Hillary',NULL,'Clinton','1960-01-01','F','N'),(8,'Barbara','password','Barbara',NULL,'Walters','1800-01-01','F','N'),(9,'Jane','password','Jane',NULL,'Doe','1980-01-01','F','N'),(10,'Pacman','password','Mrs.',NULL,'Pacman','1900-01-01','F','Y'),(11,'Billy','password','Billy','banksy','Cundiff','0000-00-00','M','N'),(12,'billy','password','bobby',NULL,'switzer','1212-12-22','M','N'),(13,'Dora','password','Dora',NULL,'The Explorer','2000-01-01','F','N'),(14,'Bourne','password','Jason',NULL,'Bourne','1980-02-02','M','Y'),(15,'Sammy','password','Samuel','L','Jackson','1950-01-01','M','N'),(16,'LordVader','pasword','Anakin',NULL,'Skywalker','1979-01-01','M','N'),(17,'batboy','password','Joseph',NULL,'Banks','1990-05-01','M','N'),(18,'Heineken','password','Heine',NULL,'Ken','1960-01-01','M','Y'),(19,'WyattEarp','password','Wyatt',NULL,'Earp','1965-05-11','M','N'),(20,'Leia','password','Carrie',NULL,'Fisher','1956-10-21','F','N'),(21,'Solo','password','Han',NULL,'Solo','1977-05-25','M','N'),(22,'Chewy','password','Chew',NULL,'Toy','1976-05-25','M','Y'),(23,'robotchicken','password','Robot',NULL,'Chicken','2005-01-01','M','N'),(24,'Discotech','password','Disco',NULL,'NotDeat','2016-01-01','F','N'),(25,'ShaoLin','password','Kung',NULL,'Fu','2000-05-05','M','N'),(26,'Barb','password','Barbara',NULL,'Bush','1900-05-05','F','N'),(27,'OJ','password','OJ',NULL,'Simpson','1965-01-01','M','N'),(28,'Spock','password','Spock',NULL,'The Vulcan','1960-01-01','M','N'),(29,'Hotel','password','Hotel',NULL,'California','1965-01-01','M','N'),(30,'Cowboy','password','Ezekiel',NULL,'Elliot','1995-01-01','M','N');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-04-21 13:54:45
