-- phpMyAdmin SQL Dump
-- version 2.9.2
-- http://www.phpmyadmin.net
-- 
-- Serveur: localhost
-- G�n�r� le : Mardi 26 Juin 2007 � 22:10
-- Version du serveur: 5.0.33
-- Version de PHP: 5.2.0
-- 
-- Base de donn�es: `braldahim`
-- 

-- --------------------------------------------------------

-- 
-- Structure de la table `ref_monstre`
-- 

CREATE TABLE `ref_monstre` (
  `id_ref_monstre` int(11) NOT NULL auto_increment,
  `id_fk_type_ref_monstre` int(11) NOT NULL,
  `id_fk_taille_ref_monstre` int(11) NOT NULL,
  `niveau_min_ref_monstre` int(11) NOT NULL,
  `niveau_max_ref_monstre` int(11) NOT NULL,
  `pourcentage_vigueur_ref_monstre` int(11) NOT NULL,
  `pourcentage_agilite_ref_monstre` int(11) NOT NULL,
  `pourcentage_sagesse_ref_monstre` int(11) NOT NULL,
  `pourcentage_force_ref_monstre` int(11) NOT NULL,
  `vue_ref_monstre` int(11) NOT NULL,
  PRIMARY KEY  (`id_ref_monstre`),
  UNIQUE KEY `id_fk_type_taille_ref_monstre` (`id_fk_type_ref_monstre`,`id_fk_taille_ref_monstre`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
