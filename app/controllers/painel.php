<?php
/*
	Classe gerada pelo Build_Core 
	@author Maickon Rangel - maickon4developers@gmail.com
	Prodigio Framework - 2017
	Controller: painel
*/

class Painel_Controller extends Controller_Core {
	function __construct(){
		$this->painel = new Painel_Model;
		if ($_SESSION['tipo'] == 4) {
			$redirect = $this->painel->is_admin();
			($redirect != 'painel')?$this->redirect($redirect):'';
		}

		parent::__construct();
		// setanto os meta dados
		$this->meta_title = 'Painel administrativo';
		$this->meta_description = 'Painel administrativo - Sis Odonto';
		$this->meta_keywords = 'web,painel administrativo, sis odonto';
		$this->alert = new Displaymsg_Core;
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
		$this->check_session();
		require_once $this->painel->render('index');
	}
	
	public function usuarios($params = 'index'){
		$this->check_session();
		global $_QUERY;
		$tipos = (new Tipos_Model)->find_all();
		$dias = (new Dias_Model)->find_all();
		$estados = (new Estados_Model)->find_all();
		$convenios = (new Convenios_Model)->find_all();
		$usuario = new Usuarios_Model;
		if (is_array($params) and $params[0] == 'show') {
			$usuarios = $usuario->find(intval($params[1]));
			$pagina = 'show';
		} elseif(is_array($params) and $params[0] == 'edit') {
			$usuarios = $usuario->find(intval($params[1]));
			$pagina = 'edit';
		} elseif ($params == 'new') {
			$pagina = 'new';
		} else {
			$usuarios = $usuario->find_all();
			$pagina = $params;
		}
		require_once $this->painel->render('usuarios/'.$pagina);
	}

	public function dentistas($params = 'index'){
		$this->check_session();
		global $_QUERY;
		$usuario = new Usuarios_Model;
		$dentistas = $usuario->find_by_sql('SELECT * FROM usuarios WHERE fk_tipos=3');
		$pagina = $params;
		require_once $this->painel->render('dentistas/index');
	}

	public function pacientes($params = 'index'){
		$this->check_session();
		global $_QUERY;
		$usuario = new Usuarios_Model;
		if ($_SESSION['tipo'] == 3) {
			$agenda = new Agendas_Model;
			$pacientes_em_agenda = $agenda->find_filter('id_dentistas='.$_SESSION['id']);
			foreach ($pacientes_em_agenda as $key => $value) {
				$pacientes[] = $usuario->find_filter('id='.$value->id_pacientes)[0];
			}
		} else {
			$pacientes = $usuario->find_filter('fk_tipos=4');
		}
		$pagina = $params;
		require_once $this->painel->render('pacientes/index');
	}

	public function secretarias($params = 'index'){
		$this->check_session();
		global $_QUERY;
		$usuario = new Usuarios_Model;
		$secretarias = $usuario->find_filter('fk_tipos=2');
		$pagina = $params;
		require_once $this->painel->render('secretarias/index');
	}

	public function convenios($params = 'index'){
		$this->check_session();
		global $_QUERY;
		$convenio = new Convenios_Model;
		$estados = (new Estados_Model)->find_all();
		if (is_array($params) and $params[0] == 'show') {
			$convenios = $convenio->find(intval($params[1]));
			$pagina = 'show';
		} elseif(is_array($params) and $params[0] == 'edit') {
			$convenios = $convenio->find(intval($params[1]));
			$pagina = 'edit';
		} elseif ($params == 'new') {
			$pagina = 'new';
		} else {
			$convenios = $convenio->find_all();
			$pagina = $params;
		}
		require_once $this->painel->render('convenios/'.$pagina);
	}

