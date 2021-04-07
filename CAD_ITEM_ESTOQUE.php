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
    if($acao != 'inserir'){
        $select = "SELECT * FROM CONTROLE_ESTOQUE ";
        if(isset($_GET["ID_ESTOQUE"])){
            $id = $_GET["ID_ESTOQUE"];
            $select .= "WHERE ID_ESTOQUE = {$id} ";
        }

        $lista_estoques = mysqli_query($conecta, $select);
        if(!$lista_estoques){
            die("Erro no Banco!");
        }

        $info_estoque = mysqli_fetch_assoc($lista_estoques);
    }
?>

<?php
    //insercao
    if(isset($_POST["inserir"])){
        if(isset($_POST["descricao"])){
            $id = $_GET["ID_ESTOQUE"];
            $descricao = $_POST["descricao"];
            $produto = $_POST["select_produto"];
            $qtd_produto = $_POST["qtd_produto"];
            $unidade_medida = $_POST["select_unidade_medida"];
            $divisoria = $_POST["select_divisoria"];

            $inserir = "INSERT INTO CONTROLE_ESTOQUE ";
            $inserir .= "(DS_ITEM_ESTOQUE, ID_PRODUTO, QTD_PRODUTO, ID_DIVISORIA, ID_UNIDADE_MEDIDA, ID_ESTOQUE) ";
            $inserir .= "VALUES ";
            $inserir .= "('$descricao', $produto, $qtd_produto, '$divisoria', $unidade_medida, $id)";

            $operacao_inserir = mysqli_query($conecta,$inserir);
            if(!$operacao_inserir){
                die("Erro no Banco!");
            }
        }
        header("location:CONTROLE_ESTOQUE.php?ID_ESTOQUE=$id");
    }
?>

