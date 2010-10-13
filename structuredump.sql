-- phpMyAdmin SQL Dump
-- version 3.0.0-rc2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generatie Tijd: 17 Sept 2010 om 13:58
-- Server versie: 5.1.38
-- PHP Versie: 5.3.2

SET FOREIGN_KEY_CHECKS=0;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

SET AUTOCOMMIT=0;
START TRANSACTION;

--
-- Database: `dicabrio_com`
--

-- --------------------------------------------------------

--
-- Tabel structuur voor tabel `folder`
--

DROP TABLE IF EXISTS `folder`;
CREATE TABLE IF NOT EXISTS `folder` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `associationtype` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `folder_id` int(11) unsigned NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tabel structuur voor tabel `media`
--

DROP TABLE IF EXISTS `media`;
CREATE TABLE IF NOT EXISTS `media` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `extension` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mimetype` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `folder_id` int(11) NOT NULL,
  `location` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tabel structuur voor tabel `module`
--

DROP TABLE IF EXISTS `module`;
CREATE TABLE IF NOT EXISTS `module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `template` int(1) NOT NULL,
  `active` int(1) NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tabel structuur voor tabel `page`
--

DROP TABLE IF EXISTS `page`;
CREATE TABLE IF NOT EXISTS `page` (
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tabel structuur voor tabel `pagemodule`
--

DROP TABLE IF EXISTS `pagemodule`;
CREATE TABLE IF NOT EXISTS `pagemodule` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `page_id` int(11) unsigned NOT NULL,
  `identifier` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tabel structuur voor tabel `pagemodule_media`
--

DROP TABLE IF EXISTS `pagemodule_media`;
CREATE TABLE IF NOT EXISTS `pagemodule_media` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pagemodule_id` int(11) unsigned NOT NULL,
  `media_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pagemodule_id` (`pagemodule_id`,`media_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tabel structuur voor tabel `pagemodule_staticblock`
--

DROP TABLE IF EXISTS `pagemodule_staticblock`;
CREATE TABLE IF NOT EXISTS `pagemodule_staticblock` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pagemodule_id` int(11) unsigned NOT NULL,
  `staticblock_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pagemodule_id` (`pagemodule_id`,`staticblock_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tabel structuur voor tabel `pagemodule_templatefile`
--

DROP TABLE IF EXISTS `pagemodule_templatefile`;
CREATE TABLE IF NOT EXISTS `pagemodule_templatefile` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pagemodule_id` int(11) unsigned NOT NULL,
  `templatefile_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pagemodule_id` (`pagemodule_id`,`templatefile_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tabel structuur voor tabel `pagetext`
--

DROP TABLE IF EXISTS `pagetext`;
CREATE TABLE IF NOT EXISTS `pagetext` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pagemodule_id` int(11) unsigned NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tabel structuur voor tabel `quote`
--

DROP TABLE IF EXISTS `quote`;
CREATE TABLE IF NOT EXISTS `quote` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quote` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `source` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabel structuur voor tabel `setting`
--

DROP TABLE IF EXISTS `setting`;
CREATE TABLE IF NOT EXISTS `setting` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabel structuur voor tabel `staticblock`
--

DROP TABLE IF EXISTS `staticblock`;
CREATE TABLE IF NOT EXISTS `staticblock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `identifier` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `path` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tabel structuur voor tabel `templatefile`
--

DROP TABLE IF EXISTS `templatefile`;
CREATE TABLE IF NOT EXISTS `templatefile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `created` datetime NOT NULL,
  `folder_id` int(11) NOT NULL,
  `source` text COLLATE utf8_unicode_ci,
  `module_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tabel structuur voor tabel `tweet`
--

DROP TABLE IF EXISTS `tweet`;
CREATE TABLE IF NOT EXISTS `tweet` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tabel structuur voor tabel `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `password` char(32) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `active` int(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tabel structuur voor tabel `xmlfeed`
--

DROP TABLE IF EXISTS `xmlfeed`;
CREATE TABLE IF NOT EXISTS `xmlfeed` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pagemodule_id` int(10) unsigned NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `xml` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

SET FOREIGN_KEY_CHECKS=1;

COMMIT;
