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
    $select = "SELECT ID_CATEGORIA, NM_CATEGORIA, DS_CATEGORIA FROM CATEGORIA";
    if(isset($_GET["pesquisa"])){
        $pesquisa = $_GET["pesquisa"];
        $select .= "WHERE NM_CATEGORIA LIKE '%{$pesquisa}%' OR ";
        $select .= "DS_CATEGORIA LIKE '%{$pesquisa}%' ";
    }
    $lista_categoria = mysqli_query ($conecta, $select);
    if(!$lista_categoria){
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
                <h2>Categorias Cadastrados</h2>
            </div>
                <div class="card-body">
                    <div class="d-flex mb-3">
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
                        <a href="CAD_CATEGORIA.php" class="btn btn-primary ml-auto">Adicionar Categoria</a>
                    </div>

                    <table class="table table-bordered table-striped small">
                    <thead class="thead-light text-center">
                        <!--- Cabeçalho da tabela --->
                        <tr>
                            <th>Identificação da Categoria</th>
                            <th>Nome da Categoria</th>
                            <th>Descrição da Categoria </th>
                            <th>Sub Categorias</th>
                            <th>Produtos Relacionados</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            while ($linha = mysqli_fetch_assoc($lista_categoria)){
                                if($linha["ID_CATEGORIA"] > 0){
                        ?>
                        <tr>
                            <td><a href="CAD_CATEGORIA.php?id_categoria=<?php echo $linha["ID_CATEGORIA"]?>&acao=alterar"> <?php echo $linha["ID_CATEGORIA"]?> </a>   </td>
                            <td> <?php echo $linha["NM_CATEGORIA"]?>    </td> 
                            <td> <?php echo $linha["DS_CATEGORIA"]?> </td>
                            <td><a href="VISUALIZAR_SUBCATEGORIA.php?id_categoria=<?php echo $linha["ID_CATEGORIA"]?>">
                                    <center>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-seam" viewBox="0 0 16 16">
                                            <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2l-2.218-.887zm3.564 1.426L5.596 5 8 5.961 14.154 3.5l-2.404-.961zm3.25 1.7l-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923l6.5 2.6zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464L7.443.184z"/>
                                        </svg>
                                    </center>
                                </a> 
                            </td>
                            <td><a href="VISUALIZAR_PRODUTOS.php?pesquisa=<?php echo $linha["NM_CATEGORIA"]?>">
                                    <center>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-minecart" viewBox="0 0 16 16">
                                            <path d="M4 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2zm0 1a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm8-1a1 1 0 1 1 0-2 1 1 0 0 1 0 2zm0 1a2 2 0 1 0 0-4 2 2 0 0 0 0 4zM.115 3.18A.5.5 0 0 1 .5 3h15a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 14 12H2a.5.5 0 0 1-.491-.408l-1.5-8a.5.5 0 0 1 .106-.411zm.987.82l1.313 7h11.17l1.313-7H1.102z"/>
                                        </svg>
                                    </center>
                                </a> 
                            </td>
                            <td>
                            <!--- Botão de excluir --->
                            <a class="btn p-0" title="Excluir" href="CAD_CATEGORIA.php?id_categoria=<?php echo $linha["ID_CATEGORIA"]?>&acao=excluir">
                                <!--- Ícone de excluir --->
                                <svg id="i-trash" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="20" height="20" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                    <path d="M28 6 L6 6 8 30 24 30 26 6 4 6 M16 12 L16 24 M21 12 L20 24 M11 12 L12 24 M12 6 L13 2 19 2 20 6" />
                                </svg>
                            </a>
                        </td>
                        </tr>                
                        <?php
                        }    
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