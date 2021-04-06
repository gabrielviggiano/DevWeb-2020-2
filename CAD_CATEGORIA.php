<!DOCTYPE html>
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
    if(isset($_GET["acao"])){
        $acao = $_GET["acao"];
    }else{
        $acao = 'inserir';
    }
?>
    
<?php 
    //insercao
    if(isset($_POST["inserir"])){
        if(isset($_POST["categoria"])){
            $nome = $_POST["categoria"];
            $descricao = $_POST["descricao"];

            $inserir = "INSERT INTO CATEGORIA ";
            $inserir .= "(NM_CATEGORIA, DS_CATEGORIA) ";
            $inserir .= "VALUES ";
            $inserir .= "('$nome','$descricao')";

            $operacao_inserir = mysqli_query($conecta,$inserir);
            if(!$operacao_inserir){
                die("Erro no Banco!");
            }else{
                echo '<script language="javascript">';
                echo 'alert("Categoria cadastrada com sucesso!")';
                echo '</script>';
            }
        }
        header("location:VISUALIZAR_CATEGORIA.php");
    }
?>

<?php
    if($acao != 'inserir'){
        $select = "SELECT * FROM CATEGORIA ";
        if(isset($_GET["id_categoria"])){
            $id = $_GET["id_categoria"];
            $select .= "WHERE ID_CATEGORIA = {$id} ";
        }

        $lista_categorias = mysqli_query($conecta, $select);
        if(!$lista_categorias){
            die("Erro no Banco!");
        }

        $info_categoria = mysqli_fetch_assoc($lista_categorias);
    }
?>

<?php 
    //atualizacao
    if(isset($_POST["atualizar"])){
        if(isset($_POST["categoria"])){
            $categoria = $_POST["categoria"];
            $descricao = $_POST["descricao"];

            $alterar = "UPDATE CATEGORIA ";
            $alterar .= "SET ";
            $alterar .= "NM_CATEGORIA = '{$categoria}', DS_CATEGORIA = '{$descricao}' ";
            $alterar .= "WHERE ID_CATEGORIA = '{$id}'";

            $operacao_alterar = mysqli_query($conecta,$alterar);
            if(!$operacao_alterar){
                die("Erro no Banco!");
            }
        }
        header("location:VISUALIZAR_CATEGORIA.php");
    }
?>

<?php 
    //exclusao
    if(isset($_POST["exclusao"])){
        if(isset($_POST["categoria"])){

            $excluir = "DELETE ";
            $excluir .= "FROM CATEGORIA ";
            $excluir .= "WHERE ID_CATEGORIA = '{$id}'";

            $operacao_excluir = mysqli_query($conecta,$excluir);
            if(!$operacao_excluir){
                die("Registro não excluido");
            }else{
                header("location:VISUALIZAR_CATEGORIA.php");
            }
        }
        
    }
?>

<!DOCTYPE html>
    <head>
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
        <link href="arquivo.css" rel="stylesheet">
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="bootstrap/js/bootstrap.min.js">

        <meta charset="utf-8">
        <div id="header">
            
        </div>
    </head>

    <body>
        <div>
            <br>
        </div>
        <form class="card" name="form" method="POST"> 
            <div class="card-header">
                <h3>
                    <?php if($acao == 'inserir') {?>
                        Cadastrar Categoria
                    <?php }elseif($acao == 'alterar') {?>
                        Atualizar Categoria
                    <?php }else{ ?>
                        Excluir Registro?
                    <?php } ?>
                    
                </h3>
            </div>

            <div class="card-body">
                <div class="form-group">
                    <label>Nome da Categoria<span title="Campo obrigatório" class="text-danger">*</span></label>
                    <input name="categoria" value="<?php if($acao != 'inserir'){ echo $info_categoria["NM_CATEGORIA"];}?>" type="text" maxlength="50" required class="form-control form-control-sm" <?php if($acao == 'excluir'){ ?> readonly <?php } ?>>
                </div>

                <div class="form-group">
                    <label>Descrição da Categoria<span title="Campo obrigatório" class="text-danger">*</span></label>
                    <input name="descricao" value="<?php if($acao != 'inserir'){ echo $info_categoria["DS_CATEGORIA"];}?>" type="text" maxlength="50" required class="form-control form-control-sm" <?php if($acao == 'excluir'){ ?> readonly <?php } ?>>
                </div>
    
            </div>

            <div class="card-footer d-flex justify-content-between mb-3">
                <a class="btn mr-auto" title="voltar" href="VISUALIZAR_CATEGORIA.php">
                    <!--- Ícone de voltar --->
                    <svg id="i-arrow-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="32" height="32" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                        <path d="M10 6 L2 16 10 26 M2 16 L30 16" />
                    </svg>
                </a>
                <?php if($acao == 'inserir'){ ?>                  
                    <button name="inserir" type="submit" class="btn btn-primary">Salvar</button>
                <?php }elseif($acao == 'alterar'){?>
                    <button name="atualizar" type="submit" class="btn btn-primary">Atualizar</button>
                <?php }else{ ?>
                    <button name="exclusao" type="submit" class="btn btn-danger">Excluir</button>
                <?php } ?>

            </div>
        </form>
    

    

    </body>

    <style>
        .card{
            width: 80%;
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