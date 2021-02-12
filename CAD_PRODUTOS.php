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
        if(isset($_POST["produto"])){
            $produto = $_POST["produto"];
            $descricao = $_POST["descricao"];
            $categoria = $_POST["select_categoria"];
            $sub_categoria = $_POST["sub_categoria"];

            $inserir = "INSERT INTO PRODUTO ";
            $inserir .= "(NM_PRODUTO, DS_PRODUTO, ID_CATEGORIA, ID_SUB_CATEGORIA) ";
            $inserir .= "VALUES ";
            $inserir .= "('$produto', '$descricao', $categoria, $sub_categoria)";

            $operacao_inserir = mysqli_query($conecta,$inserir);
            if(!$operacao_inserir){
                die("Erro no Banco!");
            }
        }
        header("location:VISUALIZAR_PRODUTOS.php");
    }
?>

<?php
    if($acao != 'inserir'){
        $select = "SELECT * FROM PRODUTO ";
        if(isset($_GET["id_produto"])){
            $id = $_GET["id_produto"];
            $select .= "WHERE ID_PRODUTO = {$id} ";
        }

        $lista_produtos = mysqli_query($conecta, $select);
        if(!$lista_produtos){
            die("Erro no Banco!");
        }

        $info_produtos = mysqli_fetch_assoc($lista_produtos);
    }
?>

<?php 
    //atualizacao
    if(isset($_POST["atualizar"])){
        if(isset($_POST["produto"])){
            $produto = $_POST["produto"];
            $descricao = $_POST["descricao"];
            $categoria = $_POST["select_categoria"];
            $sub_categoria = $_POST["sub_categoria"];

            $alterar = "UPDATE PRODUTO ";
            $alterar .= "SET ";
            $alterar .= "NM_PRODUTO = '{$produto}', DS_PRODUTO = '{$descricao}', ID_CATEGORIA = '{$categoria}', ID_SUB_CATEGORIA = '{$sub_categoria}' ";
            $alterar .= "WHERE ID_PRODUTO = '{$id}'";

            $operacao_alterar = mysqli_query($conecta,$alterar);
            if(!$operacao_alterar){
                die("Erro no Banco!");
                var_dump($alterar);
                
            }
        }
        header("location:VISUALIZAR_PRODUTOS.php");
    }
?>


<?php 
    //exclusao
    if(isset($_POST["exclusao"])){
        if(isset($_POST["produto"])){

            $excluir = "DELETE ";
            $excluir .= "FROM PRODUTO ";
            $excluir .= "WHERE ID_PRODUTO = '{$id}'";

            $operacao_excluir = mysqli_query($conecta,$excluir);
            if(!$operacao_excluir){
                die("Produto não excluido");
            }else{
                header("location:VISUALIZAR_PRODUTOS.php");
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
        <link href="css/select2.min.css" rel="stylesheet" />
        <script src="js/select2.min.js"></script>
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
                        Cadastrar Produto
                    <?php }elseif($acao == 'alterar') {?>
                        Atualizar Produto
                    <?php }else{ ?>
                        Excluir Produto?
                    <?php } ?>
                    
                </h3>
            </div>

            <div class="card-body">
                <div class="form-group">
                    <label>Produto<span title="Campo obrigatório" class="text-danger">*</span></label>
                    <input name="produto" value="<?php if($acao != 'inserir'){ echo $info_produtos["NM_PRODUTO"];}?>" type="text" maxlength="50" required class="form-control form-control-sm" <?php if($acao == 'excluir'){ ?> readonly <?php } ?>>
                </div>
                <div class="form-group">
                    <label>Descrição<span title="Campo obrigatório" class="text-danger">*</span></label>
                    <input name="descricao" value="<?php if($acao != 'inserir'){ echo $info_produtos["DS_PRODUTO"];}?>" type="text" maxlength="50" required class="form-control form-control-sm" <?php if($acao == 'excluir'){ ?> readonly <?php } ?>>
                </div>

                
                <div class="form-row align-items-center">
                    <div class="col-auto my-1">
                        <label for="select_categoria">Categoria<span title="Campo obrigatório" class="text-danger">*</span></label>
                        
                        <?php
                            $select = "SELECT * ";
                            $select .= "FROM CATEGORIA";
                            $lista_categorias = mysqli_query ($conecta, $select);
                            if(!$lista_categorias){
                                die("Erro no Banco!");
                            }
                        ?> 
                    
                        <select name="select_categoria" class="select_categoria" style="width: 100%; margin: auto;">
                        <option value="0"></option>
                        <?php
                            while ($linha = mysqli_fetch_assoc($lista_categorias)){
                                if($linha['ID_CATEGORIA'] != 0){

                                
                        ?>
                            <option value="<?php echo $linha["ID_CATEGORIA"]?>" <?php if($acao != 'inserir' and ($linha["ID_CATEGORIA"] == $info_produtos["ID_CATEGORIA"])){?> selected <?php } ?> > <?php echo $linha["NM_CATEGORIA"]?></option>
                        <?php
                            }
                                }
                        ?>
                        </select>
                    </div>
                </div>

                <script>
                    $(document).ready(function() {
                        $(".select_categoria").select2();
                    });
                </script>

                <div class="form-row align-items-center">
                    <div class="col-auto my-1">
                        <label for="sub_categoria">Sub Categoria<span title="Campo obrigatório" class="text-danger">*</span></label>

                        <?php
                            $select = "SELECT * ";
                            $select .= "FROM SUB_CATEGORIA";
                            $lista_sub_categorias = mysqli_query ($conecta, $select);
                            if(!$lista_sub_categorias){
                                die("Erro no Banco!");
                            }
                        ?> 
                        
                        <select name="sub_categoria" class="select_sub_categoria" id="sub_categoria" style="width: 100%; margin: auto;">
                        <option value="0"></option>
                        <?php
                            while ($linha2 = mysqli_fetch_assoc($lista_sub_categorias)){
                                if($linha2['ID_SUB_CATEGORIA'] != 0){
                        ?>
                            <option value="<?php echo $linha2["ID_SUB_CATEGORIA"]?>" <?php if($acao != 'inserir' and ($linha2["ID_SUB_CATEGORIA"] == $info_produtos["ID_SUB_CATEGORIA"])){?> selected <?php } ?> > <?php echo $linha2["NM_SUB_CATEGORIA"]?></option>
                        <?php
                            }
                                }
                        ?>
                        </select>
                    </div>
                </div>
                <script>
                    $(document).ready(function() {
                        $(".select_sub_categoria").select2();
                    });
                </script>
            </div>

            <div class="card-footer d-flex">
                <a class="btn mr-auto" title="voltar" href="VISUALIZAR_PRODUTOS.php">
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
          $("#header").load("header.html"); 
        });
    </script>

</html>

<?php
    mysqli_close($conecta);
?>