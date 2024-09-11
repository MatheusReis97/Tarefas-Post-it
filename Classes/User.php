<?php

include_once 'Database.php';


class User{
private $conexao;
private $table = "tb_users";

public $id;
public $nome;
public $email;
public $senha;
public $imagem;

public function __construct($db) {
    $this->conexao = $db;
}
/* FUNÇÃO PARA REALIZAR NOVO REGISTROS NO BANCO DE DADOS;
QUERY - > É o comando basico do SQL : 
    {$this->table} =  está se referindo a tabela mensionada na linha 7; 
    SET = DEFINI QUE == nm_user (nome utilizado na tabela do bd) =:name (placeholders utilizado para capturar valor do formulario, porem como vai haver outro arquivo dentro do process, que irá realizar o tratamento do dados antes)

    $stmt-> $stmt é uma instância da classe PDOStatement quando você está usando PDO para interagir com o banco de dados.

    1 - Permite que o banco de dados analise e compile a consulta, sem executá-la imediatamente. Isso é útil para aumentar a segurança e a eficiência.
    2 - bindParam é usado para ligar variáveis PHP aos placeholders na consulta SQL preparada. Isso previne SQL Injection, já que os valores são escapados automaticamente pelo PDO.
    3 -  hash - para crypt a senha do usuario antes de ir para  o banco de dados;
    4 -  Especifica que o método fetch deve retornar cada linha como um array indexado pelo nome da coluna conforme retornado no conjunto de resultados correspondente.
    5 - Faz a comparação entre a senha inserida que está armazenada no $this->senha, , e o retorno da consulta com o $user;
*/
public function register() {
    $query = "INSERT INTO {$this->table} SET nm_nome=:nome, nm_email=:email, cd_senha=:senha";
    $stmt = $this->conexao->prepare($query); // 1

    $hashedPassword = password_hash($this->senha, PASSWORD_BCRYPT);

    $stmt->bindParam(":nome", $this->nome); // 2
    $stmt->bindParam(":email", $this->email);
    $stmt->bindParam(":senha", $hashedPassword); //3
    if($stmt->execute()) {
        return true;
    }
    return false;
}

public function login(){
    $query = "SELECT * FROM {$this->table} WHERE nm_email=:email";
    $stmt = $this->conexao->prepare($query);
    $stmt->bindParam(":email", $this->email);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
    $user = $stmt->fetch(PDO::FETCH_ASSOC); //4
    if(password_verify($this->senha, $user['cd_senha'])){//5
        $this->id = $user['id_user'];
        return $user;
    } else {
        return false;
    }    
    }else{
        echo "Usuario não encontrado!";
    }
}

public function TrocarSenha(){
    $query = "SELECT * FROM {$this->table} WHERE nm_email =:email AND nm_nome =:nome";
    $stmt = $this->conexao->prepare($query);
    $stmt->bindParam(":email", $this->email);
    $stmt->bindParam(":nome", $this->nome);
    $stmt->execute();
    if($stmt->rowCount()>0){
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user;
    } else {
        return false;
    }
}

public function alterarSenha(){
    $query = "UPDATE {$this->table} SET cd_senha =:senha WHERE id_user=:id";
    $stmt = $this->conexao->prepare($query);

    $hashedPassword = password_hash($this->senha, PASSWORD_BCRYPT);
    $stmt->bindParam(":id", $this->id);
    $stmt->bindParam(":senha", $hashedPassword);

    if($stmt->execute()){
        return true;
    } else {
        return false;
    }

}

public function leitura($id) {
    $query = "SELECT * FROM {$this->table} WHERE id_user = :id";
    $stmt = $this->conexao->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        return false;
    }
}



public function alterar($id){
    $query = "UPDATE {$this->table} SET  nm_nome = :nome, nm_email = :email, cd_senha = :senha , img_perfil =:imagem WHERE id_user=:id";
    $stmt = $this->conexao->prepare($query);
    $stmt->bindParam(':id', $this->id);
    $stmt->bindParam(':name', $this->nome);
    $stmt->bindParam(':email', $this->email);
    $stmt->bindParam(':password', password_hash($this->senha, PASSWORD_BCRYPT));
    $stmt->bindParam(':imagem', $this->imagem);

    if($stmt->execute()){
        Echo "alteração feita com sucesso";
    }
    else {
        Echo "Não foi possivel realizar alteração no usuario";
    }
}


public function alteracaoComplexa($camposAlterados){
    $set_alteracao = [];

    foreach ($camposAlterados as $campo => $valor){
        switch($campo){
            case 'nome':
                $set_alteracao[] = "nm_nome = :nome";
                break;
            case 'email':
                $set_alteracao[] = "nm_email = :email";
                break;
            case 'senha':
                $set_alteracao[] = "cd_senha = :senha";
                break;
            case 'imagem':
                $set_alteracao[] = "img_imagem = :imagem";
                break;
            }
    }

    $set_alteracao_srt = implode(',', $set_alteracao);


    $query = "UPDATE {$this->table} SET {$set_alteracao_srt} WHERE id_user=:id";
    $stmt = $this->conexao->prepare($query);



    $stmt->bindParam(':id', $this->id);

    foreach ($camposAlterados as $campo => $valor){
        $stmt->bindParam(":{$campo}", $valor);
    }
   
    if($stmt->execute()){
        return "alteração feita com sucesso";
    }
    else {
        return "Não foi possivel realizar alteração no usuario";
    }
}



}
