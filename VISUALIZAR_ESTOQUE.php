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
        <div>
            <br>
        </div>
        <div class="card"> 
            <div class="card-header">
                <h2>Estoques Cadastrados</h2>
            </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">


                        <!--- Formulário de busca --->
                        <form class="form-inline mb-0 w-50" method="GET">
                            <div class="input-group w-100">
                                <input name="pesquisa" type="search" class="form-control" placeholder="Buscar..." action="VISUALIZAR_ESTOQUE.php" method="get">
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
                        <a href="CAD_ESTOQUE.php" class="btn btn-primary ml-auto">Adicionar Estoque</a>
                    </div>

                    <table class="table table-bordered table-striped small">
                    <thead class="thead-light text-center">
                        <!--- Cabeçalho da tabela --->
                        <tr>
                            <th>Identificação do Estoque</th>
                            <th>  Nome   </th>
                            <th>  Tipo </th>
                            <th>  Descrição  </th>
                            <th>  Qtd de Divisórias  </th>
                            <th>  Visualizar Divisórias  </th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            while ($linha = mysqli_fetch_assoc($lista_estoques)){
                        ?>
                        <tr>
                            <td><a href="CAD_ESTOQUE.php?id_estoque=<?php echo $linha["ID_ESTOQUE"]?>&acao=alterar"> <?php echo $linha["ID_ESTOQUE"]?> </a>   </td>
                            <td> <?php echo $linha["NM_ESTOQUE"]?>    </td> 
                            <td> <?php if ($linha != NULL) {
                                echo $linha["NM_TP_ESTOQUE"];
                            }else{
                                echo 'Não há';
                            }?> </td>
                            <td> <?php echo $linha["DS_ESTOQUE"]?> </td> 
                            <td> <?php echo $linha["ID_QTD_DIVISORIA"]?> </td>
                            <td> 
                                <a href="VISUALIZAR_DIVISORIAS.php?id_estoque=<?php echo $linha["ID_ESTOQUE"]?>"> 
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-archive" viewBox="0 0 16 16">
                                    <path d="M0 2a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1v7.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 12.5V5a1 1 0 0 1-1-1V2zm2 3v7.5A1.5 1.5 0 0 0 3.5 14h9a1.5 1.5 0 0 0 1.5-1.5V5H2zm13-3H1v2h14V2zM5 7.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
                                    </svg>
                                </a> 
                            </td>
                            <td>
                            <!--- Botão de excluir --->
                            <a class="btn p-0" title="Excluir" href="CAD_ESTOQUE.php?id_estoque=<?php echo $linha["ID_ESTOQUE"]?>&acao=excluir">
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
          $("#header").load("header.php"); 
        });
    </script>


</html>

<?php
    mysqli_close($conecta);
?>