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
        if(isset($_POST["usuario"])){
            $nome = $_POST["nome"];
            $usuario = $_POST["usuario"];
            $senha = $_POST["senha"];
            $email = $_POST["email"];

            $inserir = "INSERT INTO USUARIO ";
            $inserir .= "(NM_USUARIO ,DS_ID_USUARIO, SENHA_USUARIO, EMAIL_USUARIO) ";
            $inserir .= "VALUES ";
            $inserir .= "('$nome', '$usuario','$senha','$email')";

            $operacao_inserir = mysqli_query($conecta,$inserir);
            if(!$operacao_inserir){
                die("Erro no Banco!");
            }
        }
        header("location:VISUALIZAR_USUARIOS.php");
    }
?>

<?php
    if($acao != 'inserir'){
        $select = "SELECT * FROM USUARIO ";
        if(isset($_GET["id_usuario"])){
            $id = $_GET["id_usuario"];
            $select .= "WHERE ID_USUARIO = {$id} ";
        }

        $lista_usuarios = mysqli_query($conecta, $select);
        if(!$lista_usuarios){
            die("Erro no Banco!");
        }

        $info_usuario = mysqli_fetch_assoc($lista_usuarios);
    }
?>

<?php 
    //atualizacao
    if(isset($_POST["atualizar"])){
        if(isset($_POST["usuario"])){
            $nome = $_POST["nome"];
            $usuario = $_POST["usuario"];
            $senha = $_POST["senha"];
            $email = $_POST["email"];

            $alterar = "UPDATE USUARIO ";
            $alterar .= "SET ";
            $alterar .= "NM_USUARIO = '{$nome}', DS_ID_USUARIO = '{$usuario}', SENHA_USUARIO = '{$senha}', EMAIL_USUARIO = '{$email}' ";
            $alterar .= "WHERE ID_USUARIO = '{$id}'";

            $operacao_alterar = mysqli_query($conecta,$alterar);
            if(!$operacao_alterar){
                die("Erro no Banco!");
            }
        }
        header("location:VISUALIZAR_USUARIOS.php");
    }
?>

<?php 
    //exclusao
    if(isset($_POST["exclusao"])){
        if(isset($_POST["usuario"])){
            $nome = $_POST["nome"];
            $usuario = $_POST["usuario"];
            $senha = $_POST["senha"];
            $email = $_POST["email"];

            $excluir = "DELETE ";
            $excluir .= "FROM USUARIO ";
            $excluir .= "WHERE ID_USUARIO = '{$id}'";

            $operacao_excluir = mysqli_query($conecta,$excluir);
            if(!$operacao_excluir){
                die("Registro não excluido");
            }else{
                header("location:VISUALIZAR_USUARIOS.php");
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
                        Cadastrar Usuário
                    <?php }elseif($acao == 'alterar') {?>
                        Atualizar Usuário
                    <?php }else{ ?>
                        Excluir Registro?
                    <?php } ?>
                    
                </h3>
            </div>

            <div class="card-body">
                <div class="form-group">
                    <label>Nome<span title="Campo obrigatório" class="text-danger">*</span></label>
                    <input name="nome" value="<?php if($acao != 'inserir'){ echo $info_usuario["NM_USUARIO"];}?>" type="text" maxlength="50" required class="form-control form-control-sm" <?php if($acao == 'excluir'){ ?> readonly <?php } ?>>
                </div>
                <div class="form-group">
                    <label>Usuário<span title="Campo obrigatório" class="text-danger">*</span></label>
                    <input name="usuario"  value="<?php if($acao != 'inserir'){ echo $info_usuario["DS_ID_USUARIO"];}?>" type="text" maxlength="16" required class="form-control form-control-sm" <?php if($acao == 'excluir'){ ?> readonly <?php } ?> >
                </div>

                <div class="form-group">
                    <label>Senha<span title="Campo obrigatório" class="text-danger">*</span></label>
                    <input name="senha" value="<?php if($acao != 'inserir'){ echo $info_usuario["SENHA_USUARIO"];}?>" type="text" maxlength="16" required class="form-control form-control-sm" <?php if($acao == 'excluir'){ ?> readonly <?php } ?>>
                </div>
                 <div class="form-group">
                    <label>Email<span title="Campo obrigatório" class="text-danger">*</span></label>
                    <input name="email" value="<?php if($acao != 'inserir'){ echo $info_usuario["EMAIL_USUARIO"];}?>" type="email" maxlength="100" required class="form-control form-control-sm" <?php if($acao == 'excluir'){ ?> readonly <?php } ?>>
                </div>

            </div>

            <div class="card-footer d-flex justify-content-between mb-3">
                <a class="btn mr-auto" title="voltar" href="VISUALIZAR_USUARIOS.php">
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