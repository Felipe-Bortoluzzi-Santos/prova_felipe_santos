<?php
session_start();
require_once('conexao.php');
//verifica se o usuario tem permissão de adm
if($_SESSION['perfil']!=1){
    echo "<script>alert('Acesso Negado');window.location='principal.php'</script)";
    exit();
}
//inicializa as variaveis
$funcionarios=null;
//se o formulario for enviado, busca o usuario pelo id ou pelo nome
if($_SERVER["REQUEST_METHOD"]=="POST"){
    if (!empty($_POST['busca_funcionario'])){
        $busca=trim($_POST['busca_funcionario']);
        //verifica se a busca é um numero (id) ou um nome
        if(is_numeric($busca)){
            $sql="SELECT * FROM funcionario WHERE id_funcionario= :busca ORDER BY nome ASC";
            $stmt=$pdo->prepare($sql);
            $stmt->bindParam(":busca",$busca,PDO::PARAM_INT);
        } else {
            $sql="SELECT * FROM funcionario WHERE nome= :busca_nome ORDER BY nome ASC";
            $stmt=$pdo->prepare($sql);
            $stmt->bindValue(":busca_nome","%$busca%",PDO::PARAM_STR);
        }
    }
    $stmt->execute();
    $funcionarios=$stmt->fetchAll(PDO::FETCH_ASSOC);
    if(!$funcionarios){
        echo "<script>alert('funcionario não encontrado');window.location='principal.php'</script)";
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Usuario</title>
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
                <a href="cadastro_produto.php">Cadastro Funcionario</a>
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
                <a href="excluir_produto.php">Excluir Funcionario</a>
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
                <a href="alterar_perfil.php">Alterar Perfil</a>
                <a href="alterar_cliente.php">Alterar Cliente</a>
                <a href="alterar_usuario.php">Alterar Usuario</a>
            </div>
        </li>
    </ul>
    <h2>Alterar Funcionario</h2>
    <!--formulario para buscar funcionarios-->
    <form action="alterar_funcionario.php" method="POST">
        <label for="busca_funcionario">Digite o ID ou NOME:</label>
        <input type="text" id="busca_funcionario" name="busca_funcionario" required onkeyup="buscarSugestoes()">
        <br>
        <div id="sugestoes"></div>
        <br>
        <button type="submit">Buscar</button>
    </form>
    <?php if($funcionarios) : ?>
        <form action="processa_alteracao_usuario.php" method="POST">
            <input type="hidden" name="id_usuario" value="<?=htmlspecialchars($usuario['id_funcionario'])?>">
            <br>
            <label for="nome_funcionario">Nome:</label>
            <input type="text" id="nome_funcionario" name="nome_funcionario" value="<?=htmlspecialchars($usuario['nome'])?>">
            <br>
            <label for="endereco">Endereço:</label>
            <input type="text" id="endereco" name="endereco" value="<?=htmlspecialchars($usuario['endereco'])?>">
            <br>
            <label for="telefone">Telefone:</label>
            <input type="telefone" id="telefone" name="telefone" value="<?=htmlspecialchars($usuario['telefone'])?>" onkeypress="mascara(this,telefone)">
            <br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?=htmlspecialchars($usuario['email'])?>">
            <br>
            <button type="submit">Alterar</button>
            <button type="reset">cancelar</button>
        </form>
    <? endif ?>
</body>
</html>