<?php
/*
	Classe gerada pelo Build_Core 
	@author Maickon Rangel - maickon4developers@gmail.com
	Prodigio Framework - 2017
	Controller: pacientes
*/

class Pacientes_Controller extends Controller_Core {
	function __construct(){
		parent::__construct();
		// setanto os meta dados
		$this->meta_title = 'Paciente';
		$this->meta_description = 'Página de pacientes.';
		$this->meta_keywords = 'Paciente';

		// [Voce pode passar arquivos css para a pagina do seu controller apenas 
		// informando o array como parametro de $this->set_base_css()]

		// chamando css em assets/css
		// $this->css_files = $this->set_base_css(['index','home']);
		
		// chamando css interno dentro da view e concatenando ao css_files
		// $this->css_files .= $this->set_css(['index','home']);
		
		// [Voce pode passar arquivos javascript para ser chamado na view deste  
		// controller apenas passando um array com os nomes dos arquivos sem a 
		// extençao no array em $this->set_base_js]

		// chamada de arquivos js dentro de assets
		// $this->js_files = $this->set_base_js(['index','teste']);
		// chamada de arquivos js dentro da veiw 
		// $this->js_files .= $this->set_js(['index','teste']);
	}

	public function index(){
		$agenda = new Agendas_Model;
		$agendas = $agenda->find(['conditions'=>'id_pacientes='.$_SESSION['id'].' ORDER BY data_hora DESC']);
		require_once $this->render('index');
	}

	public function service($params = null){
		if ($params == null) {
			$resposta = 'A requisição está incorreta.';
		} elseif (is_int(intval($params[1])) and count($params) == 2) {
			$param = $params[1];

			$dias = new Dias_Model;
			$estados = new Estados_Model;
			$convenio = new Convenios_Model;
			$sql = '';

			if ($params[0] == 'nome') {
				$sql = "SELECT * FROM usuarios WHERE fk_tipos = 4 AND nome LIKE '%{$param}%'";
			} elseif ($params[0] == 'cpf') {
				$sql = "SELECT * FROM usuarios WHERE fk_tipos = 4 AND cpf='{$param}'";
			} elseif ($params[0] == 'id') {
				$sql = "SELECT * FROM usuarios WHERE fk_tipos = 4 AND id={$param}";
			}
			$paciente = (new Usuarios_Model)->find_by_sql($sql);
			if (empty($paciente)) {
				$resposta = 'Paciente não encontrado.';
			} else {
				$estado_p = $estados->find_by_id_and_nome($paciente[0]->fk_estados)[0];
				$convenio_p = $convenio->find_by_id_and_nome_fantasia($paciente[0]->fk_convenios)[0];
				$paciente[0]->nascimento = date('d-m-Y H:i:s', strtotime($paciente[0]->nascimento));
				$paciente[0]->created_at = date('d-m-Y H:i:s', strtotime($paciente[0]->created_at));
				unset($paciente[0]->fk_tipos);
				unset($paciente[0]->fk_dias);
				unset($paciente[0]->horario_atendimento_inicio);
				unset($paciente[0]->horario_atendimento_fim);
				unset($paciente[0]->fk_convenios);
				unset($paciente[0]->fk_estados);
				unset($paciente[0]->cro);

				$paciente[0]->estado = $estado_p;
				$paciente[0]->convenio = $convenio_p;

				$resposta = $paciente;
			}
		} elseif ($params == 'tudo') {
			$dias = new Dias_Model;
			$estados = new Estados_Model;
			$convenio = new Convenios_Model;
			$paciente = (new Usuarios_Model)->find_by_sql("SELECT * FROM usuarios WHERE fk_tipos = 4");
			foreach ($paciente as $key => $value) {
				$estado_p = $estados->find_by_id_and_nome($value->fk_estados)[0];
				$convenio_p = $convenio->find_by_id_and_nome_fantasia($value->fk_convenios)[0];
				$value->nascimento = date('d-m-Y H:i:s', strtotime($value->nascimento));
				$value->created_at = date('d-m-Y H:i:s', strtotime($value->created_at));
				unset($value->fk_tipos);
				unset($value->fk_dias);
				unset($value->horario_atendimento_inicio);
				unset($value->horario_atendimento_fim);
				unset($value->fk_convenios);
				unset($value->fk_estados);
				unset($value->cro);

				$value->estado = $estado_p;
				$value->convenio = $convenio_p;
			}
			
			$resposta = $paciente;
		} else {
			$resposta = 'A requisição está incorreta.';
		}

		echo json_encode($resposta);
	}	
}