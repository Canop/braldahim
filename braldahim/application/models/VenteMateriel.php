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
class VenteMateriel extends Zend_Db_Table {
	protected $_name = 'vente_materiel';
	protected $_primary = array('id_vente_materiel');

	function findByIdVente($idVente) {
		$db = $this->getAdapter();
		$select = $db->select();
		$select->from('vente_materiel', '*')
		->from('type_materiel')
		->where('id_fk_type_vente_materiel = id_type_materiel')
		->where('id_fk_vente_materiel = ?', intval($idVente));
		$sql = $select->__toString();
		return $db->fetchAll($sql);
	}
}