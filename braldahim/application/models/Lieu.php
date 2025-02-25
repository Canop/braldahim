<?php

/**
 * This file is part of Braldahim, under Gnu Public Licence v3.
 * See licence.txt or http://www.gnu.org/licenses/gpl-3.0.html
 * Copyright: see http://www.braldahim.com/sources
 */
class Lieu extends Zend_Db_Table {
	protected $_name = 'lieu';
	protected $_primary = 'id_lieu';

	public function findById($id) {
		$where = $this->getAdapter()->quoteInto('id_lieu = ?', (int)$id);
		return $this->fetchRow($where);
	}

	function countAll() {
		$db = $this->getAdapter();
		$select = $db->select();
		$select->from('lieu', 'count(*) as nombre');
		$sql = $select->__toString();
		$resultat = $db->fetchAll($sql);
		$nombre = $resultat[0]["nombre"];
		return $nombre;
	}

	public function findByType($type, $estSoule = null, $estReliee = null) {
		$db = $this->getAdapter();
		$select = $db->select();
		$select->from('lieu', '*')
				->from('type_lieu', '*')
				->where('lieu.id_fk_type_lieu = ?', $type)
				->where('lieu.id_fk_type_lieu = type_lieu.id_type_lieu')
				->joinLeft('ville', 'id_fk_ville_lieu = id_ville');

		if ($estSoule != null) {
			$select->where('lieu.est_soule_lieu = ?', $estSoule);
		}

		if ($estReliee != null) {
			$select->where("ville.est_reliee_ville like ? ", $estReliee);
		}
		$sql = $select->__toString();

		return $db->fetchAll($sql);
	}


	public function findByCritere($estDonjon = null, $estSoule = null, $estReliee = null, $estMythique, $estRuine) {
		Zend_Loader::loadClass("TypeLieu");

		$db = $this->getAdapter();
		$select = $db->select();
		$select->from('lieu', '*')
				->from('type_lieu', '*')
				->where('lieu.id_fk_type_lieu = type_lieu.id_type_lieu')
				->joinLeft('ville', 'id_fk_ville_lieu = id_ville');

		if ($estDonjon != null) {
			$select->where('lieu.est_donjon_lieu = ?', $estDonjon);
		}

		if ($estSoule != null) {
			$select->where('lieu.est_soule_lieu = ?', $estSoule);
		}

		if ($estReliee != null) {
			$select->where("ville.est_reliee_ville like ? ", $estReliee);
		}

		if ($estMythique == "non") {
			$select->where("id_fk_type_lieu not like ? ", TypeLieu::ID_TYPE_LIEUMYTHIQUE);
		}

		if ($estRuine == "non") {
			$select->where("id_fk_type_lieu not like ? ", TypeLieu::ID_TYPE_RUINE);
		}

		$sql = $select->__toString();

		return $db->fetchAll($sql);
	}

	public function findByTypeAndRegion($type, $region, $estSoule = null, $estCapitale = null) {
		$db = $this->getAdapter();
		$select = $db->select();
		$select->from('lieu', '*')
				->from('type_lieu', '*')
				->from('region', '*')
				->where('region.id_region = ?', $region)
				->where('lieu.id_fk_type_lieu = ?', $type)
				->where('lieu.id_fk_type_lieu = type_lieu.id_type_lieu')
				->where('lieu.x_lieu >= region.x_min_region')
				->where('lieu.x_lieu <= region.x_max_region')
				->where('lieu.y_lieu >= region.y_min_region')
				->where('lieu.y_lieu <= region.y_max_region')
				->joinLeft('ville', 'id_fk_ville_lieu = id_ville');

		if ($estSoule != null) {
			$select->where('lieu.est_soule_lieu = ?', $estSoule);
		}

		if ($estCapitale != null) {
			$select->where('ville.est_capitale_ville = ?', $estCapitale);
		}

		$sql = $select->__toString();

		return $db->fetchAll($sql);
	}

	function selectVue($x_min, $y_min, $x_max, $y_max, $z, $id_type = null) {
		$db = $this->getAdapter();
		$select = $db->select();
		$select->from('lieu', '*')
				->from('type_lieu', '*')
				->where('x_lieu <= ?', $x_max)
				->where('x_lieu >= ?', $x_min)
				->where('y_lieu >= ?', $y_min)
				->where('y_lieu <= ?', $y_max)
				->where('z_lieu = ?', $z)
				->where('lieu.id_fk_type_lieu = type_lieu.id_type_lieu');

		if ($id_type != null) {
			$select->where('id_fk_type_lieu = ?', $id_type);
		}

		$sql = $select->__toString();

		return $db->fetchAll($sql);
	}

