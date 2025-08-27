<?php
session_start();
require_once('conexao.php');
//verifica se o usuario tem permissão de adm
if($_SESSION['perfil']!=1){
    echo "<script>alert('Acesso Negado');window.location='principal.php'</script)";
    exit();
}
//inicializa as variaveis
$produto=null;
//se o formulario for enviado, busca o usuario pelo id ou pelo nome
if($_SERVER["REQUEST_METHOD"]=="POST"){
    if (!empty($_POST['busca_produto'])){
        $busca=trim($_POST['busca_produto']);
        //verifica se a busca é um numero (id) ou um nome
        if(is_numeric($busca)){
            $sql="SELECT * FROM produto WHERE id_produto= :busca ORDER BY nome ASC";
            $stmt=$pdo->prepare($sql);
            $stmt->bindParam(":busca",$busca,PDO::PARAM_INT);
        } else {
            $sql="SELECT * FROM produto WHERE nome= :busca_nome ORDER BY nome ASC";
            $stmt=$pdo->prepare($sql);
            $stmt->bindValue(":busca_nome","%$busca%",PDO::PARAM_STR);
        }
    }
    $stmt->execute();
    $produto=$stmt->fetchAll(PDO::FETCH_ASSOC);
    if(!$produto){
        echo "<script>alert('Produto não encontrado');window.location='principal.php'</script)";
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Produto</title>
    <link rel="stylesheet" href="stles.css">
    <!--certifique-se de que o javascript está sendo carregado corretamente-->
    <script src="scripts.js"></script>
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
                <a href="alterar_usuario.php">Alterar Usuario</a>
                <a href="alterar_perfil.php">Alterar Perfil</a>
                <a href="alterar_cliente.php">Alterar Cliente</a>
            </div>
        </li>
    </ul>
    <h2>Alterar Produtos</h2>
    <!--formulario para buscar produtos-->
    <form action="alterar_usuario.php" method="POST">
        <label for="busca_produto">Digite o ID ou NOME:</label>
        <input type="text" id="busca_produto" name="busca_produto" required onkeyup="buscarSugestoes()">
        <br>
        <div id="sugestoes"></div>
        <br>
        <button type="submit">Buscar</button>
    </form>
    <?php if($usuario) : ?>
        <form action="processa_alteracao_produto.php" method="POST">
            <input type="hidden" name="id_produto" value="<?=htmlspecialchars($produto['id_produto'])?>" onkeypress="mascara(this,letra)">
            <br>
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" value="<?=htmlspecialchars($produto['nome_prod'])?>">
            <br>
            <label for="descricao">Descrição:</label>
            <input type="descricao" id="descricao" name="descricao" value="<?=htmlspecialchars($produto['descricao'])?>" onkeypress="mascara(this,descricao)">
            <br>
            <label for="qtde">Quantidade:</label>
            <input type="number" id="qtde" name="qtde" value="<?=htmlspecialchars($produto['qtde'])?>">
            <br>
            <label for="valor_uni">Valor Unitario:</label>
            <input type="number" id="valor_unit" name="valor_unit" value="<?=htmlspecialchars($produto['valor_unit'])?>">
            <br>
            <button type="submit">Alterar</button>
            <button type="reset">cancelar</button>
        </form>
    <? endif ?>
</body>
</html>