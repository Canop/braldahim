<?php

class CompetencesController extends Zend_Controller_Action {

	function init() {
		if (!Zend_Auth::getInstance()->hasIdentity()) {
			$this->_redirect('/'); 
		}
		$this->initView();
		$this->view->baseUrl = $this->_request->getBaseUrl();
		$this->view->user = Zend_Auth::getInstance()->getIdentity();
		$this->view->config = Zend_Registry::get('config');
		$this->xml_response = new Bral_Xml_Response();
		
		$this->modification_tour = false;
		$t = Bral_Box_Factory::getTour($this->_request, $this->view, false);
		if ($t->activer()) {
			$xml_entry = new Bral_Xml_Entry();
			$xml_entry->set_type("display");
			$xml_entry->set_valeur("informations");
			$xml_entry->set_data($t->render());
			$this->xml_response->add_entry($xml_entry);
			$this->modification_tour = true;
		}
	}
	
	function DoActionAction() {
		
		if (!$this->modification_tour) { // S'il n'y a pas eu de modification du tour, on passe à la competence
			$xml_entry = new Bral_Xml_Entry();
			$xml_entry->set_type("display");
			
			try {
				$competence = Bral_Competences_Factory::getAction($this->_request, $this->view);
				$xml_entry->set_valeur($competence->getNomInterne());
				$xml_entry->set_data($competence->render());
				$this->xml_response->add_entry($xml_entry);
				$boxToRefresh = $competence->getListBoxRefresh();
				for ($i=0; $i<count($boxToRefresh); $i++) {
					$xml_entry = new Bral_Xml_Entry();
					$xml_entry->set_type("display");
					$c = Bral_Box_Factory::getBox($boxToRefresh[$i], $this->_request, $this->view, true);
					$xml_entry->set_valeur($c->getNomInterne());
					$xml_entry->set_data($c->render());
					$this->xml_response->add_entry($xml_entry);
				}
			} catch (Zend_Exception $e) {
				$b = Bral_Box_Factory::getErreur($this->_request, $this->view, false, $e->getMessage());
				$xml_entry->set_valeur($b->getNomInterne());
				$xml_entry->set_data($b->render());
				$this->xml_response->add_entry($xml_entry);
			}
		}
		$this->xml_response->render();
	}
	
	private function refreshAll() {
		$boxToRefresh = array("box_profil", "box_vue", "box_competences_communes", "box_competences_basiques", "box_competences_metiers");
		for ($i=0; $i<count($boxToRefresh); $i++) {
			$xml_entry = new Bral_Xml_Entry();
			$xml_entry->set_type("display");
			$c = Bral_Box_Factory::getBox($boxToRefresh[$i], $this->_request, $this->view, true);
			$xml_entry->set_valeur($c->getNomInterne());
			$xml_entry->set_data($c->render());
			$this->xml_response->add_entry($xml_entry);
		}
	}
}