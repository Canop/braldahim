<?php

/**
 * Ecriture de Log.
 * Les logs sont paramétrés dans le fichier de configuration.
 */
class Bral_Util_Log {
	private static $instance = null;
	private static $tech = null;
	private static $erreur = null;
	private static $inscription = null;
	private static $authentification = null;
	private static $config = null;

	public static function tech() {
		if (self::$tech == null) {
			self::initLogTech();
		}
		return self::$tech;
	}

	public static function erreur() {
		if (self::$erreur == null) {
			self::initLogErreur();
		}
		return self::$erreur;
	}

	public static function inscription() {
		if (self::$inscription == null) {
			self::initLogInscription();
		}
		return self::$inscription;
	}
	
	public static function authentification() {
		if (self::$authentification == null) {
			self::initLogAuthentification();
		}
		return self::$authentification;
	}

	//______________
	private function __construct() {
	}

	private static function getInstance() {
		if (self::$instance == null) {
			Zend_Loader::loadClass('Zend_Log');
			Zend_Loader::loadClass('Zend_Log_Writer_Stream');
			self::$instance = new self();
			self::$config = Zend_Registry::get('config');
			return self::$instance;
		}
	}

	private static function initLogTech() {
		if (self::$instance == null) {
			$instance = self::getInstance();
		}
		self::$config = Zend_Registry::get('config');
		self::$tech = new Zend_Log();
		$redacteur = new Zend_Log_Writer_Stream(self::$config->log->fichier->tech);
		self::$tech->addWriter($redacteur);
		$filtre = new Zend_Log_Filter_Priority((int)self::$config->log->niveau->tech);
		self::$tech->addFilter($filtre);
		self::$tech->addPriority('TRACE', 8);
		
		if (self::$config->log->general->debug_browser == "oui") {
			$redacteur = new Zend_Log_Writer_Stream('php://output');
			self::$tech->addWriter($redacteur);
		}
	}

	private static function initLogErreur() {
		if (self::$instance == null) {
			$instance = self::getInstance();
		}
		self::$config = Zend_Registry::get('config');
		self::$erreur = new Zend_Log();
		$redacteur = new Zend_Log_Writer_Stream(self::$config->log->fichier->erreur);
		self::$erreur->addWriter($redacteur);
		$filtre = new Zend_Log_Filter_Priority((int)self::$config->log->niveau->erreur);
		self::$erreur->addFilter($filtre);
		self::$erreur->addPriority('TRACE', 8);

		if (self::$config->log->general == "oui") {
			$redacteur = new Zend_Log_Writer_Stream('php://output');
			self::$erreur->addWriter($redacteur);
		}
	}
	
	private static function initLogInscription() {
		if (self::$instance == null) {
			$instance = self::getInstance();
		}
		self::$config = Zend_Registry::get('config');
		self::$inscription = new Zend_Log();
		$redacteur = new Zend_Log_Writer_Stream(self::$config->log->fichier->inscription);
		self::$inscription->addWriter($redacteur);
		$filtre = new Zend_Log_Filter_Priority((int)self::$config->log->niveau->inscription);
		self::$inscription->addFilter($filtre);
		self::$inscription->addPriority('TRACE', 8);
		
		if (self::$config->log->general->debug_browser == "oui") {
			$redacteur = new Zend_Log_Writer_Stream('php://output');
			self::$inscription->addWriter($redacteur);
		}
	}
	
	private static function initLogAuthentification() {
		if (self::$instance == null) {
			$instance = self::getInstance();
		}
		self::$config = Zend_Registry::get('config');
		self::$authentification = new Zend_Log();
		$redacteur = new Zend_Log_Writer_Stream(self::$config->log->fichier->authentification);
		self::$authentification->addWriter($redacteur);
		$filtre = new Zend_Log_Filter_Priority((int)self::$config->log->niveau->authentification);
		self::$authentification->addFilter($filtre);
		self::$authentification->addPriority('TRACE', 8);
		
		if (self::$config->log->general->debug_browser == "oui") {
			$redacteur = new Zend_Log_Writer_Stream('php://output');
			self::$authentification->addWriter($redacteur);
		}
	}
}
