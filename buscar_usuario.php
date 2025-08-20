<?php
session_start();
require_once('conexao.php');
if($_SESSION['perfil']!=1 && $_SESSION['perfil']!=2){
    echo "<script>alert('Acesso Negado');window.location.href='principal.php';</script>";
    exit();
}
//inicailiza a variavel para evitar erros
$usuarios=[];
//se o formulario for enviado, busca o usuario pelo id ou nome
if($_SERVER["REQUEST_METHOD"]=="POST" && !empty($_POST['bsuca'])){
    $busca=trim($_POST['busca']);
    //verifica se a busca é um numero (id) ou um nome
    if(is_numeric($busca)){
        $sql="SELECT * FROM usuario WHERE id_usuario=:busca ORDER BY nome ASC";
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(":busca",$busca,PDO::PARAM_INT);
    } else {
        $sql="SELECT * FROM usuario WHERE nome=:busca_nome ORDER BY nome ASC";
        $stmt=$pdo->prepare($sql);
        $stmt->bindValue(":busca_nome","%$busca%",PDO::PARAM_STR);
    }
} else {
    $sql="SELECT * FROM usuario ORDER BY nome ASC";
    $stmt=$pdo->prepare($sql);
}
$stmt->execute();
$usuarios=$stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Usuario</title>
    <link rel="stylesheet" href="stles.css">
</head>
<body>
    <h2>Lista de Usuarios</h2>
    <!--formulario para buscar usuarios-->
    <form action="buscar_usuario.php" method="POST">
        <label for="busca">Digite o ID ou NOME(opcional):</label>
        <input type="text" id="busca" name="busca">
        <br>
        <button type="submit">PESQUISAR</button>
    </form>
</body>
</html>