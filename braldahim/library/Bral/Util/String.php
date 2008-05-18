<?php


class Bral_Util_String {

	private function __construct() {
	}
	
	public static function firstToUpper($m) {
		return strtoupper($m{0}) . substr($m, 1);
	}
	
	/*
	 * Retourne un caract�re en majuscule, y compris la majuscule 
	 * des caract�res accentu�s.
	 */
	public static function toUpper($c) {
		$c = strtoupper($c);
		$tab = array(
			'�' => '�',
			'�' => '�',
			'�' => '�',
			'�' => '�',
			'�' => '�',
			'�' => '�',  
			'�' => '�',
			'�' => '�',
			'�' => '�',
			'�' => '�',
			'�' => '�',
			'�' => '�',
			'�' => '�', 
			'�' => '�',
			'�' => '�', 
			'�' => '�', 
			'�' => '�', 
			'�' => '�',
		);
		
		if (array_key_exists($c, $tab)) {
			return $tab[$c];
		} else {
			return $c;
		}
	}
}