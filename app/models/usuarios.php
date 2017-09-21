<?php
/*
	Classe gerada pelo Build_Core 
	@author Maickon Rangel - maickon4developers@gmail.com
	Prodigio Framework - 2017
	Model: usuarios
*/

class Usuarios_Model extends Dbrecord_Core {

	private $permit;

	public function __construct(){
		parent::__construct();
		$this->permit = ['id','nome','email','senha','telefone','fk_tipos','fk_dias','fk_convenios','horario_atendimento_inicio','horario_atendimento_fim','sexo','rg','cpf','cro','nascimento','telefone_residencial','rua','bairro','numero','cidade','cep','fk_estados','ativo','created_at'];
	}

	public function get_permit(){
		return $this->permit;
	}

	public function formatar_dias($id_dias){
		$dias = ['1'=>'2°','2'=>'3°','3'=>'4°','4'=>'5°','5'=>'6°','6'=>'SAB','7'=>'DOM'];
		$dias_de_trabalho = explode(',', $id_dias);
		$dias_formatado = '(';
		foreach ($dias_de_trabalho as $key => $value) {
			if (end($dias_de_trabalho) == $value) {
				$dias_formatado .= "{$dias[$value]}";
			} else {
				$dias_formatado .= "{$dias[$value]} - ";
			}
		}
		$dias_formatado .= ')';
		return $dias_formatado;
	}
}