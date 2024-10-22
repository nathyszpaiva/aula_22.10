<?php
require "banco.php";
 
// Acompanha os erros de validação
// Processar só quando tenha uma chamada POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomeErro = null;
    $enderecoErro = null;
    $telefoneErro = null;
    $emailErro = null;
    $idadeErro = null;
    $sexoErro = null;
   
    $validacao = true;
    $novoUsuario = false;
 
    if (!empty($_POST['nome'])) {
        $nome = $_POST['nome'];
    } else {
        $nomeErro = 'Por favor digite o seu nome!';
        $validacao = false;
    }
 
    if (!empty($_POST['endereco'])) {
        $endereco = $_POST['endereco'];
    } else {
        $enderecoErro = 'Por favor digite o seu endereço!';
        $validacao = false;
    }
 
    if (!empty($_POST['telefone'])) {
        $telefone = $_POST['telefone'];
    } else {
        $telefoneErro = 'Por favor digite o número do telefone!';
        $validacao = false;
    }
 
    if (!empty($_POST['email'])) {
        $email = $_POST['email'];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErro = 'Por favor digite um endereço de email válido!';
            $validacao = false;
        }
    } else {
        $emailErro = 'Por favor digite um endereço de email!';
        $validacao = false;
    }
 
    if (!empty($_POST['idade'])) {
        $idade = $_POST['idade'];
    } else {
        $idadeErro = 'Por favor selecione um campo!';
        $validacao = false;
    }
 
    // Inserindo no Banco:
    if ($validacao) {
        $pdo = Banco::conectar();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       
        $sql = "INSERT INTO tb_alunos (nome, endereco, telefone, email, idade) VALUES (?, ?, ?, ?, ?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($nome, $endereco, $telefone, $email, $idade));
       
        Banco::desconectar();
        header("Location: index.php");
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEJISvSWaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEWIH" crossorigin="anonymous">
    <title>Adicionar Contato</title>
</head>
<body>
    <div class="container">
        <div class="span10 offset1">
            <div class="card">
                <div class="card-header">
                    <h3 class="well">Adicionar Contato</h3>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="create.php" method="post">
                        <div class="control-group <?php echo !empty($nomeErro) ? 'error' : ''; ?>">
                            <label class="control-label">Nome</label>
                            <div class="controls">
                                <input size="50" class="form-control" name="nome" type="text" placeholder="Nome" value="<?php echo !empty($nome) ? $nome : ''; ?>">
                                <?php if (!empty($nomeErro)): ?>
                                    <span class="text-danger"><?php echo $nomeErro; ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="control-group <?php echo !empty($enderecoErro) ? 'error' : ''; ?>">
                            <label class="control-label">Endereço</label>
                            <div class="controls">
                                <input size="80" class="form-control" name="endereco" type="text" placeholder="Endereço" value="<?php echo !empty($endereco) ? $endereco : ''; ?>">
                                <?php if (!empty($enderecoErro)): ?>
                                    <span class="text-danger"><?php echo $enderecoErro; ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="control-group <?php echo !empty($telefoneErro) ? 'error' : ''; ?>">
                            <label class="control-label">Telefone</label>
                            <div class="controls">
                                <input size="35" class="form-control" name="telefone" type="text" placeholder="Telefone" value="<?php echo !empty($telefone) ? $telefone : ''; ?>">
                                <?php if (!empty($telefoneErro)): ?>
                                    <span class="text-danger"><?php echo $telefoneErro; ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="control-group <?php echo !empty($emailErro) ? 'error' : ''; ?>">
                            <label class="control-label">Email</label>
                            <div class="controls">
                                <input size="40" class="form-control" name="email" type="text" placeholder="Email" value="<?php echo !empty($email) ? $email : ''; ?>">
                                <?php if (!empty($emailErro)): ?>
                                    <span class="text-danger"><?php echo $emailErro; ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="control-group <?php echo !empty($idadeErro) ? 'error' : ''; ?>">
                            <label class="control-label">Idade</label>
                            <div class="controls">
                                <input size="40" class="form-control" type="text" name="idade" id="idade" value="<?php echo !empty($idade) ? $idade : ''; ?>">
                                <?php if (!empty($idadeErro)): ?>
                                    <span class="text-danger"><?php echo $idadeErro; ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-actions">
                            <br/>
                            <button type="submit" class="btn btn-success">Adicionar</button>
                            <a href="index.php" class="btn btn-default">Voltar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mlykV+2+9J3UJ46jBkOWLaUAdn689aCwoqbBJiSnjAK/18WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="assets/js/bootstrap.min.js"></script>
</body>
</html>



