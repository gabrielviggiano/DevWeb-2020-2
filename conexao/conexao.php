<?php
    // passo 1
    $servidor = "localhost";
    $usuario = "root";
    $senha = "";
    $banco = "estoque_gm";
    $conecta = mysqli_connect($servidor, $usuario,$senha, $banco);

    // passo 2
    // funcao para mostrar erro caso de algum problema
    if(mysqli_connect_errno() ){
        die("Conexão falhou: " . mysqli_connect_errno());
    }
    

?>
