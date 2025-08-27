<?php
session_start();
require_once('conexao.php');
if($_SESSION['perfil']!=1 or $_SESSION['perfil']!=3){
    echo "<script>alert('Acesso Negado');window.location.href='principal.php';</script>";
    exit();
}
if($_SERVER["REQUEST_METHOD"]=="POST") {
    $nome=$_POST['nome'];
    $email=$_POST['descricao'];
    $qtde=$_POST['qtde'];
    $valor_unit=$_POST['valor_unit'];
    $sql="INSERT INTO produto(nome_prod,descricao,qtde,valor_unit) VALUES ( :nome, :descricao, :qtde, :valor)";
    $stmt=$pdo->prepare($sql);
    $stmt->bindParam(":nome",$nome);
    $stmt->bindParam(":descricao",$email);
    $stmt->bindParam(":qtde",$senha);
    $stmt->bindParam(":valor",$id_perfil);
    if($stmt->execute()){
        echo"<script>alert('Produto cadastrado com sucesso!');</script>";
    } else {
        echo"<script>alert('erro ao cadastrar o produto');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Produtos</title>
    <link rel="stylesheet" href="stles.css">
    <script src="validacoes.js"></script>
</head>
<body>
    <ul>
        <li class="dropdown">
            <a href="javascript:void(0)" class="dropdown-menu">Cadastro</a>
            <div class="dropdown-content">
                <a href="cadastro_fornecedor.php">Cadastro Fornecedor</a>
                <a href="cadastro_usuario.php">Cadastro usuario</a>
                <a href="cadastro_perfil.php">Cadastro Perfil</a>
                <a href="cadastro_cliente.php">Cadastro Cliente</a>
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
            </div>
        </li>
    </ul>
    <h2>Cadastrar Produtos</h2>
    <form action="cadastro_produto.php" method="post">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>
        <br>
        <label for="descricao">Descrição:</label>
        <input type="text" id="descricao" name="email" required onkeypress="mascara(this,descricao)">
        <br>
        <label for="qtde">Quantidade:</label>
        <input type="number" id="qtde" name="qtde" required>
        <br>
        <label for="valor_unit">Valor Unitario:</label>
        <input type="number" id="valor_unit" name="valor_unit" required>
        </select>
        <br>
        <button type="submit">Salvar</button>
        <button type="reset">Cancelar</button>
    </form>
    <a href="principal.php">Voltar</a>
</body>
</html>