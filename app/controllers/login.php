<?php
/*
	Classe gerada pelo Build_Core 
	@author Maickon Rangel - maickon4developers@gmail.com
	Prodigio Framework - 2017
	Controller: login
*/

class Login_Controller extends Controller_Core {
	function __construct(){
		parent::__construct();
		// setanto os meta dados
		$this->meta_title = 'Login';
		$this->meta_description = 'Faça um login';
		$this->meta_keywords = 'sistema, web, sis-odonto';
	}

	public function index(){
		global $_QUERY;
		$msg = new Displaymsg_Core;
		require_once $this->render('index');
	}

	public function entrar(){
		if ($_REQUEST['email'] and $_REQUEST['senha']) {
			$usuario = new Usuarios_Model;
			$object = $usuario->find_all_login(sha1($_REQUEST['senha']),$_REQUEST['email']);
			if (!empty($object[0]->nome)) {
				$_SESSION['id'] 	= $object[0]->id;
				$_SESSION['nome'] 	= $object[0]->nome;
				$_SESSION['email'] 	= $object[0]->email;
				$_SESSION['tipo'] 	= $object[0]->tipos->id;
				$this->redirect('painel');
			} else {
				$this->redirect('login?erro=true');
			}
		} else {
			$this->redirect('login?erro=true');
		}
	}

	public function logout(){
		session_destroy();
		$this->redirect('login');
	}
	
	public function service($params = null){
		if ($params == null) {
			$resposta = 'A requisição está incorreta.';
		} elseif (is_array($params) && count($params) == 3) {
			$usuario = new Usuarios_Model;
			$object = $usuario->find_all_login(sha1($params[2]),$params[1]);
			if (!empty($object[0]->nome)) {
				$resposta = ['status'=>1, 'id'=>$object[0]->id, 'tipo'=>$object[0]->tipos->nome, 'nome'=>$object[0]->nome, 'email'=>$object[0]->email];
			} else {
				$resposta = 0;
			}
		} else {
			$resposta = 'A requisição está incorreta.';
		}
		
		echo json_encode($resposta);
	}
}