<?php
/*
	Classe gerada pelo Build_Core 
	@author Maickon Rangel - maickon4developers@gmail.com
	Prodigio Framework - 2017
	Controller: produtos
*/

class Produtosmedicamentos_Controller extends Controller_Core {
	function __construct(){
		parent::__construct();
		// setanto os meta dados
		$this->meta_title = 'Produto de medicamentos';
		$this->meta_description = 'Página de Produto medicamentos';
		$this->meta_keywords = 'Produto medicamentos';

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
			$medicamento = new Produtosmedicamentos_Model;
			if ($medicamento->save()) {
				$this->redirect('novo-produto-medicamento?success=create');
			} else {
				$this->redirect('novo-produto-medicamento?danger=create');
			}
		}
	}

	public function update(){
		$this->check_session();
		if ($_REQUEST) {
			$medicamento = new Produtosmedicamentos_Model;
			if ($medicamento->update()) {
				$this->redirect('painel/produto_medicamentos/show/'.$_REQUEST['id'].'?success=update');
			} else {
				$this->redirect('painel/produto_medicamentos/edit/'.$_REQUEST['id'].'?danger=update');
			}
		}	
	}

	public function delete(){
		$this->check_session();
		if ($_REQUEST['id']) {
			$medicamento = new Produtosmedicamentos_Model;
			if ($medicamento->delete($_REQUEST['id'])) {
				$this->redirect('produto-medicamento?success=update');
			} else {
				$this->redirect('produto-medicamento?danger=update');
			}
		}	
	}

	public function service($params = null){
		if ($params == null) {
			$resposta = 'A requisição está incorreta.';
		} elseif (is_int(intval($params[1])) and count($params) == 2) {
			$produto_medicamento = (new Produtosmedicamentos_Model)->find(intval($params[1]));
			$produto_medicamento[0]->created_at = date('d-m-Y H:m:s', strtotime($produto_medicamento[0]->created_at));
			$resposta = $produto_medicamento;
		} elseif ($params == 'tudo') {
			$produto_medicamento = (new Produtosmedicamentos_Model)->find_all();
			foreach ($produto_medicamento as $key => $value) {
				$value->created_at = date('d-m-Y H:m:s', strtotime($value->created_at));
			}
			$resposta = $produto_medicamento;
		} else {
			$resposta = 'A requisição está incorreta.';
		}

		if(empty($resposta[0]->id)){
			echo json_encode('Produto não encontrado.');
		} else {
			echo json_encode($resposta);
		}
	}
	
	public function relatorio(){
		$this->check_session();
		$produto = new Produtosmedicamentos_Model;

		$nome 	= $_REQUEST['nome'];
		$tarja 	= $_REQUEST['tarja'];
		$forma 	= $_REQUEST['forma'];
		$preco 	= $_REQUEST['preco'];

		$sql = "WHERE ";
		
		if ($nome != '') {
			$sql .= " AND nome LIKE '%{$nome}%'";
		}

		if ($tarja != '') {
			$sql .= " AND cor_tarja LIKE '%{$tarja}%'";
		}

		if ($forma != '') {
			$sql .= " AND forma LIKE '%{$forma}%'";
		}

		if ($preco != '') {
			$sql .= " AND preco='{$preco}'";
		}

		$sql = str_replace('WHERE  AND', ' ', $sql);
		$relatorio = $produto->find(['conditions'=>$sql]);

		if (count($relatorio) >= 1 and $relatorio[0]->id != ''){
			echo json_encode($relatorio);
		} else {
			echo 0;
		}
	}
}