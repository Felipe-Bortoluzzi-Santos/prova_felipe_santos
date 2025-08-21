<?php
session_start();
require_once('conexao.php');
if(!isset($_SESSION['usuario'])){
    header("Location:login.php");
    exit();
}
$id_perfil=$_SESSION['perfil'];
$sqlperfil="SELECT nome_perfil FROM perfil WHERE id_perfil=:id_perfil";
$stmtPerfil=$pdo->prepare($sqlperfil);
$stmtPerfil->bindParam(':id_perfil',$id_perfil);
$stmtPerfil->execute();
$perfil=$stmtPerfil->fetch(PDO::FETCH_ASSOC);
$nome_perfil=$perfil['nome_perfil'];
//definição das permissões por perfil
$permissoes=[
    1=>["Cadastrar"=>["cadastro_usuario.php","cadastro_perfil.php","cadastro_cliente.php","cadastro_fornecedor.php","cadastro_produto.php","cadastro_funcionario"],
    "Buscar"=>["buscar_usuario.php","buscar_perfil.php","buscar_cliente.php","buscar_fornecedor.php","buscar_produto.php","buscar_funcionario"],
    "Alterar"=>["alterar_usuario.php","alterar_perfil.php","alterar_cliente.php","alterar_fornecedor.php","alterar_produto.php","alterar_funcionario"],
    "Excluir"=>["excluir_usuario.php","excluir_perfil.php","excluir_cliente.php","excluir_fornecedor.php","excluir_produto.php","excluir_funcionario"]],
    2=>["Cadastrar"=>["cadastro_cliente.php"],
    "Buscar"=>["buscar_cliente.php","buscar_fornecedor.php","buscar_produto.php"],
    "Alterar"=>["alterar_cliente.php","alterar_fornecedor.php"]],
    3=>["Cadastrar"=>["cadastro_fornecedor.php","cadastro_produto.php"],
    "Buscar"=>["buscar_cliente.php","buscar_fornecedor.php","buscar_produto.php"],
    "Alterar"=>["alterar_fornecedor.php","alterar_produto.php"],
    "Excluir"=>["excluir_produto.php"]],
    4=>["Cadastrar"=>["cadastro_cliente.php"],
    "Buscar"=>["buscar_produto.php"],
    "Alterar"=>["alterar_cliente.php"]]
];
//obtendo as opções disponiveis para o perfil logado
$opcoes_menu=$permissoes[$id_perfil];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Principal</title>
    <link rel="stylesheet" href="stles.css">
    <script src="scripts.js"></script>
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
                <a href="cadastro_produto.php">Cadastro Produto</a>
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
                <a href="excluir_produto.php">Excluir Produto</a>
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
                <a href="buscar_produto.php">Buscar Produto</a>
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
                <a href="alterar_produto.php">Alterar Produto</a>
            </div>
        </li>
    </ul>
    <header>
        <div class="saudacao">
            <h2>Bem vindo, <?php echo $_SESSION['usuario']; ?>| Perfil: <?php echo $nome_perfil; ?></h2>
        </div>
        <div class="logout">
            <form action="logout.php" method="POST">
                <button type="submit">Logout</button>
            </form>
        </div>
    </header>
    <nav>
        <ul class="menu">
            <?php foreach($opcoes_menu as $categoria=>$arquivos): ?>
                <li class="dropdown">
                    <a href="#"><?= $categoria ?></a>
                    <ul class="dropdown-menu">
                        <?php foreach($arquivos as $arquivo): ?>
                            <li>
                                <a href="<?= $arquivo ?>"><?= ucfirst(str_replace("_"," ",basename($arquivo,".php")))?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
</body>
</html>