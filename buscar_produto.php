<?php
session_start();
require_once('conexao.php');
if($_SESSION['perfil']!=1 or $_SESSION['perfil']!=3){
    echo "<script>alert('Acesso Negado');window.location.href='principal.php';</script>";
    exit();
}
$produtos=[];
//se o formulario for enviado, busca o usuario pelo id ou nome
if($_SERVER["REQUEST_METHOD"]=="POST" && !empty($_POST['busca'])){
    $busca=trim($_POST['busca']);
    //verifica se a busca é um numero (id) ou um nome
    if(is_numeric($busca)){
        $sql="SELECT * FROM produto WHERE id_produto= :busca ORDER BY nome_prod ASC";
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(":busca",$busca,PDO::PARAM_INT);
    } else {
        $sql="SELECT * FROM produto WHERE nome_prod= :busca_nome ORDER BY nome_prod ASC";
        $stmt=$pdo->prepare($sql);
        $stmt->bindValue(":busca_nome","%$busca%",PDO::PARAM_STR);
    }
} else {
    $sql="SELECT * FROM produto ORDER BY nome_prod ASC";
    $stmt=$pdo->prepare($sql);
}
$stmt->execute();
$produtos=$stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Produto</title>
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
                <a href="cadastro_usuario.php">Cadastro Usuario</a>
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
                <a href="excluir_usuario.php">Excluir Usuario</a>
                <a href="excluir_cliente.php">Excluir Cliente</a>
            </div>
        </li>
    </ul>
    <ul>
        <li class="dropdown">
            <a href="javascript:void(0)" class="dropdown-menu">Buscar</a>
            <div class="dropdown-content">
                <a href="buscar_fornecedor.php">Buscar Fornecedor</a>
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
    <h2>Lista de Produtos</h2>
    <!--formulario para buscar usuarios-->
    <form action="buscar_produto.php" method="POST">
        <label for="busca">Digite o ID ou NOME(opcional):</label>
        <input type="text" id="busca" name="busca">
        <br>
        <button type="submit">PESQUISAR</button>
    </form>
    <?php if(!empty($produtos)): ?>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Quantidade</th>
                <th>Valor Unitario</th>
                <th>Ações</th>
            </tr>
            <?php foreach($produtos as $produto) :?>
                <tr>
                    <td><?=htmlspecialchars($produto['id_produto'])?></td>
                    <td><?=htmlspecialchars($produto['nome_prod'])?></td>
                    <td><?=htmlspecialchars($produto['descricao'])?></td>
                    <td><?=htmlspecialchars($produto['qtde'])?></td>
                    <td><?=htmlspecialchars($produto['valor_unit'])?></td>
                    <td><a href="alterar_usuario.php?id=<?=htmlspecialchars($produto['id_produto'])?>">Alterar</a>
                    <a href="excluir_usuario.php?id=<?=htmlspecialchars($produto['id_produto'])?>" onclick="return confirm('Tem certeza que deseja excluir este produto?')">Excluir</a></td>
                </tr>
            <? endforeach ?>
            </table>
        <?php else : ?>
            <p>Nenhum produto encontrado.</p>
        <? endif ?>
        <a href="principal.php">Voltar</a>
</body>
</html>