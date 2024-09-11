<?php

// preparando informações para serem utilizada para na coxeção,
// caso troque tabela,  ou area de utilização, atentar-se que será nesse arquivo que deverá ser realizado a mudança para que a conexao seja realizada corretamente com o banco de dados;
return [
    'host' => 'localhost',
    'db_name' => 'db_post-it',
    'username' => 'root',
    'password' => '',
    // opcional, passar o option, caso não queira passar ele diretamente na fuction de conexão;
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ],
];


