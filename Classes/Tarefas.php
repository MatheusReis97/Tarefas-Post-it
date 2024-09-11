<?php

include_once 'Database.php';

Class Tarefa{

    private $conexao;
    private $table ="tb_tasks";

    private $id;
    public $titulo;
    public $texto;
    public $criacao;
    public $vencimento;
    public $situacao;
    public $user;


    public function __construct($db) {
        $this->conexao = $db;
}


    public function CriarTarefa (){
        $query = "INSERT INTO {$this->table} (nm_titulo, text_descricao, dt_criacao, dt_vencimento, nm_status, id_user) 
              VALUES (:titulo, :texto, :criacao, :vencimento, :situacao, :id_user)";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(":titulo", $this->titulo);
        $stmt->bindParam(":texto", $this->texto);
        $stmt->bindParam(":criacao", $this->criacao);
        $stmt->bindParam(":vencimento", $this->vencimento);
        $stmt->bindParam(":situacao", $this->situacao);
        $stmt->bindParam(":id_user", $this->user);
      
        if($stmt->execute()){
            return "Post Criado com sucesso";
        } else {
            return "Não Foi possivel criar POST-IT";
        }
    }
     

    public function lerTarefasUsuario($id) {
        $query = "SELECT * FROM {$this->table} WHERE id_user = :id_user";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(":id_user", $id);
        $stmt->execute();
            
        if ($stmt->rowCount() > 0) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }

    public function lerTarefaPorId($id) {
       
        $query = "SELECT * FROM {$this->table} WHERE id_tasks = :id";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }


    public function editarTarefa($id){
        
        $query = "UPDATE {$this->table} SET  nm_titulo = :titulo, text_descricao = :texto, dt_criacao = :criacao , dt_vencimento =:vencimento, nm_status =:situacao WHERE id_tasks=:id";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(":titulo", $this->titulo);
        $stmt->bindParam(":texto", $this->texto);
        $stmt->bindParam(":criacao", $this->criacao);
        $stmt->bindParam(":vencimento", $this->vencimento);
        $stmt->bindParam(":situacao", $this->situacao);
        $stmt->bindParam(":id", $id);
        if($stmt->execute()){
            return true;
        }
        else {
            return false;
        }
    }
    

    public function ApagarTarefa($id){
        $query = "DELETE FROM {$this->table} WHERE id_tasks = :id";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(':id', $id);
        if($stmt->execute()){
            
            return true;
        }
        else
        {
          
            return false;
        }

       
    }
    
    public function alteracaoComplexa($camposAlterados){
        $set_alteracao = [];
        $set_parametro =[];
        $id_alterado = $camposAlterados['id'];

        
        foreach ($camposAlterados as $campo => $valor){
            switch($campo){
                case 'nm_titulo':
                    $set_alteracao[] = "nm_titulo = :titulo";
                    $set_parametro[':titulo'] = $valor;
                    break;
                case 'text_descricao':
                    $set_alteracao[] = "text_descricao = :texto";
                    $set_parametro[':texto'] = $valor;
                    break;
                case 'dt_criacao':
                    $set_alteracao[] = "dt_criacao = :criacao";
                    $set_parametro[':criacao'] = $valor;
                    break;
                case 'dt_vencimento':
                    $set_alteracao[] = "dt_vencimento = :vencimento";
                    $set_parametro[':vencimento'] = $valor;
                    break;
                case 'nm_status':
                    $set_alteracao[] = "nm_status = :situacao";
                    $set_parametro[':situacao'] = $valor;
                    break;
                case 'id':
                    // Se precisar adicionar algo para 'id', pode adicionar aqui
                    break;
                }
        }
    
        $set_alteracao_srt = implode(',', $set_alteracao);
    
    
        $query = "UPDATE {$this->table} SET {$set_alteracao_srt} WHERE id_tasks=:id";
        $stmt = $this->conexao->prepare($query);
    
       
        $stmt->bindValue(':id', $id_alterado);
        
       
        foreach ($set_parametro as $campo => $valor){
            $stmt->bindValue($campo, $valor);
        }
    
       
       

        if($stmt->execute()){
            return true;
        }
        else {
            return false;
        }
    }

    public function ConcluirPost($id){
        $situacao = 'Concluido';
        $query = "UPDATE {$this->table} SET nm_status =:situacao WHERE id_tasks=:id";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(':id' , $id);
        $stmt->bindParam(':situacao', $situacao);
        if($stmt->execute()){            
            return true;
        }
        else
        {
            return false;
        }       
    }

    public function IniciarPost($id){
        $situacao = 'Em andamento';
        $query = "UPDATE {$this->table} SET nm_status =:situacao WHERE id_tasks=:id";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(':id' , $id);
        $stmt->bindParam(':situacao', $situacao);
        if($stmt->execute()){            
            return true;
        }
        else
        {
            return false;
        }       
    }
    
}