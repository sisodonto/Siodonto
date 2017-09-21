<?php
/*
	Classe gerada pelo Build_Core 
	@author Maickon Rangel - maickon4developers@gmail.com
	Prodigio Framework - 2017
	Model: produtosmedicamentos
*/

class Produtosmedicamentos_Model extends Dbrecord_Core {
	private $permit;

	public function __construct(){
		parent::__construct();
		$this->permit = ['id','nome','cor_tarja','forma','preco','descricao','created_at'];
	}

	public function get_permit(){
		return $this->permit;
	}
}