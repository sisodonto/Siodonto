<?php
/*
	Classe gerada pelo Build_Core 
	@author Maickon Rangel - maickon4developers@gmail.com
	Prodigio Framework - 2017
	Controller: relatorios
*/

class Relatorios_Controller extends Controller_Core {
	function __construct(){
		parent::__construct();
		// setanto os meta dados
		$this->meta_title = 'Relatório';
		$this->meta_description = 'Página de relatórios';
		$this->meta_keywords = 'relatórios';

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
		$this->painel = new Painel_Model;
	}

	public function index(){
		require_once $this->painel->render('relatorios/index');
	}

	public function agenda(){
		$agenda = new Agendas_Model;
		$usuario = new Usuarios_Model;
		$tratamentos = (new Tratamentos_Model)->find_all();
		$dentistas = (new Usuarios_Model)->find_by_sql('SELECT * FROM usuarios WHERE fk_tipos=3');
		$pacientes = (new Usuarios_Model)->find_filter('fk_tipos=4');
		require_once $this->painel->render('relatorios/agenda');
	}
	
	public function convenio(){
		$convenio = new Convenios_Model;
		require_once $this->painel->render('relatorios/convenio');
	}
	
	public function dentista(){
		$dentista = new Usuarios_Model;
		require_once $this->painel->render('relatorios/dentista');
	}
	
	public function fornecedor(){
		$fornecedor = new Fornecedores_Model;
		$tipos_de_empresas 	= (new Tipoempresas_Model)->find_all();
		$naturezas_juridicas = (new Naturezajuridica_Model)->find_all();
		$ramo_de_negocios 	= (new Ramodenegocios_Model)->find_all();
		require_once $this->painel->render('relatorios/fornecedor');
	}

	public function paciente(){
		$paciente = new Usuarios_Model;
		require_once $this->painel->render('relatorios/paciente');
	}
	
	public function produtosprotese(){
		$produtosprotese = new Produtosprotese_Model;
		require_once $this->painel->render('relatorios/produtosprotese');
	}
	
	public function produtomedicamento(){
		$produtomedicamento = new Produtosmedicamentos_Model;
		require_once $this->painel->render('relatorios/produtomedicamento');
	}
	
	public function secretaria(){
		$secretaria = new Usuarios_Model;
		require_once $this->painel->render('relatorios/secretaria');
	}

	public function tratamento(){
		$tratamento = new Tratamentos_Model;
		require_once $this->painel->render('relatorios/tratamento');
	}
}