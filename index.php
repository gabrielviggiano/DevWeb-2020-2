<?php require_once("conexao/conexao.php");
    //todo arquivo precisa ter este cod
?>

<?php
	session_start();
	if(isset($_POST["conta"])){
		$usuario = $_POST["conta"];
		$senha = $_POST["pass"];

		$login = "SELECT * ";
		$login .= "FROM usuario ";
		$login .= "WHERE DS_ID_USUARIO = '{$usuario}' and SENHA_USUARIO = '{$senha}'";

		$acesso = mysqli_query($conecta, $login);
		if(!$acesso){
			die("Falha na consulta");
		}

		$informacao = mysqli_fetch_assoc($acesso);

		if(empty($informacao)){
			echo '<script language="javascript">';
            echo 'alert("Login sem sucesso. Este registro não existe no sistema!")';
            echo '</script>';
		}else{
			$_SESSION["user_system"] = $informacao["ID_USUARIO"];
			header("location:principal.php");
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login V1</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&display=swap" rel="stylesheet">
<!--===============================================================================================-->   
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="images/caixas.png" alt="IMG">
                    
				</div>

				<form class="login100-form validate-form" action="index.php" method="post">
					<span class="login100-form-title">
						<h2>ESTOQUE GM</h2>
        
					</span>

					<div class="wrap-input100 validate-input" data-validate = "Usuário inválido">
						<input class="input100" type="text" name="conta" placeholder="Usuário">
						<span class="focus-input100"></span>
						<!---<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>-->
                        <span class="symbol-input100">
							<i class="fa fa-user"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Digite uma senha">
						<input class="input100" type="password" name="pass" placeholder="Senha">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					
					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Login
						</button>
					</div>

					<div class="text-center p-t-12">
						<span class="txt1">
							Esqueceu
						</span>
						<a class="txt2" href="#">
							Usuário / Senha?
						</a>
					</div>

					<div class="text-center p-t-136">
						<a class="txt2" href="#">
							Criar nova conta
							<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	

	
<!--===============================================================================================-->	
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/tilt/tilt.jquery.min.js"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>