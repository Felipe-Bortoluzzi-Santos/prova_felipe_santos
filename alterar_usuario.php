<?php
session_start();
require_once('conexao.php');
//verifica se o usuario tem permissão de adm
if($_SESSION['perfil']!=1){
    echo "<script>alert('Acesso Negado');window.location='principal.php'</script)";
    exit();
}
//inicializa as variaveis
$usuarios=null;
//se o formulario for enviado, busca o usuario pelo id ou pelo nome
if($_SERVER["REQUEST_METHOD"]=="POST"){
    if (!empty($_POST['busca_usuario'])){
        $busca=trim($_POST['busca_usuario']);
        //verifica se a busca é um numero (id) ou um nome
        if(is_numeric($busca)){
            $sql="SELECT * FROM usuario WHERE id_usuario= :busca ORDER BY nome ASC";
            $stmt=$pdo->prepare($sql);
            $stmt->bindParam(":busca",$busca,PDO::PARAM_INT);
        } else {
            $sql="SELECT * FROM usuario WHERE nome= :busca_nome ORDER BY nome ASC";
            $stmt=$pdo->prepare($sql);
            $stmt->bindValue(":busca_nome","%$busca%",PDO::PARAM_STR);
        }
    }
    $stmt->execute();
    $usuario=$stmt->fetchAll(PDO::FETCH_ASSOC);
    if(!$usuario){
        echo "<script>alert('Usuario não encont rado');window.location='principal.php'</script)";
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
</head>
<body>
    <ul>
        <li class="dropdown">
            <a href="javascript:void(0)" class="dropbtn">Cadastro</a>
            <div class="dropdown-content">
                <a href="cadastro_fornecedor.php">Cadastro Fornecedor</a>
                <a href="cadastro_produto.php">Cadastro Produto</a>
                <a href="cadastro_usuario.php">Cadastro Usuario</a>
                <a href="cadastro_perfil.php">Cadastro Perfil</a>
                <a href="cadastro_cliente.php">Cadastro Cliente</a>
                <a href="cadastro_produto.php">Cadastro Produto</a>
            </div>
        </li>
    </ul>
    <ul>
        <li class="dropdown">
            <a href="javascript:void(0)" class="dropbtn">Excluir</a>
            <div class="dropdown-content">
                <a href="excluir_fornecedor.php">Excluir Fornecedor</a>
                <a href="excluir_produto.php">Excluir Produto</a>
                <a href="excluir_perfil.php">Excluir Perfil</a>
                <a href="excluir_cliente.php">Excluir Cliente</a>
                <a href="excluir_produto.php">Excluir Produto</a>
            </div>
        </li>
    </ul>
    <ul>
        <li class="dropdown">
            <a href="javascript:void(0)" class="dropbtn">Buscar</a>
            <div class="dropdown-content">
                <a href="buscar_fornecedor.php">Buscar Fornecedor</a>
                <a href="buscar_produto.php">Buscar Produto</a>
                <a href="buscar_usuario.php">Buscar Usuario</a>
                <a href="buscar_perfil.php">Buscar Perfil</a>
                <a href="buscar_cliente.php">Buscar Cliente</a>
                <a href="buscar_produto.php">Buscar Produto</a>
            </div>
        </li>
    </ul>
    <ul>
        <li class="dropdown">
            <a href="javascript:void(0)" class="dropbtn">Alterar</a>
            <div class="dropdown-content">
                <a href="alterar_fornecedor.php">Alterar Fornecedor</a>
                <a href="alterar_produto.php">Alterar Produto</a>
                <a href="alterar_usuario.php">Alterar Usuario</a>
                <a href="alterar_perfil.php">Alterar Perfil</a>
                <a href="alterar_cliente.php">Alterar Cliente</a>
                <a href="alterar_produto.php">Alterar Produto</a>
            </div>
        </li>
    </ul>
    <h2>Alterar Usuarios</h2>
    <!--formulario para buscar usuarios-->
    <form action="alterar_usuario.php" method="POST">
        <label for="busca_usuario">Digite o ID ou NOME:</label>
        <input type="text" id="busca_usuario" name="busca_usuario" required onkeyup="buscarSugestoes()">
        <br>
        <div id="sugestoes"></div>
        <br>
        <button type="submit">Buscar</button>
    </form>
    <?php if($usuario) : ?>
        <form action="processa_alteracao_usuario.php" method="POST">
            <input type="hidden" name="id_usuario" value="<?=htmlspecialchars($usuario['id_usuario'])?>">
            <br>
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" value="<?=htmlspecialchars($usuario['nome'])?>" onkeypress="mascara(this,letra)">
            <br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?=htmlspecialchars($usuario['email'])?>">
            <br>
            <label for="id_perfil">Perfil:</label>
            <select id="id_perfil" name="id_perfil">
                <option value="1"<?=$usuario['id_perfil']==1 ? 'selected':''?>>Admnistrador</option>
                <option value="2"<?=$usuario['id_perfil']==2 ? 'selected':''?>>Secretaria</option>
                <option value="3"<?=$usuario['id_perfil']==3 ? 'selected':''?>>Almoxarife</option>
                <option value="4"<?=$usuario['id_perfil']==4 ? 'selected':''?>>Cliente</option>
            </select>
            <br>
            <!--se o usuario logado for adm, exibir opção de alterar a senha-->
            <?php if($_SESSION['perfil']===1) : ?>
                <label for="nova_senha">Nova Senha:</label>
                <input type="password" id="nova_senha" name="nova_senha" value="<?=htmlspecialchars($usuario['senha'])?>">
                <br>
            <? endif ?>
            <button type="submit">Alterar</button>
            <button type="reset">cancelar</button>
        </form>
    <? endif ?>
</body>
</html>