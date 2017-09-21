<?php
/*
	Classe gerada pelo Build_Core 
	@author Maickon Rangel - maickon4developers@gmail.com
	Prodigio Framework - 2017
	Controller: init
*/

class Init_Controller extends Controller_Core {
	function __construct(){
		parent::__construct();
		// setanto os meta dados
		$this->meta_title = 'Sis Odonto';
		$this->meta_description = 'Sistema Web para administração de clinicas odontológicas.';
		$this->meta_keywords = 'sistema, web, odontologia';

		// [Voce pode passar arquivos css para a pagina do seu controller apenas 
		// informando o array como parametro de $this->set_base_css()]

		// chamando css em assets/css
		// $this->css_files = $this->set_base_css(['bootstrap.min']);
		
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
		require_once $this->render('index');
	}

	public function tratamentos(){
		require_once $this->render('tratamentos');
	}

	public function fornecedor(){
		require_once $this->render('fornecedor');
	}

	public function agendas(){
		require_once $this->render('agenda');
	}

	public function produtos(){
		require_once $this->render('produtos');
	}

	public function convenios(){
		require_once $this->render('convenios');
	}
}