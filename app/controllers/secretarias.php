<?php
/*
	Classe gerada pelo Build_Core 
	@author Maickon Rangel - maickon4developers@gmail.com
	Prodigio Framework - 2017
	Controller: secretarias
*/

class Secretarias_Controller extends Controller_Core {
	function __construct(){
		parent::__construct();
		// setanto os meta dados
		$this->meta_title = 'Secretária';
		$this->meta_description = 'Página de secretária.';
		$this->meta_keywords = 'Secretária';

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
		require_once $this->render('index');
	}

	public function service($params = null){
		if ($params == null) {
			$resposta = 'A requisição está incorreta.';
		} elseif (is_int(intval($params[1])) and count($params) == 2) {
			$param = $params[1];

			$dias = new Dias_Model;
			$estados = new Estados_Model;
			$convenio = new Convenios_Model;
			$sql = '';

			if ($params[0] == 'nome') {
				$sql = "SELECT * FROM usuarios WHERE fk_tipos = 2 AND nome LIKE '%{$param}%'";
			} elseif ($params[0] == 'cpf') {
				$sql = "SELECT * FROM usuarios WHERE fk_tipos = 2 AND cpf='{$param}'";
			} elseif ($params[0] == 'id') {
				$sql = "SELECT * FROM usuarios WHERE fk_tipos = 2 AND id={$param}";
			}
			$secretaria = (new Usuarios_Model)->find_by_sql($sql);
			if (empty($secretaria)) {
				$resposta = 'secretaria não encontrado.';
			} else {
				$estado_p = $estados->find_by_id_and_nome($secretaria[0]->fk_estados)[0];
				$secretaria[0]->nascimento = date('d-m-Y H:i:s', strtotime($secretaria[0]->nascimento));
				$secretaria[0]->created_at = date('d-m-Y H:i:s', strtotime($secretaria[0]->created_at));
				unset($secretaria[0]->fk_tipos);
				unset($secretaria[0]->fk_dias);
				unset($secretaria[0]->horario_atendimento_inicio);
				unset($secretaria[0]->horario_atendimento_fim);
				unset($secretaria[0]->fk_convenios);
				unset($secretaria[0]->fk_estados);
				unset($secretaria[0]->cro);
				unset($secretaria[0]->fk_convenios);

				$secretaria[0]->estado = $estado_p;

				$resposta = $secretaria;
			}
		} elseif ($params == 'tudo') {
			$dias = new Dias_Model;
			$estados = new Estados_Model;
			$convenio = new Convenios_Model;
			$secretaria = (new Usuarios_Model)->find_by_sql("SELECT * FROM usuarios WHERE fk_tipos = 2");
			foreach ($secretaria as $key => $value) {
				$estado_p = $estados->find_by_id_and_nome($value->fk_estados)[0];
				$value->nascimento = date('d-m-Y H:i:s', strtotime($value->nascimento));
				$value->created_at = date('d-m-Y H:i:s', strtotime($value->created_at));
				unset($value->fk_tipos);
				unset($value->fk_dias);
				unset($value->horario_atendimento_inicio);
				unset($value->horario_atendimento_fim);
				unset($value->fk_convenios);
				unset($value->fk_estados);
				unset($value->cro);
				unset($value->fk_convenios);

				$value->estado = $estado_p;
			}
			
			$resposta = $secretaria;
		} else {
			$resposta = 'A requisição está incorreta.';
		}
		
		echo json_encode($resposta);
	}		
}