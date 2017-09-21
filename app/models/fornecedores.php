<?php
/*
	Classe gerada pelo Build_Core 
	@author Maickon Rangel - maickon4developers@gmail.com
	Prodigio Framework - 2017
	Model: fornecedores
*/

class Fornecedores_Model extends Dbrecord_Core {

	private $permit;

	public function __construct(){
		parent::__construct();
		$this->permit = ['id','nome','capital_social','ativo','fk_tipoempresas','fk_ramodenegocios',
		'fk_naturezajuridica','inscricao_estadual','linha_produto','agencia','conta_corrente','created_at'];
	}

	public function get_permit(){
		return $this->permit;
	}
}