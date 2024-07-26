<?php


namespace App\Controllers;

use MF\Controller\Action;
use MF\Model\Container;

class IndexController extends Action {

    public function index() {

		$this->view->login = isset($_GET['login']) ? $_GET['login'] : '';
	
        $this->render('index');
    }

    public function inscreverse() {
		// Pra no mostrar o erro quando ele entrar de primeira
		$this->view->erroCadastro = false;
		$this->view->erroEmailExistente = false;
		$this->view->erroUsernameExistente = false;

		// Isso aqui pra caso o animal acesse a URL diretamente, só pra n dar erro
		$this->view->usuario = array(
			'nome' => "",
			'email' => "",
			'senha' => ""
		);
        $this->render('inscreverse');
    }

	public function registrar(){

		// Vamos usar o container por que ele ja retorna a classe instanciada com a conexao com o banco
		$usuario = Container::getModel('Usuario');
		$usuario->__set('nome', $_POST['nome']);
		$usuario->__set('email', $_POST['email']);
		$usuario->__set('senha', md5($_POST['senha']));

		if(!$usuario->validarCadastro()){
			// Erro de validação por causa do tamanho de algum dos campos

			$this->view->erroCadastro = true;
			$this->view->usuario = array(
				'nome' => $_POST['nome'],
				'email' => $_POST['email'],
				'senha' => $_POST['senha']
			);	
			$this->render('inscreverse');
			return;

		} else if (count($usuario->getUsuarioPorEmail()) > 0){
			// Se ja tem alguem com o email

			$this->view->erroEmailExistente = true;
			$this->view->usuario = array(
				'nome' => $_POST['nome'],
				'email' => $_POST['email'],
				'senha' => $_POST['senha']
			);	
			$this->render('inscreverse');
			return;
		
		} else if(count($usuario->getUsuarioPorUsername()) > 0){
			// Se ja tem alguem com o username

			$this->view->erroUsernameExistente = true;
			$this->view->usuario = array(
				'nome' => $_POST['nome'],
				'email' => $_POST['email'],
				'senha' => $_POST['senha']
			);	
			$this->render('inscreverse');
			return;
		} else {

			$usuario->salvar();			
			$this->render('cadastro');
			$usuario->seguirUsuario(1);
		
		}
	}

}
?>