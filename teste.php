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
    $select = "SELECT * FROM ESTOQUE ";

    $lista_estoques = mysqli_query($conecta, $select);
    if(!$lista_estoques){
        die("Erro no Banco!");
    }

    $info_estoque = mysqli_fetch_assoc($lista_estoques);
    $qtd_estoques = mysqli_num_rows ($lista_estoques);
?>

<?php
    $select_produtos = "SELECT * FROM PRODUTO ";

    $lista_produtos = mysqli_query($conecta, $select_produtos);
    if(!$lista_produtos){
        die("Erro no Banco!");
    }

    $info_produtos = mysqli_fetch_assoc($lista_produtos);
    $qtd_produtos = mysqli_num_rows ($lista_produtos);
?>

<?php
    $select_fornecedores = "SELECT * FROM FORNECEDOR ";

    $lista_fornecedores = mysqli_query($conecta, $select_fornecedores);
    if(!$lista_fornecedores){
        die("Erro no Banco!");
    }

    $info_fornecedores = mysqli_fetch_assoc($lista_fornecedores);
    $qtd_fornecedores = mysqli_num_rows ($lista_fornecedores);
?>



<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        Dashboard Estoques
    </title>
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <link href="arquivo.css" rel="stylesheet">
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="bootstrap/js/bootstrap.min.js">
    <div id="header-estoque" >

    </div>
</head>

<body>
    <br>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-warning card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">folder_open</i>
                        </div>
                        <p class="card-category">Estoques cadastrados</p>
                        <h3 class="card-title"><?php echo $qtd_estoques; ?>
                            <small>Estoques</small>
                        </h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons text-danger">warning</i>
                            <a href="VISUALIZAR_ESTOQUE.php">Visualizar estoques.</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-success card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">store</i>
                        </div>
                        <p class="card-category">Total de Produtos Cadastrados</p>
                        <h3 class="card-title"><?php echo $qtd_produtos; ?>
                            Produtos
                        </h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">date_range</i>
                            <a href="VISUALIZAR_PRODUTOS.php"> Visualizar produtos </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-success card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">store</i>
                        </div>
                        <p class="card-category">Total de Fornecedores Cadastrados</p>
                        <h3 class="card-title"><?php echo $qtd_fornecedores; ?>
                            Fornecedores
                        </h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">date_range</i>
                            <a href="VISUALIZAR_FORNECEDOR.php"> Visualizar fornecedores </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <br>
        <div class="row">
            <div class="col-lg-9 col-md-12">
              <div class="card">
                <div class="card-header card-header-warning">
                  <h4 class="card-title">Estatísticas dos Estoques</h4>
                  <p class="card-category">Informações acerca dos estoques cadastrados no sistema</p>
                </div>
                <div class="card-body table-responsive">
                  <table class="table table-hover">
                    <thead class="text-warning">
                      <th>N° de Identificação</th>
                      <th>Nome do Estoque</th>
                      <th>Valor Total</th>
                      <th>Qtd de Divisórias</th>
                      <th>Qtd de Produtos</th>
                    </thead>
                    <tbody>
                      <tr>
                        <td>1</td>
                        <td>Dakota Rice</td>
                        <td>$36,738</td>
                        <td>Niger</td>
                      </tr>
                      <tr>
                        <td>2</td>
                        <td>Minerva Hooper</td>
                        <td>$23,789</td>
                        <td>Curaçao</td>
                      </tr>
                      <tr>
                        <td>3</td>
                        <td>Sage Rodriguez</td>
                        <td>$56,142</td>
                        <td>Netherlands</td>
                      </tr>
                      <tr>
                        <td>4</td>
                        <td>Philip Chaney</td>
                        <td>$38,735</td>
                        <td>Korea, South</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            
        </div>
    </div>

    <script> 
        $(function(){
          console.log('init');
          $("#header-estoque").load("header.html"); 
        });
    </script>

    <script>
        $('.nav li').click(function() {
        $(this).siblings('li').removeClass('active');
        $(this).addClass('active');
        });
    </script>
</body>
</html>