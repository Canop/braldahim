-- phpMyAdmin SQL Dump
-- version 2.9.2
-- http://www.phpmyadmin.net
-- 
-- Serveur: localhost
-- G�n�r� le : Mercredi 27 Juin 2007 � 23:33
-- Version du serveur: 5.0.33
-- Version de PHP: 5.2.0
-- 
-- Base de donn�es: `braldahim`
-- 

-- --------------------------------------------------------

-- 
-- Structure de la table `monstre`
-- 

CREATE TABLE `monstre` (
  `id_monstre` int(11) NOT NULL,
  `id_fk_type_monstre` int(11) NOT NULL,
  `id_fk_taille_monstre` int(11) NOT NULL,
  `id_fk_groupe_monstre` int(11) NOT NULL,
  `x_monstre` int(11) NOT NULL,
  `y_monstre` int(11) NOT NULL,
  `id_cible_monstre` int(11) NOT NULL,
  `pv_restant_monstre` int(11) NOT NULL,
  `pv_max_monstre` int(11) NOT NULL,
  `vue_monstre` int(11) NOT NULL,
  `force_base_monstre` int(11) NOT NULL,
  `force_bm_monstre` int(11) NOT NULL,
  `agilite_base_monstre` int(11) NOT NULL,
  `agilite_bm_monstre` int(11) NOT NULL,
  `sagesse_base_monstre` int(11) NOT NULL,
  `sagesse_bm_monstre` int(11) NOT NULL,
  `vigueur_base_monstre` int(11) NOT NULL,
  `vigueur_bm_monstre` int(11) NOT NULL,
  `regeneration_monstre` int(11) NOT NULL,
  `armure_naturelle_monstre` int(11) NOT NULL,
  `duree_base_tour_monstre` time NOT NULL,
  `nb_kill_monstre` int(11) NOT NULL,
  `date_creation_monstre` datetime NOT NULL,
  `est_mort_monstre` enum('oui','non') NOT NULL default 'non',
  PRIMARY KEY  (`id_monstre`),
  KEY `id_fk_groupe_monstre` (`id_fk_groupe_monstre`),
  KEY `idx_x_monstre_y_monstre` (`x_monstre`,`y_monstre`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
