-- phpMyAdmin SQL Dump
-- version 2.10.2
-- http://www.phpmyadmin.net
-- 
-- Serveur: localhost
-- G�n�r� le : Sam 22 D�cembre 2007 � 20:14
-- Version du serveur: 5.0.41
-- Version de PHP: 5.2.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Base de donn�es: `braldahim`
-- 

-- --------------------------------------------------------

-- 
-- Structure de la table `environnement`
-- 

CREATE TABLE `environnement` (
  `id_environnement` int(11) NOT NULL auto_increment,
  `nom_environnement` varchar(20) NOT NULL,
  `description_environnement` varchar(250) NOT NULL,
  `nom_systeme_environnement` varchar(20) NOT NULL,
  `image_environnement` varchar(100) NOT NULL,
  PRIMARY KEY  (`id_environnement`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;
