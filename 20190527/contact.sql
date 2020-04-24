-- phpMyAdmin SQL Dump
-- version 3.5.7
-- http://www.phpmyadmin.net
--
-- 主機: localhost
-- 產生日期: 2013 年 10 月 14 日 09:17
-- 伺服器版本: 5.1.67
-- PHP 版本: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 資料庫: `contact`
--

-- --------------------------------------------------------

--
-- 表的結構 `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `groupid` varchar(20) NOT NULL,
  `groupname` varchar(50) NOT NULL,
  `valid` enum('Y','N') NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`groupid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 轉存資料表中的資料 `groups`
--

INSERT INTO `groups` (`groupid`, `groupname`, `valid`) VALUES
('UI3A', '資工三年級A班', 'Y'),
('UI3B', '資工三年級B班', 'Y'),
('UI4A', '資工四年級A班', 'Y'),
('UI4B', '資工四年級B班', 'Y'),
('UN4', '資經四年級', 'Y');

-- --------------------------------------------------------

--
-- 表的結構 `namelist`
--

CREATE TABLE IF NOT EXISTS `namelist` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `groupid` varchar(20) NOT NULL,
  `birthday` date NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` varchar(100) NOT NULL,
  `valid` enum('Y','N') NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`cid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- 轉存資料表中的資料 `namelist`
--

INSERT INTO `namelist` (`cid`, `name`, `groupid`, `birthday`, `phone`, `address`, `valid`) VALUES
(1, '專題', 'UI3A', '2011-02-01', '(2)21822928 x6561', 'eeeee', 'Y'),
(2, '張三', 'UI3B', '2000-12-12', '0912345678', 'A5-811', 'Y'),
(3, '李四', 'UI4A', '1998-01-01', '0932456567', '台北市', 'Y'),
(17, 'aaa', 'UI3A', '0000-00-00', '5555', 'A5-705', 'Y'),
(4, '王武', 'UI3A', '0000-00-00', '0912345678', '<a href=http://www.ttu.edu.tw><font color=white>TTU</font></a>', 'Y'),
(5, '林大同', 'UI3A', '0000-00-00', '1234', '大同大學', 'Y'),
(6, '許六', 'UI3A', '0000-00-00', '6561', '資工系', 'Y'),
(7, '陳年', 'UI3B', '0000-00-00', '6590', '資訊系', 'Y'),
(8, 'AAA', 'UI3A', '0000-00-00', '6547', 'BB', 'Y'),
(9, 'bbb', 'UI3A', '0000-00-00', '34134', 'bbb', 'Y'),
(10, 'dddd', 'UI3A', '0000-00-00', '13412', 'dddd', 'Y'),
(11, 'ffff', 'UI3A', '0000-00-00', '132413', '314', 'Y'),
(12, 'dfadsf', 'UI3A', '0000-00-00', '253245', 'adfadf', 'Y'),
(13, '452354', 'UI3A', '0000-00-00', '34512435', 'fgdsg', 'Y'),
(14, 'sfgsrg', 'UI3A', '0000-00-00', '342413', 'dfgsdgfds', 'Y'),
(15, 'adsfasdf', 'UN4', '0000-00-00', '34513', 'gsdgsdf', 'Y'),
(16, 'adgsfg', 'UI3A', '0000-00-00', '3546356', 'fdgdgfdfg', 'Y');

-- --------------------------------------------------------

--
-- 表的結構 `privileges`
--

CREATE TABLE IF NOT EXISTS `privileges` (
  `seqno` smallint(6) NOT NULL AUTO_INCREMENT,
  `loginid` varchar(20) NOT NULL,
  `groupid` varchar(20) NOT NULL,
  `privilege` smallint(6) NOT NULL DEFAULT '1',
  `valid` enum('Y','N') NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`seqno`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- 轉存資料表中的資料 `privileges`
--

INSERT INTO `privileges` (`seqno`, `loginid`, `groupid`, `privilege`, `valid`) VALUES
(1, 'i4010', 'UI3A', 3, 'Y'),
(2, 'i4010', 'UI3B', 3, 'Y'),
(3, 'i4010', 'UI4A', 3, 'N'),
(4, 'i4010', 'UI4B', 3, 'N'),
(5, 'i4010', 'UN4', 3, 'Y'),
(6, 'i4010-3b', 'UI3B', 3, 'Y'),
(7, 'i4010-4a', 'UI4A', 3, 'Y');

-- --------------------------------------------------------

--
-- 表的結構 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `seqno` smallint(6) NOT NULL AUTO_INCREMENT,
  `loginid` varchar(20) NOT NULL,
  `passwd` varchar(50) NOT NULL,
  `groupid` varchar(20) NOT NULL,
  `valid` enum('Y','N') NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`seqno`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 轉存資料表中的資料 `user`
--

INSERT INTO `user` (`seqno`, `loginid`, `passwd`, `groupid`, `valid`) VALUES
(1, 'i4010', 'b7772864eb1c7f59502034e87dc22a50', 'UI3A', 'Y');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
