<?php
/*
	Classe gerada pelo Build_Core 
	@author Maickon Rangel - maickon4developers@gmail.com
	Prodigio Framework - 2017
	Controller: fornecedores
*/

class Fornecedores_Controller extends Controller_Core {
	function __construct(){
		parent::__construct();
		// setanto os meta dados
		$this->meta_title = 'Fornecedores';
		$this->meta_description = 'Página de Fornecedores.';
		$this->meta_keywords = 'Fornecedores';

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
			$fornecedor = new Fornecedores_Model;
			if ($fornecedor->save()) {
				$this->redirect('novo-fornecedor?success=create');
			} else {
				$this->redirect('novo-fornecedor?danger=create');
			}
		}
	}

	public function update(){
		$this->check_session();
		if ($_REQUEST) {
			$fornecedor = new Fornecedores_Model;
			if ($fornecedor->update()) {
				$this->redirect('painel/fornecedores/show/'.$_REQUEST['id'].'?success=update');
			} else {
				$this->redirect('painel/fornecedores/edit/'.$_REQUEST['id'].'?danger=update');
			}
		}	
	}

	public function delete(){
		$this->check_session();
		if ($_REQUEST['id']) {
			$fornecedor = new Fornecedores_Model;
			if ($fornecedor->delete($_REQUEST['id'])) {
				$this->redirect('fornecedor?success=update');
			} else {
				$this->redirect('fornecedor?danger=update');
			}
		}	
	}

	public function service($params = null){
		if ($params == null) {
			$resposta = 'A requisição está incorreta.';
		} elseif (is_int(intval($params[1])) and count($params) == 2) {
			$fornecedor = (new fornecedores_Model)->find(intval($params[1]));
			$fornecedor[0]->created_at = date('d-m-Y H:m:s', strtotime($fornecedor[0]->created_at));
			$resposta = $fornecedor;
		} elseif ($params == 'tudo') {
			$fornecedor = (new fornecedores_Model)->find_all();
			foreach ($fornecedor as $key => $value) {
				$value->created_at = date('d-m-Y H:m:s', strtotime($value->created_at));
			}
			$resposta = $fornecedor;
		} else {
			$resposta = 'A requisição está incorreta.';
		}

		echo json_encode($resposta);
	}
	
	public function relatorio(){
		$this->check_session();
		$fornecedor = new Fornecedores_Model;

		$nome 				= $_REQUEST['nome'];
		$capital_social 	= $_REQUEST['capital_social'];
		$inscricao_estadual = $_REQUEST['inscricao_estadual'];
		$linha_produto 		= $_REQUEST['linha_produto'];
		$tipo_empresa 		= $_REQUEST['fk_tipoempresas'];
		$ramo_negocio 		= $_REQUEST['fk_ramodenegocios'];
		$natureza_juridica 	= $_REQUEST['fk_naturezajuridica'];

		$sql = "WHERE ";
		
		if ($nome != '') {
			$sql .= " AND nome='{$nome}'";
		}

		if ($capital_social != '') {
			$sql .= " AND capital_social='{$capital_social}'";
		}

		if ($inscricao_estadual != '') {
			$sql .= " AND inscricao_estadual='{$inscricao_estadual}'";
		}

		if ($linha_produto != '') {
			$sql .= " AND linha_produto='{$linha_produto}'";
		}

		if ($tipo_empresa != '') {
			$sql .= " AND fk_tipoempresas='{$tipo_empresa}'";
		}

		if ($ramo_negocio != '') {
			$sql .= " AND fk_ramodenegocios='{$ramo_negocio}'";
		}

		if ($natureza_juridica != '') {
			$sql .= " AND fk_naturezajuridica='{$natureza_juridica}'";
		}

		$sql = str_replace('WHERE  AND', ' ', $sql);
		$relatorio = $fornecedor->find(['conditions'=>$sql]);

		if (count($relatorio) >= 1 and $relatorio[0]->id != ''){
			echo json_encode($relatorio);
		} else {
			echo 0;
		}
	}
}