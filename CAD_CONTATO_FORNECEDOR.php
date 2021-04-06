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
        if(isset($_POST["identificacao"])){
            $nome = $_POST["identificacao"];
            $descricao = $_POST["nm_identificacao"];
            $id = $_GET["id_fornecedor"];

            $inserir = "INSERT INTO CONTATO_FORNECEDOR ";
            $inserir .= "(ID_FORNECEDOR, ID_TP_CONTATO, DS_CONTATO_FORNECEDOR) ";
            $inserir .= "VALUES ";
            $inserir .= "($id, $nome,'$descricao')";

            $operacao_inserir = mysqli_query($conecta,$inserir);
            if(!$operacao_inserir){
                echo $id;
            }else{
                echo '<script language="javascript">';
                echo 'alert("Contato de fornecedor cadastrado com sucesso!")';
                echo '</script>';
            }
        }
        $id = $_GET["id_fornecedor"];
        header("location:VISUALIZAR_CONTATO_FORN.php?id_fornecedor=$id");
    }
?>

<?php
    if($acao != 'inserir'){
        $select = "SELECT * FROM CONTATO_FORNECEDOR ";
        if(isset($_GET["id_contato_fornecedor"])){
            $id_fornecedor = $_GET["id_contato_fornecedor"];
            if($id_fornecedor != ''){
                $select .= "WHERE ID_CONTATO_FORNECEDOR = {$id_fornecedor} ";
            }
        }

        $lista_contatos = mysqli_query($conecta, $select);
        if(!$lista_contatos){
            die("Erro no Banco!");
        }

        $info_contato = mysqli_fetch_assoc($lista_contatos);
    }
?>

<?php 
    //atualizacao
    if(isset($_POST["atualizar"])){
        if(isset($_POST["identificacao"])){
            $nome = $_POST["identificacao"];
            $descricao = $_POST["nm_identificacao"];

            $alterar = "UPDATE CONTATO_FORNECEDOR ";
            $alterar .= "SET ";
            $alterar .= "ID_TP_CONTATO = '{$nome}', DS_CONTATO_FORNECEDOR = '{$descricao}' ";
            $alterar .= "WHERE ID_CONTATO_FORNECEDOR = '{$id_fornecedor}'";

            $operacao_alterar = mysqli_query($conecta,$alterar);
            if(!$operacao_alterar){
                die("Erro no Banco!");
            }
        }
        $id = $_GET["id_fornecedor"];
        header("location:VISUALIZAR_CONTATO_FORN.php?id_fornecedor=$id");
    }
?>

<?php 
    //exclusao
    if(isset($_POST["exclusao"])){
        $excluir = "DELETE ";
        $excluir .= "FROM CONTATO_FORNECEDOR ";
        $excluir .= "WHERE ID_CONTATO_FORNECEDOR = '{$id_fornecedor}'";

        $operacao_excluir = mysqli_query($conecta,$excluir);

        if(!$operacao_excluir){
            die("Registro não excluido");
        }else{
            $id = $_GET["id_fornecedor"];
            header("location:VISUALIZAR_CONTATO_FORN.php?id_fornecedor=$id");
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
                    Cadastrar contatos do Fornecedor
                </h3>
            </div>

            <div class="card-body">
                <div class="form-group">
                    <label>Escolha o tipo de contato<span title="Campo obrigatório" class="text-danger">*</span></label>
                    <select style="width: 100%; margin: auto;" class="custom-select mr-sm-2" name="identificacao" id="inlineFormCustomSelect">
                                <option selected>Escolha</option>
                                <option value="1" <?php if($acao != 'inserir' and ($info_contato["ID_TP_CONTATO"] == '1')){?> selected <?php } ?> <?php if($acao == 'excluir'){ ?> disabled <?php } ?>>Email</option>
                                <option value="2" <?php if($acao != 'inserir' and ($info_contato["ID_TP_CONTATO"] == '2')){?> selected <?php } ?> <?php if($acao == 'excluir'){ ?> disabled <?php } ?>>Celular</option>
                                <option value="3" <?php if($acao != 'inserir' and ($info_contato["ID_TP_CONTATO"] == '3')){?> selected <?php } ?> <?php if($acao == 'excluir'){ ?> disabled <?php } ?>>Telefone Residencial</option>
                                <option value="4" <?php if($acao != 'inserir' and ($info_contato["ID_TP_CONTATO"] == '4')){?> selected <?php } ?> <?php if($acao == 'excluir'){ ?> disabled <?php } ?>>Outro</option>
                    </select>        
                </div> 
                <div class="form-group">
                    <label>Preencha de acordo com a opção escolhida acima<span title="Campo obrigatório" class="text-danger">*</span></label>
                    <input name="nm_identificacao" type="text" maxlength="30" value="<?php if($acao != 'inserir'){ echo $info_contato["DS_CONTATO_FORNECEDOR"];}?>" required class="form-control form-control-sm" <?php if($acao == 'excluir'){ ?> readonly <?php } ?>>
                </div>
            </div>

            <div class="card-footer d-flex justify-content-between mb-3">
                <a class="btn mr-auto" title="voltar" href="VISUALIZAR_CONTATO_FORN.php?id_fornecedor=<?php echo $_GET["id_fornecedor"]; ?>">
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