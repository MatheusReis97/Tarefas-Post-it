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
 $usuario->email = $_POST['email'];
 $usuario->senha = $_POST['senha'];


 $user = $usuario->login();

 if ($user) {
  
   $_SESSION['login'] = $usuario->email;
   $_SESSION['senha'] = $usuario->senha;
   $_SESSION['user_id'] = $user['id_user'];
   header('location:../../views/home.php');
 }else{
    $status = "Error";
    MensagemCadastro($status);
    header("Location: ../../index.php");
exit();
 }
} else {
  $status = "Error";
  MensagemCadastro($status);
  header("Location: ../../index.php");
exit();
}

// Verifica se $_POST está vazio e armazena o resultado em $forms
$forms[] = empty($_POST);





function MensagemCadastro ($status){
  $mensagem = $status ; 

  if($mensagem == "Error"){
     $_SESSION['mensagemCadastro'] = "<div class='alert alert-danger  alert-dismissible fade show' role='alert'>
 <strong>Houve erro de login/senha no login!</strong> 
 <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>";
  }
 
}