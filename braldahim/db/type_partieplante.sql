-- phpMyAdmin SQL Dump
-- version 2.10.2
-- http://www.phpmyadmin.net
-- 
-- Serveur: localhost
-- G�n�r� le : Sam 22 D�cembre 2007 � 20:22
-- Version du serveur: 5.0.41
-- Version de PHP: 5.2.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Base de donn�es: `braldahim`
-- 

-- --------------------------------------------------------

-- 
-- Structure de la table `type_partieplante`
-- 

CREATE TABLE `type_partieplante` (
  `id_type_partieplante` int(11) NOT NULL auto_increment,
  `nom_type_partieplante` varchar(20) NOT NULL,
  `nom_systeme_type_partieplante` varchar(10) NOT NULL,
  `description_type_partieplante` varchar(200) NOT NULL,
  PRIMARY KEY  (`id_type_partieplante`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;