	public function fornecedores($params = 'index'){
		$this->check_session();
		global $_QUERY;
		$fornecedor = new Fornecedores_Model;
		$naturezas_juridicas = (new Naturezajuridica_Model)->find_all();
		$ramo_de_negocios 	= (new Ramodenegocios_Model)->find_all();
		$tipos_de_empresas 	= (new Tipoempresas_Model)->find_all();
		if (is_array($params) and $params[0] == 'show') {
			$fornecedores = $fornecedor->find(intval($params[1]));
			$pagina = 'show';
		} elseif(is_array($params) and $params[0] == 'edit') {
			$fornecedores = $fornecedor->find(intval($params[1]));
			$pagina = 'edit';
		} elseif ($params == 'new') {
			$pagina = 'new';
		} else {
			$fornecedores = $fornecedor->find_all();
			$pagina = $params;
		}
		require_once $this->painel->render('fornecedores/'.$pagina);
	}

	public function produto_medicamentos($params = 'index'){
		$this->check_session();
		global $_QUERY;
		$medicamento = new Produtosmedicamentos_Model;
		if (is_array($params) and $params[0] == 'show') {
			$medicamentos = $medicamento->find(intval($params[1]));
			$pagina = 'show';
		} elseif(is_array($params) and $params[0] == 'edit') {
			$medicamentos = $medicamento->find(intval($params[1]));
			$pagina = 'edit';
		} elseif ($params == 'new') {
			$pagina = 'new';
		} else {
			$medicamentos = $medicamento->find_all();
			$pagina = $params;
		}
		require_once $this->painel->render('produto_medicamentos/'.$pagina);
	}

	public function produto_proteses($params = 'index'){
		$this->check_session();
		global $_QUERY;
		$protese = new Produtosprotese_Model;
		if (is_array($params) and $params[0] == 'show') {
			$proteses = $protese->find(intval($params[1]));
			$pagina = 'show';
		} elseif(is_array($params) and $params[0] == 'edit') {
			$proteses = $protese->find(intval($params[1]));
			$pagina = 'edit';
		} elseif ($params == 'new') {
			$pagina = 'new';
		} else {
			$proteses = $protese->find_all();
			$pagina = $params;
		}
		require_once $this->painel->render('produto_proteses/'.$pagina);
	}

	public function tratamentos($params = 'index'){
		$this->check_session();
		global $_QUERY;
		$tratamento = new Tratamentos_Model;
		if (is_array($params) and $params[0] == 'show') {
			$tratamentos = $tratamento->find(intval($params[1]));
			$pagina = 'show';
		} elseif(is_array($params) and $params[0] == 'edit') {
			$tratamentos = $tratamento->find(intval($params[1]));
			$pagina = 'edit';
		} elseif ($params == 'new') {
			$pagina = 'new';
		} else {
			$tratamentos = $tratamento->find_all();
			$pagina = $params;
		}
		require_once $this->painel->render('tratamentos/'.$pagina);
	}

	public function alterar_senha(){
		$this->check_session();
		global $_QUERY;
		require_once $this->painel->render('usuarios/senha');
	}

	public function agendas($params = 'index'){
		$this->check_session();
		global $_QUERY;
		$agenda = new Agendas_Model;
		$usuario = new Usuarios_Model;
		$dentistas = (new Usuarios_Model)->find_by_sql('SELECT * FROM usuarios WHERE fk_tipos=3');
		$pacientes = (new Usuarios_Model)->find_filter('fk_tipos=4');
		$tratamentos = (new Tratamentos_Model)->find_all();
		if (is_array($params) and $params[0] == 'show') {
			$agendas = $agenda->find(intval($params[1]));
			$pagina = 'show';
		} elseif(is_array($params) and $params[0] == 'edit') {
			$agendas = $agenda->find(intval($params[1]));
			$pagina = 'edit';
		} elseif ($params == 'new') {
			$pagina = 'new';
		} else {
			if ($_SESSION['tipo'] == 3) {
				$agenda = new Agendas_Model;
				$agendas = $agenda->find_filter('id_dentistas='.$_SESSION['id']);
				$pagina = $params;
			} else {
				$agendas = $agenda->find_all();
				$pagina = $params;
			}
		}
		require_once $this->painel->render('agendas/'.$pagina);
	}
}