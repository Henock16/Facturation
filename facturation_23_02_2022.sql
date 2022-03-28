-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Mer 23 Février 2022 à 08:46
-- Version du serveur: 5.6.12-log
-- Version de PHP: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `facturation`
--
CREATE DATABASE IF NOT EXISTS `facturation` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `facturation`;

-- --------------------------------------------------------

--
-- Structure de la table `chargeur`
--

CREATE TABLE IF NOT EXISTS `chargeur` (
  `IDENTIFIANT` int(100) NOT NULL AUTO_INCREMENT,
  `NOM` mediumtext NOT NULL,
  `VILLE` varchar(10000) NOT NULL,
  `STATUT` int(1) NOT NULL COMMENT '0=Actif 1=inactif',
  PRIMARY KEY (`IDENTIFIANT`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `email`
--

CREATE TABLE IF NOT EXISTS `email` (
  `IDENTIFIANT` int(11) NOT NULL AUTO_INCREMENT,
  `LIBELLE` varchar(100) NOT NULL,
  `ID_USER` int(10) NOT NULL,
  `STATUT` int(1) NOT NULL,
  PRIMARY KEY (`IDENTIFIANT`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `email`
--

INSERT INTO `email` (`IDENTIFIANT`, `LIBELLE`, `ID_USER`, `STATUT`) VALUES
(1, 'abrosteph@yahoo.fr', 10, 0),
(2, 'abrosteph@gmail.com', 10, 0),
(3, 'stephaneabro@cci.ci', 10, 0),
(4, 'abrosteph@cci.ci', 2, 1),
(5, 'stephaneabro@cci.ci', 2, 0);

-- --------------------------------------------------------

--
-- Structure de la table `facture`
--

CREATE TABLE IF NOT EXISTS `facture` (
  `IDENTIFIANT` int(11) NOT NULL AUTO_INCREMENT,
  `ANNEE` varchar(4) NOT NULL,
  `MOIS` varchar(2) NOT NULL,
  `TYPE` int(1) NOT NULL COMMENT '1=cafe/cacao  2=autres',
  `NUM_FACTURE` int(100) NOT NULL,
  `ID_USER` int(11) NOT NULL,
  `NBCH` int(10) NOT NULL,
  `NBTC` int(10) NOT NULL,
  `MONTANT` int(10) NOT NULL,
  PRIMARY KEY (`IDENTIFIANT`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=219 ;

--
-- Contenu de la table `facture`
--

INSERT INTO `facture` (`IDENTIFIANT`, `ANNEE`, `MOIS`, `TYPE`, `NUM_FACTURE`, `ID_USER`, `NBCH`, `NBTC`, `MONTANT`) VALUES
(217, '2021', '05', 2, 0, 91, 1, 29, 79750),
(216, '2021', '05', 2, 0, 88, 1, 96, 264000),
(215, '2021', '05', 2, 0, 86, 78, 1024, 2816000),
(214, '2021', '05', 2, 0, 85, 1, 241, 662750),
(213, '2021', '05', 2, 0, 84, 3, 39, 107250),
(212, '2021', '05', 2, 0, 83, 1, 138, 379500),
(211, '2021', '05', 2, 0, 82, 47, 1012, 2783000),
(210, '2021', '05', 2, 0, 75, 4, 68, 187000),
(209, '2021', '05', 2, 0, 72, 1, 190, 522500),
(208, '2021', '05', 2, 0, 71, 5, 895, 2461250),
(207, '2021', '05', 2, 0, 70, 1, 49, 134750),
(206, '2021', '05', 2, 0, 66, 1, 9, 24750),
(205, '2021', '05', 2, 0, 65, 1, 3, 8250),
(204, '2021', '05', 2, 0, 61, 1, 99, 272250),
(203, '2021', '05', 2, 0, 60, 1, 72, 198000),
(202, '2021', '05', 2, 0, 59, 1, 14, 38500),
(201, '2021', '05', 2, 0, 58, 21, 256, 704000),
(200, '2021', '05', 2, 0, 56, 4, 142, 390500),
(199, '2021', '05', 2, 0, 55, 2, 160, 440000),
(198, '2021', '05', 2, 0, 47, 1, 118, 324500),
(197, '2021', '05', 2, 0, 46, 5, 272, 748000),
(196, '2021', '05', 2, 0, 44, 1, 379, 1042250),
(195, '2021', '05', 2, 0, 40, 2, 11, 30250),
(194, '2021', '05', 2, 0, 36, 1, 79, 217250),
(193, '2021', '05', 2, 0, 35, 31, 344, 946000),
(192, '2021', '05', 2, 0, 33, 1, 1, 2750),
(191, '2021', '05', 2, 0, 31, 1, 45, 123750),
(190, '2021', '05', 2, 0, 29, 21, 318, 874500),
(189, '2021', '05', 2, 0, 28, 14, 1332, 3663000),
(188, '2021', '05', 2, 0, 27, 1, 35, 96250),
(174, '2021', '05', 2, 0, 2, 1, 155, 426250),
(187, '2021', '05', 2, 0, 26, 1, 20, 55000),
(186, '2021', '05', 2, 0, 24, 1, 73, 200750),
(185, '2021', '05', 2, 0, 23, 18, 338, 929500),
(184, '2021', '05', 2, 0, 20, 21, 988, 2717000),
(183, '2021', '05', 2, 0, 19, 1, 709, 1949750),
(182, '2021', '05', 2, 0, 18, 1, 7, 19250),
(181, '2021', '05', 2, 0, 14, 1, 7, 19250),
(180, '2021', '05', 2, 0, 13, 2, 171, 470250),
(179, '2021', '05', 2, 0, 12, 7, 139, 382250),
(178, '2021', '05', 2, 0, 10, 94, 1918, 5274500),
(177, '2021', '05', 2, 0, 9, 1, 174, 478500),
(176, '2021', '05', 2, 0, 8, 1, 41, 112750),
(175, '2021', '05', 2, 0, 5, 89, 1470, 4042500),
(88, '2021', '04', 2, 0, 2, 1, 75, 206250),
(89, '2021', '04', 2, 0, 5, 118, 1943, 5343250),
(90, '2021', '04', 2, 0, 8, 1, 25, 68750),
(91, '2021', '04', 2, 0, 9, 1, 175, 481250),
(92, '2021', '04', 2, 0, 10, 86, 1822, 5010500),
(93, '2021', '04', 2, 0, 12, 4, 41, 112750),
(94, '2021', '04', 2, 0, 13, 2, 274, 753500),
(95, '2021', '04', 2, 0, 14, 1, 24, 66000),
(96, '2021', '04', 2, 0, 18, 2, 75, 206250),
(97, '2021', '04', 2, 0, 19, 1, 837, 2301750),
(98, '2021', '04', 2, 0, 20, 24, 1372, 3773000),
(99, '2021', '04', 2, 0, 23, 20, 194, 533500),
(100, '2021', '04', 2, 0, 24, 1, 111, 305250),
(101, '2021', '04', 2, 0, 26, 1, 56, 154000),
(102, '2021', '04', 2, 0, 27, 1, 35, 96250),
(103, '2021', '04', 2, 0, 28, 10, 1160, 3190000),
(104, '2021', '04', 2, 0, 29, 21, 449, 1234750),
(105, '2021', '04', 2, 0, 31, 1, 54, 148500),
(106, '2021', '04', 2, 0, 33, 3, 107, 294250),
(107, '2021', '04', 2, 0, 35, 30, 306, 841500),
(108, '2021', '04', 2, 0, 36, 1, 54, 148500),
(109, '2021', '04', 2, 0, 44, 1, 323, 888250),
(110, '2021', '04', 2, 0, 46, 9, 320, 880000),
(111, '2021', '04', 2, 0, 47, 1, 190, 522500),
(112, '2021', '04', 2, 0, 55, 2, 65, 178750),
(113, '2021', '04', 2, 0, 56, 4, 121, 332750),
(114, '2021', '04', 2, 0, 57, 1, 1, 2750),
(115, '2021', '04', 2, 0, 58, 22, 202, 555500),
(116, '2021', '04', 2, 0, 59, 1, 18, 49500),
(117, '2021', '04', 2, 0, 60, 1, 109, 299750),
(118, '2021', '04', 2, 0, 61, 1, 148, 407000),
(119, '2021', '04', 2, 0, 65, 3, 18, 49500),
(120, '2021', '04', 2, 0, 66, 1, 3, 8250),
(121, '2021', '04', 2, 0, 70, 1, 58, 159500),
(122, '2021', '04', 2, 0, 71, 5, 922, 2535500),
(123, '2021', '04', 2, 0, 72, 1, 200, 550000),
(124, '2021', '04', 2, 0, 75, 5, 45, 123750),
(125, '2021', '04', 2, 0, 82, 48, 820, 2255000),
(126, '2021', '04', 2, 0, 83, 1, 203, 558250),
(127, '2021', '04', 2, 0, 84, 3, 61, 167750),
(128, '2021', '04', 2, 0, 85, 1, 169, 464750),
(129, '2021', '04', 2, 0, 86, 77, 1073, 2950750),
(130, '2021', '04', 2, 0, 88, 1, 160, 440000),
(131, '2021', '04', 2, 0, 91, 1, 41, 112750),
(132, '2021', '04', 2, 0, 97, 3, 117, 321750),
(133, '2021', '03', 2, 0, 2, 1, 122, 335500),
(134, '2021', '03', 2, 0, 5, 104, 1755, 4826250),
(135, '2021', '03', 2, 0, 8, 1, 26, 71500),
(136, '2021', '03', 2, 0, 9, 1, 191, 525250),
(137, '2021', '03', 2, 0, 10, 77, 2232, 6138000),
(138, '2021', '03', 2, 0, 12, 3, 48, 132000),
(139, '2021', '03', 2, 0, 13, 2, 312, 858000),
(140, '2021', '03', 2, 0, 18, 1, 48, 132000),
(141, '2021', '03', 2, 0, 19, 1, 434, 1193500),
(142, '2021', '03', 2, 0, 20, 20, 894, 2458500),
(143, '2021', '03', 2, 0, 23, 10, 130, 357500),
(144, '2021', '03', 2, 0, 24, 1, 121, 332750),
(145, '2021', '03', 2, 0, 27, 1, 39, 107250),
(146, '2021', '03', 2, 0, 28, 10, 975, 2681250),
(147, '2021', '03', 2, 0, 29, 25, 357, 981750),
(148, '2021', '03', 2, 0, 31, 1, 37, 101750),
(149, '2021', '03', 2, 0, 33, 5, 234, 643500),
(150, '2021', '03', 2, 0, 35, 33, 408, 1122000),
(151, '2021', '03', 2, 0, 36, 2, 42, 115500),
(152, '2021', '03', 2, 0, 40, 2, 27, 74250),
(153, '2021', '03', 2, 0, 44, 1, 392, 1078000),
(154, '2021', '03', 2, 0, 46, 8, 247, 679250),
(155, '2021', '03', 2, 0, 47, 1, 266, 731500),
(156, '2021', '03', 2, 0, 55, 1, 79, 217250),
(157, '2021', '03', 2, 0, 56, 6, 302, 830500),
(158, '2021', '03', 2, 0, 58, 21, 215, 591250),
(159, '2021', '03', 2, 0, 59, 1, 13, 35750),
(160, '2021', '03', 2, 0, 60, 1, 96, 264000),
(161, '2021', '03', 2, 0, 61, 1, 172, 473000),
(162, '2021', '03', 2, 0, 65, 2, 18, 49500),
(163, '2021', '03', 2, 0, 70, 1, 28, 77000),
(164, '2021', '03', 2, 0, 71, 5, 920, 2530000),
(165, '2021', '03', 2, 0, 72, 1, 283, 778250),
(166, '2021', '03', 2, 0, 75, 2, 39, 107250),
(167, '2021', '03', 2, 0, 82, 41, 897, 2466750),
(168, '2021', '03', 2, 0, 84, 3, 80, 220000),
(169, '2021', '03', 2, 0, 85, 1, 345, 948750),
(170, '2021', '03', 2, 0, 86, 67, 1263, 3473250),
(171, '2021', '03', 2, 0, 88, 1, 204, 561000),
(172, '2021', '03', 2, 0, 91, 1, 44, 121000),
(173, '2021', '03', 2, 0, 97, 3, 89, 244750),
(218, '2021', '05', 2, 0, 97, 2, 28, 77000);

-- --------------------------------------------------------

--
-- Structure de la table `parametre`
--

CREATE TABLE IF NOT EXISTS `parametre` (
  `IDENTIFIANT` int(10) NOT NULL AUTO_INCREMENT,
  `TYPE` varchar(50) NOT NULL,
  `NOM` varchar(100) NOT NULL,
  `LIBELLE` varchar(100) NOT NULL,
  `VALEUR` varchar(100) NOT NULL,
  `EXPLICATION` varchar(500) NOT NULL,
  PRIMARY KEY (`IDENTIFIANT`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Contenu de la table `parametre`
--

INSERT INTO `parametre` (`IDENTIFIANT`, `TYPE`, `NOM`, `LIBELLE`, `VALEUR`, `EXPLICATION`) VALUES
(1, 'number', 'deconnect', 'Temps de connexion', '15', 'Temps sans clic en minute au bout duquel l''application se deconnecte automatiquement'),
(2, 'text', 'appli', 'Nom de l''application', 'FACTURATION SOLAS', 'Nom de l''application apparaissant dans le titre des mails envoyes'),
(3, 'text', 'nom_site', 'Url du site internet de l''application', 'www.pesagecci.com/facturation', 'URL du site ou est hebergee l''application sans le http:// ou https://'),
(4, 'ouinon', 'mail_server', 'Emission des mails', '0', 'Activation de la transmission de mail vers les utilisateurs, présence de serveur de mail'),
(5, 'ouinon', 'test_mail', 'Mail vers la boite de l''administrateur \r\n', '0', 'Envoyer tous les mails dans la boite de l''administrateur au lieu des opérateurs auxquels ils sont destinés'),
(6, 'ouinon', 'mail_fact', 'Emission de mail automatique de facturation ', '0', 'Activer ou non la generation des factures en debut de mois '),
(12, 'ouinon', 'autres', 'Facturation des autres produits', '1', 'Facturation des autres pesées '),
(7, 'text', 'mail_admin', 'Mail de l''administrateur', 'stephaneabro@cci.ci', 'Adresse électronique de l''administrateur de l''application'),
(8, 'number', 'facture', 'Mois en arrière a facturer', '6', 'Nombre de  mois en arrière de facturation automatique\r\n\r\n'),
(9, 'number', 'tarif', 'Tarif SOLAS (Franc CFA)', '2750', 'Coût de la prestation SOLAS'),
(10, 'ouinon', 'cafe', 'Facturation du café/cacao', '0', 'Facturation des pesées café/cacao'),
(11, 'ouinon', 'cajou', 'Facturation du coton/cajou', '1', 'Facturation des pesées coton/cajou'),
(13, 'number', 'nbpnt', 'Nombre de ponts par page', '3', 'Nombre maximum de ponts a afficher dans une page'),
(17, 'ouinon', 'genfact', 'Générer les factures sois même', '0', 'Forcer la génération des factures par le module d’émission des factures si elles ne l''ont pas encore été. (Dans ce cas, cette génération mettra du temps et risque d''echouer)'),
(14, 'number', 'nbchg', 'Nombre de chargeurs par page', '5', 'Nombre maximum de chargeurs a afficher dans une page'),
(16, 'text', 'pass', 'Mot de passe par défaut', '12345', 'Mot de passe après la création ou la réinitialisation du compte '),
(15, 'number', 'nbuser', 'Nombre d''utilisateurs par page', '3', 'Nombre maximum d''utilisateurs a afficher dans une page'),
(19, 'text', 'numcc', 'Numéro de coompte contribuable', '9-206.388.X', 'Numéro de coompte contribuable de la CCI'),
(20, 'text', 'regime', 'Régime fiscal', 'Régime du réel normal', 'Régime fiscal de la CCI'),
(21, 'text', 'impot', 'Centre des impôts', 'Direction des grandes entreprises', 'Centre des impôts de la CCI'),
(22, 'text', 'bank', 'Banque', 'UBA COTE DIVOIRE', 'Banque de la CCI'),
(23, 'text', 'compte', 'Compte banquaire', 'CI150 0100 101090011461', 'Compte banquaire de la CCI'),
(24, 'number', 'tva', 'Taux de la TVA', '18', 'Taux de TVA en vigueur'),
(25, 'text', 'signature', 'Signature du chef comptable', 'facture_solas.png', 'Fichier image de la signature du Chef de Département Comptable et Financier'),
(26, 'ouinon', 'cumul', 'Factures cumulatives', '1', 'Si les factures sont cumulatives, celles-ci s''additionnent chaque mois en cas d’impayé. les paiements doivent être mis a jour. Si non cumulatives, ce sont les non paiements qui doivent être mis a jour. ');

-- --------------------------------------------------------

--
-- Structure de la table `pont`
--

CREATE TABLE IF NOT EXISTS `pont` (
  `IDENTIFIANT` int(11) NOT NULL AUTO_INCREMENT,
  `STATUT` int(1) NOT NULL DEFAULT '0',
  `ID_PONT` int(11) NOT NULL,
  `ID_USER` int(11) NOT NULL,
  `IMPAYES` int(10) NOT NULL DEFAULT '0',
  `DATE_CREATION` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`IDENTIFIANT`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=62 ;

--
-- Contenu de la table `pont`
--

INSERT INTO `pont` (`IDENTIFIANT`, `STATUT`, `ID_PONT`, `ID_USER`, `IMPAYES`, `DATE_CREATION`) VALUES
(1, 0, 210, 2, 17263400, '2021-09-30 10:33:47'),
(2, 0, 196, 3, 1, '2021-09-30 10:33:47'),
(3, 0, 97, 4, 0, '2021-09-30 10:33:47'),
(4, 0, 66, 5, 142812450, '2021-09-30 10:33:47'),
(5, 0, 175, 6, 0, '2021-09-30 10:33:47'),
(6, 0, 174, 7, 299750, '2021-09-30 10:33:47'),
(7, 0, 204, 8, 4787828, '2021-09-30 10:33:47'),
(8, 0, 146, 9, 6515960, '2021-09-30 10:33:47'),
(9, 0, 145, 10, 1000375090, '2021-09-30 10:33:47'),
(10, 0, 157, 10, 1000375090, '2021-09-30 10:33:47'),
(11, 0, 161, 10, 1000375090, '2021-09-30 10:33:47'),
(12, 0, 159, 10, 1000375090, '2021-09-30 10:33:47'),
(13, 0, 160, 10, 1000375090, '2021-09-30 10:33:47'),
(14, 0, 158, 10, 1000375090, '2021-09-30 10:33:47'),
(15, 0, 7, 10, 1000375090, '2021-09-30 10:33:47'),
(16, 0, 168, 10, 1000375090, '2021-09-30 10:33:47'),
(17, 0, 156, 10, 1000375090, '2021-09-30 10:33:47'),
(18, 0, 135, 10, 1000375090, '2021-09-30 10:33:47'),
(19, 0, 166, 11, 0, '2021-09-30 10:33:47'),
(20, 0, 113, 12, 2823150, '2021-09-30 10:33:47'),
(21, 0, 170, 13, 9725265, '2021-09-30 10:33:47'),
(22, 0, 171, 13, 9725265, '2021-09-30 10:33:47'),
(23, 0, 167, 14, 314765, '2021-09-30 10:33:47'),
(24, 0, 100, 15, 0, '2021-09-30 10:33:47'),
(25, 0, 213, 16, 0, '2021-09-30 10:33:47'),
(26, 0, 207, 17, 0, '2021-09-30 10:33:47'),
(27, 0, 201, 18, 1090320, '2021-09-30 10:33:47'),
(28, 0, 75, 19, 19752315, '2021-09-30 10:33:47'),
(29, 0, 61, 20, 31041670, '2021-09-30 10:33:47'),
(30, 0, 82, 21, 880000, '2021-09-30 10:33:47'),
(31, 0, 131, 22, 0, '2021-09-30 10:33:47'),
(32, 0, 184, 23, 34845855, '2021-09-30 10:33:47'),
(33, 0, 73, 23, 34845855, '2021-09-30 10:33:47'),
(34, 0, 92, 24, 2534345, '2021-09-30 10:33:47'),
(35, 0, 169, 25, 0, '2021-09-30 10:33:47'),
(36, 0, 162, 26, 2115740, '2021-09-30 10:33:47'),
(37, 0, 205, 27, 1169960, '2021-09-30 10:33:47'),
(38, 0, 63, 28, 42704860, '2021-09-30 10:33:47'),
(39, 0, 72, 28, 42704860, '2021-09-30 10:33:47'),
(40, 0, 50, 29, 39328025, '2021-09-30 10:33:47'),
(41, 0, 208, 29, 39328025, '2021-09-30 10:33:47'),
(42, 0, 85, 29, 39328025, '2021-09-30 10:33:47'),
(43, 0, 96, 31, 1629430, '2021-09-30 10:33:47'),
(44, 0, 144, 32, 58410, '2021-09-30 10:33:47'),
(45, 0, 38, 10, 1000375090, '2021-09-30 10:33:47'),
(46, 0, 36, 10, 1000375090, '2021-09-30 10:33:47'),
(47, 0, 214, 10, 1000375090, '2021-09-30 10:33:47'),
(48, 0, 40, 10, 1000375090, '2021-09-30 10:33:47'),
(49, 0, 42, 10, 1000375090, '2021-09-30 10:33:47'),
(53, 0, 81, 10, 1000375090, '2021-09-30 10:33:47'),
(52, 0, 142, 33, 2261765, '2021-09-30 10:33:47'),
(54, 0, 138, 10, 1000375090, '2021-09-30 10:33:47'),
(55, 0, 67, 23, 34845855, '2021-09-30 10:33:47'),
(56, 0, 177, 23, 34845855, '2021-09-30 10:33:47'),
(57, 0, 155, 23, 34845855, '2021-09-30 10:33:47'),
(58, 0, 180, 23, 34845855, '2021-09-30 10:33:47'),
(59, 1, 178, 34, 175232, '2021-10-04 15:58:10'),
(60, 1, 185, 34, 1, '2021-10-07 10:55:12'),
(61, 0, 101, 34, 334245, '2021-10-07 10:56:24');

-- --------------------------------------------------------

--
-- Structure de la table `posseder`
--

CREATE TABLE IF NOT EXISTS `posseder` (
  `IDENTIFIANT` int(11) NOT NULL AUTO_INCREMENT,
  `ID_USER` int(11) NOT NULL,
  `ID_CHAR` int(11) NOT NULL,
  `STATUT` int(11) NOT NULL,
  PRIMARY KEY (`IDENTIFIANT`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `IDENTIFIANT` int(10) NOT NULL AUTO_INCREMENT,
  `TYPE` int(10) NOT NULL,
  `STATUT` int(1) NOT NULL DEFAULT '0',
  `STRUCTURE` varchar(50) NOT NULL,
  `LOGIN` varchar(50) NOT NULL,
  `BP` varchar(100) DEFAULT NULL,
  `TELEPHONE` varchar(100) DEFAULT NULL,
  `NUM_CC` varchar(100) DEFAULT NULL,
  `ADRESSE_GEO` text,
  `ACOMPTE` int(10) NOT NULL DEFAULT '0',
  `PASS` varchar(50) NOT NULL,
  `FIRST_CONNECTION` int(1) NOT NULL DEFAULT '0' COMMENT '0-pas encore connécté/1-deja connecté/2-mot de passe réinitialisé ',
  `DERNIERE_ACTION` int(16) NOT NULL DEFAULT '0',
  `LAST_PAGE` varchar(100) DEFAULT NULL,
  `DATE_CREATION` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CREATEUR` int(10) NOT NULL,
  `DATE_MODIF` datetime DEFAULT NULL,
  `MODIFICATEUR` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`IDENTIFIANT`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=35 ;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`IDENTIFIANT`, `TYPE`, `STATUT`, `STRUCTURE`, `LOGIN`, `BP`, `TELEPHONE`, `NUM_CC`, `ADRESSE_GEO`, `ACOMPTE`, `PASS`, `FIRST_CONNECTION`, `DERNIERE_ACTION`, `LAST_PAGE`, `DATE_CREATION`, `CREATEUR`, `DATE_MODIF`, `MODIFICATEUR`) VALUES
(1, 1, 0, 'COMPTABILITE', 'compta', '', '', '', '', 0, '12345', 1, 0, '', '2021-08-17 09:59:03', 0, NULL, 0),
(2, 2, 0, 'EXAT AGRICULTURE', 'exat', '09 BP 1233 ABIDJAN', '8098090890', '0808080R', '', 0, 'mapless', 1, 0, '', '2021-08-17 09:59:03', 0, '2021-10-07 09:03:17', 1),
(3, 2, 0, 'ADF-AGRO', 'adf', '', '', '', '', 0, '12345', 2, 0, '', '2021-08-17 09:59:03', 0, '2021-10-04 16:34:05', 1),
(4, 2, 0, 'AIRONE CI', 'airone', '', '', '', '', 0, '12345', 2, 1625004730, 'vgm', '2021-08-17 09:59:03', 0, '2021-10-04 16:34:43', 1),
(5, 2, 0, 'APM T CI', 'apmtci', '', '', 'FV', '', 0, '12345', 2, 0, '', '2021-08-17 09:59:03', 0, '2021-08-17 13:27:40', 1),
(6, 2, 0, 'ASAF RUBBER INDUSTRY', 'asaf', '', '', '', '', 0, '12345', 2, 0, 'pont', '2021-08-17 09:59:03', 0, NULL, 0),
(7, 2, 0, 'AWAHUS SERVICE', 'awahus', '', '', '', '', 0, '12345', 2, 0, 'pont', '2021-08-17 09:59:03', 0, NULL, 0),
(8, 2, 0, 'BACIBAM', 'bacibam', '', '', '', '', 0, '12345', 2, 0, 'vgm', '2021-08-17 09:59:03', 0, NULL, 0),
(9, 2, 0, 'BANACI', 'banaci', '', '', '', '', 0, '12345', 2, 0, '', '2021-08-17 09:59:03', 0, NULL, 0),
(10, 2, 0, 'BOLLORE AFRICA LOGISTICS', 'bollore', '09 BP 23 ABIDJAN', '2134568754', '3242242V', '', 0, '12345', 1, 0, '', '2021-08-17 09:59:03', 0, '2021-10-04 16:05:12', 1),
(11, 2, 0, 'CARTE D''OR COTE D''IVOIRE', 'cartedor', '', '', '', '', 0, '12345', 2, 0, 'charg', '2021-08-17 09:59:03', 0, NULL, 0),
(12, 2, 0, 'CCI-CI', 'ccici', '', '', '', '', 0, '12345', 2, 0, '', '2021-08-17 09:59:03', 0, NULL, 0),
(13, 2, 0, 'CCP', 'ccp', '', '', '', '', 0, '12345', 2, 1601463677, 'charg', '2021-08-17 09:59:03', 0, '2021-10-04 16:32:55', 1),
(14, 2, 0, 'CELEF IMPORT-EXPORT', 'celef', '', '', '', '', 0, '12345', 2, 0, '', '2021-08-17 09:59:03', 0, NULL, 0),
(15, 2, 0, 'COCOPACK', 'cocopack', '', '', '', '', 0, '12345', 2, 0, '', '2021-08-17 09:59:03', 0, NULL, 0),
(16, 2, 0, 'COIC SA', 'coic', '', '', '', '', 0, '12345', 2, 0, '', '2021-08-17 09:59:03', 0, NULL, 0),
(17, 2, 0, 'COMPAGNIE CACAOYERE DU BANDAMA', 'ccb', '', '', '', '', 0, '12345', 2, 0, '', '2021-08-17 09:59:03', 0, NULL, 0),
(18, 2, 0, 'COTIERE TRANSIT ET MANUTENTION', 'ctm', '', '', '', '', 0, '12345', 2, 0, '', '2021-08-17 09:59:03', 0, NULL, 0),
(19, 2, 0, 'EOLIS', 'eolis', '', '', '', '', 0, '12345', 2, 0, '', '2021-08-17 09:59:03', 0, NULL, 0),
(20, 2, 0, 'FARLIN', 'farlin', '', '', '', '', 0, '12345', 2, 0, '', '2021-08-17 09:59:03', 0, NULL, 0),
(21, 2, 0, 'FORAGRI', 'foragri', '', '', '', '', 0, '12345', 2, 0, '', '2021-08-17 09:59:03', 0, NULL, 0),
(22, 2, 0, 'FRUITPACK', 'fruitpack', '', '', '', '', 0, '12345', 2, 0, '', '2021-08-17 09:59:03', 0, NULL, 0),
(23, 2, 0, 'GMCI', 'gmci', '', '', '', '', 0, '12345', 2, 0, '', '2021-08-17 09:59:03', 0, '2021-08-17 20:46:26', 1),
(24, 2, 0, 'GROUPE SCAB', 'scab', '', '', '', '', 0, '12345', 2, 0, '', '2021-08-17 09:59:03', 0, NULL, 0),
(25, 2, 0, 'ICP', 'icp', '', '', '', '', 0, '12345', 2, 0, '', '2021-08-17 09:59:03', 0, NULL, 0),
(26, 2, 0, 'IVOIRE AGREAGE', 'ivoireagreage', '', '', '', '', 0, '12345', 2, 0, '', '2021-08-17 09:59:03', 0, NULL, 0),
(27, 2, 0, 'KOFFIBAM', 'koffibam', '', '', '', '', 0, '12345', 2, 0, '', '2021-08-17 09:59:03', 0, NULL, 0),
(28, 2, 0, 'MANTRA IVOIRE', 'mantra', '', '', '', '', 0, '12345', 2, 0, '', '2021-08-17 09:59:03', 0, NULL, 0),
(29, 2, 0, 'MOVIS', 'movis', '', '', '', '', 0, '12345', 2, 0, '', '2021-08-17 09:59:03', 0, NULL, 0),
(31, 2, 0, 'NESTLE', 'nestle', '', '', '', '', 0, '12345', 2, 0, '', '2021-08-17 09:59:03', 0, NULL, 0),
(32, 2, 0, 'NSDA', 'nsda', '', '', '', '', 0, '12345', 2, 0, '', '2021-08-17 09:59:03', 0, NULL, 0),
(33, 2, 0, 'AK INTER', 'ak', '', '', '', '', 0, '12345', 0, 0, NULL, '2021-08-17 11:44:45', 1, '2021-09-24 10:48:49', 1),
(34, 2, 0, 'ITCA', 'itca', '', '2342443434', '3234423M', '', 0, '12345', 0, 0, NULL, '2021-10-07 09:45:00', 1, '2021-10-07 11:39:18', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
