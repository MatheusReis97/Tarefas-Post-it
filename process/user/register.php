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
 $usuario->senha = $_POST['senha'];
 $usuario->email = $_POST['email'];

 if($usuario->register()){
   $status = "criado";
   MensagemCadastro($status);  
 }else{
   $status = "Não criado";
   MensagemCadastro($status); 
 }
} else {
    echo "Não foi possivel realizar o login";
}

header("Location: ../../index.php");
exit();

function MensagemCadastro ($status){
   $mensagem = $status ; 

   if($mensagem == "criado"){
      $_SESSION['mensagemCadastro'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
  <strong>Cadastro Realizado com sucesso!</strong> 
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>";
   }
   else{
      $_SESSION['mensagemCadastro'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
      <strong>Cadastro não realizado, verifique os dados inseridos!</strong> 
      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>";

   }
}