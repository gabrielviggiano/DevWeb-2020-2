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
        if(isset($_POST["fornecedor"])){
            $fornecedor = $_POST["fornecedor"];
            $cd_tipo_fornecedor = $_POST["cd_tipo_fornecedor"];
            $identificacao = $_POST["identificacao"];
            
        

            $inserir = "INSERT INTO fornecedor ";
            $inserir .= "(NM_FORNECEDOR , CD_TP_FORNECEDOR, NO_ID_FORNECEDOR)";
            $inserir .= "VALUES ";
            $inserir .= "('$fornecedor', '$cd_tipo_fornecedor', '$identificacao')";

            $operacao_inserir = mysqli_query($conecta,$inserir);
            if(!$operacao_inserir){
                die("Erro no Banco!");
            }    
        }
        header("location:VISUALIZAR_FORNECEDOR.php");
    }
?>

<?php
    if($acao != 'inserir'){
        $select = "SELECT * FROM FORNECEDOR ";
        if(isset($_GET["id_fornecedor"])){
            $id_fornecedor = $_GET["id_fornecedor"];
            if($id_fornecedor != ''){
                $select .= "WHERE ID_FORNECEDOR = {$id_fornecedor} ";
            }
        }

        $lista_fornecedores = mysqli_query($conecta, $select);
        if(!$lista_fornecedores){
            die("Erro no Banco!");
        }

        $info_fornecedor = mysqli_fetch_assoc($lista_fornecedores);
    }
?>

<?php 
    //atualizacao
    if(isset($_POST["atualizar"])){
        if(isset($_POST["fornecedor"])){
            $fornecedor = $_POST["fornecedor"];
            $cd_tipo_fornecedor = $_POST["cd_tipo_fornecedor"];
            $identificacao = $_POST["identificacao"];

            $alterar = "UPDATE FORNECEDOR ";
            $alterar .= "SET ";
            $alterar .= "NM_FORNECEDOR = '{$fornecedor}', CD_TP_FORNECEDOR = '{$cd_tipo_fornecedor}', NO_ID_FORNECEDOR = '{$identificacao}' ";
            $alterar .= "WHERE ID_FORNECEDOR = '{$id_fornecedor}'";

            $operacao_alterar = mysqli_query($conecta,$alterar);
            if(!$operacao_alterar){
                die("Erro no Banco!");
            }
        }
        header("location:VISUALIZAR_FORNECEDOR.php");
    }
?>

<?php 
    //exclusao
    if(isset($_POST["exclusao"])){
        if(isset($_POST["fornecedor"])){

            $excluir = "DELETE ";
            $excluir .= "FROM FORNECEDOR ";
            $excluir .= "WHERE ID_FORNECEDOR = '{$id_fornecedor}'";

            $operacao_excluir = mysqli_query($conecta,$excluir);
            if(!$operacao_excluir){
                die("Registro não excluido");
            }else{
                $id = $_GET["id_fornecedor"];
                header("location:VISUALIZAR_FORNECEDOR.php?id_fornecedor=$id");
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
                        Cadastrar Fornecedor
                    <?php }elseif($acao == 'alterar') {?>
                        Atualizar Fornecedor
                    <?php }else{ ?>
                        Excluir Fornecedor?
                    <?php } ?>
                    
                </h3>
            </div>

            <div class="card-body">
                <div class="form-group">
                    <label>Nome do Fornecedor<span title="Campo obrigatório" class="text-danger">*</span></label>
                    <input name="fornecedor" value="<?php if($acao != 'inserir'){ echo $info_fornecedor["NM_FORNECEDOR"];}?>" type="text" maxlength="50" required class="form-control form-control-sm" <?php if($acao == 'excluir'){ ?> readonly <?php } ?>>
                </div>
                <div class="form-group">
                    <label>Escolha o tipo de documento<span title="Campo obrigatório" class="text-danger">*</span></label>
                    <select class="custom-select mr-sm-2" name = 'cd_tipo_fornecedor' id="inlineFormCustomSelect">
                    
                                <option selected <?php if($acao == 'excluir'){ ?> disabled <?php } ?>>Escolha</option>
                                <option value="1" <?php if($acao != 'inserir' and ($info_fornecedor["CD_TP_FORNECEDOR"] == '1')){?> selected <?php } ?> <?php if($acao == 'excluir'){ ?> disabled <?php } ?>>CPF</option>
                                <option value="2" <?php if($acao != 'inserir' and ($info_fornecedor["CD_TP_FORNECEDOR"] == '2')){?> selected <?php } ?> <?php if($acao == 'excluir'){ ?> disabled <?php } ?>>CNPJ</option>
                                <option value="3" <?php if($acao != 'inserir' and ($info_fornecedor["CD_TP_FORNECEDOR"] == '3')){?> selected <?php } ?> <?php if($acao == 'excluir'){ ?> disabled <?php } ?>>Outro</option>
                    </select>        
                </div> 
                <div class="form-group">
                    <label>Preencha de acordo com a opção escolhida acima<span title="Campo obrigatório" class="text-danger">*</span></label>
                    <input name="identificacao" type="text" maxlength="30" value="<?php if($acao != 'inserir'){ echo $info_fornecedor["NO_ID_FORNECEDOR"];}?>" required class="form-control form-control-sm" <?php if($acao == 'excluir'){ ?> readonly <?php } ?>>
                </div>

            </div>

            <div class="card-footer d-flex">
                <a class="btn mr-auto" title="voltar" href="VISUALIZAR_FORNECEDOR.php">
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