<?php

class Bral_Lieux_Ahennepeheux extends Bral_Lieux_Lieu {

	private $_achatPossible;
	private $_coutCastars;
	private $_tabNouveauMetiers;
	private $_tabMetiers;
	private $_possedeMetier;

	function prepareCommun() {
		Zend_Loader::loadClass("Hobbit");
		Zend_Loader::loadClass("Metier");
		Zend_Loader::loadClass("HobbitsMetiers");

		$hobbitsMetiersTable = new HobbitsMetiers();
		$hobbitsMetierRowset = $hobbitsMetiersTable->findMetiersByHobbitId($this->view->user->id_hobbit);
		$this->_tabMetiers = null;
		$this->_possedeMetier = false;
		$convertDate = new Bral_Util_ConvertDate();

		foreach($hobbitsMetierRowset as $m) {
			$this->_possedeMetier = true;

			$this->_tabMetiers[] = array("id_metier" => $m["id_metier"],
			"nom" => $m["nom_metier"],
			"nom_systeme" => $m["nom_systeme_metier"],
			"est_actif" => ($m["est_actif_hmetier"] == "oui"),
			"date_apprentissage" => $convertDate->get_date_mysql_datetime("d/m/Y", $m["date_apprentissage_hmetier"]),
			"description" => $m["description_metier"]);
		}

		$metiersTable = new Metier();
		$metiersRowset = $metiersTable->fetchall();
		$this->_coutCastars = $this->calculCoutCastars(count($hobbitsMetierRowset));

		$this->_tabNouveauMetiers = null;
		$this->_achatPossible = false;
		if ($this->_coutCastars <= $this->view->user->castars_hobbit) {
			$this->_achatPossible = true;
			foreach ($metiersRowset as $m) {
				$nouveau = true;
				if ($this->_possedeMetier == true) {
					foreach ($this->_tabMetiers as $t) {
						if ($m->id_metier == $t["id_metier"]) {
							$nouveau = false;
						}
					}
				}

				if ($nouveau === true) {
					$this->_tabNouveauMetiers[] = array("id_metier" => $m->id_metier,
					"nom" => $m->nom_metier,
					"nom_systeme" => $m->nom_systeme_metier,
					"description" => $m->description_metier);
				}
			}
		}
	}

	function prepareFormulaire() {
		$this->view->achatPossible = $this->_achatPossible;
		$this->view->coutCastars = $this->_coutCastars;
		$this->view->tabNouveauMetiers = $this->_tabNouveauMetiers;
		$this->view->tabMetiers = $this->_tabMetiers;
		$this->view->possedeMetier = $this->_possedeMetier;
	}