	function countVue($x_min, $y_min, $x_max, $y_max, $z, $id_type) {
		$db = $this->getAdapter();
		$select = $db->select();
		$select->from('lieu', 'count(*) as nombre')
				->where('x_lieu <= ?', $x_max)
				->where('x_lieu >= ?', $x_min)
				->where('y_lieu >= ?', $y_min)
				->where('y_lieu <= ?', $y_max)
				->where('z_lieu = ?', $z);

		if ($id_type != null) {
			$select->where('id_fk_type_lieu = ?', $id_type);
		}

		$sql = $select->__toString();
		$resultat = $db->fetchAll($sql);

		$nombre = $resultat[0]["nombre"];
		return $nombre;
	}

	function findNomById($id) {
		$db = $this->getAdapter();
		$select = $db->select();
		$select->from('lieu', '*')
				->from('type_lieu', '*')
				->where('id_lieu = ?', $id)
				->where('lieu.id_fk_type_lieu = type_lieu.id_type_lieu');
		$sql = $select->__toString();

		$lieu = $db->fetchRow($sql);
		if ($lieu == null) {
			$retour = "lieu inconnu";
		} else {
			$retour = $lieu["nom_lieu"] . " (" . $lieu["id_lieu"] . ")";
		}
		return $retour;
	}

	function findByCase($x, $y, $z) {
		$db = $this->getAdapter();
		$select = $db->select();
		$select->from('lieu', '*')
				->from('type_lieu', '*')
				->where('x_lieu = ?', $x)
				->where('y_lieu = ?', $y)
				->where('z_lieu = ?', $z)
				->where('lieu.id_fk_type_lieu = type_lieu.id_type_lieu')
				->joinLeft('ville', 'id_fk_ville_lieu = id_ville');
		$sql = $select->__toString();

		return $db->fetchAll($sql);
	}

	function countByCase($x, $y, $z) {
		$db = $this->getAdapter();
		$select = $db->select();
		$select->from('lieu', 'count(*) as nombre')
				->where('x_lieu = ?', $x)
				->where('y_lieu = ?', $y)
				->where('z_lieu = ?', $z);
		$sql = $select->__toString();
		$resultat = $db->fetchAll($sql);
		$nombre = $resultat[0]["nombre"];
		return $nombre;
	}

	function findByTypeAndCase($type, $x, $y, $z) {
		$db = $this->getAdapter();
		$select = $db->select();
		$select->from('lieu', '*')
				->from('type_lieu', '*')
				->where('x_lieu = ?', $x)
				->where('y_lieu = ?', $y)
				->where('z_lieu = ?', $z)
				->where('lieu.id_fk_type_lieu = ?', $type)
				->where('lieu.id_fk_type_lieu = type_lieu.id_type_lieu')
				->joinLeft('ville', 'id_fk_ville_lieu = id_ville');

		$sql = $select->__toString();
		return $db->fetchAll($sql);
	}

	function findByIdCommunaute($idCommunaute, $x = null, $y = null, $z = null, $pourEntretien = false, $idTypeLieu = null, $niveauMin = null, $estDependance = false) {
		if ($idCommunaute == null) {
			return $idCommunaute;
		}

		$db = $this->getAdapter();
		$select = $db->select();
		$select->from('lieu', '*')
				->from('type_lieu', '*')
				->where('lieu.id_fk_communaute_lieu = ?', $idCommunaute)
				->where('lieu.id_fk_type_lieu = type_lieu.id_type_lieu')
				->joinLeft('ville', 'id_fk_ville_lieu = id_ville');

		if ($estDependance == false) {
			$select->from('type_lieu_communaute', '*')
					->where('type_lieu.id_fk_type_lieu_communaute_type_lieu = type_lieu_communaute.id_type_lieu_communaute');
		}

		if ($x != null && $y != null && $z != null) {
			$select->where('x_lieu = ?', $x);
			$select->where('y_lieu = ?', $y);
			$select->where('z_lieu = ?', $z);
		}

		if ($idTypeLieu != null) {
			$select->where('type_lieu.id_type_lieu = ?', intval($idTypeLieu));
		}

		if ($niveauMin != null) {
			$select->where('niveau_lieu >= ?', intval($niveauMin));
		}

		if ($pourEntretien) {
			// 15 jours
			// Si le batiment est de niveau 0, construit il y a moins de 15j => pas d'entretien
			$select->where("date_entretien_lieu <= ?", Bral_Util_ConvertDate::get_date_add_day_to_date(date("Y-m-d H:i:s"), -15));
		}

		$sql = $select->__toString();
		return $db->fetchAll($sql);
	}

