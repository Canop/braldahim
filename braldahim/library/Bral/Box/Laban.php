<?php

class Bral_Box_Laban {

	function __construct($request, $view, $interne) {
		Zend_Loader::loadClass('LabanPartieplante');
		Zend_Loader::loadClass('LabanMinerai');
		$this->_request = $request;
		$this->view = $view;
		$this->view->affichageInterne = $interne;
	}

	function getTitreOnglet() {
		return "Laban";
	}

	function getNomInterne() {
		return "box_laban";
	}

	function setDisplay($display) {
		$this->view->display = $display;
	}

	function render() {
		$tabPartiePlantes = null;
		$labanPartiePlanteTable = new LabanPartieplante();
		$partiePlantes = $labanPartiePlanteTable->findByIdHobbit($this->view->user->id_hobbit);

		foreach ($partiePlantes as $p) {
			$tabPartiePlantes[] = array(
			"nom_type" => $p["nom_type_partieplante"],
			"quantite" => $p["quantite_laban_partieplante"],
			);
		}

		$tabMinerais = null;
		$labanMineraiTable = new LabanMinerai();
		$minerais = $labanMineraiTable->findByIdHobbit($this->view->user->id_hobbit);

		foreach ($minerais as $m) {
			$tabMinerais[] = array(
			"type" => $m["nom_type_minerai"],
			"quantite" => $m["quantite_laban_minerai"],
			);
		}

		$this->view->nb_partieplantes = count($tabPartiePlantes);
		$this->view->partieplantes = $tabPartiePlantes;
		$this->view->nb_minerais = count($tabMinerais);
		$this->view->minerais = $tabMinerais;
		$this->view->nom_interne = $this->getNomInterne();
		return $this->view->render("interface/laban.phtml");
	}
}
?>