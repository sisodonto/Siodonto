<?php
/*
	Classe gerada pelo Build_Core 
	@author Maickon Rangel - maickon4developers@gmail.com
	Prodigio Framework - 2017
	Controller: tratamentos
*/

class Tratamentos_Controller extends Controller_Core {
	function __construct(){
		parent::__construct();
		// setanto os meta dados
		$this->meta_title = 'Tratamentos';
		$this->meta_description = 'Página de Tratamentos';
		$this->meta_keywords = 'Tratamentos';

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
			$tratamento = new Tratamentos_Model;
			if ($tratamento->save()) {
				$this->redirect('novo-tratamento?success=create');
			} else {
				$this->redirect('novo-tratamento?danger=create');
			}
		} else {
			$this->redirect('error');
		}
	}

	public function update(){
		$this->check_session();
		if ($_REQUEST) {
			$tratamento = new Tratamentos_Model;
			if ($tratamento->update()) {
				$this->redirect('painel/tratamentos/show/'.$_REQUEST['id'].'?success=update');
			} else {
				$this->redirect('painel/tratamentos/edit/'.$_REQUEST['id'].'?danger=update');
			}
		} else {
			$this->redirect('error');
		}	
	}

	public function delete(){
		$this->check_session();
		if ($_REQUEST['id']) {
			$tratamento = new Tratamentos_Model;
			if ($tratamento->delete($_REQUEST['id'])) {
				$this->redirect('tratamento?success=update');
			} else {
				$this->redirect('tratamento?danger=update');
			}
		} else {
			$this->redirect('error');
		}	
	}

	public function service($params = null){
		if ($params == null) {
			$resposta = 'A requisição está incorreta.';
		} elseif (is_int(intval($params[1])) and count($params) == 2) {
			$tratamento = (new Tratamentos_Model)->find(intval($params[1]));
			$tratamento[0]->created_at = date('d-m-Y H:m:s', strtotime($tratamento[0]->created_at));
			$resposta = $tratamento;
		} elseif ($params == 'tudo') {
			$tratamento = (new Tratamentos_Model)->find_all();
			foreach ($tratamento as $key => $value) {
				$value->created_at = date('d-m-Y H:m:s', strtotime($value->created_at));
			}
			$resposta = $tratamento;
		} else {
			$resposta = 'A requisição está incorreta.';
		}

		if(empty($resposta[0]->id)){
			echo json_encode('Tratamento não encontrado.');
		} else {
			echo json_encode($resposta);
		}
	}
	
	public function relatorio(){
		$this->check_session();
		$tratamento = new Tratamentos_Model;

		$nome 	= $_REQUEST['nome'];
		$preco 	= $_REQUEST['preco'];

		$sql = "WHERE ";
		
		if ($nome != '') {
			$sql .= " AND nome LIKE '%{$nome}%'";
		}

		if ($preco != '') {
			$sql .= " AND preco='{$preco}'";
		}

		$sql = str_replace('WHERE  AND', ' ', $sql);
		$relatorio = $tratamento->find(['conditions'=>$sql]);

		if (count($relatorio) >= 1 and $relatorio[0]->id != ''){
			echo json_encode($relatorio);
		} else {
			echo 0;
		}
	}
}