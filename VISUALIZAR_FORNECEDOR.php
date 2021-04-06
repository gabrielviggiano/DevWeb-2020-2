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
    $select = "SELECT * ";
    $select .= "FROM fornecedor";
    $lista_fornecedores = mysqli_query ($conecta, $select);
    if(!$lista_fornecedores){
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
                <h2>Fornecedores</h2>
            </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <!--- Formulário de busca --->
                        <form class="form-inline mb-0 w-50" method="GET">
                            <div class="input-group w-100">
                                <input name="pesquisa" type="search" class="form-control" placeholder="Buscar...">
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
                        <a href="CAD_FORNECEDOR.php" class="btn btn-primary ml-auto">Adicionar Fornecedor</a>
                    </div>

                    <table class="table table-bordered table-striped small">
                    <thead class="thead-light text-center">
                        <!--- Cabeçalho da tabela --->
                        <tr>
                            <th>Identificação do Fornecedor </th>
                            <th>Nome do Fornecedor</th>
                            <th>Tipo do Documento</th>
                            <th>Número do Documento</th>
                            <th>Contato</a></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            while ($linha = mysqli_fetch_assoc($lista_fornecedores)){
                        ?>
                        <tr>
                            <td><a href="CAD_FORNECEDOR.php?id_fornecedor=<?php echo $linha["ID_FORNECEDOR"]?>&acao=alterar"> <?php echo $linha["ID_FORNECEDOR"]?> </a>   </td>
                            <td> <?php echo $linha["NM_FORNECEDOR"]?>    </td> 
                            <td> <?php echo $linha["CD_TP_FORNECEDOR"]?> </td> 
                            <td> <?php echo $linha["NO_ID_FORNECEDOR"]?> </td>
                            <td> 
                                <a href="VISUALIZAR_CONTATO_FORN.php?id_fornecedor=<?php echo $linha["ID_FORNECEDOR"]?>">
                                    <center> 
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone-plus-fill" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511zM12.5 1a.5.5 0 0 1 .5.5V3h1.5a.5.5 0 0 1 0 1H13v1.5a.5.5 0 0 1-1 0V4h-1.5a.5.5 0 0 1 0-1H12V1.5a.5.5 0 0 1 .5-.5z"/>
                                        </svg>
                                    </center>
                                </a> 
                            </td>
                            <td>
                            <!--- Botão de excluir --->
                            <a class="btn p-0" title="Excluir" href="CAD_FORNECEDOR.php?id_fornecedor=<?php echo $linha["ID_FORNECEDOR"]?>&acao=excluir">
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