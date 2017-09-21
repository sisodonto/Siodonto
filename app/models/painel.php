<?php
/*
	Classe gerada pelo Build_Core 
	@author Maickon Rangel - maickon4developers@gmail.com
	Prodigio Framework - 2017
	Model: painel
*/

class Painel_Model extends Dbrecord_Core {

	function render($action, $layout = true){
		$this->action = $action;
		if ($layout == true && file_exists('app/views/painel/layout.phtml')) {
			return 'app/views/painel/layout.phtml';
		} else {
			return $this->content();
		}
	}

	function content(){
		$actual = get_class($this);
		$singleClassName = strtolower(str_replace("_Model", "", $actual));
		if (file_exists("app/views/{$singleClassName}/{$this->action}.phtml")) {
			return "app/views/{$singleClassName}/{$this->action}.phtml";
		}
	}

	public function is_admin(){
		$redirect = 'painel';
		if (isset($_SESSION['tipo']) and $_SESSION['tipo'] == 3) {
			$redirect = 'painel-dentista';
		} elseif (isset($_SESSION['tipo']) and $_SESSION['tipo'] == 4) {
			$redirect = 'painel-paciente';
		}
		return $redirect;
	}
}