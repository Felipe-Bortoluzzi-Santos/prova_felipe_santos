<?php
session_start();
require_once('conexao.php');
if($_SESSION['perfil']!=1){
    echo "<script>alert('Acesso Negado');window.location.href='principal.php';</script>";
    exit();
}
if($_SERVER["REQUEST_METHOD"]=="POST") {
    $nome=$_POST['nome'];
    $email=$_POST['email'];
    $senha=password_hash($_POST['senha'],PASSWORD_DEFAULT);
    $id_perfil=$_POST['id_perfil'];
    $sql="INSERT INTO funcionario(nome_funcionario,endereco,telefone,email) VALUES (:nome,:endereco,:telefone,:email)";
    $stmt=$pdo->prepare($sql);
    $stmt->bindParam(":nome",$nome);
    $stmt->bindParam(":endereco",$email);
    $stmt->bindParam(":telefone",$senha);
    $stmt->bindParam(":email",$id_perfil);
    if($stmt->execute()){
        echo"<script>alert('funcionario cadastrado com sucesso!');</script>";
    } else {
        echo"<script>alert('erro ao cadastrar o funcionario');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuarios</title>
    <link rel="stylesheet" href="stles.css">
    <script src="validacoes.js"></script>
</head>
<body>
    <ul>
        <li class="dropdown">
            <a href="javascript:void(0)" class="dropdown-menu">Cadastro</a>
            <div class="dropdown-content">
                <a href="cadastro_fornecedor.php">Cadastro Fornecedor</a>
                <a href="cadastro_produto.php">Cadastro Produto</a>
                <a href="cadastro_perfil.php">Cadastro Perfil</a>
                <a href="cadastro_cliente.php">Cadastro Cliente</a>
                <a href="cadastro_usuario.php">Cadastro Usuario</a>
            </div>
        </li>
    </ul>
    <ul>
        <li class="dropdown">
            <a href="javascript:void(0)" class="dropdown-menu">Excluir</a>
            <div class="dropdown-content">
                <a href="excluir_fornecedor.php">Excluir Fornecedor</a>
                <a href="excluir_produto.php">Excluir Produto</a>
                <a href="excluir_perfil.php">Excluir Perfil</a>
                <a href="excluir_cliente.php">Excluir Cliente</a>
                <a href="excluir_usuario.php">Excluir Usuario</a>
                <a href="excluir_funcionario.php">Excluir Funcionario</a>
            </div>
        </li>
    </ul>
    <ul>
        <li class="dropdown">
            <a href="javascript:void(0)" class="dropdown-menu">Buscar</a>
            <div class="dropdown-content">
                <a href="buscar_fornecedor.php">Buscar Fornecedor</a>
                <a href="buscar_produto.php">Buscar Produto</a>
                <a href="buscar_usuario.php">Buscar Usuario</a>
                <a href="buscar_perfil.php">Buscar Perfil</a>
                <a href="buscar_cliente.php">Buscar Cliente</a>
                <a href="buscar_funcionario.php">Buscar Funcionario</a>
            </div>
        </li>
    </ul>
    <ul>
        <li class="dropdown">
            <a href="javascript:void(0)" class="dropdown-menu">Alterar</a>
            <div class="dropdown-content">
                <a href="alterar_fornecedor.php">Alterar Fornecedor</a>
                <a href="alterar_produto.php">Alterar Produto</a>
                <a href="alterar_usuario.php">Alterar Usuario</a>
                <a href="alterar_perfil.php">Alterar Perfil</a>
                <a href="alterar_cliente.php">Alterar Cliente</a>
                <a href="alterar_funcionario.php">Alterar Funcionario</a>
            </div>
        </li>
    </ul>
    <h2>Cadastrar Usuario</h2>
    <form action="cadastro_funcionario.php" method="post">
        <label for="nome">Nome:</label>
        <input type="text" id="nome_funcionario" name="nome_funcionario" required>
        <br>
        <label for="email">Endereço::</label>
        <input type="text" id="endereco" name="endereco" required>
        <br>
        <label for="telefone">Telefone:</label>
        <input type="text" id="telefone" name="telefone" required onkeypress="mascara(this,telefone)">
        <br>
        <label for="senha">Email:</label>
        <input type="email" id="email" name="email" required>
        </select>
        <br>
        <button type="submit">Salvar</button>
        <button type="reset">Cancelar</button>
    </form>
    <a href="principal.php">Voltar</a>
</body>
</html>