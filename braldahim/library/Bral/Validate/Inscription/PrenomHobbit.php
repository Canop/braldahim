<?php
require_once 'Zend/Validate/Interface.php';

class Bral_Validate_Inscription_PrenomHobbit implements Zend_Validate_Interface {
    protected $_messages = array();

    public function isValid($valeur) {
        $this->_messages = array();
		$valid = true;
		
		if (strlen($valeur) < 5) {
			$this->_messages[] = "Le pr�nom du hobbit doit contenir plus de 5 caract�res";
			$valid = false;
		}
		
    	if (strlen($valeur) > 20) {
			$this->_messages[] = "Le pr�nom du hobbit doit contenir au maximum 20 caract�res";
			$valid = false;
    	}
		
		$tab = array(
			'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p',  'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
			'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P',  'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
			'\'', '.', ',', 
			'�', '�', '�', '�', '�', '�',
			'�', '�', '�', '�', '�', '�',
			'�', '�', '�', '�', '�', '�',
			'�', '�', '�', '�', '�', '�',
			'�', '�', '�', '�', '�', '�',
			'�',
			'�', '�', '�', '�', '�', '-',
			'�', '�', '�', '�',
			' ', 
			);
    	
		$flag = true;
		$val = null;
		for ($i = 0; $i< strlen($valeur); $i++) {
			if (!in_array($valeur[$i], $tab)) {
				$this->_messages[] = "Le nom du hobbit contient un ou plusieurs caract�res invalides";
				foreach ($tab as $t) {
					$val .= $t. " ";
				}	
				$this->_messages[] = "Seuls les caract�res suivants sont autoris�s : ";
				$this->_messages[] = $val ." (espace)";
				$valid = false;
				break;
			}
		}
		
        if (strlen($valeur) > 10) {
			$this->_messages[] = "Le pr�nom du hobbit doit contenir au maximum 10 caract�res";
			$valid = false;
    	}
    	
    	Zend_Loader::loadClass('Bral_Util_Nom');
    	$nom = new Bral_Util_Nom();
    	
    	if ($nom->estValidPrenom($valeur) == false) {
			$this->_messages[] = "Ce pr�nom est d�j� trop utilis�...";
			$valid = false;
    	}
    	
		return $valid;
    }

    public function getMessages(){
        return $this->_messages;
    }
    
    public function getErrors() {
    	return $this->_messages;
    }
}