<?php


namespace App\Controllers;

use MF\Controller\Action;
use MF\Model\Container;

final class AppController extends Action{

    public function timeline(){

        $this->validarLogado();

        // recuperar tweets
        $this->view->id = $_SESSION["id"];

        // Instanciando o tweet
        $tweet = Container::getModel("Tweet");
        
        // Setando para recuperar os meus tweets
        $tweet->__set("id_usuario", $_SESSION["id"]);

        $user = Container::getModel("Usuario");
        $user->__set("id", $_SESSION["id"]);

        $this->view->nome = $user->getInfoUsuario()["nome"];
        $this->view->totalTweets = $user->getTotalTweets()["total_tweets"];
        $this->view->totalSeguidores = $user->getTotalSeguidores()["total_seguidores"];
        $this->view->totalSeguindo = $user->getTotalSeguindo()["total_seguindo"];
        $this->view->imagemTopo = $user->getImagemTopo();

        //variaveis de paginação
        $totalRegistrosPagina = 10; //limit
        $paginaAtual = isset($_GET["pagina"]) ? $_GET["pagina"] : 1;
        $deslocamento = ($paginaAtual - 1) * $totalRegistrosPagina; // offset
        $this->view->paginaAtual = $paginaAtual;

        // Recuperando os meus e de quem eu sigo
        $tweets = $tweet->recuperarPorPagina($totalRegistrosPagina, $deslocamento);
        $totalTweets = $tweet->recuperarTotalRegistros()['total'];
        $totalPaginas = ceil($totalTweets / $totalRegistrosPagina);
        $this->view->totalPaginas = $totalPaginas;
        $this->view->tweets = $tweets;

        // Recomendação do quem seguir
        $retorno = [];
       
        $retorno = $user->getRecomendacao();            
                
        $this->view->recomendacao = $retorno;

        $this->render("timeline");
    }


    public function pesquisaHovers(){

        $this->validarLogado();

        // recuperar tweets
        $this->view->id = $_SESSION["id"];

        // Instanciando o tweet
        $tweet = Container::getModel("Tweet");
        
        // Setando para recuperar os meus tweets
        $tweet->__set("id_usuario", $_SESSION["id"]);

        $user = Container::getModel("Usuario");
        $user->__set("id", $_SESSION["id"]);

        $this->view->nome = $user->getInfoUsuario()["nome"];
        $this->view->totalTweets = $user->getTotalTweets()["total_tweets"];
        $this->view->totalSeguidores = $user->getTotalSeguidores()["total_seguidores"];
        $this->view->totalSeguindo = $user->getTotalSeguindo()["total_seguindo"];
        $this->view->imagemTopo = $user->getImagemTopo();

        //variaveis de paginação
        $totalRegistrosPagina = 10; //limit
        $paginaAtual = isset($_GET["pagina"]) ? $_GET["pagina"] : 1;
        $deslocamento = ($paginaAtual - 1) * $totalRegistrosPagina; // offset
        $this->view->paginaAtual = $paginaAtual;

        $pesquisa = $_POST["search"];
        echo $pesquisa;
        
        // Recuperando os hover de acordo com a pesquisa
        $tweets = $tweet->recuperarSearchBy($pesquisa, $totalRegistrosPagina, $deslocamento);
        $totalTweets = $tweet->recuperarTotalRegistros()['total'];
        $totalPaginas = ceil($totalTweets / $totalRegistrosPagina);
        $this->view->totalPaginas = $totalPaginas;
        $this->view->tweets = $tweets;

        // Recomendação do quem seguir
        $retorno = [];
       
        $retorno = $user->getRecomendacao();            
                
        $this->view->recomendacao = $retorno;

        $this->render("pesquisaHovers");
    }

    public function quemseguir(){

        $this->validarLogado();    
        $this->view->nome = $_SESSION["nome"];
    
        
        $pesquisa = isset($_GET["pesquisa"]) ? $_GET["pesquisa"] : '';
        
        $user = Container::getModel("Usuario");
        $user->__set("id", $_SESSION["id"]);

        $this->view->nome = $user->getInfoUsuario()["nome"];
        $this->view->totalTweets = $user->getTotalTweets()["total_tweets"];
        $this->view->totalSeguidores = $user->getTotalSeguidores()["total_seguidores"];
        $this->view->totalSeguindo = $user->getTotalSeguindo()["total_seguindo"];
        $this->view->imagemTopo = $user->getImagemTopo();

        // Caso n seja nada pesquisado o array é vazio
        $retorno = [];
        
        if ($pesquisa != ""){
            $user = Container::getModel("Usuario");
            $user->__set("nome", $pesquisa);
            $user->__set("id", $_SESSION["id"]);
            $retorno = $user->getPesquisa();            
        }
        
        $this->view->retorno = $retorno;
        $this->render("quemSeguir");
    }

