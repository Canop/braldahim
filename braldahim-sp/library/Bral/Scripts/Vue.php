<?php

/**
 * This file is part of Braldahim, under Gnu Public Licence v3.
 * See licence.txt or http://www.gnu.org/licenses/gpl-3.0.html
 *
 * $Id: $
 * $Author: $
 * $LastChangedDate: $
 * $LastChangedRevision: $
 * $LastChangedBy: $
 */
class Bral_Scripts_Vue extends Bral_Scripts_Script {

	public function getType() {
		return self::TYPE_DYNAMIQUE;
	}
	
	public function calculScriptImpl() {
		Bral_Util_Log::scripts()->trace("Bral_Scripts_Vue - calculScriptImpl - enter -");

		$retour = null;
		$retour .= $this->calculVue();

		Bral_Util_Log::scripts()->trace("Bral_Scripts_Vue - calculScriptImpl - exit -");
		return $retour;
	}

	private function calculVue() {
		Bral_Util_Log::scripts()->trace("Bral_Scripts_Vue - calculChamp - enter -");
		$retour = "";
		
		$retour = "TEST";

		Bral_Util_Log::scripts()->trace("Bral_Scripts_Vue - calculChamp - exit -");
		return $retour;
	}
}