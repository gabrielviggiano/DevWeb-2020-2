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
    if(isset($_GET["pesquisa"])){
        $nome_estoque = $_GET["pesquisa"];
        $select .= "WHERE NM_ESTOQUE LIKE '%{$nome_estoque}%' ";
    }
    $lista_estoques = mysqli_query ($conecta, $select);
    if(!$lista_estoques){
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
        <br>
        <?php
            while ($linha = mysqli_fetch_assoc($lista_estoques)){
        ?>
            <div class="card">
                <div class="card-header">
                    <?php echo "Estoque ", $linha["ID_ESTOQUE"]; ?>
                </div>
                <div class="card-body">
                    <h5 class="card-title"><?php echo "Nome: ", $linha["NM_ESTOQUE"]; ?></h5>
                    <p class="card-text"><?php echo $linha["DS_ESTOQUE"]; ?></p>
                    <a href="#" class="btn btn-outline-primary">Visualizar Informações</a>
                    <a href="CONTROLE_ESTOQUE.php?ID_ESTOQUE=<?php echo $linha["ID_ESTOQUE"]; ?>" class="btn btn-outline-primary">Acessar Estoque</a>
                </div>
            </div>
            <br>
        <?php } ?>

        
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