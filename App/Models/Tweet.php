<?php

namespace App\Models;

use MF\Model\Model;

class Tweet extends Model {

    private $id;
    private $id_usuario;
    private $tweet;
    private $data;
    private $img;
    public function __get($nome){
        return $this->$nome;
    }

    public function __set($nome, $valor){
        $this->$nome = $valor;
    }

    // Salvar
    public function salvar(){
        $tweet = $this->__get('tweet');
        $tweet = preg_replace('/[^a-zA-Z0-9\s]/', '', $tweet);

        $query = "INSERT INTO tweets(id_usuario, tweet, imagem_tweet) VALUES (:id_usuario, :tweet, :img)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
        $stmt->bindValue(':tweet', $tweet);
        $stmt->bindValue(':img', $this->__get('img'));
        $stmt->execute();

        return $this;
    }


    // Recuperar,
    public function recuperar($limit, $offset){
    
        $query = "SELECT t.id, t.id_usuario, t.tweet, u.nome, t.imagem_tweet, DATE_FORMAT(t.data, '%d/%m/%y %H:%m') as data FROM tweets as t LEFT JOIN usuarios as u ON t.id_usuario = u.id WHERE id_usuario = :id_usuario ORDER BY t.data DESC limit $limit offset $offset";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":id_usuario", $this->__get('id_usuario'));
        $stmt->execute();
        
        if($stmt->errorCode() != '00000') {
            print_r($stmt->errorInfo());
        }

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function recuperarPorPagina($limit, $offset){
    
        $query = "SELECT t.id, t.id_usuario, t.tweet, u.nome, t.imagem_tweet, DATE_FORMAT(t.data, '%d/%m/%y %H:%m') as data from tweets as t LEFT JOIN usuarios as u on t.id_usuario = u.id where id_usuario = :id_usuario or t.id_usuario in (SELECT id_usuario_seguindo from usuarios_seguidores where id_usuario = :id_usuario) order by t.data desc limit $limit offset $offset";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":id_usuario", $this->__get('id_usuario'));
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function recuperarSearchBy($search, $limit, $offset){
        $query = "
        SELECT t.id, t.id_usuario, t.tweet, u.nome, t.imagem_tweet, DATE_FORMAT(t.data, '%d/%m/%y %H:%i') as data FROM tweets as t LEFT JOIN usuarios as u ON t.id_usuario = u.id WHERE t.tweet LIKE :search LIMIT $limit OFFSET $offset ";
    
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(":search", '%' . $search . '%'); // Mó trampo pq n pode por isso aqui no like e tem q por aqui
    $stmt->execute();

    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function recuperarTotalRegistros(){
        
            $query = "SELECT count(*) as total from tweets where id_usuario = :id_usuario or id_usuario in (SELECT id_usuario_seguindo from usuarios_seguidores where id_usuario = :id_usuario)";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(":id_usuario", $this->__get('id_usuario'));
            $stmt->execute();
    
            return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function recuperarTotalRegistrosPerfil(){
        
        $query = "SELECT count(*) as total from tweets where id_usuario = :id_usuario";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":id_usuario", $this->__get('id_usuario'));
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
}

    public function removerTweet(){

        $query = "DELETE FROM tweets WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":id", $this->__get('id'));
        $stmt->execute();

        return $this;
    }

}