    public function perfilPrincipal(){

        // é praticamente identico a timeline em alguns aspectos
        $this->validarLogado();

        // recuperar tweets
        $this->view->id = $_SESSION["id"];
        
        // Instanciando o tweet
        $tweet = Container::getModel("Tweet");
        
        // Setando para recuperar os meus tweets
        $tweet->__set("id_usuario", $_SESSION["id"]);

        $user = Container::getModel("Usuario");
        $user->__set("id", $_SESSION["id"]);

        $this->view->nome = $user->getInfoUsuario()["nome"];
        $this->view->totalTweets = $user->getTotalTweets()["total_tweets"];
        $this->view->totalSeguidores = $user->getTotalSeguidores()["total_seguidores"];
        $this->view->totalSeguindo = $user->getTotalSeguindo()["total_seguindo"];
        $this->view->imagemTopo = $user->getImagemTopo();
        
        //variaveis de paginação
        $totalRegistrosPagina = 10; //limit
        $paginaAtual = isset($_GET["pagina"]) ? $_GET["pagina"] : 1;
        $deslocamento = ($paginaAtual - 1) * $totalRegistrosPagina; // offset
        $this->view->paginaAtual = $paginaAtual;

        // Recuperando só os meus tweets
        $tweets = $tweet->recuperar($totalRegistrosPagina, $deslocamento);
        $totalTweets = $tweet->recuperarTotalRegistrosPerfil()['total'];
        $totalPaginas = ceil($totalTweets / $totalRegistrosPagina);
        $this->view->totalPaginas = $totalPaginas;
        $this->view->tweets = $tweets;

        // Verificando se teve erro ao mudar o nome
        $this->view->erroUsernameExistente = isset($_GET["erroUsuarioExistente"]) ? $_GET["erroUsuarioExistente"] : false;
        $this->view->username = isset($_GET["username"]) ? $_GET["username"] : '';


        $this->render("perfilPrincipal");

    }

    public function tweet(){
       session_start();

    $this->validarLogado();

    $tweet = Container::getModel("Tweet");

    $tweet->__set("tweet", $_POST["tweet"]);
    $tweet->__set("id_usuario", $_SESSION["id"]);
    
    $img_path = null;
    if(isset($_FILES['imagem_tweet']) && $_FILES['imagem_tweet']['error'] == 0) {
        $arquivo_tmp = $_FILES['imagem_tweet']['tmp_name'];
        $nome = $_FILES['imagem_tweet']['name'];
        
        $extensao = pathinfo($nome, PATHINFO_EXTENSION);
        $extensao = strtolower($extensao);

        if(strstr('.jpg;.jpeg;.gif;.png', $extensao)) {
            $novo_nome = uniqid(time()) . '.' . $extensao;
            $destino = 'img/tweets/' . $novo_nome;
            
            if(@move_uploaded_file($arquivo_tmp, $destino)) {
                $img_path = $destino;
                $tweet->__set("img", $img_path);
            } else {
                echo "Falha ao mover o arquivo.";
            }
        } else {
            echo "Extensão de arquivo não permitida.";
        }
    } else {
        echo "Erro no upload do arquivo.";
    }

    $tweet->salvar();

    header("Location: timeline");

    print_r($_POST);
    print_r($_FILES);
    }

        
    public function validarLogado(){
        session_start();
    
        if((!isset($_SESSION["id"]) || $_SESSION["id"] == '') && (!isset($_SESSION["nome"]) || $_SESSION["nome"] == '')){
            header("Location: /HoverApp/public/?login=erro");
        }
    }

    public function acao(){
        $this->validarLogado();

        $acao = isset($_GET["acao"]) ? $_GET["acao"] : '';
        $id_usuario_seguindo = isset($_GET["id_seguindo"]) ? $_GET["id_seguindo"] : '';

        $user = Container::getModel("Usuario");
        $user->__set("id", $_SESSION["id"]);    

        if($acao == "seguir"){
            $user->seguirUsuario($id_usuario_seguindo);
        } else if($acao == "deixar_seguir"){
            $user->deixarSeguirUsuario($id_usuario_seguindo);
        }

        header("Location: timeline");
    }

    public function removertweet(){

        $this->validarLogado();
        
        $tweet = Container::getModel("Tweet");
        $tweet->__set("id", $_GET["id_tweet"]);

        $tweet->removerTweet();

        header("Location: timeline");
    }    
    
public function mudarTopo() {
    $this->validarLogado();
    
    if(isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
        $arquivo_tmp = $_FILES['imagem']['tmp_name'];
        $nome = $_FILES['imagem']['name'];
        
        $extensao = pathinfo($nome, PATHINFO_EXTENSION);
        $extensao = strtolower($extensao);

        if(strstr('.jpg;.jpeg;.gif;.png', $extensao)) {
            $novo_nome = uniqid(time()) . '.' . $extensao;
            $destino = 'img/topos/' . $novo_nome;
            
            if(@move_uploaded_file($arquivo_tmp, $destino)) {
                $usuario = Container::getModel('Usuario');
                $usuario->__set('id', $_SESSION['id']);
                $usuario->__set('imagem_topo', $destino);
                $usuario->atualizarImagemTopo();
            }
        }
    }
    
    header("Location: perfilPrincipal");
}

public function atualizar_nome(){
    $this->validarLogado();
    
    $usuario = Container::getModel('Usuario');
    $usuario->__set('id', $_SESSION['id']);
    $usuario->__set('nome', $_POST['nome']);
    $this->view->erroUsernameExistente = false;    
    
    if (count($usuario->getUsuarioPorUsername()) > 0){

        $this->view->erroUsernameExistente = true;        
        header("Location: perfilPrincipal?erroUsuarioExistente=true&username=" . $_POST['nome']);
    } 
    else{
        $usuario->atualizarNome();
        header("Location: perfilPrincipal?");
    }

    
}


}

