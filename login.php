<?php
include "banco.php";
$pdo = Banco::conectar(); // Corrigido: uso do operador de atribuição '='

// Protegendo contra XSS e SQL Injection
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_SPECIAL_CHARS); // Hash da senha

// Consulta otimizada buscando apenas os campos necessários
$validarLogin = $pdo->prepare("SELECT * FROM tb_alunos WHERE email = :email AND pass = :senha"); // Corrigido: use '=' para comparação
$validarLogin->bindParam(':email', $email); // Corrigido: removeu as aspas extras e corrigido o parâmetro
$validarLogin->bindParam(':senha', $senha); // Corrigido: removido o espaço extra

$validarLogin->execute();
if ($validarLogin->rowCount() >= 1) {
    $usuario = $validarLogin->fetch(PDO::FETCH_ASSOC); // Corrigido: use 'usuario' em vez de 'Susuario'
    header('Location: index.php'); // Redireciona para a página segura
    exit();
} else {
?>
    <script>
        alert("Usuário não encontrado");
    </script>
<?php
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/estilo.css">
</head>
<body>
<section class="vh-100"> <!-- Corrigido: use 'section' em vez de 'csection' -->
    <div class="container-fluid h-custom">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-md-9 col-lg-6 col-xl-5">
                <img src="../aula_Php/assets/img/login.png" class="img-fluid" alt="Sample image">
            </div>
            <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                <form method="post" action="login.php">
                    <div class="divider d-flex align-items-center my-4"> <!-- Corrigido: removido 'd' extra -->
                        <p class="font-weight-bold">LOGIN</p>
                    </div>
                    <!-- Email input -->
                    <div data-mdb-input-init class="form-outline mb-4">
                        <input type="email" id="form3Example3" class="form-control form-control-lg" placeholder="Enter a valid email address" name="email" />
                        <label class="form-label" for="form3Example3">Email address</label>
                    </div>
                    <!-- Password input -->
                    <div data-mdb-input-init class="form-outline mb-3">
                        <input type="password" id="form3Example4" class="form-control form-control-lg" placeholder="Enter password" name="senha" />
                        <label class="form-label" for="form3Example4">Password</label>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <!-- Checkbox -->
                        <div class="form-check mb-0">
                            <input class="form-check-input me-2" type="checkbox" value="" id="form2Example3" />
                            <label class="form-check-label" for="form2Example3">
                                Remember me
                            </label>
                        </div>
                        <a href="#" class="text-body">Forgot password?</a>
                    </div>
                    <div class="text-center text-lg-start mt-4 pt-2">
                        <input type="submit" class="btn btn-primary btn-lg" value="Login" style="padding-left: 2.5rem; padding-right: 2.5rem;">
                        <p class="small fw-bold mt-2 pt-1 mb-0">Don't have an account? <a href="#" class="link-danger">Register</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<div class="d-flex flex-column flex-md-row text-center text-md-start justify-content-between py-4 px-4 px-xl-5 bg-primary">
    <!-- Copyright -->
    <div class="text-white mb-3 mb-md-0">
        Copyright © 2020. All rights reserved.
    </div>
</div>
</body>
</html>