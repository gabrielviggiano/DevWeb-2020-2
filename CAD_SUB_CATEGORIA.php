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
        if(isset($_POST["sub_categoria"])){
            $nome = $_POST["sub_categoria"];
            $descricao = $_POST["descricao"];
            $id = $_GET["id_categoria"];

            $inserir = "INSERT INTO SUB_CATEGORIA ";
            $inserir .= "(NM_SUB_CATEGORIA, DS_SUB_CATEGORIA, ID_CATEGORIA) ";
            $inserir .= "VALUES ";
            $inserir .= "('$nome','$descricao', '$id')";

            $operacao_inserir = mysqli_query($conecta,$inserir);
            if(!$operacao_inserir){
                die("Erro no Banco!");
            }else{
                echo '<script language="javascript">';
                echo 'alert("Sub Categoria cadastrada com sucesso!")';
                echo '</script>';
            }
        }
        $id = $_GET["id_categoria"];
        header("location:VISUALIZAR_SUBCATEGORIA.php?id_categoria=$id");
    }
?>

<?php
    if($acao != 'inserir'){
        $select = "SELECT * FROM SUB_CATEGORIA ";
        if(isset($_GET["id_sub_categoria"])){
            $id_sub = $_GET["id_sub_categoria"];
            if($id_sub != ''){
                $select .= "WHERE ID_SUB_CATEGORIA = {$id_sub} ";
            }
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
        if(isset($_POST["sub_categoria"])){
            $categoria = $_POST["sub_categoria"];
            $descricao = $_POST["descricao"];

            $alterar = "UPDATE SUB_CATEGORIA ";
            $alterar .= "SET ";
            $alterar .= "NM_SUB_CATEGORIA = '{$categoria}', DS_SUB_CATEGORIA = '{$descricao}' ";
            $alterar .= "WHERE ID_SUB_CATEGORIA = '{$id_sub}'";

            $operacao_alterar = mysqli_query($conecta,$alterar);
            if(!$operacao_alterar){
                die("Erro no Banco!");
            }
        }
        $id = $_GET["id_categoria"];
        header("location:VISUALIZAR_SUBCATEGORIA.php?id_categoria=$id");
    }
?>

<?php 
    //exclusao
    if(isset($_POST["exclusao"])){
        if(isset($_POST["sub_categoria"])){

            $excluir = "DELETE ";
            $excluir .= "FROM SUB_CATEGORIA ";
            $excluir .= "WHERE ID_SUB_CATEGORIA = '{$id_sub}'";

            $operacao_excluir = mysqli_query($conecta,$excluir);
            if(!$operacao_excluir){
                die("Registro não excluido");
            }else{
                $id = $_GET["id_categoria"];
                header("location:VISUALIZAR_SUBCATEGORIA.php?id_categoria=$id");
            }
        }
        
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
        <form class="card" name="form" method="POST"> 
            <div class="card-header">
                <h3>
                    <?php if($acao == 'inserir') {?>
                        Cadastrar Sub Categoria
                    <?php }elseif($acao == 'alterar') {?>
                        Atualizar Sub Categoria
                    <?php }else{ ?>
                        Excluir Sub Categoria?
                    <?php } ?>
                    
                </h3>
            </div>

            <div class="card-body">
                <div class="form-group">
                    <label>Nome da Sub Categoria<span title="Campo obrigatório" class="text-danger">*</span></label>
                    <input name="sub_categoria" value="<?php if($acao != 'inserir'){ echo $info_categoria["NM_SUB_CATEGORIA"];}?>" type="text" maxlength="50" required class="form-control form-control-sm" <?php if($acao == 'excluir'){ ?> readonly <?php } ?>>
                </div>

                <div class="form-group">
                    <label>Descrição da Sub Categoria<span title="Campo obrigatório" class="text-danger">*</span></label>
                    <input name="descricao" value="<?php if($acao != 'inserir'){ echo $info_categoria["DS_SUB_CATEGORIA"];}?>" type="text" maxlength="100" required class="form-control form-control-sm" <?php if($acao == 'excluir'){ ?> readonly <?php } ?>>
                </div>
    
            </div>

            <div class="card-footer d-flex justify-content-between mb-3">
                <a class="btn mr-auto" title="voltar" href="VISUALIZAR_SUBCATEGORIA.php?id_categoria=<?php echo $_GET["id_categoria"]; ?>">
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