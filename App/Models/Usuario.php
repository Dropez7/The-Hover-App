<?php

namespace App\Models;

use MF\Model\Model;

class Usuario extends Model {


    private $id;
    private $nome;
    private $email;
    private $senha;
    private $imagem_topo;
    
    public function __get($nome){
        return $this->$nome;
    }

    public function __set($nome, $valor){
        $this->$nome = $valor;
    }

    // Salvar
    public function salvar(){
        $query = "INSERT INTO usuarios(nome, email, senha) VALUES(:nome, :email, :senha)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':nome', $this->__get('nome'));
        $stmt->bindValue(':email', $this->__get('email'));
        $stmt->bindValue(':senha', $this->__get('senha'));
       
        $stmt->execute(); 
        
        
        return $this;
    }

    // Validar se um cadastro pode ser feito
    public function validarCadastro(){
        $valido = true;

        // Validação exemplo
        if(strlen($this->__get('nome')) < 3){
            $valido = false;
        }

        if(strlen($this->__get('email')) < 11){
            $valido = false;
        }

        if(strlen($this->__get('senha')) < 3){
            $valido = false;
        }

        return $valido;
    }

    // Recuperar um usuário por e-mail
    public function getUsuarioPorEmail(){
        $query = "SELECT nome, email FROM Usuarios WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':email', $this->__get('email'));
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getUsuarioPorUsername(){
        $query = "SELECT nome, email FROM Usuarios WHERE nome = :nome";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':nome', $this->__get('nome'));
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function autenticar(){
        $query = "SELECT id, nome, email FROM Usuarios WHERE email = :email AND senha = :senha";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":email", $this->__get('email'));
        $stmt->bindValue(":senha", $this->__get('senha'));
        $stmt->execute();

        $usuario = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        if($usuario['id'] != '' && $usuario['nome'] != ''){
            $this->__set('id', $usuario['id']);
            $this->__set('nome', $usuario['nome']);
        }

        return $this;
    }

    public function getPesquisa(){
        $query = "SELECT u.id, u.nome, u.email, (SELECT COUNT(*) FROM usuarios_seguidores as us where us.id_usuario = :id and us.id_usuario_seguindo = u.id) as seguindo_sn FROM usuarios as u where u.nome LIKE :nome and u.id != :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":nome", '%'.$this->__get('nome').'%');
        $stmt->bindValue(":id", $this->__get('id'));
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getRecomendacao(){
    
        $query = "SELECT u.id, u.nome, u.email FROM usuarios AS u WHERE u.id != :id AND u.id NOT IN (SELECT us.id_usuario_seguindo FROM usuarios_seguidores AS us WHERE us.id_usuario = :id) ORDER BY RAND() LIMIT 5;";
        $stmt = $this->db->prepare($query);        
        $stmt->bindValue(":id", $this->__get('id'));
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);

    }

    public function seguirUsuario($id_usuario_seguindo){
        try {
        $query = "INSERT INTO usuarios_seguidores(id_usuario, id_usuario_seguindo) VALUES (:id_usuario, :id_usuario_seguindo)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":id_usuario", $this->__get('id'));
        $stmt->bindValue(":id_usuario_seguindo", $id_usuario_seguindo);
        $stmt->execute();
        
        } catch (\PDOException $e){
            echo $e->getMessage();
        }

        return $this;
    }

    public function deixarSeguirUsuario($id_usuario_seguindo){
        $query = "DELETE FROM usuarios_seguidores WHERE id_usuario = :id_usuario AND id_usuario_seguindo = :id_usuario_seguindo";
        $stmt = $this->db->prepare($query);
        
        $stmt->bindValue(":id_usuario", $this->__get('id'));
        $stmt->bindValue(":id_usuario_seguindo", $id_usuario_seguindo);
        $stmt->execute();
        echo "<br>";
        echo "MEU ID:" . $this->__get('id');
        echo "<br>";
        echo "ID de quem eu vou Seguir:" . $id_usuario_seguindo;
        echo "<br>";    
        echo "rodou";

        return $this;
    }


    public function getInfoUsuario(){

        $query = "SELECT nome FROM usuarios WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":id", $this->__get('id'));
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getTotalTweets(){
        $query = "SELECT COUNT(*) as total_tweets FROM tweets WHERE id_usuario = :id_usuario";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":id_usuario", $this->__get('id'));
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getTotalSeguindo(){
        $query = "SELECT COUNT(*) as total_seguindo FROM usuarios_seguidores WHERE id_usuario = :id_usuario";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":id_usuario", $this->__get('id'));
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getTotalSeguidores(){
        $query = "SELECT COUNT(*) as total_seguidores FROM usuarios_seguidores WHERE id_usuario_seguindo = :id_usuario";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":id_usuario", $this->__get('id'));
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }


    public function atualizarImagemTopo() {
        $query = "UPDATE usuarios SET imagem_topo = :imagem_topo WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":imagem_topo", $this->__get("imagem_topo"));
        $stmt->bindValue(":id", $this->__get("id"));
        $stmt->execute();
    }   
    
    public function getImagemTopo() {
        $query = "SELECT imagem_topo FROM usuarios WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":id", $this->__get("id"));
        $stmt->execute();
    
        return $stmt->fetch(\PDO::FETCH_ASSOC)["imagem_topo"];
    }

    public function atualizarNome(){
        $query = "UPDATE usuarios SET nome = :nome WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":nome", $this->__get("nome"));
        $stmt->bindValue(":id", $this->__get("id"));
        $stmt->execute();
    }
    
    
}