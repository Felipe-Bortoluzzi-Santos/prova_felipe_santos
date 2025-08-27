<?php
session_start();
require_once('conexao.php');
if($_SESSION['perfil']!=1 or $_SESSION['perfil']!=3){
    echo "<script>alert('Acesso Negado');window.location.href='principal.php';</script>";
    exit();
}
$produtos=null;
//busca todos os usuarios cadastrados em ordem alfabetica
$sql="SELECT * FROM produto ORDER BY nome_prod ASC";
$stmt=$pdo->prepare($sql);
$stmt->execute();
$produtos=$stmt->fetchall(PDO::FETCH_ASSOC);
//se um id for passado via get. exclui o usuario
if(isset($_GET['id']) && is_numeric($_GET['id'])){
    $id_produto=$_GET['id'];
    //exclui o usuario do banco de dados
    $sql="DELETE FROM produto WHERE id_produto= :id";
    $stmt=$pdo->prepare($sql);
    $stmt->bindParam(":id",$id_produto,PDO::PARAM_INT);
    if($stmt->execute()){
        echo "<script>alert('Produto excluido com sucesso');window.location.href='excluir_produto.php';</script>";
    } else {
        echo "<script>alert('Erro ao excluir produto');window.location.href='principal.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Produto</title>
    <link rel="stylesheet" href="stles.css">
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
                <a href="excluir_usuario.php">Excluir Usuario</a>
                <a href="excluir_perfil.php">Excluir Perfil</a>
                <a href="excluir_cliente.php">Excluir Cliente</a>
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
    <h2>Excluir Produto</h2>
    <?php if(!empty($produtos)) : ?>
        <table>
            <tr>
                <th>ID:</th>
                <th>Nome:</th>
                <th>Descrição:</th>
                <th>Quantidade:</th>
                <th>Valor Unitario:</th>
                <th>Ações:</th>
            </tr>
            <?php foreach($produtos as $produto) : ?>
                <tr>
                    <td><?=htmlspecialchars($produto['id_produto']) ?></td>
                    <td><?=htmlspecialchars($produto['nome_prod']) ?></td>
                    <td><?=htmlspecialchars($produto['descricao']) ?></td>
                    <td><?=htmlspecialchars($produto['qtde']) ?></td>
                    <td><?=htmlspecialchars($produto['valor_unit']) ?></td>
                    <td><?=htmlspecialchars($produto['id_produto']) ?></td>
                    <td><a href="excluir_produto.php?id=<?=htmlspecialchars($produto['id_produto']) ?>" onclick="return confirm('Tem certeza que deseja excluir este produto?')">Excluir</a></td>
                </tr>
            <? endforeach ?>
        </table>
    <? else : ?>
        <p>Nenhum produto encontrado</p>
    <? endif ?>
    <a href="principal.php">Voltar</a>
</body>
</html>