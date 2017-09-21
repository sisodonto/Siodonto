<?php
/*
	Classe gerada pelo Build_Core 
	@author Maickon Rangel - maickon4developers@gmail.com
	Prodigio Framework - 2017
	Controller: dentistas
*/

class Dentistas_Controller extends Controller_Core {
	function __construct(){
		parent::__construct();
		// setanto os meta dados
		$this->meta_title = 'Dentistas';
		$this->meta_description = 'Página de dentista.';
		$this->meta_keywords = 'Dentistas';

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
		$agendas = $agenda->find(['conditions'=>'id_dentistas='.$_SESSION['id'].' ORDER BY data_hora DESC']);
		require_once $this->render('index');
	}
	
	public function service($params = null){
		if ($params == null) {
			$resposta = 'A requisição está incorreta.';
		} elseif (is_int(intval($params[1])) and count($params) == 2) {
			$id = intval($params[1]);
			$dias = new Dias_Model;
			$estados = new Estados_Model;
			$convenio = new Convenios_Model;
			$dentista = (new Usuarios_Model)->find_by_sql("SELECT * FROM usuarios WHERE fk_tipos = 3 AND id={$id}");
			if (empty($dentista)) {
				$resposta = 'Dentista não encontrado.';
			} else {
				$dentista[0]->horario_atendimento_inicio = date('d-m-Y H:m:s', strtotime($dentista[0]->horario_atendimento_inicio));
				$dentista[0]->horario_atendimento_fim = date('d-m-Y H:m:s', strtotime($dentista[0]->horario_atendimento_fim));
				$dentista[0]->created_at = date('d-m-Y H:m:s', strtotime($dentista[0]->created_at));
				
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

				$resposta = $dentista;
			}
		} elseif ($params == 'tudo') {
			$dias = new Dias_Model;
			$estados = new Estados_Model;
			$convenio = new Convenios_Model;
			$dentista = (new Usuarios_Model)->find_by_sql("SELECT * FROM usuarios WHERE fk_tipos = 3");
			foreach ($dentista as $key => $value) {
				$value->horario_atendimento_inicio = date('d-m-Y H:m:s', strtotime($value->horario_atendimento_inicio));
				$value->horario_atendimento_fim = date('d-m-Y H:m:s', strtotime($value->horario_atendimento_fim));
				$value->created_at = date('d-m-Y H:m:s', strtotime($value->created_at));
				
				$dias_trabalho = explode(',', $value->fk_dias);
				foreach ($dias_trabalho as $d_value) {
					$dentista_dias[] = $dias->find_by_id_and_nome($d_value)[0]; 
				}
				$estado = $estados->find_by_id_and_nome($value->fk_estados)[0];
				
				unset($value->fk_convenios);
				unset($value->fk_tipos);
				unset($value->fk_dias);
				unset($value->fk_estados);
				$value->dias = $dentista_dias;
				$value->estado = $estado;
			}
			
			$resposta = $dentista;
		} else {
			$resposta = 'A requisição está incorreta.';
		}

		echo json_encode($resposta);
	}
}