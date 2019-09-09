-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 09 Eyl 2019, 21:33:36
-- Sunucu sürümü: 10.1.30-MariaDB
-- PHP Sürümü: 7.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `kursnotpaylasma`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ayarlar`
--

CREATE TABLE `ayarlar` (
  `id` int(11) NOT NULL,
  `site_logo` varchar(400) NOT NULL,
  `site_baslik` varchar(350) NOT NULL,
  `site_aciklama` varchar(300) NOT NULL,
  `site_link` varchar(100) NOT NULL,
  `site_sahip_mail` varchar(100) NOT NULL,
  `site_mail_host` varchar(100) NOT NULL,
  `site_mail_mail` varchar(100) NOT NULL,
  `site_mail_port` int(11) NOT NULL,
  `site_mail_sifre` varchar(100) NOT NULL,
  `sayfa_hakkimizda` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `ayarlar`
--

INSERT INTO `ayarlar` (`id`, `site_logo`, `site_baslik`, `site_aciklama`, `site_link`, `site_sahip_mail`, `site_mail_host`, `site_mail_mail`, `site_mail_port`, `site_mail_sifre`, `sayfa_hakkimizda`) VALUES
(1, '794969aksoyhlclogo.png', 'Aksoyhlc Not Paylaşma Scripti', 'Aksoyhlc Not Paylaşma Scripti', 'http://localhost/kurs/not-metin-paylasma', 'aksoyhlc@gmail.com', '00000', '000', 0, '000000', '<h1><span class=\"marker\"><s><em><strong>asdasd</strong></em></s></span></h1>\r\n\r\n<h1><span class=\"marker\"><s><em><strong>asd</strong></em></s></span></h1>\r\n\r\n<h1><span class=\"marker\"><s><em><strong>asd</strong></em></s></span></h1>\r\n\r\n<p>as</p>\r\n\r\n<p>d</p>\r\n\r\n<p>as</p>\r\n\r\n<p>d</p>\r\n\r\n<p>asd</p>\r\n\r\n<p>as</p>\r\n\r\n<p>d</p>\r\n');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanicilar`
--

CREATE TABLE `kullanicilar` (
  `kul_id` int(11) NOT NULL,
  `kul_isim` varchar(200) NOT NULL,
  `kul_mail` varchar(200) NOT NULL,
  `kul_sifre` varchar(100) NOT NULL,
  `kul_telefon` varchar(100) NOT NULL,
  `kul_yetki` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `kullanicilar`
--

INSERT INTO `kullanicilar` (`kul_id`, `kul_isim`, `kul_mail`, `kul_sifre`, `kul_telefon`, `kul_yetki`) VALUES
(1, 'Ökkeş Aksoy', 'aksoyhlc@gmail.com', '202cb962ac59075b964b07152d234b70', '', 1),
(2, 'Ökkeş', '27aksoy27@gmail.com', '202cb962ac59075b964b07152d234b70', '', 1),
(3, 'Ökkeş', 'aksoyhlcasdasdsadgmail.com', '202cb962ac59075b964b07152d234b70', '', 0),
(4, 'Ökkeş', 'adasdasd@gmail.com', 'c4ca4238a0b923820dcc509a6f75849b', '', 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `notlar`
--

CREATE TABLE `notlar` (
  `not_id` int(11) NOT NULL,
  `not_link` varchar(100) NOT NULL,
  `not_sifre` varchar(100) NOT NULL,
  `not_detay` mediumtext NOT NULL,
  `not_baslik` varchar(300) NOT NULL,
  `not_okunma_sayisi` int(11) NOT NULL DEFAULT '0',
  `not_durum` int(11) NOT NULL DEFAULT '1',
  `not_limit` bigint(11) NOT NULL,
  `not_eklenme_tarih` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `not_ekleyen` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `notlar`
--

INSERT INTO `notlar` (`not_id`, `not_link`, `not_sifre`, `not_detay`, `not_baslik`, `not_okunma_sayisi`, `not_durum`, `not_limit`, `not_eklenme_tarih`, `not_ekleyen`) VALUES
(2, '100', 'c4ca4238a0b923820dcc509a6f75849b', 'asdasdsad', 'qweqwe', 11, 1, 111, '2019-08-23 16:52:23', '0'),
(9, '5jzwo', '202cb962ac59075b964b07152d234b70', 'fsdfsdf', '', 2, 1, 9999999999, '2019-08-23 18:29:21', '0'),
(11, 'jm6yi', '202cb962ac59075b964b07152d234b70', 'TEST - 2', '', 4, 1, 9999999999, '2019-08-23 18:33:41', '0'),
(12, '6c6ti', '', 'Voluptates est numqu', '', 0, 1, 9999999999, '2019-08-23 18:38:25', '0'),
(13, '4v3nv', '', 'asdasdasd', '', 10, 1, 9999999999, '2019-08-23 18:56:36', '0'),
(15, 'x90to', '', 'xxxxxxxxxxxxx', 'TEST', 3, 1, 1111, '2019-08-23 20:59:41', '0'),
(20, 'ft069', '', 'asdasdasdasdasd', '', 0, 1, 9999999999, '2019-08-24 21:10:06', '1'),
(21, 'k1x5z', '', 'asdasdasdasdasd', '   window.location=\"https://google.com\" ', 0, 1, 9999999999, '2019-08-24 21:12:25', '1'),
(22, 'iiy05', '', 'asdasdasdasd', '   window.location=&quot;https://google.com&quot; ', 0, 1, 9999999999, '2019-08-24 21:13:27', '1'),
(23, '7xfm7', 'c4ca4238a0b923820dcc509a6f75849b', 'TESTTTT', 'test', 1, 1, 11, '2019-08-24 21:21:09', '1'),
(24, '5m1ii', '', 'q+dasddqwe&quot;&quot;-*2 1-/ea\r\ns as\r\ndasd as\r\n\r\ndasdişkasd a&ccedil;izczxcp &uuml;ği.asd ', 'adasdasdsad', 1, 1, 9999999999, '2019-08-24 21:21:35', '1'),
(25, 'ni78r', '', 'dsffs', '', 1, 1, 9999999999, '2019-08-25 11:57:28', '1'),
(26, '72x32', '', '', '', 0, 1, 9999999999, '2019-08-25 12:10:23', '1'),
(27, 'nr9j1', '202cb962ac59075b964b07152d234b70', 'asdasdas\r\nda\r\nsd\r\nasd\r\na\r\nsd', '', 2, 1, 9999999999, '2019-09-03 20:05:59', ''),
(28, 'awiei', '', 'asdasdasd', '', 2, 1, 1, '2019-09-03 20:07:31', '');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `ayarlar`
--
ALTER TABLE `ayarlar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `kullanicilar`
--
ALTER TABLE `kullanicilar`
  ADD PRIMARY KEY (`kul_id`);

--
-- Tablo için indeksler `notlar`
--
ALTER TABLE `notlar`
  ADD PRIMARY KEY (`not_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `ayarlar`
--
ALTER TABLE `ayarlar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `kullanicilar`
--
ALTER TABLE `kullanicilar`
  MODIFY `kul_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `notlar`
--
ALTER TABLE `notlar`
  MODIFY `not_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
