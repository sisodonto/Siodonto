<?php
/*
	Classe gerada pelo Build_Core 
	@author Maickon Rangel - maickon4developers@gmail.com
	Prodigio Framework - 2017
	Controller: usuarios
*/

class Usuarios_Controller extends Controller_Core {
	function __construct(){
		parent::__construct();
		// setanto os meta dados
		$this->meta_title = 'Nova conta';
		$this->meta_description = 'Criando uma nova conta.';
		$this->meta_keywords = 'web, Sis-odonto, criar conta';

	}

	public function novo(){
		require_once $this->render('novo');
	}

	public function criar_conta(){
		if ($_REQUEST) {
			$usuario = new Usuarios_Model;
			$_REQUEST['senha'] = sha1($_REQUEST['senha']);
			if ($usuario->save()) {
				$last_usuario 	= $usuario->find_last();
				$_SESSION['usuario_nome'] 	= $last_usuario[0]->nome;
				$_SESSION['usuario_email'] 	= $last_usuario[0]->email;
				$this->redirect('painel');
			} else {
				$this->redirect('nova-conta?erro=true');
			}
		} else {
			$this->redirect('nova-conta');
		}
	}

	public function new(){
		$this->check_session();
		if ($_REQUEST) {
			$usuario = new Usuarios_Model;
			$_REQUEST['senha'] = sha1($_REQUEST['senha']);
			$_REQUEST['fk_dias'] = ($_REQUEST['fk_tipos'] == 3)?implode(",", $_REQUEST['fk_dias']):'';
			$_REQUEST['nascimento'] = implode("-",array_reverse(explode("/", $_REQUEST['nascimento'])));
			if ($usuario->save()) {
				$this->redirect('novo-usuario?success=create');
			} else {
				$this->redirect('novo-usuario?danger=create');
			}
		} else {
			$this->redirect('error');
		}
	}

	public function update(){
		$this->check_session();
		if ($_REQUEST) {
			if (isset($_REQUEST['fk_tipos']) and isset($_REQUEST['fk_dias'])) {
				$_REQUEST['fk_dias'] = ($_REQUEST['fk_tipos'] == 3)?implode(",", $_REQUEST['fk_dias']):'';
			}
			$_REQUEST['nascimento'] = implode("-",array_reverse(explode("/", $_REQUEST['nascimento'])));
			$usuario = new Usuarios_Model;
			if ($usuario->update()) {
				$this->redirect('painel/usuarios/show/'.$_REQUEST['id'].'?success=update');
			} else {
				$this->redirect('painel/usuarios/edit/'.$_REQUEST['id'].'?danger=update');
			}
		} else {
			$this->redirect('error');
		}
	}

	public function update_pass(){
		$this->check_session();
		if ($_REQUEST['senha'] and $_REQUEST['id']) {
			$_REQUEST['senha'] = sha1($_REQUEST['senha']);
			$usuario = new Usuarios_Model;
			if ($usuario->update()) {
				$this->redirect('alterar-senha?success=update');
			} else {
				$this->redirect('alterar-senha?danger=update');
			}
		} else {
			$this->redirect('error');
		}
	}

	public function delete(){
		$this->check_session();
		if ($_REQUEST['id']) {
			$usuario = new Usuarios_Model;
			if ($usuario->delete($_REQUEST['id'])) {
				$this->redirect('usuarios?success=delete');
			} else {
				$this->redirect('usuarios?danger=delete');
			}
		}	
	}

	public function checar_horario(){
		$this->check_session();
		if (empty($_REQUEST['dias'])) {
			$dias = '0';
		} else {
			$dias = implode(',',$_REQUEST['dias']);
		}

		$horario_inicio = $_REQUEST['horario_atendimento_inicio'];
		$horario_fim = $_REQUEST['horario_atendimento_fim'];

		$usuario = new Usuarios_Model;
		$usuario_com_hora_marcada = $usuario->find_by_sql("SELECT COUNT(*) as qtd FROM usuarios WHERE  fk_dias = '{$dias}' AND horario_atendimento_inicio='{$horario_inicio}' AND horario_atendimento_fim='{$horario_fim}'");

		echo json_encode($usuario_com_hora_marcada);
	}
}