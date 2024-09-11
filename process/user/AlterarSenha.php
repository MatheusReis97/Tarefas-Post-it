<?php


// Incluindo a classe de usuário e a classe de conexão com o banco de dados
include_once '../../Classes/Database.php';
include_once '../../Classes/User.php';

session_start();


if (!empty($_POST)) {
    
    // Conecte-se ao banco de dados
    $database = new Database();
    $db = $database->connect();
    
     // Crie uma instância da classe Usuario
     $usuario = new User($db);
    
     // Preencha as variáveis da classe com os dados do formulário
     $usuario->nome = $_POST['nome'];
     $usuario->email = $_POST['email'];
     $usuario->senha = $_POST['senha'];

     $Consulta = $usuario->TrocarSenha();
     
     if ($Consulta){
        $usuario->id = $Consulta['id_user'];

        $alteracao = $usuario->alterarSenha();
        
        if($alteracao){
           $status = "Alterada";           
           MensagemAlteracao($status);

        } else 
        {
            $status = "Não alterada";           
            MensagemAlteracao($status);
        }
     }else {
        $status = "Não alterada";           
        MensagemAlteracao($status);
     }
    
}



function MensagemAlteracao($status){
    $mensagem = $status ; 
 
    if($mensagem == "Alterada"){
       $_SESSION['mensagemAlteracao'] = "<div class='alert alert-success  alert-dismissible fade show' role='alert'>
   <strong>Senha alterada com sucesso!</strong> 
   <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
 </div>";
    }
    else{
       $_SESSION['mensagemAlteracao'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
       <strong>Senha não alterada, verifique os dados inseridos!</strong> 
       <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
     </div>";
 
    }
 }