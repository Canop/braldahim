-- phpMyAdmin SQL Dump
-- version 2.10.2
-- http://www.phpmyadmin.net
-- 
-- Serveur: localhost
-- G�n�r� le : Mer 05 Mars 2008 � 21:01
-- Version du serveur: 5.0.41
-- Version de PHP: 5.2.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Base de donn�es: `braldahim`
-- 

-- --------------------------------------------------------

-- 
-- Structure de la table `charrette`
-- 

CREATE TABLE `charrette` (
  `id_charrette` int(11) NOT NULL auto_increment,
  `id_fk_hobbit_charrette` int(11) default NULL,
  `quantite_rondin_charrette` int(11) NOT NULL,
  `x_charrette` int(11) default NULL,
  `y_charrette` int(11) default NULL,
  PRIMARY KEY  (`id_charrette`),
  UNIQUE KEY `id_fk_hobbit_charrette` (`id_fk_hobbit_charrette`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Contraintes pour les tables export�es
-- 

-- 
-- Contraintes pour la table `charrette`
-- 
ALTER TABLE `charrette`
  ADD CONSTRAINT `charrette_ibfk_1` FOREIGN KEY (`id_fk_hobbit_charrette`) REFERENCES `hobbit` (`id_hobbit`) ON DELETE CASCADE;
