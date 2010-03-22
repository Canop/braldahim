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
abstract class Bral_Monstres_Competences_Reperage extends Bral_Monstres_Competences_Competence {
	
	/*
	 * Après 3 attaques ratées (2 DLA différentes pour les monstres attaquant plusieurs fois par DLA) :
	 * Si nivH > nivM+5 :
	 * On calcule nivH-nivM=DiffNiv. On lance un D10.
	 * - Si le résultat est < à DiffNiv alors le monstre lache la cible et ne pourra pas la recibler pendant 1D3+1 DLA (effet de zone fonctionne toujours bien sûr car il ne cible pas directement).
	 * - Si le résultat est inférieur, le monstre jour sa DLA normalement et refera le test à la DLA suivante.
	 */
	protected function peutAttaquer($cible) {
		Bral_Util_Log::viemonstres()->trace(get_class($this)." - peutAttaquer - enter - (idm:".$this->monstre["id_monstre"].") cible:".$cible["id_hobbit"]);
		
		$retour = true;
		
		// Recuperation du nombre d'attaque esquive par le hobbit dans les 3 dernières DLA.
		$evenementTable = new Evenement();
		$nbAttaqueEsquivee  = $evenementTable->countByIdMonstreIdHobbitLast3tours($this->monstre["nb_dla_jouees_monstre"], $this->monstre["id_monstre"], $cible["id_hobbit"], Bral_Util_Evenement::ATTAQUE_ESQUIVEE);
		
		if ($nbAttaqueEsquivee >= 3 && $cible["niveau_hobbit"] > $cible["niveau_monstre"] + 5) {
			Bral_Util_Log::viemonstres()->trace(get_class($this)." - (idm:".$this->monstre["id_monstre"].") ".$cible["niveau_hobbit"]." > ".$cible["niveau_monstre"]."+5");
			$diffNiv = $cible["niveau_hobbit"] - $cible["niveau_monstre"];
			$de = Bral_Util_De::get_1D10();
			if ($de < $diffNiv) {
				$retour = false;
				Bral_Util_Log::viemonstres()->trace(get_class($this)." - peutAttaquer - (idm:".$this->monstre["id_monstre"].") ne peut pas attaquer ".$cible["id_hobbit"]);
			} else {
				$retour = true;
			}
		}

		if ($retour) {
			Bral_Util_Log::viemonstres()->trace(get_class($this)." - peutAttaquer - (idm:".$this->monstre["id_monstre"].") peut attaquer ".$cible["id_hobbit"]);
		}
		
		Bral_Util_Log::viemonstres()->trace(get_class($this)." - peutAttaquer - exit - (idm:".$this->monstre["id_monstre"].")");
		return $retour;
	}
}