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
    $select = "SELECT ID_USUARIO, DS_ID_USUARIO, NM_USUARIO, SENHA_USUARIO, EMAIL_USUARIO FROM USUARIO ";
    if(isset($_GET["pesquisa"])){
        $nome_usuario = $_GET["pesquisa"];
        $select .= "WHERE NM_USUARIO LIKE '%{$nome_usuario}%' ";
    }
    $lista_usuarios = mysqli_query ($conecta, $select);
    if(!$lista_usuarios){
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
                <h2>Usuários Cadastrados</h2>
            </div>
                <div class="card-body">
                    <div class="d-flex mb-3">


                        <!--- Formulário de busca --->
                        <form class="form-inline mb-0 w-50" method="GET">
                            <div class="input-group w-100">
                                <input name="pesquisa" type="search" class="form-control" placeholder="Buscar..." action="VISUALIZAR_USUARIOS.php" method="get">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="submit" name="buscar">
                                            <!--- Ícone da lupa --->
                                            <svg id="i-search" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="24" height="24" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                            <circle cx="14" cy="14" r="12" />
                                            <path d="M23 23 L30 30"  />
                                            </svg>
                                        </button>
                                    </div>
                            </div>
                        </form>


                        <!--- Botão de novo --->
                        <a href="CAD_USUARIO.php" class="btn btn-primary ml-auto">Adicionar Usuário</a>
                    </div>

                    <table class="table table-bordered table-striped small">
                    <thead class="thead-light text-center">
                        <!--- Cabeçalho da tabela --->
                        <tr>
                            <th>Identificação do Usuário</th>
                            <th>  Nome   </th>
                            <th>  Login  </th>
                            <th>  Senha  </th>
                            <th>  Email  </th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            while ($linha = mysqli_fetch_assoc($lista_usuarios)){
                        ?>
                        <tr>
                            <td><a href="CAD_USUARIO.php?id_usuario=<?php echo $linha["ID_USUARIO"]?>&acao=alterar"> <?php echo $linha["ID_USUARIO"]?> </a>   </td>
                            <td> <?php echo $linha["NM_USUARIO"]?>    </td> 
                            <td> <?php echo $linha["DS_ID_USUARIO"]?> </td> 
                            <td> <?php echo $linha["SENHA_USUARIO"]?> </td>
                            <td> <?php echo $linha["EMAIL_USUARIO"]?> </td>
                            <td>
                            <!--- Botão de excluir --->
                            <a class="btn p-0" title="Excluir" href="CAD_USUARIO.php?id_usuario=<?php echo $linha["ID_USUARIO"]?>&acao=excluir">
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
          $("#header").load("header.html"); 
        });
    </script>


</html>

<?php
    mysqli_close($conecta);
?>