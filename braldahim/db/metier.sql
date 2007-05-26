-- phpMyAdmin SQL Dump
-- version 2.9.2
-- http://www.phpmyadmin.net
-- 
-- Serveur: localhost
-- G�n�r� le : Samedi 19 Mai 2007 � 10:42
-- Version du serveur: 5.0.33
-- Version de PHP: 5.2.0
-- 
-- Base de donn�es: `braldahim`
-- 

-- --------------------------------------------------------

-- 
-- Structure de la table `metier`
-- 

DROP TABLE IF EXISTS `metier`;
CREATE TABLE `metier` (
  `id_metier` int(11) NOT NULL auto_increment,
  `nom_metier` varchar(20) NOT NULL,
  `nom_systeme_metier` varchar(20) NOT NULL,
  `description_metier` varchar(200) NOT NULL,
  PRIMARY KEY  (`id_metier`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

-- 
-- Contenu de la table `metier`
-- 

INSERT INTO `metier` VALUES (1, 'Mineur', 'mineur', 'Description du m�tier mineur');
INSERT INTO `metier` VALUES (2, 'Chasseur', 'chasseur', 'Description du m�tier chasseur');
INSERT INTO `metier` VALUES (3, 'B�cheron', 'bucheron', 'Description du m�tier B�cheron');
INSERT INTO `metier` VALUES (4, 'Herboriste', 'herboriste', 'Description du m�tier Herboriste');
INSERT INTO `metier` VALUES (5, 'Forgeron', 'forgeron', 'Description du m�tier Forgeron');
INSERT INTO `metier` VALUES (6, 'Apothicaire', 'apothicaire', 'Description du m�tier Apothicaire');
INSERT INTO `metier` VALUES (7, 'Menuisier', 'menuisier', 'Description du m�tier menuisier');
INSERT INTO `metier` VALUES (8, 'Cuisiner', 'cuisinier', 'Description du m�tier Cuisinier');
INSERT INTO `metier` VALUES (9, 'Tanneur', 'tanneur', 'Description du m�tier Tanneur');
INSERT INTO `metier` VALUES (10, 'Guerrier', 'guerrier', 'Description du m�tier Guerrier');
