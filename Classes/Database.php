<?php 

class Database{
  
    private $host;
    private $db_base;
    private $login;
    private $senha; 

    private $options;

    public $conexao;

    public function __construct(){
            $config = include_once __DIR__ . '/../config/connection.php';
            $this->host=$config['host'];
            $this->db_base=$config['db_name'];
            $this->login=$config['username'];
            $this->senha=$config['password'];
            $this->options=$config['options'];

    }

    public function connect (){
        $this->conexao = null;

    try {
    $this->conexao = new PDO("mysql:host=".$this->host .";dbname=".$this->db_base, $this->login, $this->senha, $this->options);
    
    } catch (PDOException $e) {
    echo "Erro ao conectar: " . $e->getMessage();
    }

    return $this->conexao;
    }
        

}