<?php 
    //atualizacao
    if(isset($_POST["atualizar"])){
        if(isset($_POST["descricao"])){
            $id = $_GET["ID_ESTOQUE"];
            $descricao = $_POST["descricao"];
            $produto = $_POST["select_produto"];
            $qtd_produto = $_POST["qtd_produto"];
            $unidade_medida = $_POST["select_unidade_medida"];
            $divisoria = $_POST["select_divisoria"];

            $alterar = "UPDATE CONTROLE_ESTOQUE ";
            $alterar .= "SET ";
            $alterar .= "DS_ITEM_ESTOQUE = '{$descricao}', ID_PRODUTO = {$produto}, QTD_PRODUTO = {$qtd_produto}, ID_DIVISORIA = '{$divisoria}', ID_UNIDADE_MEDIDA = {$unidade_medida}  ";
            $alterar .= "WHERE ID_ESTOQUE = '{$id}'";

            $operacao_alterar = mysqli_query($conecta,$alterar);
            if(!$operacao_alterar){
                die("Erro no Banco!");
                var_dump($alterar);
                
            }
        }
        header("location:CONTROLE_ESTOQUE.php?ID_ESTOQUE=$id");
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
                        Cadastrar Item no Estoque
                    <?php }elseif($acao == 'alterar') {?>
                        Atualizar Item no Estoque
                    <?php }else{ ?>
                        Excluir Item no Estoque?
                    <?php } ?>
                    
                </h3>
            </div>

            <div class="card-body">
                <div class="form-group">
                    <label>Descrição do Item<span title="Campo obrigatório" class="text-danger">*</span></label>
                    <input name="descricao" type="text" maxlength="50" required value="<?php if($acao != 'inserir'){ echo $info_estoque["DS_ITEM_ESTOQUE"];}?>" class="form-control form-control-sm" <?php if($acao == 'excluir'){ ?> readonly <?php } ?>>
                </div>

                <div class="form-row align-items-center">
                    <div class="col-auto my-1">
                        <label for="select_produto">Produto<span title="Campo obrigatório" class="text-danger">*</span></label>
                        
                        <?php
                            $select = "SELECT * ";
                            $select .= "FROM PRODUTO";
                            $lista_produtos = mysqli_query ($conecta, $select);
                            if(!$lista_produtos){
                                die("Erro no Banco!");
                            }
                        ?> 
                    
                        <select name="select_produto"  style="width: 100%; margin: auto;" >
                        <option value="0"></option>
                        <?php
                            while ($linha = mysqli_fetch_assoc($lista_produtos)){
                                if($linha['ID_PRODUTO'] != 0){

                                
                        ?>
                            <option value="<?php echo $linha["ID_PRODUTO"];?>" <?php if(($acao != 'inserir' and ($linha["ID_PRODUTO"] == $info_estoque["ID_PRODUTO"]))){?> selected <?php } ?> > <?php echo $linha["NM_PRODUTO"];?></option>
                        <?php
                            }
                                }
                        ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Quantidade do Produto<span title="Campo obrigatório" class="text-danger">*</span></label>
                        <input name="qtd_produto" type="number" min="0" max="99999" step="1" required value="<?php if($acao != 'inserir'){ echo $info_estoque["QTD_PRODUTO"];}?>" class="form-control form-control-sm" <?php if($acao == 'excluir'){ ?> readonly <?php } ?>>
                    </div>


                    <div class="col-auto my-1">
                        <label for="select_unidade_medida">Unidade de Medida <span title="Campo obrigatório" class="text-danger">*</span></label>
                        
                        <?php
                            $select = "SELECT * ";
                            $select .= "FROM TP_UNIDADE_MEDIDA";
                            $lista_unidade_medida = mysqli_query ($conecta, $select);
                            if(!$lista_unidade_medida){
                                die("Erro no Banco!");
                            }
                        ?> 
                    
                        <select name="select_unidade_medida"  style="width: 100%; margin: auto;" >
                        <option value="0"></option>
                        <?php
                            while ($linha = mysqli_fetch_assoc($lista_unidade_medida)){
                                if($linha['ID_UNIDADE_MEDIDA'] != 0){

                                
                        ?>
                            <option value="<?php echo $linha["ID_UNIDADE_MEDIDA"];?>" <?php if(($acao != 'inserir' and ($linha["ID_UNIDADE_MEDIDA"] == $info_estoque["ID_UNIDADE_MEDIDA"]))){?> selected <?php } ?> > <?php echo $linha["DS_UNIDADE_MEDIDA"];?></option>
                        <?php
                            }
                                }
                        ?>
                        </select>
                    </div>

                    <div class="col-auto my-1">
                        <label for="select_divisoria">Localização do Produto no Estoque<span title="Campo obrigatório" class="text-danger">*</span></label>
                        
                        <?php
                            $select = "SELECT * ";
                            $id = $_GET["ID_ESTOQUE"];
                            $select .= "FROM DIVISORIA_ESTOQUE WHERE ID_ESTOQUE = {$id}";
                            $lista_divisorias = mysqli_query ($conecta, $select);
                            if(!$lista_divisorias){
                                die("Erro no Banco!");
                            }
                        ?> 
                    
                        <select name="select_divisoria"  style="width: 100%; margin: auto;" >
                        <option value="0"></option>
                        <?php
                            while ($linha = mysqli_fetch_assoc($lista_divisorias)){
                                if($linha['ID_DIVISORIA'] != 0){

                                
                        ?>
                            <option value="<?php echo $linha["ID_DIVISORIA"];?>" <?php if(($acao != 'inserir' and ($linha["ID_DIVISORIA"] == $info_estoque["ID_DIVISORIA"]))){?> selected <?php } ?> > <?php echo $linha["DS_DIVISORIA"];?></option>
                        <?php
                            }
                                }
                        ?>
                        </select>
                    </div>


                </div>

                
            </div>

            <div class="card-footer d-flex justify-content-between mb-3">
                <a class="btn mr-auto" title="voltar" href="CONTROLE_ESTOQUE.php?ID_ESTOQUE=<?php echo $_GET["ID_ESTOQUE"]; ?>">
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

    <script>
        $(document).ready(function() {
            $(".select_estoque").select2();
        });
    </script>


</html>

<?php
    mysqli_close($conecta);
?>