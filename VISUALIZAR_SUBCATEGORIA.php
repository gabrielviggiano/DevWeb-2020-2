<?php 
    require_once("conexao/conexao.php");
    //todo arquivo precisa ter este cod

    //Códio que verifica o usuário de sessão, toda página deverá conter esse trecho
    session_start();
    if(!isset($_SESSION["user_system"])){
        header("location:index.php");
    }
?>


<?php

    $select = "SELECT * FROM CATEGORIA ";
    if(isset($_GET["id_categoria"])){
        $id = $_GET["id_categoria"];
        if($id != ''){
            $select .= "WHERE ID_CATEGORIA = {$id} ";
        }
    }
    $recupera_pai = mysqli_query ($conecta, $select);
    if(!$recupera_pai){
        die("Erro no Banco!");
    }

?>

<?php
    $select = "SELECT ID_SUB_CATEGORIA, NM_SUB_CATEGORIA, DS_SUB_CATEGORIA, ID_CATEGORIA FROM SUB_CATEGORIA ";
    
    if(isset($_GET["id_categoria"])){
        $id = $_GET["id_categoria"];
        if($id != ''){
            $select .= "WHERE ID_CATEGORIA = {$id} ";
        }
    }
    if(isset($_GET["pesquisa"])){
        $pesquisa = $_GET["pesquisa"];
        $select .= "WHERE NM_SUB_CATEGORIA LIKE '%{$pesquisa}%' OR ";
        $select .= "DS_SUB_CATEGORIA LIKE '%{$pesquisa}%' ";
    }
    $lista_sub_categoria = mysqli_query ($conecta, $select);
    if(!$lista_sub_categoria){
        die("Erro no Bancos!");
    }

?>

<!DOCTYPE html>
    <head>
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
        <link href="arquivo.css" rel="stylesheet">
        <link href="bootstrap-4.5.3-dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="bootstrap-4.5.3-dist/js/bootstrap.min.js">
        <meta charset="utf-8">
        <div id="header">
            
        </div>
    </head>

    <body>
        <div>
            <br>
        </div>
    
        <div class="card">
        <div class="card-header">
            
            <?php $linha = mysqli_fetch_assoc($recupera_pai) ?>
            <h3>Categoria: <?php echo $linha["NM_CATEGORIA"] ?></h3>
        </div>

        <div class="card-body">

            <!--- Título --->
            <div class="d-flex justify-content-between mb-3">
                <h4>
                    Sub Categorias Cadastradas
                </h4>
                <a class="btn btn-primary ml-auto mb-2" href="CAD_SUB_CATEGORIA.php?id_categoria=<?php echo $_GET["id_categoria"]; ?>">Nova Sub Categoria</a>
            </div>
            <?php $num_rows = mysqli_num_rows($lista_sub_categoria); ?>
            <?php if($num_rows > 0) { ?>

                <table class="table table-bordered table-striped small">
                    <thead class="thead-light text-center">
                        <!--- Cabeçalho da tabela --->
                        <tr>
                            <th>Código</th>
                            <th>Nome da Categoria</th>
                            <th>Descrição da Categoria</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            while ($linha = mysqli_fetch_assoc($lista_sub_categoria)){
                        ?>
                        <tr>
                            <td><a href="CAD_SUB_CATEGORIA.php?id_categoria=<?php echo $linha["ID_CATEGORIA"]?>&id_sub_categoria=<?php echo $linha["ID_SUB_CATEGORIA"]?>&acao=alterar"> <?php echo $linha["ID_SUB_CATEGORIA"]?> </a>   </td>
                            <td> <?php echo $linha["NM_SUB_CATEGORIA"]?>    </td> 
                            <td> <?php echo $linha["DS_SUB_CATEGORIA"]?> </td>
                            <td>
                                <!--- Botão de excluir --->
                                <a class="btn p-0" title="Excluir" href="CAD_SUB_CATEGORIA.php?id_sub_categoria=<?php echo $linha["ID_SUB_CATEGORIA"]?>&id_categoria=<?php echo $linha["ID_CATEGORIA"]?>&acao=excluir">
                                    <!--- Ícone de excluir --->
                                    <svg id="i-trash" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="20" height="20" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                        <path d="M28 6 L6 6 8 30 24 30 26 6 4 6 M16 12 L16 24 M21 12 L20 24 M11 12 L12 24 M12 6 L13 2 19 2 20 6" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                        <?php
                            }
                        ?>
                    </tbody>
                </table>

            <?php }else{ ?>
                
                <div class="alert alert-secondary mb-3" role="alert">
                    Nenhum item cadastrado.
                </div>
            
            <?php } ?>

        </div>

        <div class="card-footer d-flex">
            <a class="btn mr-auto" title="voltar" href="VISUALIZAR_CATEGORIA.php">
                <!--- Ícone de voltar --->
                <svg id="i-arrow-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="32" height="32" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                    <path d="M10 6 L2 16 10 26 M2 16 L30 16" />
                </svg>
            </a>
        </div>
    </div>

    </body>

    <style>
        .card{
            width: 60%;
            margin: auto;
        }
    </style>

    <script> 
        $(function(){
        console.log('init');
        $("#header").load("header.php"); 
        });
    </script>


</html>

<?php
mysqli_close($conecta);
?>