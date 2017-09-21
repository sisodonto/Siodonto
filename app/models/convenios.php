<?php
/*
	Classe gerada pelo Build_Core 
	@author Maickon Rangel - maickon4developers@gmail.com
	Prodigio Framework - 2017
	Model: convenios
*/

class Convenios_Model extends Dbrecord_Core {

	private $permit;

	public function __construct(){
		parent::__construct();
		$this->permit = ['id','cnpj','razao_social','nome_fantasia','rua','bairro','numero',
		'cidade','cep','fk_estados','data_assinatura','prazo_vigilancia','tipo','valor_reembolso',
		'email','site','telefone','descricao','objetivo','status','created_at'];
	}

	public function get_permit(){
		return $this->permit;
	}
}