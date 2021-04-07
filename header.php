<!DOCTYPE html>

<html lang="pt-BR">
    <head>
        <meta charset="utf-8">
        <link href="arquivo.css" rel="stylesheet">
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
        <link href="bootstrap/js/bootstrap.min.js">
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
        <meta charset="utf-8">

        <!--- Arquivos para Select com Busca --->
        <link href="css/select2.min.css" rel="stylesheet" />
        <script src="js/select2.min.js"></script>
        <script>
          //função default do jquery é similar ao document.ready
          $(function(){
              //ativa select2 para os selects (ignora os selects que possam já ter o select2 ativo em outro momento)
              $('select').each(function(){
                  if(!$(this).hasClass('select2-hidden-accessible'))
                      $(this).select2();
              });
          });

          //desconsidera espaços em branco nos inputs
          $(function(){
              $('input, textarea').blur(function(){
                  $(this).val($(this).val().trim());
              });
          });

          //limpa campos CPF/CNPJ ao colar (deixa apenas os números)
          $(function(){
              $('[data-colar-numeros]').on('paste', function(e){
                  var valor = e.originalEvent.clipboardData.getData('text');
                  var valorLimpo = '';
                  for(var i = 0; i < valor.length; i++){
                      if(valor.charCodeAt(i) >= '0'.charCodeAt(0) && valor.charCodeAt(i) <= '9'.charCodeAt(0)){
                          valorLimpo += valor.charAt(i);
                      }
                  }
                  e.preventDefault(); //necessário para impedir de colar o texto original
                  $(this).val(valorLimpo);
              });
          });
        </script>

        
    </head>
    <body>

        <div class="header">
            <img src="" alt="Minha Figura" class="vertical-align"> 
       
        </div>
            <ul class="nav nav-tabs">
              <li class="nav-item">
                <a class="nav-link" href="principal.php">Principal</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="VISAO_ESTOQUE.php">Visão Geral de Estoque</a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Cadastro</a>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="VISUALIZAR_CATEGORIA.php">Categoria</a>
                  <a class="dropdown-item" href="VISUALIZAR_PRODUTOS.php">Produtos</a>
                  <a class="dropdown-item" href="VISUALIZAR_FORNECEDOR.php">Fornecedor</a>
                  <a class="dropdown-item" href="VISUALIZAR_ESTOQUE.php">Estoque</a>
                  <a class="dropdown-item" href="VISUALIZAR_USUARIOS.php">Novo Usuário</a>
                </div>
              </li>
            </ul>
           
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>  
        <script>
          $('a[data-toggle="tab"]').on('shown', function (e) {
            e.target // activated tab
            e.relatedTarget // previous tab
          })
        </script>
      </body>
    
</html>