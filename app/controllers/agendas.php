<?php
/*
	Classe gerada pelo Build_Core 
	@author Maickon Rangel - maickon4developers@gmail.com
	Prodigio Framework - 2017
	Controller: agendas
*/

class Agendas_Controller extends Controller_Core {
	function __construct(){
		parent::__construct();
		// setanto os meta dados
		$this->meta_title = 'Agenda';
		$this->meta_description = 'Página de agendamento.';
		$this->meta_keywords = 'Agenda';

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

	public function new(){
		$this->check_session();
		if ($_REQUEST) {
			$agenda = new Agendas_Model;
			$_REQUEST['data_hora'] = $agenda->formatar_data_para_sql($_REQUEST['data_hora']); 
			if ($agenda->save()) {
				$this->redirect('nova-agenda?success=create');
			} else {
				$this->redirect('nova-agenda?danger=create');
			}
		} else {
			$this->redirect('error');
		}
	}

	public function update(){
		$this->check_session();
		if ($_REQUEST) {
			$agenda = new Agendas_Model;
			$_REQUEST['data_hora'] = $agenda->formatar_data_para_sql($_REQUEST['data_hora']); 
			if ($agenda->update()) {
				$this->redirect('painel/agendas/show/'.$_REQUEST['id'].'?success=update');
			} else {
				$this->redirect('painel/agendas/edit/'.$_REQUEST['id'].'?danger=update');
			}
		} else {
			$this->redirect('error');
		}
	}

	public function delete(){
		$this->check_session();
		if ($_REQUEST['id']) {
			$agenda = new Agendas_Model;
			if ($agenda->delete($_REQUEST['id'])) {
				$this->redirect('agenda?success=update');
			} else {
				$this->redirect('agenda?danger=update');
			}
		} else {
			$this->redirect('error');
		}
	}

	public function checar_agenda(){
		$this->check_session();
		if ($_REQUEST['data_hora'] and $_REQUEST['id_dentistas'] and $_REQUEST['id_pacientes']) {
			$agenda = new Agendas_Model;
			$data_hora = $agenda->formatar_data_para_sql($_REQUEST['data_hora']);
			$id_dentistas = $_REQUEST['id_dentistas'];
			$id_pacientes = $_REQUEST['id_pacientes'];
			$agenda = new Agendas_Model;

			$agendas_ja_marcadas = $agenda->find_by_sql("SELECT COUNT(*) as qtd FROM agendas WHERE  id_dentistas = '{$id_dentistas}' AND data_hora='{$data_hora}'");
			if (count($agendas_ja_marcadas) == 1) {
				echo json_encode($agendas_ja_marcadas);
			} else {
				echo 0;
			}
		}
	}

	public function listar_agenda(){
		$this->check_session();
		if ($_REQUEST['id_dentistas']) {
			$agenda = new Agendas_Model;
			$agenda_dentistas = $agenda->find_filter('id_dentistas='.$_REQUEST['id_dentistas']);

			if (count($agenda_dentistas) == 1 and !empty($agenda_dentistas[0]->id)) {
				echo json_encode($agenda_dentistas);
			
			} elseif (count($agenda_dentistas) > 1){
				echo json_encode($agenda_dentistas);
			} else {
				echo 0;
			}
		}
	}

	public function nome() {
		$this->check_session();
		$agenda = new Agendas_Model;
		echo $agenda->retornar_nome($_REQUEST['nome']);
	}

	public function data() {
		$this->check_session();
		$agenda = new Agendas_Model;
		echo $agenda->formatar_data_para_escrita($_REQUEST['data_hora']);
	}

	public function tratamento() {
		$this->check_session();
		$agenda = new Agendas_Model;
		echo $agenda->retornar_tratamento($_REQUEST['tratamento']);
	}

	public function chacar_dentista_horario(){
		$this->check_session();
		$agenda = new Agendas_Model;
		$dentista = $agenda->find_by_sql("SELECT COUNT(*) as qtd FROM agendas WHERE id_dentistas='{$_REQUEST['id']}' AND NOW() <= data_hora");
		if (count($dentista) == 1) {
			echo json_encode($dentista);
		} else {
			echo 0;
		}
	}

	public function chacar_dentista(){
		$this->check_session();
		$agenda = new Agendas_Model;
		$dentista = $agenda->find_by_sql("SELECT COUNT(*) as qtd FROM agendas WHERE id_dentistas='{$_REQUEST['id']}'");
		if (count($dentista) == 1) {
			echo json_encode($dentista);
		} else {
			echo 0;
		}
	}

	public function chacar_paciente(){
		$this->check_session();
		$agenda = new Agendas_Model;
		$paciente = $agenda->find_by_sql("SELECT COUNT(*) as qtd FROM agendas WHERE id_pacientes='{$_REQUEST['id']}'");
		if (count($paciente) == 1) {
			echo json_encode($paciente);
		} else {
			echo 0;
		}
	}

	public function service($params = 'all'){
		if (count($params) < 2 and $params != 'all') {
			$this->error('URL não encontrada.');
		} else {
			$agenda = new Agendas_Model;
			switch ($params[0]) {
				case 'intervalo-data-hora': $agenda->service_by_intervalo_data_hora($params[1], $params[2]);
				break;

				case 'id_dentista-intervalo-data-hora': $agenda->service_by_intervalo_data_hora($params[2], "{$params[3]} 24:00:00", $params[1]);
				break;
				
				case 'intervalo-data': $agenda->service_by_intervalo_data_hora("{$params[1]} 00:00:00", "{$params[2]} 00:00:00");
				break;

				case 'id_dentista-intervalo-data': $agenda->service_by_intervalo_data_hora("{$params[2]} 00:00:00", "{$params[3]} 24:00:00", $params[1]);
				break;

				case 'id_dentista-intervalo-data-hora_fixa': $agenda->service_by_intervalo_data_hora_fixa("{$params[2]} 00:00:00", "{$params[3]} 24:00:00", $params[4], $params[1]);
				break;

				case 'data-hora-fixa': $agenda->service_by_data_hora_fixa($params[1]);
				break;

				case 'id_dentista-data-hora-fixa': $agenda->service_by_data_hora_fixa($params[2], $params[1]);
				break;

				case 'data-fixa': $agenda->service_by_data_fixa("{$params[1]} 00:00:00");
				break;

				case 'id_dentista-data-fixa': $agenda->service_by_data_fixa("{$params[2]} 00:00:00", $params[1]);
				break;
				
				case 'id': $agenda->service_by_id($params[1]);
				break;
				
				case 'nome-dentista': $agenda->service_by_nome_dentista($params[1]);
				break;
				
				case 'nome-paciente': $agenda->service_by_nome_paciente($params[1]);
				break;

				case 'pacientes_do_dentista': $agenda->service_by_pacientes_por_dentistas($params[1]);
				break;

				case 'cpf-paciente_do_dentista': $agenda->service_by_pacientes_por_dentistas($params[1], $params[2], 'cpf');
				break;

				case 'nome-paciente_do_dentista': $agenda->service_by_pacientes_por_dentistas($params[1], $params[2], 'nome');
				break;
				
				case 'nome-tratamento': $agenda->service_by_nome_tratamento($params[1]);
				break;
				
				default: $agenda->service_by_all();
				break;
			}

		}
	}

	public function relatorio(){
		$this->check_session();
		$agenda = new Agendas_Model;
		$id_dentistas = $_REQUEST['id_dentistas'];
		$id_pacientes = $_REQUEST['id_pacientes'];
		$fk_tratamentos = $_REQUEST['fk_tratamentos'];
		$inicial 	= $agenda->formatar_data_para_sql($_REQUEST['data_hora_inicial']);
		$final 		= $agenda->formatar_data_para_sql($_REQUEST['data_hora_final']);

		$sql = "SELECT * FROM agendas WHERE ";
		
		if ($id_dentistas != '') {
			$sql .= " AND id_dentistas='{$id_dentistas}'";
		}

		if ($id_pacientes != '') {
			$sql .= " AND id_pacientes='{$id_pacientes}'";
		}

		if ($fk_tratamentos != '') {
			$sql .= " AND fk_tratamentos='{$fk_tratamentos}'";
		}

		if ($inicial != '' AND $final != '') {
			$sql .= " AND data_hora BETWEEN '{$inicial}' AND '{$final}'";
		}

		$sql = str_replace('WHERE  AND', 'WHERE', $sql.' ORDER BY data_hora DESC');
		$relatorio = $agenda->find_by_sql($sql);

		if (count($relatorio) >= 1){
			echo json_encode($relatorio);
		} else {
			echo 0;
		}
		
	}
}