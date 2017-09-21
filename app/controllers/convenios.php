<?php
/*
	Classe gerada pelo Build_Core 
	@author Maickon Rangel - maickon4developers@gmail.com
	Prodigio Framework - 2017
	Controller: convenios
*/

class Convenios_Controller extends Controller_Core {
	function __construct(){
		parent::__construct();
		// setanto os meta dados
		$this->meta_title = 'Convênios';
		$this->meta_description = 'Convênios.';
		$this->meta_keywords = 'Convênios';

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
		$_REQUEST['data_assinatura'] = implode("-",array_reverse(explode("/", $_REQUEST['data_assinatura'])));
		$_REQUEST['prazo_vigilancia'] = implode("-",array_reverse(explode("/", $_REQUEST['prazo_vigilancia'])));
		if ($_REQUEST) {
			$convenio = new Convenios_Model;
			if ($convenio->save()) {
				$this->redirect('novo-convenio?success=create');
			} else {
				$this->redirect('novo-convenio?danger=create');
			}
		}
	}

	public function update(){
		$this->check_session();
		$_REQUEST['data_assinatura'] = implode("-",array_reverse(explode("/", $_REQUEST['data_assinatura'])));
		$_REQUEST['prazo_vigilancia'] = implode("-",array_reverse(explode("/", $_REQUEST['prazo_vigilancia'])));
		if ($_REQUEST) {
			$convenio = new Convenios_Model;
			if ($convenio->update()) {
				$this->redirect('painel/convenios/show/'.$_REQUEST['id'].'?success=update');
			} else {
				$this->redirect('painel/convenios/edit/'.$_REQUEST['id'].'?danger=update');
			}
		}	
	}

	public function delete(){
		$this->check_session();
		if ($_REQUEST['id']) {
			$convenio = new Convenios_Model;
			if ($convenio->delete($_REQUEST['id'])) {
				$this->redirect('convenio?success=update');
			} else {
				$this->redirect('convenio?danger=update');
			}
		}	
	}
	
	public function service($params = null){
		if ($params == null) {
			$resposta = 'A requisição está incorreta.';
		} elseif (is_int(intval($params[1])) and count($params) == 2) {
			$convenio = (new Convenios_Model)->find(intval($params[1]));
			$convenio[0]->data_assinatura = date('d-m-Y', strtotime($convenio[0]->data_assinatura));
			$convenio[0]->prazo_vigilancia = date('d-m-Y', strtotime($convenio[0]->prazo_vigilancia));
			$resposta = $convenio;
		} elseif ($params == 'tudo') {
			$convenio = (new Convenios_Model)->find_all();
			$resposta = $convenio;
		} else {
			$resposta = 'A requisição está incorreta.';
		}
		echo json_encode($resposta);
	}

	public function relatorio(){
		$this->check_session();
		$convenio = new Convenios_Model;

		$nome 	= $_REQUEST['nome_fantasia'];
		$cnpj 	= $_REQUEST['cnpj'];
		$razao 	= $_REQUEST['razao_social'];

		$sql = "WHERE ";
		
		if ($nome != '') {
			$sql .= " AND nome_fantasia='{$nome}'";
		}

		if ($cnpj != '') {
			$sql .= " AND cnpj='{$cnpj}'";
		}

		if ($razao != '') {
			$sql .= " AND razao_social='{$razao}'";
		}

		$sql = str_replace('WHERE  AND', ' ', $sql);
		$relatorio = $convenio->find(['conditions'=>$sql]);

		if (count($relatorio) >= 1 and $relatorio[0]->id != ''){
			echo json_encode($relatorio);
		} else {
			echo 0;
		}
	}
}