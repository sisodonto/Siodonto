<?php
/*
	Classe gerada pelo Build_Core 
	@author Maickon Rangel - maickon4developers@gmail.com
	Prodigio Framework - 2017
	Model: agendas
*/

class Agendas_Model extends Dbrecord_Core {

	private $permit;

	public function __construct(){
		parent::__construct();
		$this->permit = ['id','id_dentistas','id_pacientes','fk_tratamentos','data_hora','anotacoes','created_at'];
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

	public function formatar_dias_para_calendario($id_dias){
		$dias_de_trabalho = explode(',', $id_dias);
		foreach ($dias_de_trabalho as $value) {
			$dias[] = $value;
		}
		$dias_de_trabalho = $dias;
		$dias_gerais = ['0','1','2','3','4','5','6'];
		$dias_desabilitado = implode(',', array_diff($dias_gerais, $dias_de_trabalho));
		$dias_desabilitado = "[{$dias_desabilitado}]";
		return $dias_desabilitado;
	}

	public function formatar_data_para_sql($data){
		$data_hora = explode(" ", $data);
		if (count($data_hora) == 2) {
			$data = implode("-",array_reverse(explode("/", $data_hora[0])));
			$hora = $data_hora[1];
			return date('Y-m-d H:i:s', strtotime("{$data} {$hora}"));
		} else {
			return null;
		}
	}

	public function verificar_validade($data){
		if (strtotime("now") > strtotime($data)) {
			$validade = 0;
		} else {
			$validade = 1;
		}
		return $validade;
	}

	public function formatar_data_para_escrita($data,$tipo = 'data'){
		if ($tipo == 'data') {
			return date('d-m-Y H:i:s', strtotime($data));
		} else {
			return utf8_encode(strftime('%A, %d de %B de %Y as %H:%M', strtotime($data)));
		}
	}

	public function retornar_nome($id){
		$usuario = new Usuarios_Model;
		$dados_usuario = $usuario->find_by_sql("SELECT nome FROM usuarios WHERE id={$id}")[0];
		return $dados_usuario->nome;
	}

	public function retornar_tratamento($id){
		$tratamento = new Tratamentos_Model;
		$dados_tratamento = $tratamento->find_by_sql("SELECT nome FROM tratamentos WHERE id={$id}")[0];
		return $dados_tratamento->nome;
	}

	// service
	public function service($sql){
		$agenda = new Agendas_Model;
		$usuario = new Usuarios_Model;
		$tratamento = new Tratamentos_Model;
		$dias = new Dias_Model;
		$estados = new Estados_Model;
		$convenio = new Convenios_Model;
		
		$agendas = $agenda->find_by_sql($sql);
		
		if (count($agendas) == 0) {
			$service = [];
		} else {
			foreach ($agendas as $key => $value) {
				$dentista = $usuario->find_by_sql("SELECT * FROM usuarios WHERE fk_tipos = 3 AND id={$value->id_dentistas}");
				$dentista[0]->nascimento = $this->formatar_data_para_escrita($dentista[0]->nascimento);
				$dentista[0]->created_at = $this->formatar_data_para_escrita($dentista[0]->created_at);

				$dias_trabalho = explode(',', $dentista[0]->fk_dias);
				foreach ($dias_trabalho as $d_value) {
					$dentista_dias[] = $dias->find_by_id_and_nome($d_value)[0]; 
				}
				$estado = $estados->find_by_id_and_nome($dentista[0]->fk_estados)[0];
				
				unset($dentista[0]->fk_convenios);
				unset($dentista[0]->fk_tipos);
				unset($dentista[0]->fk_dias);
				unset($dentista[0]->fk_estados);
				$dentista[0]->dias = $dentista_dias;
				$dentista[0]->estado = $estado;

				$paciente = $usuario->find_by_sql("SELECT * FROM usuarios WHERE fk_tipos = 4 AND id={$value->id_pacientes}");
				$paciente[0]->nascimento = $this->formatar_data_para_escrita($paciente[0]->nascimento);
				$paciente[0]->created_at = $this->formatar_data_para_escrita($paciente[0]->created_at);

				$estado_p = $estados->find_by_id_and_nome($paciente[0]->fk_estados)[0];
				$convenio_p = $convenio->find_by_id_and_nome_fantasia($paciente[0]->fk_convenios)[0];
				
				unset($paciente[0]->fk_tipos);
				unset($paciente[0]->fk_dias);
				unset($paciente[0]->fk_convenios);
				unset($paciente[0]->fk_estados);
				unset($paciente[0]->cro);

				$paciente[0]->estado = $estado_p;
				$paciente[0]->convenio = $convenio_p;
				$tratamento_a = $tratamento->find_filter('id='.$value->fk_tratamentos);
				$tratamento_a[0]->created_at = $this->formatar_data_para_escrita($tratamento_a[0]->created_at);

				$service[] = [
					'id' 			=> $value->id,
					'dentista' 		=> $dentista,
					'paciente' 		=> $paciente,
					'tratamento' 	=> $tratamento_a,
					'data_hora' 	=> $this->formatar_data_para_escrita($value->data_hora),
					'anotacoes' 	=> $value->anotacoes,
					'cadastrado' 	=> $this->formatar_data_para_escrita($value->created_at)
				];			
			}
		}
		return $service;
	}

	public function service_by_intervalo_data_hora($data_hora_inicial, $data_hora_final, $id = 0){
		$data_hora_inicial = $this->formatar_data_para_sql($data_hora_inicial);
		$data_hora_final = $this->formatar_data_para_sql($data_hora_final);
		if ($id == 0) {
			$id_dentistas = '';
		} else {
			$id_dentistas = " AND id_dentistas={$id}";
		}

		$sql = "SELECT * FROM agendas WHERE data_hora BETWEEN '{$data_hora_inicial}' AND '{$data_hora_final}' {$id_dentistas}";

		echo json_encode($this->service($sql));
	}

	public function service_by_intervalo_data_hora_fixa($data_inicial, $data_final, $hora, $id = 0){
		$data_inicial = $this->formatar_data_para_sql($data_inicial);
		$data_final = $this->formatar_data_para_sql($data_final);
		if ($id == 0) {
			$id_dentistas = '';
		} else {
			$id_dentistas = " AND id_dentistas={$id}";
		}

		$sql = "SELECT * FROM agendas WHERE (CAST(data_hora AS TIME) = '{$hora}') AND data_hora BETWEEN '{$data_inicial}' AND '{$data_final}' {$id_dentistas}";

		echo json_encode($this->service($sql));
	}

	public function service_by_data_hora_fixa($data_hora_inicial, $id = 0){
		$data_hora_inicial = $this->formatar_data_para_sql($data_hora_inicial);
		if ($id == 0) {
			$id_dentistas = '';
		} else {
			$id_dentistas = " AND id_dentistas={$id}";
		}
		$sql = "SELECT * FROM agendas WHERE data_hora = '{$data_hora_inicial}' {$id_dentistas}";
		echo json_encode($this->service($sql));
	}

	public function service_by_data_fixa($data_hora_inicial, $id = 0){
		$data_hora_inicial = substr($this->formatar_data_para_sql($data_hora_inicial), 0, 11);
		if ($id == 0) {
			$id_dentistas = '';
		} else {
			$id_dentistas = " AND id_dentistas={$id}";
		}
		$sql = "SELECT * FROM agendas WHERE data_hora LIKE '%{$data_hora_inicial}%' {$id_dentistas}";
		echo json_encode($this->service($sql));
	}

	public function service_by_id($id){
		$sql = "SELECT * FROM agendas WHERE id = '{$id}'";
		echo json_encode($this->service($sql));
	}

	public function service_by_nome_dentista($nome){
		$sql = "SELECT d.nome, a.* FROM agendas a, usuarios d WHERE d.nome LIKE '%{$nome}%' AND d.id = a.id_dentistas";
		echo json_encode($this->service($sql));
	}

	public function service_by_nome_paciente($nome){
		$sql = "SELECT p.nome, a.* FROM agendas a, usuarios p WHERE p.nome LIKE '%{$nome}%' AND p.id = a.id_pacientes";
		echo json_encode($this->service($sql));
	}

	public function service_by_nome_tratamento($nome){
		$sql = "SELECT t.nome, a.* FROM agendas a, tratamentos t WHERE t.nome LIKE '%{$nome}%' AND t.id = a.fk_tratamentos";
		echo json_encode($this->service($sql));
	}

	public function service_by_all(){
		$sql = "SELECT * FROM agendas";
		echo json_encode($this->service($sql));
	}

	public function service_by_pacientes_por_dentistas($id, $campo = null, $tipo = null){
		$usuario = new Usuarios_Model;
		$agenda = new Agendas_Model;
		$pacientes_em_agenda = $agenda->find_filter('id_dentistas='.$id);
	
		foreach ($pacientes_em_agenda as $key => $value) {
			$paciente = $usuario->find_filter('id='.$value->id_pacientes)[0];
			unset($paciente->dias);
			$paciente->nascimento = $this->formatar_data_para_escrita($paciente->nascimento);
			$paciente->created_at = $this->formatar_data_para_escrita($paciente->created_at);

			$paciente->tipos->created_at = $this->formatar_data_para_escrita($paciente->tipos->created_at);
			
			$paciente->convenios->data_assinatura = $this->formatar_data_para_escrita($paciente->tipos->data_assinatura);
			$paciente->convenios->prazo_vigilancia = $this->formatar_data_para_escrita($paciente->tipos->prazo_vigilancia);
			$paciente->convenios->created_at = $this->formatar_data_para_escrita($paciente->tipos->created_at);
			
			$paciente->agenda = $value;
			$paciente->agenda->data_hora = $this->formatar_data_para_escrita($paciente->agenda->data_hora);
			$paciente->agenda->created_at = $this->formatar_data_para_escrita($paciente->agenda->created_at);
			
			$dentista = $usuario->find_filter('id='.$paciente->agenda->id_dentistas)[0];
			unset($paciente->agenda->id_dentistas);
			$paciente->agenda->dentista = $dentista;

			$pacientes[] = $paciente;
		}
		
		if ($campo != null) {
			foreach ($pacientes as $key => $value) {
				if(strpos($value->$tipo, $campo) === false){
					unset($pacientes[$key]);
				} else {
				}
			}
		}
	
		if(isset($pacientes[0]) and $pacientes[0]->id == ''){
			echo json_encode([]);
		} else {
			echo json_encode($pacientes);
		}
	}
}