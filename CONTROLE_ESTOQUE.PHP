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
    $select = "SELECT ID_ESTOQUE, NM_ESTOQUE, DS_ESTOQUE, ID_QTD_DIVISORIA, ";
    $select .= "(SELECT NM_TP_ESTOQUE FROM TIPO_ESTOQUE WHERE ESTOQUE.ID_TP_ESTOQUE = TIPO_ESTOQUE.ID_TP_ESTOQUE) AS NM_TP_ESTOQUE ";
    $select .= "FROM ESTOQUE ";
    if(isset($_GET["ID_ESTOQUE"])){
        $id_estoque = $_GET["ID_ESTOQUE"];
        $select .= "WHERE ID_ESTOQUE = {$id_estoque}";
    }
    $lista_estoques = mysqli_query ($conecta, $select);
    $recupera = mysqli_fetch_assoc($lista_estoques);
    if(!$lista_estoques){
        die("Erro no Banco!");
    }

?>


<?php
    $select = "SELECT ID_ITEM_ESTOQUE, DS_ITEM_ESTOQUE, QTD_PRODUTO, ID_ESTOQUE, ";
    $select .= "(SELECT DS_DIVISORIA FROM DIVISORIA_ESTOQUE WHERE CONTROLE_ESTOQUE.ID_DIVISORIA = DIVISORIA_ESTOQUE.ID_DIVISORIA) AS DS_DIVISORIA, ";
    $select .= "(SELECT DS_UNIDADE_MEDIDA FROM TP_UNIDADE_MEDIDA WHERE CONTROLE_ESTOQUE.ID_UNIDADE_MEDIDA = TP_UNIDADE_MEDIDA.ID_UNIDADE_MEDIDA) AS DS_UNIDADE_MEDIDA, ";
    $select .= "(SELECT NM_PRODUTO FROM PRODUTO WHERE CONTROLE_ESTOQUE.ID_PRODUTO = PRODUTO.ID_PRODUTO) AS NM_PRODUTO, ";
    $select .= "(SELECT NM_ESTOQUE FROM ESTOQUE WHERE CONTROLE_ESTOQUE.ID_ESTOQUE = ESTOQUE.ID_ESTOQUE) AS NM_ESTOQUE ";
    $select .= "FROM CONTROLE_ESTOQUE ";
    if(isset($_GET["ID_ESTOQUE"])){
        $id_estoque = $_GET["ID_ESTOQUE"];
        $select .= "WHERE ID_ESTOQUE = {$id_estoque}";
    }
    $lista_estoques2 = mysqli_query ($conecta, $select);
    if(!$lista_estoques2){
        die("Erro no Banco!");
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
                <h2>Gerenciamento de Estoque</h2>
            </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">


                        <h3><?php echo $recupera["NM_ESTOQUE"];?> </h3>


                        <!--- Botão de novo --->
                        <a href="CAD_ITEM_ESTOQUE.php?ID_ESTOQUE=<?php echo $_GET["ID_ESTOQUE"]; ?>" class="btn btn-primary ml-auto">Adicionar Item no Estoque</a>
                    </div>

                    <table class="table table-bordered table-striped small">
                    <thead class="thead-light text-center">
                        <!--- Cabeçalho da tabela --->
                        <tr>
                            <th>Identificação do Item</th>
                            <th>  Produto </th>
                            <th>  Descrição do Item  </th>
                            <th>  Quantidade </th>
                            <th>  Localização do Item no Estoque </th>
                            <th>  Unidade de Medida </th>
                            <th>  Nome do Estoque </th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            while ($linha = mysqli_fetch_assoc($lista_estoques2)){
                        ?>
                        <tr>
                            <td><a href="CAD_ITEM_ESTOQUE.php?ID_ESTOQUE=<?php echo $linha["ID_ITEM_ESTOQUE"]?>&acao=alterar"> <?php echo $linha["ID_ITEM_ESTOQUE"]?> </a>   </td>
                            <td> <?php echo $linha["NM_PRODUTO"]?> </td>
                            <td> <?php echo $linha["DS_ITEM_ESTOQUE"]?> </td>
                            <td> <?php echo $linha["QTD_PRODUTO"]?> </td>
                            <td> <?php echo $linha["DS_DIVISORIA"]?> </td>
                            <td> <?php echo $linha["DS_UNIDADE_MEDIDA"]?> </td>
                            <td> <?php echo $linha["NM_ESTOQUE"]?> </td>
                            <td>
                            <!--- Botão de excluir --->
                            <a class="btn p-0" title="Excluir" href="CAD_ITEM_ESTOQUE.php?ID_ESTOQUE=<?php echo $linha["ID_ESTOQUE"]?>&acao=excluir">
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