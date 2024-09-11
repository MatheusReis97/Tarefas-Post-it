<?php

require_once 'Classes/Database.php';
include 'header.php';

$database = new Database();
$db = $database->connect();

session_start();


?>
<main class="pagina-login">
    <br>
    <div class="login d-grid">
    <h2> ÁREA DE ACESSO 
    </h2>
     
    <form action="../process/user/login.php" method="post">
    <div class="mb-3">
    <?php 

    if(!empty($_SESSION['mensagemCadastro'])){
     echo $_SESSION['mensagemCadastro'] ;
     unset($_SESSION['mensagemCadastro']);
    }
     ?>
        <label for="login"  class="form-label">Login</label><br>
        <input type="text" class="form-control" id="email" name="email" required>   
    </div>
     <div class="mb-3">
        <label for="senha"  class="form-label">Senha</label><br>
        <input type="password" class="form-control" name="senha" id="senha" required><br>
        <?php 

    if(!empty($_SESSION['mensagemAlteracao'])){
     echo $_SESSION['mensagemAlteracao'] ;
     unset($_SESSION['mensagemAlteracao']);
    }
     ?>
        <button type="button" class="btn btn-outline" data-bs-toggle="modal" data-bs-target="#Senha" style="border: none; margin-bottom: 8px; margin-top: 4px">
        esqueci a senha
</button>
 

<div class="d-grid gap-3 col-6 mx-auto">
<button type="submit" class="btn btn-primary">Entrar</button> <br><br>
        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#Cadastrar">
        Cadastrar
</button>
</div>
    </div>
    </form>
    </div>

    
  

    <!-- modal senha -->
    <div class="modal fade" id="Senha" tabindex="-1" aria-labelledby="SenhaLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">TROCAR SENHA</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action="../process/user/AlterarSenha.php" method="POST">
    <label for="login">Nome</label>
    <input type="text" id="nome" name="nome" class="form-control" required><br>    
        <label for="senha">Email</label>
        <input type="email" name="email" id="email" class="form-control" required><br>
        <label for="senha">Nova Senha</label>
        <input type="password" name="senha" id="senha" class="form-control" required><br>  
    
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        <button type="submit" class="btn btn-primary">Alterar</button>
      </div>
      </form>
    </div>
  </div>
</div>
 <!-- fim modal senha -->

 <!-- CADASTRAR USUARIOS -->
 <div class="modal fade" id="Cadastrar" tabindex="-1" aria-labelledby="CadastrarLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">CADASTRAR NOVO</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action="../process/user/register.php" method="post">
    <label for="login">Nome</label>
    <input type="text" id="nome" name="nome" class="form-control" required>    <br>
 
        <label for="senha">Email</label>
        <input type="email" name="email" class="form-control" id="email" required > <br>

        <label for="senha">Senha</label>        
        <input type="password" name="senha"  class="form-control" id="senha" required> <br>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        <button type="submit" class="btn btn-primary">Criar</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- FIM CADASTRO DE USUARIO -->
    </main>

    </body>
    </html>