	function findDependanceByIdTypeAndIdCommunaute($idTypeLieu, $idCommunaute) {
		$db = $this->getAdapter();
		$select = $db->select();
		$select->from('lieu', '*')
				->from('type_lieu', '*')
				->from('type_dependance', '*')
				->where('type_dependance.id_fk_type_lieu_enfant_type_dependance = id_type_lieu')
				->where('lieu.id_fk_communaute_lieu = ?', $idCommunaute)
				->where('lieu.id_fk_type_lieu = type_lieu.id_type_lieu')
				->where('type_dependance.id_fk_type_lieu_type_dependance = ?', intval($idTypeLieu));

		$sql = $select->__toString();
		return $db->fetchAll($sql);
	}


	public function findByTypeAndPosition($type, $x, $y, $estSoule = null, $estReliee = null) {
		$db = $this->getAdapter();
		$select = $db->select();
		$select->from('lieu', '*, SQRT(((x_lieu - ' . $x . ') * (x_lieu - ' . $x . ')) + ((y_lieu - ' . $y . ') * ( y_lieu - ' . $y . '))) as distance')
				->from('type_lieu', '*')
				->where('lieu.id_fk_type_lieu = ?', $type)
				->where('lieu.id_fk_type_lieu = type_lieu.id_type_lieu')
				->joinLeft('ville', 'id_fk_ville_lieu = id_ville')
				->order(array('distance ASC'));

		if ($estSoule != null) {
			$select->where('lieu.est_soule_lieu = ?', $estSoule);
		}

		if ($estReliee != null) {
			$select->where("ville.est_reliee_ville like ? ", $estReliee);
		}

		$sql = $select->__toString();
		return $db->fetchAll($sql);
	}

	public function findByPositionMax($x, $y, $max) {
		$db = $this->getAdapter();
		$select = $db->select();
		$select->from('lieu', '*, SQRT(((x_lieu - ' . $x . ') * (x_lieu - ' . $x . ')) + ((y_lieu - ' . $y . ') * ( y_lieu - ' . $y . '))) as distance')
				->from('type_lieu', '*')
				->where('lieu.id_fk_type_lieu = type_lieu.id_type_lieu')
				->where('SQRT(((x_lieu - ' . $x . ') * (x_lieu - ' . $x . ')) + ((y_lieu - ' . $y . ') * ( y_lieu - ' . $y . '))) <= ?', $max)
				->joinLeft('ville', 'id_fk_ville_lieu = id_ville')
				->order(array('distance ASC'));
		$sql = $select->__toString();
		return $db->fetchAll($sql);
	}

	public function findAllLieuAvecVille() {
		$db = $this->getAdapter();
		$select = $db->select();
		$select->from('lieu', '*')
				->from('type_lieu', '*')
				->from('ville', '*')
				->from('region', '*')
				->where('lieu.id_fk_type_lieu = type_lieu.id_type_lieu')
				->where('lieu.id_fk_ville_lieu = id_ville')
				->where('ville.id_fk_region_ville = region.id_region');
		$sql = $select->__toString();
		return $db->fetchAll($sql);
	}

	public function findAllLieuQueteAvecRegion() {
		$db = $this->getAdapter();
		$select = $db->select();
		$select->from('lieu', '*')
				->from('type_lieu', '*')
				->from('ville', '*')
				->from('region', '*')
				->where('lieu.id_fk_type_lieu = type_lieu.id_type_lieu')
				->where('lieu.id_fk_ville_lieu = id_ville')
				->where('ville.id_fk_region_ville = region.id_region')
				->where('nom_systeme_type_lieu = ?', 'quete');
		$sql = $select->__toString();
		return $db->fetchAll($sql);
	}
}