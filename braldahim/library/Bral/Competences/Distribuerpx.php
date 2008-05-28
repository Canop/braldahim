<?php

class Bral_Competences_Distribuerpx extends Bral_Competences_Competence {

	function prepareCommun() {
		Zend_Loader::loadClass('Bral_Util_Commun');

		// r�cup�ration des hobbits qui sont pr�sents dans la vue
		$hobbitTable = new Hobbit();
		// s'il y a trop de hobbits, on prend que les plus proches
		$this->view->estMaxHobbits = false;

		$vue = Bral_Util_Commun::getVueBase($this->view->user->x_hobbit, $this->view->user->y_hobbit) + $this->view->user->vue_bm_hobbit;
		$hobbits = $hobbitTable->findLesPlusProches($this->view->user->x_hobbit, $this->view->user->y_hobbit, $vue, $this->view->config->game->competence->distribuerpx->nb_max_hobbit);

		foreach($hobbits as $h) {
			if ($h["id_hobbit"] == $this->view->user->id_hobbit) {
				$nom = " Vous-M�me : ".$h["prenom_hobbit"]. " ". $h["nom_hobbit"];
			}
			$tabHobbits[] = array("id_hobbit" => $h["id_hobbit"], "nom_hobbit" => $h["nom_hobbit"], "prenom_hobbit" => $h["prenom_hobbit"]);
		}

		if (count($tabHobbits) >= $this->view->config->game->competence->distribuerpx->nb_max_hobbit) {
			$this->view->estMaxHobbits = true;
		}

		$this->view->tabHobbits = $tabHobbits;
		$this->view->n_hobbits = count($tabHobbits);
	}

	function prepareFormulaire() {
		// rien a faire ici
	}

	function prepareResultat() {
		$tabDistribution = null;
		$total_distribution = 0;
		for ($i=2 ;$i<=$this->view->n_hobbits*2; $i=$i+2) {
			$tab["px_recu"] = 0;
			$tab["id_hobbit"] = (int)$this->request->get("valeur_".($i-1));
			if ((int)$this->request->get("valeur_".$i).""!=$this->request->get("valeur_".$i)."") {
				throw new Zend_Exception(get_class($this)." Valeur invalide : i=$i val=".$this->request->get("valeur_".$i));
			} else {
				$tab["px_recu"] = (int)$this->request->get("valeur_".$i);
			}

			$trouve = false;
			foreach($this->view->tabHobbits  as $h) {
				if ($tab["id_hobbit"] == $h["id_hobbit"]) {
					$trouve = true;
				}
			}
			if ($trouve == false) {
				throw new Zend_Exception(get_class($this)." Hobbit invalide : o:".$this->view->user->id_hobbit." d:".$tab["id_hobbit"]);
			}
			if ($tab["px_recu"] > 0) {
				$tabDistribution[] = $tab;
			}

			$total_distribution = $total_distribution + $tab["px_recu"];
		}

		if ($total_distribution > $this->view->user->px_commun_hobbit) {
			throw new Zend_Exception(get_class($this)." Total trop eleve:".$total_distribution. " c=".$this->view->user->px_commun_hobbit);
		}

		// distribution
		$tabAffiche = null;
		$hobbitTable = new Hobbit();
		$this->setEstEvenementAuto(false);
		foreach ($tabDistribution as $t) {
			$hobbitRowset = $hobbitTable->find($t["id_hobbit"]);
			$hobbit = $hobbitRowset->current();
			$hobbit->px_perso_hobbit = $hobbit->px_perso_hobbit + $t["px_recu"];
			$data = array(
				'px_perso_hobbit' => $hobbit->px_perso_hobbit,
			);
			$where = "id_hobbit=".$t["id_hobbit"];
			$hobbitTable->update($data, $where);
			if ($t["id_hobbit"] == $this->view->user->id_hobbit) {
				$this->view->user->px_perso_hobbit = $hobbit->px_perso_hobbit;
			}
			$tab["id_hobbit"] = $t["id_hobbit"];
			if ($t["id_hobbit"] == $this->view->user->id_hobbit) {
				$tab["nom_hobbit"] = "Vous-M�me : ".$hobbit->prenom_hobbit. " " .$hobbit->nom_hobbit;
			} else {
				$tab["nom_hobbit"] = $hobbit->prenom_hobbit. " " .$hobbit->nom_hobbit;
			}
			
			$tab["nom_hobbit_details"] = $hobbit->prenom_hobbit. " " .$hobbit->nom_hobbit;
			
			$tab["px_recu"] = $t["px_recu"];
			$tabAffiche[] = $tab;

			$id_type = $this->view->config->game->evenements->type->don;
			$detailsD = $this->view->user->prenom_hobbit ." ". $this->view->user->nom_hobbit ." (".$this->view->user->id_hobbit.") a donn� des PX � ".$tab["nom_hobbit_details"]." (".$tab["id_hobbit"].")";
			$detailsR = $tab["nom_hobbit_details"]." (".$tab["id_hobbit"].") a re�u des PX la part de ".$this->view->user->prenom_hobbit ." ". $this->view->user->nom_hobbit ." (".$this->view->user->id_hobbit.")";
			
			$detailDonneur = "Vous avez donn� ".$tab["px_recu"]." PX � ".$tab["nom_hobbit"]." (".$tab["id_hobbit"].")";
			$detailReceveur = "Vous avez re�u ".$tab["px_recu"]." PX de la part de ".$hobbit->prenom_hobbit. " ". $hobbit->nom_hobbit." (".$this->view->user->id_hobbit.")";
			Bral_Util_Evenement::majEvenements($this->view->user->id_hobbit, $id_type, $detailsD, $detailDonneur);
			Bral_Util_Evenement::majEvenements($tab["id_hobbit"], $id_type, $detailsR, $detailReceveur);
		}

		$hobbitRowset = $hobbitTable->find($this->view->user->id_hobbit);
		$hobbit = $hobbitRowset->current();
		$this->view->user->px_commun_hobbit = $this->view->user->px_commun_hobbit - $total_distribution;
		$data = array(
			'px_commun_hobbit' => $this->view->user->px_commun_hobbit,
		);
		$where = "id_hobbit=".$this->view->user->id_hobbit;
		$hobbitTable->update($data, $where);

		$this->view->tabAffiche = $tabAffiche;
		$this->view->totalDistribution = $total_distribution;
	}

	function getListBoxRefresh() {
		return array("box_profil", "box_evenements");
	}

}