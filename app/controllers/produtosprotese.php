<?php
/*
	Classe gerada pelo Build_Core 
	@author Maickon Rangel - maickon4developers@gmail.com
	Prodigio Framework - 2017
	Controller: produtosprotese
*/

class Produtosprotese_Controller extends Controller_Core {
	function __construct(){
		parent::__construct();
		// setanto os meta dados
		$this->meta_title = 'Produtos Protese';
		$this->meta_description = 'Página de Produto protese.';
		$this->meta_keywords = 'Produto protese';

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
			$protese = new Produtosprotese_Model;
			if ($protese->save()) {
				$this->redirect('novo-produto-protese?success=create');
			} else {
				$this->redirect('novo-produto-protese?danger=create');
			}
		}
	}

	public function update(){
		$this->check_session();
		if ($_REQUEST) {
			$protese = new Produtosprotese_Model;
			if ($protese->update()) {
				$this->redirect('painel/produto_proteses/show/'.$_REQUEST['id'].'?success=update');
			} else {
				$this->redirect('painel/produto_proteses/edit/'.$_REQUEST['id'].'?danger=update');
			}
		}	
	}

	public function delete(){
		$this->check_session();
		if ($_REQUEST['id']) {
			$protese = new Produtosprotese_Model;
			if ($protese->delete($_REQUEST['id'])) {
				$this->redirect('produto-protese?success=update');
			} else {
				$this->redirect('produto-protese?danger=update');
			}
		}	
	}

	public function service($params = null){
		if ($params == null) {
			$resposta = 'A requisição está incorreta.';
		} elseif (is_int(intval($params[1])) and count($params) == 2) {
			$produto_protese = (new Produtosprotese_Model)->find(intval($params[1]));
			$produto_protese[0]->created_at = date('d-m-Y H:m:s', strtotime($produto_protese[0]->created_at));
			$resposta = $produto_protese;
		} elseif ($params == 'tudo') {
			$produto_protese = (new Produtosprotese_Model)->find_all();
			foreach ($produto_protese as $key => $value) {
				$value->created_at = date('d-m-Y H:m:s', strtotime($value->created_at));
			}
			$resposta = $produto_protese;
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
		$produto = new Produtosprotese_Model;

		$nome 	= $_REQUEST['nome'];
		$tipo 	= $_REQUEST['tipo'];
		$preco 	= $_REQUEST['preco'];

		$sql = "WHERE ";
		
		if ($nome != '') {
			$sql .= " AND nome LIKE '%{$nome}%'";
		}

		if ($tipo != '') {
			$sql .= " AND tipo LIKE '%{$tipo}%'";
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