	function prepareResultat() {
		$apprentissageMetier = false;
		$changementMetier = false;

		$mode = $this->request->get("valeur_1"); // changer ou apprendre
		$idNouveauMetierCourant = intval($this->request->get("valeur_2"));
		$idNouveauMetier = intval($this->request->get("valeur_3"));

		switch($mode) {
			case "changer" :
				if ($idNouveauMetierCourant < 0) {
					throw new Zend_Exception(get_class($this)." Nouveau Metier courant inconnu : ".$idNouveauMetierCourant);
				}
				$changementMetier = true;
				break;
			case "apprendre" :
				if ($idNouveauMetier < 0) {
					throw new Zend_Exception(get_class($this)." Nouveau Metier inconnu : ".$idNouveauMetier);
				}
				$apprentissageMetier = true;
				break;
			default:
				throw new Zend_Exception(get_class($this)." Mode inconnu : ".$mode);
		}

		if ($changementMetier) {
			// verification que le metier est bien possede par le hobbit
			$changementOk = false;
			if ($this->_possedeMetier == true) {
				foreach ($this->_tabMetiers as $t) {
					if ($idNouveauMetierCourant == $t["id_metier"]) {
						$nomMetier = $t["nom"];
						$changementOk = true;
					}
				}
			}
			if (!$changementOk) {
				throw new Zend_Exception(get_class($this)." Metier non possede : ".$idNouveauMetierCourant);
			}
		} else { // apprentissage
			// verification que le hobbit peut acheter le metier
			if ($this->_achatPossible === false) {
				throw new Zend_Exception(get_class($this)." Achat impossible : castars:".$this->view->user->castars_hobbit." cout:".$this->_coutCastars);
			}
			// verification que le metier n'est pas encore possede par le hobbit
			$nouveau = false;
			if (count($this->_tabNouveauMetiers) > 0) {
				foreach ($this->_tabNouveauMetiers as $t) {
					if ($idNouveauMetier == $t["id_metier"]) {
						$nouveau = true;
						$nomMetier = $t["nom"];
						break;
					}
				}
			}
			if ($nouveau === false) {
				throw new Zend_Exception(get_class($this)." Nouveau metier invalide:".$idNouveauMetier);
			}
		}

		if ($changementMetier) {
			$hobbitsMetiersTable = new HobbitsMetiers();
			$data = array('est_actif_hmetier' => 'non');
			$where = array("id_hobbit_hmetier" => intval($this->view->user->id_hobbit));
			$hobbitsMetiersTable->update($data, $where);

			//$hobbitsMetiersTable->updateTousMetierVersNonActif($this->view->user->id_hobbit);
			//$hobbitsMetiersTable->updateMetierVersActif($this->view->user->id_hobbit, $idNouveauMetierCourant);
			$data = array('est_actif_hmetier' => 'oui');
			$where = array("id_hobbit_hmetier = ".intval($this->view->user->id_hobbit)." AND id_metier_hmetier = ".intval($idNouveauMetierCourant));
			$hobbitsMetiersTable->update($data, $where);

		} else { // apprentissage
			$hobbitsMetiersTable = new HobbitsMetiers();
			$data = array('est_actif_hmetier' => 'non');
			$where = array("id_hobbit_hmetier" => intval($this->view->user->id_hobbit));
			$hobbitsMetiersTable->update($data, $where);
			//$hobbitsMetiersTable->updateTousMetierVersNonActif($this->view->user->id_hobbit);

			$dataNouveauMetier = array(
			'id_hobbit_hmetier' => $this->view->user->id_hobbit,
			'id_metier_hmetier'  => $idNouveauMetier, // marcher
			'date_apprentissage_hmetier'  => date("Y-m-d"),
			'est_actif_hmetier'  => "oui",
			);

			$hobbitsMetiersTable->insert($dataNouveauMetier);

			$hobbitTable = new Hobbit();
			$this->view->user->castars_hobbit = $this->view->user->castars_hobbit - $this->_coutCastars;

			$data = array('castars_hobbit' => $this->view->user->castars_hobbit);
			$where = "id_hobbit=".$this->view->user->id_hobbit;
			$hobbitTable->update($data, $where);

		}

		$this->view->nomMetier = $nomMetier;
		$this->view->apprentissageMetier = $apprentissageMetier;
		$this->view->changementMetier = $changementMetier;
	}


	function getListBoxRefresh() {
		return array("box_metier", "box_laban", "box_competences_communes", "box_competences_basiques", "box_competences_metiers");
	}

	private function calculCoutCastars($nbMetiersAcquis) {
		/*1er métier : 20 castars
		 2nd métier : 100 castars
		 3ème métier : 500 castars
		 4ème métier : 1000 castars
		 5ème métier : 2000 castars
		 6ème métier : 3000 castars
		 7ème métier : 4000 castars
		 8ème métier : 5000 castars
		 9ème métier : 6000 castars
		 10ème métier : 7000 castars*/
		$v = 0;

		if ($nbMetiersAcquis == 0) {
			$v = 20;
		} else if ($nbMetiersAcquis == 1) {
			$v = 100;
		} else if ($nbMetiersAcquis == 2) {
			$v = 500;
		} else if ($nbMetiersAcquis >= 3) {
			$v = ($nbMetiersAcquis - 2) * 1000;
		}

		return $v;
	}
}